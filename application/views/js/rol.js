$(document).ready(function() {
	js_ini();
	$("#rolButton").addClass("highlight");
	rolAutocomplete();
});

function rolAutocomplete() {
	$.ajax({
		type : "POST",
		url : "index.php/rol/rolAutocompleteRead",
		data : "rolAutocomplete",
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				msgBoxSucces("Ocurrio un problema: " + retrievedData.msg);
			} else {
				$("#txtRecords").autocomplete({
					minChars : 0,
					source : retrievedData.data,
					minLength : 1,
					select : function(event, ui) {
						$("#idRol").val(ui.item.id);
					}
				});

			}
		}

	});
}

function save() {
	var formData = "";

	if (validarCampos()) {
		formData += "idRol=" + $("#idRol").val();
		formData += "&nombreRol=" + $("#txtRolName").val();

		$.ajax({
			type : "POST",
			url : "index.php/rol/rolValidateAndSave",
			data : formData,
			dataType : "json",
			success : function(retrievedData) {
				if (retrievedData.status != 0) {
					msgBoxSucces("Ocurrio un problema: " + retrievedData.msg);
				} else {
					if ($("idRol").val() == "") {
						msgBoxSucces("Registro agregado con &eacute;xito");
					} else {
						msgBoxSucces("Registro actualizado con &eacute;xito");
					}
					rolAutocomplete();
					clear();
				}
			}

		});
	}
}

function edit() {
	if ($("#txtRecords").val() != "") {
		$("#accionActual").val("editando");
		var formData = "idRol=" + $("#idRol").val();
		$.ajax({
			type : "POST",
			url : "index.php/rol/rolRead",
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
					// est�
					// mostrando
					// es
					// t�cnico,
					// para
					// cuestiones
					// de
					// depuraci�n
				} else {
					$("#txtRolName").val(retrievedData.data.nombreRol);
				}
			}
		});
	} else {
		msgBoxInfo("Debe seleccionar un ROL a editar");
	}

}

function deleteData() {
	if ($("#txtRecords").val() != "") {
		var formData = "idRol=" + $("#idRol").val();
		var answer = confirm("Est&aacute; seguro que quiere eliminar el registro: "
				+ $("#txtRecords").val() + " ?");

		if (answer) {
			$.ajax({
				type : "POST",
				url : "index.php/rol/rolDelete",
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
						// est�
						// mostrando
						// es
						// t�cnico,
						// para
						// cuestiones
						// de
						// depuraci�n
					} else {
						msgBoxSucces("Registro eliminado con &eacute;xito");
						rolAutocomplete();
						clear();
					}
				}

			});
		}
	} else {
		msgBoxInfo("Debe seleccionar un ROL a eliminar");
	}
}

function cancel() {
	clear();
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
	if ($("#txtRolName").val() != "") {
		if (!validarAlfaEsp($("#txtRolName").val())) {
			camposFallan += "El campo NOMBRE contiene caracteres no permitidos <br/>";
		}
	} else {
		camposFallan += "El campo NOMBRE es requerido <br/>";
	}

	if (camposFallan == "") {
		return true;
	} else {
		msgBoxInfo(camposFallan);
		return false;
	}
}
