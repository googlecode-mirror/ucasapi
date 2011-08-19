$(document).ready(function() {
	js_ini();
	$("#historicoUsuarioButton").addClass("highlight");
	$("#roles").hide();
	usuarioAutocomplete();
	usuarioRolAutocomplete();
	loadGridUsuarioHistorico();
	loadGridRolHistorico();
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

function usuarioRolAutocomplete() {
	$.ajax({
		type : "POST",
		url : "index.php/usuario/usuarioRolAutocompleteRead",
		data : "usuarioRolAutocomplete",
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				alert("Mensaje de error: " + retrievedData.msg);
			} else {
				$("#txtHistoricoRol").autocomplete({
					minChars : 0,
					source : retrievedData.data,
					minLength : 1,
					select : function(event, ui) {
						$("#idRol").val(ui.item.id);
					}
				});

			}
		}

	});
}

// grid donde estan todos los contratos de ese usuario
function loadGridUsuarioHistorico() {
	$("#usuarioHist").jqGrid(
			{
				url : "index.php/historicoUsuario/gridContratoUsuarioRead/"
						+ $("#idUsuario").val(),
				datatype : "json",
				mtype : "POST",
				colNames : [ "Inicio contrato", "Fin contrato",
						"Meses contrato", "CorrelContrato", "idUsuario" ],
				colModel : [ {
					name : "fechaInicioContrato",
					index : "fechaInicioContrato",
					width : 150
				}, {
					name : "fechaFinContrato",
					index : "fechaFinContrato",
					width : 150
				}, {
					name : "tiempoContrato",
					index : "tiempoContrato",
					width : 150
				}, {
					name : "correlUsuarioHistorico",
					index : "correlUsuarioHistorico",
					width : 50,
					hidden : true
				}, {
					name : "idUsuario",
					index : "idUsuario",
					width : 50,
					hidden : true
				} ],
				pager : "#gridpagerUH",
				rowNum : 10,
				rowList : [ 10, 20, 30 ],
				sortname : "fechaInicioContrato",
				sortorder : "desc",
				// loadonce : true,
				viewrecords : true,
				gridview : true,
				caption : "Contratos"
			});
}

// grid donde estan todos los roles de un usuario para un determinado contrato
function loadGridRolHistorico() {
	$("#rolesHist").jqGrid(
			{
				url : "index.php/historicoUsuario/gridContratoRolRead/"
						+ $("#idUsuario").val() + "/"
						+ $("#correlUsuarioHistorico").val(),
				datatype : "json",
				mtype : "POST",
				colNames : [ "Ejercido desde", "Hasta", "Salario", "Rol",
						"idRolHistorico", "idUsuario", "CorrelContrato",
						"idRol" ],
				colModel : [ {
					name : "fechaInicio",
					index : "fechaInicio",
					width : 150
				}, {
					name : "fechaFin",
					index : "fechaFin",
					width : 150
				}, {
					name : "salario",
					index : "salario",
					width : 150
				}, {
					name : "nombreRol",
					index : "nombreRol",
					width : 150
				}, {
					name : "idRolHistorico",
					index : "idRolHistorico",
					width : 50,
					hidden : true
				}, {
					name : "idUsuario",
					index : "idUsuario",
					width : 50,
					hidden : true
				}, {
					name : "correlUsuarioHistorico",
					index : "correlUsuarioHistorico",
					width : 50,
					hidden : true
				}, {
					name : "idRol",
					index : "idRol",
					width : 50,
					hidden : true
				} ],
				pager : "#gridpagerRH",
				rowNum : 10,
				rowList : [ 10, 20, 30 ],
				sortname : "fechaInicio",
				sortorder : "desc",
				width : 550,
				// loadonce : true,
				viewrecords : true,
				gridview : true,
				caption : "Roles por contrato"
			});
}

function saveContrato() {

	if (validarCampos()) {
		var formData = "";
		formData += "idUsuario=" + $("#idUsuario").val();
		formData += "&correlUsuarioHistorico="
				+ $("#correlUsuarioHistorico").val();
		formData += "&accionActual=" + $("#accionActual").val();
		formData += "&fechaInicioContrato="
				+ $("#txtFechaInicioContrato").val();
		formData += "&fechaFinContrato=" + $("#txtFechaFinContrato").val();
		formData += "&tiempoContrato=" + $("#txtTiempoContrato").val();
		if ($("#idUsuario").val() != "") {
			if ($("#contratosPressed").val() == "yes") {
				$
						.ajax({
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
										/* LIMPIANDO EL GRID */
										$('#usuarioHist')
												.setGridParam(
														{
															url : "index.php/historicoUsuario/gridContratoUsuarioRead/"
																	+ $(
																			"#idUsuario")
																			.val()
														})
												.trigger("reloadGrid");
									} else {
										/* Recargando el grid */
										$('#usuarioHist')
												.setGridParam(
														{
															url : "index.php/historicoUsuario/gridContratoUsuarioRead/"
																	+ $(
																			"#idUsuario")
																			.val()
														})
												.trigger("reloadGrid");

										msgBoxSucces("Registro actualizado con éxito");
									}
									usuarioAutocomplete();
									clearSaveContrato();
								}
							}

						});
			} else {
				msgBoxSucces("Debe seleccionar la opcion \"CONTRATOS\" para este usuario");
			}
		} else {
			msgBoxSucces("Debe seleccionar un usuario");
		}
	}
}

