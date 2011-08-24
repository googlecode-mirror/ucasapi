var faseCorrel = 0;

$(document).ready(function() {
	js_ini();
	$("#proyectoButton").addClass("highlight");
	idArchivo = "";
	upload = null;
	proyectoAutocomplete();	
	proyectoFaseAutocomplete();
	ajaxUpload();
	$("#idProyecto").val("0");
	$("#tabs-2").hide();
	$("#tagBliblioteca").hide();	
	loadGrid("0");
	loadGridDocuments();
	proyectoUsuarioDuenhoAutocomplete();
	proyectoUsuarioEncAutocomplete();
	
	if($("#idRol").val() != 2){	
		$("#btnSave").attr("disabled", true);
	}
		
});

function proyectoUsuarioEncAutocomplete(){
	$.ajax({
		type : "POST",
		url : "index.php/proyecto/proyectoUsuarioEncRead",
		data : "proyectoUsuAutocomplete",
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				msgBoxSucces("Ocurrio un problema: " + retrievedData.msg);				
			} else {
				$("#txtCoordinadorEnc").autocomplete({
					minChars : 0,
					matchContains : true,
					source : retrievedData.data,
					minLength : 1,
					select : function(event, ui) {
						$("#idUsuarioProy").val(ui.item.id);
					}
				});

			}
		}

	});
}

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

function proyectoFaseAutocomplete(){
	$.ajax({				
		type: "POST",
		url:  "index.php/proyecto/proyectoFaseRead",
		data: "procesoFaseAutocomplete",
		dataType : "json",
		success: function(retrievedData){        	 
			options = '<option value="">Seleccione una fase</option>';
			$.each(retrievedData.data, function(i,obj) {
				options += '<option value="' + obj.id + '">' + obj.value + '</option>';
			});			
			$("#cbFases").html(options);

		}
	});		
}

