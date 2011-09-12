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
	    	mostrarSolicitud(id, true);
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
	    	mostrarSolicitud(id, false);
	    	$("#idSolicitud").val(id);
	    }
  });
}

function mostrarSolicitud (idSolicitud, autor) {
	$.ajax({				
        type: "POST",
        url:  "/ucasapi/index.php/solicitud/getSolicitudCliente",
        data: "idSolicitud=" + idSolicitud,
        dataType : "json",
        success: function(retrievedData){
        	if(retrievedData.status != 0){
        		msgBoxInfo(retrievedData.msg);
        	}
        	else{
        		$("#tituloSolicitud").html(retrievedData.data[0].titulo);
        		$("#fecha").html(retrievedData.data[0].fechaIngreso);
        		$("#cliente").html(retrievedData.data[0].cliente);
        		$("#txtSolicitudDesc").val(retrievedData.data[0].descripcion);
        		
        		if(retrievedData.data[0].fechaAtencion == null) {
            		$("#fechaInicio").html("(Solicitud no asignada)");
        		} else if (retrievedData.data[0].fechaAtencion == "0000-00-00") {
        			$("#fechaInicio").html("(Asignada sin fecha de inicio)");
        		} else {
        			$("#fechaInicio").html(retrievedData.data[0].fechaAtencion);
        		}
        		
        		$("#fechaFinEsperada").html(retrievedData.data[0].fechaFinEsperada.substring(0,10));
        		$("#fechaFin").html(retrievedData.data[0].fechaSalida);
        		
        		if(retrievedData.data[0].progreso == null) {
        			$("#progreso").html("(Solicitud no asignada)");
        		} else {
        			$("#progreso").html(retrievedData.data[0].progreso);
        		}
        		
        		if(autor) {
        			$("#btnEdit").css('visibility', 'visible');
        		} else {
        			$("#btnEdit").css('visibility', 'hidden');
        		}
        		
        		$("#dialogoSolicitud").css('visibility', 'visible').dialog('open');
        	}
        	
      	}
      
	});
}

function goToEdit() {
	window.location = "/ucasapi/solicitud/index/" + $("#idSolicitud").val();
}