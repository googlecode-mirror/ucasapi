$(document).ready(function(){
	js_ini();
	$("#faseButton").addClass("highlight");
	faseAutocomplete();
	llenarFases();
});

function faseAutocomplete(){
		$.ajax({
			type: "POST",
	        url:  "index.php/fase/faseAutocompleteRead",
	        data: "faseAutocomplete",
	        dataType : "json",
	        success: function(retrievedData){        	
	        	if(retrievedData.status != 0){
	        		alert("Mensaje de error: " + retrievedData.msg);
	        	}
	        	else{        		
	        		$("#txtSearch").autocomplete({
	            		minChars: 0,  
	    		        source: retrievedData.data,
	    		        minLength: 1,
	    		        select: function(event, ui) {
	    			        $("#idFase").val(ui.item.id);					
	    				}
	    			});
	        		
	        	}        	
	      }
			
		});
}

function llenarFases() {
	$.ajax({
		type : "POST",
		url : "index.php/fase/faseAutocompleteRead",
		dataType : "json",
		success : function(retrievedData) {
			if (retrievedData.status != 0) {
				 msgBoxInfo(retrievedData.msg);
//				alert("Mensaje de error: " + retrievedData.msg);
			} else {
				var i = 0;
				var options = '<option value="0">Seleccione fase</option>';
				
				for(; i< retrievedData.data.length ; i++) {
					options += '<option value="' + retrievedData.data[i].id + '">' + retrievedData.data[i].value + '</option>';
				}
				
				$("#cbxFasePrev").html(options);
				$("#cbxFaseSig").html(options);
			}
		}

	});
}

function save(){
		var formData = "";
		formData += "idFase=" + $("#idFase").val();
		formData += "&nombreFase=" + $("#txtFaseName").val();
		formData += "&descripcion=" + $("#txtFaseDesc").val();
		formData += "&idFasePrevia=" + $("#cbxFasePrev").val();
		formData += "&idFaseSiguiente=" + $("#cbxFaseSig").val();

		if(validar_campos()){
			$.ajax({
				type: "POST",
				url: "index.php/fase/faseValidateAndSave",
				data: formData,
				dataType: "json",
				success: function(retrievedData){
					if(retrievedData.status != 0){
						alert("Mensaje de error: " + retrievedData.msg);
					}
					else{
						if($("#idFase").val() == ""){
							alert("Fase agregada con exito");
						}
						else{
							alert("Fase actualizada con exito");
						}
						faseAutocomplete();
						llenarFases();
						clear();
							
					}
				}
			
			});	
		}
}

function deleteData(){
	var formData = "idFase=" + $("#idFase").val();
	
	$.ajax({
		type: "POST",
		url: "index.php/fase/faseDelete",
		data: formData,
		dataType: "json",
		success: function(retrievedData){
			if(retrievedData.status != 0){
				alert("Mensaje de error: " + retrievedData.msg);
			}
			else{
				alert("Fase eliminada con exito");
				faseAutocomplete();
				llenarFases();
				clear();
			}
		}
	});
	
}

function edit(){
	var formData = "idFase=" + $("#idFase").val();
	
	if ($("#txtSearch").val() != "") {
		$.ajax({
			type: "POST",
			url: "index.php/fase/faseRead",
			data: formData,
			dataType: "json",
			success: function(retrievedData){
				if(retrievedData.status != 0){
					alert("Mensaje de error: " + retrievedData.msg);
				}
				else{
					$("#txtFaseName").val(retrievedData.data.nombreFase);
					$("#txtFaseDesc").val(retrievedData.data.descripcion);
					$("#cbxFasePrev").val(retrievedData.data.anterior);
					$("#cbxFaseSig").val(retrievedData.data.siguiente);
					
					$("select").attr("disabled", "disabled");					
					
				}
			}
		});
	} else {
		msgBoxInfo("Debe seleccionar un FASE a editar");
	}
	
}

function validar_campos(){
	var camposFallan = "";
	
	if($("#txtFaseName").val()!=""){
		if(!validarAlfaEsp($("#txtFaseName").val())){
			camposFallan += "El campos NOMBRE FASE contiene caracteres no validos <br />";
		}
	}else{
		camposFallan += "El campo NOMBRE FASE es requerido <br />";
	}
	
	if($("#txtFaseDesc").val()!=""){
		if(!validarAlfaEspNum($("#txtFaseDesc").val())){
			camposFallan += "El campos DESCRIPCION FASE contiene caracteres no validos <br />";
		}
	}else{
		camposFallan += "El campo DESCRIPCION FASE es requerido <br />";
	}
	
	if ( $("#cbxFasePrev").val() == "0" && $("#cbxFaseSig").val() == "0" ) {
		camposFallan += "Debe seleccionar al menos una FASE PREVIA o una FASE SIGUIENTE <br />";
	} else if ( $("#cbxFasePrev").val() == $("#cbxFaseSig").val() ) {
		camposFallan += "Los campos FASE PREVIA y FASE SIGUIENTE no deben ser iguales";
	}
	
	if(camposFallan == ""){
		return true;
	}else{
		msgBoxInfo(camposFallan);
		return false;
	}
	return true;
}

function clear(){
	$(".inputField").val("");
	$(".hiddenId").val("");
	$("#txtSearch").val("");
	$("#txtFaseDesc").val("");
	
	$("select").attr("disabled", "");
}

