<?php

class solicitudModel extends CI_Model {
	
	function saveValidation(){
		$this->load->library('form_validation');
		//print_r($_POST);
		
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
		//$correlAnio = $anioSolicitud . time();
		$correlAnio = time();
		$idInteresados = explode(',', $this->input->post("usuariosInteresados"));
		echo $idInteresados;
		$sql = "INSERT INTO SOLICITUD (anioSolicitud, correlAnio, tituloSolicitud, descripcionSolicitud, activo, idPrioridadCliente) 
   				VALUES (" . 
						$this->db->escape(intval($anioSolicitud)) . ", " . 
						$this->db->escape(intval($correlAnio)).", ". 
						$this->db->escape($asunto) . ", " .
						$this->db->escape($descripcion) . ", " .
						$this->db->escape(1) . ", " .
						$this->db->escape($prioridad) . ")";
		
		$sql2 = "INSERT INTO USUARIO_SOLICITUD (idUsuario, anioSolicitud, correlAnio) VALUES (" . 
					$this->db->escape($this->session->userdata("idUsuario")) . ", " . 
					$this->db->escape($anioSolicitud) . ", " . 
					$this->db->escape($correlAnio) . ")";
		
		foreach ($idInteresados as $idUser){
			$sql2 .= ",(" . $this->db->escape($idUser) . ", " . 
					$this->db->escape($anioSolicitud) . ", " . 
					$this->db->escape($correlAnio) .  ")";
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
}