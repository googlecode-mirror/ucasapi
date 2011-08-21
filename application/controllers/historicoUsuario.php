<?php
class historicoUsuario extends CI_Controller{

	function index(){
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
		$this->load->model("roleOptionsModel");

		$controllerName = get_class($this);

		$previousPage = $this->session->userdata("currentPage");
		$previousPage = ($previousPage!="")?$previousPage:"buzon";

		$idRol = $this->session->userdata("idRol");//Se agrega en $idRol el dato correspondiente de la sesión

		if($idRol != ""){//Si está en sesión
			$allowedPage = $this->roleOptionsModel->validatePage($idRol, $controllerName);
				
			if($allowedPage){//Si el usuario según rol tiene permiso para acceder a la página
				$this->session->set_userdata("previousPage", $previousPage);
				$this->session->set_userdata("currentPage", $controllerName);

				$menu = $this->roleOptionsModel->showMenu($idRol);//Se genera el menú
				$userName = $this->session->userdata("username");//Se obtiene el nombre de usuario de la sesión
				$roleName = $this->session->userdata("roleName");

				$this->load->view("historicoUsuarioView", array("menu"=> $menu, "userName" => $userName, "roleName" => str_replace("%20", " ", $roleName)));//Se agrega el código del menú y el nombre del usuario como variables al view

			}
			else{//Si el usuario no tiene permiso para acceder a la página se redirige a la anterior
				redirect($previousPage,"refresh");
			}

		}
		else{//Si no existe usuario en sesión se redirige al login
			redirect("login", "refresh");
		}
	}

	function contratosRead(){
		$this->load->model("historicoUsuarioModel");
		echo json_encode($this->historicoUsuarioModel->read());
	}

	function nohacernada() {
		// no hacer nada
	}

	function usuarioAutocompleteRead(){
		$this->load->model("historicoUsuarioModel");

		$autocompleteData = $this->historicoUsuarioModel->autocompleteRead();

		echo json_encode($autocompleteData);
	}

	function usuarioCargoAutocompleteRead(){
		$this->load->model("cargoModel");

		$autocompleteData = $this->cargoModel->autocompleteRead();

		echo json_encode($autocompleteData);
	}

	function rolAutocompleteRead(){
		$this->load->model("rolModel");

		$autocompleteData = $this->rolModel->autocompleteRead();

		echo json_encode($autocompleteData);
	}

	function gridContratoRolRead($idUsuario,$correlUsuarioHistorico){
		$this->load->model("historicoUsuarioModel");
		echo json_encode($this->historicoUsuarioModel->gridRolRead($idUsuario,$correlUsuarioHistorico));
	}

	function gridContratoUsuarioRead($idUsuario){
		$this->load->model("historicoUsuarioModel");
		echo json_encode($this->historicoUsuarioModel->gridContratoUsuarioRead($idUsuario));
	}

	function contratoDelete(){
		$this->load->model("historicoUsuarioModel");

		$deleteInfo = $this->historicoUsuarioModel->delete();

		echo json_encode($deleteInfo);
	}

	function rolDelete(){
		$this->load->model("historicoUsuarioModel");

		$deleteInfo = $this->historicoUsuarioModel->deleteRol();

		echo json_encode($deleteInfo);
	}

	function historicoUsuarioValidateAndSave(){
		$this->load->model("historicoUsuarioModel");
		$retArray = array();

		$validationInfo = $this->historicoUsuarioModel->saveValidation();

		if($validationInfo["status"] == 0){//Los datos ingresados pasaron las validaciones
			$accionActual =  $this->input->post("accionActual");

			if($accionActual == ""){//Si no se recibe el id, los datos se guardarán como un nuevo registro
				$retArray = $this->historicoUsuarioModel->create();
			}
			else{
				$retArray = $this->historicoUsuarioModel->update();
			}

		}
		else{//Los datos ingresados no pasaron las validaciones
			$retArray = $validationInfo;
		}

		echo json_encode($retArray);
	}

	function historicoUsuarioRolValidateAndSave(){
		$this->load->model("historicoUsuarioModel");
		$retArray = array();

		$validationInfo = $this->historicoUsuarioModel->saveValidationRol();

		if($validationInfo["status"] == 0){//Los datos ingresados pasaron las validaciones
			$accionActual =  $this->input->post("accionActualRol");

			if($accionActual == ""){//Si no se recibe el id, los datos se guardarán como un nuevo registro
				$retArray = $this->historicoUsuarioModel->createRol();
			}
			else{
				$retArray = $this->historicoUsuarioModel->updateRol();
			}

		}
		else{//Los datos ingresados no pasaron las validaciones
			$retArray = $validationInfo;
		}

		echo json_encode($retArray);
	}



}