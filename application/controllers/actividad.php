<?php
class Actividad extends CI_Controller{
	function index(){
		$this->load->helper(array('form', 'url'));
		$this->load->view("actividadView");
	}
	
	function actividadRead(){
		$this->load->model("actividadModel");
		echo json_encode($this->actividadModel->read());
	}
	
	function actividadValidateAndSave(){
		$this->load->model("actividadModel");
		$retArray = array();
		
		$validationInfo = $this->actividadModel->saveValidation();
		
		if($validationInfo["status"] == 0){
			$retArray = $this->actividadModel->update();
		}
		else{
			$retArray = $validationInfo;
		}
		
		echo json_encode($retArray);
	}
	
	function actividadEstados(){
		$this->load->model("actividadModel");
		echo json_encode($this->actividadModel->readEstados());
	}
	
	function gridUsuariosRead($idActividad){
		$this->load->model("actividadModel");
		echo json_encode($this->actividadModel->readUsuarios($idActividad));
	}
	
	function gridUsuarioSet(){
		$this->load->model("actividadModel");
		echo json_encode($this->actividadModel->gridUsuarioSet());
	}
	
}