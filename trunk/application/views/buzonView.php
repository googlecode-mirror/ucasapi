<html>
	<head>
		<title>Test</title>		
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/humanity/jquery-ui-1.8.14.custom.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/style.css" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/jquery-1.5.1.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/jquery-ui-1.8.14.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/buzon.js"></script>
    	<link rel="stylesheet" type="text/css" media="screen" href="application/themes/ui.jqgrid.css" />
    	<link rel="stylesheet" type="text/css" media="screen" href="application/themes/ui.multiselect.css" /> 
		<script type="text/javascript" src="application/libraries/i18n/grid.locale-es.js"></script>
        <script type="text/javascript" src="application/libraries/jquery.jqGrid.min.js"></script>
		
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
			<span id="sessionUser"></span>
		</div>
		
		<div><span id="pageTittle"></span></div>
		
		<div class="container">
			<div style="height: 20px"></div>
			
			<div id ="msgBox"></div>	
				
			<div class="divDataForm">
				<?php include "application/grids/buzonGrid.php";?>
			</div>
			
			<div class="divActions">				
							
				<div class="divCRUDButtons">
					<button id="btnSave" onClick="read()">Ver Mensaje</button>
					<button id="btnCancel" onClick="cancel()">Cancelar</button>
				</div>
			</div>
			
		</div>
	
		
	</body>
</html>