function saveRol() {

	if (validarCamposRol()) {
		var formData = "";
		formData += "idUsuario=" + $("#idUsuario").val();
		formData += "&correlUsuarioHistorico="
				+ $("#correlUsuarioHistorico").val();
		formData += "&idRol=" + $("#idRol").val();
		formData += "&idRolHistorico=" + $("#idRolHistorico").val();
		formData += "&accionActualRol=" + $("#accionActualRol").val();
		formData += "&fechaInicio=" + $("#txtFechaInicioRol").val();
		formData += "&fechaFin=" + $("#txtFechaFinRol").val();
		formData += "&salario=" + $("#txtSalarioRol").val();

		if ($("#idUsuario").val() != "") {
			$
					.ajax({
						type : "POST",
						url : "index.php/historicoUsuario/historicoUsuarioRolValidateAndSave",
						data : formData,
						dataType : "json",
						success : function(retrievedData) {
							if (retrievedData.status != 0) {
								msgBoxInfo01(retrievedData.msg);
							} else {
								if ($("#accionActualRol").val() == "") {
									msgBoxSucces01("Rol agregado con éxito al contrato");
									/* LIMPIANDO EL GRID */
									$('#rolesHist')
											.setGridParam(
													{
														url : "index.php/historicoUsuario/gridContratoRolRead/"
																+ $(
																		"#idUsuario")
																		.val()
																+ "/"
																+ $(
																		"#correlUsuarioHistorico")
																		.val()
													}).trigger("reloadGrid");
								} else {
									msgBoxSucces01("Registro actualizado con éxito");
									/* Recargando el grid */
									$('#rolesHist')
											.setGridParam(
													{
														url : "index.php/historicoUsuario/gridContratoRolRead/"
																+ $(
																		"#idUsuario")
																		.val()
																+ "/"
																+ $(
																		"#correlUsuarioHistorico")
																		.val()
													}).trigger("reloadGrid");

								}
								usuarioAutocomplete();
								usuarioRolAutocomplete();
								clearSaveRol();
							}
						}

					});
		} else {
			msgBoxSucces01("Debe seleccionar un usuario");
		}
	}
}

function edit() {
	if ($("#idUsuario").val() != "") {
		$("#contratosPressed").val("yes");
		var formData = "idUsuario=" + $("#idUsuario").val();
		$("#usuarioHist").GridUnload();
		loadGridUsuarioHistorico();
	} else {
		msgBoxSucces("Debe seleccionar un usuario");
	}
}

function editContrato() {
	if ($("#idUsuario").val() != "" && $("#contratosPressed").val() == "yes") {
		$("#accionActual").val("editando_contrato")
		// obteniendo el rol seleccionado del grid de todos los roles
		row_id = $("#usuarioHist").jqGrid("getGridParam", "selrow");
		if (row_id != null) {
			row_data = $("#usuarioHist").jqGrid("getRowData", row_id);

			// insertando los valores del row seleccionado en los campos
			// editables
			if (row_id != null) {
				$("#txtFechaInicioContrato").val(
						row_data["fechaInicioContrato"]);
				$("#txtFechaFinContrato").val(row_data["fechaFinContrato"]);
				$("#txtTiempoContrato").val(row_data["tiempoContrato"]);
				$("#correlUsuarioHistorico").val(
						row_data["correlUsuarioHistorico"]);
				$("#idUsuario").val(row_data["idUsuario"]);
				$("#accionActualRol").val("editando");
			}
		} else {
			msgBoxSucces("Debe seleccionar un contrato a editar");
		}
	} else {
		msgBoxSucces("Debe seleccionar la opcion \"CONTRATOS\" para este usuario");
	}

}

