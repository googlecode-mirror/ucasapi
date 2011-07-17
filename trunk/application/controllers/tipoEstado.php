<?php
class TipoEstado extends CI_Controller{

	function index(){
		$this->load->helper(array('form', 'url'));
		$this->load->view("tipoEstadoView");
	}
	
	function tipoAutocompleteRead(){
		$this->load->model("tipoEstadoModel");
		$autocompleteData = $this->tipoEstadoModel->autocompleteRead();
		echo json_encode($autocompleteData);
	}
	
	function tipoRead(){
		$this->load->model("tipoEstadoModel");
		echo json_encode($this->tipoEstadoModel->read());
	}
	
	function tipoDelete(){
		$this->load->model("tipoEstadoModel");
		echo json_encode($this->tipoEstadoModel->delete());
	}
	
	function tipoValidateAndSave(){
		$this->load->model("tipoEstadoModel");
		$retArray = array();
		
		$validationInfo = $this->tipoEstadoModel->saveValidation();
		
		if($validationInfo["status"] == 0){
			$idTipo = $this->input->post("idTipo");
			
			if($idTipo == ""){
				$retArray = $this->tipoEstadoModel->create();
			}
			else{
				$retArray = $this->tipoEstadoModel->update();
			}
			
		}
		else{
			$retArray = $validationInfo;
		}
		
		echo json_encode($retArray);
	}
	
}