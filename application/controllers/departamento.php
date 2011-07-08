<?php
class Departamento extends CI_Controller{

	function index(){
		$this->load->helper(array('form', 'url'));
		$this->load->view("departamento_view");
	}
	
	function departmentRead(){
		$this->load->model("departamento_model");	
		echo json_encode($this->departamento_model->read());
	}
	
	
	//Retorna en formato json los datos necesarios para mostrar en el autocomplete
	function departmentAutocompleteRead(){
		$this->load->model("departamento_model");	
		echo json_encode($this->departamento_model->autocompleteRead());
	}


	/*Asumiendo en esta parte que la variable $status servirá para determinar el tipo de mensaje que se mostrará:
		 0: Mensaje de error
		 1: Mensaje de éxito
		 2: Mensaje de información */	
	function departmentValidateAndSave(){
		$this->load->model("departamento_model");
		$returnMsg = $this->departamento_model->saveValidation();
		$status = 1;
		
		if($returnMsg == ""){//Los datos ingresados no pasaron las validaciones
			$idDepto =  $this->input->post("idDepto");
			
			if($idDepto == ""){//Si no se recibe el id, los datos se guardarán como un nuevo registro
				if($this->departamento_model->create()){//create retorna el número de filas afectadas
					$status = 1;
				}
				else{
					$status = 0;
				}
			}
			else{
				if($this->departamento_model->update()){
					$status = 1;
				}
				else{
					$status = 0;
				}
			}
			
		}		
		else{//Los datos ingresados no pasaron las validaciones
			$status = 2;
		}
		
		$returnDataArray = array("status" => $status,"msg" => $returnMsg);
		echo json_encode($returnDataArray);	
	}
	
}