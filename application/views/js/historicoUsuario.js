$(document).ready(function() {
	js_ini();
	// $("#chkUsuarioActivo").button();
	usuarioAutocomplete();
	loadGridUsuarioHistorico();
});

function usuarioAutocomplete() {
	$.ajax({
		type : "POST",
		url : "index.php/usuario/usuarioAutocompleteRead",
		data : "usuarioAutocomplete",
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				alert("Mensaje de error: " + retrievedData.msg); // Por el

			} else {
				$("#txtRecords").autocomplete({
					minChars : 0,
					matchContains : true,
					source : retrievedData.data,
					minLength : 1,
					select : function(event, ui) {
						$("#idUsuario").val(ui.item.id);
					}
				});
			}
		}

	});
}

// grid donde estan todos los contratos de ese usuario
function loadGridUsuarioHistorico() {
	$("#usuarioHist").jqGrid(
			{
				url : "index.php/historicoUsuario/gridContratoUsuarioRead/"
						+ $("#idUsuario").val(),
				datatype : "json",
				mtype : "POST",
				colNames : [ "Inicio contrato", "Fin contrato",
						"Meses contrato", "CorrelContrato", "idUsuario" ],
				colModel : [ {
					name : "fechaInicioContrato",
					index : "fechaInicioContrato",
					width : 150
				}, {
					name : "fechaFinContrato",
					index : "fechaFinContrato",
					width : 150
				}, {
					name : "tiempoContrato",
					index : "tiempoContrato",
					width : 150
				}, {
					name : "correlUsuarioHistorico",
					index : "correlUsuarioHistorico",
					width : 150
				}, {
					name : "idUsuario",
					index : "idUsuario",
					width : 150
				} ],
				pager : "#gridpagerUH",
				rowNum : 10,
				rowList : [ 10, 20, 30 ],
				sortname : "fechaInicioContrato",
				sortorder : "desc",
				// loadonce : true,
				viewrecords : true,
				gridview : true,
				caption : "Contratos"
			});
}

function saveContrato() {
	var formData = "";
	formData += "idUsuario=" + $("#idUsuario").val();
	formData += "&accionActual=" + $("#accionActual").val();
	formData += "&fechaInicioContrato=" + $("#txtFechaInicioContrato").val();
	formData += "&fechaFinContrato=" + $("#txtFechaFinContrato").val();
	formData += "&tiempoContrato=" + $("#txtTiempoContrato").val();

	// alert(formData);

	if (validarCampos()) {
		modifyContrato();
		if ($("#idUsuario").val() != "") {
			$
					.ajax({
						type : "POST",
						url : "index.php/historicoUsuario/historicoUsuarioValidateAndSave",
						data : formData,
						dataType : "json",
						success : function(retrievedData) {
							if (retrievedData.status != 0) {
								msgBoxInfo(retrievedData.msg);
							} else {
								if ($("#accionActual").val() == "") {
									msgBoxSucces("Registro agregado con éxito");
									/* LIMPIANDO EL GRID */
									$('#usuarioHist')
											.setGridParam(
													{
														url : "index.php/historicoUsuario/gridContratoUsuarioRead/"
																+ -1
													}).trigger("reloadGrid");
								} else {
									msgBoxSucces("Registro actualizado con éxito");
								}
								usuarioAutocomplete();
								clear();
							}
						}

					});
		} else {
			msgBoxSucces("Debe seleccionar un usuario");
		}
	}
}

function modifyContrato() {	
	
	// insertando los valores en el otro grid
	if ($("#idRowEdit").val() != "") {
		// obteniendo los datos del row a editar para usar el IdUsuario y el correl
		row_data = $("#usuarioHist").jqGrid("getRowData", $("#idRowEdit").val());
		// borrando del grid el row a editar, este paso debe ir afuera
		$("#usuarioHist").delRowData($("#idRowEdit").val());

		
		num_rows = $("#usuarioHist").getGridParam("records");// Número de filas en el
		// grid
		new_row_data = {
				"fechaInicioContrato" : $("#txtFechaInicioContrato").val(),
				"fechaFinContrato" : $("#txtFechaFinContrato").val(),
				"tiempoContrato" : $("#txtTiempoContrato").val(),
				"correlUsuarioHistorico" : $row_data["correlUsuarioHistorico"],
				"idUsuario" : $row_data["idUsuario"]
		};
		$("#usuarioHist").addRowData(num_rows + 1, new_row_data);
	}

}

function edit() {
	var formData = "idUsuario=" + $("#idUsuario").val();
	$("#usuarioHist").GridUnload();
	loadGridUsuarioHistorico();
}

function editContrato() {
	// obteniendo el rol seleccionado del grid de todos los roles
	row_id = $("#usuarioHist").jqGrid("getGridParam", "selrow");
	row_data = $("#usuarioHist").jqGrid("getRowData", row_id);

	// insertando los valores del row seleccionado en los campos editables
	if (row_id != null) {
		$("#txtFechaInicioContrato").val(row_data["fechaInicioContrato"]);
		$("#txtFechaFinContrato").val(row_data["fechaFinContrato"]);
		$("#txtTiempoContrato").val(row_data["tiempoContrato"]);
		// persistir el ROW_ID que voy a editar
		$("#idRowEdit").val(row_id);
		$("#accionActual").val("editando");		
	}

}

function deleteData() {
	var formData = "idUsuario=" + $("#idUsuario").val();

	var answer = confirm("Está seguro que quiere eliminar el registro: "
			+ $("#txtRecords").val() + " ?");

	if (answer) {
		$.ajax({
			type : "POST",
			url : "index.php/usuario/usuarioDelete",
			data : formData,
			dataType : "json",
			success : function(retrievedData) {
				if (retrievedData.status != 0) {
					msgBoxInfo(retrievedData.msg);
					// alert("Mensaje de error: " + retrievedData.msg); //Por el
					// momento, el mensaje que se está mostrando es técnico,
					// para cuestiones de depuración
				} else {

					// msgBoxSucces("<p>Registro eliminado con éxito</p>");
					alert("Registro eliminado con éxito");

					msgBoxSucces("Registro eliminado con éxito");
					// alert("Registro eliminado con éxito");

					usuarioAutocomplete();
					usuarioCargoAutocomplete();
					usuarioDepartamentoAutocomplete()
					clear();
				}
			}

		});
	}
}

function cancel() {
	// $("#btnCancel").toggleClass('ui-state-active');
	clear();
	$("#msgBox").hide();
}

function clear() {
	$(".inputField").val("");
	$(".jqcalendario").val("");
	$(".hiddenId").val("");
	$("#idRowEdit").val("");
	$("#txtRecords").val("");
	$("#txtTiempoContrato").val("");
	$("#chkUsuarioActivo").attr('checked', false);
}

function validarCampos() {

	return true;
}

function soloNumeros() {
	var key = window.event.keyCode;
	if (key < 48 || key > 57) {
		window.event.keyCode = 0;
	}
}

$("#chkUsuarioActivo").change(function() {
	alert('Handler for .change() called.');
});
