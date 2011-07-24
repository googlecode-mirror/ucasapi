
$(document).ready(function(){
	 js_ini();	 
	 departmentAutocomplete();		
});	

function empleadosAutocomplete(){
	$.ajax({				
        type: "POST",
        url:  "index.php/departamento/departmentAutocompleteRead",
        data: "departmentAutocomplete",
        dataType : "json",
        success: function(retrievedData){        	
        	if(retrievedData.status != 0){
        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se est� mostrando es t�cnico, para cuestiones de depuraci�n
        	}
        	else{        		
        		$("#txtRecords").autocomplete({
            		minChars: 0,
            		matchContains: true,
    		        source: retrievedData.data,
    		        minLength: 1,
    		        select: function(event, ui) {
    			        $("#idDepto").val(ui.item.id);					
    				}
    			});
        		
        	}        	
      }
      
	});		
}

function save(){			
	var formData= "";
	formData += "asunto=" + $("#txtSolicitudAsunto").val();
	formData += "&prioridad=" + $("#cbxPrioridades").val();
	formData += "&descripcion=" + $("#txtSolicitudDesc").val();
	
	$.ajax({				
        type: "POST",
        url:  "index.php/solicitud/solicitudSave",
        data: formData,
        dataType : "json",
        success: function(retrievedData){
        	if(retrievedData.status != 0){
        		msgBoxInfo(retrievedData.msg);
        		//alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se est� mostrando es t�cnico, para cuestiones de depuraci�n
        	}
        	else{
        		
        			msgBoxSucces("Solicitud creada con éxito");
        			//alert("Registro actualizado con �xito");
        		
        		clear();
        	}
      	}
      
	});
	
}

function clear(){
	$(".inputField").val("");
	$("#txtRecords").val("");
	$("cbxPrioridades").val(0);
}