$(document).ready(function(){
	 js_ini();
	 $("#btnGet").button({icons: {primary: "ui-icon-folder-open"}});	
	 $("#buzonButton").addClass("highlight");
	 loadBuzon();
	 $("#todosMensajes").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false})
});	

function loadBuzon() {
	$("#todosMensajes").jqGrid(
			{
				url : "index.php/buzon/gridMensajesBuzon/" + $("#idUsuario").val(),
				datatype : "json",
				mtype : "POST",
				colNames : [ "Asunto", "Fecha", "Estado", "Hora" ],
				colModel : [ {
					name : "subject",
					index: "subject",
					width: 415
				}, {
					name : "fechaNotificacion",
					index : "fechaNotificacion",
					width : 150
				}, {
					name : "idEstado",
					index : "idEstado",
					width : 0,
					hidden: true
				}, {
					name : "horaEntrada",
					index : "horaEntrada",
					width : 0,
					hidden: true
				}],
				pager : "#pager",
				rowNum : 20,
				width : 900,
				height : 500,
				rowList : [20, 40, 60],
				sortname : "id",
				sortorder : "desc",
				loadonce : true,
				viewrecords : true,
				gridview : false,
				caption : "Lista de Notificaciones",
				afterInsertRow: function(rowid,rowdata){
					if(rowdata.idEstado == '18'){
						jQuery("#todosMensajes").setCell(rowid,'subject','',{'font-weight':'bold'});
						jQuery("#todosMensajes").setCell(rowid,'fechaNotificacion','',{'font-weight':'bold'});
					}
				},
				ondblClickRow: function(id) {
			    	load();
			    }
			});
	
}

function load(){
	var idNotificacion = $("#todosMensajes").jqGrid('getGridParam','selrow');
	var formData = "idNotificacion=" + idNotificacion;
	formData += "&idUsuario=" + $("#idUsuario").val();
	
	$.ajax({				
		type: "POST",
		url:  "index.php/buzon/buzonReadMensaje",
		data: formData,
		dataType : "json",
		success: function(retrievedData){        	 
			if(retrievedData.status != 0){
				alert("Mensaje de error: " + retrievedData.msg);
			}
			else{
				var $dialog = $('<div></div>')
				.html("<br>"+retrievedData.data.notificacion)
				.dialog({
					buttons: { "Cerrar": function() { $(this).dialog("close"); }},
					height: 200,
					resizable : false,
					width: 400,
					modal : true,
					autoOpen: false,
					close: function(event, ui){
						//loadBuzon();
						$("#todosMensajes").setGridParam({ datatype: 'json' });
						$("#todosMensajes").trigger("reloadGrid");
					},
					title: retrievedData.data.subject
				});
				$dialog.dialog('open');
				updateStatus(idNotificacion);
			}
		}

	});
}

function updateStatus(idN){
	var formData = "idUsuario=" + $("#idUsuario").val();
	
	$.ajax({				
		type: "POST",
		url:  "index.php/buzon/buzonUpdateMessage/" + idN,
		data: formData,
		dataType : "json",
		success: function(retrievedData){        	 
			if(retrievedData.status != 0){
				alert("Mensaje de error: " + retrievedData.msg);
			}
		}

	});
}

function cancel(){
	$('#msg').hide("slow");
	
}
