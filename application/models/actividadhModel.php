<?php

class ActividadhModel extends CI_Model{
	
	function proyRead($idUsuario,$idRol){
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
		
		$this->load->database();		
		//Verificando correcta conexión a la base de datos
		if (!$this->db->conn_id) {
			$retArray["status"] = 2;
			$retArray["msg"] = database_cn_error_msg();
			return $retArray;
		}
		
		if($idRol == 1){
			$sql = "SELECT nombreProyecto, idProyecto
					FROM PROYECTO";
			$query = $this->db->query($sql);
		}
		else{
			$sql = "SELECT p.nombreProyecto, p.idProyecto
					FROM PROYECTO p INNER JOIN USUARIO u ON p.idUsuarioEncargado = u.idUsuario 
					WHERE u.idUsuario = " .$idUsuario;
			$query = $this->db->query($sql);
		}	
	
		if($query){
			if($query->num_rows > 0){			
				foreach ($query->result() as $row){		
					$rowArray = array();
					$rowArray["id"] = $row->idProyecto;
					$rowArray["value"] = $row->nombreProyecto;
										
					$retArray["data"][] = $rowArray;				
				}							
			}
		}
		else{
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = (database_error_msg()!="")?database_error_msg():$this->db->_error_message();
		}		
		return $retArray;
	}
	
	function actProyRead($idProyecto){
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
		
		$this->load->database();		
		//Verificando correcta conexión a la base de datos
		if (!$this->db->conn_id) {
			$retArray["status"] = 2;
			$retArray["msg"] = database_cn_error_msg();
			return $retArray;
		}
		
		$sql = "SELECT DISTINCT a.idActividad, a.nombreActividad
				FROM ACTIVIDAD a INNER JOIN ACTIVIDAD_PROYECTO axp ON a.idActividad = axp.idActividad
					INNER JOIN PROYECTO pt ON axp.idProyecto = pt.idProyecto
				WHERE pt.idProyecto = ".$idProyecto;
		
		$query = $this->db->query($sql);		
	
		if($query){
			if($query->num_rows > 0){			
				foreach ($query->result() as $row){		
					$rowArray = array();
					$rowArray["id"] = $row->idActividad;
					$rowArray["value"] = $row->nombreActividad;
										
					$retArray["data"][] = $rowArray;				
				}							
			}
		}
		else{
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = (database_error_msg()!="")?database_error_msg():$this->db->_error_message();
		}		
		return $retArray;
	}
	
	function actividadBitacora($idActividad){
		$this->load->database();
		
		$page = $this->input->post("page");
		$limit = $this->input->post("rows");
		$sidx = $this->input->post("sidx");
		$sord = $this->input->post("sord");
		$count = 0;
		if(!$sidx) $sidx =1;
		
		$sql = "SELECT COUNT(*) AS count FROM BITACORA WHERE idActividad = " .$idActividad;
		
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
		
		$sql = "SELECT CONCAT_WS(' ',u.primerNombre,u.primerApellido) AS nombre, b.comentario, b.progreso, e.estado, b.fechaReg
				FROM BITACORA b INNER JOIN USUARIO u ON b.idUsuario = u.idUsuario
					INNER JOIN ESTADO e ON b.idEstado = e.idEstado
				WHERE b.idActividad = " .$idActividad.
				" ORDER BY b.ultimoRegistro DESC";
		
		$query = $this->db->query($sql);
		
		$i = 0;
		if($query->num_rows > 0){			
			foreach ($query->result() as $row){		
				//$rowArray = array();
				//$rowArray["subject"] = $row->subject;
				//$rowArray["fechaNotificacion"] = $row->fechaNotificacion;
				//$rowArray["idEstado"] = $row->idEstado;
				//$retArray["data"][] = $rowArray;
				$response->rows[$i]["id"] = i;
				$response->rows[$i]["cell"] = array($row->nombre, $row->comentario, $row->progreso, $row->estado, $row->fechaReg);
				$i++;		
			}							
		}
		
		else{
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = (database_error_msg()!="")?database_error_msg():$this->db->_error_message();
		}
		
		//return $retArray;
		return $response;
	}
	
}