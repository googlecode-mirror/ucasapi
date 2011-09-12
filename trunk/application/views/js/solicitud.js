$(document).ready(function() {
	js_ini();
	$("#solicitudButton").addClass("highlight");
	$("#btnDelete").css("width", "160px");
	usuarioAutocomplete();
	llenarPrioridades();
	
	$("#txtRecords").focus(function(){$("#txtRecords").autocomplete('search', '');});
	$("#txtEndingDate").datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true , changeYear: true, yearRange: '1920:c+5'});
	
	if($("#edit").val() != "") {
		$.ajax({
			type : "POST",
			url : "/ucasapi/solicitud/getSolicitud",
			data : "idSolicitud=" + $("#edit").val(),
			dataType : "json",
			success : function(retrievedData) {
				if (retrievedData.status != 0) {
					msgBoxError(retrievedData.msg);
				} else {
					
					$("#txtSolicitudAsunto").val(retrievedData.data[0].titulo);
					$("#cbxPrioridades").attr("selectedIndex", retrievedData.data[0].prioridad);
					$("#txtEndingDate").val(retrievedData.data[0].fechaSalida.substring(0,10));
					$("#txtSolicitudDesc").val(retrievedData.data[0].descripcion);
					
					
					for (i = 1; i < retrievedData.data.length; i++) {
						$("#cbxInteresados").append(
								'<option value="' + retrievedData.data[i].idCliente + '">'
										+ retrievedData.data[i].cliente + '</option>');
					}
					
					
				}

			}

		});
	}
	
});

function usuarioAutocomplete() {
	$.ajax({
		type : "POST",
		url : "/ucasapi/usuario/usuarioSolicitudAutocompleteRead",
		data : "usuarioAutocomplete",
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				alert("Mensaje de error: " + retrievedData.msg); 
			} else {
				$("#txtRecords").autocomplete(
						{
							minChars : 0,
							matchContains : true,
							source : retrievedData.data,
							minLength : 0,
							select : function(event, ui) {
								// $("#idUsuario").val(ui.item.id);
								$("#cbxInteresados").append(
										'<option value="' + ui.item.id + '">'
												+ ui.item.value + '</option>');
								$("#txtRecords").val("");
							},
							//Esto es para el esperado mustMatch o algo parecido
							change :function(){
								if(!autocompleteMatch(retrievedData.data, $("#txtRecords").val())){
									$("#txtRecords").val("");									
								}
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
		url : "/ucasapi/solicitud/cargarPrioridades",
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				// msgBoxInfo(retrievedData.msg);
				alert("Mensaje de error: " + retrievedData.msg);
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
		formData += "&fechaFinEsperada=" + $("#txtEndingDate").val();
		formData += "&observadores=" + interesados;

		$.ajax({
			type : "POST",
			url : "index.php/solicitud/solicitudSave",
			data : formData,
			dataType : "json",
			success : function(retrievedData) {
				if (retrievedData.status != 0) {
					msgBoxInfo(retrievedData.msg);
				} else {
					msgBoxSucces("Solicitud creada con &eacute;xito");
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