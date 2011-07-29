
$(document).ready(function(){
	$('.divActions').addClass("ui-corner-all");
	$('.divDataForm').addClass("ui-corner-all");
	$('.container').addClass("ui-corner-bottom");
	$("button").button({icons: {primary: "ui-icon-locked"}});
	verifica();
	accionAutocomplete();			
});	

function accionAutocomplete(){
	$.ajax({				
        type: "POST",
        url:  "index.php/accion/accionAutocompleteRead",
        data: "accionAutocomplete",
        dataType : "json",
        success: function(retrievedData){        	
        	if(retrievedData.status != 0){
        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se est� mostrando es t�cnico, para cuestiones de depuraci�n
        	}
        	else{        		
        		$("#txtRecords").autocomplete({
            		minChars: 0,  
    		        source: retrievedData.data,
    		        minLength: 1,
    		        select: function(event, ui) {
    			        $("#idAccion").val(ui.item.id);					
    				}
    			});        		
        	}        	
      }      
	});		
}

function save(){
	if(validate()==true){
		var formData= "";
		formData += "idAccion=" + $("#idAccion").val();
		formData += "&nombreAccion=" + $("#txtAccionName").val();	
		
		$.ajax({				
	        type: "POST",
	        url:  "index.php/accion/accionValidateAndSave",
	        data: formData,
	        dataType : "json",
	        success: function(retrievedData){
	        	if(retrievedData.status != 0){
	        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se est� mostrando es t�cnico, para cuestiones de depuraci�n
	        	}
	        	else{
	        		if($("idAccion").val()==""){
	        			alert("Registro agregado con �xito");
	        		}
	        		else{
	        			alert("Registro actualizado con �xito");
	        		}
	        		accionAutocomplete();
	        		clear();
	        	}
	      	}
	      
		});
	}
}

function edit(){
	var formData = "idAccion=" + $("#idAccion").val();	
	
	$.ajax({				
        type: "POST",
        url:  "index.php/accion/accionRead",
        data: formData,
        dataType : "json",
        success: function(retrievedData){
        	if(retrievedData.status != 0){
        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se est� mostrando es t�cnico, para cuestiones de depuraci�n
        	}else{
        		$("#txtAccionName").val(retrievedData.data.nombreAccion);
        	}			       
      	}      
	});
	
}

function deleteData(){
	var formData = "idAccion=" + $("#idAccion").val();
	
	var answer = confirm("Est� seguro que quiere eliminar el registro: "+ $("#txtRecords").val()+ " ?");
	
	if (answer){		
		$.ajax({				
	        type: "POST",
	        url:  "index.php/accion/accionDelete",
	        data: formData,
	        dataType : "json",
	        success: function(retrievedData){
	        	if(retrievedData.status != 0){
	        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se est� mostrando es t�cnico, para cuestiones de depuraci�n
	        	}
	        	else{
	        		alert("Registro eliminado con �xito");
	        		accionAutocomplete();
	        		clear();
	        	}
	      	}
	      
		});		
	}	
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
					if($(this).attr("id") == "txtAccionName"){
						if($(this).val().length > 4 && $(this).val().length < 256 && !($(this).val().split(" ").length== $(this).val().length+1)) msg = "correcto";
						else msg = "incorrecto";
						switch (msg){
							case "correcto":
								$(this).next("span").attr("class", "correct");
								$(this).next("span").html("OK");
								break;
							case "incorrecto":
								$(this).next("span").attr("class", "incorrect");
								$(this).next("span").html("incorrecto");
								break;
							default:
								break;
						}
					}
				}else
					$(this).next("span").html("");
			});
}


function validate(){
	var valida = true;
	$("input").each(function(index){
		if($(this).attr("id") == "txtAccionName"){
			if($(this).next("span").text() != "OK"){
						$(this).next("span").attr("class", "incorrect");
						$(this).next("span").html("Compruebe este campo!");
						valida = false;
			}
				
		}
	});
	
	if(valida == true) return true
	else return false;
}

function cancel(){
	clear();
}

function clear(){
	$(".inputField").val("");
	$(".hiddenId").val("");
	$("#txtRecords").val("");
	$("#spanaccion").text("");
}
