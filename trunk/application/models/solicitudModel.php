<?php

class solicitudModel extends CI_Model {

	function saveValidation(){
		$this->load->library('form_validation');

		$retArray = array("status"=> 0, "msg" => "");

		//Colocando las reglas para los campos, el segundo par�metro es el nombre del campo que aparecer� en el mensaje
		//Habr� que reemplazar los mensajes, pues por el momento est�n en ingl�s
		$this->form_validation->set_rules("asunto", "Asunto", 'required');
		$this->form_validation->set_rules("descripcion", "Descripcion", 'required');

		if ($this->form_validation->run() == false){//Si al menos una de las reglas no se cumpli�...
			//Concatenamos en $msg los mensajes de errores generados para cada campo, lo tenga o no
			$retArray["status"] = 1;

			$retArray["msg"] .= form_error("asunto");
			$retArray["msg"] .= form_error("descripcion");
		}

		return $retArray;
	}

	function create() {
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());

		$this->load->database();
		//Verificando correcta conexi�n a la base de datos
		if (!$this->db->conn_id) {
			$retArray["status"] = 2;
			$retArray["msg"] = database_cn_error_msg();
			return $retArray;
		}
		$this->load->library('session');

		$asunto = $this->input->post("asunto");
		$prioridad = $this->input->post("prioridad");
		$descripcion = $this->input->post("descripcion");
		$fechaFinEsperada = ($this->input->post("fechaFinEsperada")=='')? '0000-00-00 00:00:00' : $this->input->post("fechaFinEsperada");
		$editSolicitud = ($this->input->post("edit")!='')? explode("-", $this->input->post("edit")) : NULL;
		$anioSolicitud = strftime('%Y');
		$correlAnio = 1;

		// ---------------------------------------------------------------------

