<?php
class actividadaModel extends CI_Model{
	
	
	function create(){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "");
		
		$nombreActividad = $this->input->post("nombreActividad");	
		$fechaInicioPlan = $this->input->post("fechaInicioPlan");
		$fechaFinalizacionPlan = $this->input->post("fechaFinalizacionPlan");
		$descripcionActividad = $this->input->post("descripcion");
		
		$anioSolicitud = ($this->input->post("anioSolicitud")!="")?$this->input->post("anioSolicitud"):null;
		$correlAnio = ($this->input->post("correlAnio")!="")?$this->input->post("correlAnio"):null;
		
		$idProyecto = $this->input->post("idProyecto");
		$idPrioridad = $this->input->post("idPrioridad");
		$idProceso = ($this->input->post("idProceso")!="")?$this->input->post("idProceso"):null;
		$idEstado = $this->input->post("idEstado");
		
		$idUsuarioResponsable = $this->input->post("idUsuarioResponsable");
		$idUsuarioAsigna = $this->input->post("idUsuarioAsigna");
		
		$seguidores = $this->input->post("seguidores");
		
		//Si no se está en sesión
		$idUsuarioAsigna = 1;
		$idUsuarioResponsable = 1;
		
		$lastId  = -1;
				
		//Iniciando transacción
		$this->db->trans_begin();
		
		
		//Insertando en ACTIVIDAD
		$sql = "INSERT INTO ACTIVIDAD (nombreActividad, fechaInicioPlan, fechaFinalizacionPlan, descripcionActividad, activo, anioSolicitud, correlAnio, idPrioridad, idProceso, idEstado)".
				"VALUES (".$this->db->escape($nombreActividad).", ".$this->db->escape($fechaInicioPlan).",".$this->db->escape($fechaFinalizacionPlan).",".$this->db->escape($descripcionActividad).",'NULL',".
						  $this->db->escape($anioSolicitud).",".$this->db->escape($correlAnio).",".$this->db->escape($idPrioridad).",".$this->db->escape($idProceso).",".
						  $this->db->escape($idEstado).")";
						 
		
		$query = $this->db->query($sql);		
		if (!$query){
	     	$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $sql;
	    }
	    
