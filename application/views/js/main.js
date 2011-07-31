
function js_ini(){
	$("#msgBox" ).addClass("ui-corner-all");
	$('.divActions').addClass("ui-corner-all");
	$('.divDataForm').addClass("ui-corner-all");
	$('.container').addClass("ui-corner-bottom");
	$(".jqcalendario").datepicker();
	$( "#tabs" ).tabs();
	//$("#logoutButton").tooltip();
	$("#btnSave").button({icons: {primary: "ui-icon-disk"}});
	$("#btnEdit").button({icons: {primary: "ui-icon-pencil"}});
	$("#btnDelete").button({icons: {primary: "ui-icon-trash"}});
	$("#btnCancel").button({icons: {primary: "ui-icon-cancel"}});
	$("#btnUpload").button({icons: {primary: "ui-icon-arrowthick-1-n"}});
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
	$("#msgBox").fadeIn(800);
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