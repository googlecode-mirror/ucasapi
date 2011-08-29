$(document).ready(function() {
	// $("#chkUsuarioActivo").button();
	js_ini();
	$("#usuarioButton").addClass("highlight");
	usuarioAutocomplete();
	usuarioCargoAutocomplete();
	usuarioDepartamentoAutocomplete();
	loadGrid();
	loadGridTR();
	
	$("#txtRecords").focus(function(){$("#txtRecords").autocomplete('search', '');});
	$("#txtUsuarioDepartamento").focus(function(){$("#txtUsuarioDepartamento").autocomplete('search', '');});
	$("#txtUsuarioCargo").focus(function(){$("#txtUsuarioCargo").autocomplete('search', '');});

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
					//Esto es para el esperado mustMatch o algo parecido
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
				$("#txtUsuarioRolNombre").autocomplete({
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

function usuarioDepartamentoAutocomplete() {
	$.ajax({
		type : "POST",
		url : "index.php/usuario/usuarioDepartamentoAutocompleteRead",
		data : "usuarioDepartamentoAutocomplete",
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				alert("Mensaje de error: " + retrievedData.msg); // Por el

			} else {
				$("#txtUsuarioDepartamento").autocomplete({
					minChars : 0,
					source : retrievedData.data,
					minLength : 0,
					select : function(event, ui) {
						$("#idDepto").val(ui.item.id);
						$(this).blur();//Dedicado al IE
					},
					//Esto es para el esperado mustMatch o algo parecido
					change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtUsuarioDepartamento").val())){
							$("#txtUsuarioDepartamento").val("");
							$("#idDepto").val("");
						}
					}
				});

			}
		}

	});
}

function usuarioCargoAutocomplete() {
	$.ajax({
		type : "POST",
		url : "index.php/usuario/usuarioCargoAutocompleteRead",
		data : "usuarioCargoAutocomplete",
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				alert("Mensaje de error: " + retrievedData.msg); // Por el

			} else {
				$("#txtUsuarioCargo").autocomplete({
					minChars : 0,
					source : retrievedData.data,
					minLength : 0,
					select : function(event, ui) {
						$("#idCargo").val(ui.item.id);
						$(this).blur();//Dedicado al IE
					},
					//Esto es para el esperado mustMatch o algo parecido
					change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtUsuarioCargo").val())){
							$("#txtUsuarioCargo").val("");
							$("#idCargo").val("");
						}
					}
				});

			}
		}

	});
}


// grid donde estan lo roles que el usuario tiene asignados actualmente
function loadGrid() {
	$("#list").jqGrid(
			{
				url : "index.php/usuario/gridRolesUsuarioRead/"
						+ $("#idUsuario").val(),
				datatype : "json",
				mtype : "POST",
				colNames : [ "ID", "Rol", "Asignado" ],
				colModel : [ {
					name : "idRol",
					index : "idRol",
					width : 63,
					hidden : true
				}, {
					name : "nombreRol",
					index : "nombreRol",
					width : 250
				}, {
					name : "fechaAsignacionSistema",
					index : "fechaAsignacionSistema",
					width : 200,
					hidden : true
				} ],
				pager : "#pager",
				rowNum : 10,
				rowList : [ 10, 20, 30 ],
				sortname : "id",
				sortorder : "desc",
				// loadonce : true,
				viewrecords : true,
				gridview : true,
				caption : "Roles del usuario"
			});
}

// grid donde se encuentran todos los roles asignables
function loadGridTR() {

	$("#todosRoles").jqGrid({
		url : "index.php/usuario/gridRead/" + $("#idUsuario").val(),
		datatype : "json",
		mtype : "POST",
		colNames : [ "ID", "Rol", "ASIGNADO" ],
		colModel : [ {
			name : "idRol",
			index : "idRol",
			width : 63,
			hidden : true
		}, {
			name : "nombreRol",
			index : "nombreRol",
			width : 250
		}, {
			name : "fechaAsignacionSistema",
			index : "fechaAsignacionSistema",
			width : 190,
			hidden : true
		} ],
		pager : "#pagerTR",
		rowNum : 10,
		rowList : [ 10, 20, 30 ],
		sortname : "id",
		sortorder : "desc",
		// loadonce : true,
		viewrecords : true,
		gridview : true,
		caption : "Roles asignables"
	});
}

