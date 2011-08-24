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
	var RegExPattern = /^\d{1,4}.\d{2}$/
		if ((campo.match(RegExPattern)) && (campo.value != '')) {
			return true;
		} else {
			return false;
		}  
}

/* El rollercoaster de la vida, abroche sus cinturones y disfrute del viaje */