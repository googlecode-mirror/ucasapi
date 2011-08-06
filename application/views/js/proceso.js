
$(document).ready(function(){
	procesoProyectoAutocomplete();
	procesoEstadoAutocomplete();
	$("#idProceso").val("0");
	loadGrid("0");
});	

function procesoAutocomplete($idProyecto){
	$.ajax({				
		type: "POST",
		url:  "index.php/proceso/procesoAutocompleteRead/" + $idProyecto,
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
						procesoAutocomplete($("#idProyecto").val());
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
		url:  "index.php/proceso/procesoEstadoAutocompleteRead/3",
		data: "procesoEstadoAutocomplete",
		dataType : "json",
		success: function(retrievedData){        	 
			options = '<option value="">--Estado--</option>';
			$.each(retrievedData.data, function(i,obj) {
				options += '<option value="' + obj.id + '">' + obj.value + '</option>';
			});			
			$("#cbEstado").html(options);
			
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
				procesoProyectoAutocomplete();
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
				$("#cbEstado").val(retrievedData.data.idEstado);
				$("#txtProcesoDesc").val(retrievedData.data.descripcion);
				$("#txtProyectoName").val(retrievedData.data.nombreProyecto)
				$("#tablaFases").GridUnload();
				loadGrid();
			}			      
		}      
	});
}

function loadGrid($idProceso){

	$("#tablaFases").jqGrid(
			{
				url : "index.php/proceso/gridFasesProceso/" + $("#idProceso").val(),
				datatype : "json",
				mtype : "POST",
				colNames : [ "Nombre", "Fecha Inicial Plan.", "Fecha Fin Plan.", "Fecha Inicial Real", "Fecha Fin Real" ],
				colModel : [ {
					name : "nombreFase",
					index : "nombreFase",
					width : 180
				}, {
					name : "fechaIniPlan",
					index : "fechaIniPlan",
					width : 120,
					editable : true
				}, {
					name : "fechaFinPlan",
					index : "fechaFinPlan",
					width : 120,
					editable : true
				}, {
					name : "fechaIniReal",
					index : "fechaIniReal",
					width : 120,
					editable : true
				}, {
					name : "fechaFinReal",
					index : "fechaFinReal",
					width : 120,
					editable : true
				}],
				pager : "#pager",
				rowNum : 10,
				rowList : [ 10, 20, 30 ],
				sortname : "id",
				sortorder : "desc",
				ajaxGridOptions: {cache: false},
				loadonce : false,
				viewrecords : true,
				gridview : true,
				caption : "Fases del proceso"
			});
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

function editDate(){
	jQuery("#tablaFases").jqGrid('editRow',$("#tablaFases").jqGrid('getGridParam','selrow')); 
	this.disabled = 'true'; 
	jQuery("#btnCancelEd").attr("disabled",false);
}

function cancelEdit(){
	jQuery("#tablaFases").jqGrid('restoreRow',$("#tablaFases").jqGrid('getGridParam','selrow')); 
	jQuery("#btnCancelEd").attr("disabled",true); 
	jQuery("#btnEdit").attr("disabled",false);
	
}

function cancel(){
	clear();
}

function clear(){
	$(".inputFieldAC").val("");
	$(".inputFieldTA").val("");
	$(".hiddenId").val("");
	$("#txtRecords").val("");
}
