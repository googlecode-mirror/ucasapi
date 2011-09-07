$(document).ready(function() {
	js_ini();
	$("#historicoUsuarioButton").addClass("highlight");
	$("#roles").hide();
	usuarioAutocomplete();
	usuarioRolAutocomplete();
	loadGridUsuarioHistorico();
	loadGridRolHistorico();
	
	$("#txtRecords").focus(function(){$("#txtRecords").autocomplete('search', '');});
	$("#txtHistoricoRol").focus(function(){$("#txtHistoricoRol").autocomplete('search', '');});
	
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
					minLength : 0,
					select : function(event, ui) {
						$("#idUsuario").val(ui.item.id);
						$(this).blur();//Dedicado al IE
					},
					// Esto es para el esperado mustMatch o algo parecido
					change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtRecords").val())){
							$("#txtRecords").val("");
							$("#idUsuario").val("");
						}
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
					minLength : 0,
					select : function(event, ui) {
						$("#idRol").val(ui.item.id);
						$(this).blur();//Dedicado al IE
					},
					// Esto es para el esperado mustMatch o algo parecido
					change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtHistoricoRol").val())){
							$("#txtHistoricoRol").val("");
							$("#idRol").val("");
						}
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
						"Salario", "CorrelContrato", "idUsuario" ],
				colModel : [ {
					name : "fechaInicioContrato",
					index : "fechaInicioContrato",
					width : 130
				}, {
					name : "fechaFinContrato",
					index : "fechaFinContrato",
					width : 130
				}, {
					name : "salario",
					index : "salario",
					width : 130
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
				colNames : [ "Ejercido desde", "Hasta", "Rol",
						"idRolHistorico", "idUsuario", "CorrelContrato",
						"idRol" ],
				colModel : [ {
					name : "fechaInicio",
					index : "fechaInicio",
					width : 110
				}, {
					name : "fechaFin",
					index : "fechaFin",
					width : 110
				}, {
					name : "nombreRol",
					index : "nombreRol",
					width : 250
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

	if ($("#idUsuario").val() != "") {
		if ($("#contratosPressed").val() == "yes") {
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
			formData += "&salario=" + $("#txtSalario").val();
			
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
									msgBoxSucces("Registro agregado con \u00e9xito");
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

									msgBoxSucces("Registro actualizado con \u00e9xito");
								}
								usuarioAutocomplete();
								clearSaveContrato();
							}
						}

					});
			} 
		}else {
			msgBoxSucces("Debe seleccionar la opcion \"CONTRATOS\" para este usuario");
		}
	}else {
		msgBoxInfo("Debe seleccionar un usuario");
	}
}

function saveRol() {
	if ($("#idUsuario").val() != "") {
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
				$.ajax({
					type : "POST",
					url : "index.php/historicoUsuario/historicoUsuarioRolValidateAndSave",
					data : formData,
					dataType : "json",
					success : function(retrievedData) {
						if (retrievedData.status != 0) {
							msgBoxInfo01(retrievedData.msg);
						} else {
							// alert($("#accionActualRol").val());
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
			}
	} else {
		msgBoxInfo01("Debe seleccionar un usuario");
	}
}

function edit() {
	if ($("#idUsuario").val() != "") {		
		lockAutocomplete();
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
				$("#txtSalario").val(row_data["salario"]);
				$("#correlUsuarioHistorico").val(
						row_data["correlUsuarioHistorico"]);
				$("#idUsuario").val(row_data["idUsuario"]);
				$("#accionActualRol").val("editando");
			}
		} else {
			msgBoxSucces("Debe seleccionar un contrato a editar");
		}
	} else {
		msgBoxSucces("Debe seleccionar la opci&oacute;n \"CONTRATOS\" para este usuario");
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
			$("#txtHistoricoRol").val(row_data["nombreRol"]);
			$("#correlUsuarioHistorico")
					.val(row_data["correlUsuarioHistorico"]);
			$("#idUsuario").val(row_data["idUsuario"]);
			$("#idRol").val(row_data["idRol"]);
			$("#idRolHistorico").val(row_data["idRolHistorico"]);
		} else {
			msgBoxInfo01("Debe seleccionar un rol a editar");
		}
	} else {
		msgBoxInfo01("Debe seleccionar un usuario");
	}
}

