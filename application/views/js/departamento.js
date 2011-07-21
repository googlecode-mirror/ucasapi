

$(document).ready(function(){
	 js_ini();	 
	 departmentAutocomplete();		
});	

function departmentAutocomplete(){
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
	formData += "idDepto=" + $("#idDepto").val();
	formData += "&nombreDepto=" + $("#txtDepartmentName").val();
	formData += "&descripcion=" + $("#txtDepartmentDesc").val();
	
	$.ajax({				
        type: "POST",
        url:  "index.php/departamento/departmentValidateAndSave",
        data: formData,
        dataType : "json",
        success: function(retrievedData){
        	if(retrievedData.status != 0){
        		msgBoxInfo(retrievedData.msg);
        		//alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se est� mostrando es t�cnico, para cuestiones de depuraci�n
        	}
        	else{
        		if($("#idDepto").val()==""){
        			msgBoxSucces("<p>Registro agregado con �xito</p>");
        			//alert();
        		}
        		else{
        			msgBoxSucces("<p>Registro actualizado con �xito</p>");
        			//alert("Registro actualizado con �xito");
        		}
        		departmentAutocomplete();
        		clear();
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
        	if(retrievedData.status != 0){
        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se est� mostrando es t�cnico, para cuestiones de depuraci�n
        	}else{
        		$("#txtDepartmentName").val(retrievedData.data.nombreDepto);
			    $("#txtDepartmentDesc").val(retrievedData.data.descripcion);
        	}			       
      	}      
	});
	
}

function deleteData(){
	var formData = "idDepto=" + $("#idDepto").val();
	
	var answer = confirm("Est� seguro que quiere eliminar el registro: "+ $("#txtRecords").val()+ " ?");
	
	if (answer){		
		$.ajax({				
	        type: "POST",
	        url:  "index.php/departamento/departmentDelete",
	        data: formData,
	        dataType : "json",
	        success: function(retrievedData){
	        	if(retrievedData.status != 0){
	        		msgBoxInfo(retrievedData.msg);
	        		//alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se est� mostrando es t�cnico, para cuestiones de depuraci�n
	        	}
	        	else{
	        		msgBoxSucces("<p>Registro eliminado con �xito</p>");
	        		//alert("Registro eliminado con �xito");
	        		departmentAutocomplete();
	        		clear();
	        	}
	      	}
	      
		});		
	}	
}

function cancel(){
	//$("#btnCancel").toggleClass('ui-state-active');
	clear();
}

function clear(){
	$(".inputField").val("");
	$(".hiddenId").val("");
	$("#txtRecords").val("");
	$("#msgBox").hide();
}
