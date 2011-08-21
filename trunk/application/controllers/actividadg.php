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
	
	function actividad($idActividad, $idProyecto){
		$this->load->library('session');
		$this->load->helper(array('url'));
		
		//$this->session->set_userdata("idActividad", $idActividad);
		//$this->session->set_userdata("idProyecto", $idProyecto);
		
		//redirect("actividad","refresh");
		$data = array();
		$data["idActividad"] = $idActividad;
		$data["idProyecto"] = $idProyecto;
		
		$this->load->view("actividadView", $data);
		
	}
	
}