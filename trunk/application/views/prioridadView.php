<html>
	<head>
		<title>PHOBOS - Prioridades</title>	
		 <meta http-equiv="X-UA-Compatible" content="IE=8" >			
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/horus/jquery-ui-1.8.14.custom.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/style.css" rel="stylesheet" />	
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-1.5.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-ui-1.8.14.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.bt.min.js"></script>
		
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/validaciones.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.simplemodal.1.4.1.min.js"></script>
		
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/main.js"></script>		
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/prioridad.js"></script>
	</head>
	
	<body>
	
		<div class="menuBar" style="height:52px">
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
			<img id="logoutButton" title="Cerrar sesi&oacute;n" src="<?php echo base_url(); ?>application/views/css/img/logout_button.png" />
			<span id="sessionUser"><?php echo  utf8_decode($userName."/".$roleName); ?></span> 
		</div>
		
		<div><span id="pageTittle"></span></div>
		
		<div class="container" style="height: auto">
			<div style="height: 20px"></div>
			
			<div class="divActions">				
				<div class="divCRUDRecords">
					<span class = "recordsLabel">Buscar prioridad: </span>
					<input id="txtRecords" type="text"  value="" class = "inputFieldAC"  title="Seleccione un Prioridad para edición o eliminación"/><br>
				</div>
							
				<div class="divCRUDButtons">
					<button id="btnSave" onClick="save()">Guardar</button>
					<button id="btnEdit" onClick="edit()">Editar</button>
					<button id="btnDelete" onClick="deleteData()">Eliminar</button>
					<button id="btnCancel" onClick="cancel()">Cancelar</button>
				</div>
			</div>
				
			<div id ="msgBox"></div>	
				
			<div class="divDataForm" style="height:128px">
				<input id="idPrioridad" type="hidden"  value="" class = "hiddenId"/><br>
				<input id="accionActual" type="hidden"  value="" class = "hiddenId"/><br>
			
				<span class = "inputFieldLabel">Nombre: </span>
				<input id="txtPrioridadName" type="text"  value="" class = "inputField" title="Ingrese el nombre del prioridad" maxlength="40"/><br>
				
			</div>
			
			<div style="height: 20px"></div>
			
		</div>
	
		
	</body>
</html>