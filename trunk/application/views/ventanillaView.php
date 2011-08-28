<html>
	<head>
		<title>Solicitudes entrantes</title>
		 <meta http-equiv="X-UA-Compatible" content="IE=8" >		
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/horus/jquery-ui-1.8.14.custom.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/ui.jqgrid.css" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/style.css" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-1.5.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery-ui-1.8.14.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/grid.locale-es.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.jqGrid.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.bt.min.js"></script>
		
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/validaciones.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/libraries/jquery.simplemodal.1.4.1.min.js"></script>
		
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/main.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/ventanilla.js"></script>

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

		<div><span id="pageTittle"></span></div>

		<div class="container">
			<div style="height: 20px"></div>

			<div  align="center">
				<table id="listPeticion"><tr><td/></tr></table>
				<div id="pager"></div>
			</div>			

			<div align="center" id="dialogoSolicitud" style="visibility: hidden;">
				<span class = "inputFieldLabel"><b>Ingresada el:</b></span><br/>
				<span class="cleanable" id="fecha"></span><br/><br/>

				<span class = "inputFieldLabel"><b>Por:</b></span><br/>
				<span class="cleanable" id="cliente"></span><br/><br/>

				<span class = "inputFieldLabel"><b>T&iacute;tulo:</b></span><br/>
				<span class="cleanable" id="tituloSolicitud"></span><br/><br/>

				<span class = "inputFieldLabel"><b>Prioridad:</b></span><br/>
				<span class="cleanable" id="prioridad"></span><br/><br/>

				<span class = "inputFieldLabel"><b>Descripci&oacute;n:</b></span><br/>
				<textArea readonly="readonly" id="txtSolicitudDesc" cols=20 rows=6 class = "inputFieldTA"></textArea><br>
				<br><br>

				<span class = "inputFieldLabel"><b>Otros interesados:</b></span><br/>
				<span class="cleanable" id="interesados"></span><br><br><br>

				<input type="hidden" value="" id="idSolicitud"/>
				<button id="btnSave" onClick="cargarDialogoAsignacion()">Asignar esta solicitud</button>
				<button id="btnUpload" onClick="definirDestinatario()">Transferir la solicitud</button>
			</div>

			<div align="center" id="dialogoTransferir" style="visibility: hidden;">
				<input type="hidden" value="" id="idUsuario"/>
				<span class = "inputFieldLabel"><b>Destinatario:</b></span><br/>
				<input id="txtRecords" type="text" disabled="disabled"  value="" class="inputFiledAC" /><br/><br/>
				<button id="btnUpload" onClick="transferirSolicitud()">Transferir</button>
			</div>

			<div align="center" id="dialogoAsignar" style="visibility: hidden;" class="divDataForm">
			<div id ="msgBox" style="width:500px"></div>
				<span class = "requiredFieldLabel" style="margin-left:56px">Nombre</span>
				<input id="txtActivityName" type="text"  value="" class = "inputField"  maxlength="40"/><br/><br/>

				<span class = "requiredFieldLabel" style="margin-left:56px">Proyecto principal</span>
				<input id="txtProjectName" type="text"  value="" class = "inputField"  maxlength="100"/><br/>
				
				<span class="inputFieldLabel" style="margin-left:56px">Proyectos secundarios</span>
				<input id="txtProjectRecords" type="text"  value="" class="inputField" /><br/>
				
				
				<span class="inputFieldLabel" style="margin-left:56px">Agregados: </span>
				<select style = "float:right; width:256px; margin-right:96px; margin-top:20px" size="5" multiple="multiple" id="cbxRelacionados"></select><br>
				<!-- <span class = "inputFieldLabel" >Proceso</span><br/> -->
				<!-- <input id="txtProcessName" type="text"  value="" class = "inputField" title="Proceso al que la actividad est&aacute; asociada" maxlength="40"/><br/><br/> -->

				<div style="clear:both"></div>
				
				<div align="center" style="margin-top:20px">
					<button id="btnRemoveProject" onClick="asignarSolicitud()" >Quitar</button>
				</div>
				
	
				<span class = "requiredFieldLabel" style="margin-left:56px">Responsable</span>
				<input id="txtResponsibleName" type="text"  value="" class = "inputField"  maxlength="40"/><br/>

				<span class = "requiredFieldLabel" style="margin-left:56px">Prioridad</span>
				<input id="txtPriorityName" type="text"  value="" class = "inputField"  maxlength="40"/><br/>

				<span class = "requiredFieldLabel" style="margin-left:56px">Estado</span>
				<input id="txtStatusName" type="text"  value="" class = "inputField"  maxlength="40"/><br/>

				<span class = "inputFieldLabel" style="margin-left:56px">Planificaci&oacute;n</span>
				<div class="divDateCombo">
				
					<span>Inicio</span>
					<input id="txtStartingDate" type="text"  value=""   readonly/><br/>
					<span>Fin</span>
					<input id="txtEndingDate" type="text"  value=""   readonly/><br/>
				</div><br/><br/>

				<span class = "requiredFieldLabel" style = "clear:both; margin-left:56px">Descripci&oacute;n</span>
				<textArea id="txtActivityDesc" cols=20 rows=6 class = "inputFieldTA" ></textArea>

				<input id="idProyecto" type="hidden"  value="" class = "hiddenId"/>
				<input id="idProceso" type="hidden"  value="" class = "hiddenId"/>
				<input id="idActividad" type="hidden"  value="" class = "hiddenId"/>
				<input id="idUsuarioResponsable" type="hidden"  value="" class = "hiddenId"/>
				<input id="idEstado" type="hidden"  value="" class = "hiddenId"/>
				<input id="idPrioridad" type="hidden"  value="" class = "hiddenId"/>
				<input id="idUsuarioAsigna" style="display:none"  value=<?php echo $idUsuario;?> class = "hiddenId"/>
				<br/><br/>
				<div style="clear:both"></div>
				<button id="btnAsign" onClick="asignarSolicitud()">Asignar</button>
			</div>

			<!--
			<div id="dialogoAsignar"></div>
			 -->



		</div>

	</body>
</html>