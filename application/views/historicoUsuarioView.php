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
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/historicoUsuario.js"></script>
	</head>	
	<body>
		<div class="menuBar"> 
	     	<ul>
	            <li><span class="menu_button_to"><a href="http://www.google.com"><span class="menu_button_text">Acci�n</span></a></span></li>
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
		
		<div class="container" style = "height : 400px">
			<div style="height: 20px"></div>
			
			<div class="divActions">				
				<div class="divCRUDRecords">
					<span class = "recordsLabel">Usuario:</span>
					<input id="txtRecords" type="text"  value=""/><br>
				</div>
							
				<div class="divCRUDButtons">					
					<button id="btnEdit" onClick="edit()">Editar Contratos</button>					
					<button id="btnCancel" onClick="cancel()">Cancelar</button>

				</div>
			</div>
				
			<div id ="msgBox"></div>	
				
			<div class="divDataForm" style="height: 250px">
				<input id="idUsuario" type="hidden"  value="" class = "hiddenId"/><br>		
				
				<span class = "inputFieldLabel">Fecha inicio contrato:</span>
				<input id="txtUsuarioCodigo" type="text"  value="" class = "jqcalendario" title = "Fecha inicio de contrato"/><br>
							
				<span class = "inputFieldLabel">Fecha fin contrato:</span>
				<input id="txtUsuarioPrimerNombre" type="text"  value="" class = "jqcalendario" title = "Fecha fin de contrato"/><br>
				
				<span class = "inputFieldLabel">Tiempo de contrato:</span>
				<input id="txtUsuarioOtrosNombres" type="text"  value="" class  = "inputField" title = "Meses de contrato"/><br>
								
				<span class = "inputFieldLabel">Activo:</span>
				<input id="chkUsuarioActivo" type="checkbox" value="1" title = "Checkear si el usuario esta activo en el sistema"/><br>
				
				<div class="divContratoButtons">
					<button id="btnSaveContrato" onClick="saveContrato()" >Guardar contrato</button>					
					<button id="btnCancelContrato" onClick="cancelContrato()" >Cancelar</button>
				</div>				
				
			</div>
			
			<table align="center"">
			<tr>
				<td>
				<div align="center" style="background-color:#ffffff">
					<table align="center">
						<tr>
							<td>
								<table id="usuarioHist"></table>
								<div style = "height : 40px" id="gridpagerUH"></div>
							</td>
						</tr>				
					</table>
				</div>
				</td>
			</tr>
			<tr>
				<td>
					<div align="center" style="background-color:#ffffff">
						<table align="center">
							<tr>
								<td>
									<table id="rolHist"></table>
									<div style = "height : 40px" id="gridpagerRH"></div>
								</td>
							</tr>				
						</table>
					</div>
				</td>
			</tr>

			</table>
			
			
			
				
			<!-- </div>  -->	
		</div>
		
	</body>
</html>