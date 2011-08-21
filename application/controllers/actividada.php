<?php
class Actividada extends CI_Controller{

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
				$idUsuario = $this->session->userdata("idUsuario");
				
				$this->load->view("actividadaView", array("menu"=> $menu, "idUsuario" => $idUsuario,"userName" => $userName, "roleName" => str_replace("%20", " ", $roleName), "filePath" => $filePath));//Se agrega el código del menú y el nombre del usuario como variables al view
				
			}
			else{//Si el usuario no tiene permiso para acceder a la página se redirige a la anterior				
				redirect($previousPage,"refresh");
			}
						
		}
		else{//Si no existe usuario en sesión se redirige al login
			redirect("login", "refresh");
		}		
	}
	
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	function activityRead(){
		$this->load->model("actividadaModel");	
		echo json_encode($this->actividadaModel->read());
	}
	
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	function projectAutocomplete(){
		$this->load->model("proyectoModel");
		
		$autocompleteData = $this->proyectoModel->autocompleteRead();		
		
		echo json_encode($autocompleteData);
	}
	
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	function processAutocomplete($idProyecto){
		$this->load->model("actividadaModel");
		
		$autocompleteData = $this->actividadaModel->processAutocompleteRead($idProyecto);		
		
		echo json_encode($autocompleteData);
	}
	
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	function activityAutocomplete($idProyecto, $idProceso){
		$this->load->model("actividadaModel");
		
		$autocompleteData = $this->actividadaModel->activityAutocompleteRead($idProyecto, $idProceso);		
		
		echo json_encode($autocompleteData);
	}
	
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	function userAutocomplete(){
		$this->load->model("actividadaModel");

		$autocompleteData = $this->actividadaModel->userAutocompleteRead();

		echo json_encode($autocompleteData);
	}
	
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	function priorityAutocomplete(){
		$this->load->model("actividadaModel");

		$autocompleteData = $this->actividadaModel->priorityAutocompleteRead();

		echo json_encode($autocompleteData);
	}
	
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	function statusAutocomplete(){
		$this->load->model("actividadaModel");

		$autocompleteData = $this->actividadaModel->statusAutocompleteRead();

		echo json_encode($autocompleteData);
	}
	
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	function fileTypeAutocomplete(){
		$this->load->model("actividadaModel");

		$autocompleteData = $this->actividadaModel->fileTypeAutocompleteRead();

		echo json_encode($autocompleteData);
	}
	
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	function departmentDelete(){
		$this->load->model("departamentoModel");
		
		$deleteInfo = $this->departamentoModel->delete();		
		
		echo json_encode($deleteInfo);
	}
	
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------


	function activityValidateAndSave(){
		$this->load->model("actividadaModel");
		$retArray = array();
		
		$validationInfo = $this->actividadaModel->saveValidation();
		
		if($validationInfo["status"] == 0){//Los datos ingresados pasaron las validaciones
			$idActividad =  $this->input->post("idActividad");
			
			if($idActividad == ""){//Si no se recibe el id, los datos se guardarán como un nuevo registro
				$retArray = $this->actividadaModel->create();
			}
			else{
				$retArray = $this->actividadaModel->update();
			}
						
		}		
		else{//Los datos ingresados no pasaron las validaciones
			$retArray = $validationInfo;
		}
		
		echo json_encode($retArray);	
	}
	
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	
	function gridUsersRead($idActividad){
			$this->load->model("actividadaModel");	
			echo json_encode($this->actividadaModel->gridUsuariosRead($idActividad));
		}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	function gridFollowersRead($idActividad){
			$this->load->model("actividadaModel");	
			echo json_encode($this->actividadaModel->gridSeguidoresRead($idActividad));
	}
	
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	function fileValidateAndSave(){
		$this->load->model("actividadaModel");

		$retArray = array();

		$validationInfo = $this->actividadaModel->fileSaveValidation();

		if($validationInfo["status"] == 0){//Los datos ingresados pasaron las validaciones
			$idArchivo =  $this->input->post("idArchivo");
			if($idArchivo == ""){//Si no se recibe el id, los datos se guardarán como un nuevo registro
				$retArray = $this->actividadaModel->createActivityFile();
			}
			else{
				$retArray = $this->actividadaModel->updateActivityFile();
			}

		}
		else{//Los datos ingresados no pasaron las validaciones
			$retArray = $validationInfo;
		}

		echo json_encode($retArray);
		//echo json_encode($this->proyectoModel->createProjectFile());
	}
	
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	function gridDocumentsLoad($idActividad){
		$this->load->model("actividadaModel");
		echo json_encode($this->actividadaModel->activityFilesRead($idActividad));
	}
	
}