function editRol() {
	if ($("#idUsuario").val() != "") {
		row_id = $("#rolesHist").jqGrid("getGridParam", "selrow");
		row_data = $("#rolesHist").jqGrid("getRowData", row_id);
		if (row_id != null) {
			$("#accionActualRol").val("editando");

			$("#txtFechaInicioRol").val(row_data["fechaInicio"]);
			$("#txtFechaFinRol").val(row_data["fechaFin"]);
			$("#txtSalarioRol").val(row_data["salario"]);
			$("#txtHistoricoRol").val(row_data["nombreRol"]);
			$("#correlUsuarioHistorico")
					.val(row_data["correlUsuarioHistorico"]);
			$("#idUsuario").val(row_data["idUsuario"]);
			$("#idRol").val(row_data["idRol"]);
			$("#idRolHistorico").val(row_data["idRolHistorico"]);
		} else {
			msgBoxSucces01("Debe seleccionar un rol a editar");
		}
	} else {
		msgBoxSucces01("Debe seleccionar un usuario");
	}
}

function deleteContrato() {
	if ($("#idUsuario").val() != "") {
		if ($("#contratosPressed").val() == "yes") {
			// obteniendo el rol seleccionado del grid de todos los roles
			row_id = $("#usuarioHist").jqGrid("getGridParam", "selrow");
			if (row_id != null) {
				row_data = $("#usuarioHist").jqGrid("getRowData", row_id);
				$("#correlUsuarioHistorico").val(
						row_data["correlUsuarioHistorico"]);
				$("#idUsuario").val(row_data["idUsuario"]);
				$("#accionActual").val("eliminando");

				var formData = "idUsuario=" + $("#idUsuario").val();
				formData += "&correlUsuarioHistorico="
						+ $("#correlUsuarioHistorico").val();

				var answer = confirm("Está seguro que quiere eliminar el registro seleccionado ?");
				if (answer) {
					$
							.ajax({
								type : "POST",
								url : "index.php/historicoUsuario/contratoDelete",
								data : formData,
								dataType : "json",
								success : function(retrievedData) {
									if (retrievedData.status != 0) {
										msgBoxInfo(retrievedData.msg);
									} else {
										$('#usuarioHist')
												.setGridParam(
														{
															url : "index.php/historicoUsuario/gridContratoUsuarioRead/"
																	+ $(
																			"#idUsuario")
																			.val()
														})
												.trigger("reloadGrid");

										msgBoxSucces("Contrato eliminado con éxito");
										usuarioAutocomplete();
										clearInside();
									}
								}

							});
				}
			} else {
				msgBoxSucces("Debe seleccionar un contrato a eliminar");
			}
		} else {
			msgBoxSucces("Debe seleccionar la opcion \"CONTRATOS\" para este usuario");
		}
	} else {
		msgBoxSucces("Debe seleccionar un usuario");
	}
}

function deleteRol() {
	if ($("#idUsuario").val() != "") {
		row_id = $("#rolesHist").jqGrid("getGridParam", "selrow");
		row_data = $("#rolesHist").jqGrid("getRowData", row_id);
		// insertando los valores del row seleccionado en los campos editables
		if (row_id != null) {
			$("#idRolHistorico").val(row_data["idRolHistorico"]);
			var formData = "idRolHistorico=" + $("#idRolHistorico").val();
			var answer = confirm("Está seguro que quiere eliminar el rol seleccionado ?");
			if (answer) {
				$
						.ajax({
							type : "POST",
							url : "index.php/historicoUsuario/rolDelete",
							data : formData,
							dataType : "json",
							success : function(retrievedData) {
								if (retrievedData.status != 0) {
									msgBoxInfo01(retrievedData.msg);
								} else {
									$('#rolesHist')
											.setGridParam(
													{
														url : "index.php/historicoUsuario/gridContratoRolRead/"
																+ $(
																		"#idUsuario")
																		.val()
																+ "/"
																+ $(
																		"#correlUsuarioHistorico")
																		.val()
													}).trigger("reloadGrid");
									msgBoxSucces01("Asignación de Rol eliminado con éxito");
									usuarioAutocomplete();
									usuarioRolAutocomplete();
									clearDeleteRole();
								}
							}

						});
			}
		} else {
			msgBoxSucces01("Debe seleccionar un rola eliminar de el contrato");
		}
	} else {
		msgBoxSucces01("Debe seleccionar un usuario");
	}
}

