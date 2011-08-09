$(document).ready(function(){
	 js_ini();
	 projectAutocomplete();
	 userAutocomplete();
	 priorityAutocomplete();
	 statusAutocomplete();
	 $("#txtStartingDate, #txtEndingDate").datepicker({ dateFormat: 'yy-mm-dd' });
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
    		        minLength: 1,
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
    		        minLength: 1,
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
    			        $("#idResponsable").val(ui.item.id);					
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
	var formData = "idDepto=" + $("#idDepto").val();	
	
	$.ajax({				
        type: "POST",
        url:  "index.php/departamento/departmentRead",
        data: formData,
        dataType : "json",
        success: function(retrievedData){
        	if(retrievedData.status != 0){
        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
        	}else{
        		$("#txtDepartmentName").val(retrievedData.data.nombreDepto);
			    $("#txtDepartmentDesc").val(retrievedData.data.descripcion);
			    
			    $('#list').setGridParam({url:"index.php/departamento/gridRead/"+$("#idDepto").val()}).trigger("reloadGrid");
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