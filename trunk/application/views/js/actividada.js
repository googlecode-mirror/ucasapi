numUsersOnGrid = 0;
numFollowersOnGrid = 0;
numUsers1OnGrid = 0;
numResponsiblesOnGrid = 0;
numProjectsOnGrid = 0;
numRProjectsOnGrid=0;

currentResponsibles=new Array();
dynamicResponsibles = new Array();

currentFollowers = new Array();
dynamicFollowers = new Array();


$(document).ready(function(){
	 idArchivo = "";
	 upload = null;
	 $("#actividadaButton").addClass("highlight");
	 js_ini();	 
	 if(navigator.appName == "Microsoft Internet Explorer"){$("#txtStartingDate,#txtEndingDate").css("height", "16px");};
	 
	 ajaxUpload();
	 projectAutocomplete();
	 priorityAutocomplete();
	 statusAutocomplete();
	 fileTypeAutocomplete();
	// $("#txtStartingDate, #txtEndingDate").datepicker({ dateFormat: 'yy-mm-dd' });
	 loadProjectsGrid();
	 loadRelatedProjectsGrid();
	 loadGridDocuments();
	 loadFollowersGrid();
	 loadUsersGrid();
	 loadUsers1Grid();
	 loadResponsibleUsersGrid();
	 $("button").button();
	 
	 $("#txtProjectRecords").focus(function(){$("#txtProjectRecords").autocomplete('search', '');});
	 $("#txtProjectName").focus(function(){$("#txtProjectName").autocomplete('search', '');});
	 $("#txtProcessRecords").focus(function(){$("#txtProcessRecords").autocomplete('search', '');});
	 $("#txtProcessName").focus(function(){$("#txtProcessName").autocomplete('search', '');});
	 $("#txtRecords").focus(function(){$("#txtRecords").autocomplete('search', '');});
	 $("#txtPriorityName").focus(function(){$("#txtPriorityName").autocomplete('search', '');});
	 $("#txtStatusName").focus(function(){$("#txtStatusName").autocomplete('search', '');});
	 $("#txtFileType").focus(function(){$("#txtFileType").autocomplete('search', '');});
	 
	 
	 //$("#departamentoButton").addClass("highlight");
	 //departmentAutocomplete();	
	 //loadGrid();
	 //ajaxUpload();
	 
	//Datepickers
		$("#txtStartingDate").datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true , changeYear: true, yearRange: '1920:c+5'});
		$("#txtEndingDate").datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true , changeYear: true, yearRange: '1920:c+5'});
	
		$("#tagBliblioteca").hide();	
		
		
	 
});	

//------------------------------------------------------------------------------------------------------------------------------------------------------------------

function projectAutocomplete(){
	$.ajax({				
        type: "POST",
        url:  "/ucasapi/actividada/projectAutocomplete",
        dataType : "json",
        success: function(retrievedData){        	
        	if(retrievedData.status != 0){
        		//alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se estï¿½ mostrando es tï¿½cnico, para cuestiones de depuraciï¿½n
        	}
        	else{        		
        		$("#txtProjectRecords").autocomplete({
            		minChars: 1,
            		matchContains: true,
    		        source: retrievedData.data,
    		        minLength: 0,
    		        selectFirst: true,
    		        select: function(event, ui) {
    			        $("#idProyecto").val(ui.item.id);
    			        $(this).blur();//Dedicado al IE
    			        $("#txtProcessRecords").val("");
    			        $("#idProceso").val("");
    			        processAutocomplete($("#idProyecto").val(), "#txtProcessRecords");
    			        activityAutocomplete($("#idProyecto").val(), "");
    				},
					//Esto es para el esperado mustMatch o algo parecido
					change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtProjectRecords").val())){
							$("#txtProjectRecords").val("");
							$("#idProyecto").val("");
						}
					}
    			});
        		$("#txtProjectName").autocomplete({
            		minChars: 0,
            		matchContains: true,
    		        source: retrievedData.data,
    		        minLength: 0,
    		        select: function(event, ui) {
    			        $("#idProyecto").val(ui.item.id);
    			        $(this).blur();//Dedicado al IE
    			        $("#txtProcessName").val("");
    			        $("#idProceso").val("");
    			        processAutocomplete($("#idProyecto").val(), "#txtProcessName");
    				},
    				change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtProjectName").val())){
							$("#txtProjectName").val("");
							$("#idProyecto").val("");
							$("#txtProcessName").val("");
							$("#idProceso").val("");
						}
					}
    				
    			});
        		
        	}        	
      }
      
	});		
}

//-------------------------------------------------------------------------------------------------------------------------------------------------------------------

