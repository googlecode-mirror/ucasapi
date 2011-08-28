$(document).ready(function() {
	js_ini();
	loadGrid();
	proyectoAutocomplete();
	$("#ventanillaButton").addClass("highlight");

	$("#dialogoSolicitud").dialog({
		modal : true,
		resizable : false,
		width : 700,
		autoOpen : false
	});
	$("#dialogoTransferir").dialog({
		autoOpen : false
	});
	$("#dialogoAsignar").dialog({
		modal : true,
		//resizable : false,
		width : 600,
		height : 800,
		autoOpen : false
	});

	$("#txtStartingDate, #txtEndingDate").datepicker({
		dateFormat : 'yy-mm-dd'
	});
	
	 $("#listPeticion").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false})

	// $("#list").hideCol("anio");
	// $("#list").hideCol("correl");
	
	
	
});

function loadGrid() {

	$("#listPeticion").jqGrid({
		url : "index.php/solicitud/gridRead/",
		datatype : "json",
		mtype : "POST",
		colNames : [ "Fecha de entrada", "T&iacute;tulo", "Solicitante" ],
		colModel : [ {
			name : "fecha",
			index : "fecha",
			width : 140
		}, {
			name : "titulo",
			index : "titulo",
			width : 500
		}, {
			name : "usuario",
			index : "usuario",
			width : 200
		} ],
		pager : "#pager",
		rowNum : 20,
		rowList : [20, 40, 50 ],
		width : 900,
		height : 500,
		sortname : "id",
		sortorder : "desc",
		loadonce : true,
		viewrecords : true,
		gridview : true,
		caption : "Solicitudes",
		ondblClickRow : function(id) {
			mostrarSolicitud(id);
			$("#idSolicitud").val(id);
			$("#txtRecords").attr('disabled', '');
			empleadosAutocomplete();
		}
	});

}

function proyectoAutocomplete() {
	$.ajax({
		type : "POST",
		url : "index.php/proyecto/proyectoAutocompleteRead",
		data : "usuarioAutocomplete",
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				alert("Mensaje de error: " + retrievedData.msg);
			} else {
				$("#txtProjectRecords").autocomplete(
						{
							minChars : 0,
							matchContains : true,
							source : retrievedData.data,
							minLength : 1,
							select : function(event, ui) {
								// $("#idUsuario").val(ui.item.id);
								$("#cbxRelacionados").append(
										'<option value="' + ui.item.id + '">'
												+ ui.item.value + '</option>');
							},
							// Esto es para el esperado mustMatch o algo
							// parecido
							change : function() {
								if (!autocompleteMatch(retrievedData.data, $(
										"#txtProjectRecords").val())) {
									$("#txtProjectRecords").val("");
								}
							}
						});

			}
		}

	});
}

function empleadosAutocomplete() {
	$.ajax({
		type : "POST",
		url : "index.php/solicitud/empleadoAutocompleteRead",
		// data: "usuarioAutocomplete",
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
							minLength : 1,
							select : function(event, ui) {
								$("#idUsuario").val(ui.item.id);
							},
							// Esto es para el esperado mustMatch o algo
							// parecido
							change : function() {
								if (!autocompleteMatch(retrievedData.data, $(
										"#txtRecords").val())) {
									$("#txtRecords").val("");
								}
							}
						});

			}
		}

	});
}

function mostrarSolicitud(idSolicitud) {
	$.ajax({
		type : "POST",
		url : "index.php/solicitud/getSolicitud",
		data : "idSolicitud=" + idSolicitud,
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				msgBoxInfo(retrievedData.msg);
				// alert("Mensaje de error: " + retrievedData.msg); //Por el
				// momento, el mensaje que se est� mostrando es t�cnico,
				// para cuestiones de depuraci�n
			} else {
				$("#fecha").html(retrievedData.data[0].fechaEntrada);
				$("#cliente").html(
						retrievedData.data[0].cliente + "<br/>"
								+ retrievedData.data[0].cargo + "<br/>"
								+ retrievedData.data[0].depto);
				$("#tituloSolicitud").html(retrievedData.data[0].titulo);
				$("#prioridad").html(retrievedData.data[0].prioridadCliente);
				$("#txtSolicitudDesc").val(retrievedData.data[0].descripcion);

				var interesados = "";
				for (i = 1; i < retrievedData.data.length; i++) {
					interesados += retrievedData.data[i].cliente + " - "
							+ retrievedData.data[i].depto + "<br/>";
				}

				$("#interesados").html(interesados);

				$("#dialogoSolicitud").css('visibility', 'visible').dialog(
						'open');
			}

		}

	});
}

