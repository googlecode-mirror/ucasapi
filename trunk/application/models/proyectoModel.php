<?php
class proyectoModel extends CI_Model{


	function create(){
		$this->load->database();

		$retArray = array("status"=> 0, "msg" => "");
		
		$idUsuarioEnc = $this->input->post("idUsuario");
		$idUsuarioDuenho = $this->input->post("idUsuarioDuenho");
		$nombreProyecto = $this->input->post("nombreProyecto");
		$fechaPlanIni = $this->input->post("fechaPlanIni");
		$fechaPlanFin = $this->input->post("fechaPlanFin");
		$fechaRealIni = $this->input->post("fechaRealIni");
		$fechaRealFin = $this->input->post("fechaRealFin");
		$descripcion = $this->input->post("descripcion");
		$activo = $this->input->post("activo");
		$proc_data = $this->input->post("proc_data");
		
		$data_array = explode("|",$proc_data);

		$this->db->trans_start();
		

		$sql = "INSERT INTO PROYECTO (idUsuario, idUsuarioEncargado, nombreProyecto, fechaPlanIni, fechaPlanFin, fechaRealIni, fechaRealFin, activo, descripcion)
   				VALUES (".$this->db->escape($idUsuarioDuenho).", ".$this->db->escape($idUsuarioEnc).",".$this->db->escape($nombreProyecto)."
   				, ".$this->db->escape($fechaPlanIni).", ".$this->db->escape($fechaPlanFin)."
   				, ".$this->db->escape($fechaRealIni).", ".$this->db->escape($fechaRealFin)."
   				, ".$this->db->escape($activo).", ".$this->db->escape($descripcion).")";

		$query = $this->db->query($sql);
		
		$this->db->select_max('idProyecto');
		
		$query = $this->db->get('PROYECTO');
		
		foreach ($query->result() as $row){
   			$idProyecto = $row->idProyecto;
		}
		
		$insert_statements = $this->getFPInsert($data_array, $idProyecto);
		foreach ($insert_statements as $queryRoles) {
			$this->db->query($queryRoles);
		}
		
		$this->db->trans_complete();

		if (!$query) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
	    }

