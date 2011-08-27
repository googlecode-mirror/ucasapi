/**
 * 
 */

$(document).ready(function() {
	$('.divActions').addClass("ui-corner-all");
	$('.divDataForm').addClass("ui-corner-all");
	$('.container').addClass("ui-corner-bottom");
	$("button").button({
		icons : {
			primary : "ui-icon-locked"
		}
	});
	tipoAutocomplete();
	
	$("#txtSearch").focus(function(){$("#txtSearch").autocomplete('search', '');});
});

function tipoAutocomplete() {
	$.ajax({
		type : "POST",
		url : "index.php/tipoEstado/tipoAutocompleteRead",
		data : "tipoAutocomplete",
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				alert("Mensaje de error: " + retrievedData.msg);
			} else {
				$("#txtSearch").autocomplete({
					minChars : 0,
					source : retrievedData.data,
					minLength : 0,
					select : function(event, ui) {
						$("#idTipo").val(ui.item.id);
					},
					//Esto es para el esperado mustMatch o algo parecido
					change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtSearch").val())){
							$("#txtSearch").val("");
							$("#idTipo").val("");
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
		formData += "idTipo=" + $("#idTipo").val();
		formData += "&nombreTipo=" + $("#txtTipoName").val();
		formData += "&accionActual=" + $("#accionActual").val();
		$.ajax({
			type : "POST",
			url : "index.php/tipoEstado/tipoValidateAndSave",
			data : formData,
			dataType : "json",
			success : function(retrievedData) {
				if (retrievedData.status != 0) {
					alert("Mensaje de error: " + retrievedData.msg);
				} else {
					if ($("#accionActual").val() == "") {
						msgBoxSucces("Tipo agregada con &eacute;xito");
					} else {
						msgBoxSucces("Tipo actualizada con &eacute;xito");
					}
					tipoAutocomplete();
					clear();

				}
			}

		});
	}
}

function deleteData() {
	if ($("#txtSearch").val() != "" && $("#idTipo").val() != "") {
		var formData = "idTipo=" + $("#idTipo").val();
		$.ajax({
			type : "POST",
			url : "index.php/tipoEstado/tipoDelete",
			data : formData,
			dataType : "json",
			success : function(retrievedData) {
				if (retrievedData.status != 0) {
					alert("Mensaje de error: " + retrievedData.msg);
				} else {
					msgBoxSucces("Tipo de estado eliminado con &eacute;xito");
					tipoAutocomplete();
					clear();
				}
			}
		});
	} else {
		msgBoxInfo("Debe seleccionar un TIPO DE ESTADO a eliminar");
	}

}

function edit() {
	if ($("#txtSearch").val() != "" && $("#idTipo").val() != "") {
		lockAutocomplete();
		var formData = "idTipo=" + $("#idTipo").val();
		$("#accionActual").val("editando");
		$.ajax({
			type : "POST",
			url : "index.php/tipoEstado/tipoRead",
			data : formData,
			dataType : "json",
			success : function(retrievedData) {
				if (retrievedData.status != 0) {
					alert("Mensaje de error: " + retrievedData.msg);
				} else {
					$("#txtTipoName").val(retrievedData.data.nombreTipoEstado);
				}
			}
		});
	} else {
		msgBoxInfo("Debe seleccionar un TIPO DE ESTADO a editar");
	}

}

function cancel(){
	clear();
}

function clear() {
	$(".inputField").val("");
	$(".hiddenId").val("");
	$("#txtSearch").val("");
	unlockAutocomplete();
}

function validarCampos() {

	var camposFallan = "";
	if ($("#txtTipoName").val() != "") {
		if (!validarAlfaEsp($("#txtTipoName").val())) {
			camposFallan += "El campos NOMBRE contiene caracteres invalidos <br />";
		}
	} else {
		camposFallan += "El campo NOMBRE es requerido <br />";
	}

	if (camposFallan == "") {
		return true;
	} else {
		msgBoxInfo(camposFallan);
		return false;
	}

}


/* OTRAS FUNCIONES DE VALIDACION Y LOCKING*/
function lockAutocomplete() {	
	$("#txtSearch").attr("disabled", true);	
	$("#txtSearch").css({"background-color": "DBEBFF"});		
}

function unlockAutocomplete() {
	$("#txtSearch").attr("disabled", false);
	$("#txtSearch").css({"background-color": "FFFFFF"});	
}
