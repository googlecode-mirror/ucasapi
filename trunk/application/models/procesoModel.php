<?php
class procesoModel extends CI_Model{
	
	
	function create(){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "");
		
		$nombreProceso = $this->input->post("nombreProceso");	
		$descripcion = $this->input->post("descripcion");
		$idProyecto = $this->input->post("idProyecto");
		$idFase = $this->input->post("idFase");
		$idEstado = $this->input->post("idEstado");
		
		$sql = "INSERT INTO PROCESO (nombreProceso,descripcion,idProyecto,idFase,idEstado,activo) 
   				VALUES (".$this->db->escape($nombreProceso).", ".$this->db->escape($descripcion).",".'NULL'.",".$this->db->escape($idFase).",".$this->db->escape($idEstado).","."1".")";
		
		$query = $this->db->query($sql);
		
		if (!$query){
	     	$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
	    }
	    
		return $retArray;		
	}
	
	
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
		
		//------------------------------------------------------------------------------------------------------
		
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
	
	
	function autocompleteRead($idProyecto){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
		
		$sql = "SELECT p.nombreProceso, p.idProceso 
				FROM Proceso p INNER JOIN Proyecto pr ON p.idProyecto = pr.idProyecto
				WHERE p.idProyecto = " .$idProyecto;
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
		}		
		return $retArray;
	}
	
	
	//Devuelve en la variable $msg, los mensajes para los errores detectados por no cumplir las validaciones aplicadas usando la librería form_validation
	function saveValidation(){
		$this->load->library('form_validation');
		
		$retArray = array("status"=> 0, "msg" => "");
		
		//Colocando las reglas para los campos, el segundo parámetro es el nombre del campo que aparecerá en el mensaje
		//Habrá que reemplazar los mensajes, pues por el momento están en inglés
		$this->form_validation->set_rules("nombreProceso", "Nombre", 'required|alpha');
		$this->form_validation->set_rules("descripcion", "Descripcion", 'alpha');

		if ($this->form_validation->run() == false){//Si al menos una de las reglas no se cumplió...
			//Concatenamos en $msg los mensajes de errores generados para cada campo, lo tenga o no
			$retArray["status"] = 1;
			
			$retArray["msg"] .= form_error("nombreProceso");
			$retArray["msg"] .= form_error("descripcion");			
		}
		
		return $retArray;
	}
	
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
