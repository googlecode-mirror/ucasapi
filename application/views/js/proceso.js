$(document).ready(function() {
	js_ini();
	
	idArchivo = "";
	upload = null;
	ajaxUpload();	
	//$("#tabs-2").hide();
	//$("#tagBliblioteca").hide();	
	loadGridDocuments();
	fileTypeAutocomplete();	
	
	$("#procesoButton").addClass("highlight");
	procesoProyectoAutocomplete();
	procesoEstadoAutocomplete();
	//procesoFaseAutocomplete();
	$("#idProceso").val("0");
	
	$("#txtRecordsProc").focus(function(){$("#txtRecordsProc").autocomplete('search', '');});
	$("#txtRecordsProy").focus(function(){$("#txtRecordsProy").autocomplete('search', '');});
	$("#txtRecordsProc").focus(function(){$("#txtRecordsProc").autocomplete('search', '');});
	$("#txtProyectoName").focus(function(){$("#txtProyectoName").autocomplete('search', '');});	
	$("#txtFileType").focus(function(){$("#txtFileType").autocomplete('search', '');});
	
	$("#tagBliblioteca").hide();
	$("#tabs-2").hide();

});

function procesoAutocomplete($idProyecto) {
	$.ajax({
		type : "POST",
		url : "index.php/proceso/procesoAutocompleteRead/" + $idProyecto,
		data : "statusAutocomplete",
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				alert("Mensaje de error: " + retrievedData.msg);
			} else {
				$("#txtRecordsProc").autocomplete({
					minChars : 0,
					source : retrievedData.data,
					minLength : 0,
					select : function(event, ui) {
						$("#idProceso").val(ui.item.id);
						$(this).blur();//Dedicado al IE
					},
					//Esto es para el esperado mustMatch o algo parecido
					change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtRecordsProc").val())){
							$("#txtRecordsProc").val("");
							$("#idProceso").val("0");
						}
					}
				});

			}
		}

	});
}

function procesoProyectoAutocomplete() {
	
	$.ajax({
		type : "POST",
		url : "index.php/proceso/proyectoAutocompleteRead/" + $("#idUsuario").val() + "/" + $("#idRol").val(),
		data : "procesoProyectoAutocomplete",
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				alert("Mensaje de error: " + retrievedData.msg);
			} else {
				$("#txtRecordsProy").autocomplete({
					minChars : 0,
					source : retrievedData.data,
					minLength : 0,
					select : function(event, ui) {
						$("#idProyecto").val(ui.item.id);
						$(this).blur();//Dedicado al IE
						procesoAutocomplete($("#idProyecto").val());
					},
					//Esto es para el esperado mustMatch o algo parecido
					change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtRecordsProy").val())){
							$("#txtRecordsProc").autocomplete("destroy");
							$("#txtRecordsProc").val("");
							$("#txtRecordsProy").val("");
							$("#idProyecto").val("0");
						}
					}
				});
				$("#txtProyectoName").autocomplete({
					minChars : 0,
					source : retrievedData.data,
					minLength : 0,
					select : function(event, ui) {
						$("#idProyecto").val(ui.item.id);
						procesoFaseAutocomplete($("#idProyecto").val());
					},
					//Esto es para el esperado mustMatch o algo parecido
					change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtProyectoName").val())){
							$("#txtProyectoName").val("");
							$("#idProyecto").val("0");
						}
					}
				});

			}
		}

	});
}

function procesoFaseAutocomplete($idProyecto) {
	$.ajax({
		type : "POST",
		url : "index.php/proceso/faseAutocompleteRead/" + $idProyecto,
		data : "procesoFaseAutocomplete",
		dataType : "json",
		success : function(retrievedData) {
			options = '<option value="">Seleccione una fase</option>';
			$.each(retrievedData.data, function(i, obj) {
				options += '<option value="' + obj.id + '">' + obj.value
						+ '</option>';
			});
			$("#cbFases").html(options);

		}

	});
}

function procesoEstadoAutocomplete() {
	$.ajax({
		type : "POST",
		url : "index.php/proceso/procesoEstadoAutocompleteRead/2",
		data : "procesoEstadoAutocomplete",
		dataType : "json",
		success : function(retrievedData) {
			options = '<option value="">Seleccione un estado</option>';
			$.each(retrievedData.data, function(i, obj) {
				options += '<option value="' + obj.id + '">' + obj.value
						+ '</option>';
			});
			$("#cbEstado").html(options);

		}
	});
}

