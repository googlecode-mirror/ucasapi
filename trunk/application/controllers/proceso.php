<?php

class Proceso extends CI_Controller{

	function index(){
	$this->load->library('session');
		$this->load->helper(array('form', 'url'));
		$this->load->model("roleOptionsModel");	
		
		$controllerName = strtolower(get_class($this));
		$filePath = base_url()."uploads/";
		
		$previousPage = $this->session->userdata("currentPage");
		$previousPage = ($previousPage!="")?$previousPage:"buzon";
						
		$idRol = $this->session->userdata("idRol");//Se agrega en $idRol el dato correspondiente de la sesión
		
		if($idRol != ""){//Si está en sesión
			$allowedPage = $this->roleOptionsModel->validatePage($idRol, $controllerName); 
			
			if($allowedPage){//Si el usuario según rol tiene permiso para acceder a la página
				$this->session->set_userdata("previousPage", $previousPage);
				$this->session->set_userdata("currentPage", $controllerName);
				
				$menu = $this->roleOptionsModel->showMenu($idRol);//Se genera el menú
				$userName = $this->session->userdata("username");//Se obtiene el nombre de usuario de la sesión
				$roleName = $this->session->userdata("roleName");
				$idRol = $this->session->userdata("idRol");
				$idUsuario = $this->session->userdata("idUsuario");
				
				$this->load->view("procesoView", array("menu"=> $menu, "userName" => $userName, "roleName" => str_replace("%20", " ", $roleName), "idRol" => $idRol, "idUsuario" => $idUsuario,  "filePath" => $filePath));//Se agrega el código del menú y el nombre del usuario como variables al view
				
			}
			else{//Si el usuario no tiene permiso para acceder a la página se redirige a la anterior				
				redirect($previousPage,"refresh");
			}
						
		}
		else{//Si no existe usuario en sesión se redirige al login
			redirect("login", "refresh");
		}
	}
	
	function faseAutocompleteRead($idProyecto){
		$this->load->model("procesoModel");
		echo json_encode($this->procesoModel->faseRead($idProyecto));
	}

	function procesoRead(){
		$this->load->model("procesoModel");
		echo json_encode($this->procesoModel->read());
	}
	
	function gridFasesProceso($idProceso){
		$this->load->model("procesoModel");
		echo json_encode($this->procesoModel->readGrid($idProceso));
	}

	function procesoAutocompleteRead($idProyecto){
		$this->load->model("procesoModel");

		$autocompleteData = $this->procesoModel->autocompleteRead($idProyecto);

		echo json_encode($autocompleteData);
	}
	
	function proyectoAutocompleteRead($idUsuario,$idRol){
		$this->load->model("procesoModel");

		$autocompleteData = $this->procesoModel->proyectoAutocompleteRead($idUsuario,$idRol);

		echo json_encode($autocompleteData);
	}

	function procesoFaseAutocompleteRead(){
		$this->load->model("faseModel");

		$autocompleteData = $this->faseModel->autocompleteRead();

		echo json_encode($autocompleteData);
	}

	function procesoEstadoAutocompleteRead($idTipo){
		$this->load->model("procesoModel");

		$autocompleteData = $this->procesoModel->estadoAutocomplete($idTipo);

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
			$accionActual = $this->input->post("accionActual");
			
			if($accionActual == ""){//Si recibo 0 entonces se guardaran como un nuevo registro
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
	
/*------------------------------------- FUNCIONES BIBLIOTECA -------------------------------------*/

	function gridDocumentsLoad($idProceso){
		$this->load->model("procesoModel");
		echo json_encode($this->procesoModel->processFilesRead($idProceso));
	}

	function fileValidateAndSave(){
		$this->load->model("procesoModel");

		$retArray = array();

		$validationInfo = $this->procesoModel->fileSaveValidation();

		if($validationInfo["status"] == 0){//Los datos ingresados pasaron las validaciones
			$idArchivo =  $this->input->post("idArchivo");
			if($idArchivo == ""){//Si no se recibe el id, los datos se guardarán como un nuevo registro
				$retArray = $this->procesoModel->createProcessFile();
			}
			else{
				$retArray = $this->procesoModel->updateProcessFile();
			}

		}
		else{//Los datos ingresados no pasaron las validaciones
			$retArray = $validationInfo;
		}

		echo json_encode($retArray);
		//echo json_encode($this->proyectoModel->createProjectFile());
	}


	function fileDelete(){
		$this->load->model("procesoModel");

		$deleteInfo = $this->procesoModel->fileDataDelete();

		echo json_encode($deleteInfo);
	}

}



?>