		if($editSolicitud != NULL) {
			$sqlUpdate = "UPDATE SOLICITUD SET
							tituloSolicitud = ?,
							descripcionSolicitud = ?,
							fechaSalida = ?,
							idPrioridadCliente = ?
						WHERE anioSolicitud = ? and correlAnio = ?";

			$this->db->trans_begin();

			$this->db->query($sqlUpdate, array($asunto, $descripcion, $fechaFinEsperada, $prioridad, $editSolicitud[0], $editSolicitud[1]));

			$sqlDeleteSeguidores = "DELETE FROM USUARIO_SOLICITUD WHERE anioSolicitud = ? and correlAnio = ?";
			$this->db->query($sqlDeleteSeguidores, array($editSolicitud[0], $editSolicitud[1]));

			$idInteresados = explode(',', $this->input->post("observadores"));

			$sql2 = "INSERT INTO USUARIO_SOLICITUD (idUsuario, anioSolicitud, correlAnio, esAutor) VALUES (" .
						$this->db->escape($this->session->userdata("idUsuario")) . ", " .
						$this->db->escape(intval($editSolicitud[0])) . ", " .
						$this->db->escape(intval($editSolicitud[1])) . "," .
						$this->db->escape(1) . ")";

			foreach ($idInteresados as $idUser){
				if($idUser != '') {
				$sql2 .= ",(" . $this->db->escape($idUser) . ", " .
						$this->db->escape(intval($editSolicitud[0])) . ", " .
						$this->db->escape(intval($editSolicitud[1])) . "," .
						$this->db->escape(0) . ")";
				}
			}

			$this->db->query($sql2);

			if($this->db->trans_status() == FALSE) {
		     	$retArray["status"] = $this->db->_error_number();
				$retArray["msg"] = (database_error_msg()!="")?database_error_msg():$this->db->_error_message();
				$this->db->trans_rollback();
		    } else {
		    	$this->db->trans_commit();
		    }


		} else {

			$queryId = "SELECT MAX(s.anioSolicitud) maxAnio FROM SOLICITUD s";
			$result = $this->db->query($queryId);

			if(!$result){
				$retArray["status"] = $this->db->_error_number();
				$retArray["msg"] = (database_error_msg()!="")?database_error_msg():$this->db->_error_message();
			}

			if($result->num_rows() > 0) {
				$maxAnio = 0;

				$row = $result->row();
				$maxAnio = $row->maxAnio;

				if (intval($anioSolicitud) == $maxAnio) {

					$queryId = "SELECT MAX(s.correlAnio) + 1 correlAnio FROM SOLICITUD s " .
								"WHERE s.anioSolicitud = " . $this->db->escape(intval($anioSolicitud));
					$result2 = $this->db->query($queryId);
					if($result2->num_rows() > 0) {
						$row = $result2->row();
						$correlAnio = $row->correlAnio;
					}
				}
			}

			$idInteresados = explode(',', $this->input->post("observadores"));


			$sql = "INSERT INTO SOLICITUD (anioSolicitud, correlAnio, tituloSolicitud, descripcionSolicitud, fechaSalida, activo, idPrioridadCliente, idPrioridadInterna)
	   				VALUES (" .
							$this->db->escape(intval($anioSolicitud)) . ", " .
							$this->db->escape($correlAnio).", ".
							$this->db->escape($asunto) . ", " .
							$this->db->escape($descripcion) . ", " .
							$this->db->escape($fechaFinEsperada) . ", " .
							$this->db->escape(1) . ", " .
							$this->db->escape(intval($prioridad)) . ", " .
							$this->db->escape(intval($prioridad)) . ")";

			$sql2 = "INSERT INTO USUARIO_SOLICITUD (idUsuario, anioSolicitud, correlAnio, esAutor) VALUES (" .
						$this->db->escape($this->session->userdata("idUsuario")) . ", " .
						$this->db->escape(intval($anioSolicitud)) . ", " .
						$this->db->escape($correlAnio) . "," .
						$this->db->escape(1) . ")";

			foreach ($idInteresados as $idUser){
				if($idUser != '') {
				$sql2 .= ",(" . $this->db->escape($idUser) . ", " .
						$this->db->escape($anioSolicitud) . ", " .
						$this->db->escape($correlAnio) . "," .
						$this->db->escape(0) . ")";
				}
			}


			$this->db->trans_begin();
			//$query = $this->db->query($sql);
			$query = $this->db->query($sql);
			if(!$query){
				$retArray["status"] = $this->db->_error_number();
				$retArray["msg"] = (database_error_msg()!="")?database_error_msg():$this->db->_error_message();
				return $retArray;
			}
			$query = $this->db->query($sql2);
			if(!$query){
				$retArray["status"] = $this->db->_error_number();
				$retArray["msg"] = (database_error_msg()!="")?database_error_msg():$this->db->_error_message();
				return $retArray;
			}

			//if (!$query){
			if($this->db->trans_status() == FALSE) {
		     	$retArray["status"] = $this->db->_error_number();
				$retArray["msg"] = (database_error_msg()!="")?database_error_msg():$this->db->_error_message();
				$this->db->trans_rollback();
		    } else {
		    	$this->db->trans_commit();
		    }
		}

		return $retArray;
	}

	function getSolicitud ($idPeticion=NULL) {
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());

		$this->load->database();
		//Verificando correcta conexi�n a la base de datos
		if (!$this->db->conn_id) {
			$retArray["status"] = 2;
			$retArray["msg"] = database_cn_error_msg();
			return $retArray;
		}

		//array con la clave de la solicitud -> anioSolicitud-correlAnio
		$solicitudIds = is_null($idPeticion)? explode("-", $this->input->post("idSolicitud")) : explode("-", $idPeticion);

		$query = "SELECT
						s.tituloSolicitud titulo, s.descripcionSolicitud descripcion, s.fechaEntrada fechaEntrada, s.fechaSalida fechaSalida, s.idPrioridadCliente prioridad,
						p.nombrePrioridad prioridadCliente,	CONCAT_WS(' ', u.primerNombre, u.otrosNombres, u.primerApellido, u.otrosApellidos) cliente, us.idUsuario idCliente,
						c.nombreCargo cargo, d.nombreDepto depto
					FROM SOLICITUD s
					INNER JOIN USUARIO_SOLICITUD us ON (s.anioSolicitud = us.anioSolicitud AND s.correlAnio = us.correlAnio)
					INNER JOIN USUARIO u ON (u.idUsuario = us.idUsuario)
					INNER JOIN CARGO c ON (u.idCargo = c.idCargo)
					INNER JOIN DEPARTAMENTO d ON (u.idDepto = d.idDepto)
					INNER JOIN PRIORIDAD p ON (p.idPrioridad = s.idPrioridadCliente)
					WHERE s.anioSolicitud = ? AND s.correlAnio = ?

