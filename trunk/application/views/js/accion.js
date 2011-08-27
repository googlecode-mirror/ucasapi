
$(document).ready(function(){
	js_ini();
	$("#accionButton").addClass("highlight");
	$('.divActions').addClass("ui-corner-all");
	$('.divDataForm').addClass("ui-corner-all");
	$('.container').addClass("ui-corner-bottom");
	$("button").button({icons: {primary: "ui-icon-locked"}});
	accionAutocomplete();
	
	$("#txtRecords").focus(function(){$("#txtRecords").autocomplete('search', '');});
	
});	

function accionAutocomplete(){
	$.ajax({				
        type: "POST",
        url:  "index.php/accion/accionAutocompleteRead",
        data: "accionAutocomplete",
        dataType : "json",
        success: function(retrievedData){        	
        	if(retrievedData.status != 0){
        		alert("Mensaje de error: " + retrievedData.msg); 
        	}
        	else{        		
        		$("#txtRecords").autocomplete({
            		minChars: 0,  
    		        source: retrievedData.data,
    		        minLength: 0,
    		        select: function(event, ui) {
    			        $("#idAccion").val(ui.item.id);					
    				},
					//Esto es para el esperado mustMatch o algo parecido
					change :function(){
						if(!autocompleteMatch(retrievedData.data, $("#txtRecords").val())){
							$("#txtRecords").val("");
							$("#idAccion").val("");
						}
					}
    			});        		
        	}        	
      }      
	});		
}

function save(){
	if(validar_campos()){
		var formData= "";
		formData += "idAccion=" + $("#idAccion").val();
		formData += "&nombreAccion=" + $("#txtAccionName").val();
		formData += "&accionActual=" + $("#accionActual").val();
		
			$.ajax({				
		        type: "POST",
		        url:  "index.php/accion/accionValidateAndSave",
		        data: formData,
		        dataType : "json",
		        success: function(retrievedData){
		        	if(retrievedData.status != 0){
		        		alert("Mensaje de error: " + retrievedData.msg); 
		        	}
		        	else{
		        		if($("#accionActual").val()==""){
		        			msgBoxSucces("Registro agregado con &eacute;xito");
		        		}
		        		else{
		        			msgBoxSucces("Registro actualizado con &eacute;xito");
		        		}
		        		accionAutocomplete();
		        		clear();
		        	}
		      	}
		      
			});
	}
}

function edit(){
	if($("#txtRecords").val() != "" && $("#idAccion").val() != ""){
		$("#accionActual").val("editando");
		lockAutocomplete();
		var formData = "idAccion=" + $("#idAccion").val();
		
		$.ajax({				
	        type: "POST",
	        url:  "index.php/accion/accionRead",
	        data: formData,
	        dataType : "json",
	        success: function(retrievedData){
	        	if(retrievedData.status != 0){
	        		alert("Mensaje de error: " + retrievedData.msg); 
	        	}else{
	        		$("#txtAccionName").val(retrievedData.data.nombreAccion);
	        	}			       
	      	}      
		});
	}else{
		msgBoxInfo("Debe seleccionar una acci&oacute;n a editar");
	}
	
}

function deleteData(){
	if($("#txtRecords").val() != "" && $("#idAccion").val() != ""){
		var formData = "idAccion=" + $("#idAccion").val();	
		var answer = confirm("Est&aacute; seguro que quiere eliminar el registro: "+ $("#txtRecords").val()+ " ?");	
		if (answer){		
			$.ajax({				
		        type: "POST",
		        url:  "index.php/accion/accionDelete",
		        data: formData,
		        dataType : "json",
		        success: function(retrievedData){
		        	if(retrievedData.status != 0){
		        		alert("Mensaje de error: " + retrievedData.msg);
		        	}
		        	else{
		        		msgBoxSucces("Registro eliminado con &eacute;xito");
		        		accionAutocomplete();
		        		clear();
		        	}
		      	}
		      
			});		
		}	
	}else{
		msgBoxInfo("Debe seleccionar una acci&oacute;n a eliminar");
	}
}

function validar_campos(){
	var camposFallan = "";
	
	if($("#txtAccionName").val()!=""){
		if(!validarAlfaEsp($("#txtAccionName").val())){
			camposFallan += "<p><dd>El campo NOMBRE ACCION contiene caracteres no validos</dd><br /></p>";
		}
	}else{
		camposFallan += "<p><dd>El campo NOMBRE ACCION es requerido</dd> <br /> </p>";
	}
	
	if(camposFallan == ""){
		return true;
	}else{
		camposFallan = "Se han encontrado los siguientes problemas: <br/>" + camposFallan;
		msgBoxInfo(camposFallan);
		return false;
	}
	return true;
}
function cancel(){
	clear();
}

function clear(){
	$(".inputField").val("");
	$(".hiddenId").val("");
	$("#txtRecords").val("");
	unlockAutocomplete();
}

/* OTRAS FUNCIONES DE VALIDACION Y LOCKING */
function lockAutocomplete() {	
	$("#txtRecords").attr("disabled", true);	
	$("#txtRecords").css({"background-color": "DBEBFF"});		
}

function unlockAutocomplete() {
	$("#txtRecords").attr("disabled", false);
	$("#txtRecords").css({"background-color": "FFFFFF"});	
}
