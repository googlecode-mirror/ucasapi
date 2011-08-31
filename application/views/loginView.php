<html>
	<head>
		<title>PHOBOS - Inicio de sesión</title>
		 <meta http-equiv="X-UA-Compatible" content="IE=8" >		
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/horus/jquery-ui-1.8.14.custom.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/style.css" rel="stylesheet" />	
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-1.5.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-ui-1.8.14.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.bt.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/main.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.simplemodal.1.4.1.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/login.js"></script>
		
	</head>
	
	<body>
		<div class="menuBar">		
		</div>
		
		<div id="loading" style="display:none; text-align:center">
			<span style = "color:white">Obteniendo datos ...</span>
			<div style="clear:both"></div>
			<img  src="<?php echo base_url(); ?>application/views/css/img/loading.gif"/>
		</div>
		
		<div class="sessionBar">
			<span id="sessionUser"></span>
		</div>
		
		<div><span id="pageTittle"></span></div>
		<div class="container">
			<div style="height: 20px"></div>
			
			<div class="divLogin">		
				<input id="idRol" type="hidden"  value="" class = "hiddenID"/><br>
				<span class = "inputFieldLabelL">Usuario</span>
				<input id="txtUsername" type="text"  value="" class = "inputFieldL"/><br>
				
				<span class = "inputFieldLabelL">Contrase&nacute;a</span>
				<input id="txtPassword" type="password"  value="" class = "inputFieldLPSW"/><br>
							
				<div id="sessionMsg"></div>
				
				<div class = "loginButtons">				
					<input id = "btnLogin" type="button" value="Iniciar sesión" onClick="userLogin()"/>
					<input id = "btnCancel" type="button" value="Cancelar" onClick="cancel()"/>
				</div>
			</div>
			
		</div>
		
		<div id="roleSelection" style="display:none">
			<span class = "inputFieldLabelL">Rol</span>
			<input id="txtRol" type="text"  value="" class = "inputFieldLAC"/><br>
		</div>
	
		
	</body>
</html>