					ORDER BY esAutor DESC";
		/*AND CONCAT_WS('-', s.anioSolicitud, s.correlAnio) NOT IN (
						SELECT CONCAT_WS('-', a.anioSolicitud, a.correlAnio)
						FROM ACTIVIDAD a
						WHERE a.anioSolicitud = ? AND a.correlAnio = ?)*/

		$result = $this->db->query($query, array($solicitudIds[0], $solicitudIds[1], $solicitudIds[0], $solicitudIds[1]));

		$solicitudes = array();

		if ($result) {
			if($result->num_rows() > 0) {
				foreach ($result->result() as $row) {

					$retArray["data"][] = $row;

				}
			}
		} else{
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = (database_error_msg()!="")?database_error_msg():$this->db->_error_message();
		}

		return $retArray;

	}

	function getSolicitudCliente ($idPeticion=NULL) {
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());

		$this->load->database();
		//Verificando correcta conexi�n a la base de datos
		if (!$this->db->conn_id) {
			$retArray["status"] = 2;
			$retArray["msg"] = database_cn_error_msg();
			return $retArray;
		}

		//array con la clave de la solicitud -> anioSolicitud-correlAnio
		$solicitudIds = is_null($idPeticion)? explode("-", $this->input->post("idSolicitud")) : explode("-", $idPeticion);

		$query = "SELECT
					s.tituloSolicitud titulo,
					s.fechaEntrada fechaIngreso,
					date_format(s.fechaSalida, '%Y-%m-%d') fechaFinEsperada,
					CONCAT_WS(' ', u.primerNombre, u.otrosNombres, u.primerApellido, u.otrosApellidos) cliente,
					s.descripcionSolicitud descripcion,
					a.fechaInicioPlan fechaAtencion,
					date_format(s.fechaRealConclusion, '%Y-%m-%d') fechaSalida,
					P.progreso progreso
				FROM SOLICITUD s
				LEFT JOIN ACTIVIDAD a ON (a.anioSolicitud = s.anioSolicitud AND a.correlAnio = s.correlAnio)
				LEFT JOIN BITACORA b ON (b.idActividad = a.idActividad)
				INNER JOIN USUARIO_SOLICITUD us ON (us.anioSolicitud = s.anioSolicitud AND us.correlAnio = s.correlAnio)
				INNER JOIN USUARIO u ON (u.idUsuario = us.idUsuario)
				INNER JOIN (select TRUNCATE(AVG(progreso), 0) progreso from BITACORA where idActividad in (select idActividad from ACTIVIDAD where anioSolicitud = ? and correlAnio = ?)) P
				WHERE s.anioSolicitud = ? AND s.correlAnio = ? AND esAutor = 1
				GROUP BY s.tituloSolicitud, s.fechaEntrada, s.descripcionSolicitud, a.fechaInicioPlan";

		$result = $this->db->query($query, array($solicitudIds[0], $solicitudIds[1], $solicitudIds[0], $solicitudIds[1]));

		$solicitudes = array();

		if ($result) {
			if($result->num_rows() > 0) {
				foreach ($result->result() as $row) {
					$retArray["data"][] = $row;

				}
			} else {
				$retArray["status"] = 2;
				$retArray["msg"] = "Esta solicitud a&uacute;n no ha sido asignada.";
			}
		} else{
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = (database_error_msg()!="")?database_error_msg():$this->db->_error_message();
		}

		return $retArray;

	}

	function gridSolicitudRead($id=null){
		$this->load->database();

		$page = $this->input->post("page");
		$limit = $this->input->post("rows");
		$sidx = $this->input->post("sidx");
		$sord = $this->input->post("sord");
		$count = 0;
		if(!$sidx) $sidx =1;

		// $idDepto = is_null($idDepto) ? -1 : $idDepto;


		$sql = "SELECT COUNT(*) AS count " .
				"FROM USUARIO u " .
				"INNER JOIN USUARIO_SOLICITUD us ON u.idUsuario = us.idUsuario " .
				"INNER JOIN SOLICITUD s ON (s.anioSolicitud = us.anioSolicitud AND s.correlAnio = us.correlAnio)";
		$query = $this->db->query($sql);

		if ($query->num_rows() > 0){
			$row = $query->row();
			$count  = $row->count;
		}

		if( $count >0 ){
			$total_pages = ceil($count/$limit);
		}
		else{
			$total_pages = 0;
		}

		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;

		$response->page = $page;
		$response->total = $total_pages;
		$response->records = $count;

		//-------------------------

		$sql = "SELECT s.anioSolicitud anio, s.correlAnio correl, s.tituloSolicitud titulo, CONCAT(u.primerNombre, ' ', u.primerApellido) usuarioSolicitante, s.fechaEntrada fechaPeticion
				FROM USUARIO u
				INNER JOIN USUARIO_SOLICITUD us ON u.idUsuario = us.idUsuario
				INNER JOIN SOLICITUD s ON (s.anioSolicitud = us.anioSolicitud AND s.correlAnio = us.correlAnio)
				WHERE us.esAutor=1 AND s.activo=1
				AND CONCAT_WS('-', s.anioSolicitud, s.correlAnio) NOT IN (
										SELECT CONCAT_WS('-', a.anioSolicitud, a.correlAnio)
										FROM ACTIVIDAD a
										WHERE a.anioSolicitud IS NOT NULL AND a.correlAnio IS NOT NULL);";
		$query = $this->db->query($sql);

		$i = 0;
		if($query){
			if($query->num_rows > 0){
				foreach ($query->result() as $row){
					$response->rows[$i]["id"] = $row->anio . "-" . $row->correl;
					$response->rows[$i]["cell"] = array($row->fechaPeticion, $row->titulo, $row->usuarioSolicitante);
					$i++;
				}
			}
		}

		return $response;
	}

	function gridAllSolicitudRead($id=null){
		$this->load->database();

		$page = $this->input->post("page");
		$limit = $this->input->post("rows");
		$sidx = $this->input->post("sidx");
		$sord = $this->input->post("sord");
		$count = 0;
		if(!$sidx) $sidx =1;

		// $idDepto = is_null($idDepto) ? -1 : $idDepto;


		$sql = "SELECT COUNT(*) AS count " .
				"FROM USUARIO u " .
				"INNER JOIN USUARIO_SOLICITUD us ON u.idUsuario = us.idUsuario " .
				"INNER JOIN SOLICITUD s ON (s.anioSolicitud = us.anioSolicitud AND s.correlAnio = us.correlAnio)";
		$query = $this->db->query($sql);

		if ($query->num_rows() > 0){
			$row = $query->row();
			$count  = $row->count;
		}

		if( $count >0 ){
			$total_pages = ceil($count/$limit);
		}
		else{
			$total_pages = 0;
		}

		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;

		$response->page = $page;
		$response->total = $total_pages;
		$response->records = $count;

		//-------------------------

		$sql = "SELECT s.anioSolicitud anio, s.correlAnio correl, s.tituloSolicitud titulo, CONCAT(u.primerNombre, ' ', u.primerApellido) usuarioSolicitante, s.fechaEntrada fechaPeticion
				FROM USUARIO u
				INNER JOIN USUARIO_SOLICITUD us ON u.idUsuario = us.idUsuario
				INNER JOIN SOLICITUD s ON (s.anioSolicitud = us.anioSolicitud AND s.correlAnio = us.correlAnio)
				WHERE us.esAutor=1";
		$query = $this->db->query($sql);

		$i = 0;
		if($query){
			if($query->num_rows > 0){
				foreach ($query->result() as $row){
					$response->rows[$i]["id"] = $row->anio . "-" . $row->correl;
					$response->rows[$i]["cell"] = array($row->fechaPeticion, $row->titulo, $row->usuarioSolicitante);
					$i++;
				}
			}
		}

		return $response;
	}

	function misSolicitudes($esAutor) {
		$this->load->database();
		$this->load->library('session');
		$idUsuario = $this->session->userdata("idUsuario");

		$page = $this->input->post("page");
		$limit = $this->input->post("rows");
		$sidx = $this->input->post("sidx");
		$sord = $this->input->post("sord");
		$count = 0;
		if(!$sidx) $sidx =1;

		// $idDepto = is_null($idDepto) ? -1 : $idDepto;


		$sql = "SELECT COUNT(*) " .
				"FROM SOLICITUD s " .
				"INNER JOIN USUARIO_SOLICITUD us ON (s.anioSolicitud = us.anioSolicitud AND s.correlAnio = us.correlAnio) " .
				"WHERE us.idUsuario = ? AND us.esAutor = ?";
		$query = $this->db->query($sql, array($idUsuario, $esAutor));

		if ($query->num_rows() > 0){
			$row = $query->row();
			$count  = $row->count;
		}

		if( $count >0 ){
			$total_pages = ceil($count/$limit);
		}
		else{
			$total_pages = 0;
		}

		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;

		$response->page = $page;
		$response->total = $total_pages;
		$response->records = $count;

		//-------------------------

		$sql = "SELECT " .
					"s.anioSolicitud anio, s.correlAnio correl, s.tituloSolicitud titulo, s.fechaEntrada fechaEntrada " .
				"FROM SOLICITUD s " .
				"INNER JOIN USUARIO_SOLICITUD us ON (s.anioSolicitud = us.anioSolicitud AND s.correlAnio = us.correlAnio) " .
				"WHERE us.idUsuario = ? AND us.esAutor = ?";

		$query = $this->db->query($sql, array($idUsuario, $esAutor));

		$i = 0;
		if($query){
			if($query->num_rows > 0){
				foreach ($query->result() as $row){
					$response->rows[$i]["id"] = $row->anio . "-" . $row->correl;
					$response->rows[$i]["cell"] = array($row->fechaEntrada, $row->titulo);
					$i++;
				}
			}
		}

		return $response;

	}

	// *********************************************************************
	// METODOS TEMPORALES
	function getPrioridades() {
		$this->load->database();
		$retArray = array("status"=> 0, "msg" => "", "data"=>"");

		$query = "SELECT * FROM PRIORIDAD WHERE activo = '1' ";
		$result = $this->db->query($query);

		if ($result) {
			if ($result->num_rows() > 0) {
				$options = '<option value="0">Seleccione prioridad</option>';
				foreach ($result->result() as $row) {
					$options .= '<option value="' . $row->idPrioridad . '">' . $row->nombrePrioridad . '</option>';
				}
				$retArray["data"] = $options;
			}
		} else {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = (database_error_msg()!="")?database_error_msg():$this->db->_error_message();
		}

		return $retArray;
	}

	function empleadoAutocomplete() {
		$this->load->database();

		$retArray = array("status"=> 0, "msg" => "", "data"=>array());

		$sql = "SELECT u.idUsuario, CONCAT_WS(' ', u.primerNombre, u.otrosNombres, u.primerApellido, u.otrosApellidos) nombreUsuario
				FROM USUARIO u
				WHERE u.idusuario IN (SELECT DISTINCT uh.idUsuario FROM USUARIO_HISTORICO uh)";
		$query = $this->db->query($sql);

		if($query){
			if($query->num_rows > 0){
				foreach ($query->result() as $row){
					$rowArray = array();
					$rowArray["id"] = $row->idUsuario;
					$rowArray["value"] = $row->nombreUsuario;

					$retArray["data"][] = $rowArray;
				}
			}
		}
		else{
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = (database_error_msg()!="")?database_error_msg():$this->db->_error_message();
		}

		return $retArray;
	}

	function transferirSolicitud() {
		$this->load->helper(array('url'));
		$this->load->database();
		$this->load->library('session');

		$retArray = array("status"=> 0, "msg" => "");

		$idDestinatario = $this->input->post("idDestinatario");
		$idSolicitud = $this->input->post("idSolicitud");
		$anioCorrelSolicitud = explode("-", $idSolicitud);

		$sql = "INSERT INTO NOTIFICACION (notificacion, subject, fechaNotificacion)
				VALUES ('Una solicitud le ha sido transferida. Puede verla <a href=\"" . base_url() . "solicitud/getSolicitud/" . $idSolicitud . "\">aqui</a>',
				'Transferencia de solicitud', CURRENT_DATE)";

		$sql2 = "INSERT INTO USUARIO_NOTIFICACION (idUsuario, idNotificacion, idEstado) VALUES (?, LAST_INSERT_ID(), 2)";

		$sql3 = "UPDATE SOLICITUD SET activo=0 WHERE anioSolicitud = ? AND correlAnio = ?";

		$this->db->trans_begin();
		$this->db->query($sql);
		$this->db->query($sql2, array($idDestinatario));
		$this->db->query($sql3, array($anioCorrelSolicitud[0], $anioCorrelSolicitud[1]));

		if($this->db->trans_status() == FALSE) {
	     	$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = (database_error_msg()!="")?database_error_msg():$this->db->_error_message();
			$this->db->trans_rollback();
	    } else {
	    	$this->db->trans_commit();
	    }

		return $retArray;
	}
}