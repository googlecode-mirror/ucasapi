$(document).ready(function() {
	js_ini();
	$("#departamentoButton").addClass("highlight");
	departmentAutocomplete();
	loadGrid();
	ajaxUpload();
	
	//Esto se debería hacer para cada autocomplete de la página, para que muestre todos los registro en el focus
	$("#txtRecords").focus(function(){$("#txtRecords").autocomplete('search', '');});

});


function departmentAutocomplete() {
	$.ajax({
		type : "POST",
		url : "index.php/departamento/departmentAutocompleteRead",
		data : "departmentAutocomplete",
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				alert("Mensaje de error: " + retrievedData.msg); 
			} else {
				$("#txtRecords").autocomplete({
					minChars : 0,
					matchContains : true,
					source : retrievedData.data,
					minLength : 0,
					select : function(event, ui) {						
						$("#idDepto").val(ui.item.id);
						$(this).blur();//Dedicado al IE
					},
					//Esto es para el esperado mustMatch o algo parecido
					change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtRecords").val())){
							$("#txtRecords").val("");
							$("#idDepto").val("");
						}
					}
				});

			}
		}

	});
}



function save() {
	var formData = "";

	if (validarCampos()) {

		formData += "idDepto=" + $("#idDepto").val();
		formData += "&nombreDepto=" + $("#txtDepartmentName").val();
		formData += "&descripcion=" + $("#txtDepartmentDesc").val();
		formData += "&accionActual=" + $("#accionActual").val();

		$.ajax({
			type : "POST",
			url : "index.php/departamento/departmentValidateAndSave",
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
					departmentAutocomplete();
					clear();
				}
			}

		});
	}

}

function edit() {
	if ($("#txtRecords").val() != "" ) {
		$("#accionActual").val("editado");
		lockAutocomplete();
		var formData = "idDepto=" + $("#idDepto").val();
		$
				.ajax({
					type : "POST",
					url : "index.php/departamento/departmentRead",
					data : formData,
					dataType : "json",
					success : function(retrievedData) {
						if (retrievedData.status != 0) {
							alert("Mensaje de error: " + retrievedData.msg); 
						} else {
							$("#txtDepartmentName").val(
									retrievedData.data.nombreDepto);
							$("#txtDepartmentDesc").val(
									retrievedData.data.descripcion);

							$('#list')
									.setGridParam(
											{
												url : "index.php/departamento/gridRead/"
														+ $("#idDepto").val()
											}).trigger("reloadGrid");
						}
					}
				});
	} else {
		msgBoxInfo("Debe seleccionar un DEPARTAMENTO a editar");
	}

}

function deleteData() {
	if ($("#txtRecords").val() != "") {
		var formData = "idDepto=" + $("#idDepto").val();

		var answer = confirm("Está seguro que quiere eliminar el registro: "
				+ $("#txtRecords").val() + " ?");

		if (answer) {
			$.ajax({
				type : "POST",
				url : "index.php/departamento/departmentDelete",
				data : formData,
				dataType : "json",
				success : function(retrievedData) {
					if (retrievedData.status != 0) {
						msgBoxInfo(retrievedData.msg);
						// alert("Mensaje de error: " + retrievedData.msg);
						// //Por el
						// momento, el mensaje que se está mostrando es técnico,
						// para cuestiones de depuración
					} else {
						msgBoxSucces("Registro eliminado con éxito");
						// alert("Registro eliminado con éxito");
						departmentAutocomplete();
						clear();
					}
				}

			});
		}
	}else{
		msgBoxInfo("Debe seleccionar un DEPARTAMENTO a eliminar");
	}
}

function loadGrid() {
	$("#list").jqGrid({
		url : "index.php/departamento/gridRead/",
		datatype : "json",
		mtype : "POST",
		colNames : [ "Id", "Departamento" ],
		colModel : [ {
			name : "id",
			index : "id",
			width : 63
		}, {
			name : "value",
			index : "value",
			width : 190
		} ],
		pager : "#pager",
		rowNum : 10,
		rowList : [ 10, 20, 30 ],
		sortname : "id",
		sortorder : "desc",
		viewrecords : true,
		gridview : true,
		caption : "Departamentos"
	});
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
	$("#txtDepartmentDesc").val("");
	unlockAutocomplete();
}

function ajaxUpload() {
	new AjaxUpload("btnUpload", {
		debug : true,
		action : "index.php/upload/do_upload/",
		onSubmit : function(file, ext) {
			// Extensions allowed. You should add security check on the
			// server-side.
			if (ext && /^(txt|png|jpeg|docx)$/.test(ext)) {
				/* Setting data */
				this.setData({
					"key" : 'This string will be send with the file'
				});
				// $('#example2.text').text('Uploading ' + file);
			} else {
				// extension is not allowed
				// $('#example2.text').text('Error: only images are allowed');
				// cancel upload
				return false;
			}
		},
		onComplete : function(file, response) {
			alert(response);
		}
	});
}

function validarCampos() {

	var camposFallan = "";

	if ($("#txtDepartmentName").val() != "") {
		if (!validarAlfaEsp($("#txtDepartmentName").val())) {
			camposFallan += "El campo NOMBRE solo permite caracteres alfabeticos <br/>";
		}
	} else {
		camposFallan += "El campo NOMBRE es requerido <br/>";
	}

	if ($("#txtDepartmentDesc").val() != "") {
		if ($("#txtDepartmentDesc").val().length > 256) {
			camposFallan += "Longutud de DESCRIPCION es mayor que 256 caracteres <br/>";
		}
	} else {
		camposFallan += "El campo DESCRIPCION es requerido <br/>";
	}

	if (camposFallan == "") {
		return true;
	} else {
		msgBoxInfo(camposFallan);
		return false;
	}
}

/* OTRAS FUNCIONES DE VALIDACION Y LOCKING*/
function lockAutocomplete() {	
	$("#txtRecords").attr("disabled", true);	
	$("#txtRecords").css({"background-color": "DBEBFF"});		
}

function unlockAutocomplete() {
	$("#txtRecords").attr("disabled", false);
	$("#txtRecords").css({"background-color": "FFFFFF"});	
}