function processAutocomplete(idProyecto, processTextBox){
	$.ajax({				
        type: "POST",
        url:  "/ucasapi/actividada/processAutocomplete/"+idProyecto,
        dataType : "json",
        success: function(retrievedData){        	
        	if(retrievedData.status != 0){
        		//alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se estï¿½ mostrando es tï¿½cnico, para cuestiones de depuraciï¿½n
        	}
        	else{        		
        		$(processTextBox).autocomplete({
            		minChars: 0,
            		matchContains: true,
    		        source: retrievedData.data,
    		        minLength: 0,
    		        select: function(event, ui) {
    			        $("#idProceso").val(ui.item.id);
    			        $(this).blur();//Dedicado al IE
    			        $("#idActividad").val("");
    			        if(processTextBox=="#txtProcessRecords"){
			        		$("#txtRecords").val("");
			        		activityAutocomplete($("#idProyecto").val(),$("#idProceso").val());
    			        }    			        
    				},
    				change :function(){
						if(!autocompleteMatch(retrievedData.data, $(processTextBox).val())){
							$(processTextBox).val("");
							$("#idProceso").val("");
							$("#idActividad").val("");
							$("#txtRecords").val("");
						}
					}
    			});        		
        	}        	
      }
      
	});		
}

//-------------------------------------------------------------------------------------------------------------------------------------------------------------------

function activityAutocomplete(idProyecto, idProceso){
	$.ajax({				
        type: "POST",
        url:  "/ucasapi/actividada/activityAutocomplete/"+idProyecto+"/"+idProceso,
        dataType : "json",
        success: function(retrievedData){        	
        	if(retrievedData.status != 0){
        		//alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se estï¿½ mostrando es tï¿½cnico, para cuestiones de depuraciï¿½n
        	}
        	else{        		
        		$("#txtRecords").autocomplete({
            		minChars: 0,
            		matchContains: true,
    		        source: retrievedData.data,
    		        minLength: 0,
    		        select: function(event, ui) {
    			        $("#idActividad").val(ui.item.id);
    			        $(this).blur();//Dedicado al IE
    			        //processAutocompleteRead($("#idDepto").val());
    				},
    				change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtRecords").val())){
							$("#txtRecords").val("");
							$("#idActividad").val("");
						}
					}
    			});
        		
        	}        	
      }
      
	});		
}



//---------------------------------------------------------------------------------------------------------------------------------------------------------------------

function priorityAutocomplete(){
	$.ajax({				
        type: "POST",
        url:  "/ucasapi/actividada/priorityAutocomplete",
        dataType : "json",
        success: function(retrievedData){        	
        	if(retrievedData.status != 0){
        		//alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se estï¿½ mostrando es tï¿½cnico, para cuestiones de depuraciï¿½n
        	}
        	else{        		
        		$("#txtPriorityName").autocomplete({
            		minChars: 0,
            		matchContains: true,
    		        source: retrievedData.data,
    		        minLength:0,
    		        select: function(event, ui) {
    			        $("#idPrioridad").val(ui.item.id);
    			        $(this).blur();//Dedicado al IE
    				},
    				change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtPriorityName").val())){
							$("#txtPriorityName").val("");
							$("#idPrioridad").val("");
						}
					}
    			});
        		
        	}        	
      }
      
	});		
}

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------

function statusAutocomplete(){
	$.ajax({				
        type: "POST",
        url:  "/ucasapi/actividada/statusAutocomplete",
        dataType : "json",
        success: function(retrievedData){        	
        	if(retrievedData.status != 0){
        		//alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se estï¿½ mostrando es tï¿½cnico, para cuestiones de depuraciï¿½n
        	}
        	else{        		
        		$("#txtStatusName").autocomplete({
            		minChars: 0,
            		matchContains: true,
    		        source: retrievedData.data,
    		        minLength: 0,
    		        select: function(event, ui) {
    			        $("#idEstado").val(ui.item.id);	
    			        $(this).blur();//Dedicado al IE
    				},
    				change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtStatusName").val())){
							$("#txtStatusName").val("");
							$("#idEstado").val("");
						}
					}
    			});
        		
        	}        	
      }
      
	});		
}

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------
function fileTypeAutocomplete(){
	$.ajax({				
        type: "POST",
        url:  "/ucasapi/actividada/fileTypeAutocomplete",
        dataType : "json",
        success: function(retrievedData){        	
        	if(retrievedData.status != 0){
        		//alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se estï¿½ mostrando es tï¿½cnico, para cuestiones de depuraciï¿½n
        	}
        	else{        		
        		$("#txtFileType").autocomplete({
            		minChars: 0,
            		matchContains: true,
    		        source: retrievedData.data,
    		        minLength: 0,
    		        select: function(event, ui) {
    			        $("#idTipoArchivo").val(ui.item.id);
    			        $(this).blur();//Dedicado al IE
    				},
    				change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtFileType").val())){
							$("#txtFileType").val("");
							$("#idTipoArchivo").val("");
						}
					}

    			});
        		
        	}        	
      }
      
	});		
}

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------

