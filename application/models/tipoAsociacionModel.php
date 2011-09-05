<?php
class tipoAsociacionModel extends CI_Model{
	
	
	function create(){
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
		
		$this->load->database();		
		//Verificando correcta conexión a la base de datos
		if (!$this->db->conn_id) {
			$retArray["status"] = 2;
			$retArray["msg"] = database_cn_error_msg();
			return $retArray;
		}
		
		$nombreAsociacion = $this->input->post("nombreAsociacion");
				
		
		$sql = "INSERT INTO TIPO_ASOCIACION (idTipoAsociacion,nombreAsociacion) 
   				VALUES (DEFAULT,".$this->db->escape($nombreAsociacion).")";
		
		$query = $this->db->query($sql);
		
		if (!$query){
	     	$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = (database_error_msg()!="")?database_error_msg():$this->db->_error_message();
	    }
	    
		return $retArray;		
	}
	
	
	function read(){
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
		
		$this->load->database();		
		//Verificando correcta conexión a la base de datos
		if (!$this->db->conn_id) {
			$retArray["status"] = 2;
			$retArray["msg"] = database_cn_error_msg();
			return $retArray;
		}
		
		$idTipoAsociacion = $this->input->post("idTipoAsociacion");			
		
		$sql = "SELECT nombreAsociacion FROM TIPO_ASOCIACION WHERE idTipoAsociacion = ".$idTipoAsociacion;
		
		$query = $this->db->query($sql);
		
		if ($query) {
			$row = $query->row_array();
	    	$retArray["data"] = $row;	     	
	    }
	    else{
	    	$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = (database_error_msg()!="")?database_error_msg():$this->db->_error_message();
	    	
	    }
	    
	    return $retArray;
	}
	

	function update(){
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
		
		$this->load->database();		
		//Verificando correcta conexión a la base de datos
		if (!$this->db->conn_id) {
			$retArray["status"] = 2;
			$retArray["msg"] = database_cn_error_msg();
			return $retArray;
		}
		
		$idTipoAsociacion = $this->input->post("idTipoAsociacion");
		$nombreAsociacion = $this->input->post("nombreAsociacion");				
		
		$sql = "UPDATE TIPO_ASOCIACION 
				SET nombreAsociacion = ".$this->db->escape($nombreAsociacion)."				    
				WHERE idTipoAsociacion = ". $idTipoAsociacion; 
		
		$query = $this->db->query($sql);
		
		if (!$query) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = (database_error_msg()!="")?database_error_msg():$this->db->_error_message();
	    }
		
		return $retArray;		
	}
	

	function delete(){
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
		
		$this->load->database();		
		//Verificando correcta conexión a la base de datos
		if (!$this->db->conn_id) {
			$retArray["status"] = 2;
			$retArray["msg"] = database_cn_error_msg();
			return $retArray;
		}
		
		$idTipoAsociacion = $this->input->post("idTipoAsociacion");
		
		$sql = "DELETE FROM TIPO_ASOCIACION 
				WHERE idTipoAsociacion = ". $idTipoAsociacion;
   				
		$query = $this->db->query($sql);
		
		if (!$query) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = (database_error_msg()!="")?database_error_msg():$this->db->_error_message();
	    }
		
		return $retArray;	
	}
	
	
	function autocompleteRead(){
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
		
		$this->load->database();		
		//Verificando correcta conexión a la base de datos
		if (!$this->db->conn_id) {
			$retArray["status"] = 2;
			$retArray["msg"] = database_cn_error_msg();
			return $retArray;
		}
		
		$sql = "SELECT idTipoAsociacion, nombreAsociacion FROM TIPO_ASOCIACION";
		$query = $this->db->query($sql);		
	
		if($query){
			if($query->num_rows > 0){			
				foreach ($query->result() as $row){		
					$rowArray = array();
					$rowArray["id"] = $row->idTipoAsociacion;
					$rowArray["value"] = $row->nombreAsociacion;
					
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
	
	
	//Devuelve en la variable $msg, los mensajes para los errores detectados por no cumplir las validaciones aplicadas usando la librería form_validation
	function saveValidation(){
		$this->load->library('form_validation');
		//print_r($_POST);
		
		$retArray = array("status"=> 0, "msg" => "");
		
		//Colocando las reglas para los campos, el segundo parámetro es el nombre del campo que aparecerá en el mensaje
		//Habrá que reemplazar los mensajes, pues por el momento están en inglés
		$this->form_validation->set_rules("nombreAsociacion", "Nombre", 'required|alpha');				
		
		if ($this->form_validation->run() == false){//Si al menos una de las reglas no se cumplió...
			//Concatenamos en $msg los mensajes de errores generados para cada campo, lo tenga o no
			$retArray["status"] = 1;
			
			$retArray["msg"] .= form_error("nombreAsociacion");						
		}		
		return $retArray;
	}	
	
}