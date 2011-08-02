$(document).ready(function() {
	js_ini();
	// $("#chkUsuarioActivo").button();
	usuarioAutocomplete();
	loadGridUsuarioHistorico();
});

function usuarioAutocomplete() {
	$.ajax( {
		type : "POST",
		url : "index.php/usuario/usuarioAutocompleteRead",
		data : "usuarioAutocomplete",
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				alert("Mensaje de error: " + retrievedData.msg); // Por el

			} else {
				$("#txtRecords").autocomplete( {
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

/*
 * function loadGrid() { $("#list").jqGrid( { toppager: true, datatype : "json",
 * mtype : "POST", colNames : [ "ID", "Rol", "Asignado" ], colModel : [ { name :
 * "idRol", index : "idRol", width : 63 }, { name : "nombreRol", index :
 * "nombreRol", width : 190 }, { name : "fechaAsignacionSistema", index :
 * "fechaAsignacionSistema", width : 200 } ], pager : '#gridpager', });
 * $("#list").navGrid('#gridpager',{edit:false,add:false,del:false,search:false,
 * refresh : false}) .navButtonAdd('#gridpager', { caption:"",
 * buttonicon:"ui-icon ui-icon-plusthick", onClickButton: function(){
 * alert("Adding Row"); }, position:"last" }) .navButtonAdd('#gridpager',{
 * caption:"", buttonicon:"ui-icon ui-icon-pencil", onClickButton: function(){
 * alert("Deleting Row"); }, position:"last" }) .navButtonAdd('#gridpager',{
 * caption:"", buttonicon:"ui-icon ui-icon-trash", onClickButton: function(){
 * alert("Deleting Row"); }, position:"last" })
 * .navSeparatorAdd("#gridpager",{}); }
 */

// grid donde estan todos los contratos de ese usuario
function loadGridUsuarioHistorico() {
	$("#usuarioHist").jqGrid(
			{
				url : "index.php/usuario/gridRolesUsuarioRead/"
						+ $("#idUsuario").val(),
				datatype : "json",
				mtype : "POST",
				colNames : [ "Inicio contrato", "Fin contrato",
						"Tiempo contrato", "Estado", "correlContrato", "idUsuario" ],
				colModel : [ {
					name : "fechaInicioContrato",
					index : "fechaInicioContrato",
					width : 190
				}, {
					name : "fechaFinContrato",
					index : "fechaFinContrato",
					width : 190
				}, {
					name : "tiempoContrato",
					index : "tiempoContrato",
					width : 100
				}, {
					name : "activo",
					index : "activo",
					width : 190
				}, {
					name : "correl",
					index : "correl",
					width : 70
				}, {
					name : "UID",
					index : "UID",
					width : 70
				} ],
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

	alert(formData);

	if (validar_campos()) {

		$.ajax( {
			type : "POST",
			url : "index.php/usuario/usuarioValidateAndSave",
			data : formData,
			dataType : "json",
			success : function(retrievedData) {
				if (retrievedData.status != 0) {
					msgBoxInfo(retrievedData.msg);
				} else {
					if ($("#idUsuario").val() == "") {

						/*
						 * msgBoxSucces("<p>Registro agregado con éxito</p>");
						 * alert("Registro agregado con éxito");
						 */

						msgBoxSucces("Registro agregado con éxito");

					} else {
						msgBoxSucces("Registro actualizado con éxito");
						alert("Registro actualizado con éxito");
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
	var formData = "idUsuario=" + $("#idUsuario").val();
	// grid donde se cargan los roles que un usuario tiene asignados
	$('#list').setGridParam({url:"index.php/historicoUsuario/gridContratoUsuarioRead/"+$("#idUsuario").val()}).trigger("reloadGrid");
	// grid donde se cargan todos los roles que son asignables
	$('#todosRoles').setGridParam( {
		url : "index.php/usuario/gridRead/" + $("#idUsuario").val()
	}).trigger("reloadGrid");

	loadGrid();
	loadGridTR();
	$.ajax( {
		type : "POST",
		url : "index.php/usuario/usuarioRead",
		data : formData,
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				alert("Mensaje de error: " + retrievedData.msg);
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
				// alert(retrievedData.data.activo);
				if (retrievedData.data.activo == '1') {
					// alert('ACTIVO');
					$("#chkUsuarioActivo").attr('checked', true);
				} else {
					// alert('INACTIVO');
					$("#chkUsuarioActivo").attr('checked', false);
				}
			}
		}
	});

}

function deleteData() {
	var formData = "idUsuario=" + $("#idUsuario").val();

	var answer = confirm("Está seguro que quiere eliminar el registro: "
			+ $("#txtRecords").val() + " ?");

	if (answer) {
		$.ajax( {
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

$("#chkUsuarioActivo").change(function() {
	alert('Handler for .change() called.');
});
