<html>
	<head>
		<title>Test</title>
		<?php
			require_once("application/models/menuOptionsModel.php");
			$menuBarModel = new menuBarModel();
		?>
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/horus/jquery-ui-1.8.14.custom.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/ui.jqgrid.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/style.css" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-1.5.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-ui-1.8.14.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/grid.locale-es.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.jqGrid.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.bt.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/main.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/ventanilla.js"></script>

	</head>

	<body>

		<div class="menuBar">
			<ul>
				<?php $menuBarModel->showMenu();?>
			</ul>
		</div>

		<div class="sessionBar">
			<img id="logoutButton" title="Cerrar sesi�n" src="<?php echo base_url(); ?>application/views/css/img/logout_button.png" />
			<span id="sessionUser"><?php echo $this->session->userdata("username") . ' - ' . $this->session->userdata("idUsuario"); ?></span>
		</div>

		<div><span id="pageTittle"></span></div>

		<div class="container">
			<div style="height: 20px"></div>

			<div class="divActions">
				<table id="list"><tr><td/></tr></table>
				<div id="pager"></div>
				<br/><br/>
			</div>

			<div id ="msgBox"></div>

			<div class="divActions">
				<span class = "inputFieldLabel">Ingresada el:</span>
				<span class="cleanable" id="fecha"></span> <br/><br/>

				<span class = "inputFieldLabel">Por:</span>
				<span class="cleanable" id="cliente"></span><br/><br/>

				<span class = "inputFieldLabel">T&iacute;tulo:</span>
				<span class="cleanable" id="tituloSolicitud"></span><br/><br/>

				<span class = "inputFieldLabel">Prioridad:</span>
				<span class="cleanable" id="prioridad"></span><br/><br/>

				<span class = "inputFieldLabel">Descripci&oacute;n:</span>
				<textArea readonly="readonly" id="txtSolicitudDesc" cols=20 rows=6 class = "inputFieldTA"></textArea><br>
				<br><br>

				<span class = "inputFieldLabel">Otros interesados:</span>
				<span class="cleanable" id="interesados"></span><br><br><br>

				<div id ="msgBox"></div>

				<div id="tabs">
					<ul>
						<li><a href="#tabs-1">Asignar la solicitud</a></li>
						<li><a href="#tabs-2">Transferir la solicitud</a></li>
					</ul>

					<div id="tabs-1" class="divDataForm">
						<button id="btnSave" onClick="asignarSolicitud()">Asignar esta solicitud</button>
					</div>

					<div id="tabs-2">
						<div class="divDataForm">
							<input type="hidden" value="" id="idUsuario"/>
							<span class = "inputFieldLabel">Destinatario:</span>
							<input id="txtRecords" type="text" disabled="disabled"  value="" class="inputFiledAC" /><br/><br/><br/><br/><br/>
							<button id="btnUpload" onClick="transferirSolicitud()">Transferir la solicitud</button>
						</div>
					</div>

				</div>


			</div>

		</div>

	</body>
</html>