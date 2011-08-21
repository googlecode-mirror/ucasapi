<?php

class Actividadg extends CI_Controller{
	
	function index(){
		$this->load->helper(array('form', 'url'));
		$this->load->view("actividadgView");
	}
	
	function actividadgRead($idUsuario){
		$this->load->model("actividadgModel");
		echo json_encode($this->actividadgModel->actividadRead($idUsuario));
	}
	
}