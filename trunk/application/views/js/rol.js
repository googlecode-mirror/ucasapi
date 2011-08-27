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
					},
					//Esto es para el esperado mustMatch o algo parecido
					change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtRecords").val())){
							$("#txtRecords").val("");
							$("#idRol").val("");
						}
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
		formData += "&accionActual=" + $("#accionActual").val();

		$.ajax({
			type : "POST",
			url : "index.php/rol/rolValidateAndSave",
			data : formData,
			dataType : "json",
			success : function(retrievedData) {
				if (retrievedData.status != 0) {
					msgBoxSucces("Ocurrio un problema: " + retrievedData.msg);
				} else {
					if ($("#accionActual").val() == "") {
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
	if ($("#txtRecords").val() != "" && $("#idRol").val() != "") {
		$("#accionActual").val("editando");
		lockAutocomplete();
		var formData = "idRol=" + $("#idRol").val();
		$.ajax({
			type : "POST",
			url : "index.php/rol/rolRead",
			data : formData,
			dataType : "json",
			success : function(retrievedData) {
				if (retrievedData.status != 0) {
					alert("Mensaje de error: " + retrievedData.msg);
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
	if ($("#txtRecords").val() != "" && $("#idRol").val() != "") {
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
						alert("Mensaje de error: " + retrievedData.msg);
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
	unlockAutocomplete();
}

function validarCampos() {
	var camposFallan = "";
	if ($("#txtRolName").val() != "") {
		if (!validarAlfaEsp($("#txtRolName").val())) {
			camposFallan += "<p><dd>El campo NOMBRE contiene caracteres no permitidos </dd><br/></p>";
		}
	} else {
		camposFallan += "<p><dd>El campo NOMBRE es requerido </dd><br/></p>";
	}

	if (camposFallan == "") {
		return true;
	} else {
		camposFallan = "Se encontraron los siguiente problemas: <br/>" + camposFallan;
		msgBoxInfo(camposFallan);
		return false;
	}
}


/* OTRAS FUNCIONES DE VALIDACION Y LOCKING*/
function lockAutocomplete() {	
	$("#txtRecords").attr("disabled", true);	
	$("#txtRecords").css({"background-color": "DBEBFF"});		
}

function unlockAutocomplete() {
	$("#txtRecords").attr("disabled", false);
	$("#txtRecords").css({"background-color": "FFFFFF"});	
}