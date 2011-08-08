<?php
class historicoUsuario extends CI_Controller{

	function index(){
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));

		$idRol = $this->session->userdata("idRol");//Se agrega en $idRol el dato correspondiente de la sesión

		/*if($idRol == ""){//Si el dato no está en sesión, se redirige a la página de login
			redirect("login", "refresh");
			}
			else{
			$this->load->view("usuarioView");
			}*/

		$this->load->view("historicoUsuarioView");
	}

	function contratosRead(){
		$this->load->model("historicoUsuarioModel");
		echo json_encode($this->historicoUsuarioModel->read());
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

	function usuarioRolAutocompleteRead(){
		$this->load->model("rolModel");

		$autocompleteData = $this->rolModel->autocompleteRead();

		echo json_encode($autocompleteData);
	}

	function gridRead($idUsuario){
		$this->load->model("usuarioModel");
		echo json_encode($this->usuarioModel->gridUsuarioRead($idUsuario));
	}

	function gridContratoUsuarioRead($idUsuario){
		$this->load->model("historicoUsuarioModel");
		echo json_encode($this->historicoUsuarioModel->gridContratoUsuarioRead($idUsuario));
	}

	function usuarioDelete(){
		$this->load->model("usuarioModel");

		$deleteInfo = $this->usuarioModel->delete();

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

}