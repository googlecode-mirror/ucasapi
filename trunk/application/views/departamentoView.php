<html>
	<head>	
		<title>Test</title>
		<?php 
			require_once("application/models/menuOptionsModel.php");
			$menuBarModel = new menuBarModel();	
		?>						
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/horus/jquery-ui-1.8.14.custom.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/ui.jqgrid.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/style.css" rel="stylesheet" />	
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-1.5.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-ui-1.8.14.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/grid.locale-es.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.jqGrid.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/main.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/departamento.js"></script>
	</head>	
	<body>
		<div class="menuBar">
			<ul>
				<?php $menuBarModel->showMenu();?>
			</ul>			
		</div>		
		<div class="sessionBar">			
			<img id="logoutButton" title="Cerrar sesión" src="<?php echo base_url(); ?>application/views/css/img/logout_button.png" />
			<span id="sessionUser">Gerson Beltrán</span> 
		</div>
		
		<div><span id="pageTittle"></span></div>
		
		<div class="container">
			<div style="height: 20px"></div>
			
			<div class="divActions">				
				<div class="divCRUDRecords">
					<span class = "recordsLabel">Departamentos</span>
					<input id="txtRecords" type="text"  value="" title = "Búsqueda de registros"/><br>
				</div>
										
				<div class="divCRUDButtons">
					<button id="btnSave" onClick="save()">Guardar</button>
					<button id="btnEdit" onClick="edit()">Editar</button>
					<button id="btnDelete" onClick="deleteData()">Eliminar</button>
					<button id="btnCancel" onClick="cancel()">Cancelar</button>

				</div>				
			</div>
				
			<div id ="msgBox"></div>	
				
				
			<div id="tabs">
				<ul>
					<li><a href="#tabs-1">Información General</a></li>
					<li><a href="#tabs-2">Documentos</a></li>
				</ul>
				
				<div id="tabs-1" class="divDataForm">
					<input id="idDepto" type="hidden"  value="" class = "hiddenId"/><br>
				
					<span class = "inputFieldLabel">Nombre</span>
					<input id="txtDepartmentName" type="text"  value="" class = "inputField" title="Nombre del departamento"/><br>
					
					<span class = "inputFieldLabel">Descripción</span>
					<textArea id="txtDepartmentDesc" cols=20 rows=6 class = "inputField" title="Descripción del departamento"></textArea>
				</div>
				
				<div id="tabs-2">
					<p>Tab número 2</p>
				</div>
				
			</div>
			<div >
				
			</div>
			
		</div>
		<div>
				<?php echo form_open_multipart('upload/do_upload');?>
			<input type="file" name="userfile" size="20" />
			
			<br /><br />
			<button id="uploadFile" onClick="uploadFile()">Subir</button>
			<input type="submit" value="upload" />
		</div>
		<div>
			<table id="list"><tr><td/></tr></table> 
			<div id="pager"></div>
		</div>
		
	</body>
</html>