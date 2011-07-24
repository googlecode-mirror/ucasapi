<?php

class Login extends CI_Controller{
	
	function index(){
		$this->load->helper(array('form', 'url'));
		$this->load->view("loginView");
	}
	
	function validateUser(){
		$this->load->library('session');
		$this->load->helper(array('url'));
		
		$this->load->model("userModel");		
		$userData = $this->userModel->validateUser();
		
		
		if(count($userData["data"])>0){//Si se obtuvieron datos para las credenciales introducidas
			$this->session->set_userdata("idRol", $userData["data"]["idRol"]);
			$this->session->set_userdata("username", $userData["data"]["primerApellido"].$userData["data"]["primerNombre"]);
			$this->session->set_userdata("idUsuario", $userData["data"]["idUsuario"]);
			
			$userData["msg"] = site_url("departamento");
		}
		
		echo json_encode($userData);

	}
	
	
	
}

?>