var faseCorrel = 0;

$(document).ready(function() {
	js_ini();
	$("#proyectoButton").addClass("highlight");
	$("#btnSave, #btnEdit").button();
	$("#txtFaseFin").css("margin-bottom", "20px");
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
	fileTypeAutocomplete();
	
	if($("#idRol").val() != 1){	
		$("#btnSave").attr("disabled", true);
	}
	
	$("#txtRecords").focus(function(){$("#txtRecords").autocomplete('search', '');});
	$("#txtCoordinadorEnc").focus(function(){$("#txtCoordinadorEnc").autocomplete('search', '');});	
	$("#txtRecordsUsuario").focus(function(){$("#txtRecordsUsuario").autocomplete('search', '');});
	$("#txtProyectoNombreDuenho").focus(function(){$("#txtProyectoNombreDuenho").autocomplete('search', '');});
	$("#txtFileType").focus(function(){$("#txtFileType").autocomplete('search', '');});
	
		
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
					minLength : 0,
					select : function(event, ui) {
						$("#idUsuarioProy").val(ui.item.id);
						$(this).blur();//Dedicado al IE
					},
					//Esto es para el esperado mustMatch o algo parecido
					change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtCoordinadorEnc").val())){
							$("#txtCoordinadorEnc").val("");
							$("#idUsuarioProy").val("");
						}
					}
				});

			}
		}

	});
}

