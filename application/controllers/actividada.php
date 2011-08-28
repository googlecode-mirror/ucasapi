<?php
class Actividada extends CI_Controller{

	function index($anioSolicitud=null, $correlAnio=null){
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
		$this->load->model("roleOptionsModel");	
		
		$controllerName = strtolower(get_class($this));
		$filePath = base_url()."uploads/";
		
		$previousPage = $this->session->userdata("currentPage");
		$previousPage = ($previousPage!="")?$previousPage:"buzon";
						
		$idRol = $this->session->userdata("idRol");//Se agrega en $idRol el dato correspondiente de la sesi�n
		
		if($idRol != ""){//Si est� en sesi�n
			$allowedPage = $this->roleOptionsModel->validatePage($idRol, $controllerName); 
			
			if($allowedPage){//Si el usuario seg�n rol tiene permiso para acceder a la p�gina
				$this->session->set_userdata("previousPage", $previousPage);
				$this->session->set_userdata("currentPage", $controllerName);
				
				$menu = $this->roleOptionsModel->showMenu($idRol);//Se genera el men�
				$userName = $this->session->userdata("username");//Se obtiene el nombre de usuario de la sesi�n
				$roleName = $this->session->userdata("roleName");
				$idUsuario = $this->session->userdata("idUsuario");
				
				$params = array("menu"=> $menu, "idUsuario" => $idUsuario,"userName" => $userName, 
								"roleName" => str_replace("%20", " ", $roleName), "filePath" => $filePath);
				
				if ($anioSolicitud != null && $correlAnio != null) {
					$params["anioSolicitud"] = $anioSolicitud;
					$params["correlAnio"] = $correlAnio;
				}
				
				$this->load->view("actividadaView", $params);//Se agrega el c�digo del men� y el nombre del usuario como variables al view
				
			}
			else{//Si el usuario no tiene permiso para acceder a la p�gina se redirige a la anterior				
				redirect($previousPage,"refresh");
			}
						
		}
		else{//Si no existe usuario en sesi�n se redirige al login
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
	
	function activityDelete(){
		$this->load->model("actividadaModel");
		
		$deleteInfo = $this->actividadaModel->delete();		
		
		echo json_encode($deleteInfo);
	}
	
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------


	function activityValidateAndSave(){
		$this->load->model("actividadaModel");
		$retArray = array();
		
		$validationInfo = $this->actividadaModel->saveValidation();
		
		if($validationInfo["status"] == 0){//Los datos ingresados pasaron las validaciones
			$idActividad =  $this->input->post("idActividad");
			$accionActual =  $this->input->post("accionActual");
			
			if($accionActual == ""){//Si no se recibe el id, los datos se guardar�n como un nuevo registro
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
	
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	function gridUsers1Read($idActividad){
			$this->load->model("actividadaModel");	
			echo json_encode($this->actividadaModel->gridUsuarios1Read($idActividad));
	}
	
	function gridResponsiblesRead($idActividad){
			$this->load->model("actividadaModel");	
			echo json_encode($this->actividadaModel->gridResponsablesRead($idActividad));
	}
	
	function gridProjectsRead($idActividad){
			$this->load->model("actividadaModel");	
			echo json_encode($this->actividadaModel->gridProyectosRead($idActividad));
	}
	
	function gridRProjectsRead($idActividad){
			$this->load->model("actividadaModel");	
			echo json_encode($this->actividadaModel->gridRProyectosRead($idActividad));
	}
	
	
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	function fileValidateAndSave(){
		$this->load->model("actividadaModel");

		$retArray = array();

		$validationInfo = $this->actividadaModel->fileSaveValidation();

		if($validationInfo["status"] == 0){//Los datos ingresados pasaron las validaciones
			$idArchivo =  $this->input->post("idArchivo");
			if($idArchivo == ""){//Si no se recibe el id, los datos se guardar�n como un nuevo registro
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