<html>
	<head>
		<title>PHOBOS - Proyectos</title>	
		 <meta http-equiv="X-UA-Compatible" content="IE=8" >					
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/horus/jquery-ui-1.8.14.custom.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/ui.jqgrid.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/style.css" rel="stylesheet" />	
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-1.5.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-ui-1.8.14.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/grid.locale-es.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.jqGrid.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/ajaxupload.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.bt.min.js"></script>
		
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/dateUtils.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/validaciones.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.simplemodal.1.4.1.min.js"></script>
		
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/main.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/proyecto.js"></script>
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
		
		<div class="container" style = "height : auto">
			<div style="height: 20px"></div>
			<input id="filePath" type="hidden"  value="<?php echo $filePath;?>"/><br>
			
			<div class="divActions">				
				<div class="divCRUDRecords">
					<span class = "recordsLabel">Nombre proyecto</span>
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
					<li id="tagBliblioteca"><a href="#tabs-2">Documentos</a></li>
				</ul>
				
				<div id="tabs-1" class="divDataForm" style="height: 850px;">					

					<input id="idProyecto" type="hidden"  value="" class = "hiddenId"/>
					<input id="idUsuarioProy" type="hidden"  value="" class = "hiddenId"/>
					<input id="idUsuarioDuenho" type="hidden"  value="" class = "hiddenId"/>
					<input id="idTipoArchivo" type="hidden"  value="" class = "hiddenId"/>
					<input id="fasesString" type="hidden"  value="" class = "hiddenId"/>
					<input id="accionActual" type="hidden"  value="" class = "hiddenId"/>
				
					<input id="idRol" type="hidden"  value=<?php echo $idRol;?> />
					<input id="idUsuario" type="hidden"  value=<?php echo $idUsuario;?> />
					
					<span class = "requiredFieldLabel">Proyecto:</span>
					<input id="txtProyectoNombre" type="text"  value="" class = "inputField" title="Nombre del proyecto, solo letras y espacios" maxlength="100"/><br>
					
					<span class = "requiredFieldLabel">Due&ntilde;o:</span>
					<input id="txtProyectoNombreDuenho" type="text"  value="" class = "inputField" title="Usuario dueño del proyecto, solo letras y espacios" maxlength="400"/><br>
					
					<span class = "requiredFieldLabel">Coord. encargado:</span>
					<input id="txtCoordinadorEnc" type="text" value="" class = "inputField" title="Coordinador de proyectos encargado, solo letras y espacios" maxlength="400"/><br>
								
					<span class = "inputFieldLabel">Inicio planificado:</span>
					<input id="txtProyectoFechaPlanIni" type="text"  value="" title="Fecha inicio planificada del proyecto" class = "jqcalendario"/><br>
					
					<span class = "inputFieldLabel">Fin planificado:</span>
					<input id="txtProyectoFechaPlanFin" type="text"  value="" title="fecha fin planificada del proyecto" class = "jqcalendario"/><br>
					
					<span class = "inputFieldLabel">Inicio real:</span>
					<input id="txtProyectoFechaRealIni" type="text"  value="" title="Fecha real en la que el proyecto inici&oacute;" class = "jqcalendario"/><br>
					
					<span class = "inputFieldLabel">Fin real:</span>
					<input id="txtProyectoFechaRealFin" type="text"  value="" title="Fecha real en la que el proyecto finalizo" class = "jqcalendario"/><br>
					
					<span class = "inputFieldLabel">Activo</span>
					<input id="chkProyectoActivo" type="checkbox" value="1" class= "inputCHK"/><br>				
					
					<span class = "inputFieldLabel">Descripci&oacute;n</span>
					<textArea id="txtProyectoDescripcion" cols=20 rows=6 class = "inputFieldTA" title="Descripción del proyecto"></textArea><br>
					<div class = "gridView" style = "width : 480px">
						<table id="tablaFases" align="center"><tr><td/></tr></table>
						<div id="pager"></div>
					</div> 
					<span class = "inputFieldLabel">Elegir Fase: </span>
					<select id="cbFases"></select>
					<div class = "divCRUDButtons">
						<button id="btnSave" onClick="addFase()">Añadir Fase</button>
						<button id="btnEdit" onClick="editFase()">Editar Fase</button>
					</div>
				</div>
				
				<div id="tabs-2"  class="divDataForm" style="height: 600px">
					<div class="divUploadButton">
						<button id="btnUpload">Seleccionar archivo</button><p></p>
					</div>					
				
					<span class = "requiredFieldLabel">Título: </span>
					<input id="txtFileName" type="text"  value=""  title="Titulo del archivo" class = "inputField"/><br>
					
					<span class = "inputFieldLabel">Tipo: </span>
					<input id="txtFileType" type="text"  value=""  title="Tipo del archivo" class = "inputField"/><br>
					
					<span class = "inputFieldLabel">Descripción: </span>
					<textArea id="txtFileDesc" cols=20 rows=6 title="Descripci&oacute;n del archivo"  class = "inputFieldTA"></textArea>
					
					<div class="divAddButton">
						<button id="btnAddFile" onClick = "uploadFile()">Agregar</button>
						<button id="btnUpdateFile" onClick = "saveFileData('null')" style = "display : none">Actualizar</button>
						<button id="btnClearFileForm" onClick = "clearFileForm()">Limpiar</button>
					</div>					
					<div class = "gridView" style = "width : 480px">
						<table id="gridDocuments"><tr><td/></tr></table> 
						<div id="dpager"></div>
					</div>							
				</div>				
			</div>
			
			<div style="height: 20px"></div>
						
		</div>		
	</body>
</html>
