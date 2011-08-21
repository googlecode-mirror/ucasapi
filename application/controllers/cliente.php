<?php
class Cliente extends CI_Controller {

	function index() {
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));

		$idUsuario = $this->session->userdata("idUsuario");//Se agrega en $idRol el dato correspondiente de la sesiï¿½n

		if($idUsuario == ""){//Si el dato no estï¿½ en sesiï¿½n, se redirige a la pï¿½gina de login
			redirect("login", "refresh");
		}
		else{
			$this->load->view("clienteView");
		}
	}

	function listaSolicitudes(){
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
		$this->load->model("roleOptionsModel");	
		
		$controllerName = "cliente/listaSolicitudes";
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
				
				$this->load->view("listaSolicitudesView", array("menu"=> $menu, "idUsuario" => $idUsuario,"userName" => $userName, "roleName" => str_replace("%20", " ", $roleName), "filePath" => $filePath));//Se agrega el código del menú y el nombre del usuario como variables al view
				
			}
			else{//Si el usuario no tiene permiso para acceder a la página se redirige a la anterior				
				redirect($previousPage,"refresh");
			}						
		}
		else{//Si no existe usuario en sesión se redirige al login
			redirect("login", "refresh");
		}		
	}

	function resumenProyectos() {
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
		$this->load->model("roleOptionsModel");	
		
		$controllerName = "cliente/resumenProyectos";
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
				
				$this->load->view("resumenProyectosView", array("menu"=> $menu, "idUsuario" => $idUsuario,"userName" => $userName, "roleName" => str_replace("%20", " ", $roleName), "filePath" => $filePath));//Se agrega el código del menú y el nombre del usuario como variables al view
				
			}
			else{//Si el usuario no tiene permiso para acceder a la página se redirige a la anterior				
				redirect($previousPage,"refresh");
			}						
		}
		else{//Si no existe usuario en sesión se redirige al login
			redirect("login", "refresh");
		}	
	}

	function gridProyectosUsuario($idUsuario) {
		$this->load->model("proyectoModel");
		echo json_encode($this->proyectoModel->gridProyectosUsuario($idUsuario));
	}

	function faseProyectoRead(){
		$this->load->model("proyectoModel");
		echo json_encode($this->proyectoModel->faseProyectoRead());
	}
}