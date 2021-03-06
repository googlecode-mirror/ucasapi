<?php

class Estado extends CI_Controller{

	function index(){
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
		$this->load->model("roleOptionsModel");	
		
		$controllerName = strtolower(get_class($this));
		
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
				
				$this->load->view("estadoView", array("menu"=> $menu, "userName" => $userName, "roleName" => str_replace("%20", " ", $roleName)));//Se agrega el c�digo del men� y el nombre del usuario como variables al view
				
			}
			else{//Si el usuario no tiene permiso para acceder a la p�gina se redirige a la anterior
				redirect($previousPage,"refresh");
			}
						
		}
		else{//Si no existe usuario en sesi�n se redirige al login
			redirect("login", "refresh");
		}
		
	}
	
	function statusRead(){
		$this->load->model("estadoModel");	
		echo json_encode($this->estadoModel->read());
	}
	
	
	function statusAutocompleteRead(){
		$this->load->model("estadoModel");
		
		$autocompleteData = $this->estadoModel->autocompleteRead();		
		
		echo json_encode($autocompleteData);
	}
	
	function statusTypeAutocompleteRead(){
		$this->load->model("estadoModel");
		
		$autocompleteData = $this->estadoModel->statusTypeAutocomplete();		
		
		echo json_encode($autocompleteData);
	}
	
	function statusDelete(){
		$this->load->model("estadoModel");
		
		$deleteInfo = $this->estadoModel->delete();		
		
		echo json_encode($deleteInfo);
	}


	function statusValidateAndSave(){
		$this->load->model("estadoModel");
		$retArray = array();
		
		$validationInfo = $this->estadoModel->saveValidation();
		
		if($validationInfo["status"] == 0){//Los datos ingresados pasaron las validaciones
			$idEstado =  $this->input->post("idEstado");
			$accionActual =  $this->input->post("accionActual");
			
			if($accionActual == ""){//Si no se recibe el id, los datos se guardar�n como un nuevo registro
				$retArray = $this->estadoModel->create();
			}
			else{
				$retArray = $this->estadoModel->update();
			}
						
		}		
		else{//Los datos ingresados no pasaron las validaciones
			$retArray = $validationInfo;
		}
		
		echo json_encode($retArray);	
	}
	
}



?>