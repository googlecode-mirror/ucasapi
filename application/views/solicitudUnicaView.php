<html>
	<head>
		<title>PHOBOS - Solicitud</title>
		 <meta http-equiv="X-UA-Compatible" content="IE=8" >
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/horus/jquery-ui-1.8.14.custom.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/ui.jqgrid.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/style.css" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-1.5.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-ui-1.8.14.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/grid.locale-es.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.jqGrid.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.bt.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/main.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.simplemodal.1.4.1.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
			 js_ini();
		});

		function asignarSolicitud() {
			window.location = "/ucasapi/actividada/index/" + $("#anioSolicitud").val() + "/" + $("#correlAnio").val();
		}
		</script>
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
			<span id="systemName"><b>SKY PROJECT??</b></span>
			<img id="aboutButton" title="Acerca de..." src="<?php echo base_url(); ?>application/views/css/img/about.jpg" />
			<img id="logoutButton" title="Cerrar sesion" src="<?php echo base_url(); ?>application/views/css/img/logout_button.png" />
			<span id="sessionUser"><?php echo  utf8_decode($userName); ?></span>
		</div>

		<div><span id="pageTittle"></span></div>

		<div class="container">
			<div style="height: 20px"></div>

			<div id ="msgBox"></div>

			<div class="divActions" align="center">
				<input type="hidden" id="anioSolicitud" value="<?php echo $anioSolicitud; ?>" />
				<input type="hidden" id="correlAnio" value="<?php echo $correlAnio; ?>" />

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
					<button id="btnSave" onClick="asignarSolicitud()">Asignar esta solicitud</button>
				</div>
			</div>

		</div>
			<div id="aboutScreen" style="display: none">
				<img src="<?php echo base_url(); ?>application/views/css/img/aboutScreen.png" />		
		</div>	

	</body>
</html>