/* COSA DE LOS ROLES */
function editarContrato() {
	if ($("#idUsuario").val() != "") {
		row_id = $("#usuarioHist").jqGrid("getGridParam", "selrow");
		if (row_id != null) {
			$("#roles").show();
			row_data = $("#usuarioHist").jqGrid("getRowData", row_id);
			// insertando los valores del row seleccionado en los campos
			// editables
			if (row_id != null) {
				$("#correlUsuarioHistorico").val(
						row_data["correlUsuarioHistorico"]);
				$("#idUsuario").val(row_data["idUsuario"]);
				$("#accionActual").val("roleando");
				$('#rolesHist')
						.setGridParam(
								{
									url : "index.php/historicoUsuario/gridContratoRolRead/"
											+ $("#idUsuario").val()
											+ "/"
											+ $("#correlUsuarioHistorico")
													.val()
								}).trigger("reloadGrid");
			}
		} else {
			msgBoxSucces("Debe seleccionar un contrato");
		}

	} else {
		msgBoxSucces("Debe seleccionar un usuario");
	}
}

function cancel() {
	clear();
	$('#usuarioHist').setGridParam({
		url : "index.php/historicoUsuario/gridContratoUsuarioRead/" + -1
	}).trigger("reloadGrid");
	$("#msgBox").hide();
}

function cancelContrato() {
	$(".inputField").val("");
	$(".jqcalendario").val("");
	$(".hiddenId").val("");
	$("#txtRecords").val("");
	$("#txtTiempoContrato").val("");
	$('#usuarioHist').setGridParam({
		url : "index.php/historicoUsuario/gridContratoUsuarioRead/" + -1
	}).trigger("reloadGrid");
	$("#msgBox").hide();
	$("#contratosPressed").val("no")
}

function cancelRol() {
	$("#txtHistoricoRol").val("");
	$("#txtFechaInicioRol").val("");
	$("#txtFechaFinRol").val("");
	$("#txtSalarioRol").val("");
	$("#accionActualRol").val("");
	$("#idRol").val("");
	$('#usuarioHist').setGridParam({
		url : "index.php/historicoUsuario/gridContratoUsuarioRead/" + -1
	}).trigger("reloadGrid");
	$("#roles").hide();
}

function clearInside() {
	$(".inputField").val("");
	$(".jqcalendario").val("");
	$("#txtTiempoContrato").val("");
	$("#correlUsuarioHistorico").val("");
	$("#accionActual").val("");
}

function clearDeleteRole() {
	$("#txtHistoricoRol").val("");
	$("#txtFechaInicioRol").val("");
	$("#txtFechaFinRol").val("");
	$("#txtSalarioRol").val("");	
	$("#accionActualRol").val("");
	
}

function clear() {
	$("#roles").hide();
	$(".inputField").val("");
	$(".jqcalendario").val("");
	$(".hiddenId").val("");
	$("#txtRecords").val("");
	$("#txtTiempoContrato").val("");
	$("#correlUsuarioHistorico").val("");
	$("#accionActual").val("");
}

function clearSaveContrato() {
	// $("#roles").hide();
	$(".inputField").val("");
	$(".jqcalendario").val("");
	$("#accionActual").val("");
	$("#idRowEdit").val("");
	// $("#txtRecords").val("");
	$("#txtTiempoContrato").val("");
	// $("#correlUsuarioHistorico").val("");
	$("#accionActual").val("");
}

function clearSaveRol() {
	$("#idRol").val("");
	$("#idRolHistorico").val("");
	$("#txtHistoricoRol").val("");
	$("#txtFechaInicioRol").val("");
	$("#txtFechaFinRol").val("");
	$("#txtSalarioRol").val("");
	$("#accionActualRol").val("");
}

function clearRol() {
	$("#roles").hide();
	$("#txtHistoricoRol").val("");
	$("#idRol").val("");
	$("#idRolHistorico").val("");
	$("#txtFechaInicioRol").val("");
	$("#txtHistoricoRol").val("");
	$("#txtFechaFinRol").val("");
	$("#txtSalarioRol").val("");
	$("#accionActualRol").val("");
}

function validarCampos() {
	var camposFaltan = "";
	if ($("#txtFechaInicioContrato").val() != "") {
		if (!validarFechasOverlap()) {
			camposFaltan += "La fecha de inicio de contrato es mayor que la feche fin <br/>"
		}
	} else {
		camposFaltan += "El campo INICIO CONTRATO es obligatorio"
	}

	if ($("#txtFechaFinContrato").val() != "") {
		if (!validarFechasOverlap()) {
			camposFaltan += "La fecha de FIN DE CONTRATO es mayor que la feche fin <br/>"
		}
	} else {
		camposFaltan += "El campo FIN DE CONTRATO es obligatorio"
	}
	return true;
}

function validarCamposRol() {
	var camposFaltan = "";

	if ($("#txtSalarioRol").val() != "") {
		if (!validarSalario()) {
			camposFaltan += "El formato del salario es invalido <br/>"
		}
	}
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
