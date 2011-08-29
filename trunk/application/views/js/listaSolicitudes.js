$(document).ready(function(){
	js_ini();
	$("#cliente\\/listaSolicitudesButton").addClass("highlight");
	loadGrid();
	
	$("#dialogoSolicitud").dialog({
		width: 700,
		autoOpen: false
	});
});

function loadGrid() {
	$("#list").jqGrid({
	   	url:  "/ucasapi/index.php/solicitud/misSolicitudes/1",
	    datatype: "json",
	    mtype: "POST",
	    colNames:["Fecha de entrada", "T&iacute;tulo"],
	    colModel:[
	      {name:"fecha", index:"fecha", width:160}, 
	      {name:"titulo", index:"titulo", width:190}
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
	    	$("#idSolicitud").val(id);
	    }
  });

	$("#list2").jqGrid({
	   	url:  "/ucasapi/index.php/solicitud/misSolicitudes/0",
	    datatype: "json",
	    mtype: "POST",
	    colNames:["Fecha de entrada", "T&iacute;tulo"],
	    colModel :[
	      {name:"fecha", index:"fecha", width:160}, 
	      {name:"titulo", index:"titulo", width:190}
	    ],
	    pager: "#pager2",
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
	    	$("#idSolicitud").val(id);
	    }
  });
}

function mostrarSolicitud (idSolicitud) {
	$.ajax({				
        type: "POST",
        url:  "/ucasapi/index.php/solicitud/getSolicitudCliente",
        data: "idSolicitud=" + idSolicitud,
        dataType : "json",
        success: function(retrievedData){
        	if(retrievedData.status != 0){
        		msgBoxInfo(retrievedData.msg);
        		//alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se est� mostrando es t�cnico, para cuestiones de depuraci�n
        	}
        	else{
        		$("#tituloSolicitud").html(retrievedData.data[0].titulo);
        		$("#fecha").html(retrievedData.data[0].fechaIngreso);
        		$("#cliente").html(retrievedData.data[0].cliente);
        		$("#txtSolicitudDesc").val(retrievedData.data[0].descripcion);
        		$("#fechaInicio").html(retrievedData.data[0].fechaAtencion);
        		$("#fechaFin").html(retrievedData.data[0].fechaSalida);
        		$("#progreso").html(retrievedData.data[0].progreso);
        		
        		$("#dialogoSolicitud").css('visibility', 'visible').dialog('open');
        	}
        	
      	}
      
	});
}
