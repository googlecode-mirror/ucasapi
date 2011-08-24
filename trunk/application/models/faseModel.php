<?php

class faseModel extends CI_Model{

	function autocompleteRead(){
		$this->load->database();

		$retArray = array("status" => 0, "msg" => "", "data" => array());
		$faseList = array();
		$minFase = 0;

		$sql = "SELECT fa.idFase, fa.nombreFase, fa.idFaseSiguiente, min
				FROM FASE fa
				INNER JOIN (select f.idFase min from FASE f
							where f.idFase NOT IN (select coalesce(a.idFaseSiguiente, -1) from FASE a)) MINFASE
				ORDER BY idFase";
		$query = $this->db->query($sql);

		if($query){
			if($query->num_rows > 0){
				/*foreach ($query->result() as $row){
					$rowArray = array();
					$rowArray["id"] = $row->idFase;
					$rowArray["value"] = $row->nombreFase;
					$retArray["data"][] = $rowArray;
				}*/
				foreach ($query->result() as $row){
					$faseList[$row->idFase] = $row;
					$minFase = $row->min;
				}

				$cont = count($faseList);

				while($cont != 0) {
					$rowArray = array();
					$rowArray["id"] = $faseList[$minFase]->idFase;
					$rowArray["value"] = $faseList[$minFase]->nombreFase;

					$retArray["data"][] = $rowArray;
					$minFase = $faseList[$minFase]->idFaseSiguiente;
					$cont--;
				}
			}

		}
		else{
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
		}

		return $retArray;

	}

	function delete(){
		$this->load->database();

		$retArray = array("status" => "0", "msg" => "");
		$idFase = $this->input->post("idFase");

		// ---------------------------------------------------------------------
		$this->db->trans_begin();

		$sql = "select idFase from FASE where idFaseSiguiente = ?"; // $idFase

		$result = $this->db->query($sql, array(intval($idFase)));

		$idFaseUpdate = $result->first_row('array');

		$sql = "select idFaseSiguiente from FASE
						where idFase = ?";

		$result = $this->db->query($sql, array(intval($idFase)));

		$idFaseSiguienteUpdate = $result->first_row('array');

		$sqlUpdate = "update FASE
						set idFaseSiguiente = ?
						where idfase = ?"; // $idFaseUpdate["idFase"]

		$this->db->query($sqlUpdate, array(intval($idFaseSiguienteUpdate["idFaseSiguiente"]), intval($idFaseUpdate["idFase"])));

		$sqlDelete = "DELETE FROM FASE WHERE idFase = " .$idFase;

		$query = $this->db->query($sqlDelete);

		if($this->db->trans_status() == FALSE){
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
		} else {
			$this->db->trans_commit();
		}
		// ---------------------------------------------------------------------

		return $retArray;

	}

	function saveValidation(){
		$this->load->library('form_validation');

		$retArray = array("status"=> 0, "msg" => "");

		$this->form_validation->set_rules("nombreFase", "Nombre", 'required');

		if($this->form_validation->run() == false){
			$retArray["status"] = 1;

			$retArray["msg"] .= form_error("nombreFase");
			$retArray["msg"] .= form_error("descripcion");
		}

		return $retArray;
	}

	function create(){
		$this->load->database();

		$retArray = array("status" => 0, "msg" => "");

		$nombreFase = $this->input->post("nombreFase");
		$descripcion = $this->input->post("descripcion");
		$fasePrevia = $this->input->post("idFasePrevia");
		$faseSiguiente = $this->input->post("idFaseSiguiente");

		if ($fasePrevia == "0") {
			$sql = "INSERT INTO FASE (nombreFase, descripcion, idFaseSiguiente)
				VALUES(" .$this->db->escape($nombreFase). "," .$this->db->escape($descripcion). "," . intval($faseSiguiente) . ")";

			$query = $this->db->query($sql);

			if(!$query){
				$retArray["status"] = $this->db->_error_number();
				$retArray["msg"] = $this->db->_error_message();
			}
		} else if ($faseSiguiente == "0") {
			$sql = "INSERT INTO FASE (nombreFase, descripcion, idFaseSiguiente)
				VALUES(" .$this->db->escape($nombreFase). "," .$this->db->escape($descripcion). ",null)";

			$sql2 = "UPDATE FASE SET idFaseSiguiente = LAST_INSERT_ID() WHERE idFase = " . intval($fasePrevia);

			$this->db->trans_begin();

			$this->db->query($sql);
			$this->db->query($sql2);

			if($this->db->trans_status() == FALSE) {
		     	$retArray["status"] = $this->db->_error_number();
				$retArray["msg"] = $this->db->_error_message();
				$this->db->trans_rollback();
		    } else {
		    	$this->db->trans_commit();
		    }
		} else {
			$sql = "INSERT INTO FASE (nombreFase, descripcion, idFaseSiguiente)
				VALUES(" .$this->db->escape($nombreFase). "," .$this->db->escape($descripcion). "," . intval($faseSiguiente) . ")";

			$sql2 = "UPDATE FASE SET idFaseSiguiente = LAST_INSERT_ID() WHERE idFase = " . intval($fasePrevia);

			$this->db->trans_begin();

			$this->db->query($sql);
			$this->db->query($sql2);

			if($this->db->trans_status() == FALSE) {
		     	$retArray["status"] = $this->db->_error_number();
				$retArray["msg"] = $this->db->_error_message();
				$this->db->trans_rollback();
		    } else {
		    	$this->db->trans_commit();
		    }
		}

		return $retArray;
	}

	function read(){
		$this->load->database();

		$retArray = array("status" => 0, "msg" => "", "data" => array());
		$idFase = $this->input->post("idFase");

		$sql = 	"select ant.idFase anterior, f.idFase, f.nombreFase, f.descripcion, f.idFaseSiguiente siguiente
				from FASE f
				left join FASE ant ON ant.idFaseSiguiente = f.idFase
				where f.idFase = " .$idFase;

		$query = $this->db->query($sql);

		if($query){
			$row = $query->row_array();
			$retArray["data"] = $row;
		}
		else{
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
		}

		return $retArray;

	}

	function update(){
		$this->load->database();

		$retArray = array("status"=> 0, "msg" => "");

		$idFase = $this->input->post("idFase");
		$nombreFase = $this->input->post("nombreFase");
		$descripcion = $this->input->post("descripcion");

		$sql = "UPDATE FASE SET nombreFase = ".$this->db->escape($nombreFase).", descripcion = ".$this->db->escape($descripcion). " WHERE idFase = " .$idFase;

		$query = $this->db->query($sql);

		if (!$query) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
	    }

		return $retArray;
	}


}
