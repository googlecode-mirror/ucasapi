<?php
class Tipo extends CI_Controller{

	function index(){
		$this->load->helper(array('form', 'url'));
		$this->load->view("tipoView");
	}
	
	function tipoAutocompleteRead(){
		$this->load->model("tipoModel");
		$autocompleteData = $this->tipoModel->autocompleteRead();
		echo json_encode($autocompleteData);
	}
	
}