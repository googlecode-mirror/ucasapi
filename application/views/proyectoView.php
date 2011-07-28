<html>
	<head>
		<title>Test</title>	
		<?php 
			//require_once("application/models/menuBarModel.php");
			//echo "menuBarModel.php";
			//$menuBarModel = new menuBarModel();
			//$menuBarModel->showMenu();	 	
		?>			
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/humanity/jquery-ui-1.8.14.custom.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/style.css" rel="stylesheet" />	
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-1.5.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-ui-1.8.14.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/main.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/proyecto.js"></script>
	</head>	
	<body>
		<div class="menuBar"> 
	     	<ul>
	            <li><span class="menu_button_to"><a href="http://www.google.com"><span class="menu_button_text">Acción</span></a></span></li>
	            <li class="highlight"><span class="menu_button_to"><a href="http://www.google.com"><span class="menu_button_text">Departamento</span></a></span></li>
	            <li><span class="menu_button_to"><a href="http://www.google.com"><span class="menu_button_text">Cargo</span></a></span></li>
	            <li><span class="menu_button_to"><a href="http://www.google.com"><span class="menu_button_text">Estado</span></a></span></li>
	            <li><span class="menu_button_to"><a href="http://www.google.com"><span class="menu_button_text">Fase</span></a></span></li>
	            <li><span class="menu_button_to"><a href="http://www.google.com"><span class="menu_button_text">Rol</span></a></span></li>
        	</ul>  		
		</div>
		
		<div class="sessionBar">
			<span id="sessionUser"></span>
		</div>
		
		<div><span id="pageTittle"></span></div>
		
		<div class="container" style = "height : 1000px">
			<div style="height: 20px"></div>
			
			<div class="divActions">				
				<div class="divCRUDRecords">
					<span class = "recordsLabel">Nombre del proyecto</span>
					<input id="txtRecords" type="text"  value=""/><br>
					<!-- 
					<span class = "recordsLabel">Dueño del proyecto</span>
					<input id="txtRecordsUsuario" type="text"  value=""/><br>
					 -->
				</div>
				
							
				<div class="divCRUDButtons">
					<button id="btnSave" onClick="save()">Guardar</button>
					<button id="btnEdit" onClick="edit()">Editar</button>
					<button id="btnDelete" onClick="deleteData()">Eliminar</button>
					<button id="btnCancel" onClick="cancel()">Cancelar</button>

				</div>
			</div>
				
			<div id ="msgBox"></div>	
				
			<div class="divDataForm" style="height: 810px">
				<input id="idProyecto" type="hidden"  value="" class = "hiddenId"/><br>
				<input id="idUsuario" type="hidden"  value="" class = "hiddenId"/><br>
				<input id="idUsuarioDuenho" type="hidden"  value="" class = "hiddenId"/><br>
				
				<span class = "inputFieldLabel">Nombre:</span>
				<input id="txtProyectoNombre" type="text"  value="" class = "jqcalendario"/><br>
				
				<span class = "inputFieldLabel">Dueño:</span>
				<input id="txtProyectoNombreDuenho" type="text"  value="" class = "jqcalendario"/><br>
							
				<span class = "inputFieldLabel">Inicio planificado:</span>
				<input id="txtProyectoFechaPlanIni" type="text"  value="" class = "jqcalendario"/><br>
				
				<span class = "inputFieldLabel">Fin planificado:</span>
				<input id="txtProyectoFechaPlanFin" type="text"  value="" class = "jqcalendario"/><br>
				
				<span class = "inputFieldLabel">Inicio real:</span>
				<input id="txtProyectoFechaRealIni" type="text"  value="" class = "jqcalendario"/><br>
				
				<span class = "inputFieldLabel">Fin real:</span>
				<input id="txtProyectoFechaRealFin" type="text"  value="" class = "jqcalendario"/><br>
				
				<span class = "inputFieldLabel">Activo</span>
				<input id="chkProyectoActivo" type="checkbox" value="1"/><br>				
				
				<span class = "inputFieldLabel">Descripción</span>
				<textArea id="txtProyectoDescripcion" cols=20 rows=6 class = "inputField" title="Descripción del proyecto"></textArea><br>				

				
			</div>
			
		</div>
	
		
	</body>
</html>