<?php
class Usuario extends CI_Controller{

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

		$this->load->view("usuarioView");
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
			$idUsuario =  $this->input->post("idUsuario");
				
			if($idUsuario == ""){//Si no se recibe el id, los datos se guardarán como un nuevo registro
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