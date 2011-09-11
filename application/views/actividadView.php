<html>
<head>
<title>Actividades</title>
 <meta http-equiv="X-UA-Compatible" content="IE=8" >		
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/horus/jquery-ui-1.8.14.custom.css" rel="stylesheet" />		
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/style.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/ui.jqgrid.css" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-1.5.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.bt.min.js"></script>	
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-ui-1.8.14.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/grid.locale-es.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.jqGrid.min.js"></script>		
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/validaciones.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.simplemodal.1.4.1.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/main.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/actividad.js"></script>

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

	<div>
		<span id="pageTittle"></span>
	</div>

	<div class="container" style="height: 750px; ">
		<div style="height: 20px"></div>


		<div id="title" align="center">
			<!--  <font face="calibri" color="green" size="6">Actividad</font>-->
		</div>
		<br>
		<div class="divActions">
			<div class="divCRUDButtons">
				<button id="btnSave" onClick="save()">Guardar</button>
				<button id="btnCancel" onClick="cancel()">Cancelar</button>
			</div>
		</div>
		
		
		<div id="msgBox"></div>
		
		<div id="tabs" style = "height: auto;">
				<ul>
					<li><a href="#tabs-1">Informaci&oacute;n General</a></li>
					<li><a href="#tabs-2">Transferir actividad</a></li>
				</ul>

				<div id="tabs-1" class="divDataForm" style="height: 500px">
					<input id="idEstado" type="hidden" value="" class="hiddenId" /><br> 
					<input id="idActividad" type="hidden" value="<?php echo $idActividad; ?>" class="hiddenId" /> 
					<input id="idProyecto" type="hidden" value="<?php echo $idProyecto; ?>" class="hiddenId" /> 
					<input id="idUsuario" type="hidden" value="<?php echo $idUsuario; ?>" class="hiddenId" /> <br> 
		
					<span class="inputFieldLabel">Proyecto: </span> 
						<input id="txtProyectoName" type="text" readonly="readonly" value="" class="inputField" title="Proyecto al que pertenece la actividad"/><br>
					<span class="inputFieldLabel">Proceso:</span>
						<input id="txtProcesoName" type="text" readonly="readonly" value="" class="inputField" title="Proceso al que pertenece la actividad"/><br> 
					<span class="inputFieldLabel">Actividad: </span>
						<input id="txtActividadName" type="text" readonly="readonly" class="inputField" title="Nombre de la actividad"></input> 
					<span class="inputFieldLabel">Asignada por: </span> 
						<input id="txtAsignada" type="text" readonly="readonly" class="inputField" title="Persona que le asigno la actividad"></input> 
					<span class="inputFieldLabel">Estado: </span>
					<select id="cbEstado" title="Estado de la actividad"></select><br>
					<span class="inputFieldLabel">Progreso:
					</span> <select id="cbProgreso" title="Progreso de la actividad"><br>
						<option value="0">--Progreso--</option>
						<option value="10">10</option>
						<option value="20">20</option>
						<option value="30">30</option>
						<option value="40">40</option>
						<option value="50">50</option>
						<option value="60">60</option>
						<option value="70">70</option>
						<option value="80">80</option>
						<option value="90">90</option>
						<option value="100">100</option>
					</select>
					<!--  <input id="txtProgreso" type="text" class = "inputField"></input> -->
		
					<span class="inputFieldLabel">Comentarios: </span> 
						<textArea id="txtComentarios" class = "inputFieldTA" cols="20" rows="3" title="Comentarios sobre lo que se hizo" style="margin-bottom: -1px"></textArea><br>
					<span class="inputFieldLabel"  style="clear:both">Descripcion: </span>
						<textArea id="txtDescripcion" class = "inputFieldTA" readonly="readonly"  cols="20" rows="4" title="Descripcion de la actividad"></textArea>
					<br><br>
				</div>
				
				<div id="tabs-2" class="divDataForm" style="height: 500px">
					<table align="center" style="margin-top:30px">
							<tr >
								<td>
									<table id="todosUsuarios" align="center"><tr><td/></tr></table>
									<div id="pager"></div>
								</td>
								<td  class="divLessOrMoreThan">
									<button id="btnMoreThan" onClick="asignar()"></button><br>
									<button id="btnLessThan" onClick="desasignar()"></button>
								</td>	
								<td>
									<table id="list" align="center"><tr><td/></tr></table>
									<div id="pagerTR"></div>
								</td>
							</tr>			
						</table>
				</div>
				
			</div>
		</div>
			<div id="aboutScreen" style="display: none">
				<img src="<?php echo base_url(); ?>application/views/css/img/aboutScreen.png" />		
		</div>	

</body>

</html>