function save() {
	var formData = "";

	if (validarCampos()) {

		formData += "idProceso=" + $("#idProceso").val();
		formData += "&idProyecto=" + $("#idProyecto").val();
		formData += "&idFase=" + $("#cbFases").val();
		formData += "&idEstado=" + $("#cbEstado").val();
		formData += "&nombreProceso=" + $("#txtProcesoName").val();
		formData += "&descripcion=" + $("#txtProcesoDesc").val();
		formData += "&accionActual=" + $("#accionActual").val();

		proc_rows = $("#tablaFases").jqGrid("getRowData");
		var gridData = "";
		for ( var Elemento in proc_rows) {
			for ( var Propiedad in proc_rows[Elemento]) {
				if (Propiedad == "nombreFase" || Propiedad == "fechaIniPlan"
						|| Propiedad == "fechaFinPlan"
						|| Propiedad == "fechaIniReal"
						|| Propiedad == "fechaFinReal")
					gridData += proc_rows[Elemento][Propiedad] + "|";
			}
		}
		;
		formData += "&proc_data=" + gridData;

		$.ajax({
			type : "POST",
			url : "index.php/proceso/procesoValidateAndSave",
			data : formData,
			dataType : "json",
			success : function(retrievedData) {
				if (retrievedData.status != 0) {
					alert("Mensaje de error: " + retrievedData.msg);
				} else {
					if ($("#accionActual").val() == "") {
						msgBoxSucces("Proceso agregado con \u00e9xito");
					} else {
						msgBoxSucces("Proceso actualizado con \u00e9xito");
					}
					procesoProyectoAutocomplete();
					procesoEstadoAutocomplete();
					clear();
				}
			}
		});
	}

}

function edit() {

	if ($("#txtRecordsProy").val() != "") {
		if ($("#txtRecordsProc").val() != "") {
			var formData = "idProceso=" + $("#idProceso").val();
			lockAutocomplete();
			$("#tagBliblioteca").show();
			$("#tabs-2").show();
			$("#accionActual").val("editando");
			$.ajax({
				type : "POST",
				url : "index.php/proceso/procesoRead",
				data : formData,
				dataType : "json",
				success : function(retrievedData) {
					if (retrievedData.status != 0) {
						alert("Mensaje de error: " + retrievedData.msg);
					} else {
						procesoFaseAutocomplete();
						$("#txtProcesoName").val(
								retrievedData.data.nombreProceso);
						$("#cbEstado").val(retrievedData.data.idEstado);
						$("#txtProcesoDesc")
								.val(retrievedData.data.descripcion);
						$("#txtProyectoName").val(
								retrievedData.data.nombreProyecto)
						$("#cbFases").val(retrievedData.data.idFase);
						$('#gridDocuments').setGridParam({url:"index.php/proceso/gridDocumentsLoad/"+ $("#idProceso").val()}).trigger("reloadGrid");
					}
				}
			});
		}else{
			msgBoxInfo("Debe seleccionar un PROCESO a editar");
		}
	}else{
		msgBoxInfo("Debe seleccionar un PROYECTO al que pertenece el proceso");
	}

}

function addFase() {
	$("#tablaFases").jqGrid('addRowData', 0, {
		nombreFase : $("#cbFases :selected").text(),
		fechaIniPlan : '2011-01-01',
		fechaFinPlan : '2011-01-01',
		fechaIniReal : '2011-01-01',
		fechaFinReal : '2011-01-01'
	}, 'last')
}


function pickdates(id) {
	jQuery("#" + id + "_fechaIniPlan", "#tablaFases").datepicker({
		dateFormat : "yy-mm-dd"
	});
}

function deleteData() {
	
	if ($("#txtRecordsProy").val() != "") {
		if ($("#txtRecordsProc").val() != "") {
			var formData = "idProceso=" + $("#idProceso").val();
		
			var answer = confirm("Está seguro que quiere eliminar el proceso: "
					+ $("#txtRecordsProc").val() + " ?");
		
			if (answer) {
				$.ajax({
					type : "POST",
					url : "index.php/proceso/procesoDelete",
					data : formData,
					dataType : "json",
					success : function(retrievedData) {
						if (retrievedData.status != 0) {
							alert("Mensaje de error: " + retrievedData.msg);
						} else {
							msgBoxSucces("Registro eliminado con éxito");
							procesoAutocomplete();
							clear();
						}
					}
		
				});
			}
		}else{
			msgBoxInfo("Debe seleccionar un PROCESO a eliminar");
		}
	}else{
		msgBoxInfo("Debe seleccionar un PROYECTO al que pertenece el proceso");
	}
}

function editFase() {
	var gr = jQuery("#tablaFases").jqGrid('getGridParam', 'selrow');
	if (gr != null)
		jQuery("#tablaFases").jqGrid('editGridRow', gr, {
			height : 280,
			reloadAfterSubmit : false
		});
	else
		alert("Por favor seleccione una fila");
}

