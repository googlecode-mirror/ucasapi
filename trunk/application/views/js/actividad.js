$(document).ready(function(){
	js_ini();
	$("#sessionUser").text(($("#sessionUser").text()).replace(/%20/g, " "));


	//$("button").button({icons: {primary: "ui-icon-locked"}});
	$("#actividadgButton").addClass("highlight");
	estadoAutocomplete();
	loadGrid();
	loadGridTR();
});

var idUsuariosQuitar = new Array();
var idUsuariosAdd = new Array();
var arrayUserSet = new Array();
var arrayUserUnset = new Array();
var aBand = 0; //Bandera para ver si ha asignado a alguien
var dBand = 0; //Bandera para ver si ha desasignado a alguien

function estadoAutocomplete(){
	//index.php/actividad/actividadEstados
	$.ajax({				
		type: "POST",
		url:  "/ucasapi/actividad/actividadEstados",
		data: "statusAutocomplete",
		dataType : "json",
		success: function(retrievedData){        	 
			options = '<option value="0">--Estado--</option>';
			$.each(retrievedData.data, function(i,obj) {
				options += '<option value="' + obj.idEstado + '">' + obj.estado + '</option>';
			});			
			$("#cbEstado").html(options);
			actividadData();

		}
	});
}

function save(){
	
	if(validarCampos()){
	
		var formData = "idEstado=" + $("#cbEstado").val()
		formData += "&idProyecto=" + $("#idProyecto").val();
		formData += "&idActividad=" + $("#idActividad").val();
		formData += "&idUsuario=" + $("#idUsuario").val();
		formData += "&progreso=" + $("#cbProgreso").val();
		formData += "&comentario=" + $("#txtComentarios").val();
	
		user_rows = $("#list").jqGrid("getRowData");
		var gridData = "";
		for ( var Elemento in user_rows) {
			for ( var Propiedad in user_rows[Elemento]) {
				if (Propiedad == "idUsuario"){
					if (user_rows[Elemento][Propiedad] == $("#idUsuario").val()){
						continue;
					}
					else{
						gridData += user_rows[Elemento][Propiedad] + "|";
					}
				}
	
			}
		};
	
		if(idUsuariosAdd.length != 0){
			formData += "&add_data=" + idUsuariosAdd;
			formData += "&asignarBand=1";
		}
		else{
			formData += "&add_data=0";
			formData += "&asignarBand=0";
		}
	
		formData += "&user_data=" + gridData;
		if(idUsuariosQuitar.length != 0){
			formData += "&remove_data=" + idUsuariosQuitar;
			formData += "&desasignarBand=1";
		}
		else{
			formData += "&remove_data=0";
			formData += "&desasignarBand=0";
		}
		$.ajax({
			type: "POST",
			url: "/ucasapi/actividad/actividadValidateAndSave",
			data: formData,
			dataType: "json",
			success: function(retrievedData){
				if(retrievedData.status != 0){
					alert("Mensaje de error: " + retrievedData.msg);
				}
				else{
					msgBoxSucces("Actividad actualizada con éxito");
					idUsuariosQuitar = new Array();
					idUsuariosAdd = new Array();
				}
			}
	
		});
	}
	
}

function validarCampos() {
	var camposFallan = "";
	if($("#cbEstado").val() == "0"){
		camposFallan +=  "<p><dd>Debe seleccionar un Estado valido</dd><br/></p>";
	}
	if($("#cbProgreso").val() == "0"){
		camposFallan += "<p><dd>Debe seleccionar un Progreso valido</dd><br/></p>";
	}
	
	if (camposFallan == "") {
		return true;
	} else {
		camposFallan = "Se han encontrado los siguientes problemas:" + camposFallan;
		msgBoxInfo(camposFallan);
		return false;
	}
	
}

function actividadData(){
	var formData = "idActividad=" + $("#idActividad").val();
	formData += "&idProyecto=" + $("#idProyecto").val();
	formData += "&idUsuario=" + $("#idUsuario").val();

	// index.php/actividad/actividadRead
	$.ajax({				
		type: "POST",
		url:  "/ucasapi/actividad/actividadRead",
		data: formData,
		dataType : "json",
		success: function(retrievedData){        	
			if(retrievedData.status != 0){
				alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
			}
			else{        		
				$("#txtProyectoName").val(retrievedData.data.nombreProyecto);
				$("#txtActividadName").val(retrievedData.data.nombreActividad);
				$("#txtAsignada").val(retrievedData.data.nombreAsigna);
				$("#cbEstado").val(retrievedData.data.idEstado);
				$("#cbProgreso").val(retrievedData.data.progreso);
				$("#txtComentarios").val(retrievedData.data.comentario);
				$("#txtDescripcion").val(retrievedData.data.descripcionActividad);
			}        	
		}	

	});

}

