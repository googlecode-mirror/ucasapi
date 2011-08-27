$(document).ready(function() {
	js_ini();
	$("#procesoButton").addClass("highlight");
	procesoProyectoAutocomplete();
	procesoEstadoAutocomplete();
	procesoFaseAutocomplete();
	$("#idProceso").val("0");
	if($("#idRol").val() != 1){	
		$("#btnSave").attr("disabled", true);
	}
	
	$("#txtRecordsProc").focus(function(){$("#txtRecordsProc").autocomplete('search', '');});
	$("#txtRecordsProy").focus(function(){$("#txtRecordsProy").autocomplete('search', '');});
	$("#txtRecordsProc").focus(function(){$("#txtRecordsProc").autocomplete('search', '');});
	$("#txtProyectoName").focus(function(){$("#txtProyectoName").autocomplete('search', '');});	

});

function procesoAutocomplete($idProyecto) {
	$.ajax({
		type : "POST",
		url : "index.php/proceso/procesoAutocompleteRead/" + $idProyecto,
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

function procesoProyectoAutocomplete() {
	$.ajax({
		type : "POST",
		url : "index.php/proyecto/proyectoAutocompleteRead",
		data : "procesoProyectoAutocomplete",
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				alert("Mensaje de error: " + retrievedData.msg);
			} else {
				$("#txtRecordsProy").autocomplete({
					minChars : 0,
					source : retrievedData.data,
					minLength : 0,
					select : function(event, ui) {
						$("#idProyecto").val(ui.item.id);
						procesoAutocomplete($("#idProyecto").val());
					},
					//Esto es para el esperado mustMatch o algo parecido
					change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtRecordsProy").val())){
							$("#txtRecordsProc").autocomplete("destroy");
							$("#txtRecordsProc").val("");
							$("#txtRecordsProy").val("");
							$("#idProyecto").val("0");
						}
					}
				});
				$("#txtProyectoName").autocomplete({
					minChars : 0,
					source : retrievedData.data,
					minLength : 0,
					select : function(event, ui) {
						$("#idProyecto").val(ui.item.id);
						procesoAutocomplete($("#idProyecto").val());
					},
					//Esto es para el esperado mustMatch o algo parecido
					change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtProyectoName").val())){
							$("#txtProyectoName").val("");
							$("#idProyecto").val("0");
						}
					}
				});

			}
		}

	});
}

function procesoFaseAutocomplete() {
	$.ajax({
		type : "POST",
		url : "index.php/fase/faseAutocompleteRead",
		data : "procesoFaseAutocomplete",
		dataType : "json",
		success : function(retrievedData) {
			options = '<option value="">Seleccione una fase</option>';
			$.each(retrievedData.data, function(i, obj) {
				options += '<option value="' + obj.id + '">' + obj.value
						+ '</option>';
			});
			$("#cbFases").html(options);

		}

	});
}

function procesoEstadoAutocomplete() {
	$.ajax({
		type : "POST",
		url : "index.php/proceso/procesoEstadoAutocompleteRead/2",
		data : "procesoEstadoAutocomplete",
		dataType : "json",
		success : function(retrievedData) {
			options = '<option value="">Seleccione un estado</option>';
			$.each(retrievedData.data, function(i, obj) {
				options += '<option value="' + obj.id + '">' + obj.value
						+ '</option>';
			});
			$("#cbEstado").html(options);

		}
	});
}

function save() {
	var formData = "";

	if (validarCampos()) {

		formData += "idProceso=" + $("#idProceso").val();
		formData += "&idProyecto=" + $("#idProyecto").val();
		formData += "&idFase=" + $("#cbFases").val();
		formData += "&idEstado=" + $("#cbEstado").val();
		formData += "&nombreProceso=" + $("#txtProcesoName").val();
		formData += "&descripcion=" + $("#txtProcesoDesc").val();

		proc_rows = $("#tablaFases").jqGrid("getRowData");
		var gridData = "";
		for ( var Elemento in proc_rows) {
			for ( var Propiedad in proc_rows[Elemento]) {
				if (Propiedad == "nombreFase" || Propiedad == "fechaIniPlan"
						|| Propiedad == "fechaFinPlan"
						|| Propiedad == "fechaIniReal"
						|| Propiedad == "fechaFinReal")
					gridData += proc_rows[Elemento][Propiedad] + "|";
			}
		}
		;
		formData += "&proc_data=" + gridData;

		$.ajax({
			type : "POST",
			url : "index.php/proceso/procesoValidateAndSave",
			data : formData,
			dataType : "json",
			success : function(retrievedData) {
				if (retrievedData.status != 0) {
					alert("Mensaje de error: " + retrievedData.msg);
				} else {
					if ($("idProceso").val() == "") {
						msgBoxSucces("Proceso agregado con \u00e9xito");
					} else {
						msgBoxSucces("Proceso actualizado con \u00e9xito");
					}
					procesoProyectoAutocomplete();
					procesoEstadoAutocomplete();
					clear();
				}
			}
		});
	}

}