function definirDestinatario() {
	$("#dialogoTransferir").css('visibility', 'visible').dialog('open');
}

function cargarDialogoAsignacion() {
	projectAutocomplete();
	userAutocomplete();
	priorityAutocomplete();
	statusAutocomplete();
	$("#dialogoAsignar").css('visibility', 'visible').dialog('open');
}

function transferirSolicitud() {

	var nombreDestinatario = $("#txtRecords").val();
	var formData = "idDestinatario=" + $("#idUsuario").val();
	formData += "&idSolicitud=" + $("#idSolicitud").val()

	$.ajax({
		type : "POST",
		url : "index.php/solicitud/transferirSolicitud",
		data : formData,
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				msgBoxInfo(retrievedData.msg);
				// alert("Mensaje de error: " + retrievedData.msg); //Por el
				// momento, el mensaje que se est� mostrando es t�cnico,
				// para cuestiones de depuraci�n
			} else {
				msgBoxSucces("Se ha transferido la solicitud a "
						+ nombreDestinatario);
				$("#txtRecords").val("");
				$("#txtRecords").attr('disabled', 'disabled');
				$(".cleanable").html("");
				$("#txtSolicitudDesc").val("");

				$("#dialogoTransferir").dialog("close");
				$("#dialogoSolicitud").dialog("close");
			}

		}

	});
}

function asignarSolicitud() {
	if (validarCampos()) {
		var relacionados = '';
		$('#cbxRelacionados option').each(function(i, selected) {
			relacionados += $(selected).val() + ",";
		});

		var solicitud = $("#idSolicitud").val().split("-");
		var formData = "";
		formData += "idProyecto=" + $("#idProyecto").val();
		formData += "&idProceso=" + $("#idProceso").val();
		formData += "&idActividad=" + $("#idActividad").val();
		formData += "&idPrioridad=" + $("#idPrioridad").val();
		formData += "&idEstado=" + $("#idEstado").val();
		formData += "&responsables=" + $("#idUsuarioResponsable").val();
		formData += "&idUsuarioAsigna=" + $("#idUsuarioAsigna").val();
		formData += "&nombreActividad=" + $("#txtActivityName").val();
		formData += "&fechaInicioPlan=" + $("#txtStartingDate").val();
		formData += "&fechaFinalizacionPlan=" + $("#txtEndingDate").val();
		formData += "&descripcion=" + $("#txtActivityDesc").val();
		formData += "&anioSolicitud=" + solicitud[0];
		formData += "&correlAnio=" + solicitud[1];
		formData += "&proyRelacionados=" + relacionados;

		$.ajax({
			type : "POST",
			url : "index.php/actividada/activityValidateAndSave",
			data : formData,
			dataType : "json",
			success : function(retrievedData) {
				if (retrievedData.status != 0) {
					msgBoxInfo(retrievedData.msg);
					// alert("Mensaje de error: " + retrievedData.msg); //Por el
					// momento, el mensaje que se est� mostrando es t�cnico,
					// para cuestiones de depuraci�n
				} else {
					if ($("#idActividad").val() == "") {
						msgBoxSucces("Registro agregado con �xito");
					} else {
						msgBoxSucces("Registro actualizado con �xito");
						$("div#dialogoAsignar > input:text").val("");
						$("#txtActivityDesc").val("");

						$(".cleanable").html("");
						$("#txtSolicitudDesc").val("");

						$("#dialogoAsignar").dialog("close");
						$("#dialogoSolicitud").dialog("close");
					}

				}
			}

		});
	}
}

// -----------------------------------------------------------------------------
// Funciones de Actividada
// -----------------------------------------------------------------------------
function projectAutocomplete() {
	$.ajax({
		type : "POST",
		url : "index.php/actividada/projectAutocomplete",
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

				$("#txtProjectName").autocomplete(
						{
							minChars : 0,
							matchContains : true,
							source : retrievedData.data,
							minLength : 1,
							select : function(event, ui) {
								$("#idProyecto").val(ui.item.id);
								$("#txtProcessName").val("");
								$("#idProceso").val("");
								processAutocomplete($("#idProyecto").val(),
										"#txtProcessName");
							},
							//Esto es para el esperado mustMatch o algo parecido
							change :function(){
								if(!autocompleteMatch(retrievedData.data, $("#txtProjectName").val())){
									$("#txtProjectName").val("");	
									$("#idProyecto").val("");
									$("#idProceso").val("");
								}
							}
						});

			}
		}

	});
}

