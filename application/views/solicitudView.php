<html>
	<head>
		<title>PHOBOS - Solicitud</title>
		 <meta http-equiv="X-UA-Compatible" content="IE=8" >
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/horus/jquery-ui-1.8.14.custom.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/style.css" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-1.5.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-ui-1.8.14.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.bt.min.js"></script>

		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/validaciones.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.simplemodal.1.4.1.min.js"></script>

		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/main.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/solicitud.js"></script>

	</head>

	<body>

		<div class="menuBar" style="height:52px">
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
			<img id="aboutButton" title="Acerca de..." src="<?php echo base_url(); ?>application/views/css/img/about.jpg" />
			<img id="logoutButton" title="Cerrar sesi�n" src="<?php echo base_url(); ?>application/views/css/img/logout_button.png" />
			<span id="sessionUser"><?php echo  utf8_decode($userName."/".$roleName); ?></span>
		</div>

		<div><span id="pageTittle"></span></div>


		<div class="container" style="height: auto">
		<br/>

			 <div class="divActions">
			 	<div class="divCRUDButtons">
						<button id="btnSave" onClick="crearSolicitud()">Guardar</button>
						<button id="btnCancel" onClick="cancel()">Cancelar</button>
				</div>
			 </div>
			<div id ="msgBox"></div>

			<div class="divDataForm" style="height: 250px">

				<span class = "requiredFieldLabel">Asunto:</span>
				<input id="txtSolicitudAsunto" type="text"  value="" class = "inputField" title = "Titulo de la peticion" maxlength="40"/><br>

				<span class = "requiredFieldLabel">Prioridad:</span>
				<select name="prioridades" id="cbxPrioridades" class = "selectList" >
				</select>
				<br>

				<span class = "requiredFieldLabel">Descripci&oacute;n:</span>
				<textArea id="txtSolicitudDesc" cols=20 rows=6 class = "inputFieldTA"></textArea><br>
				<br><br><br><br><br><br><br><br><br><br>
			</div>

			<div style="height: 20px"></div>

			<div class="divActions">
				<div class="divCRUDRecords">
					<span class="recordsLabel">Nombre: </span>
					<input id="txtRecords" type="text"  value="" class="inputFiledAC" /><br>
					<span class="recordsLabel">Seguidores: </span>
					<select size="5" multiple="multiple" id="cbxInteresados" class="selectList"></select><br>
				</div>

				<div class="divCRUDButtons">
				<br>
					<button id="btnDelete" onClick="remove()">Quitar Seguidor</button>
				</div>

			</div>
			<div style="height: 20px"></div>

		</div>
			<div id="aboutScreen" style="display: none">
				<img src="<?php echo base_url(); ?>application/views/css/img/aboutScreen.png" />		
		</div>	

	</body>
</html>