$(document).ready(function(){
	$('.divActions').addClass("ui-corner-all");
	$('.divDataForm').addClass("ui-corner-all");
	$('.container').addClass("ui-corner-bottom");
	$("button").button({icons: {primary: "ui-icon-locked"}});
	estadoAutocomplete();
	loadGrid();
	loadGridTR();
});

var idUsuariosQuitar = new Array();

function estadoAutocomplete(){
	$.ajax({				
		type: "POST",
		url:  "index.php/actividad/actividadEstados",
		data: "statusAutocomplete",
		dataType : "json",
		success: function(retrievedData){        	 
			options = '<option value="">--Estado--</option>';
			$.each(retrievedData.data, function(i,obj) {
				options += '<option value="' + obj.idEstado + '">' + obj.estado + '</option>';
			});			
			$("#cbEstado").html(options);
			actividadData();

		}

	});
}

function save(){
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
	
	formData += "&user_data=" + gridData;
	if(idUsuariosQuitar.length != 0){
		formData += "&remove_data=" + idUsuariosQuitar;
	}
	else{
		formData += "&remove_data=0"; 
	}

	$.ajax({
		type: "POST",
		url: "index.php/actividad/actividadValidateAndSave",
		data: formData,
		dataType: "json",
		success: function(retrievedData){
			if(retrievedData.status != 0){
				alert("Mensaje de error: " + retrievedData.msg);
			}
			else{
				alert("Actividad actualizada con exito");
			}
		}

	});
}

function actividadData(){
	var formData = "idActividad=" + $("#idActividad").val();
	formData += "&idProyecto=" + $("#idProyecto").val();
	formData += "&idUsuario=" + $("#idUsuario").val();

	$.ajax({				
		type: "POST",
		url:  "index.php/actividad/actividadRead",
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
				url : "index.php/actividad/gridUsuariosRead/" + $("#idActividad").val(),
				datatype : "json",
				mtype : "POST",
				colNames : [ "Id", "Cod.", "Usuario", "Rol" ],
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
					width : 160
				}, {
					name : "nombreRol",
					index : "nombreRol",
					width : 200
				} ],
				pager : "#pager",
				rowNum : 10,
				rowList : [ 10, 20, 30 ],
				sortname : "id",
				sortorder : "desc",
				loadonce : true,
				viewrecords : true,
				gridview : true,
				caption : "Lista de usuarios"
			});
}

function loadGridTR() {

	$("#list").jqGrid( {
		url : "index.php/actividad/gridUsuarioSet/" + $("#idUsuario").val(),
		datatype : "json",
		mtype : "POST",
		colNames : [ "Id", "Cod.", "Usuario", "Rol" ],
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
			width : 160
		}, {
			name : "nombreRol",
			index : "nombreRol",
			width : 200
		} ],
		pager : "#pagerTR",
		rowNum : 10,
		rowList : [ 10, 20, 30 ],
		sortname : "codEmp",
		sortorder : "codEmp",
		loadonce : true,
		viewrecords : true,
		gridview : true,
		caption : "Usuarios asignados a la actividad"
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
