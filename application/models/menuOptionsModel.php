<?php
class menuBarModel{	
	
	function showMenu(){		
		$xmlDir = "application/views/xml/menuOptions.xml";		
		$xml = simplexml_load_file($xmlDir);
		
		$baseUrl = base_url();
		$html ="";	

		$query = '/roles/rol[@id="1"]/botonesMenu/botonMenu';
		$botonesMenu = $xml->xpath($query);
		
		foreach ($botonesMenu as $botonMenu){
	    	$controller =  utf8_decode($botonMenu->controller."");
	    	$buttonName =  utf8_decode($botonMenu->nombreBoton."");

			$htmlPart = '<li id="'.$controller.'Button"><span class="menu_button_to"><a href="'.$baseUrl.$controller.'"><span class="menu_button_text">'.$buttonName.'</span></a></span></li>';
			$htmlOutput = $htmlOutput.$htmlPart;
		}
		
		echo $htmlOutput;		
	}
}
?>