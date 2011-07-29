$(document).ready(function(){
	js_ini();
	loadGrid();
});

function loadGrid() {
	
	 $("#list").jqGrid({
		   	url:  "index.php/solicitud/gridRead/",
		    datatype: "json",
		    mtype: "POST",
		    colNames:["Título", "Solicitante", "Fecha de entrada"],
		    colModel :[ 
		      {name:"titulo", index:"titulo", width:63}, 
		      {name:"usuarioSolicitante", index:"usuarioSolicitante", width:190},
		      {name:"fechaPeticion", index:"fechaPeticion", width:190} 
		    ],
		    pager: "#pager",
		    rowNum:10,
		    rowList:[10,20,30],
		    sortname: "id",
		    sortorder: "desc",
		    viewrecords: true,
		    gridview: true,
		    caption: "Solicitudes"
	  });	 
	
}