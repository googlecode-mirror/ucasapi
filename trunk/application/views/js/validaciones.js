function validateEmail(campo) {  
    var RegExPattern = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;  
    var errorMessage = 'Password Incorrecta.';  
    if ((campo.value.match(RegExPattern)) && (campo.value!='')) {  
        return true;   
    } else {  
        //alert(errorMessage);
    	campo.focus();
    	return false;
    }   
}

/* El rollercoaster de la vida, abroche sus cinturones y disfrute del viaje */