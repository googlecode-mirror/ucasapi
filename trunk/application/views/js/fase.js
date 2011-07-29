/**
 * 
 */

$(document).ready(function(){
	$('.divActions').addClass("ui-corner-all");
	$('.divDataForm').addClass("ui-corner-all");
	$('.container').addClass("ui-corner-bottom");
	$("button").button({icons: {primary: "ui-icon-locked"}});
	verifica();
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
	        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se est� mostrando es t�cnico, para cuestiones de depuraci�n
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
	if(validate()==true){
		var formData = "";
		formData += "idFase=" + $("#idFase").val();
		formData += "&nombreFase=" + $("#txtFaseName").val();
		formData += "&descripcion=" + $("#txtFaseDesc").val();

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
	
}

function verifica(){
	$("input").focus(function ()
			{
				$(this).next("span").attr("class", "span");
				$(this).next("span").html($(this).attr("title"));
			});
	
	$("input").blur(function ()
			{
				if($(this).val().length > 0){
					var msg = "";
					//Nombre Accion
					if($(this).attr("id") == "txtFaseName"){
						if($(this).val().length > 4 && $(this).val().length < 40) msg = "correcto";
						else msg = "incorrecto";
					}
					switch (msg){
					case "correcto":
						$(this).next("span").attr("class", "correct");
						$(this).next("span").html("OK");
						break;
					case "incorrecto":
						$(this).next("span").attr("class", "incorrect");
						$(this).next("span").html("incorrecto");
						break;
					case "largo":
						$(this).next("span").attr("class", "incorrect");
						$(this).next("span").html("Descripcion demasiada larga!");
						break;
					default:
						break;
				}
				}else
					$(this).next("span").html("");
			});
	$("textArea").focus(function ()
			{
				$(this).next("span").attr("class", "span");
				$(this).next("span").html($(this).attr("title"));
			});
	$("textArea").blur(function ()
			{
				if($(this).val().length > 0){
					var msg = "";
					//Nombre Accion
					if($(this).attr("id") == "txtFaseDesc"){
						if($(this).val().length > 4 && $(this).val().length < 256) msg = "correcto";
						else if($(this).val().length > 256) msg = "largo";
						else msg="incorrecto";
					}
					switch (msg){
					case "correcto":
						$(this).next("span").attr("class", "correct");
						$(this).next("span").html("OK");
						break;
					case "incorrecto":
						$(this).next("span").attr("class", "incorrect");
						$(this).next("span").html("incorrecto");
						break;
					case "largo":
						$(this).next("span").attr("class", "incorrect");
						$(this).next("span").html("Descripcion demasiada larga!");
						break;
					default:
						break;
				}
				}else
					$(this).next("span").html("");
			});
}


function validate(){
	var valida1 = true;
	var valida2 = true;
	$("input").each(function(index){
		if($(this).attr("id") == "txtFaseName"){
			if($(this).next("span").text() != "OK"){
						$(this).next("span").attr("class", "incorrect");
						$(this).next("span").html("Compruebe este campo!");
						valida1 = false;
			}
				
		}
	});
	$("textArea").each(function(index){
		if($(this).attr("id") == "txtFaseDesc"){
			if($(this).next("span").text() != "OK"){
						$(this).next("span").attr("class", "incorrect");
						$(this).next("span").html("Compruebe este campo!");
						valida2 = false;
			}
				
		}
	});
	
	if(valida1 == true && valida2 == true) return true
	else return false;
}

function clear(){
	$(".inputField").val("");
	$(".hiddenId").val("");
	$("#txtSearch").val("");
	$("#spanfase1").text("");
	$("#spanfase2").text("");
}

