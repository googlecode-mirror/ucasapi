<?php
class Cliente extends CI_Controller {

	function index() {
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));

		$idUsuario = $this->session->userdata("idUsuario");//Se agrega en $idRol el dato correspondiente de la sesi�n

		if($idUsuario == ""){//Si el dato no est� en sesi�n, se redirige a la p�gina de login
			redirect("login", "refresh");
		}
		else{
			$this->load->view("clienteView");
		}
	}

	function listaSolicitudes() {
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));

		$idUsuario = $this->session->userdata("idUsuario");//Se agrega en $idRol el dato correspondiente de la sesi�n

		if($idUsuario == ""){//Si el dato no est� en sesi�n, se redirige a la p�gina de login
			redirect("login", "refresh");
		}
		else{
			$this->load->view("listaSolicitudesView");
		}
	}

	function resumenProyectos() {
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));

		$idUsuario = $this->session->userdata("idUsuario");//Se agrega en $idRol el dato correspondiente de la sesi�n

		if($idUsuario == ""){//Si el dato no est� en sesi�n, se redirige a la p�gina de login
			redirect("login", "refresh");
		}
		else{
			$data["idUsuario"] = $idUsuario;
			$this->load->view("resumenProyectosView", $data);
		}
	}

	function gridProyectosUsuario($idUsuario) {
		$this->load->model("proyectoModel");
		echo json_encode($this->proyectoModel->gridProyectosUsuario($idUsuario));
	}

	function faseProyectoRead(){
		$this->load->model("proyectoModel");
		echo json_encode($this->proyectoModel->faseProyectoRead());
	}
}