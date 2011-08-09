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
		$idProceso = $this->input->post("idProceso");
		$idEstado = $this->input->post("idEstado");
		
		$sql = "INSERT INTO ACTIVIDAD (nombreActividad, fechaInicioPlan, fechaFinalizacionPlan, descripcionActividad, activo, anioSolicitud, correlAnio, idPrioridad, idProceso, idEstado) 
   				VALUES (".$this->db->escape($nombreActividad).", ".$this->db->escape($fechaInicioPlan).",".$this->db->escape($fechaFinalizacionPlan).",".$this->db->escape($descripcionActividad).",'NULL',".
						  $this->db->escape($anioSolicitud).",".$this->db->escape($correlAnio).",".$this->db->escape($idPrioridad).",".$this->db->escape($idProceso).",".
						  $this->db->escape($Estado).")";
		
		//Iniciando transacción
		$this->db->trans_begin();		
		
		$query = $this->db->query($sql);
		
		if (!$query){
	     	$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $sql;
	    }
	    else{
	    
	    }	    
	    $this->db->trans_complete();
	    
		return $retArray;		
	}
	
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	function read(){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
		
		$idProceso = $this->input->post("idProceso");		
		
		$sql = "SELECT e.idEstado, p.nombreProceso, p.descripcion, e.estado, pr.nombreProyecto
				FROM PROCESO p INNER JOIN Proyecto pr ON p.idProyecto = pr.idProyecto 
					INNER JOIN ESTADO e ON p.idEstado = e.idEstado
				WHERE p.idProceso = " .$idProceso;
		
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

	function update(){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "");
		
		$idEstado = $this->input->post("idEstado");
		$estado = $this->input->post("estado");
		$idTipoEstado = $this->input->post("idTipoEstado");
		
		$sql = "UPDATE ESTADO 
				SET estado = ".$this->db->escape($estado).",
				    idTipoEstado = ".$idTipoEstado."
				WHERE idEstado = ". $idEstado; 
		
		$query = $this->db->query($sql);
		
		if (!$query) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
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
	
	
}
