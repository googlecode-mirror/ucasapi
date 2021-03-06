<?php

class Actividadh extends CI_Controller{

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
				$idRol = $this->session->userdata("idRol");
				$idUsuario = $this->session->userdata("idUsuario");

				$this->load->view("actividadhView", array("menu"=> $menu, "userName" => $userName, "roleName" => str_replace("%20", " ", $roleName), "idRol" => $idRol, "idUsuario" => $idUsuario));//Se agrega el c�digo del men� y el nombre del usuario como variables al view

			}
			else{//Si el usuario no tiene permiso para acceder a la p�gina se redirige a la anterior
				redirect($previousPage,"refresh");
			}

		}
		else{//Si no existe usuario en sesi�n se redirige al login
			redirect("login", "refresh");
		}
	}

	function actividadhAutocompleteRead($idUsuario, $idRol){
		$this->load->model("actividadhModel");
		echo json_encode($this->actividadhModel->proyRead($idUsuario,$idRol));
	}

	function actividadhProcAutocompleteRead($idProyecto){
		$this->load->model("actividadhModel");
		echo json_encode($this->actividadhModel->procRead($idProyecto));
	}

	function actividadhProcActividades($idProceso){
		$this->load->model("actividadhModel");
		echo json_encode($this->actividadhModel->actProcRead($idProceso));

	}

	function actividadhProyActividades($idProyecto){
		$this->load->model("actividadhModel");
		echo json_encode($this->actividadhModel->actProyRead($idProyecto));

	}

	function actividadhBitacora($idActividad){
		$this->load->model("actividadhModel");
		echo json_encode($this->actividadhModel->actividadBitacora($idActividad));
	}

	function actividadhNoProyProcActividades() {
		$this->load->model("actividadhModel");
		echo json_encode($this->actividadhModel->actividadhNoProyProcActividades());
	}

}