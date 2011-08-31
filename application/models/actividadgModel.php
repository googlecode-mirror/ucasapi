<?php

class actividadgModel extends CI_Model{
	
	function actividadRead($idUsuario){
		$this->load->database();

		$page = $this->input->post("page");
		$limit = $this->input->post("rows");
		$sidx = $this->input->post("sidx");
		$sord = $this->input->post("sord");
		$count = 0;
		if(!$sidx) $sidx =1;

		$sql = "SELECT COUNT(*) FROM USUARIO_ACTIVIDAD";

		$query = $this->db->query($sql);

		if ($query->num_rows() > 0){
			$row = $query->row();
			$count  = $row->count;
		}

		if( $count >0 ){
			$total_pages = ceil($count/$limit);
		}
		else{
			$total_pages = 0;
		}

		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;

		$response->page = $page;
		$response->total = $total_pages;
		$response->records = $count;

		//------------------------------------------------------------------------------------------------------

		$retArray = array("status"=> 0, "msg" => "", "data"=>array());

		$sql = "SELECT DISTINCT a.idActividad, axp.idProyecto, a.nombreActividad, a.fechaFinalizacionPlan, p.nombreProceso, e.estado, pr.nombrePrioridad, uxa.horaAsignacion
				FROM ACTIVIDAD a LEFT JOIN PROCESO p ON a.idProceso = p.idProceso
					INNER JOIN ACTIVIDAD_PROYECTO axp ON a.idActividad = axp.idActividad
					INNER JOIN PROYECTO pt ON axp.idProyecto = pt.idProyecto
					INNER JOIN PRIORIDAD pr ON a.idPrioridad = pr.idPrioridad
					INNER JOIN ESTADO e ON  a.idEstado = e.idEstado
					INNER JOIN USUARIO_ACTIVIDAD uxa ON a.idActividad = uxa.idActividad
 					INNER JOIN USUARIO u ON uxa.idUsuario = u.idUsuario
				WHERE uxa.idUsuario = " .$idUsuario. " AND uxa.activo = '1' 
				ORDER BY uxa.horaAsignacion DESC";

		$query = $this->db->query($sql);

		$i = 0;
		if($query){
			if($query->num_rows > 0){
				foreach ($query->result() as $row){
					$response->rows[$i]["id"] = $row->idActividad;
					$response->rows[$i]["cell"] = array($row->idActividad, $row->idProyecto, $row->nombreActividad, $row->fechaFinalizacionPlan, $row->nombreProceso, $row->estado, $row->nombrePrioridad, $row->horaAsignacion);
					$i++;
				}
			}
		}

		return $response;
	}
	
}