function save(){
	if(validarCampos()){
	
		var gridData = $("#followersGrid").jqGrid("getRowData");
		var gridResponsiblesData = $("#responsibleUsersGrid").jqGrid("getRowData");
		var gridRelatedProjectsData = $("#relatedProjectsGrid").jqGrid("getRowData");
		var formData= "";
		formData += "idProyecto=" + $("#idProyecto").val();
		formData += "&nombreProyecto=" + $("#txtProjectName").val();
		formData += "&idProceso=" + $("#idProceso").val();
		formData += "&idActividad=" + $("#idActividad").val();
		formData += "&idPrioridad=" + $("#idPrioridad").val();
		formData += "&idEstado=" + $("#idEstado").val();
		formData += "&idUsuarioAsigna=" + $("#idUsuarioAsigna").val();
		formData += "&nombreActividad=" + $("#txtActivityName").val();
		formData += "&fechaInicioPlan=" + $("#txtStartingDate").val();
		formData += "&fechaFinalizacionPlan=" + $("#txtEndingDate").val();
		formData += "&descripcion=" + $("#txtActivityDesc").val();
		formData += "&seguidoresI=" +(aNewElements(currentFollowers,dynamicFollowers)).toString();
		formData += "&seguidoresD=" +(aNewElements(dynamicFollowers,currentFollowers)).toString();
		formData += "&responsablesI=" +(aNewElements(currentResponsibles,dynamicResponsibles)).toString();
		formData += "&responsablesD=" +(aNewElements(dynamicResponsibles,currentResponsibles)).toString();
		formData += "&proyRelacionados=" +parseGridDataIds(gridRelatedProjectsData);
		formData += "&accionActual=" + $("#accionActual").val();
		
		//alert (formData);
		
		
		$.ajax({				
	        type: "POST",
	        url:  "/ucasapi/actividada/activityValidateAndSave",
	        data: formData,
	        dataType : "json",
	        success: function(retrievedData){
	        	if(retrievedData.status != 0){
	        		msgBoxInfo(retrievedData.msg);
	        		//alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se estï¿½ mostrando es tï¿½cnico, para cuestiones de depuraciï¿½n
	        	}
	        	else{
	        		if($("#accionActual").val()==""){
	        			msgBoxSucces("Registro agregado con &eacute;xito");
	        		}
	        		else{
	        			msgBoxSucces("Registro actualizado con &eacute;xito");
	        			//alert("Registro actualizado con ï¿½xito");
	        		}
	        		clear();
	        	}
	      	}
	      
		});
	}
	
}

//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function edit(){			
	var formData = "idActividad=" + $("#idActividad").val();	
	if($("#txtProjectRecords").val() != ""){		
		if($("#txtRecords").val() != ""){	
			$("#accionActual").val("editando");
			$("#tabs-4").show();
			$("#tagBliblioteca").show();
			lockAutocomplete();
			$.ajax({				
		        type: "POST",
		        url:  "/ucasapi/actividada/activityRead",
		        data: formData,
		        dataType : "json",
		        success: function(retrievedData){
		        	if(retrievedData.status != 0){
		        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se estï¿½ mostrando es tï¿½cnico, para cuestiones de depuraciï¿½n
		        	}else{
		        		$("#idProyecto").val(retrievedData.data.idProyecto);
		        		$("#idProceso").val(retrievedData.data.idProceso);
		        		$("#idPrioridad").val(retrievedData.data.idPrioridad);
		        		$("#idEstado").val(retrievedData.data.idEstado);
		        		$("#correlAnio").val(retrievedData.data.correlAnio);
		        		$("#anioSolicitud").val(retrievedData.data.anioSolicitud);
		        		$("#txtStartingDate").val(retrievedData.data.fechaInicioPlan);
		        		$("#txtEndingDate").val(retrievedData.data.fechaFinalizacionPlan);
		        		$("#txtStatusName").val(retrievedData.data.estado);
		        		$("#txtPriorityName").val(retrievedData.data.nombrePrioridad);
		        		$("#txtProjectName").val(retrievedData.data.nombreProyecto);
		        		$("#txtProcessName").val(retrievedData.data.nombreProceso);
		        		$("#txtActivityDesc").val(retrievedData.data.descripcionActividad);
		        		$("#txtActivityName").val(retrievedData.data.nombreActividad);
		        		
		        		$('#gridDocuments').setGridParam({url : "/ucasapi/actividada/gridDocumentsLoad/"+$("#idActividad").val()}).trigger("reloadGrid");
		        		$("#usersGrid").setGridParam({ datatype: 'json' });
		   			    $('#usersGrid').setGridParam({url:"/ucasapi/actividada/gridUsersRead/"+$("#idActividad").val()}).trigger("reloadGrid");
		   			    $("#users1Grid").setGridParam({ datatype: 'json' });
		   			    $('#users1Grid').setGridParam({url:"/ucasapi/actividada/gridUsers1Read/"+$("#idActividad").val()}).trigger("reloadGrid");
		   			    $("#responsibleUsersGrid").setGridParam({url:"/ucasapi/actividada/gridResponsiblesRead/"+$("#idActividad").val()}).trigger("reloadGrid");
					    $('#followersGrid').setGridParam({url:"/ucasapi/actividada/gridFollowersRead/"+$("#idActividad").val()}).trigger("reloadGrid");
					    $("#projectsGrid").setGridParam({ datatype: 'json' });
					    $("#projectsGrid").setGridParam({url:"/ucasapi/actividada/gridProjectsRead/"+$("#idActividad").val()}).trigger("reloadGrid");
					    $("#relatedProjectsGrid").setGridParam({url:"/ucasapi/actividada/gridRProjectsRead/"+$("#idActividad").val()}).trigger("reloadGrid");
		        	}			       
		      	}      
			});
		}else{
			msgBoxInfo("Debe seleccionar una ACTIVIDAD ");
		}
	}else{
		msgBoxInfo("Debe seleccionar un PROYECTO ");
	}
	
}

