$(document).ready(function(){
	 $('.divActions').addClass("ui-corner-all");
	 $('.divDataForm').addClass("ui-corner-all");
	 $('.container').addClass("ui-corner-bottom");
	 $("button").button({icons: {primary: "ui-icon-locked"}});	
	 loadBuzon();
});	

function loadBuzon() {
	$("#todosMensajes").jqGrid(
			{
				url : "index.php/buzon/gridMensajesBuzon/" + $("#idUsuario").val(),
				datatype : "json",
				mtype : "POST",
				colNames : [ "Asunto", "Fecha", "Estado" ],
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
				}],
				pager : "#pager",
				rowNum : 10,
				rowList : [ 10, 20, 30 ],
				sortname : "id",
				sortorder : "desc",
				loadonce : true,
				viewrecords : true,
				gridview : true,
				caption : "Lista de Notificaciones"
			});
}

function cancel(){
	$('#msg').hide("slow");
	
}