		$sql = "SELECT LAST_INSERT_ID() lastId FROM ACTIVIDAD";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0){
				$row = $query->row();
				$lastId = $row->lastId;
			}
	    
	    
		//Insertando en PROYECTO
		$sql = "INSERT INTO ACTIVIDAD_PROYECTO (idProyecto, idActividad) VALUES (".$this->db->escape($idProyecto).",".$this->db->escape($lastId).")";
		
		$query = $this->db->query($sql);		
		if (!$query){
	     	$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $sql;
	    }
	    
	    
		//Insertando los datos en USUARIO_ACTIVIDAD del usuario responsable de la actividad
	    $sql = "INSERT INTO USUARIO_ACTIVIDAD(idUsuario, correlVinculacion, idActividad, fechaVinculacion, fechaDesvinculacion, activo, idTipoAsociacion, idUsuarioAsigna)".
	    		"VALUES(".
	    				$this->db->escape($idUsuarioResponsable).
	    				",(SELECT COALESCE((SELECT MAX(ua.correlVinculacion) + 1 correlVinculacion FROM USUARIO_ACTIVIDAD ua WHERE ua.idUsuario =".$this->db->escape($idUsuarioResponsable)." AND ua.idActividad=".$this->db->escape($lastId)." ), 1)),".
	    				  $this->db->escape($lastId).",".
	    				  "DATE(NOW()),NULL,1,1,".
	    				$this->db->escape($idUsuarioAsigna).")";
                		
		$query = $this->db->query($sql);
		
		
		//Insertando los datos en USUARIO_ACTIVIDAD de los seguidores
		if($seguidores != ""){
			$data_array = explode("|",$seguidores);
			$insert_statements = $this->getFollowersInsert($data_array, $lastId);
			foreach ($insert_statements as $queryFollowers) {
				$this->db->query($queryFollowers);
			}
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
	
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	function read(){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "");
		
		$idActividad = $this->input->post("idActividad");		
		
		$sql = "SELECT a.nombreActividad, a.fechaInicioPlan, a.fechaFinalizacionPlan, a.descripcionActividad, ".
						"a.activo,prio.idPrioridad,prio.nombrePrioridad,e.idEstado,e.estado, a.idFase, proc.idProceso, ".
						"proc.nombreProceso, proy.idProyecto, proy.nombreProyecto,u.idUsuario, ".
						"CONCAT( u.primerNombre,' ',u.primerApellido) AS nombreUsuario".
		
				" FROM ACTIVIDAD a INNER JOIN ACTIVIDAD_PROYECTO ap ON ap.idActividad = a.idActividad".
								" INNER JOIN PROYECTO proy ON  proy.idProyecto = ap.idProyecto".
								" LEFT JOIN PROCESO proc ON proc.idProceso = a.idProceso".
								" LEFT JOIN PRIORIDAD prio ON prio.idPrioridad = a.idPrioridad".
								" LEFT JOIN ESTADO e ON e.idEstado = a.idEstado".
								" LEFT JOIN USUARIO_ACTIVIDAD ua ON ua.idActividad = a.idActividad AND ua.idTipoAsociacion = 1".
								" INNER JOIN USUARIO u ON u.idUsuario = ua.idUsuario".
				
				" WHERE a.idActividad =".$this->db->escape($idActividad);
		
		$query = $this->db->query($sql);
		
		if($query) {
			$row = $query->row_array();
	    	$retArray["data"] = $row;	     	
	    }
	    else{
	    	$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
			 return $retArray;	    
	    }
	    
	    $sql = "";
	    
	    return $retArray;
	}

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	

	function update(){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "");
		
		$nombreActividad = $this->input->post("nombreActividad");	
		$fechaInicioPlan = $this->input->post("fechaInicioPlan");
		$fechaFinalizacionPlan = $this->input->post("fechaFinalizacionPlan");
		$descripcionActividad = $this->input->post("descripcion");
		
		$anioSolicitud = ($this->input->post("anioSolicitud")!="")?$this->input->post("anioSolicitud"):null;
		$correlAnio = ($this->input->post("correlAnio")!="")?$this->input->post("correlAnio"):null;
		
		$idActividad = $this->input->post("idActividad");
		$idProyecto = $this->input->post("idProyecto");
		$idPrioridad = $this->input->post("idPrioridad");
		$idProceso = ($this->input->post("idProceso")!="")?$this->input->post("idProceso"):null;
		$idEstado = $this->input->post("idEstado");
		
		$idUsuarioResponsable = $this->input->post("idUsuarioResponsable");
		$idUsuarioAsigna = $this->input->post("idUsuarioAsigna");
		
		$seguidores = $this->input->post("seguidores");
		
		//Si no se está en sesión
		$idUsuarioAsigna = 1;
		//$idUsuarioResponsable = 1;
		
		$lastId  = -1;
				
		//Iniciando transacción
		$this->db->trans_begin();
		
		
		//Actualizando en ACTIVIDAD
		$sql = "UPDATE ACTIVIDAD ". 
				"SET nombreActividad = ".$this->db->escape($nombreActividad).
					 ",fechaInicioPlan = ".$this->db->escape($fechaInicioPlan).
					 ", fechaFinalizacionPlan = ".$this->db->escape($fechaFinalizacionPlan). 
					 ", descripcionActividad = ".$this->db->escape($descripcionActividad).
					 ", activo = ".$this->db->escape($descripcionActividad).
					 ", anioSolicitud = ".$this->db->escape($anioSolicitud).
					 ", correlAnio = ".$this->db->escape($correlAnio).
					 ", idPrioridad = ".$this->db->escape($idPrioridad).
					 ", idProceso = ".$this->db->escape($idProceso).
					 ", idEstado =". $this->db->escape($idEstado).
				" WHERE idActividad = ".$this->db->escape($idActividad);						 
		
		$query = $this->db->query($sql);		
		if (!$query){
	     	$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $sql;
	    }
	    
	    
		//Actualizando en ACTIVIDAD_PROYECTO
		$sql = "UPDATE ACTIVIDAD_PROYECTO SET idProyecto =".$this->db->escape($idProyecto)." WHERE idActividad = ".$this->db->escape($idActividad);
		
		$query = $this->db->query($sql);		
		if (!$query){
	     	$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $sql;
	    }
	    
	    	    
	    //Eliminado en USUARIO_ACTIVIDAD
		$sql = "DELETE FROM USUARIO_ACTIVIDAD WHERE idActividad = ".$this->db->escape($idActividad);
                		
		$query = $this->db->query($sql);		
		if (!$query){
	     	$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $sql;
	    }

		//Insertando los datos en USUARIO_ACTIVIDAD del usuario responsable de la actividad
	    $sql = "INSERT INTO USUARIO_ACTIVIDAD(idUsuario, correlVinculacion, idActividad, fechaVinculacion, fechaDesvinculacion, activo, idTipoAsociacion, idUsuarioAsigna)".
	    		"VALUES(".
	    				$this->db->escape($idUsuarioResponsable).
	    				",(SELECT COALESCE((SELECT MAX(ua.correlVinculacion) + 1 correlVinculacion FROM USUARIO_ACTIVIDAD ua WHERE ua.idUsuario =".$this->db->escape($idUsuarioResponsable)." AND ua.idActividad=".$this->db->escape($idActividad)." ), 1)),".
	    				  $this->db->escape($idActividad).",".
	    				  "DATE(NOW()),NULL,1,1,".
	    				$this->db->escape($idUsuarioAsigna).")";
                		
		$query = $this->db->query($sql);		
		if (!$query){
	     	$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $sql;
	    }
	    
		
		//Insertando los datos en USUARIO_ACTIVIDAD de los seguidores
		if($seguidores != ""){
			$data_array = explode("|",$seguidores);
			$insert_statements = $this->getFollowersInsert($data_array, $idActividad);
			foreach ($insert_statements as $queryFollowers) {
				$this->db->query($queryFollowers);
				$retArray["msg"] = $queryFollowers;
			}
		}
	
		if($this->db->trans_status() == FALSE) {
			$retArray["status"] = $this->db->_error_number();
			//$retArray["msg"] = $this->db->_error_message();
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}	    
	    
		return $retArray;		
	}
	
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	

	function delete(){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "");
		
		$idEstado = $this->input->post("idEstado");
		
		$sql = "DELETE FROM ESTADO
				WHERE idEstado = ". $idEstado;
   				
		$query = $this->db->query($sql);
		
		if (!$query) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
	    }
		
		return $retArray;	
	}
	
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	function readGrid($idProceso){
		$this->load->database();
		
		$page = $this->input->post("page");
		$limit = $this->input->post("rows");
		$sidx = $this->input->post("sidx");
		$sord = $this->input->post("sord");
		$count = 0;
		if(!$sidx) $sidx =1;
		
		$sql = "SELECT COUNT(*) FROM Fase";
		
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
		
		//------------------------------------------
		
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());	
		
		$sql = 	"SELECT p.idProceso, f.nombreFase, fxp.fechaIniPlan, fxp.fechaFinPlan, fxp.fechaIniReal, fxp.fechaFinReal " .
			   	"FROM FASE f INNER JOIN FASE_PROCESO fxp ON f.idFase = fxp.idFase INNER JOIN PROCESO p " . 
				"ON fxp.idProceso = p.idProceso WHERE p.idProceso = ".$idProceso;
		
		$query = $this->db->query($sql);

		$i = 0;
		if($query){
			if($query->num_rows > 0){
				foreach ($query->result() as $row){
					$response->rows[$i]["id"] = $row->idProceso;
					$response->rows[$i]["nombreFase"] = $row->nombreFase;
					$response->rows[$i]["fechaIniPlan"] = $row->fechaIniPlan;
					$response->rows[$i]["fechaFinPlan"] = $row->fechaFinPlan;
					$response->rows[$i]["fechaIniReal"] = $row->fechaIniReal;
					$response->rows[$i]["fechaFinReal"] = $row->fechaFinReal;
					$response->rows[$i]["cell"] = array($row->nombreFase, $row->fechaIniPlan, $row->fechaFinPlan, $row->fechaIniReal, $row->fechaFinReal);
					$i++;
				}
			}
		}

		return $response;
	}
	
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	
	function processAutocompleteRead($idProyecto=null){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
				
		$sql = "SELECT p.nombreProceso, p.idProceso 
				FROM PROCESO p INNER JOIN PROYECTO pr ON p.idProyecto = pr.idProyecto";
		
		$sql.=($idProyecto!=null)?"	 WHERE p.idProyecto = " .$this->db->escape($idProyecto):"";
		
		$query = $this->db->query($sql);		
	
		if($query){
			if($query->num_rows > 0){			
				foreach ($query->result() as $row){		
					$rowArray = array();
					$rowArray["id"] = $row->idProceso;
					$rowArray["value"] = $row->nombreProceso;
										
					$retArray["data"][] = $rowArray;				
				}							
			}
		}
		else{
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
			$retArray["msg"] = $sql;
		}		
		return $retArray;
	}
	
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------	
	
	function activityAutocompleteRead($idProyecto, $idProceso){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
				
		$sql = "SELECT a.idActividad, a.nombreActividad 
				FROM ACTIVIDAD a INNER JOIN ACTIVIDAD_PROYECTO ap ON a.idActividad = ap.idActividad
				WHERE ap.idProyecto =". $this->db->escape($idProyecto);
		
		$sql.=($idProceso!='')?"	 AND a.idProceso = " .$this->db->escape($idProceso):"";
		
		$query = $this->db->query($sql);		
	
		if($query){
			if($query->num_rows > 0){			
				foreach ($query->result() as $row){		
					$rowArray = array();
					$rowArray["id"] = $row->idActividad;
					$rowArray["value"] = $row->nombreActividad;
										
					$retArray["data"][] = $rowArray;				
				}							
			}
		}
		else{
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
			$retArray["msg"] = $sql;
		}		
		return $retArray;
	}
	
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	function priorityAutocompleteRead(){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
				
		$sql = "SELECT idPrioridad, nombrePrioridad FROM PRIORIDAD";
		
		$query = $this->db->query($sql);		
	
		if($query){
			if($query->num_rows > 0){			
				foreach ($query->result() as $row){		
					$rowArray = array();
					$rowArray["id"] = $row->idPrioridad;
					$rowArray["value"] = $row->nombrePrioridad;
										
					$retArray["data"][] = $rowArray;				
				}							
			}
		}
		else{
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
			$retArray["msg"] = $sql;
		}		
		return $retArray;
	}
	
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	function statusAutocompleteRead(){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
				
		$sql = "SELECT idEstado, estado FROM ESTADO WHERE idTipoEstado = 2";
		
		$query = $this->db->query($sql);		
	
		if($query){
			if($query->num_rows > 0){			
				foreach ($query->result() as $row){		
					$rowArray = array();
					$rowArray["id"] = $row->idEstado;
					$rowArray["value"] = $row->estado;
										
					$retArray["data"][] = $rowArray;				
				}							
			}
		}
		else{
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
			$retArray["msg"] = $sql;
		}		
		return $retArray;
	}
	
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	//Devuelve en la variable $msg, los mensajes para los errores detectados por no cumplir las validaciones aplicadas usando la librería form_validation
	function saveValidation(){
		$this->load->library('form_validation');
		
		$retArray = array("status"=> 0, "msg" => "");
		
		//Colocando las reglas para los campos, el segundo parámetro es el nombre del campo que aparecerá en el mensaje
		//Habrá que reemplazar los mensajes, pues por el momento están en inglés
		$this->form_validation->set_rules("nombreActividad", "Nombre", 'required');
		$this->form_validation->set_rules("descripcion", "Descripcion", 'alpha|required');
		$this->form_validation->set_rules("idProyecto", "Proyecto", 'required');

		if ($this->form_validation->run() == false){//Si al menos una de las reglas no se cumplió...
			//Concatenamos en $msg los mensajes de errores generados para cada campo, lo tenga o no
			$retArray["status"] = 1;
			$retArray["msg"] .= form_error("idProyecto");
			$retArray["msg"] .= form_error("nombreActividad");
			$retArray["msg"] .= form_error("descripcion");			
		}
		
		return $retArray;
	}
	
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	function estadoAutocomplete($idTipo){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
		
		$sql = "select e.idEstado, e.estado
				from ESTADO e INNER JOIN TIPO_ESTADO tp ON e.idTipoEstado = tp.idTipoEstado
				WHERE e.idTipoEstado = " .$idTipo;
		
		$query = $this->db->query($sql);		
	
		if($query){
			if($query->num_rows > 0){			
				foreach ($query->result() as $row){		
					$rowArray = array();
					$rowArray["id"] = $row->idEstado;
					$rowArray["value"] = $row->estado;
										
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
	
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function gridUsuariosRead($idActividad){
		$this->load->database();		
		
		$page = $this->input->post("page");
		$limit = $this->input->post("rows");
		$sidx = $this->input->post("sidx");
		$sord = $this->input->post("sord");
		$count = 0;		
		if(!$sidx) $sidx =1;
		
		$sql = "SELECT COUNT(*) as count FROM USUARIO u INNER JOIN DEPARTAMENTO d ON u.idDepto = d.idDepto ".
				"WHERE u.idUsuario NOT IN (SELECT idUsuario FROM USUARIO_ACTIVIDAD WHERE idTipoAsociacion = 2 AND idActividad = ".$this->db->escape($idActividad).")";
		
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
		
		$sql = "SELECT u.idUsuario, CONCAT(u.primerNombre, u.primerApellido) as nombreUsuario, d.nombreDepto ".
				"FROM USUARIO u INNER JOIN DEPARTAMENTO d ON u.idDepto = d.idDepto ".
				"WHERE u.idUsuario NOT IN (SELECT idUsuario FROM USUARIO_ACTIVIDAD WHERE idTipoAsociacion = 2 AND idActividad = ".$this->db->escape($idActividad).")";
		
		$query = $this->db->query($sql);		
	
		$i = 0;
		if($query){
			if($query->num_rows > 0){							
				foreach ($query->result() as $row){		
					$response->rows[$i]["id"] = $row->idUsuario;
					$response->rows[$i]["cell"] = array($row->idUsuario, $row->nombreUsuario, $row->nombreDepto);
					$i++;				
				}										
			}			
		}
		
		return $response;
	}
	
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function gridSeguidoresRead($idActividad){
		$this->load->database();		
		
		$page = $this->input->post("page");
		$limit = $this->input->post("rows");
		$sidx = $this->input->post("sidx");
		$sord = $this->input->post("sord");
		$count = 0;		
		if(!$sidx) $sidx =1;
		
		$sql = "SELECT COUNT(*) as count ".
				"FROM USUARIO_ACTIVIDAD ua INNER JOIN USUARIO u ON u.idUsuario = ua.idUsuario LEFT JOIN DEPARTAMENTO d ON d.idDepto = u.idDepto ".
				"WHERE  ua.idTipoAsociacion = 2 AND idActividad = ".$this->db->escape($idActividad);
	
		
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
		
		$sql = "SELECT u.idUsuario, CONCAT(u.primerNombre, u.primerApellido) as nombreUsuario, d.nombreDepto ".
				"FROM USUARIO_ACTIVIDAD ua INNER JOIN USUARIO u ON u.idUsuario = ua.idUsuario LEFT JOIN DEPARTAMENTO d ON d.idDepto = u.idDepto ".
				"WHERE  ua.idTipoAsociacion = 2 AND idActividad = ".$this->db->escape($idActividad).
				" GROUP BY u.idUsuario, nombreUsuario, d.nombreDepto";
		
		$query = $this->db->query($sql);		
	
		$i = 0;
		if($query){
			if($query->num_rows > 0){							
				foreach ($query->result() as $row){		
					$response->rows[$i]["id"] = $row->idUsuario;
					$response->rows[$i]["cell"] = array($row->idUsuario, $row->nombreUsuario, $row->nombreDepto);
					$i++;				
				}										
			}			
		}
		
		return $response;
	}
	
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	function getFollowersInsert($data_array,$idActividad){
		$counter = 1;
		$idUsuario;
		$idUsuarioInsert;
		$fechaAsignacionSistema;
		$index = 0;
		$indexTrippin = 0;
		$trippin;

		foreach ($data_array as $value) {
			if($counter == 1){
				$idUsuario = $value;
				$counter++;
				continue;
			}
			if($counter == 2){
				//$idUsuarioInsert = $idUsuario;
				$counter++;
				continue;
			}
			if($counter == 3){
				$fechaAsignacionSistema = $value;
				$counter = 1;
				//if($fechaAsignacionSistema == "null"){
					//$trippin[$indexTrippin++] = "INSERT INTO ROL_USUARIO (idRol, idUsuario, fechaAsigancionSistema) VALUES (".$idRolInsert.",".$idUsuarioInsert.",CURRENT_TIMESTAMP)";
				//}else{
					$trippin[$indexTrippin++] = "INSERT INTO USUARIO_ACTIVIDAD(idUsuario, correlVinculacion, idActividad, fechaVinculacion, fechaDesvinculacion, activo, idTipoAsociacion, idUsuarioAsigna)".
    												"VALUES(".
															$this->db->escape($idUsuario).
															",(SELECT COALESCE((SELECT MAX(ua.correlVinculacion) + 1 correlVinculacion FROM USUARIO_ACTIVIDAD ua WHERE ua.idUsuario =".$this->db->escape("1")." AND ua.idActividad=".$this->db->escape($idActividad)." ), 1)),".
															  $this->db->escape($idActividad).",".
															  "DATE(NOW()),NULL,1,2,".
														    	$this->db->escape('1').")";
				//}

				continue;
			}
		}

		return  $trippin;
	}

}
