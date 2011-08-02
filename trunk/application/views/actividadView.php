<html>
<head>
<title>Actividades</title>
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/humanity/jquery-ui-1.8.14.custom.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/ui.jqgrid.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/style.css" rel="stylesheet" />	
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-1.5.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-ui-1.8.14.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/grid.locale-es.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.jqGrid.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/main.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/actividad.js"></script>

</head>

<body>
	<div class="menuBar">
		<ul>
			<li><span class="menu_button_to"><a href="http://www.google.com"><span
						class="menu_button_text">Dinamic</span>
				</a>
			</span>
			</li>
			<li class="highlight"><span class="menu_button_to"><a
					href="http://www.google.com"><span class="menu_button_text">Dinamic</span>
				</a>
			</span>
			</li>
			<li><span class="menu_button_to"><a href="http://www.google.com"><span
						class="menu_button_text">Dinamic</span>
				</a>
			</span>
			</li>
			<li><span class="menu_button_to"><a href="http://www.google.com"><span
						class="menu_button_text">Dinamic</span>
				</a>
			</span>
			</li>
		</ul>
	</div>

	<div class="sessionBar">
		<span id="sessionUser"></span>
	</div>

	<div>
		<span id="pageTittle"></span>
	</div>

	<div class="container" style="height: 870; width: 1100">
		<div style="height: 20px"></div>


		<div id="title" align="center">
			<font face="calibri" color="green" size="6">Actividad</font>
		</div>
		<br>
		<div id="msgBox"></div>

		<div class="divDataForm" style="height: 500">
			<input id="idEstado" type="hidden" value="" class="hiddenId" /><br> <input
				id="idActividad" type="hidden" value="1" class="hiddenId" /> <input
				id="idProyecto" type="hidden" value="1" class="hiddenId" /> <input
				id="idUsuario" type="hidden" value="1" class="hiddenId" /> <br> <font
				face="calibri" color="green" size="4">Informacion General</font> <br>

			<span class="inputFieldLabel">Proyecto: </span> <input
				id="txtProyectoName" type="text" readonly="readonly" value=""
				class="inputField" /><br> <span class="inputFieldLabel">Actividad: </span>
			<input id="txtActividadName" type="text" readonly="readonly"
				class="inputField"></input> <span class="inputFieldLabel">Asignada
				por: </span> <input id="txtAsignada" type="text" readonly="readonly"
				class="inputField"></input> <span class="inputFieldLabel">Estado: </span>
			<select id="cbEstado"></select> <span class="inputFieldLabel">Progreso:
			</span> <select id="cbProgreso">
				<option value="">--Progreso--</option>
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

			<span class="inputFieldLabel">Comentarios: </span> <input
				id="txtComentarios" type="text" class="inputField"></input> <span
				class="inputFieldLabel">Descripcion: </span>
			<textArea id="txtDescripcion" readonly="readonly" cols="20" rows="4"
				class="inputField"></textArea>

		</div>
		<p align="center"><font size="4"><span class="inputFieldLabel">Transferir actividad a usuario: </span></font></p>
		<table>
				<tr>
					<td>
						<table id="todosUsuarios" align="center"><tr><td/></tr></table>
						<div id="pager"></div>
					</td>
					<td align="center">
						<button id="btnAsignar" onClick="asignar()">Asignar</button>
						<button id="btnDesasignar" onClick="desasignar()">Desasignar</button>
					</td>	
					<td>
						<table id="list" align="center"><tr><td/></tr></table>
						<div id="pagerTR"></div>
					</td>				
		</table>
		<br><br>
		<div class="divActions">
			<div class="divCRUDButtons">
				<button id="btnSave" onClick="save()">Guardar</button>
				<button id="btnCancel" onClick="cancel()">Cancelar</button>
			</div>

		</div>

	</div>

</body>

</html>


