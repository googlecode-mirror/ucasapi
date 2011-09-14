/**
 * 
 */

$(document).ready(function() {
	js_ini();
	actividadhProyectoAutocomplete();
	procesoNullProyectoAutocomplete();
	loadActividadNoProyProc();
	$("#actividadhButton").addClass("highlight");
	$("#idActividad").val("0");
	$("#txtRecordsProy").focus(function(){$("#txtRecordsProy").autocomplete('search', '');});
	$("#txtRecordsProc").focus(function(){$("#txtRecordsProc").autocomplete('search', '');});
	$("#txtRecordsAct").focus(function(){$("#txtRecordsAct").autocomplete('search', '');});
	ver();
});

function loadActividadNoProyProc() {
	$.ajax({
		type : "POST",
		url : "index.php/actividadh/actividadhNoProyProcActividades/",
		data : "proyectoAutocomplete",
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				msgBoxError("Ocurrio un problema: " + retrievedData.msg);				
			} else {
				$("#txtRecordsAct").autocomplete({
					minChars : 0,
					matchContains : true,
					source : retrievedData.data,
					minLength : 0,
					select : function(event, ui) {
						$("#idActividad").val(ui.item.id);
						$(this).blur();//Dedicado al IE
					},
					//Esto es para el esperado mustMatch o algo parecido
					change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtRecordsAct").val())){
							$("#txtRecordsAct").val("");
							$("#idActividad").val("");
						}
					}
				});

			}
		}

	});
}

function procesoNullProyectoAutocomplete(){
	$.ajax({
		type : "POST",
		url : "index.php/proceso/procesoNPAutocompleteRead",
		data : "statusAutocomplete",
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				alert("Mensaje de error: " + retrievedData.msg);
			} else {
				$("#txtRecordsProc").autocomplete({
					minChars : 0,
					source : retrievedData.data,
					minLength : 0,
					select : function(event, ui) {
						$("#idProceso").val(ui.item.id);
						$(this).blur();//Dedicado al IE
						loadActividadesProc($("#idProceso").val());
					},
					//Esto es para el esperado mustMatch o algo parecido
					change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtRecordsProc").val())){
							$("#txtRecordsProc").val("");
							$("#idProceso").val("0");
						}
					}
				});

			}
		}

	});
}

function actividadhProyectoAutocomplete(){
	$.ajax({
		type : "POST",
		url : "index.php/actividadh/actividadhAutocompleteRead/" + $("#idUsuario").val() + "/" + $("#idRol").val(),
		data : "proyectoAutocomplete",
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				msgBoxSucces("Ocurrio un problema: " + retrievedData.msg);				
			} else {
				$("#txtRecordsProy").autocomplete({
					minChars : 0,
					matchContains : true,
					source : retrievedData.data,
					minLength : 0,
					select : function(event, ui) {
						$("#idProyecto").val(ui.item.id);
						$(this).blur();//Dedicado al IE
						loadProceso($("#idProyecto").val());
						loadActividadesProy($("#idProyecto").val());
					},
					//Esto es para el esperado mustMatch o algo parecido
					change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtRecordsProy").val())){
							$("#txtRecordsProy").val("");
							$("#idProyecto").val("");
						}
					}
				});

			}

		}

	});
}

function loadProceso($idProyecto){
	$.ajax({
		type : "POST",
		url : "index.php/actividadh/actividadhProcAutocompleteRead/" + $idProyecto,
		data : "proyectoAutocomplete",
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				msgBoxSucces("Ocurrio un problema: " + retrievedData.msg);				
			} else {
				$("#txtRecordsProc").autocomplete({
					minChars : 0,
					matchContains : true,
					source : retrievedData.data,
					minLength : 0,
					select : function(event, ui) {
						$("#idProceso").val(ui.item.id);
						$(this).blur();//Dedicado al IE
						loadActividadesProc($("#idProceso").val());
					},
					//Esto es para el esperado mustMatch o algo parecido
					change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtRecordsProc").val())){
							$("#txtRecordsProc").val("");
							$("#idProceso").val("");
						}
					}
				});

			}

		}

	});
}

function loadActividadesProy($idProyecto){
	$.ajax({
		type : "POST",
		url : "index.php/actividadh/actividadhProyActividades/" + $idProyecto,
		data : "proyectoAutocomplete",
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				msgBoxError("Ocurrio un problema: " + retrievedData.msg);				
			} else {
				$("#txtRecordsAct").autocomplete({
					minChars : 0,
					matchContains : true,
					source : retrievedData.data,
					minLength : 0,
					select : function(event, ui) {
						$("#idActividad").val(ui.item.id);
						$(this).blur();//Dedicado al IE
					},
					//Esto es para el esperado mustMatch o algo parecido
					change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtRecordsAct").val())){
							$("#txtRecordsAct").val("");
							$("#idActividad").val("");
						}
					}
				});

			}
		}

	});
}


function loadActividadesProc($idProceso){
	$.ajax({
		type : "POST",
		url : "index.php/actividadh/actividadhProcActividades/" + $idProceso,
		data : "proyectoAutocomplete",
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				msgBoxError("Ocurrio un problema: " + retrievedData.msg);				
			} else {
				$("#txtRecordsAct").autocomplete({
					minChars : 0,
					matchContains : true,
					source : retrievedData.data,
					minLength : 0,
					select : function(event, ui) {
						$("#idActividad").val(ui.item.id);
						$(this).blur();//Dedicado al IE
					},
					//Esto es para el esperado mustMatch o algo parecido
					change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtRecordsAct").val())){
							$("#txtRecordsAct").val("");
							$("#idActividad").val("");
						}
					}
				});

			}
		}

	});
}

function ver(){
	var idActividad = $("#idActividad").val();
	
	$("#actividadBitacora").GridUnload();

	$("#actividadBitacora").jqGrid(
			{
				url : "index.php/actividadh/actividadhBitacora/" + idActividad,
				datatype : "json",
				mtype : "POST",
				colNames : [ "Usuario", "Comentario", "Progreso", "Estado", "Fecha Reg.", "Ultimo" ],
				colModel : [ {
					name : "nombre",
					index: "nombre",
					width: 150,
				}, {
					name : "comentario",
					index : "comentario",
					width : 350
				}, {
					name : "progreso",
					index : "progreso",
					width : 60,
				}, {
					name : "estado",
					index : "estado",
					width : 80,
				}, {
					name : "fechaReg",
					index : "fechaReg",
					width : 80,
				}, {
					name : "ultimoRegistro",
					index : "ultimoRegistro",
					width : 0,
					hidden : true
				}],
				pager : "#pager",
				rowNum : 10,
				rowList : [ 10, 20, 30 ],
				sortname : "id",
				sortorder : "desc",
				loadonce : false,
				viewrecords : true,
				gridview : false,
				width : 750,
				height : 400,
				caption : "Bitacora de la actividad"
			});
}

