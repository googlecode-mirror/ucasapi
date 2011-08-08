$(document).ready(function() {
	js_ini();
	idArchivo = "";
	upload = null;
	proyectoAutocomplete();	
	ajaxUpload();
	loadGridDocuments();
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
				msgBoxSucces("Ocurrio un problema: " + retrievedData.msg);				
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
				msgBoxSucces("Ocurrio un problema: " + retrievedData.msg);
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
				msgBoxSucces("Ocurrio un problema: " + retrievedData.msg);
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
		//alert('ACTIVO');
		formData += "&activo=1";
	} else {
		//alert('INACTIVO');
		formData += "&activo=0";
	}

	//alert(formData);

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
				msgBoxSucces("Ocurrio un problema: " + retrievedData.msg);
			} else {
				$("#txtProyectoNombre").val(retrievedData.data.nombreProyecto);
				$("#txtProyectoNombreDuenho").val(
						retrievedData.data.nombreUsuario);
				$("#txtProyectoFechaPlanIni").val(
						retrievedData.data.fechaPlanIni);
				$("#txtProyectoFechaPlanFin").val(
						retrievedData.data.fechaPlanFin);
				$("#txtProyectoFechaRealIni").val(
						retrievedData.data.fechaRealIni);
				$("#txtProyectoFechaRealFin").val(
						retrievedData.data.fechaRealFin);
				$("#idUsuarioDuenho").val(retrievedData.data.idUsuario);
				$("#txtProyectoDescripcion")
						.val(retrievedData.data.descripcion);
				if (retrievedData.data.activo == '1') {
					//alert('ACTIVO');
					$("#chkProyectoActivo").attr('checked', true);
				} else {
					//alert('INACTIVO');
					$("#chkProyectoActivo").attr('checked', false);
				}
				$('#gridDocuments').setGridParam(
						{
							url : "index.php/proyecto/gridDocumentsLoad/"
									+ $("#idProyecto").val()
						}).trigger("reloadGrid");
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
	$(".jqcalendario").val("");
	$(".hiddenId").val("");
	$("#txtRecords").val("");
	$("#chkProyectoActivo").attr('checked', false);
}

$("#chkUsuarioActivo").change(function() {
	alert('Handler for .change() called.');
});

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------

// Utilizando el plugin ajaxupload para la subida de archivos
function ajaxUpload() {
	new AjaxUpload("btnUpload", {
		debug : true,
		autoSubmit : false,
		responseType : "json",
		action : "index.php/upload/do_upload/",
		onSubmit : function(file, ext) {
			if (!(ext && /^(txt|png|jpeg|docx)$/.test(ext))) {
				msgBoxInfo("El tipo de archivo no está perimitido");
				return false;
			}
		},
		onChange : function(file, response) {
			upload = this;
			$(".divUploadButton p").text("Archivo: " + file);
		},
		onComplete : function(file, response) {
			if (response.status != 0) {
				msgBoxInfo(response.msg);
				return false;
			} else {
				saveFileData(response.data.file_name);
			}
		}
	});
	upload = null;
	$(".divUploadButton p").text("");
}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------

// Función asociada al botón "Agregar"
function uploadFile() {
	if (upload == null) {
		msgBoxInfo('Debe seleccionar un archivo');
		return false;
	}
	if ($("#txtFileName").val() == "") {
		msgBoxInfo('El campo "Nombre" es requerido');
		return false;
	}
	upload.setData({// Datos adicionales en el envío del archivo
		uploadIdName : "idProyecto",
		uploadIdValue : $("#idProyecto").val()
	});
	upload.submit();
}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------

// Función desencadenada en el onComplete de la subida del archivo y asociada al
// botón "Actualizar"
function saveFileData(fileName) {
	$idProyecto = $("#idProyecto").val();
	var formData = "nombreArchivo=" + fileName;
	formData += "&idProyecto=" + $("#idProyecto").val();
	formData += "&descripcion=" + $("#txtFileDesc").val();
	formData += "&idArchivo=" + idArchivo;
	if($idProyecto != ""){
		//alert($idProyecto);
	$.ajax({
		type : "POST",
		url : "index.php/proyecto/fileValidateAndSave",
		data : formData,
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				msgBoxInfo(retrievedData.msg);

			} else {
				$('#gridDocuments').setGridParam(
						{
							url : "index.php/proyecto/gridDocumentsLoad/"
									+ $("#idProyecto").val()
						}).trigger("reloadGrid");
				if (idArchivo == "") {
					msgBoxSucces("Documento agregado con éxito");
				} else {
					msgBoxSucces("Documento actualizado con éxito");
				}
				clearFileForm();
			}
		}

	});
	}
	else{
		msgBoxSucces("Debe seleccionarse un proyecto para agregar documentos a el");
	}
}

// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------

// Inicializa el grid de documentos
function loadGridDocuments() {
	$("#gridDocuments").jqGrid({
		/* url: "index.php/departamento/gridRead/", */
		datatype : "json",
		mtype : "POST",
		colNames : [ "Id", "Nombre", "Descripción" ],
		colModel : [ {
			name : "idArchivo",
			index : "idArchivo",
			width : 20,
			hidden : true
		}, {
			name : "nombreArchivo",
			index : "nombreArchivo",
			width : 160
		}, {
			name : "descripcion",
			index : "descripcion",
			width : 320
		} ],
		pager : "#pager",
		rowNum : 10,
		width : 480,
		rowList : [ 10, 20, 30 ],
		sortname : "idArchivo",
		sortorder : "desc",
		viewrecords : true,
		gridview : true,
		caption : "Documentos"
	});

	// Utilizando botones personalizados en el grid
	$("#gridDocuments").navGrid("#pager", {
		edit : false,
		add : false,
		del : false,
		refresh : false
	});
	$("#gridDocuments").jqGrid("navButtonAdd", "#pager", {
		caption : "",
		buttonicon : "ui-icon-folder-open",
		title : "Abrir documento",
		onClickButton : function() {
			openFile();
		}
	});
	$("#gridDocuments").jqGrid("navButtonAdd", "#pager", {
		caption : "",
		buttonicon : "ui-icon-pencil",
		title : "Editar",
		onClickButton : function() {
			editFileData();
		}
	});
	$("#gridDocuments").jqGrid("navButtonAdd", "#pager", {
		caption : "",
		buttonicon : "ui-icon-trash",
		title : "Eliminar",
		onClickButton : function() {
			deleteFile();
		}
	});
}

// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------

// Abre el documento correspondiente a la fila seleccionada
function openFile() {
	rowId = $("#gridDocuments").jqGrid("getGridParam", "selrow");
	if (rowId == null) {
		msgBoxInfo("Debe seleccionar un archivo para abrir");
	} else {
		rowData = $("#gridDocuments").jqGrid("getRowData", rowId);
		fileName = rowData["nombreArchivo"];
		fileURL = $("#filePath").val() + fileName;

		window.open(fileURL);
	}
}

// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------

// Permite la edición de los datos del archivo seleccionado
function editFileData() {
	rowId = $("#gridDocuments").jqGrid("getGridParam", "selrow");
	if (rowId == null) {
		msgBoxInfo("Debe seleccionar un archivo para editar");
	} else {
		$("#btnAddFile").hide()
		$("#btnUpdateFile").show();
		rowData = $("#gridDocuments").jqGrid("getRowData", rowId);
		idArchivo = rowData["idArchivo"];
		$("#txtFileDesc").val(rowData["descripcion"]);
		$("#txtFileName").val(rowData["nombreArchivo"]);
	}
}

// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------

// Permite la eliminación de los datos del archivo seleccionado
function deleteFile() {
	rowId = $("#gridDocuments").jqGrid("getGridParam", "selrow");
	if (rowId == null) {
		msgBoxInfo("Debe seleccionar un archivo para editar");
	} else {
		rowData = $("#gridDocuments").jqGrid("getRowData", rowId);
		idArchivo = rowData["idArchivo"];
		var formData = "idArchivo=" + idArchivo;
		var answer = confirm("Está seguro que quiere eliminar el documento?");
if(answer){
$.ajax({
										type : "POST",
						url : "index.php/proyecto/fileDelete",
						data : formData,
						dataType : "json",
						success : function(retrievedData) {
							if (retrievedData.status != 0) {
								msgBoxInfo(retrievedData.msg);

							} else {
								$('#gridDocuments')
										.setGridParam(
												{
													url : "index.php/proyecto/gridDocumentsLoad/"
															+ $("#idProyecto")
																	.val()
												}).trigger("reloadGrid");
								msgBoxSucces("Documento eliminado con éxito");
								clearFileForm();

							}
						}

					});
		}
	}
}

// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------

// Abre el documento correspondiente a la fila seleccionada
function clearFileForm() {
	idArchivo = "";
	$("#txtFileDesc").val("");
	$("#btnAddFile").show();
	$("#btnUpdateFile").hide();
}
