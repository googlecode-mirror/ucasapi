<html>
	<head>
		<title>Test</title>	
		<?php 
			require_once("application/models/menuBarModel.php");
			//echo "menuBarModel.php";
			//$menuBarModel = new menuBarModel();
			//$menuBarModel->showMenu();		
		?>			
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/humanity/jquery-ui-1.8.14.custom.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/style.css" rel="stylesheet" />	
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-1.5.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-ui-1.8.14.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/main.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/solicitud.js"></script>

		<style type="text/css">
			.divDataForm select{
				height : 20px;
				float:right;
				width : 256px;
				margin-top : 20px;
				margin-right : 96px;
				font-family: Lucida Grande, Lucida Sans, Arial;
				font-size: 1em;	
			}
			
			.divActions select{
				float:right;
				width : 256px;
				margin-top : 20px;
				margin-right : 96px;
				font-family: Lucida Grande, Lucida Sans, Arial;
				font-size: 1em;	
			}
		</style>
		
	</head>
	
	<body>
	
		<div class="menuBar">
			<ul>
				<li><span class="menu_button_to"><a href="http://www.google.com"><span class="menu_button_text">Dinamic</span></a></span></li>
				<li class="highlight"><span class="menu_button_to"><a href="http://www.google.com"><span class="menu_button_text">Dinamic</span></a></span></li>
				<li><span class="menu_button_to"><a href="http://www.google.com"><span class="menu_button_text">Dinamic</span></a></span></li>
				<li><span class="menu_button_to"><a href="http://www.google.com"><span class="menu_button_text">Dinamic</span></a></span></li>
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
				
				<table id="list"><tr><td/></tr></table> 
				<div id="pager"></div>
			</div>
			
		</div>
		
	</body>
</html>