function cancelEdit() {
	jQuery("#tablaFases").jqGrid('restoreRow',
			$("#tablaFases").jqGrid('getGridParam', 'selrow'));
	jQuery("#btnCancelEd").attr("disabled", true);
	jQuery("#btnEdit").attr("disabled", false);

}

function isDate(string) { // string estará en formato yyyy-mm-dd
	regExp = /^[0-9]{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])/;
	if (!regExp.test(string))
		return false;
	else
		return true;
}

function cancel() {
	clear();
}

function clear() {
	$(".inputFieldAC").val("");
	$(".inputFieldTA").val("");
	$(".hiddenId").val("");
	$("#cbEstado").val("--Estado--");
	$("#cbEstado").val("Seleccione una fase");
	$("#idProceso").val("0");
	$("#tablaFases").GridUnload();
	unlockAutocomplete();
	$("#tagBliblioteca").hide();
	$("#tabs-2").hide();
}

function validarCampos() {
	var camposFallan = "";
	if ($("#txtProcesoName").val() != "") {
		if (!validarAlfaEspNum($("#txtProcesoName").val())) {
			camposFallan += "	El campo NOMBRE contiene caracteres no validos";
		}
	} else {
		camposFallan += "	El campo NOMBRE es requerido <br/>";
	}

	if ($("#cbEstado").val() == "") {
		camposFallan += "	Debe seleccionar un ESTADO <br />";
	}

	if ($("#cbFases").val() == "") {
		camposFallan += "	Debe seleccionar una FASE <br />";
	}

	if ($("#txtProcesoDesc").val() != "") {
		if ($("#txtProcesoDesc").val().length > 256) {
			camposFallan += "	El campo DESCRIPCION es mayor a 256 caracteres <br/>";
		}
	} else {
		camposFallan += "	El campo DESCRIPCION es requerido <br/>";
	}

	if (camposFallan == "") {
		camposFallan = "Se encontraron los siguientes problemas: <br/>"
		return true;
	} else {
		msgBoxInfo(camposFallan);
		return false;
	}
}

/* OTRAS FUNCIONES DE VALIDACION Y LOCKING */
function lockAutocomplete() {

	$("#txtRecordsProy").attr("disabled", true);
	$("#txtRecordsProy").css({
		"background-color" : "DBEBFF"
	});

	$("#txtRecordsProc").attr("disabled", true);
	$("#txtRecordsProc").css({
		"background-color" : "DBEBFF"
	});
}

function unlockAutocomplete() {
	
	$("#txtRecordsProy").attr("disabled", false);
	$("#txtRecordsProy").css({
		"background-color" : "FFFFFF"
	});	
		
	$("#txtRecordsProc").attr("disabled", false);
	$("#txtRecordsProc").css({
		"background-color" : "FFFFFF"
	});
}

//-------------------------------------------------------ARCHIVOS-------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------

