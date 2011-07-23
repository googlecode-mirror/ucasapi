<?php

class Estado extends CI_Controller{

	function index(){
		$this->load->helper(array('form', 'url'));
		$this->load->view("estadoView");
	}
	
	function statusRead(){
		$this->load->model("estadoModel");	
		echo json_encode($this->estadoModel->read());
	}
	
	
	function statusAutocompleteRead(){
		$this->load->model("estadoModel");
		
		$autocompleteData = $this->estadoModel->autocompleteRead();		
		
		echo json_encode($autocompleteData);
	}
	
	function statusTypeAutocompleteRead(){
		$this->load->model("estadoModel");
		
		$autocompleteData = $this->estadoModel->statusTypeAutocomplete();		
		
		echo json_encode($autocompleteData);
	}
	
	function statusDelete(){
		$this->load->model("estadoModel");
		
		$deleteInfo = $this->estadoModel->delete();		
		
		echo json_encode($deleteInfo);
	}


	function statusValidateAndSave(){
		$this->load->model("estadoModel");
		$retArray = array();
		
		$validationInfo = $this->estadoModel->saveValidation();
		
		if($validationInfo["status"] == 0){//Los datos ingresados pasaron las validaciones
			$idEstado =  $this->input->post("idEstado");
			
			if($idEstado == ""){//Si no se recibe el id, los datos se guardarán como un nuevo registro
				$retArray = $this->estadoModel->create();
			}
			else{
				$retArray = $this->estadoModel->update();
			}
						
		}		
		else{//Los datos ingresados no pasaron las validaciones
			$retArray = $validationInfo;
		}
		
		echo json_encode($retArray);	
	}
	
}



?>