<?php
class loginModel extends CI_Model{
	
	
	function validateUser(){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "", "data"=>array(), "roleData"=>array());
		
		$username = $this->input->post("username");
		$password = $this->input->post("password");	
		
		$sqlUserData = "SELECT u.idUsuario, u.primerNombre, u.primerApellido
				FROM USUARIO u INNER JOIN ROL_USUARIO ru ON u.idUsuario = ru.idUsuario
				WHERE u.username =".$this->db->escape($username)." AND u.password =". $this->db->escape($password);
		
		$sqlRoleData = "SELECT r.idRol, r.nombreRol
						FROM ROL r INNER JOIN ROL_USUARIO ru ON r.idRol = ru.idROl
						WHERE ru.idUsuario =";
		
		
		$query1 = $this->db->query($sqlUserData );
		
		if($query1) {	
					
	    	$retArray["data"] = $query1->row_array();
	    	    	
	    	if(count($retArray["data"]) > 0){
	    		
	    		$sqlRoleData.=$this->db->escape($retArray['data']['idUsuario']);
	    		$query2 = $this->db->query($sqlRoleData);
	    		
	    		if($query2){
	    			
					if($query2->num_rows > 0){		
							
						foreach ($query2->result() as $row){		
							$rowArray = array();
							$rowArray["id"] = $row->idRol;
							$rowArray["value"] = $row->nombreRol;					
							$retArray["roleData"][] = $rowArray;				
						}		
											
					}
					
				}
				else{
					$retArray["status"] = $this->db->_error_number();
					$retArray["msg"] = $this->db->_error_message();
				}    		
	    		
	    	}
	    }
	    else{
	    	$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
	    	
	    }
	       
	    return $retArray;
	}
	
	
//--------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	function readRolesAutocomplete(){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
		
		$sql = "SELECT idRol, nombreRol FROM ROL";
		$query = $this->db->query($sql);		
	
		if($query){
			if($query->num_rows > 0){			
				foreach ($query->result() as $row){		
					$rowArray = array();
					$rowArray["id"] = $row->idRol;
					$rowArray["value"] = $row->nombreRol;					
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
	
?>