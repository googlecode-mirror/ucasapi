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
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/main.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/usuario.js"></script>
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
				
				<span class = "inputFieldLabel">Codigo empleado:</span>
				<input id="txtUsuarioCodigo" type="text"  value="" class = "inputField" title = "Codigo empleado UCA"/><br>
							
				<span class = "requiredFieldLabel">Primer nombre:</span>
				<input id="txtUsuarioPrimerNombre" type="text"  value="" class = "inputField" title = "Primer nombre del usuario"/><br>
				
				<span class = "inputFieldLabel">Otros Nombre:</span>
				<input id="txtUsuarioOtrosNombres" type="text"  value="" class = "inputField" title = "Otros nombres del usuario"/><br>
				
				<span class = "requiredFieldLabel">Primer Apellido:</span>
				<input id="txtUsuarioPrimerApellido" type="text"  value="" class = "inputField" title = "Primer apellido del usuario "/><br>
				
				<span class = "inputFieldLabel">Otros Apellidos:</span>
				<input id="txtUsuarioOtrosApellidos" type="text"  value="" class = "inputField" title = "Otros apellidos del usuario"/><br>
				
				<span class = "requiredFieldLabel">Fecha nacimiento:</span>
				<input id="txtProyectoFechaNacimiento" type="text"  value="" class = "jqcalendario" title = "Fecha nacimiento del usuario"/><br>
				
				<span class = "requiredFieldLabel">Usuario sistema:</span>
				<input id="txtUsuarioUserName" type="text"  value="" class = "inputField" title = "Nombre de usuario de sistema"/><br>

				<span class = "requiredFieldLabel">Contraseña:</span>
				<input id="txtUsuarioPassword" type="password"  value="" class = "inputFieldPSW" title = "Contraseña para el usuario"/><br>
				
				<span class = "requiredFieldLabel">Confirmar:</span>
				<input id="txtUsuarioConfirmar" type="password"  value="" class = "inputFieldPSW" title = "Confirmación de contrasela"/><br>
				
				<span class = "requiredFieldLabel">DUI:</span>
				<input id="txtUsuarioDUI" type="text"  value="" class = "inputField" title = "Documento Unico de Identidad del usuario"/><br>				
				
				<span class = "inputFieldLabel">NIT:</span>
				<input id="txtUsuarioNIT" type="text"  value="" class = "inputField" title = "Número de identificación tributaria"/><br>
				
				<span class = "inputFieldLabel">ISSS:</span>
				<input id="txtUsuarioISSS" type="text"  value="" class = "inputField" title = "Número de afiliacion al ISSS"/><br>
				
				<span class = "inputFieldLabel">NUP:</span>
				<input id="txtUsuarioNUP" type="text"  value="" class = "inputField" title = "Número de afiliación de AFP"/><br>
				
				<span class = "requiredFieldLabel">Departamento:</span>
				<input id="txtUsuarioDepartamento" type="text"  value="" class = "inputField" title = "Departamento universitario al que pertenece"/><br>
				
				<span class = "requiredFieldLabel">Cargo:</span>
				<input id="txtUsuarioCargo" type="text"  value="" class = "inputField" title = "Cargo que desempeña en la universidad"/><br>
				
				<span class = "inputFieldLabel">Carnet:</span>
				<input id="txtUsuarioCarnet" type="text"  value="" class = "inputField" title = "Carnet de estudiante UCA"/><br>
				
				<span class = "inputFieldLabel">Email Personal:</span>
				<input id="txtUsuarioEmailPersonal" type="text"  value="" class = "inputField" title = "Dirección de correo electronico personal"/><br>
				
				<span class = "inputFieldLabel">Email Institucional:</span>
				<input id="txtUsuarioEmailInstitucional" type="text"  value="" class = "inputField" title = "Dirección de correo electronico institucional"/><br>
				
				<span class = "inputFieldLabel">Telefono Contacto:</span>
				<input id="txtUsuarioTelefono" type="text"  value="" class = "inputField" title = "Teléfono de contacto personal"/><br>
				
				<span class = "inputFieldLabel">Extension:</span>
				<input id="txtUsuarioExtension" type="text"  value="" class = "inputField" title = "Extensión UCA"/><br>
				
				<span class = "inputFieldLabel">Activo:</span>
				<input id="chkUsuarioActivo" type="checkbox" value="1" title = "Checkear si el usuario esta activo en el sistema" class="inputCHK"/><br>
				
			</div>
			<!-- <div class="divDataForm" style="height: 250px" align="center">  -->
				<input id="idRol" type="hidden"  value="" class = "hiddenId"/><br>
			<!-- 
				<span class = "inputFieldLabel">Rol:</span>
				<input id="txtUsuarioRolNombre" type="text"  value="" class = "inputField"/><br>
				 -->
				
				
				<table>
				<tr>
					<td>
						<table id="todosRoles" align="center"><tr><td/></tr></table>
						<div id="pagerTR"></div>
					</td>
					<td>
						<button id="btnCancel" onClick="agregarRol()">Agregar</button>
						<button id="btnCancel" onClick="eliminarRol()">Elminar Rol</button>
					</td>	
					<td>
						<table id="list" align="center"><tr><td/></tr></table>
						<div id="pager"></div>
					</td>				
				</table>				
				
				
				
				
				
				
			<!-- </div>  -->	
		</div>
		
	</body>
</html>