<?php
class uploadModel extends CI_Model{
	
	//Para completar el nombre que tendrá el  archivo a subir
	function fileNameCorrelative($uploadIdName, $uploadIdValue){
		$this->load->database();

		$retArray = array("status"=> 0, "msg" => "", data => "");
		
		$sql = "SELECT COUNT(idArchivo) AS countId FROM ARCHIVOS WHERE $uploadIdName = ".$this->db->escape($uploadIdValue);
		$query = $this->db->query($sql);
		
		
		if (!$query){
	     	$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
			return $retArray;
	    }	
		
		if ($query->num_rows() > 0){
			$row = $query->row();				
			$countId  = $row->countId;
			
			$retArray["data"] = $countId+1;
			
		}
		return $retArray;		
	}
	
}