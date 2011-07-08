
$(document).ready(function(){
	departmentAutocomplete();		
});	




function departmentAutocomplete(){
	$.ajax({				
        type: "POST",
        url:  "index.php/departamento/departmentAutocompleteRead",
        data: "",
        dataType : "json",
        success: function(dat){
        	$( "#txtRecords" ).autocomplete({
        		minChars: 0,  
		        source: dat,
		        minLength: 1,
		        select: function( event, ui) {
			        $("#idDepto").val(ui.item.id);					
				}
			});
      }
      
	});			
}


function save(){			
	var formData= "";
	formData += "idDepto=" + $("#idDepto").val();
	formData += "&nombreDepto=" + $("#txtDepartmentName").val();
	formData += "&descripcion=" + $("#txtDepartmentDesc").val();		
	
	$.ajax({				
        type: "POST",
        url:  "index.php/departamento/departmentValidateAndSave",
        data: formData,
        dataType : "json",
        success: function(retrievedData){
			        switch(retrievedData.status){
			        	case 0 : alert("Mensaje de error: "+ retrievedData.msg);
			        			 break;
			        	case 1 : alert("Mensaje de éxito: "+ retrievedData.msg);
	        			 		 break;
	        			case 2 : alert("Mensaje de información: "+ retrievedData.msg);
   			 		 			 break;			        
			        }
      	}
      
	});
	
}

function edit(){			
	var formData = "idDepto=" + $("#idDepto").val();	
	
	$.ajax({				
        type: "POST",
        url:  "index.php/departamento/departmentRead",
        data: formData,
        dataType : "json",
        success: function(retrievedData){
			       $("#txtDepartmentName").val(retrievedData.nombreDepto);
			       $("#txtDepartmentDesc").val(retrievedData.descripcion);
      	}
      
	});
	
}

function deleteData(){		
	alert("Pendiente....");	
	/*var formData = "idDepto=" + $("#idDepto").val();	
	
	$.ajax({				
        type: "POST",
        url:  "index.php/departamento/departmentDelete",
        data: formData,
        dataType : "json",
        success: function(retrievedData){
			       $("#txtDepartmentName").val(retrievedData.nombreDepto);
			       $("#txtDepartmentDesc").val(retrievedData.descripcion);
      	}
      
	});*/
	
}

function cancel(){
	clear();
}

function clear(){
	$(".inputField").val("");
	$(".hiddenId").val("");
	$("#txtRecords").val("");
}
