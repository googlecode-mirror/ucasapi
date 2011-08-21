$(document).ready(function(){
	js_ini();
	$("#faseButton").addClass("highlight");
	faseAutocomplete();		
});

function faseAutocomplete(){
		$.ajax({
			type: "POST",
	        url:  "index.php/fase/faseAutocompleteRead",
	        data: "faseAutocomplete",
	        dataType : "json",
	        success: function(retrievedData){        	
	        	if(retrievedData.status != 0){
	        		alert("Mensaje de error: " + retrievedData.msg); // Por
																		// el
																		// momento,
																		// el
																		// mensaje
																		// que
																		// se
																		// est�
																		// mostrando
																		// es
																		// t�cnico,
																		// para
																		// cuestiones
																		// de
																		// depuraci�n
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

function save(){
		var formData = "";
		formData += "idFase=" + $("#idFase").val();
		formData += "&nombreFase=" + $("#txtFaseName").val();
		formData += "&descripcion=" + $("#txtFaseDesc").val();

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
				clear();
			}
		}
	});
	
}

function edit(){
	var formData = "idFase=" + $("#idFase").val();
	
	if ($("txtRecords").val() == "") {
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
		if(!validarAlfa($("#txtFaseName").val())){
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
}

