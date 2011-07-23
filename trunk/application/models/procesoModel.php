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
		
		$sql = "SELECT e.estado, e.idTipoEstado, te.nombreTipoEstado
				FROM ESTADO e INNER JOIN TIPO_ESTADO te  ON e.idTipoEstado = te.idTipoEstado
				WHERE idProceso = ".$idProceso;
		
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
	
	
	function autocompleteRead(){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
		
		$sql = "SELECT idProceso, nombreProceso, descripcion FROM PROCESO";
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
	
	/*
	function statusTypeAutocomplete(){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
		
		$sql = "SELECT idTipoEstado, nombreTipoEstado FROM TIPO_ESTADO";
		$query = $this->db->query($sql);		
	
		if($query){
			if($query->num_rows > 0){			
				foreach ($query->result() as $row){		
					$rowArray = array();
					$rowArray["id"] = $row->idTipoEstado;
					$rowArray["value"] = $row->nombreTipoEstado;
					
					$retArray["data"][] = $rowArray;				
				}							
			}
		}
		else{
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
		}
		
		return $retArray;
	}*/
	
}