function agregarRol() {
	// obteniendo el rol seleccionado del grid de todos los roles
	row_id = $("#todosRoles").jqGrid("getGridParam", "selrow");
	row_data = $("#todosRoles").jqGrid("getRowData", row_id);

	// insertando los valores en el otro grid
	if (row_id != null) {
		num_rows = $("#list").getGridParam("records");// N�mero de filas en
														// el
		// grid
		new_row_data = {
			"idRol" : row_data["idRol"],
			"nombreRol" : row_data["nombreRol"],
			"fechaAsignacionSistema" : row_data["fechaAsignacionSistema"]
		};
		$("#list").addRowData(num_rows + 1, new_row_data);

		// borrando del grid de todos los roles, el rol que ya se selecciono
		$("#todosRoles").delRowData(row_id);
	}

}

function eliminarRol() {
	// obteniendo el rol seleccionado del grid de todos los roles
	row_id = $("#list").jqGrid("getGridParam", "selrow");
	row_data = $("#list").jqGrid("getRowData", row_id);

	// insertando los valores en el otro grid
	if (row_id != null) {
		num_rows = $("#todosRoles").getGridParam("records");// N�mero de filas
		// en el
		// grid
		new_row_data = {
			"idRol" : row_data["idRol"],
			"nombreRol" : row_data["nombreRol"],
			"fechaAsignacionSistema" : row_data["fechaAsignacionSistema"]
		};
		$("#todosRoles").addRowData(num_rows + 1, new_row_data);

		// borrando del grid de todos los roles, el rol que ya se selecciono
		$("#list").delRowData(row_id);
	}
}

function save() {
	var formData = "";
	
	
	formData += "idUsuario=" + $("#idUsuario").val();
	formData += "&codEmp=" + $("#txtUsuarioCodigo").val();
	formData += "&primerNombre=" + $("#txtUsuarioPrimerNombre").val();
	formData += "&otrosNombres=" + $("#txtUsuarioOtrosNombres").val();
	formData += "&primerApellido=" + $("#txtUsuarioPrimerApellido").val();
	formData += "&otrosApellidos=" + $("#txtUsuarioOtrosApellidos").val();
	formData += "&username=" + $("#txtUsuarioUserName").val();
	formData += "&password=" + $("#txtUsuarioPassword").val();
	formData += "&confirmacion=" + $("#txtUsuarioConfirmacion").val();
	formData += "&dui=" + $("#txtUsuarioDUI").val();
	formData += "&nit=" + $("#txtUsuarioNIT").val();
	formData += "&isss=" + $("#txtUsuarioISSS").val();
	formData += "&nup=" + $("#txtUsuarioNUP").val();
	formData += "&emailPersonal=" + $("#txtUsuarioEmailPersonal").val();
	formData += "&emailInstitucional="
			+ $("#txtUsuarioEmailInstitucional").val();
	formData += "&carnet=" + $("#txtUsuarioCarnet").val();
	formData += "&idCargo=" + $("#idCargo").val();
	formData += "&idDepto=" + $("#idDepto").val();
	formData += "&extension=" + $("#txtUsuarioExtension").val();
	formData += "&telefonoContacto=" + $("#txtUsuarioTelefono").val();
	formData += "&fechaNacimiento=" + $("#txtProyectoFechaNacimiento").val();
	formData += "&accionActual=" + $("#accionActual").val();
	

	rol_rows = $("#list").jqGrid("getRowData");
	var gridData = "";
	for ( var Elemento in rol_rows) {
		for ( var Propiedad in rol_rows[Elemento]) {
			gridData += rol_rows[Elemento][Propiedad] + "|";
		}
	}
	;

	formData += "&rol_data=" + gridData;

	if ($("#chkUsuarioActivo").is(':checked')) {
		// alert('ACTIVO');
		formData += "&activo=1";
	} else {
		// alert('INACTIVO');
		formData += "&activo=0";
	}

	// alert(formData);

	if (validar_campos()) {

		$.ajax({
			type : "POST",
			url : "index.php/usuario/usuarioValidateAndSave",
			data : formData,
			dataType : "json",
			success : function(retrievedData) {
				if (retrievedData.status != 0) {
					msgBoxInfo(retrievedData.msg);
				} else {
					if ($("#accionActual").val() == "") {

						msgBoxSucces("Registro agregado con \u00e9xito");

					} else {
						msgBoxSucces("Registro actualizado con \u00e9xito");
					}
					usuarioAutocomplete();
					usuarioCargoAutocomplete();
					usuarioDepartamentoAutocomplete()
					clear();
				}
			}
		});
	}

}

