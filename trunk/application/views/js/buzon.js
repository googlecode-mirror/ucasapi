$(document).ready(function(){
	 js_ini();
	 $("#btnGet").button({icons: {primary: "ui-icon-folder-open"}});	
	 $("#buzonButton").addClass("highlight");
	 loadBuzon();
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
				rowNum : 10,
				rowList : [ 10, 20, 30 ],
				sortname : "id",
				sortorder : "desc",
				loadonce : false,
				viewrecords : true,
				gridview : false,
				caption : "Lista de Notificaciones",
				afterInsertRow: function(rowid,rowdata){
					if(rowdata.idEstado == '18'){
						jQuery("#todosMensajes").setCell(rowid,'subject','',{'font-weight':'bold'});
						jQuery("#todosMensajes").setCell(rowid,'fechaNotificacion','',{'font-weight':'bold'});
					}
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
				.html(retrievedData.data.notificacion)
				.dialog({
					height: 200,
					width: 300,
					autoOpen: false,
					close: function(event, ui){
						//loadBuzon();
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
