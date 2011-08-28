<?php

class Proyecto extends CI_Controller{

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
				
				$this->load->view("proyectoView", array("menu"=> $menu, "userName" => $userName, "roleName" => str_replace("%20", " ", $roleName), "idRol" => $idRol, "idUsuario" => $idUsuario, "filePath" => $filePath));//Se agrega el código del menú y el nombre del usuario como variables al view				
			}
			else{//Si el usuario no tiene permiso para acceder a la página se redirige a la anterior				
				redirect($previousPage,"refresh");
			}
						
		}
		else{//Si no existe usuario en sesión se redirige al login
			redirect("login", "refresh");
		}
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

	function proyectoAutocompleteRead($idUsuario,$idRol){
		$this->load->model("proyectoModel");
		echo json_encode($this->proyectoModel->autocompleteRead($idUsuario,$idRol));
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
			$accionActual =  $this->input->post("accionActual");

			if($accionActual == ""){//Si no se recibe el id, los datos se guardarán como un nuevo registro
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