$(document).ready(function() {
	js_ini();
	$("#prioridadButton").addClass("highlight");
	prioridadAutocomplete();
	
	$("#txtRecords").focus(function(){$("#txtRecords").autocomplete('search', '');});
});

function prioridadAutocomplete() {
	$.ajax({
		type : "POST",
		url : "index.php/prioridad/prioridadAutocompleteRead",
		data : "prioridadAutocomplete",
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				msgBoxSucces("Ocurrio un problema: " + retrievedData.msg);
			} else {
				$("#txtRecords").autocomplete({
					minChars : 0,
					source : retrievedData.data,
					minLength : 0,
					select : function(event, ui) {
						$("#idPrioridad").val(ui.item.id);
						$(this).blur();//Dedicado al IE
					},
					//Esto es para el esperado mustMatch o algo parecido
					change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtRecords").val())){
							$("#txtRecords").val("");
							$("#idPrioridad").val("");
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
		formData += "idPrioridad=" + $("#idPrioridad").val();
		formData += "&nombrePrioridad=" + $("#txtPrioridadName").val();
		formData += "&accionActual=" + $("#accionActual").val();

		$.ajax({
			type : "POST",
			url : "index.php/prioridad/prioridadValidateAndSave",
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
					prioridadAutocomplete();
					clear();
				}
			}

		});
	}
}

function edit() {
	if ($("#txtRecords").val() != "" && $("#idPrioridad").val() != "") {
		$("#accionActual").val("editando");
		lockAutocomplete();
		var formData = "idPrioridad=" + $("#idPrioridad").val();
		$.ajax({
			type : "POST",
			url : "index.php/prioridad/prioridadRead",
			data : formData,
			dataType : "json",
			success : function(retrievedData) {
				if (retrievedData.status != 0) {
					alert("Mensaje de error: " + retrievedData.msg);
				} else {
					$("#txtPrioridadName").val(retrievedData.data.nombrePrioridad);
				}
			}
		});
	} else {
		msgBoxInfo("Debe seleccionar una PRIORIDAD a editar");
	}

}

function deleteData() {
	if ($("#txtRecords").val() != "" && $("#idPrioridad").val() != "") {
		var formData = "idPrioridad=" + $("#idPrioridad").val();
		var answer = confirm("Est&aacute; seguro que quiere eliminar el registro: "
				+ $("#txtRecords").val() + " ?");

		if (answer) {
			$.ajax({
				type : "POST",
				url : "index.php/prioridad/prioridadDelete",
				data : formData,
				dataType : "json",
				success : function(retrievedData) {
					if (retrievedData.status != 0) {
						alert("Mensaje de error: " + retrievedData.msg);
					} else {
						msgBoxSucces("Registro eliminado con &eacute;xito");
						prioridadAutocomplete();
						clear();
					}
				}

			});
		}
	} else {
		msgBoxInfo("Debe seleccionar un PRIORIDAD a eliminar");
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
	if ($("#txtPrioridadName").val() != "") {
		if (!validarAlfaEsp($("#txtPrioridadName").val())) {
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