function processAutocomplete(idProyecto, processTextBox) {
	$.ajax({
		type : "POST",
		url : "index.php/actividada/processAutocomplete/" + idProyecto,
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
				$(processTextBox).autocomplete(
						{
							minChars : 0,
							matchContains : true,
							source : retrievedData.data,
							minLength : 0,
							select : function(event, ui) {
								$("#idProceso").val(ui.item.id);
								$("#idActividad").val("");
								if (processTextBox == "#txtProcessRecords") {
									$("#txtRecords").val("");
									activityAutocomplete(
											$("#idProyecto").val(), $(
													"#idProceso").val());
								}
							},
							//Esto es para el esperado mustMatch o algo parecido
							change :function(){
								if(!autocompleteMatch(retrievedData.data, $("#txtProcessName").val())){
									$("#txtProjectRecords").val("");	
									$("#idActividad").val("");
								}
							}
						});

			}
		}

	});
}

function userAutocomplete() {
	$.ajax({
		type : "POST",
		url : "index.php/actividada/userAutocomplete",
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
				$("#txtResponsibleName").autocomplete({
					minChars : 0,
					matchContains : true,
					source : retrievedData.data,
					minLength : 1,
					select : function(event, ui) {
						$("#idUsuarioResponsable").val(ui.item.id);
					},
					//Esto es para el esperado mustMatch o algo parecido
					change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtResponsibleName").val())){
							$("#idUsuarioResponsable").val("");
							$("#txtResponsibleName").val("");		
						}
					}
				});

			}
		}

	});
}

function priorityAutocomplete() {
	$.ajax({
		type : "POST",
		url : "index.php/actividada/priorityAutocomplete",
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
				$("#txtPriorityName").autocomplete({
					minChars : 0,
					matchContains : true,
					source : retrievedData.data,
					minLength : 1,
					select : function(event, ui) {
						$("#idPrioridad").val(ui.item.id);
					},
					//Esto es para el esperado mustMatch o algo parecido
					change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtPriorityName").val())){
							$("#txtPriorityName").val("");			
							$("#idPrioridad").val("");
						}
					}
				});

			}
		}

	});
}

function statusAutocomplete() {
	$.ajax({
		type : "POST",
		url : "index.php/actividada/statusAutocomplete",
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
				$("#txtStatusName").autocomplete({
					minChars : 0,
					matchContains : true,
					source : retrievedData.data,
					minLength : 1,
					select : function(event, ui) {
						$("#idEstado").val(ui.item.id);
					},
					//Esto es para el esperado mustMatch o algo parecido
					change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtStatusName").val())){
							$("#txtStatusName").val("");		
							$("#idEstado").val("");
						}
					}
				});

			}
		}

	});
}

function validarCampos() {
	var camposFallan = "";
	if ($("#txtActivityName").val() != "") {
		if (!validarAlfaEsp($("#txtActivityName").val())) {
			camposFallan += "El campos NOMBRE para actividad contiene caracteres no validos <br />";
		}
	} else {
		camposFallan += "El campo NOMBRE es requerido <br />";
	}

	if ($("#txtProjectName").val() != "") {
		if (!validarAlfaEsp($("#txtProjectName").val())) {
			camposFallan += "El campos PROYECTO contiene caracteres no validos <br />";
		}
	} else {
		camposFallan += "El campo PROYETCO es requerido <br />";
	}

	if ($("#txtProcessName").val() != "") {
		if (!validarAlfaEsp($("#txtProcessName").val())) {
			camposFallan += "El campos PROCESO contiene caracteres no validos <br />";
		}
	} /*
		 * else { camposFallan += "El campo PROCESO es requerido <br />"; }
		 */

	if ($("#txtResponsibleName").val() != "") {
		if (!validarAlfaEsp($("#txtResponsibleName").val())) {
			camposFallan += "El campos RESPONSABLE contiene caracteres no validos <br />";
		}
	} else {
		camposFallan += "El campo RESPONSABLE es requerido <br />";
	}

	if ($("#txtPriorityName").val() != "") {
		if (!validarAlfaEsp($("#txtPriorityName").val())) {
			camposFallan += "El campos PRIORIDAD contiene caracteres no validos <br />";
		}
	} else {
		camposFallan += "El campo PRIORIDAD es requerido <br />";
	}

	if ($("#txtStatusName").val() != "") {
		if (!validarAlfaEsp($("#txtStatusName").val())) {
			camposFallan += "El campos ESTADO contiene caracteres no validos <br />";
		}
	} else {
		camposFallan += "El campo ESTADO es requerido <br />";
	}

	if ($("#txtActivityDesc").val() == "") {
		camposFallan += "El campo DESCRIPCION es requerido <br />";
	}

	if (camposFallan == "") {
		return true;
	} else {
		msgBoxInfo(camposFallan);
		return false;
	}

}
