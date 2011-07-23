<?php
class menuBarModel{	
	
	function showMenu(){		
		$xmlDir = "application/views/xml/menuBarElements.xml";		
		$xml = simplexml_load_file($xmlDir);

		$query = '/roles/rol[@id="1"]/botonesMenu/botonMenu';
		$botonesMenu = $xml->xpath($query);
		
		foreach ($botonesMenu as $botonMenu){
	    	echo utf8_decode($botonMenu->nombreBoton."");
		}
	}
}
?>