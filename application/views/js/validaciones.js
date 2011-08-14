function validarEmail(campo) {
	var RegExPattern = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
	var errorMessage = 'Password Incorrecta.';
	if ((campo.match(RegExPattern)) && (campo.value != '')) {
		return true;
	} else {
		return false;
	}
}

function validarTelefono(campo) {
	var RegExPattern = /^[0-9]{8}$/;
	var errorMessage = 'Password Incorrecta.';
	if ((campo.match(RegExPattern)) && (campo.value != '')) {
		return true;
	} else {
		return false;
	}
}



/* El rollercoaster de la vida, abroche sus cinturones y disfrute del viaje */