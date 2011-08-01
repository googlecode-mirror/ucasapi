$(document).ready(function(){
	js_ini();
	loadGrid();
});

function loadGrid() {
	$("#list").jqGrid({
	   	url:  "/ucasapi/index.php/solicitud/misSolicitudes/1",
	    datatype: "json",
	    mtype: "POST",
	    colNames:["Fecha de entrada", "T&iacute;tulo"],
	    colModel :[
	      {name:"fecha", index:"fecha", width:160}, 
	      {name:"titulo", index:"titulo", width:190}
	    ],
	    pager: "#pager",
	    rowNum:10,
	    rowList:[10,20,30],
	    sortname: "id",
	    sortorder: "desc",
	    loadonce:true,
	    viewrecords: true,
	    gridview: true,
	    caption: "Solicitudes"
  });

	$("#list2").jqGrid({
	   	url:  "/ucasapi/index.php/solicitud/misSolicitudes/0",
	    datatype: "json",
	    mtype: "POST",
	    colNames:["Fecha de entrada", "T&iacute;tulo"],
	    colModel :[
	      {name:"fecha", index:"fecha", width:160}, 
	      {name:"titulo", index:"titulo", width:190}
	    ],
	    pager: "#pager2",
	    rowNum:10,
	    rowList:[10,20,30],
	    sortname: "id",
	    sortorder: "desc",
	    loadonce:true,
	    viewrecords: true,
	    gridview: true,
	    caption: "Solicitudes"
  });
}