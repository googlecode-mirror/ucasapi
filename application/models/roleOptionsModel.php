<?php
class roleOptionsModel{	
	
	//Retorna el código html del menú correspondiente al rol
	function showMenu($idRol){		
		$xmlDir = "application/views/xml/menuOptions.xml";		
		$xml = simplexml_load_file($xmlDir);
		
		$baseUrl = base_url();
		$html ="";	

		$query = "/roles/rol[@id='$idRol']/paginas/pagina";
		$paginas = $xml->xpath($query);
		
		foreach ($paginas as $pagina){
	    	$controller =  utf8_decode($pagina->controller."");
	    	$pageName =  utf8_decode($pagina->nombrePagina."");

			$htmlPart = '<li id="'.$controller.'Button"><span class="menu_button_to"><a href="'.$baseUrl.$controller.'"><span class="menu_button_text">'.$pageName.'</span></a></span></li>';
			$htmlOutput = $htmlOutput.$htmlPart;
		}
		
		return $htmlOutput;		
	}
	
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	//Retorna un valor mayor que cero si el controller está asociado al rol
	function validatePage($idRol, $controllerName){		
		$xmlDir = "application/views/xml/menuOptions.xml";		
		$xml = simplexml_load_file($xmlDir);
		
		$result = 0;

		$query = "/roles/rol[@id='$idRol']/paginas/pagina[controller='$controllerName']";
		$paginas = $xml->xpath($query);
				
		foreach ($paginas as $pagina){
	    	$result++;			
		}
		
		return $result;				
	}
}
?>