function edit() {	
	if($("#idUsuario").val()!=""){
		var formData = "idUsuario=" + $("#idUsuario").val();	
		$("#accionActual").val("editando");
		formData += "&accionActual=" + $("#accionActual").val();
		lockAutocomplete();
		// grid donde se cargan los roles que un usuario tiene asignados
		$('#list').setGridParam({
			url : "index.php/usuario/gridRolesUsuarioRead/" + $("#idUsuario").val()
		}).trigger("reloadGrid");
		// grid donde se cargan todos los roles que son asignables
		$('#todosRoles').setGridParam({
			url : "index.php/usuario/gridRead/" + $("#idUsuario").val()
		}).trigger("reloadGrid");
	
		loadGrid();
		loadGridTR();
		$.ajax({
			type : "POST",
			url : "index.php/usuario/usuarioRead",
			data : formData,
			dataType : "json",
			success : function(retrievedData) {
				if (retrievedData.status != 0) {
					alert("Mensaje de error: " + retrievedData.msg); // Por
																		// el
				} else {
					$("#txtUsuarioCodigo").val(retrievedData.data.codEmp);
					$("#txtUsuarioPrimerNombre").val(
							retrievedData.data.primerNombre);
					$("#txtUsuarioOtrosNombres").val(
							retrievedData.data.otrosNombres);
					$("#txtUsuarioPrimerApellido").val(
							retrievedData.data.primerApellido);
					$("#txtUsuarioOtrosApellidos").val(
							retrievedData.data.otrosApellidos);
					$("#txtUsuarioUserName").val(retrievedData.data.username);
					$("#txtUsuarioPassword").val(retrievedData.data.password);
					$("#txtUsuarioConfirmar").val(retrievedData.data.password);
					$("#txtUsuarioDUI").val(retrievedData.data.dui);
					$("#txtUsuarioNIT").val(retrievedData.data.nit);
					$("#txtUsuarioISSS").val(retrievedData.data.isss);
					$("#txtUsuarioNUP").val(retrievedData.data.nup);
					$("#txtUsuarioDepartamento")
							.val(retrievedData.data.nombreDepto);
					$("#txtUsuarioCargo").val(retrievedData.data.nombreCargo);
					$("#txtUsuarioCarnet").val(retrievedData.data.carnet);
					$("#txtUsuarioEmailPersonal").val(
							retrievedData.data.emailPersonal);
					$("#txtUsuarioEmailInstitucional").val(
							retrievedData.data.emailInstitucional);
					$("#txtUsuarioExtension").val(retrievedData.data.extension);
					$("#idDepto").val(retrievedData.data.idDepto);
					$("#idCargo").val(retrievedData.data.idCargo);
					$("#txtProyectoFechaNacimiento").val(
							retrievedData.data.fechaNacimiento);
					$("#txtUsuarioTelefono").val(
							retrievedData.data.telefonoContacto);
					$("#txtUsuarioExtension").val(retrievedData.data.extension);
	
					if (retrievedData.data.activo == '1') {
	
						$("#chkUsuarioActivo").attr('checked', true);
					} else {
	
						$("#chkUsuarioActivo").attr('checked', false);
					}
	
				}
			}
		});
	}else{
		msgBoxInfo("Debe seleccionar un usuario a editar");
	}

}

