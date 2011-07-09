<?php
class Departamento extends CI_Controller{

	function index(){
		$this->load->helper(array('form', 'url'));
		$this->load->view("departamentoView");
	}
	
	function departmentRead(){
		$this->load->model("departamentoModel");	
		echo json_encode($this->departamentoModel->read());
	}
	
	
	function departmentAutocompleteRead(){
		$this->load->model("departamentoModel");
		
		$autocompleteData = $this->departamentoModel->autocompleteRead();		
		
		echo json_encode($autocompleteData);
	}
	
	function departmentDelete(){
		$this->load->model("departamentoModel");
		
		$deleteInfo = $this->departamentoModel->delete();		
		
		echo json_encode($deleteInfo);
	}


	function departmentValidateAndSave(){
		$this->load->model("departamentoModel");
		$retArray = array();
		
		$validationInfo = $this->departamentoModel->saveValidation();
		
		if($validationInfo["status"] == 0){//Los datos ingresados pasaron las validaciones
			$idDepto =  $this->input->post("idDepto");
			
			if($idDepto == ""){//Si no se recibe el id, los datos se guardarán como un nuevo registro
				$retArray = $this->departamentoModel->create();
			}
			else{
				$retArray = $this->departamentoModel->update();
			}
						
		}		
		else{//Los datos ingresados no pasaron las validaciones
			$retArray = $validationInfo;
		}
		
		echo json_encode($retArray);	
	}
	
}