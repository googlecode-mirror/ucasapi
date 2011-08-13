numUsersOnGrid = 0;
numFollowersOnGrid = 0;

$(document).ready(function(){
	 js_ini();
	 projectAutocomplete();
	 userAutocomplete();
	 priorityAutocomplete();
	 statusAutocomplete();
	 $("#txtStartingDate, #txtEndingDate").datepicker({ dateFormat: 'yy-mm-dd' });
	 loadFollowersGrid();
	 loadUsersGrid();
	 
	 //$("#departamentoButton").addClass("highlight");
	 //departmentAutocomplete();	
	 //loadGrid();
	 //ajaxUpload();
	 
});	

function projectAutocomplete(){
	$.ajax({				
        type: "POST",
        url:  "index.php/actividada/projectAutocomplete",
        dataType : "json",
        success: function(retrievedData){        	
        	if(retrievedData.status != 0){
        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
        	}
        	else{        		
        		$("#txtProjectRecords").autocomplete({
            		minChars: 0,
            		matchContains: true,
    		        source: retrievedData.data,
    		        minLength: 0,
    		        selectFirst: true,
    		        select: function(event, ui) {
    			        $("#idProyecto").val(ui.item.id);
    			        $("#txtProcessRecords").val("");
    			        $("#idProceso").val("");
    			        processAutocomplete($("#idProyecto").val(), "#txtProcessRecords");
    			        activityAutocomplete($("#idProyecto").val(), "");
    				}
    			});
        		$("#txtProjectName").autocomplete({
            		minChars: 0,
            		matchContains: true,
    		        source: retrievedData.data,
    		        minLength: 0,
    		        select: function(event, ui) {
    			        $("#idProyecto").val(ui.item.id);
    			        $("#txtProcessName").val("");
    			        $("#idProceso").val("");
    			        processAutocomplete($("#idProyecto").val(), "#txtProcessName");
    				}
    			});
        		
        	}        	
      }
      
	});		
}

function processAutocomplete(idProyecto, processTextBox){
	$.ajax({				
        type: "POST",
        url:  "index.php/actividada/processAutocomplete/"+idProyecto,
        dataType : "json",
        success: function(retrievedData){        	
        	if(retrievedData.status != 0){
        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
        	}
        	else{        		
        		$(processTextBox).autocomplete({
            		minChars: 0,
            		matchContains: true,
    		        source: retrievedData.data,
    		        minLength: 1,
    		        select: function(event, ui) {
    			        $("#idProceso").val(ui.item.id);
    			        $("#idActividad").val("");
    			        if(processTextBox=="#txtProcessRecords"){
			        		$("#txtRecords").val("");
			        		activityAutocomplete($("#idProyecto").val(),$("#idProceso").val());
    			        }    			        
    				}
    			});
        		
        	}        	
      }
      
	});		
}

function activityAutocomplete(idProyecto, idProceso){
	$.ajax({				
        type: "POST",
        url:  "index.php/actividada/activityAutocomplete/"+idProyecto+"/"+idProceso,
        dataType : "json",
        success: function(retrievedData){        	
        	if(retrievedData.status != 0){
        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
        	}
        	else{        		
        		$("#txtRecords").autocomplete({
            		minChars: 0,
            		matchContains: true,
    		        source: retrievedData.data,
    		        minLength: 1,
    		        select: function(event, ui) {
    			        $("#idActividad").val(ui.item.id);					
    			        //processAutocompleteRead($("#idDepto").val());
    				}
    			});
        		
        	}        	
      }
      
	});		
}

function userAutocomplete(){
	$.ajax({				
        type: "POST",
        url:  "index.php/actividada/userAutocomplete",
        dataType : "json",
        success: function(retrievedData){        	
        	if(retrievedData.status != 0){
        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
        	}
        	else{        		
        		$("#txtResponsibleName").autocomplete({
            		minChars: 0,
            		matchContains: true,
    		        source: retrievedData.data,
    		        minLength: 1,
    		        select: function(event, ui) {
    			        $("#idUsuarioResponsable").val(ui.item.id);					
    				}
    			});
        		
        	}        	
      }
      
	});		
}