function edit() {

	if ($("#txtRecordsProy").val() != "") {
		if ($("#txtRecordsProc").val() != "") {
			var formData = "idProceso=" + $("#idProceso").val();
			lockAutocomplete();
			$.ajax({
				type : "POST",
				url : "index.php/proceso/procesoRead",
				data : formData,
				dataType : "json",
				success : function(retrievedData) {
					if (retrievedData.status != 0) {
						alert("Mensaje de error: " + retrievedData.msg);
					} else {
						$("#txtProcesoName").val(
								retrievedData.data.nombreProceso);
						$("#cbEstado").val(retrievedData.data.idEstado);
						$("#txtProcesoDesc")
								.val(retrievedData.data.descripcion);
						$("#txtProyectoName").val(
								retrievedData.data.nombreProyecto)
						$("#cbFases").val(retrievedData.data.idFase);
					}
				}
			});
		}else{
			msgBoxInfo("Debe seleccionar un PROCESO a editar");
		}
	}else{
		msgBoxInfo("Debe seleccionar un PROYECTO al que pertenece el proceso");
	}

}

function addFase() {
	$("#tablaFases").jqGrid('addRowData', 0, {
		nombreFase : $("#cbFases :selected").text(),
		fechaIniPlan : '2011-01-01',
		fechaFinPlan : '2011-01-01',
		fechaIniReal : '2011-01-01',
		fechaFinReal : '2011-01-01'
	}, 'last')
}

function loadGrid($idProceso) {
	var lastsel;
	var fases = "";

	$.ajax({
		type : "POST",
		url : "index.php/proceso/procesoFaseRead",
		data : "fasesRetrieve",
		dataType : "json",
		async : false,
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				alert("Mensaje de error: " + retrievedData.msg);
			} else {
				$.each(retrievedData.data, function(i, obj) {
					fases += obj.id + ':' + obj.value + ';';
				});
				// fases = "";
				fases = fases.substring(0, fases.length - 1);
				$("#fasesString").val(fases);
			}
		}
	});
	fases = $("#fasesString").val();
	$("#tablaFases").jqGrid(
			{
				url : "index.php/proceso/gridFasesProceso/"
						+ $("#idProceso").val(),
				datatype : "json",
				mtype : "POST",
				colNames : [ "Cod.", "Nombre", "Fecha Inicial Plan.",
						"Fecha Fin Plan." ],
				colModel : [ {
					name : "idFase",
					index : "idFase",
					width : 0,
					hidden : true
				}, {
					name : "nombreFase",
					index : "nombreFase",
					editable : true,
					edittype : "select",
					editoptions : {
						value : fases
					},
					width : 180
				}, {
					name : "fechaIniPlan",
					index : "fechaIniPlan",
					width : 120,
					editable : true,
					editoptions : {
						size : 10
					},
					editrules : {
						date : true
					},
					formatter : 'date',
					formatoptions : {
						newformat : 'Y-m-d'
					}
				}, {
					name : "fechaFinPlan",
					index : "fechaFinPlan",
					width : 120,
					editable : true,
					editoptions : {
						size : 10
					},
					editrules : {
						date : true
					},
					formatter : 'date',
					formatoptions : {
						newformat : 'Y-m-d'
					}
				} ],
				pager : "#pager",
				rowNum : 10,
				rowList : [ 10, 20, 30 ],
				sortname : "id",
				sortorder : "desc",
				ajaxGridOptions : {
					cache : false
				},
				loadonce : true,
				viewrecords : true,
				gridview : true,
				editurl : "proceso",
				caption : "Fases del proceso"
			});
	jQuery("#tablaFases").jqGrid('navGrid', '#pager', {});
}

