$(document).ready(function() {
	js_ini();
	// $("#chkUsuarioActivo").button();
	usuarioAutocomplete();
	usuarioCargoAutocomplete();
	usuarioDepartamentoAutocomplete()
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

function usuarioDepartamentoAutocomplete() {
	$.ajax({
		type : "POST",
		url : "index.php/usuario/usuarioDepartamentoAutocompleteRead",
		data : "usuarioDepartamentoAutocomplete",
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
				$("#txtUsuarioDepartamento").autocomplete({
					minChars : 0,
					source : retrievedData.data,
					minLength : 1,
					select : function(event, ui) {
						$("#idDepto").val(ui.item.id);
					}
				});

			}
		}

	});
}

function usuarioCargoAutocomplete() {
	$.ajax({
		type : "POST",
		url : "index.php/usuario/usuarioCargoAutocompleteRead",
		data : "usuarioCargoAutocomplete",
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
				$("#txtUsuarioCargo").autocomplete({
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
	var formData = "";
	formData += "idUsuario=" + $("#idUsuario").val();
	formData += "&codEmp=" + $("#txtUsuarioCodigo").val();
	formData += "&primerNombre=" + $("#txtUsuarioPrimerNombre").val();
	formData += "&otrosNombres=" + $("#txtUsuarioOtrosNombres").val();
	formData += "&primerApellido=" + $("#txtUsuarioPrimerApellido").val();
	formData += "&otrosApellidos=" + $("#txtUsuarioOtrosApellidos").val();
	formData += "&username=" + $("#txtUsuarioUserName").val();
	formData += "&password=" + $("#txtUsuarioPassword").val();
	formData += "&confirmacion=" + $("#txtUsuarioConfirmacion").val();
	formData += "&dui=" + $("#txtUsuarioDUI").val();
	formData += "&nit=" + $("#txtUsuarioNIT").val();
	formData += "&isss=" + $("#txtUsuarioISSS").val();
	formData += "&nup=" + $("#txtUsuarioNUP").val();
	formData += "&emailPersonal=" + $("#txtUsuarioEmailPersonal").val();
	formData += "&emailInstitucional="
			+ $("#txtUsuarioEmailInstitucional").val();
	formData += "&carnet=" + $("#txtUsuarioCarnet").val();
	formData += "&idCargo=" + $("#idCargo").val();
	formData += "&idDepto=" + $("#idDepto").val();

	if ($("#chkUsuarioActivo").is(':checked')) {
		alert('ACTIVO');
		formData += "&activo=1";
	} else {
		alert('INACTIVO');
		formData += "&activo=0";
	}

	alert(formData);

	if (validar_campos()) {

		$.ajax({
			type : "POST",
			url : "index.php/usuario/usuarioValidateAndSave",
			data : formData,
			dataType : "json",
			success : function(retrievedData) {
				if (retrievedData.status != 0) {
					msgBoxInfo(retrievedData.msg);
					// alert("Mensaje de error: " + retrievedData.msg); //Por el
					// momento, el mensaje que se está mostrando es técnico,
					// para
					// cuestiones de depuración
				} else {
					if ($("#idUsuario").val() == "") {

						/*
						 * msgBoxSucces("<p>Registro agregado con éxito</p>");
						 * alert("Registro agregado con éxito");
						 */

						msgBoxSucces("Registro agregado con éxito");

					} else {
						msgBoxSucces("Registro actualizado con éxito");
						alert("Registro actualizado con éxito");
					}
					usuarioAutocomplete();
					usuarioCargoAutocomplete();
					usuarioDepartamentoAutocomplete()
					clear();
				}
			}

		});

	}

}

function edit() {
	var formData = "idUsuario=" + $("#idUsuario").val();

	$.ajax({
		type : "POST",
		url : "index.php/usuario/usuarioRead",
		data : formData,
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
				$("#txtUsuarioCodigo").val(retrievedData.data.codEmp);
				$("#txtUsuarioPrimerNombre").val(
						retrievedData.data.primerNombre);
				$("#txtUsuarioOtrosNombres").val(
						retrievedData.data.otrosNombres);
				$("#txtUsuarioPrimerApellido").val(
						retrievedData.data.primerApellido);
				$("#txtUsuarioOtrosApellidos").val(
						retrievedData.data.otrosApellidos);
				$("#txtUsuarioUserName").val(retrievedData.data.username);
				$("#txtUsuarioPassword").val(retrievedData.data.password);
				$("#txtUsuarioConfirmar").val(retrievedData.data.password);
				$("#txtUsuarioDUI").val(retrievedData.data.dui);
				$("#txtUsuarioNIT").val(retrievedData.data.nit);
				$("#txtUsuarioISSS").val(retrievedData.data.isss);
				$("#txtUsuarioNUP").val(retrievedData.data.nup);
				$("#txtUsuarioDepartamento")
						.val(retrievedData.data.nombreDepto);
				$("#txtUsuarioCargo").val(retrievedData.data.nombreCargo);
				$("#txtUsuarioCarnet").val(retrievedData.data.carnet);
				$("#txtUsuarioEmailPersonal").val(
						retrievedData.data.emailPersonal);
				$("#txtUsuarioEmailInstitucional").val(
						retrievedData.data.emailInstitucional);
				$("#txtUsuarioExtension").val(retrievedData.data.extension);
				$("#idDepto").val(retrievedData.data.idDepto);
				$("#idCargo").val(retrievedData.data.idCargo);
				alert(retrievedData.data.activo);
				if(retrievedData.data.activo == '1'){
					alert('ACTIVO');
					$("#chkUsuarioActivo").attr('checked', true);
				} else {
					alert('INACTIVO');
					$("#chkUsuarioActivo").attr('checked', false);
				}
			}
		}
	});

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

					departmentAutocomplete();
					clear();
				}
			}

		});
	}
}

function validar_campos() {

	if ($("#txtUsuarioPassword").val() == ""
			|| $("#txtUsuarioConfirmar").val() == "") {
		alert("Complete la Contraseñas");
		return (false);
	}
	if ($("#txtUsuarioPassword").val() < 4) {
		alert("La contraseña debe ser mayor de 4 digitos")
		return (false);
	}

	if ($("#txtUsuarioConfirmar").val() == "") {
		alert("Debe confirmar la contraseña");
		return (false);
	}

	if ($("#txtUsuarioPassword").val() != $("#txtUsuarioConfirmar").val()) {
		alert("La contraseña confirmada no concuerda con la contraseña escrita");
		return (false);
	}

	return (true)
}

function cancel() {
	// $("#btnCancel").toggleClass('ui-state-active');
	clear();
	$("#msgBox").hide();
}

function clear() {
	$(".inputField").val("");
	$(".hiddenId").val("");
	$("#txtRecords").val("");
}

$("#chkUsuarioActivo").change(function() {
	alert('Handler for .change() called.');
});
