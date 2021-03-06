<?php
class estadoModel extends CI_Model{
	
	
	function create(){
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
		
		$db = $this->load->database();		
		//Verificando correcta conexi�n a la base de datos
		if (!$this->db->conn_id) {
			$retArray["status"] = 2;
			$retArray["msg"] = database_cn_error_msg();
			return $retArray;
		}
		
		$estado = $this->input->post("estado");	
		$idTipoEstado = $this->input->post("idTipoEstado");
		
		$sql = "INSERT INTO ESTADO (estado,idTipoEstado,activo) 
   				VALUES (".$this->db->escape($estado).", ".$idTipoEstado.",'1')";
		
		$query = $this->db->query($sql);
		
		if (!$query){
	     	$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = (database_error_msg()!="")?database_error_msg():$this->db->_error_message();
	    }
	    
		return $retArray;		
	}
	
	
	function read(){
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
		
		$db = $this->load->database();		
		//Verificando correcta conexi�n a la base de datos
		if (!$this->db->conn_id) {
			$retArray["status"] = 2;
			$retArray["msg"] = database_cn_error_msg();
			return $retArray;
		}
		
		$idEstado = $this->input->post("idEstado");		
		
		$sql = "SELECT e.estado, e.idTipoEstado, te.nombreTipoEstado
				FROM ESTADO e INNER JOIN TIPO_ESTADO te  ON e.idTipoEstado = te.idTipoEstado
				WHERE e.idEstado = ".$idEstado;
		
		$query = $this->db->query($sql);
		
		if($query) {
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
		
		$db = $this->load->database();		
		//Verificando correcta conexi�n a la base de datos
		if (!$this->db->conn_id) {
			$retArray["status"] = 2;
			$retArray["msg"] = database_cn_error_msg();
			return $retArray;
		}
		
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
			$retArray["msg"] = (database_error_msg()!="")?database_error_msg():$this->db->_error_message();
	    }
		
		return $retArray;		
	}
	

	function delete(){
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
		
		$db = $this->load->database();		
		//Verificando correcta conexi�n a la base de datos
		if (!$this->db->conn_id) {
			$retArray["status"] = 2;
			$retArray["msg"] = database_cn_error_msg();
			return $retArray;
		}
		
		$idEstado = $this->input->post("idEstado");
		
		$sql = "UPDATE ESTADO
				SET activo = '0'
				WHERE idEstado = ". $idEstado;
   				
		$query = $this->db->query($sql);
		
		if (!$query) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = (database_error_msg()!="")?database_error_msg():$this->db->_error_message();
	    }
		
		return $retArray;	
	}
	
	
	function autocompleteRead(){
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
		
		$db = $this->load->database();		
		//Verificando correcta conexi�n a la base de datos
		if (!$this->db->conn_id) {
			$retArray["status"] = 2;
			$retArray["msg"] = database_cn_error_msg();
			return $retArray;
		}
		
		$sql = "SELECT idEstado, estado FROM ESTADO WHERE activo = '1' ";
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
			$retArray["msg"] = (database_error_msg()!="")?database_error_msg():$this->db->_error_message();
		}
		
		return $retArray;
	}
	
	
	//Devuelve en la variable $msg, los mensajes para los errores detectados por no cumplir las validaciones aplicadas usando la librer�a form_validation
	function saveValidation(){
		$this->load->library('form_validation');
		
		$retArray = array("status"=> 0, "msg" => "");
		
		//Colocando las reglas para los campos, el segundo par�metro es el nombre del campo que aparecer� en el mensaje
		//Habr� que reemplazar los mensajes, pues por el momento est�n en ingl�s
		$this->form_validation->set_rules("estado", "Estado", 'required');
		$this->form_validation->set_rules("idTipoEstado", "Tipo estado", 'required');

		if ($this->form_validation->run() == false){//Si al menos una de las reglas no se cumpli�...
			//Concatenamos en $msg los mensajes de errores generados para cada campo, lo tenga o no
			$retArray["status"] = 1;
			
			$retArray["msg"] .= form_error("estado");
			$retArray["msg"] .= form_error("idTipoEstado");			
		}
		
		return $retArray;
	}
	
	
	function statusTypeAutocomplete(){
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
		
		$db = $this->load->database();		
		//Verificando correcta conexi�n a la base de datos
		if (!$this->db->conn_id) {
			$retArray["status"] = 2;
			$retArray["msg"] = database_cn_error_msg();
			return $retArray;
		}
		
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
			$retArray["msg"] = (database_error_msg()!="")?database_error_msg():$this->db->_error_message();
		}
		
		return $retArray;
	}
	
}