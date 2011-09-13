<?php
class actividadaModel extends CI_Model{
	
	
	function create(){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "");
		
		$nombreActividad = $this->input->post("nombreActividad");	
		$fechaInicioPlan = $this->input->post("fechaInicioPlan");
		$fechaFinalizacionPlan = $this->input->post("fechaFinalizacionPlan");
		$descripcionActividad = $this->input->post("descripcion");
		$nombreProyecto = $this->input->post("nombreProyecto");
		
		$anioSolicitud = ($this->input->post("anioSolicitud")!="")?$this->input->post("anioSolicitud"):null;
		$correlAnio = ($this->input->post("correlAnio")!="")?$this->input->post("correlAnio"):null;
		$idProyecto = $this->input->post("idProyecto");
		$idPrioridad = $this->input->post("idPrioridad");
		$idProceso = ($this->input->post("idProceso")!="")?$this->input->post("idProceso"):null;
		$idEstado = $this->input->post("idEstado");
		
		//$idUsuarioResponsable = $this->input->post("idUsuarioResponsable");
		$idUsuarioAsigna = $this->input->post("idUsuarioAsigna");
		
		$seguidores = $this->input->post("seguidoresI");
		$responsables = $this->input->post("responsablesI");
		$proyectosRelacionados = $this->input->post("proyRelacionados");
		
		
		//Si no se est� en sesi�n
		if ($idUsuarioAsigna == "")$idUsuarioAsigna=1;
		
		$lastId  = -1;
				
		//Iniciando transacci�n
		$this->db->trans_begin();
		
		
		//Insertando en ACTIVIDAD
		$sql = "INSERT INTO ACTIVIDAD (nombreActividad, fechaInicioPlan, fechaFinalizacionPlan, descripcionActividad, anioSolicitud, correlAnio, idPrioridad, idProceso,activo, idEstado)".
				"VALUES (".$this->db->escape($nombreActividad).", ".$this->db->escape($fechaInicioPlan).",".$this->db->escape($fechaFinalizacionPlan).",".$this->db->escape($descripcionActividad).",".
						  $this->db->escape($anioSolicitud).",".$this->db->escape($correlAnio).",".$this->db->escape($idPrioridad).",".$this->db->escape($idProceso).", 1, ".
						  $this->db->escape($idEstado).")";
						 
		
		$query = $this->db->query($sql);		
		if (!$query){
	     	$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
			return $retArray;
			die();
	    }
		
		
	    
		$sql = "SELECT LAST_INSERT_ID() lastId FROM ACTIVIDAD";
		$query = $this->db->query($sql);
		if (!$query){
	     	$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
			return $retArray;
			die();
	    }
		if ($query->num_rows() > 0){
			$row = $query->row();
			$lastId = $row->lastId;
		}
		
		
			
		$sqlInsert = "CALL sp_insert_bitacora(".$this->db->escape($lastId).",".$idUsuarioAsigna.",10,NULL,1,1,".$idEstado.")";
		$query = $this->db->query($sqlInsert);
		if (!$query){
	     	$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
			return $retArray;
			die();
	    }
	    
		//$idProyectoRelacionado = explode(",", $this->input->post("proyRelacionados"));
		//Insertando en PROYECTO
		if($idProyecto!=""){
			$sql = "INSERT INTO ACTIVIDAD_PROYECTO (idProyecto, idActividad, proyectoPrincipal,activo) 
					VALUES (".$this->db->escape($idProyecto).",".$this->db->escape($lastId).", '1', '1')";
			
			$query = $this->db->query($sql);		
			if (!$query){
		     	$retArray["status"] = $this->db->_error_number();
				$retArray["msg"] = $this->db->_error_message();
				return $retArray;
				die();
		    }		
		}
		
	    
	   
	    
		//Insertando los datos en ACTIVIDAD_PROYECTO de los proyectos relacionados
		if($proyectosRelacionados != ""){			
			$data_array12 = explode("|",$proyectosRelacionados);
			$insert_statements = $this->getRProjectsInsert($data_array12, $lastId);
			foreach ($insert_statements as $queryRProjects) {
				$this->db->query($queryRProjects);
				if(!$query){
			     	$retArray["status"] = $this->db->_error_number();
					$retArray["msg"] = $this->db->_error_message();
					return $retArray;
					die();
		   		}
			}
		}
		
