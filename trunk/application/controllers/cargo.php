<?php
class Cargo extends CI_Controller{

	function index(){
		$this->load->helper(array('form', 'url'));
		$this->load->view("cargoView");
	}
	
	function cargoRead(){
		$this->load->model("cargoModel");	
		echo json_encode($this->cargoModel->read());
	}
	
	
	function cargoAutocompleteRead(){
		$this->load->model("cargoModel");
		
		$autocompleteData = $this->cargoModel->autocompleteRead();		
		
		echo json_encode($autocompleteData);
	}
	
	function cargoDelete(){
		$this->load->model("cargoModel");
		
		$deleteInfo = $this->cargoModel->delete();		
		
		echo json_encode($deleteInfo);
	}


	function cargoValidateAndSave(){
		$this->load->model("cargoModel");
		$retArray = array();
		
		$validationInfo = $this->cargoModel->saveValidation();
		
		if($validationInfo["status"] == 0){//Los datos ingresados pasaron las validaciones
			$idDepto =  $this->input->post("idCargo");
			
			if($idDepto == ""){//Si no se recibe el id, los datos se guardarán como un nuevo registro
				$retArray = $this->cargoModel->create();
			}
			else{
				$retArray = $this->cargoModel->update();
			}
						
		}		
		else{//Los datos ingresados no pasaron las validaciones
			$retArray = $validationInfo;
		}
		
		echo json_encode($retArray);	
	}
	
}