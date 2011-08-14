
function js_ini(){
	
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
	$(".jqcalendario").datepicker({ dateFormat: 'yy-mm-dd' });

	//Botones
	$("#btnSave").button({icons: {primary: "ui-icon-disk"}});
	$("#btnEdit").button({icons: {primary: "ui-icon-pencil"}});
	$("#btnDelete").button({icons: {primary: "ui-icon-trash"}});
	$("#btnCancel").button({icons: {primary: "ui-icon-cancel"}});
	$("#btnUpload").button({icons: {primary: "ui-icon-arrowthick-1-n"}});
	$("#btnAddFile").button({icons: {primary: "ui-icon-disk"}});
	$("#btnUpdateFile").button({icons: {primary: "ui-icon-disk"}});
	$("#btnClearFileForm").button({icons: {primary: "ui-icon-cancel"}});
	
	//Tooltips
	setTooltips();
	
	//Cierre de sessión
	$('#logoutButton').click(function() {
	    window.location = "login/close"
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

function setTooltips(){	
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
