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
		<script type="text/javascript">
		$(document).ready(function(){
			 js_ini();
		});
		</script>
	</head>

	<body>

		<div class="menuBar">
			<ul>
				<?php echo $menu;?>
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

			<div id ="msgBox"></div>

			<div class="divActions" align="center">
				<span class = "inputFieldLabel"><b>Ingresada el:</b></span><br/>
				<span class="cleanable" id="fecha"><?php echo $data[0]->fechaEntrada; ?></span><br/><br/>

				<span class = "inputFieldLabel"><b>Por:</b></span><br/>
				<span class="cleanable" id="cliente"><?php echo $data[0]->cliente; ?></span><br/><br/>

				<span class = "inputFieldLabel"><b>T&iacute;tulo:</b></span><br/>
				<span class="cleanable" id="tituloSolicitud"><?php echo $data[0]->titulo; ?></span><br/><br/>

				<span class = "inputFieldLabel"><b>Prioridad:</b></span><br/>
				<span class="cleanable" id="prioridad"><?php echo $data[0]->prioridadCliente; ?></span><br/><br/>

				<span class = "inputFieldLabel"><b>Descripci&oacute;n:</b></span><br/>
				<textArea readonly="readonly" id="txtSolicitudDesc" cols=20 rows=6 class = "inputFieldTA"><?php echo $data[0]->descripcion; ?></textArea><br>
				<br><br>

				<span class = "inputFieldLabel"><b>Otros interesados:</b></span><br/>
				<span class="cleanable" id="interesados">
					<?php
						$i=1;
						for($i=1 ; $i < count($data) ; $i++) {
							echo $data[$i]->cliente . " - " . $data[$i]->cargo . "<br/>";
						}
					?>
				</span><br><br><br>

				<div class="divCRUDButtons">
					<button id="btnSave" onClick="alert('Hay que implementar esta funcionalidad')">Asignar esta solicitud</button>
				</div>
			</div>

		</div>

	</body>
</html>