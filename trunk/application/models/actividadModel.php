<?php

class actividadModel extends CI_Model{
	
	function readEstados(){
		$this->load->database();
		
		$retArray = array();
		
		$sql = "SELECT idEstado, estado FROM ESTADO WHERE idTipoEstado = 1 AND activo = '1' ";
		
		$query = $this->db->query($sql);
		
		if($query->num_rows > 0){			
			foreach ($query->result() as $row){		
				$rowArray = array();
				$rowArray["idEstado"] = $row->idEstado;
				$rowArray["estado"] = $row->estado;
				$retArray["data"][] = $rowArray;				
			}							
		}
		
		return $retArray;
	}
	
	function read(){
		$this->load->database();
		
		$retArray = array("status" => 0, "msg" => "");
		
		$idActividad = $this->input->post("idActividad");
		$idProyecto = $this->input->post("idProyecto");
		$idUsuario = $this->input->post("idUsuario");
		
		$sql = "SELECT DISTINCT CONCAT(u.primerNombre, ' ', u.primerApellido) nombreAsigna, p.nombreProyecto, a.nombreActividad, a.descripcionActividad, 
					e.idEstado, b.progreso, b.comentario
				FROM PROYECTO p INNER JOIN ACTIVIDAD_PROYECTO axp ON p.idProyecto = axp.idProyecto 
					INNER JOIN ACTIVIDAD a ON axp.idActividad = a.idActividad 
					INNER JOIN ESTADO e ON a.idEstado = e.idEstado 
					INNER JOIN BITACORA b ON a.idActividad = b.idActividad 
					INNER JOIN USUARIO_ACTIVIDAD uxa ON a.idActividad = uxa.idActividad
    			 	INNER JOIN USUARIO u ON uxa.idUsuarioAsigna = u.idUsuario
				WHERE b.ultimoRegistro = (SELECT MAX(ultimoRegistro) FROM BITACORA WHERE idActividad = ".$idActividad.") 
					AND a.idActividad = " .$idActividad. " AND p.idProyecto = " .$idProyecto." AND uxa.idUsuario = ".$idUsuario;
		
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
	
	function update(){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "");
		
		$idEstado = $this->input->post("idEstado");
		$idUsuario = $this->input->post("idUsuario");
		$idActividad = $this->input->post("idActividad");
		$progreso = $this->input->post("progreso");
		$asignar = $this->input->post("asignarBand");
		$desasignar = $this->input->post("desasignarBand");
		$comentario = $this->input->post("comentario");
		$user_rows = $this->input->post("user_data");
		$remove_ids = $this->input->post("remove_data");
		$add_ids = $this->input->post("add_data");
		
		//Manejando la transaccion
		$this->db->trans_start();
		
		//Iniciando el texto de notificacion
		$sql = "SELECT nombreActividad
				FROM ACTIVIDAD
				WHERE idActividad = " .$idActividad;
		
		$query = $this->db->query($sql);
		$row = $query->row();
		
		$cadAsignaciones = "";		
		$cadAsignaciones .= "<b>Actividad: '" .$row->nombreActividad."'</b><br />";
		
		if($desasignar == 1){
			$cadAsignaciones .= "Los siguientes usuarios fueron desasignados de la actividad: <br />";
		}
		//Actualizando el estado de la actividad
		$sql = "UPDATE ACTIVIDAD SET idEstado = ".$idEstado." WHERE idActividad = ".$idActividad;
		$query = $this->db->query($sql);
		
		//Desasignando a los usuarios de la actividad
		$id_array = explode(",",$remove_ids);
		if($id_array[0] != 0){
			$cadNotificacion = "Se le ha desasignado la actividad: <b>'" .$row->nombreActividad."'</b>";
			$sql = "INSERT INTO NOTIFICACION(notificacion,subject,fechaNotificacion) VALUES(".$this->db->escape($cadNotificacion).",'Actividad desasignada',CURDATE())";
			$this->db->query($sql);
			
			//Obteniendo el ultimo ID
			$sql = "SELECT LAST_INSERT_ID() lastId FROM NOTIFICACION";
			$query = $this->db->query($sql);
			$row = $query->row();
			$idNotificacion = $row->lastId;
			
			foreach ($id_array as $element){
				$sql = "UPDATE USUARIO_ACTIVIDAD SET activo = '0', fechaDesvinculacion = CURDATE() WHERE idActividad = ".$idActividad. " AND idUsuario = ".$element;
				$this->db->query($sql);
				
				$sql = "INSERT INTO USUARIO_NOTIFICACION(idUsuario,idNotificacion,idEstado,horaEntrada) VALUES(".$element.",".$idNotificacion.",18,CURTIME())";
				$this->db->query($sql);
				
				if($desasignar == 1){ //Es por que hay personas que se van a desasignar
					//	Creando String de notificacion
					$sql = "SELECT CONCAT_WS(' ',primerNombre, primerApellido) AS nombre
							FROM USUARIO
							WHERE idUsuario = " .$element;
				
					$query = $this->db->query($sql);
					$row = $query->row();
					$cadAsignaciones .= "- '" .$row->nombre. "'<br />";
				}
				 
			}
		}
		$id = explode(",",$add_ids);
		if($asignar == 1){
			$cadAsignaciones .= "Los siguientes usuarios fueron asignados a la actividad: <br />";
			foreach ($id as $item){
				$sql = "SELECT CONCAT_WS(' ',primerNombre, primerApellido) AS nombre
						FROM USUARIO
						WHERE idUsuario = " .$item;
			
				$query = $this->db->query($sql);
				$row = $query->row();
				$cadAsignaciones .= "- '" .$row->nombre. "'<br />";
			}
		}
		
		//Asignando a los usuarios a la actividad
		$statements = new actividadModel();
		$data_array = explode("|",$user_rows);
		
		$insert_statements = $statements->execUAInsert($data_array, $idUsuario);
		foreach ($insert_statements as $sql) {
			$this->db->query($sql);
		}
		
		//Actualizando la informacion de la actividad
		$sql = "CALL sp_insert_bitacora(".$idActividad.",".$idUsuario.",".$progreso.",".$this->db->escape($comentario).",1,1,".$idEstado.")";
		$query = $this->db->query($sql);
		
		//Insertando la notificacion a los seguidores
		if($asignar == 1 || $desasignar == 1){
			$sql = "INSERT INTO NOTIFICACION(notificacion,subject,fechaNotificacion) VALUES(".$this->db->escape($cadAsignaciones).",'Asignaciones ocurridas en actividad',CURDATE())";
			$this->db->query($sql);
		}
		
		//Obteniendo el ultimo ID
		$sql = "SELECT LAST_INSERT_ID() lastId FROM NOTIFICACION";
		$query = $this->db->query($sql);
		$row = $query->row();
		$idNotificacion = $row->lastId;
		
		$sql = "SELECT DISTINCT uxa.idUsuario
				FROM USUARIO_ACTIVIDAD uxa INNER JOIN TIPO_ASOCIACION ta ON uxa.idTipoAsociacion = ta.idTipoAsociacion
				WHERE uxa.idActividad = ".$idActividad." AND uxa.idTipoAsociacion = 2";
		$query = $this->db->query($sql);
		
		foreach ($query->result() as $row){
			$sql = "INSERT INTO USUARIO_NOTIFICACION(idUsuario,idNotificacion,idEstado,horaEntrada) VALUES(".$row->idUsuario.",".$idNotificacion.",18,CURTIME())"; 	
			$this->db->query($sql);		
		}
		
		$this->db->trans_complete();
		
		return $retArray;
	}
	