function priorityAutocomplete(){
	$.ajax({				
        type: "POST",
        url:  "index.php/actividada/priorityAutocomplete",
        dataType : "json",
        success: function(retrievedData){        	
        	if(retrievedData.status != 0){
        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
        	}
        	else{        		
        		$("#txtPriorityName").autocomplete({
            		minChars: 0,
            		matchContains: true,
    		        source: retrievedData.data,
    		        minLength: 1,
    		        select: function(event, ui) {
    			        $("#idPrioridad").val(ui.item.id);					
    				}
    			});
        		
        	}        	
      }
      
	});		
}

function statusAutocomplete(){
	$.ajax({				
        type: "POST",
        url:  "index.php/actividada/statusAutocomplete",
        dataType : "json",
        success: function(retrievedData){        	
        	if(retrievedData.status != 0){
        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
        	}
        	else{        		
        		$("#txtStatusName").autocomplete({
            		minChars: 0,
            		matchContains: true,
    		        source: retrievedData.data,
    		        minLength: 1,
    		        select: function(event, ui) {
    			        $("#idEstado").val(ui.item.id);					
    				}
    			});
        		
        	}        	
      }
      
	});		
}

function save(){	
	var gridData = $("#followersGrid").jqGrid("getRowData");
	var formData= "";
	formData += "idProyecto=" + $("#idProyecto").val();
	formData += "&idProceso=" + $("#idProceso").val();
	formData += "&idActividad=" + $("#idActividad").val();
	formData += "&idPrioridad=" + $("#idPrioridad").val();
	formData += "&idEstado=" + $("#idEstado").val();
	formData += "&idUsuarioResponsable=" + $("#idUsuarioResponsable").val();
	formData += "&idUsuarioAsigna=" + $("#idUsuarioAsigna").val();
	formData += "&nombreActividad=" + $("#txtActivityName").val();
	formData += "&fechaInicioPlan=" + $("#txtStartingDate").val();
	formData += "&fechaFinalizacionPlan=" + $("#txtEndingDate").val();
	formData += "&descripcion=" + $("#txtActivityDesc").val();
	formData += "&seguidores=" +parseGridData(gridData);
	
	
	$.ajax({				
        type: "POST",
        url:  "index.php/actividada/activityValidateAndSave",
        data: formData,
        dataType : "json",
        success: function(retrievedData){
        	if(retrievedData.status != 0){
        		msgBoxInfo(retrievedData.msg);
        		//alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
        	}
        	else{
        		if($("#idActividad").val()==""){
        			msgBoxSucces("Registro agregado con éxito");
        		}
        		else{
        			msgBoxSucces("Registro actualizado con éxito");
        			//alert("Registro actualizado con éxito");
        		}
        		clear();
        	}
      	}
      
	});
	
}

function edit(){			
	var formData = "idActividad=" + $("#idActividad").val();	
	
	$.ajax({				
        type: "POST",
        url:  "index.php/actividada/activityRead",
        data: formData,
        dataType : "json",
        success: function(retrievedData){
        	if(retrievedData.status != 0){
        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
        	}else{
        		$("#idProyecto").val(retrievedData.data.idProyecto);
        		$("#idProceso").val(retrievedData.data.idProceso);
        		$("#idUsuarioResponsable").val(retrievedData.data.idUsuario);
        		$("#idPrioridad").val(retrievedData.data.idPrioridad);
        		$("#idEstado").val(retrievedData.data.idEstado);
        		$("#txtStartingDate").val(retrievedData.data.fechaInicioPlan);
        		$("#txtEndingDate").val(retrievedData.data.fechaFinalizacionPlan);
        		$("#txtStatusName").val(retrievedData.data.estado);
        		$("#txtPriorityName").val(retrievedData.data.nombrePrioridad);
        		$("#txtResponsibleName").val(retrievedData.data.nombreUsuario);
        		$("#txtProjectName").val(retrievedData.data.nombreProyecto);
        		$("#txtProcessName").val(retrievedData.data.nombreProceso);
        		$("#txtActivityDesc").val(retrievedData.data.descripcionActividad);
        		$("#txtActivityName").val(retrievedData.data.nombreActividad);
        		
        		
        		
			    //$("#txtDepartmentDesc").val(retrievedData.data.descripcion);
			    
			    $('#usersGrid').setGridParam({url:"index.php/actividada/gridUsersRead/"+$("#idActividad").val()}).trigger("reloadGrid");
			    $('#followersGrid').setGridParam({url:"index.php/actividada/gridFollowersRead/"+$("#idActividad").val()}).trigger("reloadGrid");
        	}			       
      	}      
	});
	
}

