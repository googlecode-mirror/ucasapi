function js_ini(){
	
	//Validación para IE
	browserValidation();
	//Autocompletes muestran todos los elementos en el focus
	//autocompletesShowsAll();
	
	ajaxLoading();
	
	//Seteo de estilos
	$("#msgBox").addClass("ui-corner-all");
	$("#msgBox01").addClass("ui-corner-all");
	$('.divActions').addClass("ui-corner-all");
	$('.divDataForm').addClass("ui-corner-all");
	$('.container').addClass("ui-corner-bottom");
	
	//Tabs
	$("#tabs").tabs();
	$("#tabs-1").css("padding", "0px");
	$("#tabs-2").css("padding", "0px");
	$("#tabs-3").css("padding", "0px");
	$("#tabs-4").css("padding", "0px");
	
	//Datepickers
	$(".jqcalendario").datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true , changeYear: true, yearRange: '1920:c+5'});

	//Botones
	$("#btnSave").button({icons: {primary: "ui-icon-disk"}});
	$("#btnEdit").button({icons: {primary: "ui-icon-pencil"}});
	$("#btnSaveContrato").button({icons: {primary: "ui-icon-disk"}});
	$("#btnEditContrato").button({icons: {primary: "ui-icon-pencil"}});
	$("#btnDeleteContrato").button({icons: {primary: "ui-icon-trash"}});
	$("#btnEditarContrato").button({icons: {primary: "ui-icon-pencil"}});
	$("#btnCancelContrato").button({icons: {primary: "ui-icon-cancel"}});
	$("#btnSaveRol").button({icons: {primary: "ui-icon-disk"}});
	$("#btnEditRol").button({icons: {primary: "ui-icon-pencil"}});
	$("#btnDeleteRol").button({icons: {primary: "ui-icon-trash"}});
	$("#btnCancelRol").button({icons: {primary: "ui-icon-cancel"}});
	$("#btnDelete").button({icons: {primary: "ui-icon-trash"}});
	$("#btnCancel").button({icons: {primary: "ui-icon-cancel"}});
	$("#btnUpload").button({icons: {primary: "ui-icon-arrowthick-1-n"}});
	$("#btnAddFile").button({icons: {primary: "ui-icon-disk"}});
	$("#btnUpdateFile").button({icons: {primary: "ui-icon-disk"}});
	$("#btnClearFileForm").button({icons: {primary: "ui-icon-cancel"}});
	$("#btnMoreThan").button({icons: {primary: "ui-icon-carat-1-e"}});
	$("#btnLessThan").button({icons: {primary: "ui-icon-carat-1-w"}});
	
	//Tooltips
	setTooltips();
	
	//Cierre de sessiï¿½n
	$('#logoutButton').click(function() {
		window.location = "/ucasapi/login/close";
	});

}


function msgBoxSucces(message){
	$("#msgBox").hide();
	$("#msgBox").html(message);
	$("#msgBox").removeClass( "msgBoxInfo");
	$("#msgBox").removeClass( "msgBoxError");
	$("#msgBox").addClass( "msgBoxSucces");
	$("#msgBox").fadeIn(800);
	$("#msgBox").delay(5000).fadeOut();
}

function msgBoxInfo(message){
	$("#msgBox").hide();
	$("#msgBox").html(message);
	$("#msgBox").removeClass( "msgBoxSucces");
	$("#msgBox").removeClass( "msgBoxError");
	$("#msgBox" ).addClass( "msgBoxInfo");
	$("#msgBox").fadeIn(2000);
	$("#msgBox").delay(5000).fadeOut();
}

function msgBoxError(message){
	$("#msgBox").hide();
	$("#msgBox").html(message);
	$("#msgBox").removeClass( "msgBoxInfo");
	$("#msgBox").removeClass( "msgBoxSucces");
	$("#msgBox" ).addClass( "msgBoxError");
	$("#msgBox").fadeIn(800);
	$("#msgBox").delay(5000).fadeOut();
}


