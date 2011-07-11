/**
 * 
 */

$(document).ready(function(){
	faseAutocomplete();	
});

function faseAutocomplete(){
	$.ajax({
		type: "POST",
        url:  "index.php/fase/faseAutocompleteRead",
        data: "faseAutocomplete",
        dataType : "json",
        success: function(retrievedData){        	
        	if(retrievedData.status != 0){
        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se est� mostrando es t�cnico, para cuestiones de depuraci�n
        	}
        	else{        		
        		$("#txtSearch").autocomplete({
            		minChars: 0,  
    		        source: retrievedData.data,
    		        minLength: 1,
    		        select: function(event, ui) {
    			        $("#idFase").val(ui.item.id);					
    				}
    			});
        		
        	}        	
      }
		
	});
	
}

function save(){
	var formData = "";
	formData += "idFase=" + $("#idFase").val();
	formData += "&nombreFase=" + $("#txtFaseName").val();
	formData += "&descripcion=" + $("#txtFaseDesc").val();

	$.ajax({
		type: "POST",
		url: "index.php/fase/faseValidateAndSave",
		data: formData,
		dataType: "json",
		success: function(retrievedData){
			if(retrievedData.status != 0){
				alert("Mensaje de error: " + retrievedData.msg);
			}
			else{
				if($("#idFase").val() == ""){
					alert("Fase agregada con exito");
				}
				else{
					alert("Fase actualizada con exito");
				}
				faseAutocomplete();
				clear();
					
			}
		}
	
	});	
}

function deleteData(){
	var formData = "idFase=" + $("#idFase").val();
	
	$.ajax({
		type: "POST",
		url: "index.php/fase/faseDelete",
		data: formData,
		dataType: "json",
		success: function(retrievedData){
			if(retrievedData.status != 0){
				alert("Mensaje de error: " + retrievedData.msg);
			}
			else{
				alert("Fase eliminada con exito");
				faseAutocomplete();
				clear();
			}
		}
	});
	
}

function edit(){
	var formData = "idFase=" + $("#idFase").val();

	$.ajax({
		type: "POST",
		url: "index.php/fase/faseRead",
		data: formData,
		dataType: "json",
		success: function(retrievedData){
			if(retrievedData.status != 0){
				alert("Mensaje de error: " + retrievedData.msg);
			}
			else{
				$("#txtFaseName").val(retrievedData.data.nombreFase);
				$("#txtFaseDesc").val(retrievedData.data.descripcion);
			}
		}
	});
	
}

function clear(){
	$(".inputField").val("");
	$(".hiddenId").val("");
	$("#txtSearch").val("");
}

