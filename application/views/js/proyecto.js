$(document).ready(function() {
	js_ini();
	// $("#chkUsuarioActivo").button();
	proyectoAutocomplete();
	//proyectoUsuarioAutocomplete();
	proyectoUsuarioDuenhoAutocomplete();	
});

function proyectoAutocomplete() {
	$.ajax({
		type : "POST",
		url : "index.php/proyecto/proyectoAutocompleteRead",
		data : "proyectoAutocomplete",
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				alert("Mensaje de error: " + retrievedData.msg); // Por el
			} else {
				$("#txtRecords").autocomplete({
					minChars : 0,
					matchContains : true,
					source : retrievedData.data,
					minLength : 1,
					select : function(event, ui) {
						$("#idProyecto").val(ui.item.id);
					}
				});

			}
		}

	});
}

function proyectoUsuarioAutocomplete() {
	$.ajax({
		type : "POST",
		url : "index.php/proyecto/proyectoUsuarioAutocompleteRead",
		data : "proyectoUsuarioAutocomplete",
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				alert("Mensaje de error: " + retrievedData.msg);
			} else {
				$("#txtRecordsUsuario").autocomplete({
					minChars : 0,
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

function proyectoUsuarioDuenhoAutocomplete() {
	$.ajax({
		type : "POST",
		url : "index.php/proyecto/proyectoUsuarioAutocompleteRead",
		data : "proyectoUsuarioDuenhoAutocomplete",
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				alert("Mensaje de error: " + retrievedData.msg);
			} else {
				$("#txtProyectoNombreDuenho").autocomplete({
					minChars : 0,
					source : retrievedData.data,
					minLength : 1,
					select : function(event, ui) {
						$("#idUsuarioDuenho").val(ui.item.id);
					}
				});

			}
		}

	});
}


function save() {
	var formData = "";
	formData += "idProyecto=" + $("#idProyecto").val();
	formData += "&nombreProyecto=" + $("#txtProyectoNombre").val();
	formData += "&fechaPlanIni=" + $("#txtProyectoFechaPlanIni").val();
	formData += "&fechaPlanFin=" + $("#txtProyectoFechaPlanFin").val();
	formData += "&fechaRealIni=" + $("#txtProyectoFechaRealIni").val();
	formData += "&fechaRealFin=" + $("#txtProyectoFechaRealFin").val();
	formData += "&descripcion=" + $("#txtProyectoDescripcion").val();
	formData += "&idUsuarioDuenho=" + $("#idUsuarioDuenho").val();
	
	if ($("#chkProyectoActivo").is(':checked')) {
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
			url : "index.php/proyecto/proyectoValidateAndSave",
			data : formData,
			dataType : "json",
			success : function(retrievedData) {
				if (retrievedData.status != 0) {
					msgBoxInfo(retrievedData.msg);
				} else {
					if ($("#idProyecto").val() == "") {
						msgBoxSucces("Registro agregado con éxito");
					} else {
						msgBoxSucces("Registro actualizado con éxito");
						alert("Registro actualizado con éxito");
					}
					proyectoAutocomplete();
					proyectoUsuarioDuenhoAutocomplete();	
					clear();
				}
			}

		});

	}

}

function edit() {
	var formData = "idProyecto=" + $("#idProyecto").val();

	$.ajax({
		type : "POST",
		url : "index.php/proyecto/proyectoRead",
		data : formData,
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				alert("Mensaje de error: " + retrievedData.msg); // Por el

			} else {
				$("#txtProyectoNombre").val(retrievedData.data.nombreProyecto);
				$("#txtProyectoNombreDuenho").val(retrievedData.data.nombreUsuario);
				$("#txtProyectoFechaPlanIni").val(
						retrievedData.data.fechaPlanIni);
				$("#txtProyectoFechaPlanFin").val(
						retrievedData.data.fechaPlanFin);
				$("#txtProyectoFechaRealIni").val(
						retrievedData.data.fechaRealIni);
				$("#txtProyectoFechaRealFin").val(
						retrievedData.data.fechaRealFin);				
				$("#idUsuarioDuenho").val(retrievedData.data.idUsuario);
				if(retrievedData.data.activo == '1'){
					alert('ACTIVO');
					$("#chkProyectoActivo").attr('checked', true);
				} else {
					alert('INACTIVO');
					$("#chkProyectoActivo").attr('checked', false);
				}
			}
		}
	});

}

function deleteData() {
	var formData = "idProyecto=" + $("#idProyecto").val();

	var answer = confirm("Está seguro que quiere eliminar el registro: "
			+ $("#txtRecords").val() + " ?");

	if (answer) {
		$.ajax({
			type : "POST",
			url : "index.php/proyecto/proyectoDelete",
			data : formData,
			dataType : "json",
			success : function(retrievedData) {
				if (retrievedData.status != 0) {
					msgBoxInfo(retrievedData.msg);

				} else {

					msgBoxSucces("Registro eliminado con éxito");

					proyectoAutocomplete();
					proyectoUsuarioAutocomplete();	
					clear();
				}
			}

		});
	}
}

function validar_campos() {	
	// aqui poner las validaciones
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