		//Insertando los datos en USUARIO_ACTIVIDAD de los usuario responsables
		if($responsables != ""){
			$data_array1 = explode(",",$responsables);
			$insert_statements = $this->getResponsiblesInsert($data_array1, $lastId, $nombreActividad, $nombreProyecto);
			foreach ($insert_statements as $queryResponsibles) {
				$this->db->query($queryResponsibles[0]);
				$this->db->query($queryResponsibles[1]);
				$this->db->query($queryResponsibles[2]);
				$this->db->query($queryResponsibles[3]);
				if (!$queryResponsibles[0]){
			     	$retArray["status"] = $this->db->_error_number();
					$retArray["msg"] = $this->db->_error_message();
					return $retArray;
					die();
	    		}
			}
		}
	    
		
		
		//Insertando los datos en USUARIO_ACTIVIDAD de los seguidores
		if($seguidores != ""){
			$data_array = explode(",",$seguidores);
			$insert_statements = $this->getFollowersInsert($data_array, $lastId, $nombreActividad, $nombreProyecto);
			foreach ($insert_statements as $queryFollowers) {
				$this->db->query($queryFollowers[0]);
				$this->db->query($queryFollowers[1]);
				$this->db->query($queryFollowers[2]);
				$this->db->query($queryFollowers[3]);
				if (!$queryFollowers[0]){
			     	$retArray["status"] = $this->db->_error_number();
					$retArray["msg"] = $this->db->_error_message();
					return $retArray;
					die();
	    		}
			}
		}
	
		if($this->db->trans_status() == FALSE) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}	    
		
