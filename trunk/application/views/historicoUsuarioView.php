<html>
	<head>
		<title>PHOBOS - Contratos</title>
	 	<meta http-equiv="X-UA-Compatible" content="IE=8" >		
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/horus/jquery-ui-1.8.14.custom.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/ui.jqgrid.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/style.css" rel="stylesheet" />	
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-1.5.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-ui-1.8.14.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/grid.locale-es.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.jqGrid.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.bt.min.js"></script>
		
		
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/dateUtils.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/validaciones.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.simplemodal.1.4.1.min.js"></script>
		
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/main.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/historicoUsuario.js"></script>
		
		
	</head>	
	<body>
		<div class="menuBar" style="height: 52px"> 
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
			<img id="logoutButton" title="Cerrar sesión" src="<?php echo base_url(); ?>application/views/css/img/logout_button.png" />
			<span id="sessionUser"><?php echo  utf8_decode($userName."/".$roleName); ?></span>
		</div>
		
		<div><span id="pageTittle"></span></div>
		
		<div class="container" style = "height : auto">
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
				<input id="contratosPressed" type="hidden"  value="" class = "hiddenId"/>
								
				<span class = "requiredFieldLabel">Inicio contrato:</span>
				<input id="txtFechaInicioContrato" type="text"  value="" class = "jqcalendario" title = "Fecha inicio de este contrato" readonly/><br>
											
				<span class = "requiredFieldLabel">Fin contrato:</span>
				<input id="txtFechaFinContrato" type="text"  value="" class = "jqcalendario" title = "Fecha finalización de este contrato" readonly/><br>
								
				<span class = "requiredFieldLabel">Tiempo contrato:</span>
				<input id="txtTiempoContrato" type="text"  value="" class = "inputFieldNUM" title = "Tiempo en meses que durara el contrato" maxlength="4"/>				
				
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
			
			<div id="roles"class="divDataForm" style="height: 515px; margin-top: 20px">
				<span class = "requiredFieldLabel">Rol:</span>
				<input id="txtHistoricoRol" type="text"  value="" class = "inputFieldAC" title = "Rol Desempeñado" maxlength="40"/><br>
			
				<span class = "requiredFieldLabel">Fecha asignación:</span>
				<input id="txtFechaInicioRol" type="text"  value="" class = "jqcalendario" title = "Fecha en que se vinculo este rol" readonly/><br>
											
				<span class = "inputFieldLabel">Fecha fin:</span>
				<input id="txtFechaFinRol" type="text"  value="" class = "jqcalendario" title = "Fecha en que se desvinculo" readonly/><br>
								
				<span class = "inputFieldLabel">Salario:</span>
				<input id="txtSalarioRol" type="text"  value="" class = "inputFieldNUM" title = "Salario devengado" maxlength="8"/><br>
								
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