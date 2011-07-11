<html>
	<head>
		<title>Test</title>		
		<link type="text/css" href="<?php echo base_url(); ?>application/views/css/humanity/jquery-ui-1.8.14.custom.css" rel="stylesheet" />	
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/jquery-1.5.1.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/jquery-ui-1.8.14.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/proceso.js"></script>
		
	</head>
	
	<body>
	
		<div id="divActions" class="ActionPane">	
			
			<div id="divCRUDRecords">
				<span class = "recordsLabel">Proceso</span>
				<input id="txtRecords" type="text"  value=""/><br>
			</div>			
			<div id="divCRUDButtons">
				<input id = "btnSave" type="button" value="Guardar" onClick="save()"/><br>
				<input id = "btnEdit" type="button" value="Editar" onClick="edit()"/><br>
				<input id = "btnDelete" type="button" value="Eliminar" onClick="deleteData()"/><br>
				<input id = "btnCancel" type="button" value="Cancelar" onClick="cancel()"/><br>
			</div>
			
			<div id="divDataForm" class="DataForm" style>
				<input id="idProceso" type="hidden"  value="" class = "hiddenId"/><br>
				<input id="idProyecto" type="hidden"  value="" class = "hiddenId"/><br>
				<input id="idFase" type="hidden"  value="" class = "hiddenId"/><br>
				<input id="idEstado" type="hidden"  value="" class = "hiddenId"/><br>
				
				<span class = "inputFieldLabel">Nombre del proceso:</span>
				<input id="txtProcesoName" type="text"  value="" class = "inputField"/><br>		
			
				<span class = "inputFieldLabel">Descripción:</span>
				<textArea id="txtProcesoDesc" cols=20 rows=6 class = "inputField"></textArea><br>				
				
				<span class = "inputFieldLabel">Proyecto (opcional)</span>
				<input id="txtProyectoName" type="text"  value="" class = "inputField"/><br>
				
				<span class = "inputFieldLabel">Fase</span>
				<input id="txtFaseName" type="text"  value="" class = "inputField"/><br>
				
				<span class = "inputFieldLabel">Estado</span>
				<input id="txtEstadoName" type="text"  value="" class = "inputField"/><br>	
			</div>		
		
		</div>
	
		
	</body>
</html>