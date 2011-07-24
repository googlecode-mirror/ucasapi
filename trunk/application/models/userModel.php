<?php
class userModel extends CI_Model{
	
	
	function validateUser(){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "");
		
		$username = $this->input->post("username");
		$password = $this->input->post("password");	
		
		$sql = "SELECT u.idUsuario, u.primerNombre, u.primerApellido, ru.idRol 
				FROM USUARIO u INNER JOIN ROL_USUARIO ru ON u.idUsuario = ru.idUsuario
				WHERE u.username =".$this->db->escape($username)." AND u.password =". $this->db->escape($password);		
		
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
	
}
	
?>