function proyectoAutocomplete() {
	$.ajax({
		type : "POST",
		url : "index.php/proyecto/proyectoAutocompleteRead/" + $("#idUsuario").val() + "/" + $("#idRol").val(),
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
					minLength : 0,
					select : function(event, ui) {
						$("#idProyecto").val(ui.item.id);
						$(this).blur();//Dedicado al IE
					},
					//Esto es para el esperado mustMatch o algo parecido
					change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtRecords").val())){
							$("#txtRecords").val("");
							$("#idProyecto").val("");
						}
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
					minLength : 0,
					select : function(event, ui) {
						$("#idUsuario").val(ui.item.id);
						$(this).blur();//Dedicado al IE
					},
					//Esto es para el esperado mustMatch o algo parecido
					change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtRecordsUsuario").val())){
							$("#txtRecordsUsuario").val("");
							$("#idUsuario").val("");
						}
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
					minLength : 0,
					select : function(event, ui) {
						$("#idUsuarioDuenho").val(ui.item.id);
						$(this).blur();//Dedicado al IE
					},
					//Esto es para el esperado mustMatch o algo parecido
					change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtProyectoNombreDuenho").val())){
							$("#txtProyectoNombreDuenho").val("");
							$("#idUsuarioDuenho").val("");
						}
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
	if($("#txtRecords").val() != "" && $("#idProyecto").val() != "0" ){
		var formData = "idProyecto=" + $("#idProyecto").val();
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
	if($("#txtRecords").val() != "" && $("#idProyecto").val() != "0"){
		var formData = "idProyecto=" + $("#idProyecto").val();
		if($("#idProyecto").val() == ""){
			msgBoxError("Debe seleccionar un PROYECTO a eliminar.");
		}
		else{
			var answer = confirm("Est� seguro que quiere eliminar el registro: "
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
	
							msgBoxSucces("Registro eliminado con �xito");
	
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
		if(!validarAlfaEspNum($("#txtProyectoNombre").val())){
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
	
	if ($("#txtProyectoFechaPlanFin").val() != "" &&	 $("#txtProyectoFechaPlanIni").val() != "") { 
		if(!validateOverlapFechas($("#txtProyectoFechaPlanFin").val(),$("#txtProyectoFechaPlanIni").val())) {
			 camposFallan += "<p><dd> El campo INICIO PLANIFICADO debe ser menor o igual a FIN PLANIFICADO </dd><br/></p>";
		}
	}
	
	if ($("#txtProyectoFechaRealFin").val() != "" &&	 $("#txtProyectoFechaRealIni").val() != "") { 
		if(!validateOverlapFechas($("#txtProyectoFechaRealFin").val(),$("#txtProyectoFechaRealIni").val())) {
			 camposFallan += "<p><dd> El campo INICIO REAL debe ser menor o igual a FIN REAL </dd><br/></p>";
		}
	}
	
	if(camposFallan == ""){
		return true;
	}else{
		camposFallan = "Se encontraron los siguientes problemas:<br/>" + camposFallan;
		msgBoxInfo(camposFallan);
		return false;
	}
}

function validarCamposFases() {
	
	var camposFallan = "";

	if ($("#cbFases").val() == "") {
		camposFallan += "<p><dd>Debe seleccionar una FASE </dd><br/></p>";
	}
	if($("#txtFaseIni").val() == ""){
		camposFallan += "<p><dd>Debe ingresar la fecha Inicial de la fase</dd><br/></p>";
	}
	if($("#txtFaseFin").val() == ""){
		camposFallan += "<p><dd>Debe ingresar la fecha Final de la fase</dd><br/></p>";
	}
	
	if ($("#txtFaseIni").val() != "" &&	 $("#txtFaseFin").val() != "") { 
		if(!validateOverlapFechas($("#txtFaseFin").val(),$("#txtFaseIni").val())) {
			 camposFallan += "<p><dd> El campo FECHA INICIO debe ser menor o igual a FECHA FIN para las fases</dd><br/></p>";
		}
	}
			
	if(camposFallan == ""){
		return true;
	}else{
		camposFallan = "Se encontraron los siguientes problemas:<br/>" + camposFallan;
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
	$('#tabs').tabs({ selected: 0 }); 
	$("#tabs-2").hide();
	$("#tagBliblioteca").hide();
	unlockAutocomplete();
}

function addFase(){
	if(validarCamposFases()){
		$("#tablaFases").jqGrid('addRowData',faseCorrel,{nombreFase:$("#cbFases :selected").text(),fechaIniPlan: $("#txtFaseIni").val(),fechaFinPlan:$("#txtFaseFin").val()},'last');
		jQuery("#tablaFases").jqGrid('editGridRow',faseCorrel,{height:280,reloadAfterSubmit:false}); 
		faseCorrel++;
		$("#txtFaseIni, #txtFaseFin").val("");
	}
}

function editFase(){	
	var gr = jQuery("#tablaFases").jqGrid('getGridParam','selrow'); 
	if( gr != null ){
		jQuery("#tablaFases").jqGrid('editGridRow',gr,{height:280,reloadAfterSubmit:false}); 
		$("#fechaIniPlan, #fechaFinPlan").datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true , changeYear: true, yearRange: '1920:c+5'});
	}
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
			if (!(ext && /^(txt|png|jpeg|docx|doc|rtf|ppt|pptx|bmp|gif|xls|xlsx|odt|ods|odp|odb|odf|odg|csv|pdf)$/.test(ext))) {
				//msgBoxInfo("El tipo de archivo no est� perimitido");
				//return false;
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

// Funci�n asociada al bot�n "Agregar"
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
		upload.setData({// Datos adicionales en el env�o del archivo
			uploadIdName : "idProyecto",
			uploadIdValue : $("#idProyecto").val()
		});
		upload.submit();
	}
	else{
		msgBoxInfo("Debe seleccionar un PROYECTO al cual subir los archivos");
	}
}


function fileTypeAutocomplete(){
	$.ajax({				
        type: "POST",
        url:  "index.php/actividada/fileTypeAutocomplete",
        dataType : "json",
        success: function(retrievedData){        	
        	if(retrievedData.status != 0){
        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se est� mostrando es t�cnico, para cuestiones de depuraci�n
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
    		        select: function(event, ui) {
    			        $("#idTipoArchivo").val(ui.item.id);
    			        $(this).blur();//Dedicado al IE
    				}
        		
    			});
        		
        	}        	
      }
      
	});		
}


// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------

// Funci�n desencadenada en el onComplete de la subida del archivo y asociada al
// bot�n "Actualizar"
function saveFileData(fileName) {
	$idProyecto = $("#idProyecto").val();
	var formData = "nombreArchivo=" + fileName;
	formData += "&idProyecto=" + $("#idProyecto").val();
	formData += "&descripcion=" + $("#txtFileDesc").val();
	formData += "&tituloArchivo=" + $("#txtFileName").val();
	formData += "&idTipoArchivo=" + $("#idTipoArchivo").val();
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
						msgBoxSucces("Documento agregado con �xito");
					} else {
						msgBoxSucces("Documento actualizado con �xito");
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
				alert("Mensaje de error: " + retrievedData.msg); 
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
		colNames : [ "Id", "Tipo", "T�tulo","Nombre", "Subido", "Descripcion", "idTipo" ],
		colModel : [ {name : "idArchivo",index : "idArchivo",width : 20,hidden : true},
		             {name : "Tipo",index : "Tipo",width : 160}, 
		             {name : "T�tulo",index : "T�tulo",width : 160}, 
		             {name : "Nombre",index : "Nombre", width : 160}, 
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
		shrinkToFit: false,

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

// Permite la edici�n de los datos del archivo seleccionado
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
		$("#txtFileName").val(rowData["T�tulo"]);
		$("#txtFileType").val(rowData["Tipo"]);
		$("#idTipoArchivo").val(rowData["idTipoArchivo"]);
	}
}

// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------

// Permite la eliminaci�n de los datos del archivo seleccionado
function deleteFile() {
	rowId = $("#gridDocuments").jqGrid("getGridParam", "selrow");
	if (rowId == null) {
		msgBoxInfo("Debe seleccionar un archivo para editar");
	} else {
		rowData = $("#gridDocuments").jqGrid("getRowData", rowId);
		idArchivo = rowData["idArchivo"];
		nombreArchivo = rowData["Nombre"];
		var formData = "idArchivo=" + idArchivo;
		formData+="&nombreArchivo="+nombreArchivo;
		var answer = confirm("Est� seguro que quiere eliminar el documento?");
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
						msgBoxSucces("Documento eliminado con �xito");
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

/* OTRAS FUNCIONES */
function lockAutocomplete() {
	$("#btnSave").attr("disabled", false);	
	$("#txtRecords").attr("disabled", true);	
	$("#txtRecords").css({"background-color": "DBEBFF"});		
}

function unlockAutocomplete() {
	if($("#idRol").val() != 1){
		$("#btnSave").attr("disabled", true);
	}	
	$("#txtRecords").attr("disabled", false);
	$("#txtRecords").css({"background-color": "FFFFFF"});		
}