//------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function deleteData(){
	
	if($("#txtProjectRecords").val() != ""){		
		if($("#txtRecords").val() != ""){	
			var formData = "idActividad=" + $("#idActividad").val();	
			var answer = confirm("Estï¿½ seguro que quiere eliminar el registro: "+ $("#txtRecords").val()+ " ?");
			
			if (answer){		
				$.ajax({				
			        type: "POST",
			        url:  "/ucasapi/actividada/activityDelete",
			        data: formData,
			        dataType : "json",
			        success: function(retrievedData){
			        	if(retrievedData.status != 0){
			        		msgBoxInfo(retrievedData.msg);
			        		//alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se estï¿½ mostrando es tï¿½cnico, para cuestiones de depuraciï¿½n
			        	}
			        	else{
			        		msgBoxSucces("Registro eliminado con &eacute;xito");
			        		//alert("Registro eliminado con ï¿½xito");
			        		//departmentAutocomplete();
			        		clear();
			        	}
			      	}
			      
				});		
			}
		}else{
			msgBoxInfo("Debe seleccionar una ACTIVIDAD ");
		}
	}else{
		msgBoxInfo("Debe seleccionar un PROYECTO ");	
	}
}

//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function cancel(){
	//$("#btnCancel").toggleClass('ui-state-active');
	clear();
	$("#msgBox").hide();
}

//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function clear(){	
	$("#projectsGrid").setGridParam({ datatype: 'json' });
	$("#projectsGrid").trigger("reloadGrid");
	
	$("#users1Grid").setGridParam({ datatype: 'json' });
	$("#users1Grid").trigger("reloadGrid");
	
	$("#usersGrid").setGridParam({ datatype: 'json' });
	$("#usersGrid").trigger("reloadGrid");
	
	
	$("#responsibleUsersGrid").jqGrid("clearGridData", true);
	$("#followersGrid").jqGrid("clearGridData", true);
	$("#relatedProjectsGrid").jqGrid("clearGridData", true);

	
	
	$(".inputField,.inputFieldAC, .hiddenId,.inputFieldTA, #txtRecords, #txtStartingDate, #txtEndingDate").val("");
	$("#tabs-4").hide();
	$("#tagBliblioteca").hide();
	unlockAutocomplete();
	
	numUsersOnGrid = 0;
	numFollowersOnGrid = 0;
	numUsers1OnGrid = 0;
	numResponsiblesOnGrid = 0;
	numProjectsOnGrid = 0;
	numRProjectsOnGrid=0;
	
	$('#tabs').tabs({ selected: 0 }); 
}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function loadFollowersGrid(){	
	 $("#followersGrid").jqGrid({
		   	//url:  "/ucasapi/departamento/gridRead/",
		    datatype: "json",
		    mtype: "POST",
		    colNames:["Id","Usuario","Departamento"],
		    colModel :[ 
              {name:"id", index:"id", hidden:true}, 
 		      {name:"usuario", index:"usuario", width:190},
	 		  {name:"depto", index:"depto", width:190}
		    ],
		    pager: "#ffpager",
		    rowNum:10,
		    width : 480,
		    rowList:[10,20,30],
		    sortname: "id",
		    sortorder: "desc",
		    viewrecords: true,
		    gridview: true,
		    caption: "Seguidores de la actividad",
		    loadComplete: function(){
				if(numFollowersOnGrid==0){
					numFollowersOnGrid = $("#followersGrid").jqGrid("getGridParam","records");
					
					currentFollowers = dataDataIdsToArray($("#followersGrid").jqGrid("getRowData"));
					dynamicFollowers = dataDataIdsToArray($("#followersGrid").jqGrid("getRowData"));
				}
		    }	    	
	  });	
}

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------

