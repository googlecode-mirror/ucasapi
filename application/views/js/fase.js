$(document).ready(function(){
	js_ini();
	$("#faseButton").addClass("highlight");
	faseAutocomplete();
	llenarFases();
	
	$("#txtSearch").focus(function(){$("#txtSearch").autocomplete('search', '');});
	
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
	    		        minLength: 0,
	    		        select: function(event, ui) {
	    			        $("#idFase").val(ui.item.id);					
	    				},
						//Esto es para el esperado mustMatch o algo parecido
						change :function(){
							if(!autocompleteMatch(retrievedData.data, $("#txtSearch").val())){
								$("#txtSearch").val("");
								$("#idFase").val("");
							}
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
	if ($("#txtSearch").val() != "" && $("#idFase").val() != "") {
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
	} else {
		msgBoxInfo("Debe seleccionar un FASE a eliminar");
	}
}

function edit(){
	if ($("#txtSearch").val() != "" && $("#idFase").val() != "") {		
		var formData = "idFase=" + $("#idFase").val();
		lockAutocomplete();
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
			camposFallan += "<p><dd>El campos NOMBRE FASE contiene caracteres no validos </dd><br/></p>";
		}
	}else{
		camposFallan += "<p><dd>El campo NOMBRE FASE es requerido </dd><br/></p>";
	}
	
	if($("#txtFaseDesc").val()!=""){
		if(!validarAlfaEspNum($("#txtFaseDesc").val())){
			camposFallan += "<p><dd>El campos DESCRIPCION FASE contiene caracteres no validos </dd><br/></p>";
		}
	}else{
		camposFallan += "<p><dd>El campo DESCRIPCION FASE es requerido </dd><br/></p>";
	}
	
	if ( $("#cbxFasePrev").val() == "0" && $("#cbxFaseSig").val() == "0" ) {
		camposFallan += "<p><dd>Debe seleccionar al menos una FASE PREVIA o una FASE SIGUIENTE </dd><br/></p>";
	} else if ( $("#cbxFasePrev").val() == $("#cbxFaseSig").val() ) {
		camposFallan += "<p><dd>Los campos FASE PREVIA y FASE SIGUIENTE no deben ser iguales </dd><br/></p>";
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

function cancel() {
	clear();
}

function clear(){
	$(".inputField").val("");
	$(".hiddenId").val("");
	$("#txtSearch").val("");
	$("#txtFaseDesc").val("");	
	$("select").attr("disabled", "");
	unlockAutocomplete();
}

/* OTRAS FUNCIONES DE VALIDACION Y LOCKING*/
function lockAutocomplete() {	
	$("#txtSearch").attr("disabled", true);	
	$("#txtSearch").css({"background-color": "DBEBFF"});		
}

function unlockAutocomplete() {
	$("#txtSearch").attr("disabled", false);
	$("#txtSearch").css({"background-color": "FFFFFF"});	
}

