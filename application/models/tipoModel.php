<?php

class tipoModel extends CI_Model{
	
	function autocompleteRead(){
		$this->load->database();
		$retArray = array("status" => 0, "msg" => "", "data" => array());
		
		$sql = "SELECT idTipo, tipo FROM TIPO";
		$query = $this->db->query($sql);
		
		if($query){
			if($query->num_rows > 0){
				foreach ($query->result() as $row){
					$rowArray = array();
					$rowArray["id"] = $row->idTipo;
					$rowArray["value"] = $row->tipo;
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

	function saveValidation(){
		$this->load->library('form_validation');
		
		$retArray = array("status"=> 0, "msg" => "");
		
		$this->form_validation->set_rules("nombreTipo", "Nombre", 'required|alpha');	
		
		if($this->form_validation->run() == false){
			$retArray["status"] = 1;
			
			$retArray["msg"] .= form_error("nombreTipo");
		}
		
		return $retArray;
	}
	
	function delete(){
		$this->load->database();
		
		$retArray = array("status" => "0", "msg" => "");
		$idTipo = $this->input->post("idTipo");
		
		$sql = "DELETE FROM TIPO WHERE idTipo = " .$idTipo;
		
		$query = $this->db->query($sql);
		
		if (!$query) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
	    }
		
		return $retArray;
		
	}
	
	function update(){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "");
		
		$idTipo = $this->input->post("idTipo");
		$nombreTipo = $this->input->post("nombreTipo");		
		
		$sql = "UPDATE TIPO SET tipo = ".$this->db->escape($nombreTipo)." WHERE idTipo = " .$idTipo; 
		
		$query = $this->db->query($sql);
		
		if (!$query) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
	    }
		
		return $retArray;		
	}

	function create(){
		$this->load->database();
		
		$retArray = array("status" => 0, "msg" => "");
		
		$nombreTipo = $this->input->post("nombreTipo");
		
		$sql = "INSERT INTO TIPO(tipo) VALUES(" .$this->db->escape($nombreTipo). ")";
		
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
		$idTipo = $this->input->post("idTipo");
		
		$sql = 	"SELECT tipo FROM TIPO WHERE idTipo = " .$idTipo;
		
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
	
	
	
}