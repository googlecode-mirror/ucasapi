<?php

class Proceso extends CI_Controller{

	function index(){
		$this->load->helper(array('form', 'url'));
		$this->load->view("procesoView");
	}

	function procesoRead(){
		$this->load->model("procesoModel");
		echo json_encode($this->procesoModel->read());
	}


	function procesoAutocompleteRead(){
		$this->load->model("procesoModel");

		$autocompleteData = $this->procesoModel->autocompleteRead();

		echo json_encode($autocompleteData);
	}

	/*ESTA ES LA QUE HAY QUE CAMBIAR*/
	function procesoProyectoAutocompleteRead(){
		$this->load->model("proyectoModel");

		$autocompleteData = $this->proyectoModel->autocompleteRead();

		echo json_encode($autocompleteData);
	}

	function procesoFaseAutocompleteRead(){
		$this->load->model("faseModel");

		$autocompleteData = $this->faseModel->autocompleteRead();

		echo json_encode($autocompleteData);
	}

	function procesoEstadoAutocompleteRead(){
		$this->load->model("estadoModel");

		$autocompleteData = $this->estadoModel->autocompleteRead();

		echo json_encode($autocompleteData);
	}
	/*fin de los demas*/


	function procesoDelete(){
		$this->load->model("procesoModel");

		$deleteInfo = $this->procesoModel->delete();

		echo json_encode($deleteInfo);
	}


	function procesoValidateAndSave(){
		$this->load->model("procesoModel");
		$retArray = array();

		$validationInfo = $this->procesoModel->saveValidation();

		if($validationInfo["status"] == 0){//Los datos ingresados pasaron las validaciones
			$idProceso =  $this->input->post("idProceso");
				
			if($idProceso == ""){//Si no se recibe el id, los datos se guardarán como un nuevo registro
				$retArray = $this->procesoModel->create();
			}
			else{
				$retArray = $this->procesoModel->update();
			}

		}
		else{//Los datos ingresados no pasaron las validaciones
			$retArray = $validationInfo;
		}

		echo json_encode($retArray);
	}

}



?>