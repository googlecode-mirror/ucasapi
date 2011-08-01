<?php
class proyectoModel extends CI_Model{


	function create(){
		$this->load->database();

		$retArray = array("status"=> 0, "msg" => "");

		$idUsuarioDuenho = $this->input->post("idUsuarioDuenho");
		$nombreProyecto = $this->input->post("nombreProyecto");
		$fechaPlanIni = $this->input->post("fechaPlanIni");
		$fechaPlanFin = $this->input->post("fechaPlanFin");
		$fechaRealIni = $this->input->post("fechaRealIni");
		$fechaRealFin = $this->input->post("fechaRealFin");
		$activo = $this->input->post("activo");


		$sql = "INSERT INTO PROYECTO (idUsuario, nombreProyecto, fechaPlanIni, fechaPlanFin, fechaRealIni, fechaRealFin, activo)
   				VALUES (".$this->db->escape($idUsuarioDuenho).", ".$this->db->escape($nombreProyecto)."
   				, ".$this->db->escape($fechaPlanIni).", ".$this->db->escape($fechaPlanFin)."
   				, ".$this->db->escape($fechaRealIni).", ".$this->db->escape($fechaRealFin)."
   				, ".$this->db->escape($activo).")";

		$query = $this->db->query($sql);

		if (!$query){
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
		}
	  
		return $retArray;
	}


	function read(){
		$this->load->database();

		$retArray = array("status"=> 0, "msg" => "", "data"=>array());

		$idProyecto = $this->input->post("idProyecto");

		$sql = "SELECT p.idProyecto, p.idUsuario, p.nombreProyecto, p.fechaPlanIni, p.fechaPlanFin, p.fechaRealIni, p.fechaRealFin, p.activo, CONCAT(u.primerNombre,' ',u.OtrosNombres,' ',u.primerApellido,' ',u.otrosApellidos,' ') nombreUsuario 
				FROM PROYECTO p, USUARIO u
				WHERE p.idUsuario = u.idUsuario AND
				idProyecto = ".$idProyecto;

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

		$idProyecto = $this->input->post("idProyecto");

		$idUsuarioDuenho = $this->input->post("idUsuarioDuenho");
		$nombreProyecto = $this->input->post("nombreProyecto");
		$fechaPlanIni = $this->input->post("fechaPlanIni");
		$fechaPlanFin = $this->input->post("fechaPlanFin");
		$fechaRealIni = $this->input->post("fechaRealIni");
		$fechaRealFin = $this->input->post("fechaRealFin");
		$activo = $this->input->post("activo");

		$sql = "UPDATE PROYECTO
				SET idUsuario = ".$this->db->escape($idUsuarioDuenho).",
					nombreProyecto = ".$this->db->escape($nombreProyecto).",
					fechaPlanIni = ".$this->db->escape($fechaPlanIni).",	
					fechaPlanFin = ".$this->db->escape($fechaPlanFin).",	
					fechaRealIni = ".$this->db->escape($fechaRealIni).",	
					fechaRealFin = ".$this->db->escape($fechaRealFin).",		
					activo = ".$this->db->escape($activo)."
					WHERE idProyecto = ". $idProyecto; 

		$query = $this->db->query($sql);

		if (!$query) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
		}

		return $retArray;
	}


	function delete(){
		$this->load->database();

		$retArray = array("status"=> 0, "msg" => "");

		$idProyecto = $this->input->post("idProyecto");

		$sql = "UPDATE PROYECTO
				SET activo = 0
				WHERE idProyecto = ". $idProyecto;
			
		$query = $this->db->query($sql);

		if (!$query) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
		}

		return $retArray;
	}


	function autocompleteRead(){
		$this->load->database();

		$retArray = array("status"=> 0, "msg" => "", "data"=>array());

		$sql = "SELECT idProyecto, nombreProyecto FROM PROYECTO";
		$query = $this->db->query($sql);

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
			$retArray["msg"] = $this->db->_error_message();
		}

		return $retArray;
	}

	// Buscar usuarios
	function autocompleteUsuarioProyectoRead(){
		$this->load->database();

		$retArray = array("status"=> 0, "msg" => "", "data"=>array());

		$sql = "SELECT idUsuario, CONCAT(primerNombre,' ', OtrosNombres,' ',primerApellido,' ',otrosApellidos) nombreUsuario FROM USUARIO WHERE activo = '1'";
		$query = $this->db->query($sql);

		if($query){
			if($query->num_rows > 0){
				foreach ($query->result() as $row){
					$rowArray = array();
					$rowArray["id"] = $row->idUsuario;
					$rowArray["value"] = $row->nombreUsuario;

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


	//Devuelve en la variable $msg, los mensajes para los errores detectados por no cumplir las validaciones aplicadas usando la librería form_validation
	function saveValidation(){
		$this->load->library('form_validation');

		$retArray = array("status"=> 0, "msg" => "");

		//Colocando las reglas para los campos, el segundo parámetro es el nombre del campo que aparecerá en el mensaje
		//Habrá que reemplazar los mensajes, pues por el momento están en inglés
		$this->form_validation->set_rules("nombreProyecto", "Nombre proyecto", 'required');
		$this->form_validation->set_rules("idUsuarioDuenho", "Dueño del proyecto", 'required');

		if ($this->form_validation->run() == false){//Si al menos una de las reglas no se cumplió...
			//Concatenamos en $msg los mensajes de errores generados para cada campo, lo tenga o no
			$retArray["status"] = 1;
				
			$retArray["msg"] .= form_error("nombreProyecto");
			$retArray["msg"] .= form_error("idUsuarioDuenho");
		}

		return $retArray;
	}

}