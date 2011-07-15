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
	
	
}