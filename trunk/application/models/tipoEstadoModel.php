<?php

class tipoEstadoModel extends CI_Model{

	function autocompleteRead(){
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
		
		$this->load->database();		
		//Verificando correcta conexión a la base de datos
		if (!$this->db->conn_id) {
			$retArray["status"] = 2;
			$retArray["msg"] = database_cn_error_msg();
			return $retArray;
		}

		$sql = "SELECT idTipoEstado, nombreTipoEstado FROM TIPO_ESTADO";
		$query = $this->db->query($sql);

		if($query){
			if($query->num_rows > 0){
				foreach ($query->result() as $row){
					$rowArray = array();
					$rowArray["id"] = $row->idTipoEstado;
					$rowArray["value"] = $row->nombreTipoEstado;
					$retArray["data"][] = $rowArray;
				}
			}
				
		}
		else{
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = (database_error_msg()!="")?database_error_msg():$this->db->_error_message();
		}

		return $retArray;

	}

	function saveValidation(){
		$this->load->library('form_validation');

		$retArray = array("status"=> 0, "msg" => "");

		$this->form_validation->set_rules("nombreTipo", "Nombre de Estado", 'required|alpha');

		if($this->form_validation->run() == false){
			$retArray["status"] = 1;
				
			$retArray["msg"] .= form_error("nombreTipo");
		}

		return $retArray;
	}

	function delete(){
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
		
		$this->load->database();		
		//Verificando correcta conexión a la base de datos
		if (!$this->db->conn_id) {
			$retArray["status"] = 2;
			$retArray["msg"] = database_cn_error_msg();
			return $retArray;
		}
		$idTipo = $this->input->post("idTipo");

		$sql = "DELETE FROM TIPO_ESTADO WHERE idTipoEstado = " .$idTipo;

		$this->db->trans_start();
		$query = $this->db->query($sql);		
		if ($this->db->trans_status() === FALSE)
		{
			show_error("Please notify support with transaction details");
			$this->db->trans_rollback();
			return $retArray;
		}else{
			$this->db->trans_commit();
		}

		/*$query = $this->db->query($sql);

		if (!$query) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
			log_message("error", "Problem Inserting to ".$table.": ".$errMess." (".$errNo.")");
		}
*/
		return $retArray;

	}

	function update(){
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
		
		$this->load->database();		
		//Verificando correcta conexión a la base de datos
		if (!$this->db->conn_id) {
			$retArray["status"] = 2;
			$retArray["msg"] = database_cn_error_msg();
			return $retArray;
		}

		$idTipo = $this->input->post("idTipo");
		$nombreTipo = $this->input->post("nombreTipo");

		$sql = "UPDATE TIPO_ESTADO SET nombreTipoEstado = ".$this->db->escape($nombreTipo)." WHERE idTipoEstado = " .$idTipo;

		$query = $this->db->query($sql);

		if (!$query) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = (database_error_msg()!="")?database_error_msg():$this->db->_error_message();
		}

		return $retArray;
	}

	function create(){
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
		
		$this->load->database();		
		//Verificando correcta conexión a la base de datos
		if (!$this->db->conn_id) {
			$retArray["status"] = 2;
			$retArray["msg"] = database_cn_error_msg();
			return $retArray;
		}

		$nombreTipo = $this->input->post("nombreTipo");

		$sql = "INSERT INTO TIPO_ESTADO(nombreTipoEstado) VALUES(" .$this->db->escape($nombreTipo). ")";

		$query = $this->db->query($sql);

		if(!$query){
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = (database_error_msg()!="")?database_error_msg():$this->db->_error_message();
		}

		return $retArray;
	}

	function read(){
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
		
		$this->load->database();		
		//Verificando correcta conexión a la base de datos
		if (!$this->db->conn_id) {
			$retArray["status"] = 2;
			$retArray["msg"] = database_cn_error_msg();
			return $retArray;
		}
		$idTipo = $this->input->post("idTipo");

		$sql = 	"SELECT nombreTipoEstado FROM TIPO_ESTADO WHERE idTipoEstado = " .$idTipo;

		$query = $this->db->query($sql);

		if($query){
			$row = $query->row_array();
			$retArray["data"] = $row;
		}
		else{
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = (database_error_msg()!="")?database_error_msg():$this->db->_error_message();
		}

		return $retArray;

	}



}