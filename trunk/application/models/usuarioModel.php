<?php
class UsuarioModel extends CI_Model{
	
	
	function create(){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "");
		
		$username = $this->input->post("username");
		$password = $this->input->post("password");
		$primerNombre = $this->input->post("primerNombre");
		$primerApellido = $this->input->post("primerApellido");
		$otrosNombres = $this->input->post("otrosNombres");
		$otrosApellidos = $this->input->post("otrosApellidos");
		$codEmp = $this->input->post("codEmp");
		$dui = $this->input->post("dui");
		$nit = $this->input->post("nit");
		$isss = $this->input->post("isss");
		$emailPersonal = $this->input->post("emailPersonal");
		$emailInstitucional = $this->input->post("emailInstitucional");
		$nup = $this->input->post("nup");
		$carnet = $this->input->post("carnet");
		$activo = $this->input->post("activo");
		$idDepto = (int) $this->input->post("idDepto");
		$idCargo = (int) $this->input->post("idCargo");
		
		
		
		$sql = "INSERT INTO USUARIO (username, password, primerNombre, primerApellido, otrosNombres, otrosApellidos, codEmp, dui, nit, isss, emailPersonal, emailInstitucional, nup, carnet, idDepto, idCargo, activo)
				VALUES (".$this->db->escape($username).", ".$this->db->escape($password).", ".$this->db->escape($primerNombre).", ".$this->db->escape($primerApellido)."
				, ".$this->db->escape($otrosNombres).", ".$this->db->escape($otrosApellidos).", ".$this->db->escape($codEmp).", ".$this->db->escape($dui).", ".$this->db->escape($nit)."
				, ".$this->db->escape($isss).", ".$this->db->escape($emailPersonal).", ".$this->db->escape($emailInstitucional).", ".$this->db->escape($nup)."
				, ".$this->db->escape($carnet).", ".$this->db->escape($idDepto).", ".$this->db->escape($idCargo).",".$this->db->escape($activo).")";
		
		
		$query = $this->db->query($sql);
		
		if (!$query){
	     	$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
	    }
	    
