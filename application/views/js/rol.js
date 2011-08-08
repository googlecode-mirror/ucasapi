
$(document).ready(function(){
	js_ini();	
	rolAutocomplete();		
});	

function rolAutocomplete(){
	$.ajax({				
        type: "POST",
        url:  "index.php/rol/rolAutocompleteRead",
        data: "rolAutocomplete",
        dataType : "json",
        success: function(retrievedData){        	
        	if(retrievedData.status != 0){
        		msgBoxSucces("Ocurrio un problema: " + retrievedData.msg);        		
        	}
        	else{        		
        		$("#txtRecords").autocomplete({
            		minChars: 0,  
    		        source: retrievedData.data,
    		        minLength: 1,
    		        select: function(event, ui) {
    			        $("#idRol").val(ui.item.id);					
    				}
    			});
        		
        	}        	
      }
      
	});		
}

function save(){			
	var formData= "";
	formData += "idRol=" + $("#idRol").val();	
	formData += "&nombreRol=" + $("#txtRolName").val();
	
	$.ajax({				
        type: "POST",
        url:  "index.php/rol/rolValidateAndSave",
        data: formData,
        dataType : "json",
        success: function(retrievedData){
        	if(retrievedData.status != 0){
        		msgBoxSucces("Ocurrio un problema: " + retrievedData.msg);
        	}
        	else{
        		if($("idRol").val()==""){
        			msgBoxSucces("Registro agregado con éxito");
        		}
        		else{
        			msgBoxSucces("Registro actualizado con éxito");
        		}
        		rolAutocomplete();
        		clear();
        	}
      	}
      
	});
	
}

function edit(){			
	var formData = "idRol=" + $("#idRol").val();	
	
	$.ajax({				
        type: "POST",
        url:  "index.php/rol/rolRead",
        data: formData,
        dataType : "json",
        success: function(retrievedData){
        	if(retrievedData.status != 0){
        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
        	}else{
        		$("#txtRolName").val(retrievedData.data.nombreRol);
        	}			       
      	}      
	});
	
}

function deleteData(){
	var formData = "idRol=" + $("#idRol").val();
	
	var answer = confirm("Está seguro que quiere eliminar el registro: "+ $("#txtRecords").val()+ " ?");
	
	if (answer){		
		$.ajax({				
	        type: "POST",
	        url:  "index.php/rol/rolDelete",
	        data: formData,
	        dataType : "json",
	        success: function(retrievedData){
	        	if(retrievedData.status != 0){
	        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
	        	}
	        	else{
	        		alert("Registro eliminado con éxito");
	        		rolAutocomplete();
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
