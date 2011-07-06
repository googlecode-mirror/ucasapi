<?php
class HelloWorldController extends CI_Controller {
	
	function index() {
		$this->load->view('holaMundo');
	}
	
}