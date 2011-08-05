$(document).ready(function(){
	 $('.divActions').addClass("ui-corner-all");
	 $('.divDataForm').addClass("ui-corner-all");
	 $('.container').addClass("ui-corner-bottom");
	
	//$(".button").button();
	$("input[type=button]").button();
	roleSelectionIni();

});	

function userLogin(){			
	var formData= "";
	formData += "username=" + $("#txtUsername").val();
	formData += "&password=" + $("#txtPassword").val();
	
	$.ajax({				
        type: "POST",
        url:  "index.php/login/validateUser",
        data: formData,
        dataType : "json",
        success: function(retrievedData){
        	if(retrievedData.status != 0){
        		alert("Mensaje de error: " + retrievedData.msg);
        	}
        	else{
        		if(retrievedData.data.length ==0){//Si los datos del usuario son inválidos
        			$("#sessionMsg").html("Usuario o contraseña incorrectos");
        		}
        		else{//Si los datos del usuario son correctos se redirrecciona a la url proveída en la variable msg
        			$("#txtRol").autocomplete({
                		minChars: 0,
                		matchContains: true,
        		        source: retrievedData.roleData,
        		        minLength: 1,
        		        select: function(event, ui) {
        			        $("#idRol").val(ui.item.id);					
        				}
        			});
        			
        			$("#roleSelection").dialog("open");
        			
        		}
        	}
      	}
      
	});
	
}


function roleSelectionIni(){
	$("#roleSelection").dialog({
		autoOpen: false,
		modal: true,
		title: "Selección de rol",
		resizable: false,
		height:240,
		width: 420,
		buttons: {
			"Aceptar": function(event) {
				start();
			},
			"Cancelar": function() {
				$("#roleSelection").dialog("close");
			}
		}

	});
	
}



function cancel(){
	clear();
}

function clear(){
	$(".inputFieldL").val("");
	$(".inputFieldLPSW").val("");
	$(".hiddenId").val("");
	$("#sessionMsg").html("");
}

function start(){
	if($("#idRol").val()!=""){
		$("#roleSelection").dialog("close");
		window.location = "login/home/"+$("#idRol").val()+"/"+$("#txtRol").val();
	}
	
}
