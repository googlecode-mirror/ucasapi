<?php
class Departamento extends CI_Controller{

	function index(){
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
		$this->load->model("roleOptionsModel");	
		
		$controllerName = strtolower(get_class($this));
		
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
				
				$this->load->view("departamentoView", array("menu"=> $menu, "userName" => $userName, "roleName" => str_replace("%20", " ", $roleName)));//Se agrega el código del menú y el nombre del usuario como variables al view
				
			}
			else{//Si el usuario no tiene permiso para acceder a la página se redirige a la anterior				
				$previousPage = $this->session->userdata("currentPage");
				redirect($previousPage,"refresh");
			}
						
		}
		else{//Si no existe usuario en sesión se redirige al login
			redirect("login", "refresh");
		}
		
	}
	
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	function departmentRead(){
		$this->load->model("departamentoModel");	
		echo json_encode($this->departamentoModel->read());
	}
	
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	function departmentAutocompleteRead(){
		$this->load->model("departamentoModel");
		
		$autocompleteData = $this->departamentoModel->autocompleteRead();		
		
		echo json_encode($autocompleteData);
	}
	
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	function departmentDelete(){
		$this->load->model("departamentoModel");
		
		$deleteInfo = $this->departamentoModel->delete();		
		
		echo json_encode($deleteInfo);
	}
	
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------


	function departmentValidateAndSave(){
		$this->load->model("departamentoModel");
		$retArray = array();
		
		$validationInfo = $this->departamentoModel->saveValidation();
		
		if($validationInfo["status"] == 0){//Los datos ingresados pasaron las validaciones
			$idDepto =  $this->input->post("idDepto");
			
			if($idDepto == ""){//Si no se recibe el id, los datos se guardarán como un nuevo registro
				$retArray = $this->departamentoModel->create();
			}
			else{
				$retArray = $this->departamentoModel->update();
			}
						
		}		
		else{//Los datos ingresados no pasaron las validaciones
			$retArray = $validationInfo;
		}
		
		echo json_encode($retArray);	
	}
	
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	
	function gridRead($idDepto){
		$this->load->model("departamentoModel");	
		echo json_encode($this->departamentoModel->gridDepartamentoRead($idDepto));
	}
	
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
}