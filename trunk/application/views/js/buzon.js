$(document).ready(function(){
	 $('.divActions').addClass("ui-corner-all");
	 $('.divDataForm').addClass("ui-corner-all");
	 $('.container').addClass("ui-corner-bottom");
	 $("button").button({icons: {primary: "ui-icon-locked"}});		
});	

function load(){
	var selr = $('#grid').jqGrid('getGridParam','selrow');
	var formData = "idNotificacion=" + selr;
	if(selr){
		$.ajax({				
	        type: "POST",
	        url:  "index.php/buzon/buzonLeerMensaje",
	        data: formData,
	        dataType : "json",
	        success: function(retrievedData){        	
	        	if(retrievedData.status != 0){
	        		alert("Mensaje de error: " + retrievedData.msg); //Por el momento, el mensaje que se está mostrando es técnico, para cuestiones de depuración
	        	}
	        	else{
	        		$('label#subject').val(retrievedData.data.subject);
	        		$('#message').val(retrievedData.data.notificacion);
	        		$('#msg').show("slow");
	        	}        	
	      }      
		});	
	}	
	else alert("No ha seleccionado un mensaje");
	
}

function cancel(){
	$('#msg').hide("slow");
	
}
