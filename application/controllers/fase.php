<?php
class Fase extends CI_Controller{

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
				
				$this->load->view("faseView", array("menu"=> $menu, "userName" => $userName, "roleName" => str_replace("%20", " ", $roleName)));//Se agrega el código del menú y el nombre del usuario como variables al view
				
			}
			else{//Si el usuario no tiene permiso para acceder a la página se redirige a la anterior				
				$previousPage = $this->session->userdata("currentPage");
				redirect($previousPage,"refresh");
			}
						
		}
		else{//Si no existe usuario en sesión se redirige al login
			redirect("login", "refresh");
		}
	}
	
	function faseRead(){
		$this->load->model("faseModel");
		echo json_encode($this->faseModel->read());
	}
	
	function faseAutocompleteRead(){
		$this->load->model("faseModel");
		$autocompleteData = $this->faseModel->autocompleteRead();
		echo json_encode($autocompleteData);
	}
	
	function faseDelete(){
		$this->load->model("faseModel");
		echo json_encode($this->faseModel->delete());
	}
	
	function faseValidateAndSave(){
		$this->load->model("faseModel");
		$retArray = array();
		
		$validationInfo = $this->faseModel->saveValidation();
		
		if($validationInfo["status"] == 0){
			$idFase = $this->input->post("idFase");
			
			if($idFase == ""){
				$retArray = $this->faseModel->create();
			}
			else{
				$retArray = $this->faseModel->update();
			}
			
		}
		else{
			$retArray = $validationInfo;
		}
		
		echo json_encode($retArray);
	}
}