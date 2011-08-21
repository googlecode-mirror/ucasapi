<html>
	<head>
		<title>PHOBOS - Lista de solicitudes</title>

		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/horus/jquery-ui-1.8.14.custom.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/ui.jqgrid.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/style.css" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-1.5.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-ui-1.8.14.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/grid.locale-es.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.jqGrid.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.bt.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/main.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/listaSolicitudes.js"></script>

	</head>

	<body>

		<div class="menuBar">
			<ul>
				<?php echo $menu;?>
			</ul>
		</div>

		<div class="sessionBar">
			<img id="systemIcon" src="<?php echo base_url(); ?>application/views/css/img/gears.png" />	
			<span id="systemName"><b>PHOBOS PLANING</b></span> 	
			<img id="logoutButton" title="Cerrar sesi�n" src="<?php echo base_url(); ?>application/views/css/img/logout_button.png" />
			<span id="sessionUser"><?php echo  utf8_decode($userName."/".$roleName); ?></span> 
		</div>

		<div><span id="pageTittle"></span></div>

		<div class="container">
			<div style="height: 20px"></div>

			<div id ="msgBox"></div>

			<div class="divDataForm">

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

				<span class = "inputFieldLabel"><b>Descripci&oacute;n:</b></span><br/>
				<textArea readonly="readonly" id="txtSolicitudDesc" cols=20 rows=6 class = "inputFieldTA"></textArea><br>
				<br><br>

				<span class = "inputFieldLabel"><b>Fecha de inicio:</b></span><br/>
				<span class="cleanable" id="fechaInicio"></span><br/><br/>

				<span class = "inputFieldLabel"><b>Progreso (en %):</b></span><br/>
				<span class="cleanable" id="progreso"></span><br/><br/>

				<input type="hidden" value="" id="idSolicitud"/>

			</div>

		</div>

	</body>
</html>