function msgBoxSucces01(message){
	$("#msgBox01").hide();
	$("#msgBox01").html(message);
	$("#msgBox01").removeClass( "msgBoxInfo");
	$("#msgBox01").removeClass( "msgBoxError");
	$("#msgBox01").addClass( "msgBoxSucces");
	$("#msgBox01").fadeIn(800);
	$("#msgBox01").delay(5000).fadeOut();
}

function msgBoxInfo01(message){
	$("#msgBox01").hide();
	$("#msgBox01").html(message);
	$("#msgBox01").removeClass( "msgBoxSucces");
	$("#msgBox01").removeClass( "msgBoxError");
	$("#msgBox01" ).addClass( "msgBoxInfo");
	$("#msgBox01").fadeIn(800);
	$("#msgBox01").delay(5000).fadeOut();
}

function msgBoxError01(message){
	$("#msgBox01").hide();
	$("#msgBox01").html(message);
	$("#msgBox01").removeClass( "msgBoxInfo");
	$("#msgBox01").removeClass( "msgBoxSucces");
	$("#msgBox01" ).addClass( "msgBoxError");
	$("#msgBox01").fadeIn(800);
	$("#msgBox01").delay(5000).fadeOut();
}

function setTooltips(){	
	browserName = navigator.appName;
	
	if(browserName != "Microsoft Internet Explorer"){		
		$(".inputField, .inputFieldAC, .inputFieldPSW, .inputFieldTA, .inputCHK, .jqcalendario, #logoutButton").bt(
				  {
				    fill: '#FFF',
				    cornerRadius: 10,
				    strokeWidth: 0,
				    shadow: true,
				    shadowOffsetX: 3,
				    shadowOffsetY: 3,
				    shadowBlur: 8,
				    shadowColor: 'rgba(0,0,0,.9)',
				    shadowOverlap: false,
				    noShadowOpts: {strokeStyle: '#999', strokeWidth: 2},
				    positions: ['right', 'top']
		  });		
	}
	
	
	
}

function browserValidation(){
	//Pendientes validaciones para los navegadores no soportados
	
	browserName = navigator.appName;
	
	if(browserName == "Microsoft Internet Explorer"){
		//Repara algunos problemas visuales en nuestro querido IE...
		 //Para la clase hasDatepicker falla, por el momento habría que colocarlo por id en el ready de cada pantalla, como está en actividada.js
		$(".inputField,.inputFieldAC,.hasDatepicker").css("height", "16px");  
		$(".requiredFieldLabel,.inputFieldLabel").css("height", "22px");
	}
	
}

function txtDisable(txtId){
    $("#"+txtId).attr("readonly", "true")
    $("#"+txtId).css("background", "#F0F0F0");
    $("#"+txtId).css("color", "#8A8A8A");
}

function txtEnable(txtId){
    $("#"+txtId).attr("readonly", "")
    $("#"+txtId).css("background", "#FFF");
    $("#"+txtId).css("color", "#000");
}

//Retorna true si el elemento text se encuentra en el arrayData
function autocompleteMatch(arrayData, text){
	var exists = false;
	
	for(var i in arrayData){
		if(arrayData[i].value == text){
			exists = true;
			break;
		}
	}
	return exists;	
}

function ajaxLoading(){
	 $("<div></div>").ajaxStart(function(){
		 $("#loading").modal();
	 });
		$("<div></div>").ajaxStop(function(){
			$.modal.close();
	 }); 
}

//Permite que todos los autocompletes muestren todos sus elementos en el evento focus, todos deben tener en sus parámetros minLength: 0.
/*function autocompletesShowsAll(){
	element = document.getElementsByClassName("inputFieldAC");
	
	for(var i = 0; i<element.length;i++){
		$("#"+element[i].id).focus(function(){
			$("#"+this.id).autocomplete('search', '');
		});		
	}
	
}*/
