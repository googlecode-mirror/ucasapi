<?php

class faseModel extends CI_Model{
	
	function autocompleteRead(){
		$this->load->database();
		
		$retArray = array("status" => 0, "msg" => "", "data" => array());
		
		$sql = "SELECT idFase, nombreFase FROM FASE";
		$query = $this->db->query($sql);
		
		if($query){
			if($query->num_rows > 0){
				foreach ($query->result() as $row){
					$rowArray = array();
					$rowArray["id"] = $row->idFase;
					$rowArray["value"] = $row->nombreFase;
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
	
	function delete(){
		$this->load->database();
		
		$retArray = array("status" => "0", "msg" => "");
		$idFase = $this->input->post("idFase");
		
		$sql = "DELETE FROM FASE WHERE idFase = " .$idFase;
		
		$query = $this->db->query($sql);
		
		if (!$query) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
	    }
		
		return $retArray;
		
	}
	
	function saveValidation(){
		$this->load->library('form_validation');
		
		$retArray = array("status"=> 0, "msg" => "");
		
		$this->form_validation->set_rules("nombreFase", "Nombre", 'required|alpha');
		$this->form_validation->set_rules("descripcion", "Descripcion", 'alpha');	
		
		if($this->form_validation->run() == false){
			$retArray["status"] = 1;
			
			$retArray["msg"] .= form_error("nombreFase");
			$retArray["msg"] .= form_error("descripcion");
		}
		
		return $retArray;
	}
	
	function create(){
		$this->load->database();
		
		$retArray = array("status" => 0, "msg" => "");
		
		$nombreFase = $this->input->post("nombreFase");
		$descripcion = $this->input->post("descripcion");
		
		$sql = "INSERT INTO FASE (nombreFase, descripcion) VALUES(" .$this->db->escape($nombreFase). "," .$this->db->escape($descripcion). ")";
		
		$query = $this->db->query($sql);
		
		if(!$query){
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
		}		
		
		return $retArray;
	}
	
	function read(){
		$this->load->database();
		
		$retArray = array("status" => 0, "msg" => "", "data" => array());
		$idFase = $this->input->post("idFase");
		
		$sql = 	"SELECT nombreFase, descripcion FROM FASE WHERE idFase = " .$idFase;
		
		$query = $this->db->query($sql);
		
		if($query){
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
		
		$idFase = $this->input->post("idFase");
		$nombreFase = $this->input->post("nombreFase");
		$descripcion = $this->input->post("descripcion");		
		
		$sql = "UPDATE FASE SET nombreFase = ".$this->db->escape($nombreFase).", descripcion = ".$this->db->escape($descripcion). " WHERE idFase = " .$idFase; 
		
		$query = $this->db->query($sql);
		
		if (!$query) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
	    }
		
		return $retArray;		
	}
	
	
}
