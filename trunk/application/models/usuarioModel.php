<?php

class UsuarioModel extends CI_Model{


	function create(){

		$idUsuario;

		$this->load->database();

		$retArray = array("status"=> 0, "msg" => "");

		// tomando la data del post
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
		$idDepto = (int) $this->input->post("idDepto");
		$idCargo = (int) $this->input->post("idCargo");
		$fechaNacimiento = $this->input->post("fechaNacimiento");
		$telefonoContacto = $this->input->post("telefonoContacto");
		$extension = $this->input->post("extension");


		$rol_rows = $this->input->post("rol_data");

		// guardar los datos basicos de usuario
		$sql = "INSERT INTO USUARIO (username, password, primerNombre, primerApellido, otrosNombres, otrosApellidos, codEmp, dui, nit, isss, emailPersonal, emailInstitucional, nup, carnet, idDepto, idCargo, activo, fechaNacimiento, telefonoContacto, extension)
				VALUES (".$this->db->escape($username).", ".$this->db->escape($password).", ".$this->db->escape($primerNombre).", ".$this->db->escape($primerApellido)."
				, ".$this->db->escape($otrosNombres).", ".$this->db->escape($otrosApellidos).", ".$this->db->escape($codEmp).", ".$this->db->escape($dui).", ".$this->db->escape($nit)."
				, ".$this->db->escape($isss).", ".$this->db->escape($emailPersonal).", ".$this->db->escape($emailInstitucional).", ".$this->db->escape($nup)."
				, ".$this->db->escape($carnet).", ".$this->db->escape($idDepto).", ".$this->db->escape($idCargo).",".$this->db->escape($activo).",".$this->db->escape($fechaNacimiento).",'".$this->db->escape($telefonoContacto)."',".$this->db->escape($extension).")";


		/*********************************************************************************/
		$this->db->trans_begin();
		// insertando el usuario
		$this->db->query($sql);

		if($rol_rows != ""){
			//echo "hola";
			// tomar el id del usuario que estoy guardando, preguntando por el username
			$sql = "SELECT idUsuario FROM USUARIO WHERE username = '".$username."'";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0)
			{
				$row = $query->row();
				$idUsuario = $row->idUsuario;
			}
			// formando arreglo con los parametros de insert
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

		return $retArray;
	}

	function getRolInsert($data_array, $idUsuario){
		$counter = 1;
		$idRolInsert;
		$idUsuarioInsert;
		$fechaAsignacionSistema;
		$index = 0;
		$indexTrippin = 0;
		$trippin;

		foreach ($data_array as $value) {
			if($counter == 1){
				$idRolInsert = $value;
				$counter++;
				continue;
			}
			if($counter == 2){
				$idUsuarioInsert = $idUsuario;
				$counter++;
				continue;
			}
			if($counter == 3){
				$fechaAsignacionSistema = $value;
				$counter = 1;
				if($fechaAsignacionSistema == "null"){
					$trippin[$indexTrippin++] = "INSERT INTO ROL_USUARIO (idRol, idUsuario, fechaAsigancionSistema) VALUES (".$idRolInsert.",".$idUsuarioInsert.",CURRENT_TIMESTAMP)";
				}else{
					$trippin[$indexTrippin++] = "INSERT INTO ROL_USUARIO (idRol, idUsuario, fechaAsigancionSistema) VALUES (".$idRolInsert.",".$idUsuarioInsert.",'".$fechaAsignacionSistema."')";
				}

				continue;
			}
		}

		return  $trippin;
	}

	function read(){
		$this->load->database();

		$retArray = array("status"=> 0, "msg" => "", "data"=>array());

		$idUsuario = $this->input->post("idUsuario");

		$sql = "SELECT idUsuario, username, password, primerNombre, otrosNombres, primerApellido, otrosApellidos, codEmp, dui, nit, isss, emailPersonal, emailInstitucional, nup, carnet, U.activo, D.nombreDepto nombreDepto, C.nombreCargo nombreCargo, D.idDepto, C.idCargo, fechaNacimiento, telefonoContacto, extension
				FROM DEPARTAMENTO D, USUARIO U, CARGO C
				WHERE D.idDepto = U.idDepto AND U.idCargo = C.idCargo AND 
				idUsuario = ".$idUsuario;

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

		$sql = "SELECT idUsuario, CONCAT(primerNombre,' ', if(OtrosNombres=null,'',OtrosNombres),' ',primerApellido,' ',if(otrosApellidos=null,'',otrosApellidos),' ',if(activo=1,'(ACTIVO)','(INACTIVO)')) nombreUsuario FROM USUARIO";
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
		$this->form_validation->set_rules("primerNombre", "Primer Nombre", 'required');
		$this->form_validation->set_rules("primerApellido", "Apellidos", 'required');
		$this->form_validation->set_rules("username", "username", 'required');
		$this->form_validation->set_rules("password", "password", 'required');
		$this->form_validation->set_rules("dui", "DUI", 'required');
		$this->form_validation->set_rules("nit", "NIT", 'required');
		$this->form_validation->set_rules("isss", "ISSS", 'required');
		$this->form_validation->set_rules("codEmp", "Codigo Empleado", 'required');
		$this->form_validation->set_rules("isss", "ISSS", 'required');

		$this->form_validation->set_message('required', 'El campo "%s" es requerido');

		if ($this->form_validation->run() == false){//Si al menos una de las reglas no se cumplió...
			//Concatenamos en $msg los mensajes de errores generados para cada campo, lo tenga o no
			$retArray["status"] = 1;

			$retArray["msg"] .= form_error("primerNombre");
			$retArray["msg"] .= form_error("primerApellido");
			$retArray["msg"] .= form_error("username");
			$retArray["msg"] .= form_error("password");
			$retArray["msg"] .= form_error("dui");
			$retArray["msg"] .= form_error("nit");
			$retArray["msg"] .= form_error("isss");
			$retArray["msg"] .= form_error("codEmp");
			$retArray["msg"] .= form_error("isss");

		}

		return $retArray;
	}

	// este es el grid donde estan todos los roles asignables
	function gridUsuarioRead($idUsuario=null){
		$this->load->database();

		$page = $this->input->post("page");
		$limit = $this->input->post("rows");
		$sidx = $this->input->post("sidx");
		$sord = $this->input->post("sord");
		$count = 0;
		if(!$sidx) $sidx =1;

		$idUsuario = is_null($idUsuario) ? -1 : (int)$idUsuario;


		$sql = "SELECT COUNT(*) AS count FROM ROL R WHERE idRol NOT IN (SELECT idRol FROM ROL_USUARIO WHERE idUsuario = ".$this->db->escape($idUsuario).")";
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

		$sql = "SELECT idRol, nombreRol FROM ROL WHERE activo='1' AND idRol NOT IN (SELECT idRol FROM ROL_USUARIO WHERE idUsuario = ".$this->db->escape($idUsuario).")";
		$query = $this->db->query($sql);

		$i = 0;
		if($query){
			if($query->num_rows > 0){
				foreach ($query->result() as $row){
					$response->rows[$i]["id"] = $row->idRol;
					$response->rows[$i]["cell"] = array($row->idRol, $row->nombreRol,"null");
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