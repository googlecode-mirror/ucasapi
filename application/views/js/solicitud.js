$(document).ready(function() {
	js_ini();
	usuarioAutocomplete();
	llenarPrioridades();
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
				$("#txtRecords").autocomplete(
						{
							minChars : 0,
							matchContains : true,
							source : retrievedData.data,
							minLength : 1,
							select : function(event, ui) {
								// $("#idUsuario").val(ui.item.id);
								$("#cbxInteresados").append(
										'<option value="' + ui.item.id + '">'
												+ ui.item.value + '</option>');
							}
						});

			}
		}

	});
}

// HAY QUE CAMBIARLO DESPUES A 'PRIORIDAD'
function llenarPrioridades() {
	$.ajax({
		type : "POST",
		url : "index.php/solicitud/cargarPrioridades",
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				// msgBoxInfo(retrievedData.msg);
				alert("Mensaje de error: " + retrievedData.msg); // Por el
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
				$("#cbxPrioridades").html(retrievedData.data);
			}
		}

	});
}

function crearSolicitud() {
	var interesados = '';
	if (validarCampos()) {

		$('#cbxInteresados option').each(function(i, selected) {
			interesados += $(selected).val() + ",";
		});

		interesados = interesados.substr(0, interesados.length - 1);

		var formData = "";
		formData += "asunto=" + $("#txtSolicitudAsunto").val();
		formData += "&prioridad=" + $("#cbxPrioridades").val();
		formData += "&descripcion=" + $("#txtSolicitudDesc").val();
		formData += "&observadores=" + interesados;

		$.ajax({
			type : "POST",
			url : "index.php/solicitud/solicitudSave",
			data : formData,
			dataType : "json",
			success : function(retrievedData) {
				if (retrievedData.status != 0) {
					msgBoxInfo(retrievedData.msg);
					// alert("Mensaje de error: " + retrievedData.msg); //Por el
					// momento, el mensaje que se est� mostrando es t�cnico,
					// para cuestiones de depuraci�n
				} else {

					msgBoxSucces("Solicitud creada con &eacute;xito");
					// alert("Registro actualizado con �xito");

					clear();
				}
			}

		});
	}
}

function remove() {
	$('#cbxInteresados option:selected').each(function(i, selected) {
		$(selected).remove();
	});
}

function clear() {
	$(".inputField").val("");
	$("#txtRecords").val("");
	$("#txtSolicitudDesc").val("");
	$("#cbxPrioridades").val(0);

	$('option', $("#cbxInteresados")).remove();

}

function validarCampos() {
	var camposFallan = "";

	if ($("#txtSolicitudAsunto").val() != "") {
		if (!validarAlfaEsp($("#txtSolicitudAsunto").val())) {
			camposFallan += "El campos ASUNTO contiene caracteres no validos <br />";
		}
	} else {
		camposFallan += "El campo ASUNTO es requerido <br />";
	}

	if ($("#cbxPrioridades").val() == 0) {
		camposFallan += "Debe seleccionar una PRIORIDAD <br />";
	}

	if ($("#txtSolicitudDesc").val() != "") {
		if ($("#txtSolicitudDesc").val().length > 256) {
			camposFallan += "Longutud de DESCRIPCION es mayor que 256 caracteres <br/>";
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