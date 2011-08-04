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
		
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/grid.locale-es.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.jqGrid.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/ajaxupload.js"></script>
 		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.bt.min.js"></script>
		
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
			<input id="filePath" type="hidden"  value="<?php echo $filePath;?>" class = "hiddenURL"/><br>
			
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
			
			<div id="tabs" style = "height: auto;">
				<ul>
					<li><a href="#tabs-1">Información General</a></li>
					<li><a href="#tabs-2">Biblioteca</a></li>
				</ul>
				
			<!-- <div class="divDataForm" style="height: 810px"> -->
			<div id="tabs-1" class="divDataForm" style="height: 810px;">
			
				<input id="idProyecto" type="hidden"  value="" class = "hiddenId"/><br>
				<input id="idUsuarioDuenho" type="hidden"  value="" class = "hiddenId"/><br>
				
				<span class = "inputFieldLabel">Nombre:</span>
				<input id="txtProyectoNombre" type="text"  value="" class = "inputField" title = "Nombre del proyecto"/><br>
				
				<span class = "inputFieldLabel">Dueño:</span>
				<input id="txtProyectoNombreDuenho" type="text"  value="" class = "inputField" title = "Dueño del proyecto"/><br>
							
				<span class = "inputFieldLabel">Inicio planificado:</span>
				<input id="txtProyectoFechaPlanIni" type="text"  value="" class = "jqcalendario" title = "Fecha planificada para iniciar el proyecto"/><br>
				
				<span class = "inputFieldLabel">Fin planificado:</span>
				<input id="txtProyectoFechaPlanFin" type="text"  value="" class = "jqcalendario" title = "Fecha planificada para finalizar el proyecto"/><br>
				
				<span class = "inputFieldLabel">Inicio real:</span>
				<input id="txtProyectoFechaRealIni" type="text"  value="" class = "jqcalendario" title = "Fecha real en la que inició el proyecto"/><br>
				
				<span class = "inputFieldLabel">Fin real:</span>
				<input id="txtProyectoFechaRealFin" type="text"  value="" class = "jqcalendario" title = "Fecha real en la que finalizo el proyecto"/><br>
				
				<span class = "inputFieldLabel">Activo</span>
				<input id="chkProyectoActivo" type="checkbox" value="1" title = "Checkear si el proyecto esta activo"/><br>				
				
				<span class = "inputFieldLabel">Descripción</span>
				<textArea id="txtProyectoDescripcion" cols=20 rows=6 class = "inputField" title="Descripción del proyecto"></textArea><br>							
			</div>
			
			<div id="tabs-2"  class="divDataForm" style="height: 600px">
				<div class="divUploadButton">
					<button id="btnUpload">Seleccionar archivo</button><p></p>
				</div>	
			  	<span class = "requiredFieldLabel">Nombre: </span>
					<input id="txtFileName" type="text"  value="" class = "inputField"/><br>
					
					<span class = "inputFieldLabel">Descripción: </span>
					<textArea id="txtFileDesc" cols=20 rows=6 class = "inputFieldTA"></textArea>	
					<div class="divAddButton">
						<button id="btnAddFile" onClick = "uploadFile()">Agregar</button>
						<button id="btnUpdateFile" onClick = "saveFileData('null')" style = "display : none">Actualizar</button>
						<button id="btnClearFileForm" onClick = "clearFileForm()">Limpiar</button>
					</div>	
                    <div class = "gridView" style = "width : 480px">
						<table id="gridDocuments"><tr><td/></tr></table> 
						<div id="pager"></div>
					</div>	
						
			</div>	
			
			
			</div>
		</div>
	
		
	</body>
</html>