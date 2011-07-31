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
		    colNames:["Fecha de entrada", "T&iacute;tulo", "Solicitante", "A&ntilde;o", "Correlativo", ],
		    colModel :[
		      {name:"fecha", index:"fecha", width:190}, 
		      {name:"titulo", index:"titulo", width:63}, 
		      {name:"usuario", index:"usuario", width:190},
		      {name:"anio", index:"anio", width:63},
		      {name:"correl", index:"correl", width:63}
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