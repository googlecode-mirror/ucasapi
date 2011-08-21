<?php
class Rol extends CI_Controller{

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
				
				$this->load->view("rolView", array("menu"=> $menu, "userName" => $userName, "roleName" => str_replace("%20", " ", $roleName)));//Se agrega el código del menú y el nombre del usuario como variables al view
				
			}
			else{//Si el usuario no tiene permiso para acceder a la página se redirige a la anterior				
				redirect($previousPage,"refresh");
			}
						
		}
		else{//Si no existe usuario en sesión se redirige al login
			redirect("login", "refresh");
		}
	}
	
	function rolRead(){
		$this->load->model("rolModel");	
		echo json_encode($this->rolModel->read());
	}
	
	
	function rolAutocompleteRead(){
		$this->load->model("rolModel");
		
		$autocompleteData = $this->rolModel->autocompleteRead();		
		
		echo json_encode($autocompleteData);
	}
	
	function rolDelete(){
		$this->load->model("rolModel");
		
		$deleteInfo = $this->rolModel->delete();		
		
		echo json_encode($deleteInfo);
	}


	function rolValidateAndSave(){
		$this->load->model("rolModel");
		$retArray = array();
		
		$validationInfo = $this->rolModel->saveValidation();
		
		if($validationInfo["status"] == 0){//Los datos ingresados pasaron las validaciones
			$idRol =  $this->input->post("idRol");
			
			if($idRol == ""){//Si no se recibe el id, los datos se guardarán como un nuevo registro
				$retArray = $this->rolModel->create();
			}
			else{
				$retArray = $this->rolModel->update();
			}
						
		}		
		else{//Los datos ingresados no pasaron las validaciones
			$retArray = $validationInfo;
		}
		
		echo json_encode($retArray);	
	}
	
}