//Utilizando el plugin ajaxupload para la subida de archivos
function ajaxUpload() {
	new AjaxUpload("btnUpload", {
		debug : true,
		autoSubmit : false,
		responseType : "json",
		action : "index.php/upload/do_upload/",
		onSubmit : function(file, ext) {
			if (!(ext && /^(txt|png|jpeg|docx|doc|rtf|ppt|pptx|bmp|gif|xls|xlsx|odt|ods|odp|odb|odf|odg|csv|pdf)$/.test(ext))) {
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

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------

//Función asociada al botón "Agregar"
function uploadFile() {
	//if($("#accionActual").val() != ""){
		if (upload == null) {
			msgBoxInfo('Debe seleccionar un archivo');
			return false;
		}
		if ($("#txtFileName").val() == "") {
			msgBoxInfo('El campo "Nombre" es requerido');
			return false;
		}
		upload.setData({// Datos adicionales en el envío del archivo
			uploadIdName : "idProceso",
			uploadIdValue : $("#idProceso").val()
		});
		upload.submit();
	/*}
	else{
		msgBoxInfo("Debe seleccionar un PROCESO al cual subir los archivos");
	}*/
}


function fileTypeAutocomplete(){
	$.ajax({				
     type: "POST",
     url:  "index.php/actividada/fileTypeAutocomplete",
     dataType : "json",
     success: function(retrievedData){        	
     	if(retrievedData.status != 0){
     		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
     	}
     	else{        		
     		$("#txtFileType").autocomplete({
         		minChars: 0,
         		matchContains: true,
 		        source: retrievedData.data,
 		        minLength: 0,
 		        change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtFileType").val())){
							$("#txtFileType").val("");
							$("#idTipoArchivo").val("");
						}
					},
				change :function(){
					if(!autocompleteMatch(retrievedData.data, $("#txtFileType").val())){
						$("#txtFileType").val("");
						$("#idTipoArchivo").val("");
					}
				},
 		        select: function(event, ui) {
 			        $("#idTipoArchivo").val(ui.item.id);
 			        $(this).blur();//Dedicado al IE
 				}
     		
 			});
     		
     	}        	
   }
   
	});		
}


//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------

//Función desencadenada en el onComplete de la subida del archivo y asociada al
//botón "Actualizar"
function saveFileData(fileName) {
	$idProceso = $("#idProceso").val();
	var formData = "nombreArchivo=" + fileName;
	formData += "&idProceso=" + $("#idProceso").val();
	formData += "&descripcion=" + $("#txtFileDesc").val();
	formData += "&tituloArchivo=" + $("#txtFileName").val();
	formData += "&idTipoArchivo=" + $("#idTipoArchivo").val();
	formData += "&idArchivo=" + idArchivo;
	if($idProceso != ""){
		// alert($idProyecto);
		$.ajax({
			type : "POST",
			url : "index.php/proceso/fileValidateAndSave",
			data : formData,
			dataType : "json",
			success : function(retrievedData) {
				if (retrievedData.status != 0) {
					msgBoxInfo(retrievedData.msg);

				} else {
					$('#gridDocuments').setGridParam({url : "index.php/proceso/gridDocumentsLoad/"+ $("#idProceso").val()}).trigger("reloadGrid");
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

//Inicializa el grid de documentos
function loadGridDocuments() {
	$("#gridDocuments").jqGrid({
		/* url: "index.php/departamento/gridRead/", */
		datatype : "json",
		mtype : "POST",
		colNames : [ "Id", "Tipo", "Título","Nombre", "Subido", "Descripcion", "idTipo" ],
		colModel : [ {name : "idArchivo",index : "idArchivo",width : 20,hidden : true},
		             {name : "Tipo",index : "Tipo",width : 160}, 
		             {name : "Título",index : "Título",width : 160}, 
		             {name : "Nombre",index : "Nombre", hidden : true}, 
		             {name : "Subido",index : "Subido",width : 160}, 
		             {name : "Descripcion",index : "Descripcion",hidden : true},
		             {name : "idTipoArchivo",index : "idTipoArchivo",hidden : true}
		             
		             ],
		pager : "#dpager",
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
	$("#gridDocuments").navGrid("#dpager", {
		edit : false,
		add : false,
		del : false,
		refresh : false
	});
	$("#gridDocuments").jqGrid("navButtonAdd", "#dpager", {
		caption : "",
		buttonicon : "ui-icon-folder-open",
		title : "Abrir documento",
		onClickButton : function() {
			openFile();
		}
	});
	$("#gridDocuments").jqGrid("navButtonAdd", "#dpager", {
		caption : "",
		buttonicon : "ui-icon-pencil",
		title : "Editar",
		onClickButton : function() {
			editFileData();
		}
	});
	$("#gridDocuments").jqGrid("navButtonAdd", "#dpager", {
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
		fileName = rowData["Nombre"];
		fileURL = $("#filePath").val() + fileName;

		window.open(fileURL);
	}
}

// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------

// Permite la edición de los datos del archivo seleccionado
function editFileData() {
	rowId = $("#gridDocuments").jqGrid("getGridParam", "selrow");
	if(rowId == null){
		msgBoxInfo("Debe seleccionar un archivo para editar");
	}else{
		$("#btnAddFile").hide()
		$("#btnUpdateFile").show();
		rowData = $("#gridDocuments").jqGrid("getRowData", rowId);
		idArchivo = rowData["idArchivo"];
		$("#txtFileDesc").val(rowData["Descripcion"]);
		$("#txtFileName").val(rowData["Título"]);
		$("#txtFileType").val(rowData["Tipo"]);
		$("#idTipoArchivo").val(rowData["idTipoArchivo"]);
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
				url : "index.php/proceso/fileDelete",
				data : formData,
				dataType : "json",
				success : function(retrievedData) {
					if (retrievedData.status != 0) {
						msgBoxInfo(retrievedData.msg);

					} else {
						$('#gridDocuments').setGridParam({url : "index.php/proceso/gridDocumentsLoad/"+ $("#idProceso").val()}).trigger("reloadGrid");
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
	$("#txtFileName").val("");
	$("#txtFileType").val("");
	$("#idTipoArchivo").val("");	
	$("#txtFileDesc").val("");
	$("#btnAddFile").show();
	$("#btnUpdateFile").hide();
	$(".divUploadButton p").text("");
}