function deleteContrato() {
	if ($("#idUsuario").val() != "") {
		if ($("#contratosPressed").val() == "yes") {
			// obteniendo el rol seleccionado del grid de todos los roles
			row_id = $("#usuarioHist").jqGrid("getGridParam", "selrow");
			if (row_id != null) {
				clearRol();
				row_data = $("#usuarioHist").jqGrid("getRowData", row_id);
				$("#correlUsuarioHistorico").val(
						row_data["correlUsuarioHistorico"]);
				$("#idUsuario").val(row_data["idUsuario"]);
				// $("#accionActual").val("eliminando");

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

										msgBoxSucces("Contrato eliminado con \u00e9xito");
										usuarioAutocomplete();
										clearInside();
									}
								}

							});
				}
			} else {
				msgBoxInfo("Debe seleccionar un contrato a eliminar");
			}
		} else {
			msgBoxInfo("Debe seleccionar la opci&oacute;n \"CONTRATOS\" para este usuario");
		}
	} else {
		msgBoxInfo("Debe seleccionar un usuario");
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
			var answer = confirm("Est\u00e9 seguro que quiere eliminar el rol seleccionado ?");
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
									msgBoxSucces01("Asignaci\u00f3n de Rol eliminado con \u00e9xito");
									usuarioAutocomplete();
									usuarioRolAutocomplete();
									clearDeleteRole();
								}
							}

						});
			}
		} else {
			msgBoxInfo01("Debe seleccionar un rol eliminar de el contrato");
		}
	} else {
		msgBoxInfo01("Debe seleccionar un usuario");
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
				// $("#accionActual").val("roleando");
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
			msgBoxInfo("Debe seleccionar un contrato");
		}

	} else {
		msgBoxInfo("Debe seleccionar un usuario");
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
	$("#txtSalario").val("");
	unlockAutocomplete();
}

function cancelRol() {
	$("#txtHistoricoRol").val("");
	$("#txtFechaInicioRol").val("");
	$("#txtFechaFinRol").val("");	
	$("#accionActualRol").val("");
	$("#idRol").val("");
	$('#rolesHist')
	.setGridParam(
			{
				url : "index.php/historicoUsuario/gridContratoRolRead/"
						+ -1
						+ "/"
						+ "-1"
			}).trigger("reloadGrid");
	/*
	 * $('#usuarioHist').setGridParam({ url :
	 * "index.php/historicoUsuario/gridContratoUsuarioRead/" + -1
	 * }).trigger("reloadGrid");
	 */
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
	$("#txtSalario").val("");
	$("#correlUsuarioHistorico").val("");
	$("#accionActual").val("");
	unlockAutocomplete();
}

function clearSaveContrato() {
	// $("#roles").hide();
	$(".inputField").val("");
	$(".jqcalendario").val("");
	$("#accionActual").val("");
	$("#idRowEdit").val("");
	$("#txtSalario").val("");
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
	//$("#txtSalarioRol").val("");
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
	//$("#txtSalarioRol").val("");
	$("#accionActualRol").val("");
}

function validarCampos() {
	var camposFallan = "";
	if ($("#txtFechaInicioContrato").val() != "") {
		
	} else {
		camposFallan += "<p><dd> El campo INICIO CONTRATO es obligatorio </dd><br/></p>";
	}

	if ($("#txtFechaFinContrato").val() != "") {
		
	} else {
		camposFallan += "<p><dd> El campo FIN DE CONTRATO es obligatorio </dd><br/></p>";
	}
	
	if ($("#txtFechaInicioContrato").val() != "" &&	 $("#txtFechaFinContrato").val() != "") { 
		if(!validateOverlapFechas($("#txtFechaFinContrato").val(),$("#txtFechaInicioContrato").val())) {
			 camposFallan += "<p><dd> El campo FECHA INICIO debe ser menor o igual a FECHA FIN </dd><br/></p>";
		}
	}	
	
	/*if ($("#txtSalarioRol").val() != "") {
		if (!validarSalario($("#txtSalarioRol").val())) {
			camposFallan += "<p><dd> El formato de SALARIO es incorrecto o contiene caracteres no validos </dd><br/></p>"
		}
	}	
	*/
	if(camposFallan == ""){
		return true;
	}else{
		camposFallan = "Se encontraron los siguientes problemas: <br/>" + camposFallan;
		msgBoxInfo(camposFallan);
		return false;
	}
}

function validarCamposRol() {
	var camposFallan = "";

	if ($("#txtHistoricoRol").val() == "") {
		camposFallan += "<p><dd> El campo ROL es requerido </dd><br/></p>"		
	}
	
	if ($("#txtFechaInicioRol").val() == "") {
		camposFallan += "<p><dd> El campo FECHA ASIGNACION es requerido </dd><br/></p>"		
	}
		
	if ($("#txtFechaFinRol").val() != "" &&	 $("#txtFechaInicioRol").val() != "") { 
		if(!validateOverlapFechas($("#txtFechaFinRol").val(),$("#txtFechaInicioRol").val())) {
			 camposFallan += "<p><dd> El campo FECHA ASIGNACION debe ser menor o igual a FECHA FIN </dd><br/></p>";
		}
	}
	
	if(camposFallan == ""){
		return true;
	}else{
		camposFallan = "Se encontraron los siguientes problemas: <br/>" + camposFallan;
		msgBoxInfo01(camposFallan);
		return false;
	}
}


$("#chkUsuarioActivo").change(function() {
	alert('Handler for .change() called.');
});


/* OTRAS FUNCIONES DE VALIDACION Y LOCKING */
function lockAutocomplete() {	
	$("#txtRecords").attr("disabled", true);	
	$("#txtRecords").css({"background-color": "DBEBFF"});
}

function unlockAutocomplete() {
	$("#txtRecords").attr("disabled", false);
	$("#txtRecords").css({"background-color": "FFFFFF"});	
}