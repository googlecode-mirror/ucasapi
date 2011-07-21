<html>
	<head>
		<title>Test</title>		
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/humanity/jquery-ui-1.8.14.custom.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/style.css" rel="stylesheet" />	
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/jquery-1.5.1.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/jquery-ui-1.8.14.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/login.js"></script>
		
	</head>
	
	<body>
		<div class="menuBar">		
		</div>
		
		<div class="sessionBar">
			<span id="sessionUser"></span>
		</div>
		
		<div><span id="pageTittle"></span></div>
		<div class="container">
			<div style="height: 20px"></div>
			
			<div class="divLogin">		
				<span class = "inputFieldLabel">Nombre de usuario</span>
				<input id="txtUsername" type="text"  value="" class = "inputField"/><br>
				
				<span class = "inputFieldLabel">Contraseña</span>
				<input id="txtPassword" type="password"  value="" class = "inputField"/><br>
				
				<span id="invalidUser">Nombre de usuario y/o contraseña incorrectos!!</span><br>
				
				<div class = "loginButtons">				
					<input id = "btnLogin" type="button" value="Iniciar sesión" onClick="userLogin()"/>
					<input id = "btnCancel" type="button" value="Cancelar" onClick="cancel()"/>
				</div>
			</div>
			
		</div>
	
		
	</body>
</html>