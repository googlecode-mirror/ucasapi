
$(document).ready(function(){
	statusAutocomplete();
	statusTypeAutocomplete();
});	

function statusAutocomplete(){
	$.ajax({				
        type: "POST",
        url:  "index.php/estado/statusAutocompleteRead",
        data: "statusAutocomplete",
        dataType : "json",
        success: function(retrievedData){        	
        	if(retrievedData.status != 0){
        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
        	}
        	else{        		
        		$("#txtRecords").autocomplete({
            		minChars: 0,  
    		        source: retrievedData.data,
    		        minLength: 1,
    		        select: function(event, ui) {
    			        $("#idEstado").val(ui.item.id);					
    				}
    			});
        		
        	}        	
      }
      
	});		
}

function statusTypeAutocomplete(){
	$.ajax({				
        type: "POST",
        url:  "index.php/estado/statusTypeAutocompleteRead",
        data: "statusTypeAutocomplete",
        dataType : "json",
        success: function(retrievedData){        	
        	if(retrievedData.status != 0){
        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
        	}
        	else{        		
        		$("#txtStatusTypeName").autocomplete({
            		minChars: 0,  
    		        source: retrievedData.data,
    		        minLength: 1,
    		        select: function(event, ui) {
    			        $("#idTipoEstado").val(ui.item.id);
    				}
    			});
        		
        	}        	
      }
      
	});		
}

function save(){			
	var formData= "";
	formData += "idEstado=" + $("#idEstado").val();
	formData += "&idTipoEstado=" + $("#idTipoEstado").val();
	formData += "&estado=" + $("#txtStatusName").val();
		
	$.ajax({				
        type: "POST",
        url:  "index.php/estado/statusValidateAndSave",
        data: formData,
        dataType : "json",
        success: function(retrievedData){
        	if(retrievedData.status != 0){
        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
        	}
        	else{
        		if($("idEstado").val()==""){
        			alert("Registro agregado con éxito");
        		}
        		else{
        			alert("Registro actualizado con éxito");
        		}
        		statusAutocomplete();
        		statusTypeAutocomplete();
        		clear();
        	}
      	}
      
	});
	
}

function edit(){			
	var formData = "idEstado=" + $("#idEstado").val();	
	
	$.ajax({				
        type: "POST",
        url:  "index.php/estado/statusRead",
        data: formData,
        dataType : "json",
        success: function(retrievedData){
        	if(retrievedData.status != 0){
        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
        	}else{
        		$("#txtStatusName").val(retrievedData.data.estado);
        		$("#txtStatusTypeName").val(retrievedData.data.nombreTipoEstado);
			    $("#idTipoEstado").val(retrievedData.data.idTipoEstado);
        	}			       
      	}      
	});
	
}

function deleteData(){
	var formData = "idEstado=" + $("#idEstado").val();
	
	var answer = confirm("Está seguro que quiere eliminar el registro: "+ $("#txtRecords").val()+ " ?");
	
	if (answer){		
		$.ajax({				
	        type: "POST",
	        url:  "index.php/estado/statusDelete",
	        data: formData,
	        dataType : "json",
	        success: function(retrievedData){
	        	if(retrievedData.status != 0){
	        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
	        	}
	        	else{
	        		alert("Registro eliminado con éxito");
	        		statusAutocomplete();
	        		clear();
	        	}
	      	}
	      
		});		
	}	
}

function cancel(){
	clear();
}

function clear(){
	$(".inputField").val("");
	$(".hiddenId").val("");
	$("#txtRecords").val("");
}
