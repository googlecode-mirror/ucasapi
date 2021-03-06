<html>
	<head>
		<title>PHOBOS - Actividades</title>
		 <meta http-equiv="X-UA-Compatible" content="IE=8" >
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/horus/jquery-ui-1.8.14.custom.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/style.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/ui.jqgrid.css" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-1.5.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-ui-1.8.14.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/grid.locale-es.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.jqGrid.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/ajaxupload.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.bt.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.simplemodal.1.4.1.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/dateUtils.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/validaciones.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/main.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/actividada.js"></script>
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
			<img id="logoutButton" title="Cerrar sesi�n" src="<?php echo base_url(); ?>application/views/css/img/logout_button.png" />
			<span id="sessionUser"><?php echo  utf8_decode($userName."/".$roleName); ?></span>
		</div>

		<input id="filePath" type="hidden"  value="<?php echo $filePath;?>" class = "hiddenURL"/>
		<input id="idUsuarioAsigna" type="hidden"  value=<?php echo $idUsuario;?> class = "hiddenId"/>

		<div><span id="pageTittle"></span></div>

		<div class="container" style="height: 1200px">
			<div style="height: 20px"></div>

			<div class="divActions" style = "height: 210px">
				<div class="divCRUDRecords">
					<span class = "recordsLabel">Proyectos</span>
					<input id="txtProjectRecords" type="text"  value="" title = "B&uacute;squeda por proyectos" class = "inputFieldAC"/><br>

					<span class = "recordsLabel">Procesos</span>
					<input id="txtProcessRecords" type="text"  value="" title = "B&uacute;squeda por procesos" class = "inputFieldAC"/><br>

					<span class = "recordsLabel">Actividades</span>
					<input id="txtRecords" type="text"  value="" title = "Selecci&oacute;n de actividad" class = "inputFieldAC"/><br>
				</div>

				<div class="divCRUDButtons" style="margin-top: 110px">
					<button id="btnSave" onClick="save()">Guardar</button>
					<button id="btnEdit" onClick="edit()">Editar</button>
					<button id="btnDelete" onClick="deleteData()">Eliminar</button>
					<button id="btnCancel" onClick="cancel()">Cancelar</button>

				</div>
			</div>

			<div id ="msgBox"></div>


			<div id="tabs" style = "height: auto;">
				<ul>
					<li><a href="#tabs-1">Informaci&oacute;n General</a></li>
					<li><a href="#tabs-2">Proyectos relacionados</a></li>
					<li><a href="#tabs-3">Seguidores</a></li>
					<li id="tagBliblioteca"><a href="#tabs-4">Documentos</a></li>
				</ul>

				<div id="tabs-1" class="divDataForm" style= "height: auto">
					<input id="idProyecto" type="hidden"  value="" class = "hiddenId"/>
					<input id="idProceso" type="hidden"  value="" class = "hiddenId"/>
					<input id="idActividad" type="hidden"  value="" class = "hiddenId"/>
					<input id="idEstado" type="hidden"  value="" class = "hiddenId"/>
					<input id="idPrioridad" type="hidden"  value="" class = "hiddenId"/>
					<input id="idTipoArchivo" type="hidden"  value="" class = "hiddenId"/>
					<input id="accionActual" type="hidden"  value="" class = "hiddenId"/>
					<input id="anioSolicitud" type="hidden"  value="<?php echo $anioSolicitud; ?>" class = "hiddenId"/>
					<input id="correlAnio" type="hidden"  value="<?php echo $correlAnio; ?>" class = "hiddenId"/>
					<input id="triggerEdit" type="hidden"value="<?php echo $trigger?>" class="hiddenId" />

					<span class = "requiredFieldLabel" >Actividad:</span>
					<input id="txtActivityName" type="text"  value="" class = "inputField" title="Nombre de la actividad"/><br>

					<span class = "inputFieldLabel" >Proyecto:</span>
					<input id="txtProjectName" type="text"  value="" class = "inputFieldAC" title="Proyecto al que la actividad est&aacute; asociada"/><br>

					<span class = "inputFieldLabel" >Proceso:</span>
					<input id="txtProcessName" type="text"  value="" class = "inputFieldAC" title="Proceso al que la actividad est&aacute; asociada"/><br>

					<span class = "requiredFieldLabel" >Prioridad:</span>
					<input id="txtPriorityName" type="text"  value="" class = "inputFieldAC" title="Prioridad definida para la actividad"/><br>

					<span class = "requiredFieldLabel" >Estado:</span>
					<input id="txtStatusName" type="text"  value="" class = "inputFieldAC" title="Estado de la actividad"/><br>

					<span class = "inputFieldLabel" >Planificaci&oacute;n:</span>
					<div class="divDateCombo">
						<span>Inicio</span>
						<input id="txtStartingDate" type="text"  value=""  title="Fecha de inicio planificada de la actividad" readonly/><br>
						<span>Fin</span>
						<input id="txtEndingDate" type="text"  value=""  title="Fecha fin planificada de la actividad" readonly/><br>
					</div>

					<span class = "requiredFieldLabel" style = "clear:both">Descripci&oacute;n</span>
					<textArea id="txtActivityDesc" cols=20 rows=6 class = "inputFieldTA" title="Descripci&oacute;n de la actividad" ></textArea><br>

					<span style = "clear:both; margin-bottom:20px" class = "inputFieldLabel" >Responsables</span><br>
					<table align="center">
                    	<tr>
                        	<td>
                            	<table id="users1Grid" align="center"></table>
                                <div id="pagerU"></div>
                         	</td>
                            <td>
                            	<div class="divLessOrMoreThan">
                                	<button id="btnMoreThan" onClick="addResponsible()"></button><br />
                                    <button id="btnLessThan" onClick="removeResponsible()"></button>
                                 </div>
                            </td>
                            <td>
                            	<table id="responsibleUsersGrid" align="center"></table>
                                <div id="pagerAU"></div>
                            </td>
                      </tr>
                      </table>
				</div>
				<div id="tabs-2">
					<div class = "gridView" style = "width : 480px">
						<table id="projectsGrid"><tr><td/></tr></table>
						<div id="ppager"></div>
					</div>
					<div class="divAddButton">
						<button id="btnAddProject" onClick = "addProject()">Agregar</button>
					</div>

					<div class = "gridView" style = "width : 480px">
						<table id="relatedProjectsGrid"><tr><td/></tr></table>
						<div id="rpager"></div>
					</div>
						<div class="divAddButton">
						<button id="btnRemoveProject" onClick = "removeProject()">Quitar</button>
					</div>
				</div>


				<div id="tabs-3">
					<div class = "gridView" style = "width : 480px">
						<table id="usersGrid"><tr><td/></tr></table>
						<div id="uupager"></div>
					</div>
					<div class="divAddButton">
						<button id="btnAddUser" onClick = "addUser()">Agregar</button>
					</div>

					<div class = "gridView" style = "width : 480px">
						<table id="followersGrid"><tr><td/></tr></table>
						<div id="ffpager"></div>
					</div>
						<div class="divAddButton">
						<button id="btnRemoveUser" onClick = "removeUser()">Quitar</button>
					</div>
				</div>

				<div id="tabs-4" class="divDataForm" style="height: 600px">
					<div class="divUploadButton">
						<button id="btnUpload">Seleccionar archivo</button><p></p>
					</div>

					<span class = "requiredFieldLabel">T&iacute;tulo: </span>
					<input id="txtFileName" type="text"  value="" class = "inputField"/><br>

					<span class = "inputFieldLabel">Tipo: </span>
					<input id="txtFileType" type="text"  value="" class = "inputField"/><br>

					<span class = "inputFieldLabel">Descripci&oacute;n: </span>
					<textArea id="txtFileDesc" cols=20 rows=6 class = "inputFieldTA"></textArea>

					<div class="divAddButton">
						<button id="btnAddFile" onClick = "uploadFile()">Agregar</button>
						<button id="btnUpdateFile" onClick = "saveFileData('null')" style = "display : none">Actualizar</button>
						<button id="btnClearFileForm" onClick = "clearFileForm()">Limpiar</button>
					</div>
					<div class = "gridView" style = "width : 480px">
						<table id="gridDocuments"><tr><td/></tr></table>
						<div id="pager"></div>
					</div>
				</div>
			</div>
		</div>
		<div id="aboutScreen" style="display: none">
				<img src="<?php echo base_url(); ?>application/views/css/img/aboutScreen.png" />
		</div>
	</body>
</html>