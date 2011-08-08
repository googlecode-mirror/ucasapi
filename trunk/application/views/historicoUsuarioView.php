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
				
			<div class="divDataForm" style="height: 850px">
				<input id="idUsuario" type="hidden"  value="" class = "hiddenId"/><br>								
				<input id="accionActual" type="hidden"  value="" class = "hiddenId"/><br>
								
				<span class = "requiredFieldLabel">Inicio contrato:</span>
				<input id="txtFechaInicioContrato" type="text"  value="" class = "jqcalendario" title = "Fecha inicio de este contrato" readonly/><br>
											
				<span class = "requiredFieldLabel">Fin contrato:</span>
				<input id="txtFechaFinContrato" type="text"  value="" class = "jqcalendario" title = "Fecha finalización de este contrato" readonly/><br>
								
				<span class = "requiredFieldLabel">Tiempo contrato:</span>
				<input id="txtTiempoContrato" type="text"  value="" class = "inputFieldNUM" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" title = "Tiempo en meses que durara el contrato"/><br>				
				
				
				<br>
				<div class="divAddButton">
					<button id="btnSaveContrato" onClick="saveContrato()" >Guardar</button>					
					<button id="btnEditContrato" onClick="editContrato()" >Editar</button>
					<button id="btnDeleteContrato" onClick="deleteData()">Eliminar</button>
					<button id="btnCancelContrato" onClick="cancelContrato()" >Cancelar</button>
				</div>
				<br>
				<div align="center" class = "gridView" style = "width : 480px">
						<table id="usuarioHist"></table>
						<div style = "height : 40px" id="gridpagerUH"></div>
				</div>	
				
			</div>
			<!-- <div class="divDataForm" style="height: 250px" align="center">  -->
				<input id="idRol" type="hidden"  value="" class = "hiddenId"/><br>				
				
					
			<!-- </div> -->
			
			
		</div>
		
	</body>
</html>