	function execUAInsert($data_array, $idUsuarioAsigna){
		$idActividad = $this->input->post("idActividad");
		$idNotificacion;
		$idUsuarioInsert;
		$indexTrippin = 0;
		$trippin;
		
		
		$this->load->database();
		$this->db->trans_start();
		
		//Obteniendo el nombre de la actividad
		$sql = "SELECT nombreActividad
				FROM ACTIVIDAD
				WHERE idActividad = " .$idActividad;
		$query = $this->db->query($sql);
		$row = $query->row();
		$cadNotificacion = "Se le ha asignado la actividad <b>'" .$row->nombreActividad. "'</b>";
		
		//Insertando la notificacion de actividad asignada al usuario
		$sql = "INSERT INTO NOTIFICACION(notificacion,subject,fechaNotificacion) VALUES(".$this->db->escape($cadNotificacion).",'Actividad asignada',CURDATE())";
		$this->db->query($sql);
		
		$sql = "SELECT LAST_INSERT_ID() lastId FROM NOTIFICACION";
		$query = $this->db->query($sql);
		$row = $query->row();
		$idNotificacion = $row->lastId;

		foreach ($data_array as $value) {
			$idUsuarioInsert = $value;
			if($value == null){
				return $trippin;
			}
			$trippin[$indexTrippin++] = "CALL sp_insert_ua(".$idUsuarioInsert.",".$idActividad.",".$idUsuarioAsigna.")";
			
			//Insertando la notificacion al usuario
			$sql = "INSERT INTO USUARIO_NOTIFICACION(idUsuario,idNotificacion,idEstado,horaEntrada) VALUES(".$idUsuarioInsert.",".$idNotificacion.",18,CURTIME())";
			$this->db->query($sql);	

		}
		
		$this->db->trans_complete();

		return  $trippin;
	}
	
