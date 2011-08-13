<html>
	<head>	
		<title>Test</title>					
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/horus/jquery-ui-1.8.14.custom.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/style.css" rel="stylesheet" />	
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/ui.jqgrid.css" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-1.5.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-ui-1.8.14.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/grid.locale-es.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.jqGrid.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/ajaxupload.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.bt.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/main.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/actividada.js"></script>
	</head>	
	<body>
		<div class="menuBar">
			<ul>
				<?echo $menu;?>
			</ul>			
		</div>
		
		<div class="sessionBar">
			<img id="systemIcon" src="<?php echo base_url(); ?>application/views/css/img/gears.png" />	
			<span id="systemName"><b>SKY PROJECT??</b></span> 	
			<img id="logoutButton" title="Cerrar sesión" src="<?php echo base_url(); ?>application/views/css/img/logout_button.png" />
			<span id="sessionUser"><?php echo  utf8_decode($userName."/".$roleName); ?></span> 
		</div>
		
		<div><span id="pageTittle"></span></div>
		
		<div class="container" style="height: 1000px">
			<div style="height: 20px"></div>
			
			<div class="divActions" style = "height: 210px">				
				<div class="divCRUDRecords">
					<span class = "recordsLabel">Proyectos</span>
					<input id="txtProjectRecords" type="text"  value="" title = "Búsqueda por proyectos" class = "inputFieldAC"/><br>
					
					<span class = "recordsLabel">Procesos</span>
					<input id="txtProcessRecords" type="text"  value="" title = "Búesqueda por procesos" class = "inputFieldAC"/><br>
					
					<span class = "recordsLabel">Actividades</span>
					<input id="txtRecords" type="text"  value="" title = "Selección de actividad" class = "inputFieldAC"/><br>
				</div>
										
				<div class="divCRUDButtons" style="margin-top: 110px">
					<button id="btnSave" onClick="save()">Guardar</button>
					<button id="btnEdit" onClick="edit()">Editar</button>
					<button id="btnDelete" onClick="deleteData()">Eliminar</button>
					<button id="btnCancel" onClick="cancel()">Cancelar</button>

				</div>				
			</div>
				
			<div id ="msgBox"></div>	
				
				
			<div id="tabs" style = "height: auto;">
				<ul>
					<li><a href="#tabs-1">Información General</a></li>
					<li><a href="#tabs-2">Fases</a></li>
					<li><a href="#tabs-3">Seguidores</a></li>
					<li><a href="#tabs-4">Documentos</a></li>
				</ul>
				
				<div id="tabs-1" class="divDataForm" style="height: 584px;">	
					<input id="idProyecto" type="hidden"  value="" class = "hiddenId"/>
					<input id="idProceso" type="hidden"  value="" class = "hiddenId"/>
					<input id="idActividad" type="hidden"  value="" class = "hiddenId"/>
					<input id="idUsuarioResponsable" type="hidden"  value="" class = "hiddenId"/>
					<input id="idEstado" type="hidden"  value="" class = "hiddenId"/>
					<input id="idPrioridad" type="hidden"  value="" class = "hiddenId"/>
					<input id="idUsuarioAsigna" style="display:none"  value=<?php echo $idUsuario;?> class = "hiddenId"/><br>
				
					<span class = "requiredFieldLabel" >Nombre</span>
					<input id="txtActivityName" type="text"  value="" class = "inputField" title="Nombre de la actividad"/><br>
					
					<span class = "requiredFieldLabel" >Proyecto</span>
					<input id="txtProjectName" type="text"  value="" class = "inputFieldAC" title="Proyecto al que la actividad está asociada"/><br>
					
					<span class = "inputFieldLabel" >Proceso</span>
					<input id="txtProcessName" type="text"  value="" class = "inputFieldAC" title="Proceso al que la actividad está asociada"/><br>
					
					<span class = "requiredFieldLabel" >Responsable</span>
					<input id="txtResponsibleName" type="text"  value="" class = "inputFieldAC" title="Usuario responsable de la actividad"/><br>
					
					<span class = "requiredFieldLabel" >Prioridad</span>
					<input id="txtPriorityName" type="text"  value="" class = "inputFieldAC" title="Usuario responsable de la actividad"/><br>
					
					<span class = "requiredFieldLabel" >Estado</span>
					<input id="txtStatusName" type="text"  value="" class = "inputFieldAC" title="Usuario responsable de la actividad"/><br>
					
					<span class = "inputFieldLabel" >Planificación</span>
					<div class="divDateCombo">
						<span>Inicio</span>
						<input id="txtStartingDate" type="text"  value=""  title="Fecha de inicio planificada de la actividad" readonly/><br>
						<span>Fin</span>
						<input id="txtEndingDate" type="text"  value=""  title="Fecha fin planificada de la actividad" readonly/><br>
					</div>

					<span class = "requiredFieldLabel" style = "clear:both">Descripción</span>
					<textArea id="txtActivityDesc" cols=20 rows=6 class = "inputFieldTA" title="Descripción del departamento" ></textArea>
				</div>
				
				<div id="tabs-2">
					<button id="btnUpload">Subir documento</button>
				</div>
				
				<div id="tabs-3">
					<div class = "gridView" style = "width : 480px">
						<table id="usersGrid"><tr><td/></tr></table> 
						<div id="upager"></div>
					</div>
					<div class="divAddButton">
						<button id="btnAddUser" onClick = "addUser()">Agregar</button>
					</div>	
					
					<div class = "gridView" style = "width : 480px">
						<table id="followersGrid"><tr><td/></tr></table> 
						<div id="fpager"></div>
					</div>
						<div class="divAddButton">
						<button id="btnRemoveUser" onClick = "removeUser()">Quitar</button>
					</div>						
				</div>	
				
				<div id="tabs-4">
						<button id="btnUpload">Subir documento</button>
				</div>				
			</div>			
		</div>	
		
	</body>
</html>