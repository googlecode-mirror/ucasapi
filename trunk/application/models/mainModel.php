<?php
class menuBarModel{

	function formarInsertStatement($head, $data_array, $idRol, $idUsuario, $fechaAsignacionSistema){
		$query = $head;
		//		$data_array = explode("|",$params);
		$query +=  " (".$idRol.",".$idUsuario.",".(("null"==$fechaAsignacionSistema)? null:$fechaAsignacionSistema).")";
		$query = substr($query, 0 ,strlen($query)-1). ")";
		return $query;
	}

}
?>