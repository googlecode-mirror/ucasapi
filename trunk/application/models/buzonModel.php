<?php

class buzonModel extends CI_Model{
	
	function read($idUsuario){
		$this->load->database();
		
		$page = $this->input->post("page");
		$limit = $this->input->post("rows");
		$sidx = $this->input->post("sidx");
		$sord = $this->input->post("sord");
		$count = 0;
		if(!$sidx) $sidx =1;
		
		$sql = "SELECT COUNT(*) AS count FROM NOTIFICACION";
		
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
		
		//-------------------------------------------------------------------
		
		$retArray = array("status" => 0, "msg" => "", "data" => array());
		$idNotificacion = $this->input->post("idNotificacion");
		
		$sql = "SELECT n.idNotificacion, n.subject, uxn.horaEntrada, uxn.idEstado
				FROM NOTIFICACION n INNER JOIN USUARIO_NOTIFICACION uxn ON n.idNotificacion = uxn.idNotificacion
    				INNER JOIN USUARIO u ON uxn.idUsuario = u.idUsuario INNER JOIN ESTADO e ON uxn.idEstado = e.idEstado
    				INNER JOIN TIPO_ESTADO te ON e.idTipoEstado = te.idTipoEstado
				WHERE u.idUsuario = " .$idUsuario.
				" ORDER BY uxn.horaEntrada DESC";
		
		$query = $this->db->query($sql);
		
		$i = 0;
		if($query->num_rows > 0){			
			foreach ($query->result() as $row){		
				//$rowArray = array();
				//$rowArray["subject"] = $row->subject;
				//$rowArray["fechaNotificacion"] = $row->fechaNotificacion;
				//$rowArray["idEstado"] = $row->idEstado;
				//$retArray["data"][] = $rowArray;
				$response->rows[$i]["id"] = $row->idNotificacion;
				$response->rows[$i]["cell"] = array($row->subject, $row->horaEntrada, $row->idEstado);
				$i++;		
			}							
		}
		
		else{
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
		}
		
		//return $retArray;
		return $response;
	}
	
	function readMensaje(){
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
		
		$this->load->database();		
		//Verificando correcta conexión a la base de datos
		if (!$this->db->conn_id) {
			$retArray["status"] = 2;
			$retArray["msg"] = database_cn_error_msg();
			return $retArray;
		}
		$idNotificacion = $this->input->post("idNotificacion");
		$idUsuario = $this->input->post("idUsuario");
		
		$sql = "SELECT n.subject, n.notificacion
				FROM NOTIFICACION n INNER JOIN USUARIO_NOTIFICACION uxn ON n.idNotificacion = uxn.idNotificacion
    				INNER JOIN USUARIO u ON uxn.idUsuario = u.idUsuario
				WHERE u.idUsuario = ".$idUsuario." AND n.idNotificacion = ".$idNotificacion;
		
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
	
	function updateMessage($idN){
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
		
		$this->load->database();		
		//Verificando correcta conexión a la base de datos
		if (!$this->db->conn_id) {
			$retArray["status"] = 2;
			$retArray["msg"] = database_cn_error_msg();
			return $retArray;
		}
		$idUsuario = $this->input->post("idUsuario");
		
		$sql = "UPDATE USUARIO_NOTIFICACION SET idEstado = 17, horaEntrada = horaEntrada WHERE idNotificacion = ".$idN." AND idUsuario = ".$idUsuario;
		
		$query = $this->db->query($sql);
		if(!$query){
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = (database_error_msg()!="")?database_error_msg():$this->db->_error_message();
		}
		
		return $retArray;
		
	}
	
}