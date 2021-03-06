<html>
	<head>
		<title>Test</title>
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
		<script type="text/javascript">
		$(document).ready(function(){
			 js_ini();
		});
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

			<div class="divActions">

				<h3 class="inputFieldLabel">Bienvenido!</h3>

				<ul>
					<li><span class="inputFieldLabel"><a href="<?php echo base_url(); ?>solicitud">Crear una solicitud</a></span></li>

					<li><span class="inputFieldLabel"><a href="<?php echo base_url(); ?>cliente/listaSolicitudes">Ver mi lista de solicitudes</a></span></li>
					
					<li><span class="inputFieldLabel"><a href="<?php echo base_url(); ?>cliente/resumenProyectos">Ver el resumen de proyectos</a></span></li>


				</ul>


			</div>

		</div>
			<div id="aboutScreen" style="display: none">
				<img src="<?php echo base_url(); ?>application/views/css/img/aboutScreen.png" />		
		</div>	

	</body>
</html>