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
		
		$sql = "SELECT COUNT(*) AS count  FROM NOTIFICACION";
		
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
		
		$sql = "SELECT n.idNotificacion idNotificacion, n.subject subject, n.fechaNotificacion fechaNotificacion, uxn.idEstado idEstado
				FROM NOTIFICACION n INNER JOIN USUARIO_NOTIFICACION uxn ON n.idNotificacion = uxn.idNotificacion
    				INNER JOIN USUARIO u ON uxn.idUsuario = u.idUsuario INNER JOIN ESTADO e ON uxn.idEstado = e.idEstado
    				INNER JOIN TIPO_ESTADO te ON e.idTipoEstado = te.idTipoEstado
				WHERE u.idUsuario = " .$idUsuario.
				" ORDER BY n.fechaNotificacion";
		
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
				$response->rows[$i]["cell"] = array($row->subject, $row->fechaNotificacion, $row->idEstado);
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
	
}