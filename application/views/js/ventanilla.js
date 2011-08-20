$(document).ready(function(){
	js_ini();
	loadGrid();
	$("#dialogoSolicitud").dialog({
		width: 700,
		autoOpen: false
	});
	$("#dialogoTransferir").dialog({
		autoOpen: false
	});
	$("#dialogoAsignar").dialog({
		width: 700,
		autoOpen: false
	});
	
	$("#txtStartingDate, #txtEndingDate").datepicker({ dateFormat: 'yy-mm-dd' });
//	$("#list").hideCol("anio");
//	$("#list").hideCol("correl");
});

function loadGrid() {
	
	 $("#listPeticion").jqGrid({
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
		    	$("#idSolicitud").val(id);
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
        		
        		
        		$("#dialogoSolicitud").css('visibility', 'visible').dialog('open');
        	}
        	
      	}
      
	});
}

function definirDestinatario() {
	$("#dialogoTransferir").css('visibility', 'visible').dialog('open');
}

function cargarDialogoAsignacion() {
	projectAutocomplete();
	userAutocomplete();
	priorityAutocomplete();
	statusAutocomplete();
	$("#dialogoAsignar").css('visibility', 'visible').dialog('open');
}

function transferirSolicitud() {
	
	var nombreDestinatario = $("#txtRecords").val();
	var formData = "idDestinatario=" + $("#idUsuario").val();
	formData += "&idSolicitud=" + $("#idSolicitud").val()
	
	$.ajax({				
        type: "POST",
        url:  "index.php/solicitud/transferirSolicitud",
        data: formData,
        dataType : "json",
        success: function(retrievedData){
        	if(retrievedData.status != 0){
        		msgBoxInfo(retrievedData.msg);
        		//alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se est� mostrando es t�cnico, para cuestiones de depuraci�n
        	}
        	else{
        		msgBoxSucces("Se ha transferido la solicitud a " + nombreDestinatario);
        		$("#txtRecords").val("");
        		$("#txtRecords").attr('disabled', 'disabled');
        		$(".cleanable").html("");
        		$("#txtSolicitudDesc").val("");
        		
        		$("#dialogoTransferir").dialog("close");
        		$("#dialogoSolicitud").dialog("close");
        	}
        	
      	}
      
	});
}

function asignarSolicitud () {
	var solicitud = $("#idSolicitud").val().split("-");
	var formData= "";
	formData += "idProyecto=" + $("#idProyecto").val();
	formData += "&idProceso=" + $("#idProceso").val();
	formData += "&idActividad=" + $("#idActividad").val();
	formData += "&idPrioridad=" + $("#idPrioridad").val();
	formData += "&idEstado=" + $("#idEstado").val();
	formData += "&idUsuarioResponsable=" + $("#idUsuarioResponsable").val();
	formData += "&idUsuarioAsigna=" + $("#idUsuarioAsigna").val();
	formData += "&nombreActividad=" + $("#txtActivityName").val();
	formData += "&fechaInicioPlan=" + $("#txtStartingDate").val();
	formData += "&fechaFinalizacionPlan=" + $("#txtEndingDate").val();
	formData += "&descripcion=" + $("#txtActivityDesc").val();
	formData += "&anioSolicitud=" + solicitud[0];
	formData += "&correlAnio=" + solicitud[1];
	
	
	$.ajax({				
        type: "POST",
        url:  "index.php/actividada/activityValidateAndSave",
        data: formData,
        dataType : "json",
        success: function(retrievedData){
        	if(retrievedData.status != 0){
        		msgBoxInfo(retrievedData.msg);
        		//alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se est� mostrando es t�cnico, para cuestiones de depuraci�n
        	}
        	else{
        		if($("#idActividad").val()==""){
        			msgBoxSucces("Registro agregado con �xito");
        		}
        		else{
        			msgBoxSucces("Registro actualizado con �xito");
        			$("div#dialogoAsignar > input:text").val("");
        			$("#txtActivityDesc").val("");
        			

            		$(".cleanable").html("");
            		$("#txtSolicitudDesc").val("");
        			
        			$("#dialogoAsignar").dialog("close");
            		$("#dialogoSolicitud").dialog("close");
        		}
        		
        	}
      	}
      
	});
}

