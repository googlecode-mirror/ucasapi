<?php
class prioridadModel extends CI_Model{
	
	
	function create(){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "");
		
		$nombrePrioridad = $this->input->post("nombrePrioridad");
				
		
		$sql = "INSERT INTO PRIORIDAD (idPrioridad,nombrePrioridad)
   				VALUES (DEFAULT,".$this->db->escape($nombrePrioridad).")";
		
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
		
		$idPrioridad = $this->input->post("idPrioridad");			
		
		$sql = "SELECT nombrePrioridad FROM PRIORIDAD WHERE idPrioridad = ".$idPrioridad;
		
		$query = $this->db->query($sql);
		
		if ($query) {
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
		
		$idPrioridad = $this->input->post("idPrioridad");
		$nombrePrioridad = $this->input->post("nombrePrioridad");				
		
		$sql = "UPDATE PRIORIDAD 
				SET nombrePrioridad = ".$this->db->escape($nombrePrioridad)."				    
				WHERE idPrioridad = ". $idPrioridad; 
		
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
		
		$idPrioridad = $this->input->post("idPrioridad");
		
		$sql = "DELETE FROM PRIORIDAD
				WHERE idPrioridad = ". $idPrioridad;
   				
		$query = $this->db->query($sql);
		
		if (!$query) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
	    }
		
		return $retArray;	
	}
	
	
	function autocompleteRead(){
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
		}
		
		return $retArray;
	}
	
	
	//Devuelve en la variable $msg, los mensajes para los errores detectados por no cumplir las validaciones aplicadas usando la librería form_validation
	function saveValidation(){
		$this->load->library('form_validation');
		//print_r($_POST);
		
		$retArray = array("status"=> 0, "msg" => "");
		
		//Colocando las reglas para los campos, el segundo parámetro es el nombre del campo que aparecerá en el mensaje
		//Habrá que reemplazar los mensajes, pues por el momento están en inglés
		$this->form_validation->set_rules("nombrePrioridad", "Nombre", 'required|alpha');				
		
		if ($this->form_validation->run() == false){//Si al menos una de las reglas no se cumplió...
			//Concatenamos en $msg los mensajes de errores generados para cada campo, lo tenga o no
			$retArray["status"] = 1;
			
			$retArray["msg"] .= form_error("nombrePrioridad");						
		}		
		return $retArray;
	}	
	
}