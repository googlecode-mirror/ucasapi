<html>
	<head>
		<title>Test</title>		
		<link type="text/css" href="<?php echo base_url(); ?>application/css/humanity/jquery-ui-1.8.14.custom.css" rel="stylesheet" />	
		<script type="text/javascript" src="<?php echo base_url(); ?>application/js/jquery-1.5.1.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>application/js/jquery-ui-1.8.14.custom.min.js"></script>
		
	</head>
	
	<body>
	
		<div id="divCRUD" class="CRUD_Pane">	
			
			<div id="divCRUDRecords">
				<span class = "recordsLabel">Departamentos</span>
				<input id="txtRecords" type="text"  value=""/><br>
			</div>			
			<div id="divCRUDButtons">
				<input id = "btnSave" type="button" value="Guardar" onClick="save()"/><br>
				<input id = "btnEdit" type="button" value="Editar" onClick="edit()"/><br>
				<input id = "btnDelete" type="button" value="Eliminar" onClick="deleteData()"/><br>
				<input id = "btnCancel" type="button" value="Cancelar" onClick="cancel()"/><br>
			</div>
			
			<div id="divDataForm" class="DataForm" style>
				<input id="idDepto" type="hidden"  value="" class = "hiddenId"/><br>
			
				<span class = "inputFieldLabel">Nombre</span>
				<input id="txtDepartmentName" type="text"  value="" class = "inputField"/><br>
				
				<span class = "inputFieldLabel">Descripción</span>
				<textArea id="txtDepartmentDesc" cols=20 rows=6 class = "inputField"></textArea>
			</div>
		
		</div>
	
		
	</body>

	<!-- Javascript Code -->
	
	<script type="text/javascript">	
	
		$(document).ready(function(){
			departmentAutocomplete();		
		});	

		function departmentAutocomplete(){
			$.ajax({				
		        type: "POST",
		        url:  "index.php/departamento/departmentAutocompleteRead",
		        data: "",
		        dataType : "json",
		        success: function(dat){
		        	$( "#txtRecords" ).autocomplete({
		        		minChars: 0,  
				        source: dat,
				        minLength: 1,
				        select: function( event, ui) {
					        $("#idDepto").val(ui.item.id);					
						}
					});
		      }
		      
			});			
		}


		function save(){			
			var formData= "";
			formData += "idDepto=" + $("#idDepto").val();
			formData += "&nombreDepto=" + $("#txtDepartmentName").val();
			formData += "&descripcion=" + $("#txtDepartmentDesc").val();		
			
			$.ajax({				
		        type: "POST",
		        url:  "index.php/departamento/departmentValidateAndSave",
		        data: formData,
		        dataType : "json",
		        success: function(retrievedData){
					        switch(retrievedData.status){
					        	case 0 : alert("Mensaje de error: "+ retrievedData.msg);
					        			 break;
					        	case 1 : alert("Mensaje de éxito: "+ retrievedData.msg);
			        			 		 break;
			        			case 2 : alert("Mensaje de información: "+ retrievedData.msg);
		   			 		 			 break;			        
					        }
		      	}
		      
			});
			
		}

		function edit(){			
			var formData = "idDepto=" + $("#idDepto").val();	
			
			$.ajax({				
		        type: "POST",
		        url:  "index.php/departamento/departmentRead",
		        data: formData,
		        dataType : "json",
		        success: function(retrievedData){
					       $("#txtDepartmentName").val(retrievedData.nombreDepto);
					       $("#txtDepartmentDesc").val(retrievedData.descripcion);
		      	}
		      
			});
			
		}

		function deleteData(){		
			alert("Pendiente....");	
			/*var formData = "idDepto=" + $("#idDepto").val();	
			
			$.ajax({				
		        type: "POST",
		        url:  "index.php/departamento/departmentDelete",
		        data: formData,
		        dataType : "json",
		        success: function(retrievedData){
					       $("#txtDepartmentName").val(retrievedData.nombreDepto);
					       $("#txtDepartmentDesc").val(retrievedData.descripcion);
		      	}
		      
			});*/
			
		}

		function cancel(){
			clear();
		}

		function clear(){
			$(".inputField").val("");
			$(".hiddenId").val("");
			$("#txtRecords").val("");
		}

		

	</script>
	
</html>