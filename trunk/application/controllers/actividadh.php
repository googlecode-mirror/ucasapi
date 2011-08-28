<?php

class Actividadh extends CI_Controller{
	
	function index(){
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
		$this->load->view("actividadhView");	
	}
	
	function actividadhAutocompleteRead($idUsuario){
		$this->load->model("actividadhModel");
		echo json_encode($this->actividadhModel->proyRead($idUsuario));
	}
	
	function actividadhActividades($idProyecto){
		$this->load->model("actividadhModel");
		echo json_encode($this->actividadhModel->actProyRead($idProyecto));
		
	}
	
	function actividadhBitacora($idActividad){
		$this->load->model("actividadhModel");
		echo json_encode($this->actividadhModel->actividadBitacora($idActividad));
	}
	
}