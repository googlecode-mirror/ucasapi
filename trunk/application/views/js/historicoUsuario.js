$(document).ready(function() {
	js_ini();
	// $("#chkUsuarioActivo").button();
	usuarioAutocomplete();
	loadGridUsuarioHistorico();
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

// grid donde estan todos los contratos de ese usuario
function loadGridUsuarioHistorico() {
	$("#usuarioHist").jqGrid(			{
				url : "index.php/historicoUsuario/gridContratoUsuarioRead/"+ $("#idUsuario").val(),
				datatype : "json",
				mtype : "POST",
				colNames : [ "Inicio contrato"/*, "Fin contrato","Tiempo contrato", "correlContrato","idUsuario" */],
				colModel : [ {
					name : "fechaInicioContrato",
					index : "fechaInicioContrato",
					width : 150
				}],/*, {
					name : "fechaFinContrato",
					index : "fechaFinContrato",
					width : 150
				}, {
					name : "tiempoContrato",
					index : "tiempoContrato",
					width : 80
				}, {
					name : "correlUsuarioHistorico",
					index : "correlUsuarioHistorico",
					width : 70
				}, {
					name : "idUsuario",
					index : "idUsuario",
					width : 70
				} ],*/
				pager : "#gridpagerUH",
				rowNum : 10,
				rowList : [ 10, 20, 30 ],
				sortname : "id",
				sortorder : "desc",
				// loadonce : true,
				viewrecords : true,
				gridview : true,
				caption : "Roles"
			});
	/*
	$("#usuarioHist").navGrid('#gridpagerUH', {
		edit : false,
		add : false,
		del : false,
		search : false,
		refresh : false
	}).navButtonAdd('#gridpagerUH', {
		caption : "",
		buttonicon : "ui-icon ui-icon-plusthick",
		onClickButton : function() {
			alert("Adding Row");
		},
		position : "last"
	}).navButtonAdd('#gridpagerUH', {
		caption : "",
		buttonicon : "ui-icon ui-icon-pencil",
		onClickButton : function() {
			alert("Editing Row");
		},
		position : "last"
	}).navButtonAdd('#gridpagerUH', {
		caption : "",
		buttonicon : "ui-icon ui-icon-trash",
		onClickButton : function() {
			alert("Deleting Row");
		},
		position : "last"
	}).navSeparatorAdd("#gridpagerUH", {});
	*/
}

function saveContrato() {
	var formData = "";
	formData += "idUsuario=" + $("#idUsuario").val();
	formData += "&accionActual=" + $("#accionActual").val();
	formData += "&fechaInicioContrato=" + $("#txtFechaInicioContrato").val();
	formData += "&fechaFinContrato=" + $("#txtFechaFinContrato").val();
	formData += "&tiempoContrato=" + $("#txtTiempoContrato").val();

	alert(formData);

	if (validarCampos()) {

		$.ajax({
			type : "POST",
			url : "index.php/historicoUsuario/historicoUsuarioValidateAndSave",
			data : formData,
			dataType : "json",
			success : function(retrievedData) {
				if (retrievedData.status != 0) {
					msgBoxInfo(retrievedData.msg);
				} else {
					if ($("#accionActual").val() == "") {

						msgBoxSucces("Registro agregado con éxito");

					} else {
						msgBoxSucces("Registro actualizado con éxito");
					}
					usuarioAutocomplete();
					clear();
				}
			}

		});

	}

}

function edit() {
	var formData = "idUsuario=" + $("#idUsuario").val();
	$("#usuarioHist").GridUnload();
	loadGridUsuarioHistorico();
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

					usuarioAutocomplete();
					usuarioCargoAutocomplete();
					usuarioDepartamentoAutocomplete()
					clear();
				}
			}

		});
	}
}

function cancel() {
	// $("#btnCancel").toggleClass('ui-state-active');
	clear();
	$("#msgBox").hide();
}

function clear() {
	$(".inputField").val("");
	$(".jqcalendario").val("");
	$(".hiddenId").val("");
	$("#txtRecords").val("");
	$("#chkUsuarioActivo").attr('checked', false);
}

function validarCampos() {
	return true;
}

function soloNumeros() {
	var key = window.event.keyCode;
	if (key < 48 || key > 57) {
		window.event.keyCode = 0;
	}
}

$("#chkUsuarioActivo").change(function() {
	alert('Handler for .change() called.');
});
