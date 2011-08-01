<?php

class Proyecto extends CI_Controller{

	function index(){
		$this->load->helper(array('form', 'url'));
		$this->load->view("proyectoView");
	}

	function proyectoRead(){
		$this->load->model("proyectoModel");
		echo json_encode($this->proyectoModel->read());
	}

	function proyectoAutocompleteRead(){
		$this->load->model("proyectoModel");
		echo json_encode($this->proyectoModel->autocompleteRead());
	}

	function proyectoUsuarioAutocompleteRead(){
		$this->load->model("proyectoModel");
		echo json_encode($this->proyectoModel->autocompleteUsuarioProyectoRead());
	}


	function proyectoDelete(){
		$this->load->model("proyectoModel");

		$deleteInfo = $this->proyectoModel->delete();

		echo json_encode($deleteInfo);
	}

	function proyectoValidateAndSave(){
		$this->load->model("proyectoModel");
		$retArray = array();

		$validationInfo = $this->proyectoModel->saveValidation();

		if($validationInfo["status"] == 0){//Los datos ingresados pasaron las validaciones
			$idProyecto =  $this->input->post("idProyecto");
				
			if($idProyecto == ""){//Si no se recibe el id, los datos se guardarán como un nuevo registro
				$retArray = $this->proyectoModel->create();
			}
			else{
				$retArray = $this->proyectoModel->update();
			}

		}
		else{//Los datos ingresados no pasaron las validaciones
			$retArray = $validationInfo;
		}

		echo json_encode($retArray);
	}

}

?>