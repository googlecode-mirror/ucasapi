<?php

class Login extends CI_Controller{
	
	function index(){
		$this->load->helper(array('url'));
		$this->load->library('session');		
				
		$idRol = $this->session->userdata("idRol");
		if($idRol!=""){
			$previousPage = $this->session->userdata("currentPage");
			redirect($previousPage,"refresh");
		}
		
		$this->load->view("loginView");
	}
	
//-------------------------------------------------------------------------------------------------------------------------------------------------------
	
	function close(){
		$this->load->helper(array('url'));
		$this->load->library('session');
		$this->session->sess_destroy();
		
		redirect("login","refresh");
	}
	
//-------------------------------------------------------------------------------------------------------------------------------------------------------
	
	function validateUser(){
		$this->load->library('session');
		$this->load->helper(array('url'));		
		$this->load->model("loginModel");	

		$homePage = "buzon";
		
		$userData = $this->loginModel->validateUser();		
		
		if(count($userData["data"])>0){//Si se obtuvieron datos para las credenciales introducidas			
			$this->session->set_userdata("username", $userData["data"]["primerNombre"]." ".$userData["data"]["primerApellido"]);
			$this->session->set_userdata("idUsuario", $userData["data"]["idUsuario"]);
			$this->session->set_userdata("previousPage", "");
			$this->session->set_userdata("currentPage", "");
		}
		
		echo json_encode($userData);

	}
	
//-------------------------------------------------------------------------------------------------------------------------------------------------------	

	function rolesAutocompleteRead(){
		$this->load->model("loginModel");		
		$autocompleteData = $this->loginModel->readRolesAutocomplete();		
		echo json_encode($autocompleteData);
	}
	

//-------------------------------------------------------------------------------------------------------------------------------------------------------	

	function home($idRol){
		$this->load->library('session');
		$this->load->helper(array('url'));
		
		$this->session->set_userdata("idRol", $idRol);
		
		redirect("departamento","refresh");		
	}
	
}

?>