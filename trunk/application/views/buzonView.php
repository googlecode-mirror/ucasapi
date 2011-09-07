<html>
<head>
<title>PHOBOS - Buzón</title>	
 <meta http-equiv="X-UA-Compatible" content="IE=8" >		
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/horus/jquery-ui-1.8.14.custom.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/ui.jqgrid.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/style.css" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-1.5.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.bt.min.js"></script>	
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-ui-1.8.14.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/grid.locale-es.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.jqGrid.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.bt.min.js"></script>	
		
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.simplemodal.1.4.1.min.js"></script>
		
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/main.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/buzon.js"></script>
		<style>
			.mybold td {font-weight : bold !important}
		</style>
</head>
<body>	
	<div class="menuBar">
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
		<img id="logoutButton" title="Cerrar sesión" src="<?php echo base_url(); ?>application/views/css/img/logout_button.png" />
		<span id="sessionUser"><?php echo  utf8_decode($userName."/".$roleName); ?></span> 
	</div>
	<div>
		<span id="pageTittle"></span>
	</div>

	<div class="container">
		<div style="height: 20px"></div>
		<div id="msgBox"></div>
		<input id="idUsuario" type="hidden" value=<?php echo $idUsuario;?> class="hiddenId" />
		
		<div align = "center">
			<table id="todosMensajes"></table>
			<div id="pager"></div>
			<br>
			<button id="btnCancel" onClick="deleteMessage()">Eliminar Mensaje</button>
		</div>
		<br>

	</div>

</body>
</html>
