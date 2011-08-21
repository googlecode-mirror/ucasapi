$(document).ready(function() {
	js_ini();
	$("#estadoButton").addClass("highlight");
	statusAutocomplete();
	statusTypeAutocomplete();
});

function statusAutocomplete() {
	$.ajax({
		type : "POST",
		url : "index.php/estado/statusAutocompleteRead",
		data : "statusAutocomplete",
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				alert("Mensaje de error: " + retrievedData.msg); // Por el
				// momento,
				// el
				// mensaje
				// que se
				// está
				// mostrando
				// es
				// técnico,
				// para
				// cuestiones
				// de
				// depuración
			} else {
				$("#txtRecords").autocomplete({
					minChars : 0,
					source : retrievedData.data,
					minLength : 1,
					select : function(event, ui) {
						$("#idEstado").val(ui.item.id);
					}
				});

			}
		}

	});
}

function statusTypeAutocomplete() {
	$.ajax({
		type : "POST",
		url : "index.php/estado/statusTypeAutocompleteRead",
		data : "statusTypeAutocomplete",
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				alert("Mensaje de error: " + retrievedData.msg); // Por el
				// momento,
				// el
				// mensaje
				// que se
				// está
				// mostrando
				// es
				// técnico,
				// para
				// cuestiones
				// de
				// depuración
			} else {
				$("#txtStatusTypeName").autocomplete({
					minChars : 0,
					source : retrievedData.data,
					minLength : 1,
					select : function(event, ui) {
						$("#idTipoEstado").val(ui.item.id);
					}
				});

			}
		}

	});
}

function save() {
	if (validarCampos()) {
		var formData = "";
		formData += "idEstado=" + $("#idEstado").val();
		formData += "&idTipoEstado=" + $("#idTipoEstado").val();
		formData += "&estado=" + $("#txtStatusName").val();
		formData += "&accionActual=" + $("#accionActual").val();

		$.ajax({
			type : "POST",
			url : "index.php/estado/statusValidateAndSave",
			data : formData,
			dataType : "json",
			success : function(retrievedData) {
				if (retrievedData.status != 0) {
					alert("Mensaje de error: " + retrievedData.msg); // Por
																		// el
					// momento,
					// el
					// mensaje
					// que se
					// está
					// mostrando
					// es
					// técnico,
					// para
					// cuestiones
					// de
					// depuración
				} else {
					if ($("#accionActual").val() == "") {
						msgBoxInfo("Registro agregado con &eacute;xito");
					} else {
						msgBoxInfo("Registro actualizado con &eacute;xito");
					}
					statusAutocomplete();
					statusTypeAutocomplete();
					clear();
				}
			}

		});
	}

}

function edit() {
	var formData = "idEstado=" + $("#idEstado").val();
	if ($("#txtRecords").val() != "") {
		$("#accionActual").val("editando")
		$.ajax({
			type : "POST",
			url : "index.php/estado/statusRead",
			data : formData,
			dataType : "json",
			success : function(retrievedData) {
				if (retrievedData.status != 0) {
					alert("Mensaje de error: " + retrievedData.msg); // Por
					// el
					// momento,
					// el
					// mensaje
					// que se
					// está
					// mostrando
					// es
					// técnico,
					// para
					// cuestiones
					// de
					// depuración
				} else {
					$("#txtStatusName").val(retrievedData.data.estado);
					$("#txtStatusTypeName").val(
							retrievedData.data.nombreTipoEstado);
					$("#idTipoEstado").val(retrievedData.data.idTipoEstado);
				}
			}
		});
	} else {
		msgBoxInfo("Debe seleccionar un ESTADO a editar");
	}

}

function deleteData() {
	var formData = "idEstado=" + $("#idEstado").val();

	if ($("#txtRecords").val() != "") {

		var answer = confirm("Está seguro que quiere eliminar el registro: "
				+ $("#txtRecords").val() + " ?");

		if (answer) {
			$.ajax({
				type : "POST",
				url : "index.php/estado/statusDelete",
				data : formData,
				dataType : "json",
				success : function(retrievedData) {
					if (retrievedData.status != 0) {
						alert("Mensaje de error: " + retrievedData.msg); // Por
						// el
						// momento,
						// el
						// mensaje
						// que
						// se
						// está
						// mostrando
						// es
						// técnico,
						// para
						// cuestiones
						// de
						// depuración
					} else {
						msgBoxInfo("Registro eliminado con &eacute;xito");
						statusAutocomplete();
						clear();
					}
				}

			});
		}
	} else {
		msgBoxInfo("Debe seleccionar un ESTADO a eliminar");
	}
}

function cancel() {
	clear();
}

function clear() {
	$(".inputField").val("");
	$(".hiddenId").val("");
	$("#txtRecords").val("");
}

function validarCampos() {
	var camposFallan = "";
	if ($("#txtStatusName").val() != "") {
		if (!validarAlfaEsp($("#txtStatusName").val())) {
			camposFallan += "El campo NOMBRE contiene caracteres no validos <br/>";
		}
	} else {
		camposFallan += "El campo NOMBRE es requerido <br/>";
	}

	if ($("#txtStatusTypeName").val() != "") {
		if (!validarAlfaEsp($("#txtStatusTypeName").val())) {
			camposFallan += "El campo TIPO DE ESTADO contine caracteres no validos <br/>";
		}
	} else {
		camposFallan += "El campo TIPO DE ESTADO es requerido <br/>";
	}

	if (camposFallan == "") {
		return true;
	} else {
		msgBoxInfo(camposFallan);
		return false;
	}
}
