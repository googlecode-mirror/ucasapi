$(document).ready(function() {
	js_ini();
	$("#cargoButton").addClass("highlight");	
	cargoAutocomplete();
});

function cargoAutocomplete() {
	$.ajax({
		type : "POST",
		url : "index.php/cargo/cargoAutocompleteRead",
		data : "cargoAutocomplete",
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
						$("#idCargo").val(ui.item.id);
					}
				});

			}
		}

	});
}

function save() {
	if (validarCampos()) {
		var formData = "";
		formData += "idCargo=" + $("#idCargo").val();
		formData += "&nombreCargo=" + $("#txtCargoName").val();

		$.ajax({
			type : "POST",
			url : "index.php/cargo/cargoValidateAndSave",
			data : formData,
			dataType : "json",
			success : function(retrievedData) {
				if (retrievedData.status != 0) {
					msgBoxSucces("Ocurrio un problema: " + retrievedData.msg);
				} else {
					if ($("idCargo").val() == "") {
						msgBoxSucces("Registro agregado con &eacute;xito");
					} else {
						msgBoxSucces("Registro actualizado con &eacute;xito");
					}
					cargoAutocomplete();
					clear();
				}
			}

		});
	}
}

function edit() {
	if ($("#txtRecords").val() != "") {
		var formData = "idCargo=" + $("#idCargo").val();
		$.ajax({
			type : "POST",
			url : "index.php/cargo/cargoRead",
			data : formData,
			dataType : "json",
			success : function(retrievedData) {
				if (retrievedData.status != 0) {
					alert("Mensaje de error: " + retrievedData.msg);
				} else {
					$("#txtCargoName").val(retrievedData.data.nombreCargo);
				}
			}
		});
	} else {
		msgBoxInfo("Debe seleccionar un CARGO a editar");
	}

}

function deleteData() {
	if ($("#txtRecords").val() != "") {
		var formData = "idCargo=" + $("#idCargo").val();
		var answer = confirm("Est� seguro que quiere eliminar el registro: "
				+ $("#txtRecords").val() + " ?");

		if (answer) {
			$.ajax({
				type : "POST",
				url : "index.php/cargo/cargoDelete",
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
						cargoAutocomplete();
						clear();
					}
				}

			});
		}
	} else {
		msgBoxInfo("Debe seleccionar un CARGO a eliminar");
	}
}

function cancel() {
	clear();
}

function clear() {
	$(".inputField").val("");
	$(".hiddenId").val("");
	$("#txtRecords").val("");
	$("#spancargo").text("");
}

function validarCampos() {
	var camposFallan = "";
	if ($("#txtCargoName").val() != "") {
		if (!validarAlfaEsp($("#txtCargoName").val())) {
			camposFallan += "El campo NOMBRE contiene caracteres no validos <br/>";
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
