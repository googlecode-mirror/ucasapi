var projectsData = new Array();
var processesData = new Array();
var activitiesData = new Array();
var filesData = new Array();

var projFlag = true;
var procFlag = true;
var actFlag = true;
var filFlag = true;


$(document).ready(function() {
	js_ini();
	$("#bibliotecaButton").addClass("highlight");
	//departmentAutocomplete();
	loadProjectsGrid();
	loadProcessesGrid();
	loadActivitiesGrid();
	loadDocumentsGrid();
	//loadGrid();
	//ajaxUpload();

	$("#btnClean").button({icons: {primary: "ui-icon-refresh"}});
	//Esto se debería hacer para cada autocomplete de la página, para que muestre todos los registro en el focus
	$("#txtRecords").focus(function(){$("#txtRecords").autocomplete('search', '');});
	
	$("#projectsGrid").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false})
	$("#processesGrid").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false})
	$("#activitiesGrid").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false})
	$("#documentsGrid").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false})

});



function loadProjectsGrid(){
	$("#projectsGrid").jqGrid({
		url : "index.php/biblioteca/gridProyectoRead/",
		datatype : "json",
		mtype : "POST",
		colNames : [ "idProyecto", "Proyecto" ],
		colModel : [ {
			name : "idProyecto",
			index : "idProyecto",
			hidden : true
		}, {
			name : "nombreProyecto",
			index : "nombreProyecto",
			width : 300
		} ],
		loadonce: true,
		rowNum : -1,
		rowList : [ 10, 20, 30 ],
		sortname : "id",
		sortorder : "desc",
		viewrecords : true,
		gridview : true,
		caption : "Proyectos",
		onCellSelect: function(rowid,iCol,cellcontent,e) {
			projGridId = row_id = $("#projectsGrid").jqGrid("getGridParam","selrow");
			projData = $("#projectsGrid").jqGrid("getRowData",projGridId);
			projId = projData["idProyecto"];
			
			
			var qPData = queryProcesses(projId, processesData);
			$("#processesGrid").jqGrid("clearGridData", true);
			$("#processesGrid").setGridParam({ data:qPData});
			$("#processesGrid").trigger('reloadGrid');
			
			var qAData = queryActivitiesProj(projId, activitiesData);
			$("#activitiesGrid").jqGrid("clearGridData", true);
			$("#activitiesGrid").setGridParam({ data:qAData});
			$("#activitiesGrid").trigger('reloadGrid');
			
			var qFData = queryFilesProj(projId, filesData);
			$("#documentsGrid").jqGrid("clearGridData", true);
			$("#documentsGrid").setGridParam({ data:qFData});
			$("#documentsGrid").trigger('reloadGrid');
						
			//Esto podría se últil alguna vez
			//$("#gs_idProyecto2").val($("#projectsGrid").jqGrid("getRowData",rowid)["idProyecto"]);
			//var processesGrid = $("#processesGrid")[0];
			//processesGrid.triggerToolbar();		
		},
		loadComplete : function() {
			if(projFlag){
				projectsData = parseProjectsGridData($("#projectsGrid").jqGrid("getRowData"));
				projFlag = false;
			}
			
		}
	});
}
function loadProcessesGrid(){
	$("#processesGrid").jqGrid({
		url : "index.php/biblioteca/gridProcesoRead/",
		datatype : "json",
		mtype : "POST",
		colNames : [ "idProyecto", "idProceso", "Proceso" ],
		colModel : [ {
			name : "idProyecto2",
			index : "idProyecto2",
			hidden : true
		},
		{
			name : "idProceso",
			index : "idProceso",
			hidden : true
		},
		{
			name : "nombreProceso",
			index : "nombreProceso",
			width : 300
		} ],
		loadComplete : function() {
			if(procFlag){
				processesData = parseProcessesGridData($("#processesGrid").jqGrid("getRowData"));
				procFlag = false;
			}
			
		},
		onCellSelect: function(rowid,iCol,cellcontent,e) {	
			projGridId = row_id = $("#projectsGrid").jqGrid("getGridParam","selrow");
			procGridId = row_id = $("#processesGrid").jqGrid("getGridParam","selrow");
			
			projData = $("#projectsGrid").jqGrid("getRowData",projGridId);
			procData = $("#processesGrid").jqGrid("getRowData",procGridId);
			
			qAData = queryActivitiesProc(projData["idProyecto"],procData["idProceso"], activitiesData);
			
			$("#activitiesGrid").jqGrid("clearGridData", true);
			$("#activitiesGrid").setGridParam({ data:qAData});
			$("#activitiesGrid").trigger('reloadGrid');
			
			
			qFData = queryFilesProc(procData["idProceso"], filesData);
			
			$("#documentsGrid").jqGrid("clearGridData", true);
			$("#documentsGrid").setGridParam({ data:qFData});
			$("#documentsGrid").trigger('reloadGrid');
		},		
		rowNum : -1,
		rowList : [ 10, 20, 30 ],
		sortname : "id",
		loadonce: true,
		sortorder : "desc",
		viewrecords : true,
		gridview : true,
		caption : "Procesos"
	});
}
function loadActivitiesGrid(){
	$("#activitiesGrid").jqGrid({
		url : "index.php/biblioteca/gridActividadRead/",
		datatype : "json",
		mtype : "POST",
		colNames : [ "idProyecto", "idProceso","idActividad", "Actividad" ],
		colModel : [{
			name : "idProyecto3",
			index : "idProyecto3",
			hidden : true
		},
		{
			name : "idProceso2",
			index : "idProceso2",
			hidden : true
		},
		 {
			name : "idActividad",
			index : "idActividad",
			hidden : true
		}, {
			name : "nombreActividad",
			index : "nombreActividad",
			width : 300
		} ],
		loadComplete : function() {
			if(actFlag){
				activitiesData = parseActivitiesGridData($("#activitiesGrid").jqGrid("getRowData"));
				actFlag = false;
			}
			
		},
		onCellSelect: function(rowid,iCol,cellcontent,e) {	
			actGridId = row_id = $("#activitiesGrid").jqGrid("getGridParam","selrow");
			
			actData = $("#activitiesGrid").jqGrid("getRowData",actGridId);			
			
			qFData = queryFilesAct(actData["idActividad"], filesData);
			
			$("#documentsGrid").jqGrid("clearGridData", true);
			$("#documentsGrid").setGridParam({ data:qFData});
			$("#documentsGrid").trigger('reloadGrid');
		},	
		rowNum : -1,
		rowList : [ 10, 20, 30 ],
		sortname : "id",
		sortorder : "desc",
		loadonce : true,
		viewrecords : true,
		gridview : true,
		caption : "Actividades"
	});
}

