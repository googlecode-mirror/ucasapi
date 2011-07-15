<?php
class Tipo extends CI_Controller{

	function index(){
		$this->load->helper(array('form', 'url'));
		$this->load->view("tipoView");
	}
	
	function tipoAutocompleteRead(){
		$this->load->model("tipoModel");
		$autocompleteData = $this->tipoModel->autocompleteRead();
		echo json_encode($autocompleteData);
	}
	
	function tipoRead(){
		$this->load->model("tipoModel");
		echo json_encode($this->tipoModel->read());
	}
	
	function tipoDelete(){
		$this->load->model("tipoModel");
		echo json_encode($this->tipoModel->delete());
	}
	
	function tipoValidateAndSave(){
		$this->load->model("tipoModel");
		$retArray = array();
		
		$validationInfo = $this->tipoModel->saveValidation();
		
		if($validationInfo["status"] == 0){
			$idTipo = $this->input->post("idTipo");
			
			if($idTipo == ""){
				$retArray = $this->tipoModel->create();
			}
			else{
				$retArray = $this->tipoModel->update();
			}
			
		}
		else{
			$retArray = $validationInfo;
		}
		
		echo json_encode($retArray);
	}
	
}