function loadUsersGrid(){	
	 $("#usersGrid").jqGrid({
		   	url:  "/ucasapi/actividada/gridUsersRead/",
		    datatype: "json",
		    mtype: "POST",
		    colNames:["Id","Usuario", "Departamento"],
		    colModel :[ 
		      {name:"id", index:"id", hidden:true}, 
		      {name:"usuario", index:"usuario", width:190},
		      {name:"depto", index:"depto", width:190}
		    ],
		    pager: "#uupager",
		    rowNum:10,
		    width : 480,
		    rowList:[10,20,30],
		    sortname: "id",
		    sortorder: "desc",
		    loadonce : true,
		    viewrecords: true,
		    gridview: true,
		    caption: "Usuarios del sistema",
		    loadComplete: function(){
				if(numUsersOnGrid==0){
					numUsersOnGrid = $("#usersGrid").jqGrid("getGridParam","records");
				}
		    }
	  });	
}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function loadProjectsGrid(){	
	 $("#projectsGrid").jqGrid({
		   	url:  "/ucasapi/actividada/gridProjectsRead/",
		    datatype: "json",
		    mtype: "POST",
		    colNames:["Id","Proyecto","Responsable"],
		    colModel :[ 
              {name:"id", index:"id", hidden:true}, 
 		      {name:"proyecto", index:"proyecto", width:190},
	 		  {name:"responsableProyecto", index:"responsableProyecto", width:190}
		    ],
		    pager: "#ppager",
		    rowNum:10,
		    width : 480,
		    rowList:[10,20,30],
		    sortname: "id",
		    sortorder: "desc",
		    loadonce: true,
		    viewrecords: true,
		    gridview: true,
		    caption: "Proyectos del sistema",
		    loadComplete: function(){
				if(numFollowersOnGrid==0){
					numProjectsOnGrid = $("#projectsGrid").jqGrid("getGridParam","records");
				}
		    }	    	
	  });	
}

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------

function loadRelatedProjectsGrid(){	
	 $("#relatedProjectsGrid").jqGrid({
		   //	url:  "/ucasapi/actividada/gridUsersRead/",
		    datatype: "json",
		    mtype: "POST",
		    colNames:["Id","Proyecto", "Responsable"],
		    colModel :[ 
		      {name:"id", index:"id", hidden:true}, 
		      {name:"proyecto", index:"responsable", width:190},
		      {name:"responsableProyecto", index:"responsableProyecto", width:190}
		    ],
		    pager: "#rpager",
		    rowNum:10,
		    width : 480,
		    rowList:[10,20,30],
		    sortname: "id",
		    sortorder: "desc",
		    viewrecords: true,
		    gridview: true,
		    caption: "Proyectos relacionados con la actividad",
		    loadComplete: function(){
				if(numUsersOnGrid==0){
					numRProjectsOnGrid = $("#relatedProjectsGrid").jqGrid("getGridParam","records");
				}
		    }
	  });	
}


//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------
function loadUsers1Grid(){	
$("#users1Grid").jqGrid({
	   	url:  "/ucasapi/actividada/gridUsers1Read/",
	    datatype: "json",
	    mtype: "POST",
	    colNames:["Id","Usuario","Departamento"],
	    colModel :[ 
        {name:"id", index:"id", hidden:true}, 
	      {name:"usuario", index:"usuario", width:22},
		  {name:"depto", index:"depto", hidden:true}
	    ],
	    pager: "#pagerU",
	    rowNum:10,
	    width : 200,
	    rowList:[10,20,30],
	    sortname: "id",
	    sortorder: "desc",
	    viewrecords: true,
	    loadonce: true,
	    gridview: true,
	    caption: "Usuarios asignables",
	    loadComplete: function(){
			if(numUsers1OnGrid==0){
				numUsers1OnGrid = $("#users1Grid").jqGrid("getGridParam","records");
			}
	    }	    	
	});
}

function loadResponsibleUsersGrid(){	
$("#responsibleUsersGrid").jqGrid({
	   	//url:  "/ucasapi/actividada/gridUsersRead/",
	    datatype: "json",
	    mtype: "POST",
	    colNames:["Id","Usuario", "Departamento"],
	    colModel :[ 
	      {name:"id", index:"id", hidden:true}, 
	      {name:"usuario", index:"usuario", width:22},
	      {name:"depto", index:"depto", hidden:true}
	    ],
	    pager: "#pagerAU",
	    rowNum:10,
	    width : 200,
	    rowList:[10,20,30],
	    sortname: "id",
	    sortorder: "desc",
	    viewrecords: true,
	    gridview: true,
	    caption: "Usuarios responsables",
	    loadComplete: function(){
			if(numResponsiblesOnGrid==0){
				numResponsiblesOnGrid = $("#responsibleUsersGrid").jqGrid("getGridParam","records");
				
				//Agregando en un arreglo los ids de los responsables ya asignados
				currentResponsibles = dataDataIdsToArray($("#responsibleUsersGrid").jqGrid("getRowData"));
				dynamicResponsibles = dataDataIdsToArray($("#responsibleUsersGrid").jqGrid("getRowData"));

			}
	    }
	});	
}