		return $retArray;		
	}
	
	
	function read(){
		$this->load->database();

		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
		
		$idUsuario = $this->input->post("idUsuario");		
		
		$sql = "SELECT idUsuario, username, password, primerNombre, otrosNombres, primerApellido, otrosApellidos, codEmp, dui, nit, isss, emailPersonal, emailInstitucional, nup, carnet, activo, d.nombreDepto nombreDepto, c.nombreCargo nombreCargo, d.idDepto, c.idCargo 
				FROM DEPARTAMENTO D, USUARIO U, CARGO C
				WHERE D.idDepto = U.idDepto AND U.idCargo = C.idCargo AND 
				idUsuario = ".$idUsuario;
		
		$query = $this->db->query($sql);
		
		if ($query) {
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
		
		$idUsuario = $this->input->post("idUsuario");
		$username = $this->input->post("username");
		$password = $this->input->post("password");
		$primerNombre = $this->input->post("primerNombre");
		$primerApellido = $this->input->post("primerApellido");
		$otrosNombres = $this->input->post("otrosNombres");
		$otrosApellidos = $this->input->post("otrosApellidos");
		$codEmp = $this->input->post("codEmp");
		$dui = $this->input->post("dui");
		$nit = $this->input->post("nit");
		$isss = $this->input->post("isss");
		$emailPersonal = $this->input->post("emailPersonal");
		$emailInstitucional = $this->input->post("emailInstitucional");
		$nup = $this->input->post("nup");
		$carnet = $this->input->post("carnet");
		$activo = $this->input->post("activo");
		$idDepto = $this->input->post("idDepto");
		$idCargo = $this->input->post("idCargo");	
		
		$sql = "UPDATE USUARIO 
				SET username=".$this->db->escape($username).",
				    password=".$this->db->escape($password).",
				    primerNombre=".$this->db->escape($primerNombre).",
				    primerApellido=".$this->db->escape($primerApellido).",
				    otrosNombres=".$this->db->escape($otrosNombres).",
				    otrosApellidos=".$this->db->escape($otrosApellidos).",
				    codEmp=".$this->db->escape($codEmp).",
				    dui=".$this->db->escape($dui).",
				    nit=".$this->db->escape($nit).",
				    isss=".$this->db->escape($isss).",
				    emailPersonal=".$this->db->escape($emailPersonal).",
				    emailInstitucional=".$this->db->escape($emailInstitucional).",
				    nup=".$this->db->escape($nup).",
				    carnet=".$this->db->escape($carnet).",
				    idDepto=".$this->db->escape($idDepto).",
				    idCargo=".$this->db->escape($idCargo).",
				    activo=".$this->db->escape($activo)."
				     WHERE idUsuario = ". $idUsuario;	
		
		$query = $this->db->query($sql);
		
		if (!$query) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
	    }
		return $retArray;		
	}
	

	function delete(){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "");
		
		$idUsuario = $this->input->post("idUsuario");
		
		$sql = "UPDATE USUARIO
				SET ACTIVO = '1' 
				WHERE idUsuarios = ". $idUsuario;
   				
		$query = $this->db->query($sql);
		
		if (!$query) {
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
	    }
		
		return $retArray;	
	}
	
	
	function autocompleteRead(){
		$this->load->database();
		
		$retArray = array("status"=> 0, "msg" => "", "data"=>array());
		
		$sql = "SELECT idUsuario, CONCAT(primerNombre,' ', OtrosNombres,' ',primerApellido,' ',otrosApellidos,' ') nombreUsuario FROM USUARIO";
		$query = $this->db->query($sql);		
	
		if($query){
			if($query->num_rows > 0){			
				foreach ($query->result() as $row){		
					$rowArray = array();
					$rowArray["id"] = $row->idUsuario;
					$rowArray["value"] = $row->nombreUsuario;
					
					$retArray["data"][] = $rowArray;				
				}							
			}
		}
		else{
			$retArray["status"] = $this->db->_error_number();
			$retArray["msg"] = $this->db->_error_message();
		}
		
		return $retArray;
	}
	
	
	//Devuelve en la variable $msg, los mensajes para los errores detectados por no cumplir las validaciones aplicadas usando la librería form_validation
	function saveValidation(){
		$this->load->library('form_validation');
		//print_r($_POST);
		
		$retArray = array("status"=> 0, "msg" => "");
		
		//Colocando las reglas para los campos, el segundo parámetro es el nombre del campo que aparecerá en el mensaje
		//Habrá que reemplazar los mensajes, pues por el momento están en inglés
		$this->form_validation->set_rules("primerNombre", "Primer Nombre", 'required');
		$this->form_validation->set_rules("primerApellido", "Apellidos", 'required');
		$this->form_validation->set_rules("username", "username", 'required');
		$this->form_validation->set_rules("password", "password", 'required');
		$this->form_validation->set_rules("dui", "DUI", 'required');	
		$this->form_validation->set_rules("nit", "NIT", 'required');	
		$this->form_validation->set_rules("isss", "ISSS", 'required');
		$this->form_validation->set_rules("codEmp", "Codigo Empleado", 'required');
		$this->form_validation->set_rules("isss", "ISSS", 'required');		
		
		$this->form_validation->set_message('required', 'El campo "%s" es requerido');
		
		if ($this->form_validation->run() == false){//Si al menos una de las reglas no se cumplió...
			//Concatenamos en $msg los mensajes de errores generados para cada campo, lo tenga o no
			$retArray["status"] = 1;
			
			$retArray["msg"] .= form_error("primerNombre");
			$retArray["msg"] .= form_error("primerApellido");
			$retArray["msg"] .= form_error("username");
			$retArray["msg"] .= form_error("password");
			$retArray["msg"] .= form_error("dui");
			$retArray["msg"] .= form_error("nit");
			$retArray["msg"] .= form_error("isss");
			$retArray["msg"] .= form_error("codEmp");
			$retArray["msg"] .= form_error("isss");
			
		}
		
		return $retArray;
	}	
	
}