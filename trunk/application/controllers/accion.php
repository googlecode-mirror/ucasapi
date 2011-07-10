<?php
class Accion extends CI_Controller{

	function index(){
		$this->load->helper(array('form', 'url'));
		$this->load->view("accionView");
	}
	
	function accionRead(){
		$this->load->model("accionModel");	
		echo json_encode($this->accionModel->read());
	}
	
	
	function accionAutocompleteRead(){
		$this->load->model("accionModel");
		
		$autocompleteData = $this->accionModel->autocompleteRead();		
		
		echo json_encode($autocompleteData);
	}
	
	function accionDelete(){
		$this->load->model("accionModel");
		
		$deleteInfo = $this->accionModel->delete();		
		
		echo json_encode($deleteInfo);
	}


	function accionValidateAndSave(){
		$this->load->model("accionModel");
		$retArray = array();
		
		$validationInfo = $this->accionModel->saveValidation();
		
		if($validationInfo["status"] == 0){//Los datos ingresados pasaron las validaciones
			$idAccion =  $this->input->post("idAccion");
			
			if($idAccion == ""){//Si no se recibe el id, los datos se guardarán como un nuevo registro
				$retArray = $this->accionModel->create();
			}
			else{
				$retArray = $this->accionModel->update();
			}
						
		}		
		else{//Los datos ingresados no pasaron las validaciones
			$retArray = $validationInfo;
		}
		
		echo json_encode($retArray);	
	}
	
}