<?php

class Proyecto extends CI_Controller{

	function index(){
		$this->load->helper(array('form', 'url'));

		$filePath = array('filePath' => base_url()."uploads/");
		$this->load->view("proyectoView", $filePath);
	}


	function proyectoRead(){
		$this->load->model("proyectoModel");
		echo json_encode($this->proyectoModel->read());
	}
	
	function proyectoUsuarioEncRead(){
		$this->load->model("proyectoModel");
		echo json_encode($this->proyectoModel->readUsuariosEnc());
	}
	
	function proyectoFaseRead(){
		$this->load->model("proyectoModel");
		echo json_encode($this->proyectoModel->faseRead());
	}

	function proyectoAutocompleteRead(){
		$this->load->model("proyectoModel");
		echo json_encode($this->proyectoModel->autocompleteRead());
	}

	function proyectoUsuarioAutocompleteRead(){
		$this->load->model("proyectoModel");
		echo json_encode($this->proyectoModel->autocompleteUsuarioProyectoRead());
	}
	
	function gridFasesProyecto($idProyecto){
		$this->load->model("proyectoModel");
		echo json_encode($this->proyectoModel->gridFasesRead($idProyecto));
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

	/*------------------------------------- FUNCIONES BIBLIOTECA -------------------------------------*/

	function gridDocumentsLoad($idProyecto){
		$this->load->model("proyectoModel");
		echo json_encode($this->proyectoModel->projectFilesRead($idProyecto));
	}

	function fileValidateAndSave(){
		$this->load->model("proyectoModel");

		$retArray = array();

		$validationInfo = $this->proyectoModel->fileSaveValidation();

		if($validationInfo["status"] == 0){//Los datos ingresados pasaron las validaciones
			$idArchivo =  $this->input->post("idArchivo");
			if($idArchivo == ""){//Si no se recibe el id, los datos se guardarán como un nuevo registro
				$retArray = $this->proyectoModel->createProjectFile();
			}
			else{
				$retArray = $this->proyectoModel->updateProjectFile();
			}

		}
		else{//Los datos ingresados no pasaron las validaciones
			$retArray = $validationInfo;
		}

		echo json_encode($retArray);
		//echo json_encode($this->proyectoModel->createProjectFile());
	}


	function fileDelete(){
		$this->load->model("proyectoModel");

		$deleteInfo = $this->proyectoModel->fileDataDelete();

		echo json_encode($deleteInfo);
	}



}

?>