function pickdates(id) {
	jQuery("#" + id + "_fechaIniPlan", "#tablaFases").datepicker({
		dateFormat : "yy-mm-dd"
	});
}

function deleteData() {
	var formData = "idEstado=" + $("#idEstado").val();

	var answer = confirm("Est� seguro que quiere eliminar el registro: "
			+ $("#txtRecords").val() + " ?");

	if (answer) {
		$.ajax({
			type : "POST",
			url : "index.php/estado/statusDelete",
			data : formData,
			dataType : "json",
			success : function(retrievedData) {
				if (retrievedData.status != 0) {
					alert("Mensaje de error: " + retrievedData.msg);
				} else {
					alert("Registro eliminado con �xito");
					procesoAutocomplete();
					clear();
				}
			}

		});
	}
}

function editFase() {
	var gr = jQuery("#tablaFases").jqGrid('getGridParam', 'selrow');
	if (gr != null)
		jQuery("#tablaFases").jqGrid('editGridRow', gr, {
			height : 280,
			reloadAfterSubmit : false
		});
	else
		alert("Por favor seleccione una fila");
}

function cancelEdit() {
	jQuery("#tablaFases").jqGrid('restoreRow',
			$("#tablaFases").jqGrid('getGridParam', 'selrow'));
	jQuery("#btnCancelEd").attr("disabled", true);
	jQuery("#btnEdit").attr("disabled", false);

}

function isDate(string) { // string estar� en formato yyyy-mm-dd
	regExp = /^[0-9]{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])/;
	if (!regExp.test(string))
		return false;
	else
		return true;
}

function cancel() {
	clear();
}

function clear() {
	$(".inputFieldAC").val("");
	$(".inputFieldTA").val("");
	$(".hiddenId").val("");
	$("#cbEstado").val("--Estado--");
	$("#idProceso").val("0");
	$("#tablaFases").GridUnload();
	unlockAutocomplete();
	loadGrid();
}

function validarCampos() {
	var camposFallan = "";
	if ($("#txtProcesoName").val() != "") {
		if (!validarAlfaEspNum($("#txtProcesoName").val())) {
			camposFallan += "	El campo NOMBRE contiene caracteres no validos";
		}
	} else {
		camposFallan += "	El campo NOMBRE es requerido <br/>";
	}

	if ($("#cbEstado").val() == "") {
		camposFallan += "	Debe seleccionar un ESTADO <br />";
	}

	if ($("#cbFases").val() == "") {
		camposFallan += "	Debe seleccionar una FASE <br />";
	}

	if ($("#txtProcesoDesc").val() != "") {
		if ($("#txtProcesoDesc").val().length > 256) {
			camposFallan += "	El campo DESCRIPCION es mayor a 256 caracteres <br/>";
		}
	} else {
		camposFallan += "	El campo DESCRIPCION es requerido <br/>";
	}

	if (camposFallan == "") {
		camposFallan = "Se encontraron los siguientes problemas: <br/>"
		return true;
	} else {
		msgBoxInfo(camposFallan);
		return false;
	}
}

/* OTRAS FUNCIONES DE VALIDACION Y LOCKING */
function lockAutocomplete() {
	$("#btnSave").attr("disabled", false);
	$("#txtRecordsProy").attr("disabled", true);
	$("#txtRecordsProy").css({
		"background-color" : "DBEBFF"
	});

	$("#txtRecordsProc").attr("disabled", true);
	$("#txtRecordsProc").css({
		"background-color" : "DBEBFF"
	});
}

function unlockAutocomplete() {
	if($("#idRol").val() != 1){
		$("#btnSave").attr("disabled", true);
	}
	$("#txtRecordsProy").attr("disabled", false);
	$("#txtRecordsProy").css({
		"background-color" : "FFFFFF"
	});	
		
	$("#txtRecordsProc").attr("disabled", false);
	$("#txtRecordsProc").css({
		"background-color" : "FFFFFF"
	});
}