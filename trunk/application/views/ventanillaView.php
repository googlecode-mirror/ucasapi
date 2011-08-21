<html>
	<head>
		<title>Test</title>

		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/horus/jquery-ui-1.8.14.custom.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/ui.jqgrid.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/style.css" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-1.5.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-ui-1.8.14.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/grid.locale-es.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.jqGrid.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.bt.min.js"></script>
		
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/validaciones.js"></script>
		
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/main.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/ventanilla.js"></script>

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
			<img id="logoutButton" title="Cerrar sesi�n" src="<?php echo base_url(); ?>application/views/css/img/logout_button.png" />
			<span id="sessionUser"><?php echo  utf8_decode($userName); ?></span>
		</div>

		<div><span id="pageTittle"></span></div>

		<div class="container">
			<div style="height: 20px"></div>

			<div class="divActions" align="center">
				<table id="listPeticion"><tr><td/></tr></table>
				<div id="pager"></div>
				<br/><br/>
			</div>			

			<div align="center" id="dialogoSolicitud" style="visibility: hidden;">
				<span class = "inputFieldLabel"><b>Ingresada el:</b></span><br/>
				<span class="cleanable" id="fecha"></span><br/><br/>

				<span class = "inputFieldLabel"><b>Por:</b></span><br/>
				<span class="cleanable" id="cliente"></span><br/><br/>

				<span class = "inputFieldLabel"><b>T&iacute;tulo:</b></span><br/>
				<span class="cleanable" id="tituloSolicitud"></span><br/><br/>

				<span class = "inputFieldLabel"><b>Prioridad:</b></span><br/>
				<span class="cleanable" id="prioridad"></span><br/><br/>

				<span class = "inputFieldLabel"><b>Descripci&oacute;n:</b></span><br/>
				<textArea readonly="readonly" id="txtSolicitudDesc" cols=20 rows=6 class = "inputFieldTA"></textArea><br>
				<br><br>

				<span class = "inputFieldLabel"><b>Otros interesados:</b></span><br/>
				<span class="cleanable" id="interesados"></span><br><br><br>

				<input type="hidden" value="" id="idSolicitud"/>
				<button id="btnSave" onClick="cargarDialogoAsignacion()">Asignar esta solicitud</button>
				<button id="btnUpload" onClick="definirDestinatario()">Transferir la solicitud</button>
			</div>

			<div align="center" id="dialogoTransferir" style="visibility: hidden;">
				<input type="hidden" value="" id="idUsuario"/>
				<span class = "inputFieldLabel"><b>Destinatario:</b></span><br/>
				<input id="txtRecords" type="text" disabled="disabled"  value="" class="inputFiledAC" /><br/><br/>
				<button id="btnUpload" onClick="transferirSolicitud()">Transferir</button>
			</div>

			<div align="center" id="dialogoAsignar" style="visibility: hidden;">
			<div id ="msgBox"></div>
				<span class = "requiredFieldLabel" >Nombre</span><br/>
				<input id="txtActivityName" type="text"  value="" class = "inputField" title="Nombre de la actividad" maxlength="40"/><br/><br/>

				<span class = "requiredFieldLabel" >Proyecto</span><br/>
				<input id="txtProjectName" type="text"  value="" class = "inputField" title="Proyecto al que la actividad est&aacute; asociada" maxlength="100"/><br/><br/>

				<span class = "inputFieldLabel" >Proceso</span><br/>
				<input id="txtProcessName" type="text"  value="" class = "inputField" title="Proceso al que la actividad est&aacute; asociada" maxlength="40"/><br/><br/>

				<span class = "requiredFieldLabel" >Responsable</span><br/>
				<input id="txtResponsibleName" type="text"  value="" class = "inputField" title="Usuario responsable de la actividad" maxlength="80"/><br/><br/>

				<span class = "requiredFieldLabel" >Prioridad</span><br/>
				<input id="txtPriorityName" type="text"  value="" class = "inputField" title="Usuario responsable de la actividad" maxlength="40"/><br/><br/>

				<span class = "requiredFieldLabel" >Estado</span><br/>
				<input id="txtStatusName" type="text"  value="" class = "inputField" title="Usuario responsable de la actividad" maxlength="40"/><br/><br/>

				<span class = "inputFieldLabel" >Planificaci&oacute;n</span><br/>
				<div class="divDateCombo">
					<span>Inicio</span>
					<input id="txtStartingDate" type="text"  value=""  title="Fecha de inicio planificada de la actividad" readonly/><br/>
					<span>Fin</span>
					<input id="txtEndingDate" type="text"  value=""  title="Fecha fin planificada de la actividad" readonly/><br/>
				</div><br/><br/>

				<span class = "requiredFieldLabel" style = "clear:both">Descripci&oacute;n</span><br/>
				<textArea id="txtActivityDesc" cols=20 rows=6 class = "inputFieldTA" title="Descripci�n del departamento" ></textArea>

				<input id="idProyecto" type="hidden"  value="" class = "hiddenId"/>
				<input id="idProceso" type="hidden"  value="" class = "hiddenId"/>
				<input id="idActividad" type="hidden"  value="" class = "hiddenId"/>
				<input id="idUsuarioResponsable" type="hidden"  value="" class = "hiddenId"/>
				<input id="idEstado" type="hidden"  value="" class = "hiddenId"/>
				<input id="idPrioridad" type="hidden"  value="" class = "hiddenId"/>
				<input id="idUsuarioAsigna" style="display:none"  value=<?php echo $idUsuario;?> class = "hiddenId"/>
				<br/><br/>

				<button onClick="asignarSolicitud()">Asignar</button>
			</div>

			<!--
			<div id="dialogoAsignar"></div>
			 -->



		</div>

	</body>
</html>