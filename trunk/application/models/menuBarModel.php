<?php
class menuBarModel{
	
	
	function showMenu(){
		
		$xmlDir = base_url()."application/views/xml/menuBarElements.xml";
		
		$xml = simplexml_load_file($xmlDir);
		
		echo $xmlDir;	
	}	

}



?>