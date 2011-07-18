<html>
	<head>
		<title>Test</title>		
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/humanity/jquery-ui-1.8.14.custom.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/style.css" rel="stylesheet" />	
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/jquery-1.5.1.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/jquery-ui-1.8.14.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/departamento.js"></script>
		
	</head>
	
	<body>
		<div class="menu_bar">
			<ul>
				<li><span class="menu_button_to"><a href="http://www.googlecom"><span class="menu_button_text">Dinamic</span></a></span></li>
				<li class="highlight"><span class="menu_button_to"><a href="http://www.google.com"><span class="menu_button_text">Dinamic</span></a></span></li>
				<li><span class="menu_button_to"><a href="http://www.google.com"><span class="menu_button_text">Dinamic</span></a></span></li>
				<li><span class="menu_button_to"><a href="http://www.google.com"><span class="menu_button_text">Dinamic</span></a></span></li>
			</ul>			
		</div>
		<div class="user_session">	
		</div>
		<div class="container">
			<div style="height: 20px"></div>
			<div class="divActions">				
				<div id="divCRUDRecords">
					<span class = "recordsLabel">Departamentos</span>
					<input id="txtRecords" type="text"  value=""/><br>
				</div>			
				<div id="divCRUDButtons">
					<input id = "btnSave" type="button" value="Guardar" onClick="save()"/>
					<input id = "btnEdit" type="button" value="Editar" onClick="edit()"/>
					<input id = "btnDelete" type="button" value="Eliminar" onClick="deleteData()"/>
					<input id = "btnCancel" type="button" value="Cancelar" onClick="cancel()"/>
				</div>
			</div>
				
			<div class="divDataForm">
				<input id="idDepto" type="hidden"  value="" class = "hiddenId"/><br>
			
				<span class = "inputFieldLabel">Nombre</span>
				<input id="txtDepartmentName" type="text"  value="" class = "inputField"/><br>
				
				<span class = "inputFieldLabel">Descripción</span>
				<textArea id="txtDepartmentDesc" cols=20 rows=6 class = "inputField"></textArea>
			</div>
			
		</div>
	
		
	</body>
</html>