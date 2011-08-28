<html>
	<head>
		<title>PHOBOS - Procesos</title>	
		 <meta http-equiv="X-UA-Compatible" content="IE=8" >			
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/horus/jquery-ui-1.8.14.custom.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/ui.jqgrid.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/style.css" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-1.5.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.bt.min.js"></script>	
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-ui-1.8.14.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/grid.locale-es.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.jqGrid.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/ajaxupload.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/validaciones.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.simplemodal.1.4.1.min.js"></script>
		
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/main.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/proceso.js"></script>
		
	</head>
	
	<body>
		<div class="menuBar">
			<ul>
				<?php echo $menu;?>
			</ul>			
		</div>
		
		<div id="loading" style="display:none; text-align:center">
			<span style = "color:white">Obteniendo datos ...</span>
			<div style="clear:both"></div>
			<img  src="<?php echo base_url(); ?>application/views/css/img/loading.gif"/>
		</div>
		
		<div class="sessionBar">
			<img id="systemIcon" src="<?php echo base_url(); ?>application/views/css/img/gears.png" />	
			<span id="systemName"><b>PHOBOS PLANING</b></span> 	
			<img id="logoutButton" title="Cerrar sesión" src="<?php echo base_url(); ?>application/views/css/img/logout_button.png" />
			<span id="sessionUser"><?php echo  utf8_decode($userName."/".$roleName); ?></span> 
		</div>
		
		<div><span id="pageTittle"></span></div>
		
		<div class="container" style = "height: auto">
			<input id="accionActual" type="hidden"  value="" class = "hiddenId"/>
			<input id="filePath" type="hidden"  value="<?php echo $filePath;?>"/><br>
			<div style="height: 20px"></div>
			
			<div class="divActions">				
				<div class="divCRUDRecords">
					<span class = "recordsLabel">Buscar proyecto: </span>
					<input id="txtRecordsProy" class = "inputFieldAC" type="text"  value="" title = "Proyectos encontrados"/><br>
					
					<span class = "recordsLabel">Procesos: </span>
					<input id="txtRecordsProc" class = "inputFieldAC" type="text"  value="" title = "Procesos encontrados"/><br><br>
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
					<li id="tagBliblioteca"><a href="#tabs-2">Documentos</a></li>
				</ul>
				
				<div id="tabs-1" class="divDataForm" style = "height: 400px">				
					<input id="idProceso" type="hidden"  value="" class = "hiddenId"/>
					<input id="idProyecto" type="hidden"  value="" class = "hiddenId"/>
					<input id="idTipoArchivo" type="hidden"  value="" class = "hiddenId"/>
					<input id="idFase" type="hidden"  value="" class = "hiddenId"/>
					<input id="idEstado" type="hidden"  value="" class = "hiddenId"/>
					<input id="fasesString" type="hidden"  value="" class = "hiddenId"/>
					<input id="idRol" type="hidden"  value=<?php echo $idRol;?> />
					<input id="idUsuario" type="hidden"  value=<?php echo $idUsuario;?> />
							
					<span class = "requiredFieldLabel">Nombre: </span>
					<input id="txtProcesoName" class = "inputFieldAC" type="text"  value="" class = "inputField" maxlength="40"/><br>
					
					<span class = "inputFieldLabel">Proyecto: </span>
					<input id="txtProyectoName" class = "inputFieldAC" type="text"  value="" class = "inputField" maxlength="100"/>
					
					<span class = "requiredFieldLabel">Estado: </span>
					<select id="cbEstado" style="width: 256px; float: right; margin-right: 96px"></select>
					
					<span class = "inputFieldLabel">Fase: </span>
					<select id="cbFases" style="width: 256px; float: right; margin-right: 96px"></select>
					
					<span class = "requiredFieldLabel">Descripción: </span>
					<textArea id="txtProcesoDesc" class = "inputFieldTA" cols=20 rows=6 class = "inputField"></textArea>				
				</div>
				
				<div id="tabs-2"  class="divDataForm" style="height: auto">
					<div class="divUploadButton">
						<button id="btnUpload">Seleccionar archivo</button><p></p>
					</div>					
				
					<span class = "requiredFieldLabel">Título: </span>
					<input id="txtFileName" type="text"  value="" class = "inputField"/><br>
					
					<span class = "inputFieldLabel">Tipo: </span>
					<input id="txtFileType" type="text"  value="" class = "inputField"/><br>
					
					<span class = "inputFieldLabel">Descripción: </span>
					<textArea id="txtFileDesc" cols=20 rows=6 class = "inputFieldTA"></textArea>
					
					<div class="divAddButton">
						<button id="btnAddFile" onClick = "uploadFile()">Agregar</button>
						<button id="btnUpdateFile" onClick = "saveFileData('null')" style = "display : none">Actualizar</button>
						<button id="btnClearFileForm" onClick = "clearFileForm()">Limpiar</button>
					</div>					
					<div class = "gridView" style = "width : 480px; margin-bottom:40px">
						<table id="gridDocuments"><tr><td/></tr></table> 
						<div id="dpager"></div>
					</div>							
				</div>				
				
			</div>
						
			<div style="height: 20px"></div>
			
		</div>
		
	</body>
</html>