function loadDocumentsGrid(){
	$("#documentsGrid").jqGrid({
		url : "index.php/biblioteca/gridArchivoRead/",
		datatype : "json",
		mtype : "POST",
		colNames : [ "idProyectoA", "idProcesoA","idActividadA",  "Tipo","nombreArchivo", "Nombre", "Descripción", "Subido"],
		colModel : [{
			name : "idProyectoA",
			index : "idProyectoA",
			hidden : true
		},
		{
			name : "idProcesoA",
			index : "idProcesoA",
			hidden : true
		},
		 {
			name : "idActividadA",
			index : "idActividadA",
			hidden : true
		}, {
			name : "nombreTipo",
			index : "nombreTipo",
			with : 100
		},
		{
			name : "nombreArchivo",
			index : "nombreArchivo",
			hidden : true
		} ,
		{
			name : "tituloArchivo",
			index : "tituloArchivo",
			width : 225
		} ,
		{
			name : "descripcion",
			index : "descripcion",
			width : 420
		},
		{
			name : "fechaSubida",
			index : "fechaSubida",
			width : 100
		} ],
		
		 ondblClickRow: function(id) {
			 	rowId = $("#documentsGrid").jqGrid("getGridParam", "selrow");
			 	rowData = $("#documentsGrid").jqGrid("getRowData", rowId);
			 	
				fileName = rowData["nombreArchivo"];
				fileURL = $("#filePath").val() + fileName;
	
				window.open(fileURL);

		    },
	    loadComplete : function() {
			if(filFlag){
				filesData = parseFilesGridData($("#documentsGrid").jqGrid("getRowData"));
				filFlag = false;
			}
			
		},
		
		rowNum : -1,
		rowList : [ 10, 20, 30 ],
		loadonce:true,
		sortname : "id",
		sortorder : "desc",
		viewrecords : true,
		height : 400,
		gridview : true,
		caption : "Documentos"
	});
}

//-------------------- parse--------------------------------------------------------------------

function parseProjectsGridData(gridData){
    var retArray = new Array();

    for(var i = 0; i<gridData.length;i++){
        retArray[i] = new Array();
        
        retArray[i]["idProyecto"] = gridData[i].idProyecto;
        retArray[i]["nombreProyecto"] = gridData[i].nombreProyecto;
    }
    var emptyArray = new Array();
    retArray.push(emptyArray)
    return retArray;
}

function parseProcessesGridData(gridData){
    var retArray = new Array();

    for(var i = 0; i<gridData.length;i++){
        retArray[i] = new Array();
        
        retArray[i]["idProyecto2"] = gridData[i].idProyecto2;
        retArray[i]["idProceso"] = gridData[i].idProceso;
        retArray[i]["nombreProceso"] = gridData[i].nombreProceso;
    }
    var emptyArray = new Array();
    retArray.push(emptyArray)
    return retArray;
}

function parseActivitiesGridData(gridData){
    var retArray = new Array();

    for(var i = 0; i<gridData.length;i++){
        retArray[i] = new Array();
        
        retArray[i]["idProyecto3"] = gridData[i].idProyecto3;
        retArray[i]["idProceso2"] = gridData[i].idProceso2;
        retArray[i]["idActividad"] = gridData[i].idActividad;
        retArray[i]["nombreActividad"] = gridData[i].nombreActividad;
    }
    var emptyArray = new Array();
    retArray.push(emptyArray)
    return retArray;
}

