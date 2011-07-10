<?php
class Rol extends CI_Controller{

	function index(){
		$this->load->helper(array('form', 'url'));
		$this->load->view("rolView");
	}
	
	function rolRead(){
		$this->load->model("rolModel");	
		echo json_encode($this->rolModel->read());
	}
	
	
	function rolAutocompleteRead(){
		$this->load->model("rolModel");
		
		$autocompleteData = $this->rolModel->autocompleteRead();		
		
		echo json_encode($autocompleteData);
	}
	
	function rolDelete(){
		$this->load->model("rolModel");
		
		$deleteInfo = $this->rolModel->delete();		
		
		echo json_encode($deleteInfo);
	}


	function rolValidateAndSave(){
		$this->load->model("rolModel");
		$retArray = array();
		
		$validationInfo = $this->rolModel->saveValidation();
		
		if($validationInfo["status"] == 0){//Los datos ingresados pasaron las validaciones
			$idRol =  $this->input->post("idRol");
			
			if($idRol == ""){//Si no se recibe el id, los datos se guardarán como un nuevo registro
				$retArray = $this->rolModel->create();
			}
			else{
				$retArray = $this->rolModel->update();
			}
						
		}		
		else{//Los datos ingresados no pasaron las validaciones
			$retArray = $validationInfo;
		}
		
		echo json_encode($retArray);	
	}
	
}