function addResponsible(){
	rowId = $("#users1Grid").jqGrid("getGridParam","selrow");
	rowData = $("#users1Grid").jqGrid("getRowData",rowId);
	
	if(rowId == null){
		msgBoxInfo("Debe seleccionar un usuario para agregar");
		return;
	}
	
	numUsers1OnGrid--;
	numResponsiblesOnGrid++;
	
	$("#responsibleUsersGrid").jqGrid("addRowData", numResponsiblesOnGrid, rowData);
	$("#users1Grid").jqGrid("delRowData", rowId, rowData);	
	
	dynamicResponsibles.push(rowData["id"]);
}

function removeResponsible(){
	rowId = $("#responsibleUsersGrid").jqGrid("getGridParam","selrow");
	rowData = $("#responsibleUsersGrid").jqGrid("getRowData",rowId);
	
	if(rowId == null){
		msgBoxInfo("Debe seleccionar un usuario para quitar");
		return;
	}
	
	numResponsiblesOnGrid--;
	numUsers1OnGrid++;
		
	$("#users1Grid").jqGrid("addRowData", numUsers1OnGrid, rowData);
	$("#responsibleUsersGrid").jqGrid("delRowData", rowId, rowData);
	
	
	var index = dynamicResponsibles.indexOf(rowData["id"]);
	if(index!=-1)dynamicResponsibles.splice(index,1);
	
}

//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function addUser(){
	rowId = $("#usersGrid").jqGrid("getGridParam","selrow");
	rowData = $("#usersGrid").jqGrid("getRowData",rowId);
	
	if(rowId == null){
		msgBoxInfo("Debe seleccionar un usuario para agregar");
		return;
	}
	
	numUsersOnGrid--;
	numFollowersOnGrid++;
	
	$("#followersGrid").jqGrid("addRowData", numFollowersOnGrid, rowData);
	$("#usersGrid").jqGrid("delRowData", rowId, rowData);	
	
	dynamicFollowers.push(rowData["id"]);
}

//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function removeUser(){
	rowId = $("#followersGrid").jqGrid("getGridParam","selrow");
	rowData = $("#followersGrid").jqGrid("getRowData",rowId);
	
	if(rowId == null){
		msgBoxInfo("Debe seleccionar un usuario para quitar");
		return;
	}
	
	numUsersOnGrid++;
	numFollowersOnGrid--;
	
	$("#usersGrid").jqGrid("addRowData", numFollowersOnGrid, rowData);
	$("#followersGrid").jqGrid("delRowData", rowId, rowData);	
	
	var index = dynamicFollowers.indexOf(rowData["id"]);
	if(index!=-1)dynamicFollowers.splice(index,1);
}

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------
function addProject(){
	rowId = $("#projectsGrid").jqGrid("getGridParam","selrow");
	rowData = $("#projectsGrid").jqGrid("getRowData",rowId);
	
	if(rowId == null){
		msgBoxInfo("Debe seleccionar un proyecto para agregar");
		return;
	}
	
	numProjectsOnGrid--;
	numRProjectsOnGrid++;
	
	$("#relatedProjectsGrid").jqGrid("addRowData", numRProjectsOnGrid, rowData);
	$("#projectsGrid").jqGrid("delRowData", rowId, rowData);	
}

//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function removeProject(){
	rowId = $("#relatedProjectsGrid").jqGrid("getGridParam","selrow");
	rowData = $("#relatedProjectsGrid").jqGrid("getRowData",rowId);
	
	if(rowId == null){
		msgBoxInfo("Debe seleccionar un proyecto para quitar");
		return;
	}
	
	numRProjectsOnGrid--;
	numProjectsOnGrid++;	
	
	$("#projectsGrid").jqGrid("addRowData", numProjectsOnGrid, rowData);
	$("#relatedProjectsGrid").jqGrid("delRowData", rowId, rowData);	
}



//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function parseGridData(gridData){
	var parsedData = "";
	for ( var Elemento in gridData) {
		for ( var Propiedad in gridData[Elemento]) {
			parsedData += gridData[Elemento][Propiedad] + "|";
		}
	}
	return parsedData;
}

function parseGridDataIds(gridData){
	var parsedData = "";
	var i = 0;
	for ( var Elemento in gridData) {
		i=0;
		for ( var Propiedad in gridData[Elemento]) {
			if(i==0){
				parsedData += gridData[Elemento][Propiedad] + "|";
			}			
			i++;
		}
	}
	return parsedData.substring(0, parsedData.length-1);
}

function dataDataIdsToArray(gridData){
	var mArray = new Array();
	var i = 0;
	for ( var Elemento in gridData) {
		i=0;
		for ( var Propiedad in gridData[Elemento]) {
			if(i==0){
				mArray.push(gridData[Elemento][Propiedad]);
			}			
			i++;
		}
	}
	return mArray;
}

//Obtiene los elementos que tiene B y no tiene A
function aNewElements(a,b){
	var resultArray = new Array();

	for(var i = 0; i<(b.length); i++){
		var  found = false;
		
		for(var j = 0; j<(a.length); j++){
			
			if(b[i] == a[j]){
                found = true;
                break;
             }		
		}	
		if(found == false)resultArray.push(b[i]);
	}
	return resultArray;
	
}

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------