function parseFilesGridData(gridData){
    var retArray = new Array();

    for(var i = 0; i<gridData.length;i++){
        retArray[i] = new Array();
        
        retArray[i]["idProyectoA"] = gridData[i].idProyectoA;
        retArray[i]["idProcesoA"] = gridData[i].idProcesoA;
        retArray[i]["idActividadA"] = gridData[i].idActividadA;
        retArray[i]["nombreArchivo"] = gridData[i].nombreArchivo;
        retArray[i]["nombreTipo"] = gridData[i].nombreTipo;
        retArray[i]["tituloArchivo"] = gridData[i].tituloArchivo;
        retArray[i]["descripcion"] = gridData[i].descripcion;
        retArray[i]["fechaSubida"] = gridData[i].fechaSubida;
    }
    var emptyArray = new Array();
    retArray.push(emptyArray)
    return retArray;
}

//-----------------query----------------------------------------------------------------
function queryProcesses(id, arrayData){
    var retArray = new Array();
    for(var i = 0; i<arrayData.length; i++){
        if(arrayData[i].idProyecto2 == id){
            retArray.push(arrayData[i]);
        }
    }
     var emptyArray = new Array();
     retArray.push(emptyArray)
     return retArray;
}

function queryActivitiesProj(id, arrayData){
    var retArray = new Array();
    for(var i = 0; i<arrayData.length; i++){
        if(arrayData[i].idProyecto3 == id){
            retArray.push(arrayData[i]);
        }
    }
    var emptyArray = new Array();
    retArray.push(emptyArray)
    return retArray;
}

function queryActivitiesProc(idProj,idProc, arrayData){
    var retArray = new Array();
    if(idProj!=null){
	    for(var i = 0; i<arrayData.length; i++){
	        if(arrayData[i].idProyecto3 == idProj && arrayData[i].idProceso2 == idProc){
	            retArray.push(arrayData[i]);
	        }
	    }
    }
    else{
    	for(var i = 0; i<arrayData.length; i++){
	        if(arrayData[i].idProceso2 == idProc){
	            retArray.push(arrayData[i]);
	        }
	    }
    }
    var emptyArray = new Array();
    retArray.push(emptyArray)
    return retArray;
}

function queryFilesProj(id, arrayData){
    var retArray = new Array();
    for(var i = 0; i<arrayData.length; i++){
        if(arrayData[i].idProyectoA == id){
            retArray.push(arrayData[i]);
        }
    }
    var emptyArray = new Array();
    retArray.push(emptyArray)
    return retArray;
}

function queryFilesProc(id, arrayData){
    var retArray = new Array();
    for(var i = 0; i<arrayData.length; i++){
        if(arrayData[i].idProcesoA == id){
            retArray.push(arrayData[i]);
        }
    }
    var emptyArray = new Array();
    retArray.push(emptyArray)
    return retArray;
}

function queryFilesAct(id, arrayData){
    var retArray = new Array();
    for(var i = 0; i<arrayData.length; i++){
        if(arrayData[i].idActividadA == id){
            retArray.push(arrayData[i]);
        }
    }
    var emptyArray = new Array();
    retArray.push(emptyArray)
    return retArray;
}

//Abre el documento correspondiente a la fila seleccionada
function openFile() {
	rowId = $("#gridDocuments").jqGrid("getGridParam", "selrow");
	if(rowId == null){
		msgBoxInfo("Debe seleccionar un archivo para abrir");
	}
	else{
		rowData = $("#gridDocuments").jqGrid("getRowData", rowId);
		fileName = rowData["Nombre"];
		fileURL = $("#filePath").val() + fileName;

		window.open(fileURL);
	}
}

function cleanFilters(){
	$("#projectsGrid").jqGrid("clearGridData", true);
	$("#projectsGrid").setGridParam({ data:projectsData});
	$("#projectsGrid").trigger('reloadGrid');
	
	$("#processesGrid").jqGrid("clearGridData", true);
	$("#processesGrid").setGridParam({ data:processesData});
	$("#processesGrid").trigger('reloadGrid');
	
	$("#activitiesGrid").jqGrid("clearGridData", true);
	$("#activitiesGrid").setGridParam({ data:activitiesData});
	$("#activitiesGrid").trigger('reloadGrid');
	
	$("#documentsGrid").jqGrid("clearGridData", true);
	$("#documentsGrid").setGridParam({ data:filesData});
	$("#documentsGrid").trigger('reloadGrid');
	
}

/* OTRAS FUNCIONES DE VALIDACION Y LOCKING*/
function lockAutocomplete() {	
	$("#txtRecords").attr("disabled", true);	
	$("#txtRecords").css({"background-color": "DBEBFF"});		
}

function unlockAutocomplete() {
	$("#txtRecords").attr("disabled", false);
	$("#txtRecords").css({"background-color": "FFFFFF"});	
}