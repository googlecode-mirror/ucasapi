$(document).ready(function(){
	$('.divActions').addClass("ui-corner-all");
	$('.divDataForm').addClass("ui-corner-all");
	$('.container').addClass("ui-corner-bottom");
	$("button").button({icons: {primary: "ui-icon-locked"}});
	estadoAutocomplete();
	actividadData();
});

function estadoAutocomplete(){
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
        		$("#txtEstadoName").autocomplete({
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

function save(){
	var formData = "idEstado=" + $("#idEstado").val();
	formData += "&idProyecto=" + $("#idProyecto").val();
	formData += "&idActividad=" + $("#idActividad").val();
	formData += "&idUsuario=" + $("#idUsuario").val();
	formData += "&progreso=" + $("#cbProgreso").val();
	formData += "&comentario=" + $("#txtComentarios").val();
	
	$.ajax({
		type: "POST",
		url: "index.php/actividad/actividadValidateAndSave",
		data: formData,
		dataType: "json",
		success: function(retrievedData){
			if(retrievedData.status != 0){
				alert("Mensaje de error: " + retrievedData.msg);
			}
			else{
				
				alert("Actividad actualizada con exito");
				estadoAutocomplete();
			}
		}
	
	});
}

function actividadData(){
	var formData = "idActividad=" + $("#idActividad").val();
	formData += "&idProyecto=" + $("#idProyecto").val();
	formData += "&idUsuario=" + $("#idUsuario").val();
	
	$.ajax({				
        type: "POST",
        url:  "index.php/actividad/actividadRead",
        data: formData,
        dataType : "json",
        success: function(retrievedData){        	
        	if(retrievedData.status != 0){
        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
        	}
        	else{        		
        		$("#txtProyectoName").val(retrievedData.data.nombreProyecto);
        		$("#txtActividadName").val(retrievedData.data.nombreActividad);
        		$("#txtEstadoName").val(retrievedData.data.estado);
        		$("#cbProgreso").val(retrievedData.data.progreso);
        		$("#txtComentarios").val(retrievedData.data.comentario);
        		$("#txtDescripcion").val(retrievedData.data.descripcionActividad);
        	}        	
      }	
      
	});
	
}