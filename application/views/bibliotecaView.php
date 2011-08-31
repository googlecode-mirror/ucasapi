<html>
	<head>	
		<title>PHOBOS - Biblioteca</title>	
		 <meta http-equiv="X-UA-Compatible" content="IE=8" >				
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/horus/jquery-ui-1.8.14.custom.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/ui.jqgrid.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/style.css" rel="stylesheet" />	
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-1.5.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-ui-1.8.14.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/grid.locale-es.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.jqGrid.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/ajaxupload.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.bt.min.js"></script>		
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.bt.min.js"></script>		
		
		
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/validaciones.js"></script>		
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.simplemodal.1.4.1.min.js"></script>
		
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/main.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/biblioteca.js"></script>		
		
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
			<span id="systemName"><b>PHOBOS PLANNING</b></span> 	
			<img id="logoutButton" title="Cerrar sesión" src="<?php echo base_url(); ?>application/views/css/img/logout_button.png" />
			<span id="sessionUser"><?php echo  utf8_decode($userName."/".$roleName); ?></span> 
		</div>
		<input id="filePath" type="hidden"  value="<?php echo $filePath;?>" class = "hiddenURL"/>
		<div id="titulo"><span id="pageTittle"></span></div>
		
			<div class="container" style="height: 900px">
				<div align = "center" style="margin-top:40px">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
						  <td>
						  	<div>
						  		<div id="projSearch"></div>
								<table id="projectsGrid"><tr><td/></tr></table> 
								<div id="projPager"></div>
							</div>
						  </td>
						  						  
						  <td>
						  	<div>
								<table id="processesGrid"><tr><td/></tr></table> 
								<div id="procPager"></div>
							</div>
						  
						  </td>						  
						  
						  <td>
						  	<div>
								<table id="activitiesGrid"><tr><td/></tr></table> 
								<div id="actPager"></div>
							</div>
						  </td>
						</tr>
					</table>
					<div style = "margin-top:20px">
					<button  id="btnClean" onClick = "cleanFilters()">Limpiar filtros</button>
					</div>
					
					
					<table cellspacing="0" cellpadding="0" border="0" style="margin-top:40px; margin-bottom:30px">
						<tr>
						  <td>
						  	<div>
								<table id="documentsGrid"><tr><td/></tr></table> 
								<div id="docPager"></div>
							</div>
						  </td>
						</tr>
					</table>	
					<div style="margin-top: 30px"></div>
					
									
				</div>		
			</div>
		<div>
			
		</div>
		<div>
			<table id="list"><tr><td/></tr></table> 
			<div id="pager"></div>
		</div>
		
	</body>
</html>