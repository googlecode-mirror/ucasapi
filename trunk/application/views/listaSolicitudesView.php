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
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/listaSolicitudes.js"></script>

	</head>

	<body>

		<div class="menuBar">
			<ul>

			</ul>
		</div>

		<div class="sessionBar">
			<span id="sessionUser"><?php echo $this->session->userdata("username") . ' - ' . $this->session->userdata("idUsuario"); ?></span>
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

		</div>

	</body>
</html>