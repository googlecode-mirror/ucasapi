

function validarEmail(campo) {
	var RegExPattern = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
	if ((campo.match(RegExPattern)) && (campo.value != '')) {
		return true;
	} else {
		return false;
	}
}

function validarTelefono(campo) {
	var RegExPattern = /^[0-9]{8}$/;
	if ((campo.match(RegExPattern)) && (campo.value != '')) {
		return true;
	} else {
		return false;
	}
}


function validarDUI(campo) {
	var RegExPattern = /^[0-9]{8}-[0-9]{1,2}$/;
	if ((campo.match(RegExPattern)) && (campo.value != '')) {
		return true;
	} else {
		return false;
	}
}

function validarNIT(campo) {
	var RegExPattern = /^[0-9]{4}-[0-9]{6}-[0-9]{3}-[0-9]{1}$/;
	if ((campo.match(RegExPattern)) && (campo.value != '')) {
		return true;
	} else {
		return false;
	}
}

function validarISSS(campo) {
	var RegExPattern = /^[0-9]{9}$/;
	if ((campo.match(RegExPattern)) && (campo.value != '')) {
		return true;
	} else {
		return false;
	}
}

function validarCarnet(campo) {
	var RegExPattern = /^[0-9]{8}$/;
	if ((campo.match(RegExPattern)) && (campo.value != '')) {
		return true;
	} else {
		return false;
	}
}

function validarCodEmpleado(campo) {
	var RegExPattern = /^\w{2}\d{5}$/;
	if ((campo.match(RegExPattern)) && (campo.value != '')) {
		return true;
	} else {
		return false;
	}
}

function validarNUP(campo) {
	var RegExPattern = /^[0-9]{12}$/;
	if ((campo.match(RegExPattern)) && (campo.value != '')) {
		return true;
	} else {
		return false;
	}
}

function validarExtension(campo) {
	var RegExPattern = /^[0-9]{3,4}$/;
	var errorMessage = 'Password Incorrecta.';
	if ((campo.match(RegExPattern)) && (campo.value != '')) {
		return true;
	} else {
		return false;
	}
}


function validarAlfa(campo){
	var RegExPattern = /^[A-Za-z]{2,256}$/
		if ((campo.match(RegExPattern)) && (campo.value != '')) {
			return true;
		} else {
			return false;
		}
}

function validarAlfaEsp(campo){
	var RegExPattern = /^[a-zA-Z\ \'\u00e1\u00e9\u00ed\u00f3\u00fa\u00c1\u00c9\u00cd\u00d3\u00da\u00f1\u00d1\u00FC\u00DC]{1,256}$/
		if ((campo.match(RegExPattern)) && (campo.value != '')) {
			return true;
		} else {
			return false;
		} 		
}

function validarAlfaEspNum(campo){
	var RegExPattern = /^\w{1}[A-Za-z0-9\s]{1,256}$/
		if ((campo.match(RegExPattern)) && (campo.value != '')) {
			return true;
		} else {
			return false;
		}
}

function validarSalario(campo) {
	var RegExPattern = /^\d|\.$/
		if ((campo.match(RegExPattern)) && (campo.value != '')) {
			return true;
		} else {
			return false;
		}  
}

function validarNUM(campo) {
	var RegExPattern = /^\d{1,15}$/
		if ((campo.match(RegExPattern)) && (campo.value != '')) {
			return true;
		} else {
			return false;
		}  
}


function validateOverlapFechas(fecha1, fecha2){
	var format = "yyyy-MM-dd";	
	var result = compareDates(fecha1,format,fecha2,format);
	if(result == -1){		
		return false;		
	}
	return true;	
}


function validarTrasTodos(d1,d2,data){
	//alert(getDateFromFormat(d1,"yyyy-MM-dd"));
	//alert(getDateFromFormat(d2,"yyyy-MM-dd"));
	//alert("cadenota : " + data);
	var datos = data.split("|");
	//alert(datos);
	var f1;
	var f2;
	var cont = 1;
	for (var Elemento in datos) {
		//alert(Elemento);
		if(cont == 1){
			f1 = datos[Elemento];
			cont++;
			continue;
		}
		if(cont == 2){
			f2 = datos[Elemento];			
			cont = 1;
			//alert("NEW: " + d1);
			//alert("NEW: " + d2);
			//alert("OLD: " + f1);
			//alert("OLD: " + f2);
			if(!validarFechasContratos(d1,d2,f1,f2))
				return false;
		}	
	}
	return true;
}


function validarFechasContratos(f1,f2,cf1,cf2){
	//alert(f1);
	//alert(f2);
	//alert(cf1);
	//alert(cf2);
	var format = "yyyy-MM-dd";
	var d1=getDateFromFormat(f1,format);// nueva
	var d2=getDateFromFormat(f2,format);
	var cd1=getDateFromFormat(cf1,format);// bases
	var cd2=getDateFromFormat(cf2,format);
	//alert(d1,d2,cd1,cd2);
	//alert("d1 " + d1);
	//alert("d2 " + d2);
	//alert("cd1 " + cd1);
	//alert("cd2 " + cd2);
	
	if(cd1 < d1 && d2 < cd2){
		//alert(0);
		return false;		
	}
	if(cd1 <= d1 && cd2 <= d2 && d1 <= cd2){
		//alert(1);
		return false;		
	}
	
	if(d1 <= cd1 && d2 <= cd2 && cd1 <= d2){
		//alert(2);
		return false;		
	}
	
	if(cd1 == d1 && d2 == cd2){
		//alert(3);
		return false
	}
	
	return true;	
}

