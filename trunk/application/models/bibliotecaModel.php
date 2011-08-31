<?php
class bibliotecaModel extends CI_Model{
		
	function gridProyectosRead(){
		$this->load->database();		
		
		$page = $this->input->post("page");
		$limit = $this->input->post("rows");
		$sidx = $this->input->post("sidx");
		$sord = $this->input->post("sord");
		$count = 0;		
		if(!$sidx) $sidx =1;
				
		
		$sql = "SELECT COUNT(*) AS count FROM PROYECTO";
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
		
		//-------------------------
		
		$sql = "SELECT idProyecto, nombreProyecto FROM PROYECTO";
		$query = $this->db->query($sql);		
	
		$i = 0;
		if($query){
			if($query->num_rows > 0){							
				foreach ($query->result() as $row){		
					$response->rows[$i]["id"] = $row->idProyecto;
					$response->rows[$i]["cell"] = array($row->idProyecto, $row->nombreProyecto);
					$i++;				
				}										
			}			
		}
		
		return $response;
	}
	
	function gridProcesosRead(){
		$this->load->database();		
		
		$page = $this->input->post("page");
		$limit = $this->input->post("rows");
		$sidx = $this->input->post("sidx");
		$sord = $this->input->post("sord");
		$count = 0;		
		if(!$sidx) $sidx =1;
				
		
		$sql = "SELECT COUNT(*) AS count FROM PROCESO";
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
		
		//-------------------------
		
		$sql = "SELECT idProyecto,idProceso, nombreProceso FROM PROCESO";
		$query = $this->db->query($sql);		
	
		$i = 0;
		if($query){
			if($query->num_rows > 0){							
				foreach ($query->result() as $row){		
					$response->rows[$i]["id"] = $row->idProceso;
					$response->rows[$i]["cell"] = array($row->idProyecto,$row->idProceso, $row->nombreProceso);
					$i++;				
				}										
			}			
		}
		
		return $response;
	}
	
	function gridActividadesRead(){
		$this->load->database();		
		
		$page = $this->input->post("page");
		$limit = $this->input->post("rows");
		$sidx = $this->input->post("sidx");
		$sord = $this->input->post("sord");
		$count = 0;		
		if(!$sidx) $sidx =1;
				
		
		$sql = "SELECT COUNT(*) AS count FROM ACTIVIDAD";
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
		
		//-------------------------
		
		$sql = "SELECT ap.idProyecto, a.idProceso,a.idActividad, a.nombreActividad FROM ACTIVIDAD a LEFT JOIN ACTIVIDAD_PROYECTO ap ON ap.idActividad = a.idActividad";
		$query = $this->db->query($sql);		
	
		$i = 0;
		if($query){
			if($query->num_rows > 0){							
				foreach ($query->result() as $row){		
					$response->rows[$i]["id"] = $row->idActividad;
					$response->rows[$i]["cell"] = array($row->idProyecto,$row->idProceso,$row->idActividad, $row->nombreActividad);
					
					$i++;				
				}										
			}			
		}
		
		return $response;
	}
	
function gridArchivosRead(){
		$this->load->database();		
		
		$page = $this->input->post("page");
		$limit = $this->input->post("rows");
		$sidx = $this->input->post("sidx");
		$sord = $this->input->post("sord");
		$count = 0;		
		if(!$sidx) $sidx =1;
				
		
		$sql = "SELECT COUNT(*) AS count FROM ARCHIVOS a LEFT JOIN TIPO_ARCHIVO ta ON a.idTipoArchivo = ta.idTipoArchivo";
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
		
		//-------------------------
		
		$sql = "SELECT  a.idProyecto, a.idProceso, a.idActividad, ta.nombreTipo,a.nombreArchivo, a.tituloArchivo, a.descripcion, a.fechaSubida". 
				" FROM ARCHIVOS a LEFT JOIN TIPO_ARCHIVO ta ON a.idTipoArchivo = ta.idTipoArchivo";
		$query = $this->db->query($sql);		
	
		$i = 0;
		if($query){
			if($query->num_rows > 0){							
				foreach ($query->result() as $row){		
					$response->rows[$i]["id"] = $i;
					$response->rows[$i]["cell"] = array($row->idProyecto,$row->idProceso,$row->idActividad, $row->nombreTipo,$row->nombreArchivo, $row->tituloArchivo,$row->descripcion, $row->fechaSubida );
					
					$i++;				
				}										
			}			
		}
		
		return $response;
	}
	
}

