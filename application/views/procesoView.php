<html>
	<head>
		<title>Test</title>		
			<link type="text/css" href="<?php echo base_url(); ?>application/views/css/humanity/jquery-ui-1.8.14.custom.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/ui.jqgrid.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/style.css" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-1.5.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.bt.min.js"></script>	
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-ui-1.8.14.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/grid.locale-es.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.jqGrid.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/main.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/proceso.js"></script>
		
	</head>
	
	<body>
		<form name="dummy" method="post">
			<input type="hidden" name="idProceso" value="" />
		</form>
		<div class="menuBar">
			<ul>
				<li><span class="menu_button_to"><a href="http://www.google.com"><span class="menu_button_text">Dinamic</span></a></span></li>
				<li class="highlight"><span class="menu_button_to"><a href="http://www.google.com"><span class="menu_button_text">Dinamic</span></a></span></li>
				<li><span class="menu_button_to"><a href="http://www.google.com"><span class="menu_button_text">Dinamic</span></a></span></li>
				<li><span class="menu_button_to"><a href="http://www.google.com"><span class="menu_button_text">Dinamic</span></a></span></li>
			</ul>			
		</div>
		
		<div class="sessionBar">
			<span id="sessionUser"></span>
		</div>
		
		<div><span id="pageTittle"></span></div>
		
		<div class="container" style = "height: 850px">
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
				
			<div class="divDataForm" style = "height: 650px; width: 700px">
				<input id="idProceso" type="hidden"  value="" class = "hiddenId"/>
				<input id="idProyecto" type="hidden"  value="" class = "hiddenId"/>
				<input id="idFase" type="hidden"  value="" class = "hiddenId"/>
				<input id="idEstado" type="hidden"  value="" class = "hiddenId"/>
				<input id="fasesString" type="hidden"  value="" class = "hiddenId"/>
						
				<span class = "inputFieldLabel">Nombre: </span>
				<input id="txtProcesoName" class = "inputFieldAC" type="text"  value="" class = "inputField"/><br>
				
				<span class = "inputFieldLabel">Proyecto (opcional): </span>
				<input id="txtProyectoName" class = "inputFieldAC" type="text"  value="" class = "inputField"/>
				
				<span class = "inputFieldLabel">Estado: </span>
				<select id="cbEstado"></select>
				<br><br><br><br><br><br><br>
				<span class = "inputFieldLabel">Descripción: </span>
				<textArea id="txtProcesoDesc" class = "inputFieldTA" cols=20 rows=6 class = "inputField"></textArea>
				<br><br><br><br><br><br><br><br><br>
				<span class = "inputFieldLabel">Fases en que se encuentra el proceso: </span>
				<br><br><br>
				<div align="center">
					<table id="tablaFases"></table>
					<div id="pager"></div>
				</div>
				<span class = "inputFieldLabel">Añadir Fase: </span>
				<select id="cbFases" name="fases"></select>
				<div class="divCRUDButtons">
					<button id="btnFaseAdd" onClick="addFase()">Agregar Fase</button>
					<button id="btnFaseEdit" onClick="editFase()">Editar Fase</button>
				</div>	
			</div>
			
		</div>
		
	</body>
</html>