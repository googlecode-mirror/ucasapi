<html>
	<head>
		<title>Test</title>	
		<?php 
			//require_once("application/models/menuBarModel.php");
			//echo "menuBarModel.php";
			//$menuBarModel = new menuBarModel();
			//$menuBarModel->showMenu();	 	
		?>			
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/horus/jquery-ui-1.8.14.custom.css" rel="stylesheet" />
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
		
		<div class="container" style = "height : 1190px">
			<div style="height: 20px"></div>			
			
			<div class="divActions">				
				<div class="divCRUDRecords">
					<span class = "recordsLabel">Usuario</span>
					<input id="txtRecords" type="text"  value="" class="inputFieldAC"/><br>
				</div>
							
				<div class="divCRUDButtons">
					<!-- <button id="btnSave" onClick="save()">Guardar</button>  -->
					<button id="btnEdit" onClick="edit()">Contratos</button>
					<button id="btnCancel" onClick="cancel()">Cancelar</button>
				</div>
			</div>
				
			<div id ="msgBox"></div>
				
			<div class="divDataForm" style="height: 475px">
				<input id="idUsuario" type="hidden"  value="" class = "hiddenId"/>
				<input id="correlUsuarioHistorico" type="hidden"  value="" class = "hiddenId"/>
				<input id="accionActual" type="hidden"  value="" class = "hiddenId"/>
				<input id="accionActualRol" type="hidden"  value="" class = "hiddenId"/>
				<input id="idRol" type="hidden"  value="" class = "hiddenId"/>
				<input id="idRolHistorico" type="hidden"  value="" class = "hiddenId"/>
								
				<span class = "requiredFieldLabel">Inicio contrato:</span>
				<input id="txtFechaInicioContrato" type="text"  value="" class = "jqcalendario" title = "Fecha inicio de este contrato" readonly/><br>
											
				<span class = "requiredFieldLabel">Fin contrato:</span>
				<input id="txtFechaFinContrato" type="text"  value="" class = "jqcalendario" title = "Fecha finalización de este contrato" readonly/><br>
								
				<span class = "requiredFieldLabel">Tiempo contrato:</span>
				<input id="txtTiempoContrato" type="text"  value="" class = "inputFieldNUM" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" title = "Tiempo en meses que durara el contrato"/>				
				
				<div class="divCRUDButtons">
					<br /><br />
					<button id="btnSaveContrato" onClick="saveContrato()" >Guardar</button>					
					<button id="btnEditContrato" onClick="editContrato()" >Editar</button>
					<button id="btnDeleteContrato" onClick="deleteContrato()">Eliminar</button>
					<button id="btnEditarContrato" onClick="editarContrato()">Editar roles</button>
					<button id="btnCancelContrato" onClick="cancelContrato()" >Cancelar</button>
				</div>
				<div align="center" class = "gridView" style = "width : 480px">
					<table id="usuarioHist"></table>
					<div style = "height : 40px" id="gridpagerUH"></div>
				</div>
			</div>
			
			<div id ="msgBox01" style="margin-top: 20px"></div>
			
			<div class="divDataForm" style="height: 515px; margin-top: 20px">
				<span class = "requiredFieldLabel">Rol:</span>
				<input id="txtHistoricoRol" type="text"  value="" class = "inputFieldAC" title = "Rol Desempeñado"/><br>
			
				<span class = "requiredFieldLabel">Fecha asignación:</span>
				<input id="txtFechaInicioRol" type="text"  value="" class = "jqcalendario" title = "Fecha en que se vinculo este rol" readonly/><br>
											
				<span class = "requiredFieldLabel">Fecha fin:</span>
				<input id="txtFechaFinRol" type="text"  value="" class = "jqcalendario" title = "Fecha en que se desvinculo" readonly/><br>
								
				<span class = "requiredFieldLabel">Salario $:</span>
				<input id="txtSalarioRol" type="text"  value="" class = "inputFieldNUM" title = "Tiempo en meses que durará el contrato"/><br>
								
				<div class="divCRUDButtons">
					<br /><br />
					<button id="btnSaveRol" onClick="saveRol()" >Guardar</button>					
					<button id="btnEditRol" onClick="editRol()" >Editar</button>
					<button id="btnDeleteRol" onClick="deleteRol()">Eliminar</button>					
					<button id="btnCancelRol" onClick="cancelRol()" >Cancelar</button>
				</div>
				<div align="center" class = "gridView">
					<table id="rolesHist"></table>
					<div style = "height : 40px" id="gridpagerRH"></div>
				</div>
				
			</div>
			
		</div>
		
		
	</body>
</html>