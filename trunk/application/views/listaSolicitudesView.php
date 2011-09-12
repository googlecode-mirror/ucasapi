<html>
	<head>
		<title>PHOBOS - Lista de solicitudes</title>
		<meta http-equiv="X-UA-Compatible" content="IE=8" >
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/horus/jquery-ui-1.8.14.custom.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/ui.jqgrid.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/style.css" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-1.5.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-ui-1.8.14.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/grid.locale-es.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.jqGrid.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.bt.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.simplemodal.1.4.1.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/main.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/listaSolicitudes.js"></script>

	</head>

	<body>

		<div class="menuBar" style="height:52px">
			<ul>
				<?php echo $menu;?>
			</ul>
		</div>

		<div class="sessionBar">
			<img id="systemIcon" src="<?php echo base_url(); ?>application/views/css/img/gears.png" />
			<span id="systemName"><b>PHOBOS PLANING</b></span>
			<img id="aboutButton" title="Acerca de..." src="<?php echo base_url(); ?>application/views/css/img/about.jpg" />
			<img id="logoutButton" title="Cerrar sesi�n" src="<?php echo base_url(); ?>application/views/css/img/logout_button.png" />
			<span id="sessionUser"><?php echo  utf8_decode($userName."/".$roleName); ?></span>
		</div>

		<div><span id="pageTittle"></span></div>

		<div class="container">
			<div style="height: 20px"></div>

			<div id ="msgBox"></div>

			<div class="divDataForm" style="height: 650px">

				<span class="inputFieldLabel">Solicitudes que he enviado:</span><br/><br/><br/>

				<div align="center">
					<table id="list"><tr><td/></tr></table>
					<div id="pager"></div>
				</div>
				<br/><br/>

				<span class="inputFieldLabel">Solicitudes que observo:</span><br/><br/><br/>

				<div align="center">
					<table id="list2"><tr><td/></tr></table>
					<div id="pager2"></div>
				</div>

			</div>

			<div align="center" id="dialogoSolicitud" style="visibility: hidden;">
				<span class = "inputFieldLabel"><b>T&iacute;tulo:</b></span><br/>
				<span class="cleanable" id="tituloSolicitud"></span><br/><br/>

				<span class = "inputFieldLabel"><b>Ingresada el:</b></span><br/>
				<span class="cleanable" id="fecha"></span><br/><br/>

				<span class = "inputFieldLabel"><b>Por:</b></span><br/>
				<span class="cleanable" id="cliente"></span><br/><br/>

				<span class = "inputFieldLabel"><b>Descripci&oacute;n de la solicitud:</b></span><br/>
				<textArea readonly="readonly" id="txtSolicitudDesc" cols=20 rows=6 class = "inputFieldTA"></textArea><br>
				<br><br>

				<span class = "inputFieldLabel"><b>Fecha de inicio:</b></span><br/>
				<span class="cleanable" id="fechaInicio"></span><br/><br/>

				<span class = "inputFieldLabel"><b>Fecha esperada de resoluci&oacute;n:</b></span><br/>
				<span class="cleanable" id="fechaFinEsperada"></span><br/><br/>

				<span class = "inputFieldLabel"><b>Fecha de resoluci&oacute;n:</b></span><br/>
				<span class="cleanable" id="fechaFin"></span><br/><br/>

				<span class = "inputFieldLabel"><b>Progreso (en %):</b></span><br/>
				<span class="cleanable" id="progreso"></span><br/><br/>

				<input type="hidden" value="" id="idSolicitud"/>

				<button id="btnEdit" onClick="goToEdit()">Editar</button>

			</div>

		</div>
			<div id="aboutScreen" style="display: none">
				<img src="<?php echo base_url(); ?>application/views/css/img/aboutScreen.png" />
		</div>

	</body>
</html>