<?php
class Buzon extends CI_Controller{
	function index(){
		$this->load->helper(array('form', 'url'));
		$this->load->view("buzonView");
	}
	
}