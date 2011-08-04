<?php

class Upload extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url'));
	}

	function index()	{
		$this->load->view('upload_form', array('error' => ' ' ));
	}

	function do_upload(){
		
		$retArray = array("status"=> 0, "msg" => "", data => array());
		
		$this->load->model("uploadModel");
		$fileName = "doc_";
		
		//Información sobre la tabla asociada al archivo: proyecto, proceso, actividad, ...
		$uploadIdName = $this->input->post("uploadIdName");		
		$uploadIdValue = $this->input->post("uploadIdValue");	

		$fileNameCorr = $this->uploadModel->fileNameCorrelative($uploadIdName,$uploadIdValue);
		
			
		//Colocando la segunda parte del nombre del archivo
		switch ($uploadIdName) {
			
			case "idProyecto": 		$fileName.="proyecto_";
									break;
									
			case "idProceso": 		$fileName.="proceso_";
									break;
									
			case "idActividad": 	$fileName.="actividad_";
									break;
			
			default:				$fileName.="_";
									break;
									
		}
		//Colocando la tercera parte del nombre del archivo
		$fileName.= $uploadIdValue."_".$fileNameCorr["data"];		
		
				
		//Configuración de la subida		
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'doc|docx|xls|xlsx|txt|pdf';
		$config['max_size']	= '2000';//KB
		$config['file_name']	= $fileName;


		$this->load->library('upload', $config);

		//Subiendo el archivo
		if ( ! $this->upload->do_upload()){
			//$error =addslashes($this->upload->display_errors());
			$retArray["status"] = 1;
			$retArray["msg"] = addslashes($this->upload->display_errors());
			echo json_encode($retArray);
			
		}
		else{
			$uploadData = $this->upload->data();		
			//$retArray["data"] = $fileName;
			$retArray["data"] = $uploadData;
			echo json_encode($retArray);
			
		}
	}
}
?>