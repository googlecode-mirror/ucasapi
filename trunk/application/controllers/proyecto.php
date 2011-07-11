<?php

class Proyecto extends CI_Controller{

	function index(){
		$this->load->helper(array('form', 'url'));
		$this->load->view("estadoView");
	}
	
	function statusRead(){
		$this->load->model("estadoModel");	
		echo json_encode($this->estadoModel->read());
	}
	
	
	function proyectoAutocompleteRead(){
		$this->load->model("proyectoModel");
		
		$autocompleteData = $this->proyectoModel->autocompleteRead();
		
		echo json_encode($autocompleteData);
	}
	
		
	function statusDelete(){
		$this->load->model("proyectoModel");
		
		$deleteInfo = $this->proyectoModel->delete();		
		
		echo json_encode($deleteInfo);
	}


	function statusValidateAndSave(){
		$this->load->model("estadoModel");
		$retArray = array();
		
		$validationInfo = $this->estadoModel->saveValidation();
		
		if($validationInfo["status"] == 0){//Los datos ingresados pasaron las validaciones
			$idDepto =  $this->input->post("idDepto");
			
			if($idDepto == ""){//Si no se recibe el id, los datos se guardarán como un nuevo registro
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