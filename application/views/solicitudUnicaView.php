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
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/main.js"></script>

	</head>

	<body>

		<div class="menuBar">
			<ul>

			</ul>
		</div>

		<div class="sessionBar">
			<img id="logoutButton" title="Cerrar sesi�n" src="<?php echo base_url(); ?>application/views/css/img/logout_button.png" />
			<!-- <span id="sessionUser"><?php //echo $this->session->userdata("username") . ' - ' . $this->session->userdata("idUsuario"); ?></span> -->
		</div>

		<div><span id="pageTittle"></span></div>

		<div class="container">
			<div style="height: 20px"></div>

			<div id ="msgBox"></div>

			<div class="divActions">
				<span class = "inputFieldLabel">Ingresada el:</span>
				<span class="cleanable" id="fecha"><?php echo $data[0]->fechaEntrada; ?></span> <br/><br/>

				<span class = "inputFieldLabel">Por:</span>
				<span class="cleanable" id="cliente"><?php echo $data[0]->cliente; ?></span><br/><br/>

				<span class = "inputFieldLabel">T&iacute;tulo:</span>
				<span class="cleanable" id="tituloSolicitud"><?php echo $data[0]->titulo; ?></span><br/><br/>

				<span class = "inputFieldLabel">Prioridad:</span>
				<span class="cleanable" id="prioridad"><?php echo $data[0]->prioridadCliente; ?></span><br/><br/>

				<span class = "inputFieldLabel">Descripci&oacute;n:</span>
				<textArea readonly="readonly" id="txtSolicitudDesc" cols=20 rows=6 class = "inputFieldTA"><?php echo $data[0]->descripcion; ?></textArea>
				<br><br><br>

				<span class = "inputFieldLabel">Otros interesados:</span>
				<span class="cleanable" id="interesados">
					<?php
						$i=1;
						for($i=1 ; $i < count($data) ; $i++) {
							echo $data[$i]->cliente . " - " . $data[$i]->cargo;
						}
					?>
				</span><br><br><br>
			</div>

		</div>

	</body>
</html>