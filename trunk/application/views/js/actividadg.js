/**
 * 
 */

$(document).ready(function(){
	js_ini();
	$("#actividadgButton").addClass("highlight");
	loadGrid();
});


function loadGrid(){

	$("#tablaActividades").jqGrid(
			{
				url : "index.php/actividadg/actividadgRead/" + $("#idUsuario").val(),
				datatype : "json",
				mtype : "POST",
				colNames : [ "Cod.", "CodP.", "Actividad", "Fecha Fin Plan.", "Proceso", "Estado", "Prioridad" ],
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
					row_data = $("#tablaActividades").jqGrid("getRowData", id);
					$idA = row_data["idActividad"];
					$idP = row_data["idProyecto"];
					window.location = "actividadg/actividad/"+$idA+"/"+$idP;
			    }
			});
}