// -----------------------------------------------------------------------------
// Funciones de Actividada
// -----------------------------------------------------------------------------
function projectAutocomplete(){
	$.ajax({				
        type: "POST",
        url:  "index.php/actividada/projectAutocomplete",
        dataType : "json",
        success: function(retrievedData){        	
        	if(retrievedData.status != 0){
        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se est� mostrando es t�cnico, para cuestiones de depuraci�n
        	}
        	else{        		
        		
        		$("#txtProjectName").autocomplete({
            		minChars: 0,
            		matchContains: true,
    		        source: retrievedData.data,
    		        minLength: 1,
    		        select: function(event, ui) {
    			        $("#idProyecto").val(ui.item.id);
    			        $("#txtProcessName").val("");
    			        $("#idProceso").val("");
    			        processAutocomplete($("#idProyecto").val(), "#txtProcessName");
    				}
    			});
        		
        	}        	
      }
      
	});		
}

function processAutocomplete(idProyecto, processTextBox){
	$.ajax({				
        type: "POST",
        url:  "index.php/actividada/processAutocomplete/"+idProyecto,
        dataType : "json",
        success: function(retrievedData){        	
        	if(retrievedData.status != 0){
        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se est� mostrando es t�cnico, para cuestiones de depuraci�n
        	}
        	else{        		
        		$(processTextBox).autocomplete({
            		minChars: 0,
            		matchContains: true,
    		        source: retrievedData.data,
    		        minLength: 0,
    		        select: function(event, ui) {
    			        $("#idProceso").val(ui.item.id);
    			        $("#idActividad").val("");
    			        if(processTextBox=="#txtProcessRecords"){
			        		$("#txtRecords").val("");
			        		activityAutocomplete($("#idProyecto").val(),$("#idProceso").val());
    			        }    			        
    				}
    			});
        		
        	}        	
      }
      
	});		
}

function userAutocomplete(){
	$.ajax({				
        type: "POST",
        url:  "index.php/actividada/userAutocomplete",
        dataType : "json",
        success: function(retrievedData){        	
        	if(retrievedData.status != 0){
        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se est� mostrando es t�cnico, para cuestiones de depuraci�n
        	}
        	else{        		
        		$("#txtResponsibleName").autocomplete({
            		minChars: 0,
            		matchContains: true,
    		        source: retrievedData.data,
    		        minLength: 1,
    		        select: function(event, ui) {
    			        $("#idUsuarioResponsable").val(ui.item.id);					
    				}
    			});
        		
        	}        	
      }
      
	});		
}

function priorityAutocomplete(){
	$.ajax({				
        type: "POST",
        url:  "index.php/actividada/priorityAutocomplete",
        dataType : "json",
        success: function(retrievedData){        	
        	if(retrievedData.status != 0){
        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se est� mostrando es t�cnico, para cuestiones de depuraci�n
        	}
        	else{        		
        		$("#txtPriorityName").autocomplete({
            		minChars: 0,
            		matchContains: true,
    		        source: retrievedData.data,
    		        minLength: 1,
    		        select: function(event, ui) {
    			        $("#idPrioridad").val(ui.item.id);					
    				}
    			});
        		
        	}        	
      }
      
	});		
}

function statusAutocomplete(){
	$.ajax({				
        type: "POST",
        url:  "index.php/actividada/statusAutocomplete",
        dataType : "json",
        success: function(retrievedData){        	
        	if(retrievedData.status != 0){
        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se est� mostrando es t�cnico, para cuestiones de depuraci�n
        	}
        	else{        		
        		$("#txtStatusName").autocomplete({
            		minChars: 0,
            		matchContains: true,
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