function deleteData() {
	
	if($("#txtRecords").val() != "" && $("#idUsuario").val() != ""){
		var formData = "idUsuario=" + $("#idUsuario").val();
	
		var answer = confirm("Est\00e1 seguro que quiere eliminar el registro: "
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
					} else {
	
						// msgBoxSucces("<p>Registro eliminado con �xito</p>");
						msgBoxSucces("Registro eliminado con \u00e9xito");
						// alert("Registro eliminado con �xito");
	
						usuarioAutocomplete();
						usuarioCargoAutocomplete();
						usuarioDepartamentoAutocomplete()
						clear();
					}
				}
	
			});
		}
	}else{
		msgBoxInfo("Debe seleccionar un usuario a eliminar");
	}
}

function validar_campos() {
	var camposFallan = "";
	
	if($("#txtUsuarioPrimerNombre").val()!=""){
		if(!validarAlfa($("#txtUsuarioPrimerNombre").val())){
			camposFallan += "<p><dd>El campo PRIMER NOMBRE contiene caracteres no validos </dd><br/></p>";
		}
	}else{
		camposFallan += "<p><dd>El campo PRIMER NOMBRE es requerido </dd><br/></p>";
	}
	
	if($("#txtUsuarioOtrosNombres").val()!=""){
		if(!validarAlfaEsp($("#txtUsuarioOtrosNombres").val())){
			camposFallan += "<p><dd>El campos OTROS NOMBRES contiene caracteres no validos </dd><br/></p>";
		}
	}
	
	if($("#txtUsuarioPrimerApellido").val()!=""){
		if(!validarAlfa($("#txtUsuarioPrimerApellido").val())){
			camposFallan += "<p><dd>El campo PRIMER APELLIDO contiene caracteres no validos </dd><br/></p>";
		}
	}else{
		camposFallan += "<p><dd>El campo PRIMER APELLIDO es requerido </dd><br/></p>";
	}
	
	if($("#txtUsuarioOtrosApellidos").val()!=""){
		if(!validarAlfaEsp($("#txtUsuarioOtrosApellidos").val())){
			camposFallan += "<p><dd>El campo OTROS APELLIDOS contiene caracteres no validos </dd><br/></p>";
		}
	}
	
	if ($("#txtUsuarioPassword").val() == ""
			|| $("#txtUsuarioConfirmar").val() == "") {		
		camposFallan += "<p><dd>Complete la Contrase\u00f1s </dd><br/></p>";		
	}
	if ($("#txtUsuarioPassword").val() < 4) {		
		camposFallan += "<p><dd>La contrase\u00f1a debe ser mayor de 4 digitos </dd><br/></p>";			
	}
	if ($("#txtUsuarioConfirmar").val() == "") {
		camposFallan += "<p><dd>Debe confirmar la contrase\u00f1a </dd><br/></p>";		
	}

	if ($("#txtUsuarioPassword").val() != $("#txtUsuarioConfirmar").val()) {
		camposFallan += "<p><dd>La contrase\u00f1a confirmada no concuerda con la contrase\u00f1a escrita </dd><br/></p>";		
	}
	
	if ($("#txtUsuarioPassword").val() != $("#txtUsuarioConfirmar").val()) {
		camposFallan += "<p><dd>La contrase\u00f1a confirmada no concuerda con la contrase\u00f1a escrita </dd><br/></p>";		
	}
	
	/* validacions de documentos personales */
	if($("#txtUsuarioDUI").val()!=""){
		if(!validarDUI($("#txtUsuarioDUI").val())){
			camposFallan += "<p><dd>Formato de DUI es incorrecto o contiene caracteres no validos </dd><br/></p>";
		}
	}else{
		camposFallan += "<p><dd>El campo DUI es requerido </dd><br/></p>";
	}
	
	if($("#txtUsuarioNIT").val()!=""){
		if(!validarNIT($("#txtUsuarioNIT").val())){
			camposFallan += "<p><dd>Formato de NIT es incorrecto o contiene caracteres no validos </dd><br/></p>";
		}
	}else{
		camposFallan += "<p><dd>El campo NIT es requerido </dd><br/></p>";
	}
	
	if($("#txtUsuarioISSS").val()!=""){
		if(!validarISSS($("#txtUsuarioISSS").val())){
			camposFallan += "<p><dd>Formato de ISSS es incorrecto o contiene caracteres no validos </dd><br/></p>";
		}
	}else{
		camposFallan += "<p><dd>El campo ISSS es requerido </dd><br/></p>";
	}
	
	if($("#txtUsuarioNUP").val()!=""){
		if(!validarNUP($("#txtUsuarioNUP").val())){
			camposFallan += "<p><dd>Formato de NUP es incorrecto o contiene caracteres no validos </dd><br/></p>";
		}
	}
	
	if($("#txtUsuarioDepartamento").val()=="" || $("#txtUsuarioDepartamento").val()==""){
		camposFallan += "<p><dd>El campos DEPARTAMENTO es requerido </dd><br/></p>";
	}
	
	if($("#txtUsuarioCargo").val()=="" && $("#idCargo").val()==""){
		camposFallan += "<p><dd>El campos CARGO es requerido </dd><br/></p>";
	}
	
	
	if($("#txtUsuarioCarnet").val()!=""){
		if(!validarCarnet($("#txtUsuarioCarnet").val())){
			camposFallan += "<p><dd>Formato de CARNET es incorrecto o contiene caracteres no validos </dd><br/></p>";
		}
	}
	
	if($("#txtUsuarioCodigo").val()!=""){
		if(!validarCodEmpleado($("#txtUsuarioCodigo").val())){
			camposFallan += "<p><dd>Formato de CODIGO es incorrecto o contiene caracteres no validos </dd><br/></p>";
		}
	}else{
		camposFallan += "<p><dd>El campo C\u00d3DIGO es requerido </dd><br/></p>";
	}
	
	
	/* mail validations */
	if($("#txtUsuarioEmailPersonal").val()!=""){
		if(!validarEmail($("#txtUsuarioEmailPersonal").val())){
			camposFallan += "<p><dd>El correo electronico personal tiene un formato incorrecto </dd><br/></p>";
		}
	}
	
	if($("#txtUsuarioEmailInstitucional").val()!=""){
		if(!validarEmail($("#txtUsuarioEmailInstitucional").val())){
			camposFallan += "<p><dd>El correo electronico institucional tiene un formato incorrecto </dd><br/></p>";
		}
	}
	
	if($("#txtUsuarioTelefono").val()!=""){
		if(!validarTelefono($("#txtUsuarioTelefono").val())){
			camposFallan += "<p><dd>Formato de telefono incorrecto </dd><br/></p>";
		}
	}
	
	if($("#txtUsuarioExtension").val()!=""){
		if(!validarExtension($("#txtUsuarioExtension").val())){
			camposFallan += "<p><dd>Formato de extensi\u00f3n incorrecto </dd><br/></p>";
		}
	}
	
	if(camposFallan == ""){
		return true;
	}else{
		camposFallan = "Se encontraron los siguientes problemas:" + camposFallan;
		msgBoxInfo(camposFallan);
		return false;
	}
	return true
}

function cancel() {
	// $("#btnCancel").toggleClass('ui-state-active');
	clear();
	clearGrids();
	$("#msgBox").hide();
}

function clear() {
	$(".inputField").val("");
	$(".inputFieldPSW").val("");
	$(".jqcalendario").val("");
	$(".hiddenId").val("");
	$("#txtRecords").val("");
	$("#chkUsuarioActivo").attr('checked', false);
	$("#accionActual").val("");
	unlockAutocomplete();
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

function clearGrids(){
	// grid donde se cargan los roles que un usuario tiene asignados
	$('#list').setGridParam({
		url : "index.php/usuario/gridRolesUsuarioRead/" + -1
	}).trigger("reloadGrid");
	// grid donde se cargan todos los roles que son asignables
	$('#todosRoles').setGridParam({
		url : "index.php/usuario/gridRead/" + -1
	}).trigger("reloadGrid");
}