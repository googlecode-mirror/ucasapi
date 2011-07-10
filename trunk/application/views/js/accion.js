
$(document).ready(function(){
	accionAutocomplete();		
});	

function accionAutocomplete(){
	$.ajax({				
        type: "POST",
        url:  "index.php/accion/accionAutocompleteRead",
        data: "accionAutocomplete",
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
    			        $("#idAccion").val(ui.item.id);					
    				}
    			});        		
        	}        	
      }      
	});		
}

function save(){			
	var formData= "";
	formData += "idAccion=" + $("#idAccion").val();
	formData += "&nombreAccion=" + $("#txtAccionName").val();	
	

	
	$.ajax({				
        type: "POST",
        url:  "index.php/accion/accionValidateAndSave",
        data: formData,
        dataType : "json",
        success: function(retrievedData){
        	if(retrievedData.status != 0){
        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
        	}
        	else{
        		if($("idAccion").val()==""){
        			alert("Registro agregado con éxito");
        		}
        		else{
        			alert("Registro actualizado con éxito");
        		}
        		accionAutocomplete();
        		clear();
        	}
      	}
      
	});
	
}

function edit(){			
	var formData = "idAccion=" + $("#idAccion").val();	
	
	$.ajax({				
        type: "POST",
        url:  "index.php/accion/accionRead",
        data: formData,
        dataType : "json",
        success: function(retrievedData){
        	if(retrievedData.status != 0){
        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
        	}else{
        		$("#txtAccionName").val(retrievedData.data.nombreAccion);
        	}			       
      	}      
	});
	
}

function deleteData(){
	var formData = "idAccion=" + $("#idAccion").val();
	
	var answer = confirm("Está seguro que quiere eliminar el registro: "+ $("#txtRecords").val()+ " ?");
	
	if (answer){		
		$.ajax({				
	        type: "POST",
	        url:  "index.php/accion/accionDelete",
	        data: formData,
	        dataType : "json",
	        success: function(retrievedData){
	        	if(retrievedData.status != 0){
	        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
	        	}
	        	else{
	        		alert("Registro eliminado con éxito");
	        		accionAutocomplete();
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
