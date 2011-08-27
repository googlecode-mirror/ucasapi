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
		
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/validaciones.js"></script>
		
		
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/main.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/proceso.js"></script>
		
	</head>
	
	<body>
		<div class="menuBar">
			<ul>
				<?php echo $menu;?>
			</ul>			
		</div>
		
		<div class="sessionBar">
			<img id="systemIcon" src="<?php echo base_url(); ?>application/views/css/img/gears.png" />	
			<span id="systemName"><b>PHOBOS PLANING</b></span> 	
			<img id="logoutButton" title="Cerrar sesión" src="<?php echo base_url(); ?>application/views/css/img/logout_button.png" />
			<span id="sessionUser"><?php echo  utf8_decode($userName."/".$roleName); ?></span> 
		</div>
		
		<div><span id="pageTittle"></span></div>
		
		<div class="container" style = "height: 650px">
			<input id="accionActual" type="hidden"  value="" class = "hiddenId"/>
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
				
			<div class="divDataForm" style = "height: 400px; width: 700px">
				<input id="idProceso" type="hidden"  value="" class = "hiddenId"/>
				<input id="idProyecto" type="hidden"  value="" class = "hiddenId"/>
				<input id="idFase" type="hidden"  value="" class = "hiddenId"/>
				<input id="idEstado" type="hidden"  value="" class = "hiddenId"/>
				<input id="fasesString" type="hidden"  value="" class = "hiddenId"/>
				<input id="idRol" type="hidden"  value=<?php echo $idRol;?> class = "hiddenId"/>
						
				<span class = "requiredFieldLabel">Nombre: </span>
				<input id="txtProcesoName" class = "inputFieldAC" type="text"  value="" class = "inputField" maxlength="40"/><br>
				
				<span class = "inputFieldLabel">Proyecto: </span>
				<input id="txtProyectoName" class = "inputFieldAC" type="text"  value="" class = "inputField" maxlength="100"/>
				
				<span class = "requiredFieldLabel">Estado: </span>
				<select id="cbEstado"></select>
				
				<span class = "inputFieldLabel">Fase que pertenece el proceso: </span>
				<select id="cbFases"></select>
				
				<span class = "requiredFieldLabel">Descripción: </span>
				<textArea id="txtProcesoDesc" class = "inputFieldTA" cols=20 rows=6 class = "inputField"></textArea>			
				
			</div>
			
		</div>
		
	</body>
</html>