<?php
class Usuario extends CI_Controller{

	function index(){
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
		$this->load->model("roleOptionsModel");

		$controllerName = strtolower(get_class($this));

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

				$this->load->view("usuarioView", array("menu"=> $menu, "userName" => $userName, "roleName" => str_replace("%20", " ", $roleName)));//Se agrega el código del menú y el nombre del usuario como variables al view

			}
			else{//Si el usuario no tiene permiso para acceder a la página se redirige a la anterior
				redirect($previousPage,"refresh");
			}

		}
		else{//Si no existe usuario en sesión se redirige al login
			redirect("login", "refresh");
		}

	}


	function usuarioRead(){
		$this->load->model("usuarioModel");
		echo json_encode($this->usuarioModel->read());
	}

	function usuarioDepartamentoAutocompleteRead(){
		$this->load->model("departamentoModel");

		$autocompleteData = $this->departamentoModel->autocompleteRead();

		echo json_encode($autocompleteData);
	}

	function usuarioAutocompleteRead(){
		$this->load->model("usuarioModel");

		$autocompleteData = $this->usuarioModel->autocompleteRead();

		echo json_encode($autocompleteData);
	}

	function usuarioCargoAutocompleteRead(){
		$this->load->model("cargoModel");

		$autocompleteData = $this->cargoModel->autocompleteRead();

		echo json_encode($autocompleteData);
	}

	function usuarioRolAutocompleteRead(){
		$this->load->model("rolModel");

		$autocompleteData = $this->rolModel->autocompleteRead();

		echo json_encode($autocompleteData);
	}

	function gridRead($idUsuario){
		$this->load->model("usuarioModel");
		echo json_encode($this->usuarioModel->gridUsuarioRead($idUsuario));
	}

	function gridRolesUsuarioRead($idUsuario){
		$this->load->model("usuarioModel");
		echo json_encode($this->usuarioModel->gridRolesUsuarioRead($idUsuario));
	}

	function usuarioDelete(){
		$this->load->model("usuarioModel");

		$deleteInfo = $this->usuarioModel->delete();

		echo json_encode($deleteInfo);
	}

	function usuarioValidateAndSave(){
		$this->load->model("usuarioModel");
		$retArray = array();

		$validationInfo = $this->usuarioModel->saveValidation();

		if($validationInfo["status"] == 0){//Los datos ingresados pasaron las validaciones
			$accionActual =  $this->input->post("accionActual");

			if($accionActual == ""){//Si no se recibe el id, los datos se guardarán como un nuevo registro
				$retArray = $this->usuarioModel->create();
			}
			else{
				$retArray = $this->usuarioModel->update();
			}
		}
		else{//Los datos ingresados no pasaron las validaciones
			$retArray = $validationInfo;
		}

		echo json_encode($retArray);
	}


}