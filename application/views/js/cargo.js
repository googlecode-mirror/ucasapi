$(document).ready(function() {
	js_ini();
	$("#cargoButton").addClass("highlight");	
	cargoAutocomplete();
	$("#txtRecords").focus(function(){$("#txtRecords").autocomplete('search', '');});	
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
					minLength : 0,
					select : function(event, ui) {
						$("#idCargo").val(ui.item.id);
						$(this).blur();//Dedicado al IE
					},
					//Esto es para el esperado mustMatch o algo parecido
					change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtRecords").val())){
							$("#txtRecords").val("");
							$("#idCargo").val("");
						}
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
		formData += "&accionActual=" + $("#accionActual").val();

		$.ajax({
			type : "POST",
			url : "index.php/cargo/cargoValidateAndSave",
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
					cargoAutocomplete();
					clear();
				}
			}

		});
	}
}

function edit() {
	if ($("#txtRecords").val() != "" && $("#idCargo").val() != "") {
		$("#accionActual").val("editando");
		lockAutocomplete();
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
	if ($("#txtRecords").val() != "" && $("#idCargo").val() != "") {
		var formData = "idCargo=" + $("#idCargo").val();
		var answer = confirm("Esta seguro que quiere eliminar el registro: "
				+ $("#txtRecords").val() + " ?");

		if (answer) {
			$.ajax({
				type : "POST",
				url : "index.php/cargo/cargoDelete",
				data : formData,
				dataType : "json",
				success : function(retrievedData) {
					if (retrievedData.status != 0) {
						alert("Mensaje de error: " + retrievedData.msg);
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
	unlockAutocomplete();
}

function validarCampos() {
	var camposFallan = "";
	if ($("#txtCargoName").val() != "") {
		if (!validarAlfaEsp($("#txtCargoName").val())) {
			camposFallan += "<p><dd>El campo NOMBRE contiene caracteres no validos </dd><br/></p>";
		}
	} else {
		camposFallan += "<p><dd>El campo NOMBRE es requerido </dd><br/></p>";
	}

	if (camposFallan == "") {
		return true;
	} else {
		camposFallan = "Se encontraron los siguientes problemas: <br/>" + camposFallan; 
		msgBoxInfo(camposFallan);
		return false;
	}
}

/* OTRAS FUNCIONES DE VALIDACION Y LOCKING */
function lockAutocomplete() {	
	$("#txtRecords").attr("disabled", true);	
	$("#txtRecords").css({"background-color": "DBEBFF"});		
}

function unlockAutocomplete() {
	$("#txtRecords").attr("disabled", false);
	$("#txtRecords").css({"background-color": "FFFFFF"});	
}
