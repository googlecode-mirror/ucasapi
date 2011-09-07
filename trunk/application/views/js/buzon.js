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
				colNames : ["Asunto", "Fecha de Entrada", "Estado"],
				colModel : [{
					name : "subject",
					index: "subject",
					width: 415
				}, {
					name : "horaEntrada",
					index : "horaEntrada",
					width : 150
				}, {
					name : "idEstado",
					index : "idEstado",
					width : 0,
					hidden: true
				}],
				pager : "#pager",
				rowNum : 20,
				width : 800,
				height : 400,
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

function deleteMessage(){
	var idUsuario = $("#idUsuario").val();
	var idNotificacion = $("#todosMensajes").jqGrid('getGridParam','selrow');
	if(idNotificacion==null){
		msgBoxInfo("Debe seleccionar un mensaje a eliminar");
	}
	else{
		var resp = confirm("¿Está seguro que desea eliminar la notificación?");
		if(resp){
			$.ajax({				
				type: "POST",
				url:  "index.php/buzon/buzonDeleteMessage/" + idUsuario + "/" + idNotificacion,
				data: "deleteMessage",
				dataType : "json",
				success: function(retrievedData){        	 
					if(retrievedData.status != 0){
						msgBoxError("Ocurrió un error, por favor contacte al Administrador");
					}
					msgBoxSucces("La notificación fué eliminada con éxito");
					$("#todosMensajes").GridUnload("#todosMensajes");
					loadBuzon();
				}

			});
		}
	}
}

function cancel(){
	$('#msg').hide("slow");
	
}