$retArray["msg"] =count($queryResponsibles);
	    
		return $retArray;		
	}
	
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	function read(){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "");
		
		$idActividad = $this->input->post("idActividad");		
		
		/*$sql = "SELECT a.nombreActividad, a.fechaInicioPlan, a.fechaFinalizacionPlan, a.descripcionActividad, ".
						"a.activo,prio.idPrioridad,prio.nombrePrioridad,e.idEstado,e.estado, a.idFase, proc.idProceso, ".
						"proc.nombreProceso, proy.idProyecto, proy.nombreProyecto ".
		
				" FROM ACTIVIDAD a INNER JOIN ACTIVIDAD_PROYECTO ap ON ap.idActividad = a.idActividad".
								" INNER JOIN PROYECTO proy ON  proy.idProyecto = ap.idProyecto".
								" LEFT JOIN PROCESO proc ON proc.idProceso = a.idProceso".
								" LEFT JOIN PRIORIDAD prio ON prio.idPrioridad = a.idPrioridad".
								" LEFT JOIN ESTADO e ON e.idEstado = a.idEstado".

				" WHERE a.idActividad =".$this->db->escape($idActividad);*/
		$sql = "SELECT p.idProyecto, p.nombreProyecto, a.nombreActividad, a.fechaInicioPlan,
		 				a.fechaFinalizacionPlan, a.descripcionActividad, a.activo, a.idFase, pry.idPrioridad, 
		 				pry.nombrePrioridad, est.idEstado , est.estado, ps.idProceso, ps.nombreProceso
					FROM ACTIVIDAD a LEFT JOIN ACTIVIDAD_PROYECTO ap ON (ap.idActividad = a.idActividad AND ap.proyectoPrincipal = '1')
						LEFT JOIN PROYECTO p ON (ap.idProyecto = p.idProyecto) LEFT JOIN PROCESO ps ON (ps.idProceso = a.idProceso)
						INNER JOIN PRIORIDAD pry ON (pry.idPrioridad = a.idPrioridad) INNER JOIN ESTADO est ON (est.idEstado = a.idEstado)
						WHERE a.idActividad = ".$this->db->escape($idActividad);
		
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
		
		$nombreProyecto = $this->input->post("nombreProyecto");
		
		$anioSolicitud = ($this->input->post("anioSolicitud")!="")?$this->input->post("anioSolicitud"):null;
		$correlAnio = ($this->input->post("correlAnio")!="")?$this->input->post("correlAnio"):null;
		
		$idActividad = $this->input->post("idActividad");
		$idProyecto = $this->input->post("idProyecto");
		$idPrioridad = $this->input->post("idPrioridad");
		$idProceso = ($this->input->post("idProceso")!="")?$this->input->post("idProceso"):null;
		$idEstado = $this->input->post("idEstado");
		
		$idUsuarioResponsable = $this->input->post("idUsuarioResponsable");
		$idUsuarioAsigna = $this->input->post("idUsuarioAsigna");
		
		$seguidoresI = $this->input->post("seguidoresI");
		$seguidoresD = $this->input->post("seguidoresD");
		$responsablesI = $this->input->post("responsablesI");
		$responsablesD = $this->input->post("responsablesD");
		$proyectosRelacionados = $this->input->post("proyRelacionados");
		
		//Si no se esta en sesion
		if ($idUsuarioAsigna == "")$idUsuarioAsigna=1;
		//$idUsuarioResponsable = 1;
		
		$lastId  = -1;
				
		//Iniciando transaccion
		$this->db->trans_begin();
		
		
		//Actualizando en ACTIVIDAD
		$sql = "UPDATE ACTIVIDAD ". 
				"SET nombreActividad = ".$this->db->escape($nombreActividad).
					 ",fechaInicioPlan = ".$this->db->escape($fechaInicioPlan).
					 ", fechaFinalizacionPlan = ".$this->db->escape($fechaFinalizacionPlan). 
					 ", descripcionActividad = ".$this->db->escape($descripcionActividad).
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
	    
		$sql = "SELECT COUNT(*) AS count FROM ACTIVIDAD_PROYECTO WHERE proyectoPrincipal=1 AND idActividad=".$this->db->escape($idActividad);
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0){
			$row = $query->row();
			$count  = $row->count;

		}
	    
	    if($idProyecto!=""){
		    //Actualizando en ACTIVIDAD_PROYECTO
		    if($count>0){
		    	$sql = "UPDATE ACTIVIDAD_PROYECTO SET idProyecto =".$this->db->escape($idProyecto)." WHERE idActividad = ".$this->db->escape($idActividad)." AND proyectoPrincipal = 1";
		    }
		    else{
		    	$sql = "INSERT INTO ACTIVIDAD_PROYECTO (idProyecto, idActividad, proyectoPrincipal,activo) ".
					"VALUES (".$this->db->escape($idProyecto).",".$this->db->escape($idActividad).", '1', '1')";
		    }
			
			
			$query = $this->db->query($sql);		
			if (!$query){
		     	$retArray["status"] = $this->db->_error_number();
				$retArray["msg"] = $this->db->_error_message();
		    }	    
	    }else{
	    	$sql = "DELETE FROM ACTIVIDAD_PROYECTO WHERE idActividad = ".$this->db->escape($idActividad)." AND proyectoPrincipal = 1";
			
			$query = $this->db->query($sql);		
			if (!$query){
		     	$retArray["status"] = $this->db->_error_number();
				$retArray["msg"] = $this->db->_error_message();
		    }
	    	
	    }
		
	    
 		//Eliminado en ACTIVIDAD_PROYECTO
		$sqlDP = "DELETE FROM ACTIVIDAD_PROYECTO WHERE proyectoPrincipal = 0 AND idActividad = ".$this->db->escape($idActividad);
                		
		$query = $this->db->query($sqlDP);		
		if (!$query){
	     	$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
	    }
	    //Insertando los datos en ACTIVIDAD_PROYECTO de los proyectos relacionados
		if($proyectosRelacionados != ""){
			$data_array12 = explode("|",$proyectosRelacionados);
			$insert_statements = $this->getRProjectsInsert($data_array12, $idActividad);
			foreach ($insert_statements as $queryRProjects) {
				$query = $this->db->query($queryRProjects);
			}
		}	    
	    	    
	    //Eliminado en USUARIO_ACTIVIDAD de responsables
		if($responsablesD != ""){
			$data_array1 = explode(",",$responsablesD);
			$insert_statements = $this->getUsersDelete($data_array1, $idActividad);
			foreach ($insert_statements as $queryResponsibles) {
				$this->db->query($queryResponsibles);
			}
		}
		
		//Eliminado en USUARIO_ACTIVIDAD de seguidores
		if($seguidoresD != ""){
			$data_array1 = explode(",",$seguidoresD);
			$insert_statements = $this->getUsersDelete($data_array1, $idActividad);
			foreach ($insert_statements as $queryFollowers) {
				$this->db->query($queryFollowers);
			}
		}

		//Insertando los datos en USUARIO_ACTIVIDAD de los usuario responsables
		if($responsablesI != ""){
			$data_array1 = explode(",",$responsablesI);
			$insert_statements = $this->getResponsiblesInsert($data_array1, $idActividad, $nombreActividad, $nombreProyecto);
			foreach ($insert_statements as $queryResponsibles) {
				$this->db->query($queryResponsibles[0]);
				$this->db->query($queryResponsibles[1]);
				$this->db->query($queryResponsibles[2]);
				$this->db->query($queryResponsibles[3]);
			}
		}
	    
		
		//Insertando los datos en USUARIO_ACTIVIDAD de los seguidores
		if($seguidoresI != ""){
			$data_array = explode(",",$seguidoresI);
			$insert_statements = $this->getFollowersInsert($data_array, $idActividad, $nombreActividad, $nombreProyecto);
			foreach ($insert_statements as $queryFollowers) {
				$this->db->query($queryFollowers[0]);
				$this->db->query($queryFollowers[1]);
				$this->db->query($queryFollowers[2]);
				$this->db->query($queryFollowers[3]);
			}
		}
	
	
		if($this->db->trans_status() == FALSE) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}	    
		
		//$retArray["msg"] = $queryResponsibles;
	    
		return $retArray;			
	}
	
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	

	function delete(){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "");
		
		$idActividad= $this->input->post("idActividad");
		
		$sql = "DELETE FROM ACTIVIDAD
				WHERE idActividad = ". $idActividad;
   				
		$query = $this->db->query($sql);
		
		if (!$query) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $sql;
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
	function userAutocompleteRead(){
		$this->load->database();

		$retArray = array("status"=> 0, "msg" => "", "data"=>array());

		$sql = "SELECT u.idUsuario, CONCAT(u.primerNombre,' ',u.primerApellido) nombreUsuario ".
			   "FROM USUARIO u INNER JOIN ROL_USUARIO ru ON ru.idUsuario = u.idUsuario ".
			   " WHERE ru.idRol IN (1,2,3,4)";
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
	
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	function processAutocompleteRead($idProyecto=null){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
				
		$sql = "SELECT p.nombreProceso, p.idProceso 
				FROM PROCESO p INNER JOIN PROYECTO pr ON p.idProyecto = pr.idProyecto";
		
		$sql.=($idProyecto!=null)?"	 WHERE p.activo = '1' AND p.idProyecto = " .$this->db->escape($idProyecto):"";
		
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
				
		$sql = "SELECT a.idActividad, a.nombreActividad ".
				"FROM ACTIVIDAD a LEFT JOIN ACTIVIDAD_PROYECTO ap ON a.idActividad = ap.idActividad AND ap.proyectoPrincipal = '1'".
				" WHERE a.activo = '1' ";
		
		$sql.=($idProyecto!=0)?" AND ap.idProyecto = " .$this->db->escape($idProyecto):"";
		
		$sql.=($idProceso!='')?" AND a.idProceso = " .$this->db->escape($idProceso):"";
		
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
		$retArray["msg"] = "proyecto=".$idProyecto." proceso=".$idProceso;
		return $retArray;
	}
	
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	function priorityAutocompleteRead(){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
				
		$sql = "SELECT idPrioridad, nombrePrioridad FROM PRIORIDAD WHERE activo = '1' ";
		
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
				
		$sql = "SELECT idEstado, estado FROM ESTADO WHERE idTipoEstado = 1 AND activo = '1' ";
		
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

	function fileTypeAutocompleteRead(){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
				
		$sql = "SELECT idTipoArchivo, nombreTipo FROM TIPO_ARCHIVO";
		
		$query = $this->db->query($sql);		
	
		if($query){
			if($query->num_rows > 0){			
				foreach ($query->result() as $row){		
					$rowArray = array();
					$rowArray["id"] = $row->idTipoArchivo;
					$rowArray["value"] = $row->nombreTipo;
										
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
	
	//Devuelve en la variable $msg, los mensajes para los errores detectados por no cumplir las validaciones aplicadas usando la librer�a form_validation
	function saveValidation(){
		$this->load->library('form_validation');
		
		$retArray = array("status"=> 0, "msg" => "");
		
		//Colocando las reglas para los campos, el segundo par�metro es el nombre del campo que aparecer� en el mensaje
		//Habr� que reemplazar los mensajes, pues por el momento est�n en ingl�s
		$this->form_validation->set_rules("nombreActividad", "Nombre", 'required');
		$this->form_validation->set_rules("descripcion", "Descripcion", 'required');

		if ($this->form_validation->run() == false){//Si al menos una de las reglas no se cumpli�...
			//Concatenamos en $msg los mensajes de errores generados para cada campo, lo tenga o no
			$retArray["status"] = 1;
			$retArray["msg"] .= form_error("nombreActividad");
			$retArray["msg"] .= form_error("descripcion");			
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
				"WHERE u.activo = '1' AND u.idUsuario NOT IN (SELECT idUsuario FROM USUARIO_ACTIVIDAD WHERE idTipoAsociacion = 2 AND idActividad = ".$this->db->escape($idActividad).")";
		
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
		$response->sql = $sql;
		
		//-------------------------
		
		$sql = "SELECT u.idUsuario, CONCAT(u.primerNombre,' ', u.primerApellido) as nombreUsuario, d.nombreDepto ".
				"FROM USUARIO u INNER JOIN DEPARTAMENTO d ON u.idDepto = d.idDepto ";		
		
		if($idActividad != NULL)$sql.="WHERE u.idUsuario NOT IN (SELECT idUsuario FROM USUARIO_ACTIVIDAD WHERE idTipoAsociacion = 2 AND idActividad = ".$this->db->escape($idActividad).")";
		
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
		
		$sql = "SELECT u.idUsuario, CONCAT(u.primerNombre,' ', u.primerApellido) as nombreUsuario, d.nombreDepto ".
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
	
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	function gridUsuarios1Read($idActividad=NULL){
		$this->load->database();		
		
		$page = $this->input->post("page");
		$limit = $this->input->post("rows");
		$sidx = $this->input->post("sidx");
		$sord = $this->input->post("sord");
		$count = 0;		
		if(!$sidx) $sidx =1;
		
		$sql = "SELECT COUNT(*) AS count ".
				"FROM (SELECT u.idUsuario, CONCAT(u.primerNombre,' ',u.primerApellido) AS nombreUsuario, c.nombreCargo ".
					  "FROM USUARIO u INNER JOIN USUARIO_HISTORICO uh ON uh.idUsuario = u.idUsuario ".
					  "LEFT JOIN CARGO c ON c.idCargo = u.idCargo ".
					  "GROUP BY u.idUsuario) AS BLAH ";
		
		
		if($idActividad != NULL)$sql.=  "WHERE idUsuario NOT IN (SELECT ua.idUsuario FROM USUARIO_ACTIVIDAD ua WHERE ua.idActividad =".$this->db->escape($idActividad).")";
		
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
		$response->sql = $sql;
		
		//-------------------------
		
		$sql = "SELECT u.idUsuario, CONCAT(u.primerNombre,' ',u.primerApellido) AS nombreUsuario, c.nombreCargo ".
			   "FROM USUARIO u INNER JOIN USUARIO_HISTORICO uh ON uh.idUsuario = u.idUsuario ".
               "LEFT JOIN CARGO c ON c.idCargo = u.idCargo ";
			   
		
		if($idActividad != NULL)$sql.= 	"WHERE uh.activo = '1' AND u.idUsuario NOT IN (SELECT ua.idUsuario FROM USUARIO_ACTIVIDAD ua WHERE ua.idActividad =".$this->db->escape($idActividad)." AND idTipoAsociacion = 1)";
		
		$sql.=" GROUP BY u.idUsuario ";
		
		$query = $this->db->query($sql);		
	
		$i = 0;
		if($query){
			if($query->num_rows > 0){							
				foreach ($query->result() as $row){		
					$response->rows[$i]["id"] = $i;
					$response->rows[$i]["cell"] = array($row->idUsuario, $row->nombreUsuario, $row->nombreCargo);
					$i++;				
				}										
			}			
		}
		$response->sql = $sql;
		return $response;
	}
	
	
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	function gridResponsablesRead($idActividad){
		$this->load->database();		
		
		$page = $this->input->post("page");
		$limit = $this->input->post("rows");
		$sidx = $this->input->post("sidx");
		$sord = $this->input->post("sord");
		$count = 0;		
		if(!$sidx) $sidx =1;
		
		$sql = "SELECT COUNT(*) FROM (SELECT 1 ".
				"FROM USUARIO u INNER JOIN USUARIO_ACTIVIDAD ua ON ua.idUsuario = u.idUsuario AND ua.idTipoAsociacion = 1 ". 
								"LEFT JOIN CARGO c ON c.idCargo = u.idCargo ". 
            	" WHERE ua.idActividad = ".$this->db->escape($idActividad).
				" GROUP BY u.idUsuario) AS BLAH" ;
		
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
		//$response->sql = $sql;
		
		//-------------------------
		
		$sql = "SELECT u.idUsuario, CONCAT(u.primerNombre,' ',u.primerApellido) AS nombreUsuario, c.nombreCargo ".
				"FROM USUARIO u INNER JOIN USUARIO_ACTIVIDAD ua ON ua.idUsuario = u.idUsuario AND ua.idTipoAsociacion = 1 ". 
								"LEFT JOIN CARGO c ON c.idCargo = u.idCargo ". 
            	" WHERE ua.idActividad = ".$this->db->escape($idActividad).
				" GROUP BY u.idUsuario" ;
		
		$query = $this->db->query($sql);		
	
		$i = 0;
		if($query){
			if($query->num_rows > 0){							
				foreach ($query->result() as $row){		
					$response->rows[$i]["id"] = $i;
					$response->rows[$i]["cell"] = array($row->idUsuario, $row->nombreUsuario, $row->nombreCargo);
					$i++;				
				}										
			}			
		}
		
		return $response;
	}
	
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	function gridProyectosRead($idActividad=NULL){
		$this->load->database();		
		
		$page = $this->input->post("page");
		$limit = $this->input->post("rows");
		$sidx = $this->input->post("sidx");
		$sord = $this->input->post("sord");
		$count = 0;		
		if(!$sidx) $sidx =1;
		
		$sql = "SELECT COUNT(*) FROM PROYECTO p INNER JOIN USUARIO u ON p.idUsuario = u.idUsuario " ;
		
		if($idActividad != NULL) $sql.= "WHERE p.activo = '1' AND idProyecto NOT IN (SELECT ap.idProyecto FROM ACTIVIDAD_PROYECTO ap WHERE ap.idActividad =".$this->db->escape($idActividad).")";
		
		$query = $this->db->query($sql);		
		
		if ($query->num_rows > 0){
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
		$response->sql = $sql;
		
		//-------------------------
		
		$sql = "SELECT p.idProyecto, p.nombreProyecto, CONCAT(u.primerNombre, ' ', u.primerApellido) as nombreUsuario ".
				"FROM PROYECTO p INNER JOIN USUARIO u ON p.idUsuario = u.idUsuario ";
		
		if($idActividad != NULL)$sql.=  "WHERE idProyecto NOT IN (SELECT ap.idProyecto FROM ACTIVIDAD_PROYECTO ap WHERE ap.idActividad =".$this->db->escape($idActividad).")";
		
		$query = $this->db->query($sql);		
	
		$i = 0;
		if($query){
			if($query->num_rows > 0){							
				foreach ($query->result() as $row){		
					$response->rows[$i]["id"] = $i;
					$response->rows[$i]["cell"] = array($row->idProyecto, $row->nombreProyecto, $row->nombreUsuario);
					$i++;				
				}										
			}			
		}
		
		return $response;
	}
	
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	function gridRProyectosRead($idActividad){
		$this->load->database();		
		
		$page = $this->input->post("page");
		$limit = $this->input->post("rows");
		$sidx = $this->input->post("sidx");
		$sord = $this->input->post("sord");
		$count = 0;		
		if(!$sidx) $sidx =1;
		
		$sql = "SELECT COUNT(*) as count ".
				"FROM PROYECTO p INNER JOIN ACTIVIDAD_PROYECTO ap ON ap.idProyecto = p.idProyecto AND ap.proyectoPrincipal = 0 AND ap.idActividad =". $this->db->escape($idActividad).
                " INNER JOIN USUARIO u ON u.idUsuario = p.idUsuario" ;
		
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
		//$response->sql = $sql;
		
		//-------------------------
		
		$sql = "SELECT p.idProyecto, p.nombreProyecto, CONCAT(u.primerNombre,' ', u.primerApellido) as nombreUsuario ".
				"FROM PROYECTO p INNER JOIN ACTIVIDAD_PROYECTO ap ON ap.idProyecto = p.idProyecto  AND ap.proyectoPrincipal = 0 AND ap.idActividad =".$this->db->escape($idActividad).
                " INNER JOIN USUARIO u ON u.idUsuario = p.idUsuario" ;
		
		$query = $this->db->query($sql);		
	
		$i = 0;
		if($query){
			if($query->num_rows > 0){							
				foreach ($query->result() as $row){		
					$response->rows[$i]["id"] = $i;
					$response->rows[$i]["cell"] = array($row->idProyecto, $row->nombreProyecto, $row->nombreUsuario);
					$i++;				
				}										
			}			
		}
		
		return $response;
	}
	
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------

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
	function createActivityFile(){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "");
		
		$idActividad   = $this->input->post("idActividad");
		$idTipoArchivo = $this->input->post("idTipoArchivo");
		$nombreArchivo = $this->input->post("nombreArchivo");
		$tituloArchivo = $this->input->post("tituloArchivo");
		$descripcion = $this->input->post("descripcion");
		
		if($idTipoArchivo=="")$idTipoArchivo=null;
		
		$sql = "INSERT INTO ARCHIVOS (idActividad, nombreArchivo, tituloArchivo, descripcion, idTipoArchivo, fechaSubida)
    			VALUES (".$this->db->escape($idActividad).", ".
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

	function updateActivityFile(){
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
		$nombreArchivo = $this->input->post("nombreArchivo");
		
		$filePath = './uploads/'.$nombreArchivo;
		
		$sql = "DELETE FROM ARCHIVOS
				WHERE idArchivo = ". $idArchivo;
			
		$query = $this->db->query($sql);
		
		if (!$query) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
		}
		else{
			unlink($filePath);
		}

		return $retArray;
	}
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	function activityFilesRead($idActividad=null){
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
			   "WHERE idActividad = ".$this->db->escape($idActividad);
		
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
		$sql = "SELECT a.idArchivo, a.tituloArchivo ,a.nombreArchivo, a.descripcion, a.fechaSubida, ta.nombreTipo ".
				"FROM ARCHIVOS a LEFT JOIN TIPO_ARCHIVO ta on ta.idTipoArchivo = a.idTipoArchivo ".
				"WHERE idActividad = ".$this->db->escape($idActividad);
		
		$response->sql = $sql;
		
		$query = $this->db->query($sql);		
		$i = 0;
		
		if($query){
			if($query->num_rows > 0){
				foreach ($query->result() as $row){
					$response->rows[$i]["id"] = $i+1;
					$response->rows[$i]["cell"] = array($row->idArchivo,$row->nombreTipo,$row->tituloArchivo, $row->nombreArchivo, $row->fechaSubida, $row->descripcion);
					$i++;
				}
			}
		}
		return $response;
	}
	
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	function getFollowersInsert($data_array,$idActividad, $nombreActividad, $nombreProyecto){
		for($i = 0 ; $i< (count($data_array)); $i++){
				$idUsuario = $data_array[$i];
				$cadNotificacion = "Se le ha asignado como seguidor de la actividad <b>".$nombreActividad."</b>";
				
				$sql[$i][0] = "INSERT INTO USUARIO_ACTIVIDAD(idUsuario, correlVinculacion, idActividad, fechaVinculacion, idTipoAsociacion, idUsuarioAsigna, activo)".
    										"VALUES(".
													$this->db->escape($idUsuario).
													",(SELECT COALESCE((SELECT MAX(ua.correlVinculacion) + 1 correlVinculacion FROM USUARIO_ACTIVIDAD ua WHERE ua.idUsuario =".$this->db->escape($idUsuario)." AND ua.idActividad=".$this->db->escape($idActividad)." ), 1)),".
												    $this->db->escape($idActividad).",".
												    "DATE(NOW()),2,".
											    	$this->db->escape('1').",'1')";
											    	
				$sql[$i][1]="INSERT INTO NOTIFICACION(notificacion,subject,fechaNotificacion) VALUES(".$this->db->escape($cadNotificacion).",'Seguidor de actividad',CURRENT_TIMESTAMP())";
				
				$sql[$i][2]="SET @lastId = (SELECT COUNT(LAST_INSERT_ID()) FROM NOTIFICACION)";
				
				$sql[$i][3]="INSERT INTO USUARIO_NOTIFICACION(idUsuario,idNotificacion,idEstado,horaEntrada) VALUES(".$this->db->escape($idUsuario).",@lastId,18, CURRENT_TIMESTAMP())";											    	
											
		}
		return  $sql;

	}
	
	function getResponsiblesInsert($data_array,$idActividad, $nombreActividad, $nombreProyecto){
		
		for($i = 0 ; $i< (count($data_array)); $i++){
				$idUsuario = $data_array[$i];
				$cadNotificacion = "Se le ha asignado la actividad <b>".$nombreActividad."</b>";
				
				$sql[$i][0] = "INSERT INTO USUARIO_ACTIVIDAD (idUsuario, correlVinculacion, idActividad, fechaVinculacion, activo, idTipoAsociacion, idUsuarioAsigna)
							VALUES(".
													$this->db->escape($idUsuario).
													",(SELECT COALESCE((SELECT MAX(ua.correlVinculacion) + 1 correlVinculacion FROM USUARIO_ACTIVIDAD ua WHERE ua.idUsuario =".$this->db->escape($idUsuario)." AND ua.idActividad=".$this->db->escape($idActividad)." ), 1)),".
												    $this->db->escape($idActividad).",".
												    "DATE(NOW()),1,1,".
											    	$this->db->escape('1').")";
											    	
			
				$sql[$i][1]="INSERT INTO NOTIFICACION(notificacion,subject,fechaNotificacion) VALUES(".$this->db->escape($cadNotificacion).",'Actividad asignada',CURRENT_TIMESTAMP())";
				
				$sql[$i][2]="SET @lastId = (SELECT COUNT(LAST_INSERT_ID()) FROM NOTIFICACION)";
				
				$sql[$i][3]="INSERT INTO USUARIO_NOTIFICACION(idUsuario,idNotificacion,idEstado,horaEntrada) VALUES(".$this->db->escape($idUsuario).",@lastId,18, CURRENT_TIMESTAMP())";
		}
		return  $sql;
		
	}
	
	function getUsersDelete($data_array,$idActividad){
		
		for($i = 0 ; $i< (count($data_array)); $i++){
				$idUsuario = $data_array[$i];
				
				$sql[$i] = "DELETE FROM USUARIO_ACTIVIDAD WHERE idActividad = ". $this->db->escape($idActividad)." AND idUsuario = ".$this->db->escape($idUsuario);
		}
		return  $sql;
		
	}
	
	function getRProjectsInsert($data_array,$idActividad){		
		for($i = 0 ; $i< (count($data_array)); $i++){
				$idProyecto = $data_array[$i];
			
				$sql[$i] = "INSERT INTO ACTIVIDAD_PROYECTO (idProyecto, idActividad, proyectoPrincipal) VALUES (".$this->db->escape($idProyecto).",".$this->db->escape($idActividad).", 0)";
				//echo $sql[$i];
		}
		return  $sql;
	}
	
}
