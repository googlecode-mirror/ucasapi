<?php

class actividadModel extends CI_Model{
	
	function read(){
		$this->load->database();
		
		$retArray = array("status" => 0, "msg" => "");
		
		$idActividad = $this->input->post("idActividad");
		$idProyecto = $this->input->post("idProyecto");
		$idUsuario = $this->input->post("idUsuario");
		
		$sql = "SELECT p.nombreProyecto, a.nombreActividad, a.descripcionActividad, e.estado, b.progreso, b.comentario
				 FROM Proyecto p INNER JOIN Actividad_Proyecto axp ON p.idProyecto = axp.idProyecto INNER JOIN Actividad a
    			 ON axp.idActividad = a.idActividad INNER JOIN Estado e ON a.idEstado = e.idEstado INNER JOIN Bitacora b 
    			 ON a.idActividad = b.idActividad
				 WHERE b.correlativoBitacora = (SELECT MAX(correlativoBitacora) FROM Bitacora WHERE idActividad = ".$idActividad." AND idUsuario = ".$idUsuario.") 
				 AND a.idActividad = " .$idActividad. " AND p.idProyecto = " .$idProyecto;
				
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
	
	function update(){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "");
		
		$idEstado = $this->input->post("idEstado");
		$idUsuario = $this->input->post("idUsuario");
		$idActividad = $this->input->post("idActividad");
		$progreso = $this->input->post("progreso");
		$comentario = $this->input->post("comentario");
		
		$sql = "UPDATE ACTIVIDAD SET idEstado = ".$idEstado." WHERE idActividad = ".$idActividad; 
		$query = $this->db->query($sql);
		$sql = "CALL sp_insert_bitacora(".$idActividad.",".$idUsuario.",".$progreso.",".$this->db->escape($comentario).",1,1)";
		$query = $this->db->query($sql);
		
		if (!$query) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
	    }
		
		return $retArray;
	}
	
	function saveValidation(){
		$this->load->library('form_validation');
		
		$retArray = array("status"=> 0, "msg" => "");
		
		//Colocando las reglas para los campos, el segundo parámetro es el nombre del campo que aparecerá en el mensaje
		//Habrá que reemplazar los mensajes, pues por el momento están en inglés
		$this->form_validation->set_rules("comentario", "Comentario", 'alpha');

		if ($this->form_validation->run() == false){//Si al menos una de las reglas no se cumplió...
			//Concatenamos en $msg los mensajes de errores generados para cada campo, lo tenga o no
			$retArray["status"] = 1;
			$retArray["msg"] .= form_error("comentario");			
		}
		
		return $retArray;
	}
	
}
