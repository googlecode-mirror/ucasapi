<?php
class Buzon extends CI_Controller{
	function index(){
		$this->load->helper(array('form', 'url'));
		$this->load->view("buzonView");
	}
	
	function gridMensajesBuzon($idUsuario){
		$this->load->model("buzonModel");
		echo json_encode($this->buzonModel->read($idUsuario));
	}
	
}