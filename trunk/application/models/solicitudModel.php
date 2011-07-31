<?php

class solicitudModel extends CI_Model {
	
	function saveValidation(){
		$this->load->library('form_validation');
		
		$retArray = array("status"=> 0, "msg" => "");
		
		//Colocando las reglas para los campos, el segundo par�metro es el nombre del campo que aparecer� en el mensaje
		//Habr� que reemplazar los mensajes, pues por el momento est�n en ingl�s
		$this->form_validation->set_rules("asunto", "Asunto", 'required|alpha');
		$this->form_validation->set_rules("descripcion", "Descripcion", 'required|alpha');		
		
		if ($this->form_validation->run() == false){//Si al menos una de las reglas no se cumpli�...
			//Concatenamos en $msg los mensajes de errores generados para cada campo, lo tenga o no
			$retArray["status"] = 1;
			
			$retArray["msg"] .= form_error("asunto");
			$retArray["msg"] .= form_error("descripcion");			
		}
		
		return $retArray;
	}
	
	function create() {
		$this->load->database();
		$this->load->library('session');
		
		$retArray = array("status"=> 0, "msg" => "");
		
		$asunto = $this->input->post("asunto");
		$prioridad = $this->input->post("prioridad");
		$descripcion = $this->input->post("descripcion");
		$anioSolicitud = strftime('%Y');
		$correlAnio = 1;
		
		$queryId = "SELECT MAX(s.anioSolicitud) maxAnio FROM SOLICITUD s";
		$result = $this->db->query($queryId);
		
		if($result->num_rows() > 0) {
			$maxAnio = 0;
			
			$row = $result->row();
			$maxAnio = $row->maxAnio;
			
			if (intval($anioSolicitud) == $maxAnio) {
				
				$queryId = "SELECT MAX(s.correlAnio) + 1 correlAnio FROM SOLICITUD s " .
							"WHERE s.anioSolicitud = " . $this->db->escape(intval($anioSolicitud));
				$result2 = $this->db->query($queryId);
				if($result2->num_rows() > 0) {
					$row = $result2->row();
					$correlAnio = $row->correlAnio;
				}
			} 
		}
		
		$idInteresados = explode(',', $this->input->post("observadores"));
		
		
		$sql = "INSERT INTO SOLICITUD (anioSolicitud, correlAnio, tituloSolicitud, descripcionSolicitud, activo, idPrioridadCliente, idPrioridadInterna) 
   				VALUES (" . 
						$this->db->escape(intval($anioSolicitud)) . ", " . 
						$this->db->escape($correlAnio).", ". 
						$this->db->escape($asunto) . ", " .
						$this->db->escape($descripcion) . ", " .
						$this->db->escape(1) . ", " .
						$this->db->escape(intval($prioridad)) . ", " . 
						$this->db->escape(intval($prioridad)) . ")";
		
		$sql2 = "INSERT INTO USUARIO_SOLICITUD (idUsuario, anioSolicitud, correlAnio, esAutor) VALUES (" . 
					$this->db->escape($this->session->userdata("idUsuario")) . ", " . 
					$this->db->escape(intval($anioSolicitud)) . ", " . 
					$this->db->escape($correlAnio) . "," . 
					$this->db->escape(1) . ")";
		
		foreach ($idInteresados as $idUser){
			if($idUser != '') {
			$sql2 .= ",(" . $this->db->escape($idUser) . ", " . 
					$this->db->escape($anioSolicitud) . ", " . 
					$this->db->escape($correlAnio) . "," . 
					$this->db->escape(0) . ")";
			}
		}
		
		
		$this->db->trans_begin();
		//$query = $this->db->query($sql);
		$this->db->query($sql);
		$this->db->query($sql2);
		
		//if (!$query){
		if($this->db->trans_status() == FALSE) {
	     	$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
			$this->db->trans_rollback();
	    } else {
	    	$this->db->trans_commit();
	    }
	    
	    
	    
		return $retArray;
	}
	
	function getSolicitud () {
		$this->load->database();
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());

		//array con la clave de la solicitud -> anioSolicitud-correlAnio
		$solicitudIds = explode("-", $this->input->post("idSolicitud"));
		
		$query = "SELECT " .
						"s.tituloSolicitud titulo, s.descripcionSolicitud descripcion, s.fechaEntrada fechaEntrada, p.nombrePrioridad prioridadCliente, " .
						"CONCAT_WS(' ', u.primerNombre, u.otrosNombres, u.primerApellido, u.otrosApellidos) cliente, " .
						"c.nombreCargo cargo, d.nombreDepto depto, " .
						"us.esAutor " .
					"FROM SOLICITUD s " .
					"INNER JOIN USUARIO_SOLICITUD us ON (s.anioSolicitud = us.anioSolicitud AND s.correlAnio = us.correlAnio) " .
					"INNER JOIN USUARIO u ON (u.idUsuario = us.idUsuario) " .
					"INNER JOIN CARGO c ON (u.idCargo = c.idCargo) " .
					"INNER JOIN DEPARTAMENTO d ON (u.idDepto = d.idDepto) " .
					"INNER JOIN PRIORIDAD p ON (p.idPrioridad = s.idPrioridadCliente) " .
					"WHERE s.anioSolicitud = ? AND s.correlAnio = ? " .
					"AND CONCAT_WS('-', s.anioSolicitud, s.correlAnio) NOT IN (" .
						"SELECT CONCAT_WS('-', a.anioSolicitud, a.correlAnio) " .
						"FROM ACTIVIDAD a " .
						"WHERE a.anioSolicitud = ? AND a.correlAnio = ?)" .
					"ORDER BY esAutor DESC";
		
		$result = $this->db->query($query, array($solicitudIds[0], $solicitudIds[1], $solicitudIds[0], $solicitudIds[1]));
		
		$solicitudes = array();
		
		if ($result) {
			if($result->num_rows() > 0) {
				foreach ($result->result() as $row) {

					$retArray["data"][] = $row;
					
				}
			}
		} else{
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
		}
		
		return $retArray;
		
	}
	