function save() {
	var formData = "";	
	if (validarCampos()) {	
		formData += "idProyecto=" + $("#idProyecto").val();
		formData += "&nombreProyecto=" + $("#txtProyectoNombre").val();
		formData += "&fechaPlanIni=" + $("#txtProyectoFechaPlanIni").val();
		formData += "&fechaPlanFin=" + $("#txtProyectoFechaPlanFin").val();
		formData += "&fechaRealIni=" + $("#txtProyectoFechaRealIni").val();
		formData += "&fechaRealFin=" + $("#txtProyectoFechaRealFin").val();
		formData += "&descripcion=" + $("#txtProyectoDescripcion").val();
		formData += "&idUsuarioDuenho=" + $("#idUsuarioDuenho").val();
		formData += "&idUsuario=" + $("#idUsuarioProy").val();
		formData += "&accionActual=" + $("#accionActual").val();		
		if ($("#chkProyectoActivo").is(':checked')) {
			formData += "&activo=1";
		} else {
			formData += "&activo=0";
		}
	
		proc_rows = $("#tablaFases").jqGrid("getRowData");
		var gridData = "";
		for ( var Elemento in proc_rows) {
			for ( var Propiedad in proc_rows[Elemento]) {
				if (Propiedad == "nombreFase" || Propiedad == "fechaIniPlan" || Propiedad == "fechaFinPlan" || Propiedad == "fechaIniReal" || Propiedad == "fechaFinReal")
					gridData += proc_rows[Elemento][Propiedad] + "|";
			}
		};
	
		formData += "&proc_data=" + gridData;
	
		$.ajax({
			type : "POST",
			url : "index.php/proyecto/proyectoValidateAndSave",
			data : formData,
			dataType : "json",
			success : function(retrievedData) {
				if (retrievedData.status != 0) {
					msgBoxInfo(retrievedData.msg);
				} else {
					if ($("#accionActual").val() == "") {
						msgBoxSucces("Registro agregado con \u00E9xito");
					} else {
						msgBoxSucces("Registro actualizado con \u00E9xito");						
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
	if($("#txtRecords").val() != ""){
		$("#accionActual").val("editando");
		$("#tabs-2").show();
		$("#tagBliblioteca").show();
		lockAutocomplete();
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
					$("#txtCoordinadorEnc").val(retrievedData.data.nombreEnc);
					$("#txtProyectoFechaPlanIni").val(
							retrievedData.data.fechaPlanIni);
					$("#txtProyectoFechaPlanFin").val(
							retrievedData.data.fechaPlanFin);
					$("#txtProyectoFechaRealIni").val(
							retrievedData.data.fechaRealIni);
					$("#txtProyectoFechaRealFin").val(
							retrievedData.data.fechaRealFin);
					$("#idUsuarioDuenho").val(retrievedData.data.idUsuario);
					$("#txtProyectoDescripcion").val(retrievedData.data.descripcion);
					$("#idUsuarioDuenho").val(retrievedData.data.idUsuario);
					$("#idUsuarioProy").val(retrievedData.data.idUsuarioEncargado);
					if (retrievedData.data.activo == '1') {
						// alert('ACTIVO');
						$("#chkProyectoActivo").attr('checked', true);
					} else {
						// alert('INACTIVO');
						$("#chkProyectoActivo").attr('checked', false);
					}
					$('#gridDocuments').setGridParam(
							{
								url : "index.php/proyecto/gridDocumentsLoad/"
									+ $("#idProyecto").val()
							}).trigger("reloadGrid");
					$("#tablaFases").jqGrid("GridUnload");
					loadGrid($("#idProyecto").val());
				}
			}
		});
	}else {
		msgBoxInfo("Debe seleccionar un PROYECTO a editar");
	}

}

function deleteData() {
	var formData = "idProyecto=" + $("#idProyecto").val();
	if($("#txtRecords").val() != ""){	
		if($("#idProyecto").val() == ""){
			msgBoxError("Debe seleccionar un PROYECTO a eliminar.");
		}
		else{
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
	}else {
		msgBoxInfo("Debe seleccionar un PROYECTO a eliminar");
	}
}

function validarCampos() {
	var camposFallan = "";
	
	if($("#txtProyectoNombre").val()!=""){
		if(!validarAlfaEsp($("#txtProyectoNombre").val())){
			camposFallan += "El campo NOMBRE contiene caracteres no validos <br/>";
		}
	}else{
		camposFallan += "El campo NOMBRE es requerido <br/>";
	}
	
	if($("#txtProyectoNombreDuenho").val()==""){
		camposFallan += "El campo DUE&Ntilde;O es requerido <br/>";
	}
	
	if($("#txtCoordinadorEnc").val()==""){
		camposFallan += "El campo COOR. ENCARGADO es requerido <br/>";
	}
	
	if ($("#txtProyectoDescripcion").val() != "") {
		if ($("#txtProyectoDescripcion").val().length > 256) {
			camposFallan += "Longutud de DESCRIPCION es mayor que 256 caracteres <br/>";
		}
	}
	
	if(camposFallan == ""){
		return true;
	}else{
		msgBoxInfo(camposFallan);
		return false;
	}
}

function validarCamposFases() {
	
	var camposFallan = "";

	if ($("#cbFases").val() == "") {
		camposFallan += "Debe seleccionar una FASE <br />";
	}
	
	if(camposFallan == ""){
		return true;
	}else{
		msgBoxInfo(camposFallan);
		return false;
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
	$("#chkProyectoActivo").attr('checked', false);
	$("#txtProyectoDescripcion").val();
	$("#idProyecto").val("0");
	$("#txtProyectoDescripcion").val("");
	$("#tablaFases").jqGrid("GridUnload");
	loadGrid($("#idProyecto").val());
	$("#tabs-2").hide();
	$("#tagBliblioteca").hide();
	unlockAutocomplete();
}

function addFase(){
	if(validarCamposFases()){
		$("#tablaFases").jqGrid('addRowData',faseCorrel,{nombreFase:$("#cbFases :selected").text(),fechaIniPlan:'2011-01-01',fechaFinPlan:'2011-01-01'},'last');
		faseCorrel++;
	}
}

function editFase(){
	var gr = jQuery("#tablaFases").jqGrid('getGridParam','selrow'); 
	if( gr != null ) 
		jQuery("#tablaFases").jqGrid('editGridRow',gr,{height:280,reloadAfterSubmit:false}); 
	else msgBoxInfo("Por favor seleccione una FASE a editar");
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
	if($("#accionActual").val() != ""){
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
	else{
		msgBoxInfo("Debe seleccionar un PROYECTO al cual subir los archivos");
	}
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
		// alert($idProyecto);
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

// Grid para mostrar las fases por proyecto
function loadGrid($idProyecto){
	var lastsel;
	var fases = "";

	$.ajax({
		type: "POST",
		url:  "index.php/proyecto/proyectoFaseRead",
		data: "fasesRetrieve",
		dataType : "json",
		async : false,
		success: function(retrievedData){
			if(retrievedData.status != 0){
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
			}else{
				$.each(retrievedData.data, function(i,obj) {
					fases += obj.id + ':' + obj.value + ';';
				});
				// fases = "";
				fases = fases.substring(0,fases.length-1);
				$("#fasesString").val(fases);
			}			      
		}      
	});
	fases = $("#fasesString").val();
	$("#tablaFases").jqGrid(
			{
				url : "index.php/proyecto/gridFasesProyecto/" + $("#idProyecto").val(),
				datatype : "json",
				mtype : "POST",
				colNames : [ "Cod.", "Nombre", "Fecha Inicial Plan.", "Fecha Fin Plan." ],
				colModel : [ {
					name : "idFase",
					index : "idFase",
					width : 0,
					hidden : true
				}, {
					name : "nombreFase",
					index : "nombreFase",
					editable : true,
					edittype:"select",editoptions:{value:fases},
					width : 180
				}, {
					name : "fechaIniPlan",
					index : "fechaIniPlan",
					width : 130,
					editable : true,
					editoptions:{size:10},
					editrules:{date:true},
					formatter:'date', 
					formatoptions: {newformat:'Y-m-d'}
				}, {
					name : "fechaFinPlan",
					index : "fechaFinPlan",
					width : 130,
					editable : true,
					editoptions:{size:10},
					editrules:{date:true},
					formatter:'date', 
					formatoptions: {newformat:'Y-m-d'}
				}],
				pager : "#pager",
				rowNum : 10,
				rowList : [ 10, 20, 30 ],
				sortname : "id",
				sortorder : "desc",
				ajaxGridOptions: {cache: false},
				loadonce : true,
				viewrecords : true,
				gridview : true,
				editurl: "proceso",
				caption : "Fases del proyecto"
			});
	$("#tablaFases").navGrid("#pager", {
		edit : false,
		add : false,
		del : true,
		refresh : false
	});

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
	$("#idProyecto").val("0");

}

/* OTRAS FUNCIONES */
function lockAutocomplete() {
	$("#btnSave").attr("disabled", false);	
	$("#txtRecords").attr("disabled", true);	
	$("#txtRecords").css({"background-color": "DBEBFF"});		
}

function unlockAutocomplete() {
	if($("#idRol").val() != 2){
		$("#btnSave").attr("disabled", true);
	}	
	$("#txtRecords").attr("disabled", false);
	$("#txtRecords").css({"background-color": "FFFFFF"});		
}