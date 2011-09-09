<html>
	<head>
		<title>PHOBOS - Resumen de mis proyectos</title>
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
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/resumenProyectos.js"></script>

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
			<img id="logoutButton" title="Cerrar sesión" src="<?php echo base_url(); ?>application/views/css/img/logout_button.png" />
			<span id="sessionUser"><?php echo  utf8_decode($userName."/".$roleName); ?></span> 
		</div>

		<div><span id="pageTittle"></span></div>

		<div class="container">
			<div style="height: 20px"></div>

			<div id ="msgBox"></div>

			<div class="divDataForm">
				<input type="hidden" id="idUsuario" value="<?php echo $idUsuario; ?>"/>

				<span class="inputFieldLabel">Proyectos:</span><br/><br/><br/>

				<div align="center">
					<table id="list"><tr><td/></tr></table>
					<div id="pager"></div>
				</div>

			</div>

			<div align="center" id="dialogoProyecto" style="visibility: hidden;" title="Resumen del proyecto">
				<span class = "inputFieldLabel"><b>Nombre del proyecto:</b></span><br/>
				<span class="cleanable" id="nombreProyecto"></span><br/><br/>
				
				<span class = "inputFieldLabel"><b>Coordinador del proyecto:</b></span><br/>
				<span class="cleanable" id="coordinadorProyecto"></span><br/><br/>

				<span class = "inputFieldLabel"><b>Fecha de inicio:</b></span><br/>
				<span class="cleanable" id="fechaInicio"></span><br/><br/>
				
				<span class = "inputFieldLabel"><b>Fecha de finalizaci&oacute;n:</b></span><br/>
				<span class="cleanable" id="fechaFin"></span><br/><br/>
				
				<span class = "inputFieldLabel"><b>Fase del proyecto:</b></span><br/>
				<span class="cleanable" id="fase"></span><br/><br/>
				
				<span class = "inputFieldLabel"><b>Descripci&oacute;n:</b></span><br/>
				<textArea readonly="readonly" id="txtSolicitudDesc" cols=20 rows=6 class = "inputFieldTA"></textArea><br>

			</div>

		</div>
			<div id="aboutScreen" style="display: none">
				<img src="<?php echo base_url(); ?>application/views/css/img/aboutScreen.png" />		
		</div>	

	</body>
</html>