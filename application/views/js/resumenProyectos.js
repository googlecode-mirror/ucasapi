$(document).ready(function(){
	js_ini();
	loadGrid();
	$("#cliente\\/resumenProyectosButton").addClass("highlight");
	$("#dialogoProyecto").dialog({
		buttons: { "Cerrar": function() { $(this).dialog("close"); }},
		resizable : false,
		modal : true,
		width: 500,
		autoOpen: false
	});
});

function loadGrid() {
	$("#list").jqGrid({
	   	url:  "/ucasapi/index.php/cliente/gridProyectosUsuario/" + $("#idUsuario").val(),
	    datatype: "json",
	    mtype: "POST",
	    colNames:["Nombre del proyecto"],
	    colModel:[
	      {name:"nombre", index:"nombre", width:300}
	    ],
	    pager: "#pager",
	    rowNum:10,
	    rowList:[10,20,30],
	    sortname: "id",
	    sortorder: "desc",
	    loadonce:true,
	    viewrecords: true,
	    gridview: true,
	    caption: "Proyectos",
	    ondblClickRow: function(id) {
	    	mostrarProyecto(id);
	    }
  });

}

function mostrarProyecto (idProyecto) {
	$.ajax({				
        type: "POST",
        url:  "/ucasapi/index.php/proyecto/proyectoRead",
        data: "idProyecto=" + idProyecto,
        dataType : "json",
        success: function(retrievedData){
        	if(retrievedData.status != 0){
        		msgBoxInfo(retrievedData.msg);
        		//alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se est� mostrando es t�cnico, para cuestiones de depuraci�n
        	}
        	else{
//        		$("#tituloSolicitud").html(retrievedData.data[0].titulo);
//        		$("#fecha").html(retrievedData.data[0].fechaEntrada);
//        		$("#cliente").html(retrievedData.data[0].cliente + "<br/>" + retrievedData.data[0].cargo + "<br/>" + retrievedData.data[0].depto);
//        		$("#txtSolicitudDesc").val(retrievedData.data[0].descripcion);
//        		$("#fechaInicio").html(retrievedData.data[0].fechaAtencion);
//        		$("#progreso").html(retrievedData.data[0].progreso);

        		$("#nombreProyecto").html(retrievedData.data.nombreProyecto);
        		$("#coordinadorProyecto").html(retrievedData.data.nombreEnc);
        		$("#fechaInicio").html(retrievedData.data.fechaPlanIni);
        		$("#fechaFin").html(retrievedData.data.fechaPlanFin);
        		$("#txtSolicitudDesc").val(retrievedData.data.descripcion);
        		
//        		$("#dialogoProyecto").css('visibility', 'visible').dialog('open');
        	}
        	
      	}
      
	});
	
	$.ajax({				
        type: "POST",
        url:  "/ucasapi/index.php/cliente/faseProyectoRead",
        data: "idProyecto=" + idProyecto,
        dataType : "json",
        success: function(retrievedData){
        	if(retrievedData.status != 0){
        		msgBoxInfo(retrievedData.msg);
        	}
        	else{

        		$("#fase").html(retrievedData.data.fase);
        		
        		$("#dialogoProyecto").css('visibility', 'visible').dialog('open');
        	}
        	
      	}
      
	});
}