//Utilizando el plugin ajaxupload para la subida de archivos
function ajaxUpload() {
	new AjaxUpload("btnUpload", {
		debug : true,
		autoSubmit : false,
		responseType : "json",
		action : "/ucasapi/upload/do_upload/",
		onSubmit : function(file, ext) {
			if (!(ext && /^(txt|png|jpeg|docx|doc|rtf|ppt|pptx|bmp|gif|xls|xlsx|odt|ods|odp|odb|odf|odg|csv|pdf)$/.test(ext))) {
				//msgBoxInfo("El tipo de archivo no estï¿½ perimitido");
				//return false;
			}
		},
		onChange : function(file, response) {
			upload = this;
			$(".divUploadButton p").text("Archivo: " + file);
		},
		onComplete : function(file, response) {
			if (response.status != 0) {
				msgBoxInfo(response.msg);
				return false;
			} else {
				saveFileData(response.data.file_name);
			}
		}
	});
	upload = null;
	$(".divUploadButton p").text("");
}

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------

//Funciï¿½n asociada al botï¿½n "Agregar"
function uploadFile() {
	if (upload == null) {
		msgBoxInfo("Debe seleccionar un archivo");
		return false;
	}
	if ($("#txtFileName").val() == "") {
		msgBoxInfo("El campo Título es requerido");
		return false;
	}
	upload.setData({// Datos adicionales en el envï¿½o del archivo
		uploadIdName : "idActividad",
		uploadIdValue : $("#idActividad").val()
	});
	upload.submit();
}

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------

//Funciï¿½n desencadenada en el onComplete de la subida del archivo y asociada al
//botï¿½n "Actualizar"
function saveFileData(fileName) {
	idActividad = $("#idActividad").val();
	var formData = "nombreArchivo=" + fileName;
	formData += "&idActividad=" + $("#idActividad").val();
	formData += "&descripcion=" + $("#txtFileDesc").val();
	formData += "&tituloArchivo=" + $("#txtFileName").val();
	formData += "&idTipoArchivo=" + $("#idTipoArchivo").val();
	formData += "&idArchivo=" + idArchivo;
	if(idActividad != ""){
		//alert($idProyecto);
		$.ajax({
			type : "POST",
			url : "/ucasapi/actividada/fileValidateAndSave",
			data : formData,
			dataType : "json",
			success : function(retrievedData) {
				if (retrievedData.status != 0) {
					msgBoxInfo(retrievedData.msg);
	
				} else {
					$('#gridDocuments').setGridParam({url : "/ucasapi/actividada/gridDocumentsLoad/"+ $("#idActividad").val()}).trigger("reloadGrid");
					
					if (idArchivo == "") {
						msgBoxSucces("Documento agregado con éxito");
					} else {
						msgBoxSucces("Documento actualizado con éxito");
					}
					clearFileForm();
				}
			}
	
		});
	}
	else{
		msgBoxInfo("Debe seleccionarse una actividad para agregar el documento");
	}
}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------

//Inicializa el grid de documentos
function loadGridDocuments() {
	$("#gridDocuments").jqGrid({
		/* url: "/ucasapi/departamento/gridRead/", */
		datatype : "json",
		mtype : "POST",
		colNames : [ "Id", "Tipo", "Título","Nombre", "Subido", "Descripcion" ],
		colModel : [ {name : "idArchivo",index : "idArchivo",width : 20,hidden : true},
		             {name : "Tipo",index : "Tipo",width : 160}, 
		             {name : "Titulo",index : "Titulo",width : 160}, 
		             {name : "Nombre",index : "Nombre", width:160}, 
		             {name : "Subido",index : "Subido",width : 160}, 
		             {name : "Descripcion",index : "Descripcion",hidden : true} 
		             
		             ],
		pager : "#pager",
		rowNum : 10,
		width : 480,
		rowList : [ 10, 20, 30 ],
		sortname : "idArchivo",
		sortorder : "desc",
		viewrecords : true,
		gridview : true,
		shrinkToFit: false,
		caption : "Documentos"
	});

	// Utilizando botones personalizados en el grid
	$("#gridDocuments").navGrid("#pager", {
		edit : false,
		add : false,
		del : false,
		refresh : false
	});
	$("#gridDocuments").jqGrid("navButtonAdd", "#pager", {
		caption : "",
		buttonicon : "ui-icon-folder-open",
		title : "Abrir documento",
		onClickButton : function() {
			openFile();
		}
	});
	$("#gridDocuments").jqGrid("navButtonAdd", "#pager", {
		caption : "",
		buttonicon : "ui-icon-pencil",
		title : "Editar",
		onClickButton : function() {
			editFileData();
		}
	});
	$("#gridDocuments").jqGrid("navButtonAdd", "#pager", {
		caption : "",
		buttonicon : "ui-icon-trash",
		title : "Eliminar",
		onClickButton : function() {
			deleteFile();
		}
	});
}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------

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

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------

