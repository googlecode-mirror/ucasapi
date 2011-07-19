

$(document).ready(function(){
	 $('.divActions').addClass("ui-corner-all");
	 $('.divDataForm').addClass("ui-corner-all");
	 $('.container').addClass("ui-corner-bottom");
	
	//$(".button").button();
	$("input[type=button]").button();

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
        		if(retrievedData.data.length ==0){
        			$("#invalidUser").css("display", "inline");
        		}
        		else{
        			window.location = retrievedData.msg;
        		}
        	}
      	}
      
	});
	
}


function cancel(){
	clear();
}

function clear(){
	$(".inputField").val("");
	$(".hiddenId").val("");
	$("#txtRecords").val("");
	$("#invalidUser").css("display", "none");
}

