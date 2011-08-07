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
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/ui.jqgrid.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/style.css" rel="stylesheet" />	
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-1.5.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-ui-1.8.14.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/grid.locale-es.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.jqGrid.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.bt.min.js"></script>
		
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/main.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/historicoUsuario.js"></script>
		
		
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
		
		<div class="container" style = "height : 1050px">
			<div style="height: 20px"></div>
			<input id="filePath" type="hidden"  value="<?php echo $filePath;?>" class = "hiddenURL"/><br>
			
			<div class="divActions">				
				<div class="divCRUDRecords">
					<span class = "recordsLabel">Usuario</span>
					<input id="txtRecords" type="text"  value=""/><br>
				</div>
							
				<div class="divCRUDButtons">
					<button id="btnSave" onClick="save()">Guardar</button>
					<button id="btnEdit" onClick="edit()">Editar</button>
					<button id="btnDelete" onClick="deleteData()">Eliminar</button>
					<button id="btnCancel" onClick="cancel()">Cancelar</button>

				</div>
			</div>
				
			<div id ="msgBox"></div>	
				
			<div class="divDataForm" style="height: 850px">
				<input id="idUsuario" type="hidden"  value="" class = "hiddenId"/><br>
				<input id="idCargo" type="hidden"  value="" class = "hiddenId"/><br>
				<input id="idDepto" type="hidden"  value="" class = "hiddenId"/><br>				
				
				<span class = "inputFieldLabel">Inicio contrato:</span>
				<input id="txtUsuarioCodigo" type="text"  value="" class = "inputField" title = "Fecha inicio de este contrato"/><br>
							
				<span class = "requiredFieldLabel">Fin contrato:</span>
				<input id="txtUsuarioPrimerNombre" type="text"  value="" class = "jqcalendar" title = "Fecha finalización de este contrato" readonly/><br>
				
				<span class = "inputFieldLabel">Tiempo contrato:</span>
				<input id="txtUsuarioOtrosNombres" type="text"  value="" class = "jqcalendar" title = "Tiempo en meses que durara el contrato"/><br>				
				
				<span class = "inputFieldLabel">Activo:</span>
				<input id="chkUsuarioActivo" type="checkbox" value="1" title = "Checkear si el usuario esta activo en el sistema" class="inputCHK"/><br>
				
			</div>
			<!-- <div class="divDataForm" style="height: 250px" align="center">  -->
				<input id="idRol" type="hidden"  value="" class = "hiddenId"/><br>				
				
				<table>
				<tr>				
					<td>
					<div>
						<table id="usuarioHist"></table>
						<div style = "height : 40px" id="gridpagerUH"></div>
					</div>
					</td>
					<td>
						<br>
					</td>	
					<td>
					</td>				
				</table>				
				
				
				
				
				
				
			<!-- </div> 
			
			<button id="btnSaveContrato" onClick="saveContrato()" >Guardar contrato</button>					
				<button id="btnCancelContrato" onClick="cancelContrato()" >Cancelar</button> -->	
		</div>
		
	</body>
</html>