<?php

class historicoUsuarioModel extends CI_Model{


	function create(){

		$idUsuario = $this->input->post("idUsuario");

		$this->load->database();

		$retArray = array("status"=> 0, "msg" => "");

		$fechaInicioContrato = $this->input->post("fechaInicioContrato");
		$fechaFinContrato = $this->input->post("fechaFinContrato");
		$tiempoContrato = $this->input->post("tiempoContrato");
		$nuevoCorrel = 1;

		$sqlCorrel = "SELECT MAX(correlUsuarioHistorico)+1 lastCorrel FROM USUARIO_HISTORICO WHERE idUsuario = '".$idUsuario."'";
		$query = $this->db->query($sqlCorrel);
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			$nuevoCorrel = $row->lastCorrel;
		}
		if($nuevoCorrel == null)
		$nuevoCorrel = 1;

		$this->db->trans_begin();

		$sql = "INSERT INTO USUARIO_HISTORICO (idUsuario, correlUsuarioHistorico, fechaInicioContrato, fechaFinContrato, tiempoContrato, activo)
				VALUES (".$this->db->escape($idUsuario)."
				, ".$this->db->escape($nuevoCorrel)."
				, ".$this->db->escape($fechaInicioContrato)."
				, ".$this->db->escape($fechaFinContrato)."
				, ".$this->db->escape($tiempoContrato).", 1)";

		$this->db->query($sql);
			
