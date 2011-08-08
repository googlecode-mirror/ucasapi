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
		if($nuevoCorrel = $row->lastCorrel == null)
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


	function read(){
		$this->load->database();

		$retArray = array("status"=> 0, "msg" => "", "data"=>array());

		$idUsuario = $this->input->post("idUsuario");

		$sql = "SELECT idUsuario, correlUsuarioHistorico, fechaInicioContrato, fechaFinContrato, tiempoContrato, activo
				FROM USUARIO_HISTORICO 
				WHERE idUsuario = ".$idUsuario;

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
		$username = $this->input->post("username");
		$password = $this->input->post("password");
		$primerNombre = $this->input->post("primerNombre");
		$primerApellido = $this->input->post("primerApellido");
		$otrosNombres = $this->input->post("otrosNombres");
		$otrosApellidos = $this->input->post("otrosApellidos");
		$codEmp = $this->input->post("codEmp");
		$dui = $this->input->post("dui");
		$nit = $this->input->post("nit");
		$isss = $this->input->post("isss");
		$emailPersonal = $this->input->post("emailPersonal");
		$emailInstitucional = $this->input->post("emailInstitucional");
		$nup = $this->input->post("nup");
		$carnet = $this->input->post("carnet");
		$activo = $this->input->post("activo");
		$idDepto = $this->input->post("idDepto");
		$idCargo = $this->input->post("idCargo");
		$fechaNacimiento = $this->input->post("fechaNacimiento");
		$telefonoContacto = $this->input->post("telefonoContacto");
		$extension = $this->input->post("extension");

		$rol_rows = $this->input->post("rol_data");


		$sql = "UPDATE USUARIO
				SET username=".$this->db->escape($username).",
				    password=".$this->db->escape($password).",
				    primerNombre=".$this->db->escape($primerNombre).",
				    primerApellido=".$this->db->escape($primerApellido).",
				    otrosNombres=".$this->db->escape($otrosNombres).",
				    otrosApellidos=".$this->db->escape($otrosApellidos).",
				    codEmp=".$this->db->escape($codEmp).",
				    dui=".$this->db->escape($dui).",
				    nit=".$this->db->escape($nit).",
				    isss=".$this->db->escape($isss).",
				    emailPersonal=".$this->db->escape($emailPersonal).",
				    emailInstitucional=".$this->db->escape($emailInstitucional).",
				    nup=".$this->db->escape($nup).",
				    carnet=".$this->db->escape($carnet).",
				    idDepto=".$this->db->escape($idDepto).",
				    idCargo=".$this->db->escape($idCargo).",
				    activo=".$this->db->escape($activo).",
				    telefonoContacto=".$this->db->escape($telefonoContacto).",
				    extension=".$this->db->escape($extension).",
				    fechaNacimiento=".$this->db->escape($fechaNacimiento)."
				     WHERE idUsuario = ". $idUsuario;	

		// transaccion de actualización
		$this->db->trans_begin();

		$query = $this->db->query($sql);

		//eliminar los roles que actualmente estan asignados al usuario, primer paso para sobreescribir
		$sql = "DELETE FROM ROL_USUARIO WHERE idUsuario =".$idUsuario;
		$query = $this->db->query($sql);

		if($rol_rows != ""){

			// insertando roles al usuario, segundo paso para sobrescribir
			$data_array = explode("|",$rol_rows);
			$insert_statements = $this->getRolInsert($data_array, $idUsuario);
			foreach ($insert_statements as $queryRoles) {
				$this->db->query($queryRoles);
			}
		}

		//controlando la transaccion
		if($this->db->trans_status() == FALSE) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}

		/*if (!$query) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
			}*/
		return $retArray;
	}

	function delete(){
		$this->load->database();

		$retArray = array("status"=> 0, "msg" => "");

		$idUsuario = $this->input->post("idUsuario");

		$sql = "UPDATE USUARIO
				SET ACTIVO = '0' 
				WHERE idUsuario = ". $idUsuario;
			
		$query = $this->db->query($sql);

		if (!$query) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
		}

		return $retArray;
	}

	// Buscar usuarios
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


		$sql = "SELECT COUNT(*) AS count FROM USUARIO_HISTORICO WHERE idUsuario = ".$this->db->escape($idUsuario);
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

		$sql = "SELECT idUsuario, correlUsuarioHistorico, fechaInicioContrato, fechaFinContrato, tiempoContrato, activo FROM USUARIO_HISTORICO WHERE idUsuario = ".$this->db->escape($idUsuario);
		$query = $this->db->query($sql);

		$i = 0;
		if($query){
			if($query->num_rows > 0){
				foreach ($query->result() as $row){
					$response->rows[$i]["id"] = $i;// de esto no estoy del todo seguro
					$response->rows[$i]["cell"] = array($row->fechaInicioContrato,$row->fechaFinContrato,$row->tiempoContrato, $row->activo, $row->correlativoUsuarioHistorico, $row->idUsuario);
					$i++;
				}
			}
		}

		return $response;
	}

	//Este es el grid donde estan los roles que actualemente tiene un usuario
	function gridRolesUsuarioRead($idUsuario=null){
		$this->load->database();

		$page = $this->input->post("page");
		$limit = $this->input->post("rows");
		$sidx = $this->input->post("sidx");
		$sord = $this->input->post("sord");
		$count = 0;
		if(!$sidx) $sidx =1;

		$idUsuario = is_null($idUsuario) ? -1 :(int) $idUsuario;


		$sql = "SELECT COUNT(*) AS count FROM ROL_USUARIO WHERE idUsuario = ".$this->db->escape($idUsuario);
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

		$sql = "SELECT ru.idRol idRol, r.nombreRol nombreRol, ru.fechaAsigancionSistema fechaAsignacionSistema FROM ROL r, ROL_USUARIO ru WHERE ru.idRol = r.idRol AND ru.idUsuario = ".$this->db->escape($idUsuario);
		$query = $this->db->query($sql);

		$i = 0;
		if($query){
			if($query->num_rows > 0){
				foreach ($query->result() as $row){
					$response->rows[$i]["id"] = $row->idRol;
					$response->rows[$i]["cell"] = array($row->idRol, $row->nombreRol, $row->fechaAsignacionSistema);
					$i++;
				}
			}
		}

		return $response;
	}

}