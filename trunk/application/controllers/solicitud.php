<?php

class Solicitud extends CI_Controller {

	function index() {
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));

		$idUsuario = $this->session->userdata("idUsuario");//Se agrega en $idRol el dato correspondiente de la sesi�n

		if($idUsuario == ""){//Si el dato no est� en sesi�n, se redirige a la p�gina de login
			redirect("login", "refresh");
		}
		else{
			$this->load->view("solicitudView");
		}
	}

	function solicitudSave() {
		$this->load->model("solicitudModel");
		$retArray = array();

		$validationInfo = $this->solicitudModel->saveValidation();

		if($validationInfo["status"] == 0){//Los datos ingresados pasaron las validaciones
			$retArray = $this->solicitudModel->create();

		}
		else{//Los datos ingresados no pasaron las validaciones
			$retArray = $validationInfo;
		}

		echo json_encode($retArray);
	}

	function getSolicitud () {
		$this->load->model("solicitudModel");
		echo json_encode($this->solicitudModel->getSolicitud());
	}

	function gridRead($id){
		$this->load->model("solicitudModel");
		echo json_encode($this->solicitudModel->gridSolicitudRead($id));
	}

	function misSolicitudes($esAutor) {
		$this->load->model("solicitudModel");
		echo json_encode($this->solicitudModel->misSolicitudes($esAutor));
	}

	// ***********************************************************************************
	// METODOS TEMPORALES

	// Hay que cambiar el model a 'prioridad' cuando esté listo
	function cargarPrioridades() {
		$this->load->model("solicitudModel");
		echo json_encode($this->solicitudModel->getPrioridades());
	}

	function empleadoAutocompleteRead() {
		$this->load->model("solicitudModel");
		echo json_encode($this->solicitudModel->empleadoAutocomplete());
	}

	function transferirSolicitud() {
		$this->load->model("solicitudModel");
		echo json_encode($this->solicitudModel->transferirSolicitud());
	}
}