		return $retArray;
	}

	function gridFasesRead($idProyecto){
		$this->load->database();

		$page = $this->input->post("page");
		$limit = $this->input->post("rows");
		$sidx = $this->input->post("sidx");
		$sord = $this->input->post("sord");
		$count = 0;
		if(!$sidx) $sidx =1;

		$sql = "SELECT COUNT(*) FROM FASE";

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

		//------------------------------------------------------------------------------------------------------

		$retArray = array("status"=> 0, "msg" => "", "data"=>array());

		$sql = 	"SELECT fxp.idFase, f.nombreFase, fxp.fechaIniPlan, fxp.fechaFinPlan
				 FROM PROYECTO p INNER JOIN FASE_PROYECTO fxp ON p.idProyecto = fxp.idProyecto
    				INNER JOIN FASE f ON fxp.idFase = f.idFase
				 WHERE fxp.idProyecto = " .$idProyecto;

		$query = $this->db->query($sql);

		$i = 0;
		if($query){
			if($query->num_rows > 0){
				foreach ($query->result() as $row){
					$response->rows[$i]["id"] = $row->idFase;
					$response->rows[$i]["cell"] = array($row->idFase, $row->nombreFase, $row->fechaIniPlan, $row->fechaFinPlan);
					$i++;
				}
			}
		}

		return $response;
	}

	function faseRead(){
		$this->load->database();

		$retArray = array("status"=> 0, "msg" => "", "data"=>array());

		$sql = "SELECT idFase, nombreFase FROM FASE WHERE activo = '1' ";
		$query = $this->db->query($sql);

		if($query){
			if($query->num_rows > 0){
				foreach ($query->result() as $row){
					$rowArray = array();
					$rowArray["id"] = $row->idFase;
					$rowArray["value"] = $row->nombreFase;
					$retArray["data"][] = $rowArray;
				}
			}
				
		}
		else{
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
		}

		return $retArray;
	}

	function readUsuariosEnc(){
	$this->load->database();

		$retArray = array("status"=> 0, "msg" => "", "data"=>array());

		$sql = "SELECT u.idUsuario, CONCAT_WS(' ',u.primerNombre, u.primerApellido) AS nombreUsuario
				FROM USUARIO u INNER JOIN ROL_USUARIO rxu ON (u.idUsuario = rxu.idUsuario AND u.activo = '1')
    				INNER JOIN ROL r ON rxu.idRol = r.idRol
				WHERE r.idRol = 2
				ORDER BY nombreUsuario";
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
			$retArray["msg"] = $this->db->_error_message();
		}
		
		return $retArray;
	}
	
	function read(){
		$this->load->database();

		$retArray = array("status"=> 0, "msg" => "", "data"=>array());

		$idProyecto = $this->input->post("idProyecto");

		$sql = "SELECT m.nombreProyecto, m.nombreUsuario, m.idUsuario, m.idUsuarioEncargado, CONCAT_WS(' ',s.primerNombre,s.primerApellido) AS nombreEnc, m.fechaPlanIni, m.fechaPlanFin, m.fechaRealIni, m.fechaRealFin, m.activo, m.descripcion
				FROM
					(SELECT p.idUsuarioEncargado,
        				u.idUsuario,
       					p.nombreProyecto, 
       					CONCAT_WS(' ',u.primerNombre,u.primerApellido) AS nombreUsuario,
       					CONCAT_WS(' ',u.primerNombre,u.primerApellido) AS nombreEnc,
       					p.fechaPlanIni,
       					p.fechaPlanFin,
       					p.fechaRealIni,
       					p.fechaRealFin,
       					p.activo,
       					p.descripcion
				FROM  PROYECTO p , USUARIO u
				WHERE p.idProyecto = " .$idProyecto. " AND p.idUsuario = u.idUsuario) m , USUARIO s
				WHERE m.idUsuarioEncargado = s.idUsuario";

		$query = $this->db->query($sql);

		if($query) {
			$row = $query->row_array();
			$retArray["data"] = $row;
		}
		else{
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();

		}

		return $retArray;
	}

	// ------------------------------------------------------------------------

	function faseProyectoRead(){
		$this->load->database();

		$retArray = array("status"=> 0, "msg" => "", "data"=>array());

		$idProyecto = $this->input->post("idProyecto");

		$sql = "select fase, max(countFase) from
					(
					select
						f.nombreFase fase,
						e.estado estado,
						count(f.nombreFase) countFase
					from PROYECTO p
					INNER JOIN ACTIVIDAD_PROYECTO ap ON (ap.idProyecto = p.idProyecto)
					inner join ACTIVIDAD a ON (a.idActividad = ap.idActividad)
					INNER JOIN ESTADO e ON (e.idEstado = a.idEstado)
					inner join FASE f on (f.idFase = a.idFase)
					where p.idProyecto = ? AND a.idEstado = 1
					group by f.nombreFase, e.estado
					) FASES_ACTIVIDAD;";

		$query = $this->db->query($sql, array($idProyecto));

		if($query) {
			$row = $query->row_array();
			$retArray["data"] = $row;
		}
		else{
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();

		}

		return $retArray;
	}

	// Metodo para obtner la lista de proyectos de un determinado usuario
	function gridProyectosUsuario($idUsuario) {
		$this->load->database();

		$page = $this->input->post("page");
		$limit = $this->input->post("rows");
		$sidx = $this->input->post("sidx");
		$sord = $this->input->post("sord");
		$count = 0;
		if(!$sidx) $sidx =1;

		// $idDepto = is_null($idDepto) ? -1 : $idDepto;


		$sql = "select
					count(*)
				from PROYECTO p WHERE p.idUsuario = ?";
		$query = $this->db->query($sql, array($idUsuario));

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

		$sql = "select
					p.idProyecto idProyecto, p.nombreProyecto nombre
				from PROYECTO p WHERE p.idUsuario = ?";
		$query = $this->db->query($sql, array($idUsuario));

		$i = 0;
		if($query){
			if($query->num_rows > 0){
				foreach ($query->result() as $row){
					$response->rows[$i]["id"] = $row->idProyecto;
					$response->rows[$i]["cell"] = array($row->nombre);
					$i++;
				}
			}
		}

		return $response;

	}

	// ------------------------------------------------------------------------

	function update(){
		$this->load->database();

		$retArray = array("status"=> 0, "msg" => "");

		$idProyecto = $this->input->post("idProyecto");
	
		$idUsuarioDuenho = $this->input->post("idUsuarioDuenho");
		$idUsuarioEnc = $this->input->post("idUsuario");
		$nombreProyecto = $this->input->post("nombreProyecto");
		$fechaPlanIni = $this->input->post("fechaPlanIni");
		$fechaPlanFin = $this->input->post("fechaPlanFin");
		$fechaRealIni = $this->input->post("fechaRealIni");
		$fechaRealFin = $this->input->post("fechaRealFin");
		$descripcion = $this->input->post("descripcion");
		$activo = $this->input->post("activo");
		$proc_data = $this->input->post("proc_data");
		
		$data_array = explode("|",$proc_data);

		$this->db->trans_begin();
		$sql = "DELETE FROM FASE_PROYECTO WHERE idProyecto = " .$idProyecto;

		$this->db->query($sql); 
		
		$insert_statements = $this->getFPInsert($data_array, $idProyecto);
		foreach ($insert_statements as $queryRoles) {
			$this->db->query($queryRoles);
		}
		
		$sql = "UPDATE PROYECTO
				SET idUsuario = ".$this->db->escape($idUsuarioDuenho).",
					idUsuarioEncargado = ".$this->db->escape($idUsuarioEnc).",
					nombreProyecto = ".$this->db->escape($nombreProyecto).",
					fechaPlanIni = ".$this->db->escape($fechaPlanIni).",
					fechaPlanFin = ".$this->db->escape($fechaPlanFin).",
					fechaRealIni = ".$this->db->escape($fechaRealIni).",
					fechaRealFin = ".$this->db->escape($fechaRealFin).",
					activo = ".$this->db->escape($activo).",
					descripcion = ".$this->db->escape($descripcion)."
					WHERE idProyecto = ". $idProyecto;
		
		$query = $this->db->query($sql);

		if (!$query) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
	    }
		if($this->db->trans_status() == FALSE) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}

		return $retArray;
	}
	
	function getFPInsert($data_array, $idProyecto){
		$counter = 1;
		$nombreFase;
		$idFase;
		$fechaIniPlan;
		$fechaFinPlan;
		$index = 0;
		$indexTrippin = 0;
		$trippin;

		foreach ($data_array as $value) {
			$this->load->database();
			if($counter == 1){ //Estoy en nombreFase, preparo borrando las fases antiguas
				$nombreFase = $value;
			
				$sql = "SELECT idFase FROM FASE WHERE nombreFase = '" .$nombreFase. "'";
			
				$query = $this->db->query($sql);
				foreach ($query->result() as $row){
					$idFase = $row->idFase;
				}
				$counter++;
				continue;
			}
			if($counter == 2){ //Estoy en fechaIniPlan
				$fechaIniPlan = $value;
				$counter++;
				continue;
			}
			if($counter == 3){ //Estoy en fechaFinPlan
				$fechaFinPlan = $value;
				$counter = 1;
				$trippin[$indexTrippin++] = "INSERT INTO FASE_PROYECTO (idFase,idProyecto,fechaIniPlan,fechaFinPlan) VALUES(" .$idFase. "," .$idProyecto. ",'" .$fechaIniPlan."','" .$fechaFinPlan. "')";
				continue;
			}
		}

		return  $trippin;
	}


	function delete(){
		$this->load->database();

		$retArray = array("status"=> 0, "msg" => "");

		$idProyecto = $this->input->post("idProyecto");
		$this->db->trans_begin();
		
		$sql = "UPDATE PROYECTO
				SET activo = '0'
				WHERE idProyecto = ". $idProyecto;
		$this->db->query($sql);
		
		$sql = "DELETE FROM FASE_PROYECTO WHERE idProyecto = " .$idProyecto;

		$query = $this->db->query($sql);

		if (!$query) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
	    }
		if($this->db->trans_status() == FALSE) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}

		return $retArray;
	}


	function autocompleteRead($idUsuario,$idRol){
		$this->load->database();

		$retArray = array("status"=> 0, "msg" => "", "data"=>array());

		if($idRol == 1){
			$sql = "SELECT p.nombreProyecto, p.idProyecto
				FROM PROYECTO p WHERE activo = '1'";					
		}
		else{
		
			$sql = "SELECT p.nombreProyecto, p.idProyecto
				FROM PROYECTO p
				WHERE p.idUsuarioEncargado = " .$idUsuario. " AND p.activo = '1'";
		}
		$query = $this->db->query($sql);

		if($query){
			if($query->num_rows > 0){
				foreach ($query->result() as $row){
					$rowArray = array();
					$rowArray["id"] = $row->idProyecto;
					$rowArray["value"] = $row->nombreProyecto;
					$retArray["data"][] = $rowArray;
				}
			}

		}
		else{
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
		}

		return $retArray;
	}

	// Buscar usuarios
	function autocompleteUsuarioProyectoRead(){
		$this->load->database();

		$retArray = array("status"=> 0, "msg" => "", "data"=>array());

		$sql = "SELECT idUsuario, CONCAT(primerNombre,' ', OtrosNombres,' ',primerApellido,' ',otrosApellidos) nombreUsuario FROM USUARIO WHERE activo = '1'";
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
			$retArray["msg"] = $this->db->_error_message();
		}

		return $retArray;
	}


	//Devuelve en la variable $msg, los mensajes para los errores detectados por no cumplir las validaciones aplicadas usando la librer�a form_validation
	function saveValidation(){
		$this->load->library('form_validation');

		$retArray = array("status"=> 0, "msg" => "");

		//Colocando las reglas para los campos, el segundo par�metro es el nombre del campo que aparecer� en el mensaje
		//Habr� que reemplazar los mensajes, pues por el momento est�n en ingl�s
		$this->form_validation->set_rules("nombreProyecto", "Nombre proyecto", 'required');
		$this->form_validation->set_rules("idUsuarioDuenho", "Dueno del proyecto", 'required');

		if ($this->form_validation->run() == false){//Si al menos una de las reglas no se cumpli�...
			//Concatenamos en $msg los mensajes de errores generados para cada campo, lo tenga o no
			$retArray["status"] = 1;

			$retArray["msg"] .= form_error("nombreProyecto");
			$retArray["msg"] .= form_error("idUsuarioDuenho");
		}

		return $retArray;
	}


	/*-------------------------- FUNCIONES PARA ARCHIVOS -------------------------------*/
	//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	//Validaci�n para campos de informaci�n de documento
	function fileSaveValidation(){
		$this->load->library('form_validation');
		$retArray = array("status"=> 0, "msg" => "");
		$this->form_validation->set_rules("descripcion", "Descripcion", 'alpha ');

		if ($this->form_validation->run() == false){
			$retArray["status"] = 1;
			$retArray["msg"] .= form_error("descripcion");
		}
		return $retArray;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		
	function createProjectFile(){
		$this->load->database();
		$retArray = array("status"=> 0, "msg" => "");
		
		$idProyecto = $this->input->post("idProyecto");
		$idTipoArchivo = $this->input->post("idTipoArchivo");
		$nombreArchivo = $this->input->post("nombreArchivo");
		$tituloArchivo = $this->input->post("tituloArchivo");
		$descripcion = $this->input->post("descripcion");
		
		$sql = "INSERT INTO ARCHIVOS (idProyecto, nombreArchivo, tituloArchivo, descripcion, idTipoArchivo, fechaSubida)
    			VALUES (".$this->db->escape($idProyecto).", ".
						$this->db->escape($nombreArchivo).", ".
						$this->db->escape($tituloArchivo).", ".
						$this->db->escape($descripcion).", ".
						$this->db->escape($idTipoArchivo).
						",DATE(NOW()))";
		
		$query = $this->db->query($sql);
		
		if (!$query){
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
		}

		return $retArray;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function updateProjectFile(){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "");
		$idArchivo = $this->input->post("idArchivo");
		$idActividad   = $this->input->post("idActividad");
		$idTipoArchivo = $this->input->post("idTipoArchivo");
		$nombreArchivo = $this->input->post("nombreArchivo");
		$tituloArchivo = $this->input->post("tituloArchivo");
		$descripcion = $this->input->post("descripcion");
		
		if($idTipoArchivo=="")$idTipoArchivo=null;
		
		$sql = "UPDATE ARCHIVOS
				SET descripcion = ".$this->db->escape($descripcion).
				" , tituloArchivo = ".$this->db->escape($tituloArchivo).
				" , idTipoArchivo = ".$this->db->escape($idTipoArchivo).
				" WHERE idArchivo = ". $idArchivo; 
		
		$query = $this->db->query($sql);
		
		if (!$query) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
		}
		
		return $retArray;
	}
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	function fileDataDelete(){
		$this->load->database();
		$retArray = array("status"=> 0, "msg" => "");
		$idArchivo = $this->input->post("idArchivo");
		$sql = "DELETE FROM ARCHIVOS
			WHERE idArchivo = ". $idArchivo;

		$query = $this->db->query($sql);
		if (!$query) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
		}
		return $retArray;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	function projectFilesRead($idProyecto=null){
		$this->load->database();
		
		$this->load->helper(array('url'));
		
		$page = $this->input->post("page");
		$limit = $this->input->post("rows");
		$sidx = $this->input->post("sidx");
		$sord = $this->input->post("sord");
		$count = 0;
		if(!$sidx) $sidx =1;
		
		$idActividad = is_null($idActividad) ? -1 : $idActividad;
		
		$sql = "SELECT COUNT(*) AS count FROM ARCHIVOS a LEFT JOIN TIPO_ARCHIVO ta ON ta.idTipoArchivo = a.idTipoArchivo ".
			   "WHERE idProyecto = ".$this->db->escape($idProyecto);
		
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
		$sql = "SELECT a.idArchivo, a.tituloArchivo ,a.nombreArchivo, a.descripcion, a.fechaSubida, ta.nombreTipo, ta.idTipoArchivo ".
				"FROM ARCHIVOS a LEFT JOIN TIPO_ARCHIVO ta on ta.idTipoArchivo = a.idTipoArchivo ".
				"WHERE idProyecto = ".$this->db->escape($idProyecto);
		
		$response->sql = $sql;
		
		$query = $this->db->query($sql);		
		$i = 0;
		
		if($query){
			if($query->num_rows > 0){
				foreach ($query->result() as $row){
					$response->rows[$i]["id"] = $i+1;
					$response->rows[$i]["cell"] = array($row->idArchivo,$row->nombreTipo,$row->tituloArchivo, $row->nombreArchivo, $row->fechaSubida, $row->descripcion, $row->idTipoArchivo );
					$i++;
				}
			}
		}
		return $response;
	}


}