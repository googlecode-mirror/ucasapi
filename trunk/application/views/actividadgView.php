<html>
<head>
<title>Test</title>
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/humanity/jquery-ui-1.8.14.custom.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/ui.jqgrid.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/style.css" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-1.5.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.bt.min.js"></script>	
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-ui-1.8.14.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/grid.locale-es.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.jqGrid.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/main.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/actividadg.js"></script>
		<style>
			.mybold td {font-weight : bold !important}
		</style>
</head>
<body>
	
	<div class="menuBar">
		<ul>
			<li><span class="menu_button_to"><a href="http://www.google.com"><span
						class="menu_button_text">Dinamic</span> </a> </span>
			</li>
			<li class="highlight"><span class="menu_button_to"><a
					href="http://www.google.com"><span class="menu_button_text">Dinamic</span>
				</a> </span>
			</li>
			<li><span class="menu_button_to"><a href="http://www.google.com"><span
						class="menu_button_text">Dinamic</span> </a> </span>
			</li>
			<li><span class="menu_button_to"><a href="http://www.google.com"><span
						class="menu_button_text">Dinamic</span> </a> </span>
			</li>
		</ul>
	</div>

	<div class="sessionBar">
		<span id="sessionUser"></span>
	</div>

	<div>
		<span id="pageTittle"></span>
	</div>

	<div class="container">
		<div style="height: 20px"></div>
		<div id="msgBox"></div>
		<input id="idUsuario" type="hidden" value="1" class="hiddenId" />

		<div class="divDataForm">
			<table id="tablaActividades"></table>
			<div id="pager"></div>
			<br>
		</div>
		<br> <br> <br>
		<div align="center">
			<button id="btnGet" onClick="load()">Ver Mensaje</button>
			<button id="btnCancel" onClick="cancel()">Ocultar</button>
		</div>

		<br>

	</div>

</body>
</html>