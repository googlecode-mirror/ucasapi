$(document).ready(function(){
	 js_ini();	
	 $('.divActions').addClass("ui-corner-all");
	 $('.divLogin').addClass("ui-corner-all");
	 $('.divDataForm').addClass("ui-corner-all");
	 $('.container').addClass("ui-corner-bottom");
	 $("#txtRol").focus(function(){$("#txtRol").autocomplete('search', '');});
	//$(".button").button();
	$("input[type=button]").button();
	roleSelectionIni();
	
	$("#browsers").bt(
			  {
			    fill: '#FFF',
			    cornerRadius: 10,
			    strokeWidth: 0,
			    shadow: true,
			    shadowOffsetX: 3,
			    shadowOffsetY: 3,
			    shadowBlur: 8,
			    width : 256,
			    shadowColor: 'rgba(0,0,0,.9)',
			    shadowOverlap: false,
			    noShadowOpts: {strokeStyle: '#999', strokeWidth: 2},
			    positions: ['top', 'top']
	  });
	
	$("#txtPassword").bind("keypress", function(e){
	    if(e.keyCode==13){
	        userLogin();
	    }
	});

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
        		if(retrievedData.data.length ==0){//Si los datos del usuario son inv�lidos
        			$("#sessionMsg").html("Usuario o contrase�a incorrectos");
        		}
        		else{//Si los datos del usuario son correctos
        			
        			if(retrievedData.roleData.length ==1){//Si el usuario solo posee un rol        				
        				start(retrievedData.roleData[0].id,retrievedData.roleData[0].value);
        			}
        			else{
        				$("#txtRol").autocomplete({
                    		minChars: 0,
                    		matchContains: true,
            		        source: retrievedData.roleData,
            		        minLength: 0,
            		        select: function(event, ui) {
            			        $("#idRol").val(ui.item.id);					
            				}
            			});
            			
            			$("#roleSelection").dialog("open");    				
        				
        			}        			
        		}
        	}
      	}
      
	});
	
}


function roleSelectionIni(){
	$("#roleSelection").dialog({
		autoOpen: false,
		modal: true,
		title: "Selecci�n de rol",
		resizable: false,
		height:240,
		width: 420,
		buttons: {
			"Aceptar": function(event) {
				start($("#idRol").val(),$("#txtRol").val());
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

function start(idRol, nombreRol){
	if(idRol!=""){
		$("#roleSelection").dialog("close");
		window.location = "login/home/"+idRol+"/"+nombreRol;
	}
	
}
