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
		$descripcion = $this->input->post("descripcion");


		$sql = "INSERT INTO PROYECTO (idUsuario, nombreProyecto, fechaPlanIni, fechaPlanFin, fechaRealIni, fechaRealFin, activo, descripcion)
   				VALUES (".$this->db->escape($idUsuarioDuenho).", ".$this->db->escape($nombreProyecto)."
   				, ".$this->db->escape($fechaPlanIni).", ".$this->db->escape($fechaPlanFin)."
   				, ".$this->db->escape($fechaRealIni).", ".$this->db->escape($fechaRealFin)."
   				, ".$this->db->escape($activo).", ".$this->db->escape($descripcion).")";

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

		$sql = "SELECT p.idProyecto, p.idUsuario, p.nombreProyecto, p.fechaPlanIni, p.fechaPlanFin, p.fechaRealIni, p.fechaRealFin, p.activo, CONCAT(u.primerNombre,' ',u.OtrosNombres,' ',u.primerApellido,' ',u.otrosApellidos,' ') nombreUsuario, p.descripcion descripcion 
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
		$descripcion = $this->input->post("descripcion");
		$activo = $this->input->post("activo");

		$sql = "UPDATE PROYECTO
				SET idUsuario = ".$this->db->escape($idUsuarioDuenho).",
					nombreProyecto = ".$this->db->escape($nombreProyecto).",
					fechaPlanIni = ".$this->db->escape($fechaPlanIni).",	
					fechaPlanFin = ".$this->db->escape($fechaPlanFin).",	
					fechaRealIni = ".$this->db->escape($fechaRealIni).",	
					fechaRealFin = ".$this->db->escape($fechaRealFin).",		
					activo = ".$this->db->escape($activo).",
					descripcion=".$this->db->escape($descripcion)."
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
	
	
	/*-------------------------- FUNCIONES PARA ARCHIVOS -------------------------------*/
	//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	//Validación para campos de información de documento
	function fileSaveValidation(){
		$this->load->library('form_validation');
		$retArray = array("status"=> 0, "msg" => "");
		$this->form_validation->set_rules("descripcion", "Descripcion", 'alpha ');

		if ($this->form_validation->run() == false){
			$retArray["status"] = 1;
			$retArray["msg"] .= form_error("descripcion");
		}
		return $retArray;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	function createProjectFile(){
		$this->load->database();
		$retArray = array("status"=> 0, "msg" => "");
		$idProyecto = $this->input->post("idProyecto");
		$nombreArchivo = $this->input->post("nombreArchivo");
		$descripcion = $this->input->post("descripcion");
		$sql = "INSERT INTO ARCHIVOS (idProyecto, nombreArchivo, descripcion)
    VALUES (".$this->db->escape($idProyecto).", ".$this->db->escape($nombreArchivo).", ".$this->db->escape($descripcion).")";
		$query = $this->db->query($sql);
		if (!$query){
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
		}
			
		return $retArray;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	function updateProjectFile(){
		$this->load->database();
		$retArray = array("status"=> 0, "msg" => "");
		$idArchivo = $this->input->post("idArchivo");
		$descripcion = $this->input->post("descripcion");
		$sql = "UPDATE ARCHIVOS
SET descripcion = ".$this->db->escape($descripcion)."
WHERE idArchivo = ". $idArchivo; 
		$query = $this->db->query($sql);
		if (!$query) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
		}
		return $retArray;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	function fileDataDelete(){
		$this->load->database();
		$retArray = array("status"=> 0, "msg" => "");
		$idArchivo = $this->input->post("idArchivo");
		$sql = "DELETE FROM ARCHIVOS
WHERE idArchivo = ". $idArchivo;
			
		$query = $this->db->query($sql);
		if (!$query) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
		}
		return $retArray;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	function projectFilesRead($idProyecto=null){
		$this->load->database();
		$this->load->helper(array('url'));
		$page = $this->input->post("page");
		$limit = $this->input->post("rows");
		$sidx = $this->input->post("sidx");
		$sord = $this->input->post("sord");
		$count = 0;
		if(!$sidx) $sidx =1;
		$idProyecto = is_null($idProyecto) ? -1 : $idProyecto;
		$sql = "SELECT COUNT(*) AS count FROM ARCHIVOS WHERE idProyecto = ".$this->db->escape($idProyecto);
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
		$sql = "SELECT idArchivo, nombreArchivo, descripcion FROM ARCHIVOS WHERE idProyecto = ".$this->db->escape($idProyecto);
		$query = $this->db->query($sql);
		$i = 0;
		if($query){
			if($query->num_rows > 0){
				foreach ($query->result() as $row){
					$response->rows[$i]["id"] = $i+1;
					$response->rows[$i]["cell"] = array($row->idArchivo,$row->nombreArchivo, $row->descripcion);
					$i++;
				}
			}
		}
		return $response;
	}
	

}