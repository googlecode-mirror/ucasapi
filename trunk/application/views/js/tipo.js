/**
 * 
 */

$(document).ready(function(){
	tipoAutocomplete();	
});

function tipoAutocomplete(){
	$.ajax({
		type: "POST",
        url:  "index.php/tipo/tipoAutocompleteRead",
        data: "tipoAutocomplete",
        dataType : "json",
        success: function(retrievedData){        	
        	if(retrievedData.status != 0){
        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
        	}
        	else{        		
        		$("#txtSearch").autocomplete({
            		minChars: 0,  
    		        source: retrievedData.data,
    		        minLength: 1,
    		        select: function(event, ui) {
    			        $("#idTipo").val(ui.item.id);					
    				}
    			});
        		
        	}        	
      }
		
	});
	
}

function save(){
	var formData = "";
	formData += "idTipo=" + $("#idTipo").val();
	formData += "&nombreTipo=" + $("#txtTipoName").val();
	formData += "&descripcion=" + $("#txtTipoDesc").val();

	$.ajax({
		type: "POST",
		url: "index.php/tipo/tipoValidateAndSave",
		data: formData,
		dataType: "json",
		success: function(retrievedData){
			if(retrievedData.status != 0){
				alert("Mensaje de error: " + retrievedData.msg);
			}
			else{
				if($("#idTipo").val() == ""){
					alert("Tipo agregada con exito");
				}
				else{
					alert("Tipo actualizada con exito");
				}
				TipoAutocomplete();
				clear();
					
			}
		}
	
	});	
}

function deleteData(){
	var formData = "idTipo=" + $("#idTipo").val();
	
	$.ajax({
		type: "POST",
		url: "index.php/tipo/tipoDelete",
		data: formData,
		dataType: "json",
		success: function(retrievedData){
			if(retrievedData.status != 0){
				alert("Mensaje de error: " + retrievedData.msg);
			}
			else{
				alert("Tipo eliminada con exito");
				tipoAutocomplete();
				clear();
			}
		}
	});
	
}

function edit(){
	var formData = "idTipo=" + $("#idTipo").val();

	$.ajax({
		type: "POST",
		url: "index.php/tipo/tipoRead",
		data: formData,
		dataType: "json",
		success: function(retrievedData){
			if(retrievedData.status != 0){
				alert("Mensaje de error: " + retrievedData.msg);
			}
			else{
				$("#txtTipoName").val(retrievedData.data.nombreTipo);
			}
		}
	});
	
}

function clear(){
	$(".inputField").val("");
	$(".hiddenId").val("");
	$("#txtSearch").val("");
}

/**
 * 
 */