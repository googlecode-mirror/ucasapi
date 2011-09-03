<html>
	<head>	
		<title>PHOBOS - Departamentos</title>	
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
		
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/validaciones.js"></script>		
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.simplemodal.1.4.1.min.js"></script>
		
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/main.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/departamento.js"></script>		
		
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
			<span id="systemName"><b>PHOBOS PLANNING</b></span> 	
			<img id="logoutButton" title="Cerrar sesión" src="<?php echo base_url(); ?>application/views/css/img/logout_button.png" />
			<span id="sessionUser"><?php echo  utf8_decode($userName."/".$roleName); ?></span> 
		</div>
		
		<div id="titulo"><span id="pageTittle"></span></div>
		
		<div class="container">
			<div class="divActions">				
				<div class="divCRUDRecords">
					<span class = "recordsLabel">Departamentos</span>
					<input id="txtRecords" type="text"  value="" title = "Seleccione un Departamento para edición o eliminación" class="inputFieldAC" maxlength="256"/><br>
				</div>
										
				<div class="divCRUDButtons">
					<button id="btnSave" onClick="save()">Guardar</button>
					<button id="btnEdit" onClick="edit()">Editar</button>
					<button id="btnDelete" onClick="deleteData()">Eliminar</button>
					<button id="btnCancel" onClick="cancel()">Cancelar</button>

				</div>				
			</div>
				
			<div id ="msgBox"></div>	
				
				
			<div>
				<div class="divDataForm">
					<input id="idDepto" type="hidden"  value="" class = "hiddenId"/><br>
					<input id="accionActual" type="hidden"  value="" class = "hiddenId"/><br>
				
					<span class = "requiredFieldLabel" >Nombre</span>
					<input id="txtDepartmentName" type="text"  value="" class = "inputField" title="Nombre del departamento" maxlength="256"/><br>
					
					<span class = "requiredFieldLabel">Descripci&oacute;n</span>
					<textArea id="txtDepartmentDesc" cols=20 rows=6 class = "inputFieldTA" title="Descripción del departamento" ></textArea>
				</div>
				
			</div>
			<div >
				
			</div>			
		</div>		
	</body>
</html>