function loadGrid() {

	$("#todosUsuarios").jqGrid(
			{
				url : "/ucasapi/actividad/gridUsuariosRead/" + $("#idActividad").val(),
				datatype : "json",
				mtype : "POST",
				colNames : [ "Id", "Cod.", "Usuario"],
				colModel : [ {
					name : "idUsuario",
					index: "idUsuario",
					width: 0,
					hidden: true

				}, {
					name : "codEmp",
					index : "codEmp",
					width : 90
				}, {
					name : "nombre",
					index : "nombre",
					width : 150
				}],
				pager : "#pager",
				rowNum : 10,
				rowList : [ 10, 20, 30 ],
				sortname : "id",
				sortorder : "desc",
				loadonce : true,
				viewrecords : true,
				gridview : true,
				caption : "Lista de usuarios",
				gridComplete : function(){
					arrayUserUnset = $("#todosUsuarios").getDataIDs();
				}
			});
}

function loadGridTR() {

	$("#list").jqGrid( {
		url : "/ucasapi/actividad/gridUsuarioSet/" + $("#idActividad").val(),
		datatype : "json",
		mtype : "POST",
		colNames : [ "Id", "Cod.", "Usuario"],
		colModel : [ {
			name : "idUsuario",
			index: "idUsuario",
			width: 0,
			hidden: true

		}, {
			name : "codEmp",
			index : "codEmp",
			width : 90
		}, {
			name : "nombre",
			index : "nombre",
			width : 150
		}],
		pager : "#pagerTR",
		rowNum : 10,
		rowList : [ 10, 20, 30 ],
		sortname : "codEmp",
		sortorder : "codEmp",
		loadonce : true,
		viewrecords : true,
		gridview : true,
		caption : "Usuarios asignados a la actividad",
		gridComplete : function(){
			arrayUserSet = $("#list").getDataIDs();
		}
	});
}

function asignar() {
	row_id = $("#todosUsuarios").jqGrid("getGridParam", "selrow");
	row_data = $("#todosUsuarios").jqGrid("getRowData", row_id);

	if (row_id != null) {
		num_rows = $("#list").getGridParam("records"); 
		new_row_data = {
				"idUsuario" : row_data["idUsuario"],
				"codEmp" : row_data["codEmp"],
				"nombre" : row_data["nombre"],
				"nombreRol" : row_data["nombreRol"]
		};
		//Eliminar del array el ID del usuario que ya no se va desasignar...
		var index = idUsuariosQuitar.indexOf(row_data["idUsuario"]);
		if(index != -1) idUsuariosQuitar.splice(index,1);

		idUsuariosAdd.push(row_data["idUsuario"]);

		$("#list").addRowData(num_rows + 1, new_row_data);
		$("#todosUsuarios").delRowData(row_id);
	}

}

function desasignar() {
	row_id = $("#list").jqGrid("getGridParam", "selrow");
	row_data = $("#list").jqGrid("getRowData", row_id);

	if (row_id != null) {
		num_rows = $("#todosUsuarios").getGridParam("records");

		new_row_data = {
				"idUsuario" : row_data["idUsuario"],
				"codEmp" : row_data["codEmp"],
				"nombre" : row_data["nombre"],
				"nombreRol" : row_data["nombreRol"]
		};
		//Insertar en array de IDs el id del usuario que se va a desasignar...
		idUsuariosQuitar.push(row_data["idUsuario"]);

		//Eliminar del array el ID del usuario que ya no se va asignar...
		var index = idUsuariosAdd.indexOf(row_data["idUsuario"]);
		if(index != -1) idUsuariosAdd.splice(index,1);

		$("#todosUsuarios").addRowData(num_rows + 1, new_row_data);

		$("#list").delRowData(row_id);
	}
}


function cancel() {
	// $("#btnCancel").toggleClass('ui-state-active');
	clear();
}

function clear() {
	$(".inputField").val("");
	$(".jqcalendario").val("");
	$(".hiddenId").val("");
}


