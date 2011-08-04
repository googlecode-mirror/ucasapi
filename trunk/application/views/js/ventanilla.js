$(document).ready(function(){
	js_ini();
	loadGrid();
	$("#list").hideCol("anio");
	$("#list").hideCol("correl");
});

function loadGrid() {
	
	 $("#list").jqGrid({
		   	url:  "index.php/solicitud/gridRead/",
		    datatype: "json",
		    mtype: "POST",
		    colNames:["Fecha de entrada", "T&iacute;tulo", "Solicitante"],
		    colModel :[
		      {name:"fecha", index:"fecha", width:190}, 
		      {name:"titulo", index:"titulo", width:63}, 
		      {name:"usuario", index:"usuario", width:190}
		    ],
		    pager: "#pager",
		    rowNum:10,
		    rowList:[10,20,30],
		    sortname: "id",
		    sortorder: "desc",
		    loadonce:true,
		    viewrecords: true,
		    gridview: true,
		    caption: "Solicitudes",
		    ondblClickRow: function(id) {
		    	mostrarSolicitud(id);
		    	$("#txtRecords").attr('disabled', '');
		    	empleadosAutocomplete();
		    }
	  });	 
	
}

function empleadosAutocomplete() {
	$.ajax({				
        type: "POST",
        url:  "index.php/solicitud/empleadoAutocompleteRead",
        //data: "usuarioAutocomplete",
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
    			        $("#idUsuario").val(ui.item.id);
    				}
    			});
        		
        	}        	
      }
      
	});
}

function mostrarSolicitud (idSolicitud) {
	$.ajax({				
        type: "POST",
        url:  "index.php/solicitud/getSolicitud",
        data: "idSolicitud=" + idSolicitud,
        dataType : "json",
        success: function(retrievedData){
        	if(retrievedData.status != 0){
        		msgBoxInfo(retrievedData.msg);
        		//alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se est� mostrando es t�cnico, para cuestiones de depuraci�n
        	}
        	else{
        		$("#fecha").html(retrievedData.data[0].fechaEntrada);
        		$("#cliente").html(retrievedData.data[0].cliente + "<br/>" + retrievedData.data[0].cargo + "<br/>" + retrievedData.data[0].depto);
        		$("#tituloSolicitud").html(retrievedData.data[0].titulo);
        		$("#prioridad").html(retrievedData.data[0].prioridadCliente);
        		$("#txtSolicitudDesc").val(retrievedData.data[0].descripcion);
        		
        		var interesados = "";
        		for (i=1 ; i<retrievedData.data.length ; i++) {
        			interesados += retrievedData.data[i].cliente + " - " + retrievedData.data[i].depto + "<br/>";
        		}
        		
        		$("#interesados").html(interesados);
        	}
        	
      	}
      
	});
}

function transferirSolicitud() {
	var nombreDestinatario = $("#txtRecords").val();
	
	$.ajax({				
        type: "POST",
        url:  "index.php/solicitud/transferirSolicitud",
        data: "idDestinatario=" + $("#idUsuario").val(),
        dataType : "json",
        success: function(retrievedData){
        	if(retrievedData.status != 0){
        		msgBoxInfo(retrievedData.msg);
        		//alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se est� mostrando es t�cnico, para cuestiones de depuraci�n
        	}
        	else{
        		msgBoxSucces("Se ha transferido la solicitud a " + nombreDestinatario);
        		$("#txtRecords").val("");
        		$(".cleanable").html("");
        		$("#txtSolicitudDesc").val("");
        	}
        	
      	}
      
	});
}