<?php
class departamentoModel extends CI_Model{
	
	
	function create(){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "");
		
		$nombreDepto = $this->input->post("nombreDepto");
		$descripcion = $this->input->post("descripcion");		
		
		$sql = "INSERT INTO DEPARTAMENTO (nombreDepto, descripcion) 
   				VALUES (".$this->db->escape($nombreDepto).", ".$this->db->escape($descripcion).")";
		
		$query = $this->db->query($sql);
		
		if (!$query){
	     	$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = (database_eror_msg()!="")?database_eror_msg():$this->db->_error_message();
	    }
	    
		return $retArray;		
	}
	
	
	function read(){
		$this->load->database();
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
		
		$idDepto = $this->input->post("idDepto");		
		
		$sql = "SELECT nombreDepto, descripcion
				FROM DEPARTAMENTO WHERE idDepto = ".$idDepto;
		
		$query = $this->db->query($sql);
		
		if ($query) {
			$row = $query->row_array();
	    	$retArray["data"] = $row;	     	
	    }
	    else{
	    	$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = (database_eror_msg()!="")?database_eror_msg():$this->db->_error_message();
	    	
	    }
	    
	    return $retArray;
	}
	

	function update(){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "");
		
		$idDepto = $this->input->post("idDepto");
		$nombreDepto = $this->input->post("nombreDepto");
		$descripcion = $this->input->post("descripcion");		
		
		$sql = "UPDATE DEPARTAMENTO 
				SET nombreDepto = ".$this->db->escape($nombreDepto).",
				    descripcion = ".$this->db->escape($descripcion)."
				WHERE idDepto = ". $idDepto; 
		
		$query = $this->db->query($sql);
		
		if (!$query) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = (database_eror_msg()!="")?database_eror_msg():$this->db->_error_message();
	    }
		
		return $retArray;		
	}
	

	function delete(){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "");
		
		$idDepto = $this->input->post("idDepto");
		
		$sql = "DELETE FROM DEPARTAMENTO 
				WHERE idDepto = ". $idDepto;
   				
		$query = $this->db->query($sql);
		
		if (!$query) {
			$retArray["status"] = $this->db->_error_number();
			$$retArray["msg"] = (database_eror_msg()!="")?database_eror_msg():$this->db->_error_message();
	    }
		
		return $retArray;	
	}
	
	
	function autocompleteRead(){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
		
		$sql = "SELECT idDepto, nombreDepto FROM DEPARTAMENTO";
		$query = $this->db->query($sql);		
	
		if($query){
			if($query->num_rows > 0){			
				foreach ($query->result() as $row){		
					$rowArray = array();
					$rowArray["id"] = $row->idDepto;
					$rowArray["value"] = $row->nombreDepto;
					
					$retArray["data"][] = $rowArray;				
				}							
			}
		}
		else{
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = (database_eror_msg()!="")?database_eror_msg():$this->db->_error_message();
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
		$this->form_validation->set_rules("nombreDepto", "Nombre", 'required');
		$this->form_validation->set_rules("descripcion", "Descripcion", 'required');		
		
		$this->form_validation->set_message('required', 'El campo "%s" es requerido');
		
		if ($this->form_validation->run() == false){//Si al menos una de las reglas no se cumplió...
			//Concatenamos en $msg los mensajes de errores generados para cada campo, lo tenga o no
			$retArray["status"] = 1;
			
			$retArray["msg"] .= form_error("nombreDepto");
			$retArray["msg"] .= form_error("descripcion");			
		}
		
		return $retArray;
	}
	
	
	function gridDepartamentoRead($idDepto=null){
		$this->load->database();		
		
		$page = $this->input->post("page");
		$limit = $this->input->post("rows");
		$sidx = $this->input->post("sidx");
		$sord = $this->input->post("sord");
		$count = 0;		
		if(!$sidx) $sidx =1;
		
		$idDepto = is_null($idDepto) ? -1 : $idDepto;
		
		
		$sql = "SELECT COUNT(*) AS count FROM DEPARTAMENTO WHERE idDepto = ".$this->db->escape($idDepto);
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
		
		$sql = "SELECT idDepto, nombreDepto FROM DEPARTAMENTO WHERE idDepto = ".$this->db->escape($idDepto);
		$query = $this->db->query($sql);		
	
		$i = 0;
		if($query){
			if($query->num_rows > 0){							
				foreach ($query->result() as $row){		
					$response->rows[$i]["id"] = $row->idDepto;
					$response->rows[$i]["cell"] = array($row->idDepto, $row->nombreDepto);
					$i++;				
				}										
			}			
		}
		
		return $response;
	}
	
}