	function gridSolicitudRead($id=null){
		$this->load->database();		
		
		$page = $this->input->post("page");
		$limit = $this->input->post("rows");
		$sidx = $this->input->post("sidx");
		$sord = $this->input->post("sord");
		$count = 0;		
		if(!$sidx) $sidx =1;
		
		// $idDepto = is_null($idDepto) ? -1 : $idDepto;
		
		
		$sql = "SELECT COUNT(*) AS count " .
				"FROM USUARIO u " .
				"INNER JOIN USUARIO_SOLICITUD us ON u.idUsuario = us.idUsuario " .
				"INNER JOIN SOLICITUD s ON (s.anioSolicitud = us.anioSolicitud AND s.correlAnio = us.correlAnio)";
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
		
		//-------------------------

		$sql = "SELECT s.anioSolicitud anio, s.correlAnio correl, s.tituloSolicitud titulo, CONCAT(u.primerNombre, ' ', u.primerApellido) usuarioSolicitante, s.fechaEntrada fechaPeticion " .
				"FROM USUARIO u " .
				"INNER JOIN USUARIO_SOLICITUD us ON u.idUsuario = us.idUsuario " .
				"INNER JOIN SOLICITUD s ON (s.anioSolicitud = us.anioSolicitud AND s.correlAnio = us.correlAnio) " . 
				"WHERE esAutor=1";
		$query = $this->db->query($sql);		
	
		$i = 0;
		if($query){
			if($query->num_rows > 0){							
				foreach ($query->result() as $row){		
					$response->rows[$i]["id"] = $row->anio . "-" . $row->correl;
					$response->rows[$i]["cell"] = array($row->fechaPeticion, $row->titulo, $row->usuarioSolicitante, $row->anio, $row->correl);
					$i++;				
				}										
			}			
		}
		
		return $response;
	}
}