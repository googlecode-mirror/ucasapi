
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
	
	if(validar_campos()){
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
	        			msgBoxSucces("Registro agregado con �xito");
	        		}
	        		else{
	        			msgBoxSucces("Registro actualizado con �xito");
	        		}
	        		rolAutocomplete();
	        		clear();
	        	}
	      	}
	      
		});
	}
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
        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se est� mostrando es t�cnico, para cuestiones de depuraci�n
        	}else{
        		$("#txtRolName").val(retrievedData.data.nombreRol);
        	}			       
      	}      
	});
	
}

function deleteData(){
	var formData = "idRol=" + $("#idRol").val();
	
	var answer = confirm("Est� seguro que quiere eliminar el registro: "+ $("#txtRecords").val()+ " ?");
	
	if (answer){		
		$.ajax({				
	        type: "POST",
	        url:  "index.php/rol/rolDelete",
	        data: formData,
	        dataType : "json",
	        success: function(retrievedData){
	        	if(retrievedData.status != 0){
	        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se est� mostrando es t�cnico, para cuestiones de depuraci�n
	        	}
	        	else{
	        		alert("Registro eliminado con �xito");
	        		rolAutocomplete();
	        		clear();
	        	}
	      	}
	      
		});		
	}	
}


function validar_campos(){
	var camposFallan = "";
	
	if($("#txtRolName").val()!=""){
		if(!validarAlfa($("#txtRolName").val())){
			camposFallan += "Formato de NOMBRE ROL es incorrecto <br />";
		}
	}else{
		camposFallan += "El campo NOMBRE ROL es requerido <br />";
	}
	
	if(camposFallan == ""){
		return true;
	}else{
		msgBoxInfo(camposFallan);
		return false;
	}
	return true;
}
function cancel(){
	clear();
}


function cancel(){
	clear();
}

function clear(){
	$(".inputField").val("");
	$(".hiddenId").val("");
	$("#txtRecords").val("");
}
