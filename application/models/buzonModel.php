<?php

class buzonModel extends CI_Model{
	
	function read(){
		$this->load->database();
		$retArray = array("status" => 0, "msg" => "", "data" => array());
		$idNotificacion = $this->input->post("idNotificacion");
		
		$sql = "SELECT notificacion, subject FROM NOTIFICACION WHERE idNotificacion = " .$idNotificacion;
		
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