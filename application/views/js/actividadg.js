/**
 * 
 */

$(document).ready(function(){
	loadGrid();
});


function loadGrid(){

	$("#tablaActividades").jqGrid(
			{
				url : "index.php/actividadg/actividadgRead/" + $("#idUsuario").val(),
				datatype : "json",
				mtype : "POST",
				colNames : [ "Cod.", "Actividad", "Fecha Fin Plan.", "Proceso", "Estado", "Prioridad" ],
				colModel : [ {
					name : "idActividad",
					index : "idActividad",
					width : 0,
					hidden : true
				}, {
					name : "nombreActividad",
					index : "nombreActividad",
					width : 160
					
				}, {
					name : "fechaFinalizacionPlan",
					index : "fechaFinalizacionPlan",
					width : 70
					
				}, {
					name : "nombreProceso",
					index : "nombreProceso",
					width : 130
					
				}, {
					name : "estado",
					index : "estado",
					width : 40
					
				}, {
					name : "nombrePrioridad",
					index : "nombrePrioridad",
					width : 70
					
				}],
				pager : "#pager",
				rowNum : 10,
				rowList : [ 10, 20, 30 ],
				sortname : "id",
				sortorder : "desc",
				ajaxGridOptions: {cache: false},
				loadonce : true,
				viewrecords : true,
				gridview : true,
				width : 700,
				height : 320,
				caption : "Actividades asignadas:",
				ondblClickRow: function(id) {
			    	mostrarSolicitud(id);
			    	$("#idSolicitud").val(id);
			    	$("#txtRecords").attr('disabled', '');		    	
			    	empleadosAutocomplete();
			    }
			});
}
