/**
 * 
 */

$(document).ready(function(){
	js_ini();
	$("#actividadgButton").addClass("highlight");
	loadGrid();
	$("#tablaActividades").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false})
});


function loadGrid(){

	$("#tablaActividades").jqGrid(
			{
				url : "index.php/actividadg/actividadgRead/" + $("#idUsuario").val(),
				datatype : "json",
				mtype : "POST",
				colNames : [ "Cod.", "CodP.", "Actividad", "Fecha Fin Plan.", "Proceso", "Proyecto", "Estado", "Prioridad", "Fecha Asignacion" ],
				colModel : [ {
					name : "idActividad",
					index : "idActividad",
					width : 0,
					hidden : true
				}, {
					name : "idProyecto",
					index : "idProyecto",
					width : 0,
					hidden : true
					
				}, {
					name : "nombreActividad",
					index : "nombreActividad",
					width : 160
					
				}, {
					name : "fechaFinalizacionPlan",
					index : "fechaFinalizacionPlan",
					width : 50
					
				}, {
					name : "nombreProceso",
					index : "nombreProceso",
					width : 130
					
				}, {
					name : "nombreProyecto",
					index : "nombreProyecto",
					width : 150
					
				}, {
					name : "estado",
					index : "estado",
					width : 70
					
				}, {
					name : "nombrePrioridad",
					index : "nombrePrioridad",
					width : 50
					
				}, {
					name : "horaAsignacion",
					index : "horaAsignacion",
					width : 110
					
				}],
				pager : "#pager",
				rowNum : 20,
				rowList : [ 20, 40, 60 ],
				sortname : "id",
				sortorder : "desc",
				ajaxGridOptions: {cache: false},
				loadonce : true,
				viewrecords : true,
				gridview : true,
				autowidth : true,
				width : 900,
				height : 520,

				caption : "Actividades asignadas:",
				ondblClickRow: function(id) {
					row_data = $("#tablaActividades").jqGrid("getRowData", id);
					$idA = row_data["idActividad"];
					$idP = row_data["idProyecto"];
					window.location = "actividadg/actividad/"+$idA+"/"+$idP;
			    }
			});
}
