$(document).ready(function() {
	js_ini();
	$("#procesoButton").addClass("highlight");
	procesoProyectoAutocomplete();
	procesoEstadoAutocomplete();
	procesoFaseAutocomplete();
	$("#idProceso").val("0");
	// loadGrid("0");
});

function procesoAutocomplete($idProyecto) {
	$.ajax( {
		type : "POST",
		url : "index.php/proceso/procesoAutocompleteRead/" + $idProyecto,
		data : "statusAutocomplete",
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				alert("Mensaje de error: " + retrievedData.msg);
			} else {
				$("#txtRecordsProc").autocomplete( {
					minChars : 0,
					source : retrievedData.data,
					minLength : 1,
					select : function(event, ui) {
						$("#idProceso").val(ui.item.id);
					}
				});

			}
		}

	});
}

function procesoProyectoAutocomplete() {
	$.ajax( {
		type : "POST",
		url : "index.php/proyecto/proyectoAutocompleteRead",
		data : "procesoProyectoAutocomplete",
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				alert("Mensaje de error: " + retrievedData.msg);
			} else {
				$("#txtRecordsProy").autocomplete( {
					minChars : 0,
					source : retrievedData.data,
					minLength : 1,
					select : function(event, ui) {
						$("#idProyecto").val(ui.item.id);
						procesoAutocomplete($("#idProyecto").val());
					}
				});
				$("#txtProyectoName").autocomplete( {
					minChars : 0,
					source : retrievedData.data,
					minLength : 1,
					select : function(event, ui) {
						$("#idProyecto").val(ui.item.id);
						procesoAutocomplete($("#idProyecto").val());
					}
				});

			}
		}

	});
}

function procesoFaseAutocomplete() {
	$.ajax( {
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
	$.ajax( {
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
		formData += "&idFase=" + $("#idFase").val();
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

		$.ajax( {
			type : "POST",
			url : "index.php/proceso/procesoValidateAndSave",
			data : formData,
			dataType : "json",
			success : function(retrievedData) {
				if (retrievedData.status != 0) {
					alert("Mensaje de error: " + retrievedData.msg);
				} else {
					if ($("idProceso").val() == "") {
						alert("Registro agregado con éxito");
					} else {
						alert("Registro actualizado con éxito");
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
	var formData = "idProceso=" + $("#idProceso").val();
	if (validarCampos()) {
		$.ajax( {
			type : "POST",
			url : "index.php/proceso/procesoRead",
			data : formData,
			dataType : "json",
			success : function(retrievedData) {
				if (retrievedData.status != 0) {
					alert("Mensaje de error: " + retrievedData.msg);
				} else {
					$("#txtProcesoName").val(retrievedData.data.nombreProceso);
					$("#cbEstado").val(retrievedData.data.idEstado);
					$("#txtProcesoDesc").val(retrievedData.data.descripcion);
					$("#txtProyectoName")
							.val(retrievedData.data.nombreProyecto)
					$("#cbFases").val(retrievedData.data.idFase);
				}
			}
		});
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

	$.ajax( {
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
	jQuery("#" + id + "_fechaIniPlan", "#tablaFases").datepicker( {
		dateFormat : "yy-mm-dd"
	});
}

function deleteData() {
	var formData = "idEstado=" + $("#idEstado").val();

	var answer = confirm("Está seguro que quiere eliminar el registro: "
			+ $("#txtRecords").val() + " ?");

	if (answer) {
		$.ajax( {
			type : "POST",
			url : "index.php/estado/statusDelete",
			data : formData,
			dataType : "json",
			success : function(retrievedData) {
				if (retrievedData.status != 0) {
					alert("Mensaje de error: " + retrievedData.msg); 
				} else {
					alert("Registro eliminado con éxito");
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

function isDate(string) { // string estará en formato yyyy-mm-dd
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
	loadGrid();
}

function validarCampos() {
	var camposFallan = "";
	if ($("#txtProcesoName").val() != "") {
		if (!validarAlfaEspNum($("#txtProcesoName").val())) {
			camposFallan += "El campo NOMBRE contiene caracteres no permitidos";
		}
	} else {
		camposFallan += "El campo NOMBRE es requerido <br/>";
	}
	
	if ($("#cbEstado").val() == "") {
		camposFallan += "Debe seleccionar un ESTADO <br />";
	}
	
	if ($("#cbFases").val() == "") {
		camposFallan += "Debe seleccionar una FASE <br />";
	}
	
	if ($("#txtProcesoDesc").val() != "") {
		if ($("#txtProcesoDesc").val().length > 256) {
			camposFallan += "El campo DESCRIPCION es mayor a 256 caracteres <br/>";
		}
	} else {
		camposFallan += "El campo DESCRIPCION es requerido <br/>";
	}

	if (camposFallan == "") {
		return true;
	} else {
		msgBoxInfo(camposFallan);
		return false;
	}
}
