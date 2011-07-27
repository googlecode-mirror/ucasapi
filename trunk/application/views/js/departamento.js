

$(document).ready(function(){
	 js_ini();
	 $("#departamentoButton").addClass("highlight");
	 departmentAutocomplete();	
});	

function departmentAutocomplete(){
	$.ajax({				
        type: "POST",
        url:  "index.php/departamento/departmentAutocompleteRead",
        data: "departmentAutocomplete",
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
    			        $("#idDepto").val(ui.item.id);					
    				}
    			});
        		
        	}        	
      }
      
	});		
}

function save(){			
	var formData= "";
	formData += "idDepto=" + $("#idDepto").val();
	formData += "&nombreDepto=" + $("#txtDepartmentName").val();
	formData += "&descripcion=" + $("#txtDepartmentDesc").val();
	
	$.ajax({				
        type: "POST",
        url:  "index.php/departamento/departmentValidateAndSave",
        data: formData,
        dataType : "json",
        success: function(retrievedData){
        	if(retrievedData.status != 0){
        		msgBoxInfo(retrievedData.msg);
        		//alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
        	}
        	else{
        		if($("#idDepto").val()==""){
        			msgBoxSucces("Registro agregado con éxito");
        		}
        		else{
        			msgBoxSucces("Registro actualizado con éxito");
        			//alert("Registro actualizado con éxito");
        		}
        		departmentAutocomplete();
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
			    
			    loadGridData($("#idDepto").val()); // <-------------------------------------
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

function loadGridData(idDep){
	
	 $("#list").jqGrid({
		   	url:  "index.php/departamento/gridRead/"+idDep,
		    datatype: 'json',
		    mtype: 'POST',
		    colNames:['Id','Departamento'],
		    colModel :[ 
		      {name:'id', index:'id', width:63}, 
		      {name:'value', index:'value', width:190} 
		    ],
		    pager: '#pager',
		    rowNum:10,
		    rowList:[10,20,30],
		    sortname: 'id',
		    sortorder: 'desc',
		    cmon : 'grsb',
		    viewrecords: true,
		    gridview: true,
		    caption: 'Departamentos'
	  });	 
	
}



function cancel(){
	//$("#btnCancel").toggleClass('ui-state-active');
	clear();
	$("#msgBox").hide();
}

function clear(){
	$(".inputField").val("");
	$(".hiddenId").val("");
	$("#txtRecords").val("");
}

