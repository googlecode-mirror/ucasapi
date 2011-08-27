<html>
	<head>
		<title>PHOBOS - Estados</title>		
		 <meta http-equiv="X-UA-Compatible" content="IE=8" >		
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/horus/jquery-ui-1.8.14.custom.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/style.css" rel="stylesheet" />	
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-1.5.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-ui-1.8.14.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.bt.min.js"></script>
		
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/validaciones.js"></script>
		
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/main.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/estado.js"></script>
		
	</head>
	
	<body>
	
		<div class="menuBar" style="height:52px">
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
		
		<div class="container">
			<div style="height: 20px"></div>
			
			<div class="divActions">				
				<div class="divCRUDRecords">
					<span class = "recordsLabel">Buscar estado: </span>
					<input id="txtRecords" type="text"  value="" class="inputFieldAC" title="Seleccione un Estado para edición o eliminación"/><br>
				</div>
							
				<div class="divCRUDButtons">
					<button id="btnSave" onClick="save()">Guardar</button>
					<button id="btnEdit" onClick="edit()">Editar</button>
					<button id="btnDelete" onClick="deleteData()">Eliminar</button>
					<button id="btnCancel" onClick="cancel()">Cancelar</button>
				</div>
			</div>
				
			<div id ="msgBox"></div>	
				
			<div class="divDataForm">
				<input id="idEstado" type="hidden"  value="" class = "hiddenId"/><br>
				<input id="idTipoEstado" type="hidden" value="" class="hiddenId"/>
				<input id="accionActual" type="hidden" value="" class="hiddenId"/>
			
				<span class = "requiredFieldLabel">Nombre: </span>
				<input id="txtStatusName" type="text"  value="" class = "inputField" maxlength="40" title="Nombre del estado"/><br>
				
				<span class = "requiredFieldLabel">Tipo de estado: </span>
				<input id="txtStatusTypeName" type="text" class = "inputField" maxlength="40" title="Nombre del tipo de estado asociado"/>
			</div>
			
		</div>

	</body>
</html>