function deleteData(){
	var formData = "idDepto=" + $("#idDepto").val();
	
	var answer = confirm("Está seguro que quiere eliminar el registro: "+ $("#txtRecords").val()+ " ?");
	
	if (answer){		
		$.ajax({				
	        type: "POST",
	        url:  "index.php/departamento/departmentDelete",
	        data: formData,
	        dataType : "json",
	        success: function(retrievedData){
	        	if(retrievedData.status != 0){
	        		msgBoxInfo(retrievedData.msg);
	        		//alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
	        	}
	        	else{
	        		msgBoxSucces("Registro eliminado con éxito");
	        		//alert("Registro eliminado con éxito");
	        		departmentAutocomplete();
	        		clear();
	        	}
	      	}
	      
		});		
	}	
}

function loadGrid(){	
	 $("#list").jqGrid({
		   	url:  "index.php/departamento/gridRead/",
		    datatype: "json",
		    mtype: "POST",
		    colNames:["Id","Departamento"],
		    colModel :[ 
		      {name:"id", index:"id", width:63}, 
		      {name:"value", index:"value", width:190} 
		    ],
		    pager: "#pager",
		    rowNum:10,
		    rowList:[10,20,30],
		    sortname: "id",
		    sortorder: "desc",
		    viewrecords: true,
		    gridview: true,
		    caption: "Departamentos"
	  });	
}



function cancel(){
	//$("#btnCancel").toggleClass('ui-state-active');
	clear();
	$("#msgBox").hide();
}

function clear(){
	$(".inputField, .hiddenId,.inputFieldTA, #txtRecords, #txtStartingDate, #txtEndingDate").val("");
}


function ajaxUpload(){
	new AjaxUpload("btnUpload", {
		debug:true,
        action: "index.php/upload/do_upload/",
		onSubmit : function(file , ext){
            // Extensions allowed. You should add security check on the server-side.
			if (ext && /^(txt|png|jpeg|docx)$/.test(ext)){
				/* Setting data */
				this.setData({
					"key": 'This string will be send with the file'
				});					
				//$('#example2.text').text('Uploading ' + file);	
			} else {					
				// extension is not allowed
				//$('#example2.text').text('Error: only images are allowed');
				// cancel upload
				return false;				
			}		
		},
		onComplete : function(file,response){
			alert(response);				
		}		
	});
}

function loadFollowersGrid(){	
	 $("#followersGrid").jqGrid({
		   	//url:  "index.php/departamento/gridRead/",
		    datatype: "json",
		    mtype: "POST",
		    colNames:["Id","Usuario","Departamento"],
		    colModel :[ 
              {name:"id", index:"id", hidden:true}, 
 		      {name:"usuario", index:"usuario", width:190},
	 		  {name:"depto", index:"depto", width:190}
		    ],
		    pager: "#fpager",
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
					numFollowersOnGrid = $("#usersGrid").jqGrid("getGridParam","records");
				}
		    }	    	
	  });	
}

function loadUsersGrid(){	
	 $("#usersGrid").jqGrid({
		   	url:  "index.php/actividada/gridUsersRead/",
		    datatype: "json",
		    mtype: "POST",
		    colNames:["Id","Usuario", "Departamento"],
		    colModel :[ 
		      {name:"id", index:"id", hidden:true}, 
		      {name:"usuario", index:"usuario", width:190},
		      {name:"depto", index:"depto", width:190}
		    ],
		    pager: "#upager",
		    rowNum:10,
		    width : 480,
		    rowList:[10,20,30],
		    sortname: "id",
		    sortorder: "desc",
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
	
}

function removeUser(){
	rowId = $("#followersGrid").jqGrid("getGridParam","selrow");
	rowData = $("#followersGrid").jqGrid("getRowData",rowId);
	
	if(rowId == null){
		msgBoxInfo("Debe seleccionar un usuario para agregar");
		return;
	}
	
	numUsersOnGrid++;
	numFollowersOnGrid--;
	
	$("#usersGrid").jqGrid("addRowData", numFollowersOnGrid, rowData);
	$("#followersGrid").jqGrid("delRowData", rowId, rowData);
	
}

function parseGridData(gridData){
	var parsedData = "";
	for ( var Elemento in gridData) {
		for ( var Propiedad in gridData[Elemento]) {
			parsedData += gridData[Elemento][Propiedad] + "|";
		}
	}
	return parsedData;
}