
$(document).ready(function(){
	 //js_ini();
	 usuarioAutocomplete();	
	 loadGrid();
});

function usuarioAutocomplete(){
	$.ajax({				
        type: "POST",
        url:  "index.php/usuario/usuarioAutocompleteRead",
        data: "usuarioAutocomplete",
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
    			        //$("#idUsuario").val(ui.item.id);					
    		        	$("#cbxInteresados").append('<option value="' + ui.item.id + '">' + ui.item.value + '</option>');
    				}
    			});
        		
        	}        	
      }
      
	});		
}

function enviarSolicitud(){
	var interesados = ''; 

	$('#cbxInteresados option').each(function(i, selected){
		interesados += $(selected).val() + ",";
	});
	
	interesados = interesados.substr(0, interesados.length - 1);
	
	var formData= "";
	formData += "asunto=" + $("#txtSolicitudAsunto").val();
	formData += "&prioridad=" + $("#cbxPrioridades").val();
	formData += "&descripcion=" + $("#txtSolicitudDesc").val();
	formData += "&observadores=" + interesados;
	
	
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

function loadGrid(){
	
	 $("#list").jqGrid({
		   	url:  "index.php/solicitud/gridRead/",
		    datatype: "json",
		    mtype: "POST",
		    colNames:["Id","Titulo"],
		    colModel :[ 
		      {name:"id", index:"id", width:63}, 
		      {name:"value", index:"value", width:190} 
		    ],
		    pager: "#pager",
		    rowNum:10,
		    rowList:[10,20,30],
		    sortname: "id",
		    sortorder: "desc",
		    viewrecords: true,
		    gridview: true,
		    caption: "Solicitudes"
	  });	 
}


function clear(){
	$(".inputField").val("");
	$("#txtRecords").val("");
	$("#cbxPrioridades").val(0);
	
	$('option', $("#cbxInteresados")).remove();

}