<?php
class Fase extends CI_Controller{

	function index(){
		$this->load->helper(array('form', 'url'));
		$this->load->view("faseView");
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