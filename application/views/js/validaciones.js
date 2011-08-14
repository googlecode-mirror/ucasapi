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
	var RegExPattern = /^[0-9]{3}$/;
	var errorMessage = 'Password Incorrecta.';
	if ((campo.match(RegExPattern)) && (campo.value != '')) {
		return true;
	} else {
		return false;
	}
}


function validarAlfa(campo){
	var RegExPattern = /^[A-Za-z]{2,80}$/
		if ((campo.match(RegExPattern)) && (campo.value != '')) {
			return true;
		} else {
			return false;
		}   
		
}

function validarAlfaEsp(campo){
	var RegExPattern = /^\w{1}[A-Za-z\s]{2,80}$/
		if ((campo.match(RegExPattern)) && (campo.value != '')) {
			return true;
		} else {
			return false;
		}   
		
}
/* El rollercoaster de la vida, abroche sus cinturones y disfrute del viaje */