//Permite la edición de los datos del archivo seleccionado
function editFileData() {
	rowId = $("#gridDocuments").jqGrid("getGridParam", "selrow");
	if(rowId == null){
		msgBoxInfo("Debe seleccionar un archivo para editar");
	}else{
		$("#btnAddFile").hide()
		$("#btnUpdateFile").show();
		rowData = $("#gridDocuments").jqGrid("getRowData", rowId);
		idArchivo = rowData["idArchivo"];
		$("#txtFileDesc").val(rowData["Descripcion"]);
		$("#txtFileName").val(rowData["Titulo"]);
		$("#txtFileType").val(rowData["Tipo"]);
		$("#idTipoArchivo").val(rowData["idTipoArchivo"]);
	}
}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------

//Permite la eliminaciï¿½n de los datos del archivo seleccionado
function deleteFile() {
	rowId = $("#gridDocuments").jqGrid("getGridParam", "selrow");
	if(rowId == null){
		msgBoxInfo("Debe seleccionar un archivo para editar");
		
	}else{
		rowData = $("#gridDocuments").jqGrid("getRowData", rowId);
		idArchivo = rowData["idArchivo"];
		nombreArchivo = rowData["Nombre"];
		var formData = "idArchivo=" + idArchivo;
		formData += "&nombreArchivo=" + nombreArchivo;
		var answer = confirm("Está seguro que quiere eliminar el documento?");
		
		if(answer){
			$.ajax({
				type : "POST",
				url : "/ucasapi/actividada/fileDelete",
				data : formData,
				dataType : "json",
				success : function(retrievedData) {
					if (retrievedData.status != 0) {
						msgBoxInfo(retrievedData.msg);

					} else {
						$('#gridDocuments').setGridParam({
							url : "/ucasapi/actividada/gridDocumentsLoad/"+ $("#idActividad").val()}).trigger("reloadGrid");
							msgBoxSucces("Documento eliminado con éxito");
							clearFileForm();
					}
				}
			});
		}
	}
}

function clearFileForm() {
	$("#txtFileName").val("");
	$("#txtFileType").val("");
	$("#idTipoArchivo").val("");	
	$("#txtFileDesc").val("");
	$("#btnAddFile").show();
	$("#btnUpdateFile").hide();
	$(".divUploadButton p").text("");	
	idArchivo = "";
}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------


function validarCampos() {
	var camposFallan = "";
	if($("#txtActivityName").val()!=""){
		if(!validarAlfaEsp($("#txtActivityName").val())){
			camposFallan += "<p><dd>El campo NOMBRE contiene caracteres no validos </dd><br /></p>";
		}
	}else{
		camposFallan += "<p><dd>El campo NOMBRE es requerido </dd><br /></p>";
	}
	
	if($("#txtProjectName").val()==""){		
		camposFallan += "<p><dd>El campo PROYECTO es requerido </dd><br /></p>";
	}
	
	if($("#txtPriorityName").val()==""){		
		camposFallan += "<p><dd>El campo PRIORIDAD es requerido </dd><br /></p>";
	}
	
	if($("#txtStatusName").val()==""){		
		camposFallan += "<p><dd>El campo ESTADO es requerido </dd><br /></p>";
	}
	
	if ($("#txtActivityDesc").val() != "") {
		if ($("#txtActivityDesc").val().length > 256) {
			camposFallan += "<p><dd>Longutud de DESCRIPCION es mayor que 256 caracteres </dd><br /></p>";
		}
	}
	
	if ($("#txtEndingDate").val() != "" &&	 $("#txtStartingDate").val() != "") { 
		if(!validateOverlapFechas($("#txtEndingDate").val(),$("#txtStartingDate").val())) {
			 camposFallan += "<p><dd> El campo FECHA INICIO debe ser menor o igual a FECHA FIN </dd><br/></p>";
		}
	}
		
	if(camposFallan == ""){
		return true;
	}else{
		camposFallan = "Se han encontrado los siguientes problemas:<br/>" + camposFallan;
		msgBoxInfo(camposFallan);
		return false;
	}
	
	
}

/* OTRAS FUNCIONES DE VALIDACION Y LOCKING */
function lockAutocomplete() {	
	$("#txtProjectRecords").attr("disabled", true);	
	$("#txtProjectRecords").css({"background-color": "DBEBFF"});
	
	$("#txtProcessRecords").attr("disabled", true);	
	$("#txtProcessRecords").css({"background-color": "DBEBFF"});
	
	$("#txtRecords").attr("disabled", true);	
	$("#txtRecords").css({"background-color": "DBEBFF"});		
}

function unlockAutocomplete() {
	$("#txtProjectRecords").attr("disabled", false);	
	$("#txtProjectRecords").css({"background-color": "FFFFFF"});
	
	$("#txtProcessRecords").attr("disabled", false);	
	$("#txtProcessRecords").css({"background-color": "FFFFFF"});
	
	$("#txtRecords").attr("disabled", false);
	$("#txtRecords").css({"background-color": "FFFFFF"});	
}
