
$(document).ready(function(){
	procesoAutocomplete();
	procesoProyectoAutocomplete();
	procesoFaseAutocomplete();
	procesoEstadoAutocomplete();
});	

function procesoAutocomplete(){
	$.ajax({				
		type: "POST",
		url:  "index.php/proceso/procesoAutocompleteRead",
		data: "statusAutocomplete",
		dataType : "json",
		success: function(retrievedData){        	
			if(retrievedData.status != 0){
				alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
			}
			else{        		
				$("#txtRecordsProc").autocomplete({
					minChars: 0,  
					source: retrievedData.data,
					minLength: 1,
					select: function(event, ui) {
						$("#idProceso").val(ui.item.id);					
					}
				});

			}        	
		}

	});		
}

function procesoProyectoAutocomplete(){
	$.ajax({				
		type: "POST",
		url:  "index.php/proyecto/proyectoAutocompleteRead",
		data: "procesoProyectoAutocomplete",
		dataType : "json",
		success: function(retrievedData){        	
			if(retrievedData.status != 0){
				alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
			}
			else{        		
				$("#txtRecordsProy").autocomplete({
					minChars: 0,  
					source: retrievedData.data,
					minLength: 1,
					select: function(event, ui) {
						$("#idProyecto").val(ui.item.id);
					}
				});

			}        	
		}

	});		
}

function procesoFaseAutocomplete(){
	$.ajax({				
		type: "POST",
		url:  "index.php/fase/faseAutocompleteRead",
		data: "procesoFaseAutocomplete",
		dataType : "json",
		success: function(retrievedData){        	
			if(retrievedData.status != 0){
				alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
			}
			else{        		
				$("#txtFaseName").autocomplete({
					minChars: 0,  
					source: retrievedData.data,
					minLength: 1,
					select: function(event, ui) {
						$("#idFase").val(ui.item.id);
					}
				});

			}        	
		}

	});		
}

function procesoEstadoAutocomplete(){
	$.ajax({				
		type: "POST",
		url:  "index.php/estado/statusAutocompleteRead",
		data: "procesoEstadoAutocomplete",
		dataType : "json",
		success: function(retrievedData){        	
			if(retrievedData.status != 0){
				alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
			}
			else{        		
				$("#txtEstadoName").autocomplete({
					minChars: 0,  
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
	formData += "idProceso=" + $("#idProceso").val();
	formData += "&idProyecto=" + $("#idProyecto").val();
	formData += "&idFase=" + $("#idFase").val();
	formData += "&idEstado=" + $("#idEstado").val();
	formData += "&nombreProceso=" + $("#txtProcesoName").val();
	formData += "&descripcion=" + $("#txtProcesoDesc").val();

	$.ajax({				
		type: "POST",
		url:  "index.php/proceso/procesoValidateAndSave",
		data: formData,
		dataType : "json",
		success: function(retrievedData){
			if(retrievedData.status != 0){
				alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
			}
			else{
				if($("idProceso").val()==""){
					alert("Registro agregado con éxito");
				}
				else{
					alert("Registro actualizado con éxito");
				}
				procesoAutocomplete();
				procesoProyectoAutocomplete();
				procesoFaseAutocomplete();
				procesoEstadoAutocomplete();
				clear();
			}
		}

	});

}

function edit(){			
	var formData = "idProceso=" + $("#idProceso").val();
	$.ajax({				
		type: "POST",
		url:  "index.php/proceso/procesoRead",
		data: formData,
		dataType : "json",
		success: function(retrievedData){
			if(retrievedData.status != 0){
				alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
			}else{
				$("#txtProcesoName").val(retrievedData.data.nombreProceso);
				$("#txtEstadoName").val(retrievedData.data.estado);
				$("#txtProcesoDesc").val(retrievedData.data.descripcion);

			}			       
		}      
	});
	loadGrid();
}

function loadGrid(){
	var formData = $("#idProceso").val();

	jQuery("#fasesList").jqGrid({
		url: "index.php/proceso/procesoGridRead",
		datatype: "json",	
		data: formData,
		colNames:['Nombre','Fecha Inicial Plan.', 'Fecha Final Plan.', 'Fecha Inicial Real','Fecha Final Real'],
		colModel:[
		          {name: 'nombreFase', index:'nombreFase', width:35, jsonmap: 'nombreFase'},
		          {name: 'fechaIniPlan', index:'fechaIniPlan', width:42, jsonmap: 'fechaIniPlan'},
		          {name: 'fechaFinPlan', index:'fechaFinPlan', width:40, jsonmap: 'fechaFinPlan'},
		          {name: 'fechaIniReal', index:'fechaIniReal', width:42, jsonmap: 'fechaIniReal'},
		          {name: 'fechaFinReal', index:'fechaFinReal', width:40, jsonmap: 'fechaFinReal'},
		],
		rowNum: 10,
		rowList: [5,10,15],
		pager: '#pager',
		sortname: 'nombreFase',
		viewrecords: true, 
		sortorder: 'nombreFase', 
		caption: 'Fases del proceso',
		width: 600,
		height: 175
			
	});
	jQuery("#fasesList").jqGrid('navGrid','#pager',{edit:false,add:false,del:false});
}

function deleteData(){
	var formData = "idEstado=" + $("#idEstado").val();

	var answer = confirm("Está seguro que quiere eliminar el registro: "+ $("#txtRecords").val()+ " ?");

	if (answer){		
		$.ajax({				
			type: "POST",
			url:  "index.php/estado/statusDelete",
			data: formData,
			dataType : "json",
			success: function(retrievedData){
				if(retrievedData.status != 0){
					alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
				}
				else{
					alert("Registro eliminado con éxito");
					procesoAutocomplete();	        		
					clear();
				}
			}

		});		
	}	
}

function cancel(){
	clear();
}

function clear(){
	$(".inputField").val("");
	$(".hiddenId").val("");
	$("#txtRecords").val("");
}