		if($this->db->trans_status() == FALSE) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
		return $retArray;
	}

	function createRol(){

		$idUsuario = $this->input->post("idUsuario");
		$correlUsuarioHistorico = $this->input->post("correlUsuarioHistorico");
		$idRol = $this->input->post("idRol");

		$this->load->database();

		$retArray = array("status"=> 0, "msg" => "");

		$fechaInicio = $this->input->post("fechaInicio");
		$fechaFin = $this->input->post("fechaFin");
		if($fechaFin == ""){
			$fechaFin = null;
		}
		$salario = $this->input->post("salario");
		if($salario == ""){
			$salario = null;
		}
		$nuevoCorrel = 1;

		$this->db->trans_begin();

		$sql = "INSERT INTO ROL_HISTORICOS (idRolHistorico, salario, fechaInicio, fechaFin, correlUsuarioHistorico, idUsuario, idRol)
				VALUES (DEFAULT,".$this->db->escape($salario)."
				, ".$this->db->escape($fechaInicio)."
				, ".$this->db->escape($fechaFin)."
				, ".$this->db->escape($correlUsuarioHistorico)."
				, ".$this->db->escape($idUsuario)."
				, ".$this->db->escape($idRol).")";

		$this->db->query($sql);
			
		if($this->db->trans_status() == FALSE) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
		return $retArray;
	}


	function read(){
		$this->load->database();

		$retArray = array("status"=> 0, "msg" => "", "data"=>array());

		$idUsuario = $this->input->post("idUsuario");

		$sql = "SELECT idUsuario, correlUsuarioHistorico, fechaInicioContrato, fechaFinContrato, tiempoContrato, activo
				FROM USUARIO_HISTORICO 
				WHERE idUsuario = ".$idUsuario." AND activo='1'";

		$query = $this->db->query($sql);

		if ($query) {
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

		$idUsuario = $this->input->post("idUsuario");
		$correlUsuarioHistorico = $this->input->post("correlUsuarioHistorico");
		$idRol = $this->input->post("idRol");
		$fechaInicioContrato = $this->input->post("fechaInicioContrato");
		$fechaFinContrato = $this->input->post("fechaFinContrato");
		$tiempoContrato = $this->input->post("tiempoContrato");

		$sql = "UPDATE USUARIO_HISTORICO
				SET fechaInicioContrato=".$this->db->escape($fechaInicioContrato).",
				    fechaFinContrato=".$this->db->escape($fechaFinContrato).",
				    tiempoContrato=".$this->db->escape($tiempoContrato)." 			    
				     WHERE idUsuario = ". $idUsuario." AND correlUsuarioHistorico=".$correlUsuarioHistorico;	

		$query = $this->db->query($sql);
		if (!$query) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
		}

		return $retArray;
	}

	function updateRol(){
		$this->load->database();

		$retArray = array("status"=> 0, "msg" => "");

		$idUsuario = $this->input->post("idUsuario");
		$correlUsuarioHistorico = $this->input->post("correlUsuarioHistorico");
		$idRol = $this->input->post("idRol");
		$idRolHistorico = $this->input->post("idRolHistorico");
		$fechaInicio = $this->input->post("fechaInicio");
		$fechaFin = $this->input->post("fechaFin");
		$salario = $this->input->post("salario");

		if($fechaFin == ""){
			$fechaFin = null;
		}

		if($salario == ""){
			$salario = null;
		}

		$sql = "UPDATE ROL_HISTORICOS
				SET fechaInicio=".$this->db->escape($fechaInicio).",
				    fechaFin=".$this->db->escape($fechaFin).",
				    salario=".$this->db->escape($salario).",
				    idRol=".$this->db->escape($idRol)." 			    
				     WHERE idRolHistorico = ". $idRolHistorico;	

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

		$idUsuario = $this->input->post("idUsuario");
		$correlUsuarioHistorico = $this->input->post("correlUsuarioHistorico");

		$sql = "UPDATE USUARIO_HISTORICO
				SET ACTIVO = '0' 
				WHERE idUsuario = ". $idUsuario." AND correlUsuarioHistorico=".$correlUsuarioHistorico;
			
		$query = $this->db->query($sql);

		if (!$query) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
		}

		return $retArray;
	}

	function deleteRol(){
		$this->load->database();

		$retArray = array("status"=> 0, "msg" => "");

		$idRolHistorico = $this->input->post("idRolHistorico");

		$sql = "DELETE FROM ROL_HISTORICOS
				 WHERE idRolHistorico = ". $idRolHistorico;
			
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

		$sql = "SELECT idUsuario, CONCAT(primerNombre,' ', OtrosNombres,' ',primerApellido,' ',otrosApellidos,) nombreUsuario FROM USUARIO WHERE activo='1'";
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
		//print_r($_POST);

		$retArray = array("status"=> 0, "msg" => "");

		//Colocando las reglas para los campos, el segundo parámetro es el nombre del campo que aparecerá en el mensaje
		//Habrá que reemplazar los mensajes, pues por el momento están en inglés
		$this->form_validation->set_rules("fechaInicioContrato", "Inicio Contrato", 'required');
		$this->form_validation->set_rules("fechaFinContrato", "Fin Contrato", 'required');
		$this->form_validation->set_rules("tiempoContrato", "Tiempo contrato", 'required');

		$this->form_validation->set_message('required', 'El campo "%s" es requerido');

		if ($this->form_validation->run() == false){//Si al menos una de las reglas no se cumplió...
			//Concatenamos en $msg los mensajes de errores generados para cada campo, lo tenga o no
			$retArray["status"] = 1;

			$retArray["msg"] .= form_error("fechaInicioContrato");
			$retArray["msg"] .= form_error("fechaFinContrato");
			$retArray["msg"] .= form_error("tiempoContrato");
		}

		return $retArray;
	}

	function saveValidationRol(){
		$this->load->library('form_validation');
		//print_r($_POST);

		$retArray = array("status"=> 0, "msg" => "");

		//Colocando las reglas para los campos, el segundo parámetro es el nombre del campo que aparecerá en el mensaje
		//Habrá que reemplazar los mensajes, pues por el momento están en inglés
		$this->form_validation->set_rules("fechaInicio", "Asignado", 'required');
		$this->form_validation->set_message('required', 'El campo "%s" es requerido');

		if ($this->form_validation->run() == false){//Si al menos una de las reglas no se cumplió...
			//Concatenamos en $msg los mensajes de errores generados para cada campo, lo tenga o no
			$retArray["status"] = 1;
			$retArray["msg"] .= form_error("fechaInicio");
		}
	}

	// llena el grid de los contratos del usuario
	function gridContratoUsuarioRead($idUsuario=null){
		$this->load->database();

		$page = $this->input->post("page");
		$limit = $this->input->post("rows");
		$sidx = $this->input->post("sidx");
		$sord = $this->input->post("sord");
		$count = 0;
		if(!$sidx) $sidx =1;

		$idUsuario = is_null($idUsuario) ? -1 : (int)$idUsuario;


		$sql = "SELECT COUNT(*) AS count FROM USUARIO_HISTORICO WHERE idUsuario = ".$this->db->escape($idUsuario)." AND activo='1'";
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

		$sql = "SELECT fechaInicioContrato, if(fechaFinContrato=null,'',fechaFinContrato) fechaFinContrato, tiempoContrato, correlUsuarioHistorico, idUsuario  FROM USUARIO_HISTORICO WHERE idUsuario = ".$this->db->escape($idUsuario)." AND activo='1'";
		$query = $this->db->query($sql);

		$i = 0;
		if($query){
			if($query->num_rows > 0){
				foreach ($query->result() as $row){
					$response->rows[$i]["id"] = $i+1;// de esto no estoy del todo seguro
					$response->rows[$i]["cell"] = array($row->fechaInicioContrato,$row->fechaFinContrato,$row->tiempoContrato, $row->correlUsuarioHistorico, $row->idUsuario);
					$i++;
				}
			}
		}

		return $response;
	}

	function gridRolRead($idUsuario, $correlUsuarioHistorico){
		$this->load->database();

		$page = $this->input->post("page");
		$limit = $this->input->post("rows");
		$sidx = $this->input->post("sidx");
		$sord = $this->input->post("sord");
		$count = 0;
		if(!$sidx) $sidx =1;

		$idUsuario = is_null($idUsuario) ? -1 : (int)$idUsuario;

		$sql = "SELECT COUNT(*) AS count FROM ROL_HISTORICOS WHERE idUsuario = ".$this->db->escape($idUsuario)." AND correlUsuarioHistorico=".$this->db->escape($correlUsuarioHistorico);
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

		$sql = "SELECT fechaInicio, fechaFin, salario, nombreRol, correlUsuarioHistorico, idRolHistorico, idUsuario, ROL_HISTORICOS.idRol  FROM ROL_HISTORICOS, ROL WHERE ROL_HISTORICOS.idRol = ROL.idRol AND idUsuario = ".$this->db->escape($idUsuario)." AND correlUsuarioHistorico=".$this->db->escape($correlUsuarioHistorico);
		$query = $this->db->query($sql);

		$i = 0;
		if($query){
			if($query->num_rows > 0){
				foreach ($query->result() as $row){
					$response->rows[$i]["id"] = $i+1;// de esto no estoy del todo seguro
					$response->rows[$i]["cell"] = array($row->fechaInicio,$row->fechaFin,$row->salario, $row->nombreRol, $row->idRolHistorico, $row->idUsuario, $row->correlUsuarioHistorico,  $row->idRol);
					$i++;
				}
			}
		}

		return $response;
	}
}