	function saveValidation(){
		$this->load->library('form_validation');
		
		$retArray = array("status"=> 0, "msg" => "");
		
		//Colocando las reglas para los campos, el segundo par�metro es el nombre del campo que aparecer� en el mensaje
		//Habr� que reemplazar los mensajes, pues por el momento est�n en ingl�s
		$this->form_validation->set_rules("comentario", "Comentario", 'alpha');

		if ($this->form_validation->run() == false){//Si al menos una de las reglas no se cumpli�...
			//Concatenamos en $msg los mensajes de errores generados para cada campo, lo tenga o no
			$retArray["status"] = 1;
			$retArray["msg"] .= form_error("comentario");			
		}
		
		return $retArray;
	}
	
	function readUsuarios($idActividad){
		$this->load->database();
		
		$page = $this->input->post("page");
		$limit = $this->input->post("rows");
		$sidx = $this->input->post("sidx");
		$sord = $this->input->post("sord");
		$count = 0;
		if(!$sidx) $sidx =1;
		
		$sql = "SELECT COUNT(*) AS count  FROM ROL r INNER JOIN ROL_USUARIO rxu ON r.idRol = rxu.idRol INNER JOIN USUARIO u
    				ON rxu.idUsuario = u.idUsuario
    				WHERE r.idRol = 1 OR r.idRol = 2 OR r.idRol = 3 OR r.idRol = 4 OR r.idRol = 5";
		
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
		
		//-------------------------------------------------------------------
		
		
		$retArray = array("status" => 0, "msg" => "");
		
		$sql = "SELECT DISTINCT u.idUsuario, u.codEmp, CONCAT(u.primerNombre,' ', u.primerApellido,' ') nombre
				FROM ROL r INNER JOIN ROL_USUARIO rxu ON r.idRol = rxu.idRol INNER JOIN USUARIO u
        			ON rxu.idUsuario = u.idUsuario
        		WHERE (r.idRol = 1 OR r.idRol = 2 OR r.idRol = 3 OR r.idRol = 4 OR r.idRol = 5)
            		AND u.idUsuario NOT IN (SELECT u.idUsuario FROM USUARIO u INNER JOIN USUARIO_ACTIVIDAD uxa
                ON u.idUsuario = uxa.idUsuario WHERE uxa.idActividad = " . $idActividad ." AND uxa.activo = '1')";
		
		
		$query = $this->db->query($sql);

		$i = 0;
		if($query){
			if($query->num_rows > 0){
				foreach ($query->result() as $row){
					/*$response->rows[$i]["idUsuario"] = $row->idUsuario;
					$response->rows[$i]["codEmp"] = $row->codEmp;
					$response->rows[$i]["nombre"] = $row->nombre;
					$response->rows[$i]["nombreRol"] = $row->nombreRol;*/
					$response->rows[$i]["id"] = $row->idUsuario;
					$response->rows[$i]["cell"] = array($row->idUsuario, $row->codEmp, $row->nombre);
					$i++;
				}
			}
		}

		return $response;
		
	}
	
	function gridUsuarioSet($idActividad){
		$this->load->database();
		
		$page = $this->input->post("page");
		$limit = $this->input->post("rows");
		$sidx = $this->input->post("sidx");
		$sord = $this->input->post("sord");
		$count = 0;
		if(!$sidx) $sidx =1;
		
		$sql = "SELECT COUNT(*) AS count  FROM ROL r INNER JOIN ROL_USUARIO rxu ON r.idRol = rxu.idRol INNER JOIN USUARIO u
    				ON rxu.idUsuario = u.idUsuario
    				WHERE u.activo = '1' AND (r.idRol = 1 OR r.idRol = 2 OR r.idRol = 3 OR r.idRol = 4 OR r.idRol = 5)";
		
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
		
		//------------------------------------------------------------
		
		$sql = "SELECT DISTINCT u.idUsuario, u.codEmp, CONCAT(u.primerNombre,' ', u.primerApellido,' ') nombre
    			FROM ROL r INNER JOIN ROL_USUARIO rxu ON r.idRol = rxu.idRol INNER JOIN USUARIO u
    				ON rxu.idUsuario = u.idUsuario INNER JOIN USUARIO_ACTIVIDAD uxa
    				ON u.idUsuario = uxa.idUsuario
    			WHERE uxa.idActividad = " .$idActividad. " AND uxa.activo = '1'
    				AND (r.idRol = 1 OR r.idRol = 2 OR r.idRol = 3 OR r.idRol = 4 OR r.idRol = 5)";
		
		$query = $this->db->query($sql);

		$i = 0;
		if($query){
			if($query->num_rows > 0){
				foreach ($query->result() as $row){
					/*$response->rows[$i]["idUsuario"] = $row->idUsuario;
					$response->rows[$i]["codEmp"] = $row->codEmp;
					$response->rows[$i]["nombre"] = $row->nombre;
					$response->rows[$i]["nombreRol"] = $row->nombreRol;*/
					$response->rows[$i]["id"] = $row->idUsuario;
					$response->rows[$i]["cell"] = array($row->idUsuario, $row->codEmp, $row->nombre, $row->nombreRol);
					$i++;
				}
			}
		}

		return $response;
		
	}
	
}
