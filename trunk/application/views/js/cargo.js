
$(document).ready(function(){
	cargoAutocomplete();		
});	

function cargoAutocomplete(){
	$.ajax({				
        type: "POST",
        url:  "index.php/cargo/cargoAutocompleteRead",
        data: "cargoAutocomplete",
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
    			        $("#idCargo").val(ui.item.id);					
    				}
    			});
        		
        	}        	
      }
      
	});		
}

function save(){			
	var formData= "";
	formData += "idCargo=" + $("#idCargo").val();
	formData += "&nombreCargo=" + $("#txtCargoName").val();	
	
	
	$.ajax({				
        type: "POST",
        url:  "index.php/cargo/cargoValidateAndSave",
        data: formData,
        dataType : "json",
        success: function(retrievedData){
        	if(retrievedData.status != 0){
        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
        	}
        	else{
        		if($("idCargo").val()==""){
        			alert("Registro agregado con éxito");
        		}
        		else{
        			alert("Registro actualizado con éxito");
        		}
        		cargoAutocomplete();
        		clear();
        	}
      	}
      
	});
	
}

function edit(){			
	var formData = "idCargo=" + $("#idCargo").val();	
	
	$.ajax({				
        type: "POST",
        url:  "index.php/cargo/cargoRead",
        data: formData,
        dataType : "json",
        success: function(retrievedData){
        	if(retrievedData.status != 0){
        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
        	}else{
        		$("#txtCargoName").val(retrievedData.data.nombreCargo);
        	}			       
      	}      
	});
	
}

function deleteData(){
	var formData = "idCargo=" + $("#idCargo").val();
	
	var answer = confirm("Está seguro que quiere eliminar el registro: "+ $("#txtRecords").val()+ " ?");
	
	if (answer){		
		$.ajax({				
	        type: "POST",
	        url:  "index.php/cargo/cargoDelete",
	        data: formData,
	        dataType : "json",
	        success: function(retrievedData){
	        	if(retrievedData.status != 0){
	        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
	        	}
	        	else{
	        		alert("Registro eliminado con éxito");
	        		cargoAutocomplete();
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
