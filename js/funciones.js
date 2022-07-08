function justNumbers(e, cad){//Permitir solo numeros y puntos
	var keynum = window.event ? window.event.keyCode : e.which;
	if(keynum>=1&&keynum<=31){
		return true;		
	}
	if(keynum==46){
		if(ExisteCaracter(cad,".")){
			return false;
		}else{
			return true;
		}
	}
	return /\d/.test(String.fromCharCode(keynum));
}

function justNumbersOnly(e){//Permitir solo numeros
	var keynum = window.event ? window.event.keyCode : e.which;
	if(keynum>=1&&keynum<=31){
		return true;
	}
	return /\d/.test(String.fromCharCode(keynum));
}

function ExisteCaracter(Cadena, Caracter){
	if(Cadena.indexOf(Caracter)==-1){
		return false;
	}else{
		return true;
	}
}

function SoloNumeros(evt){//Otro metodo para no permitir el ingreso de letras, solo numeros.
	if(window.event){//asignamos el valor de la tecla a keynum
		keynum = evt.keyCode; //IE
	}else{
		keynum = evt.which; //FF
	}
	//comprobamos si se encuentra en el rango numérico y que teclas no recibirá.
	if((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 9 || keynum == 13 || keynum == 6 ){
		return true;
	}else{
		return false;
	}
}

function number_format(amount, decimals) {

	amount += ''; // por si pasan un numero en vez de un string
	amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

	decimals = decimals || 0; // por si la variable no fue fue pasada

	// si no es un numero o es igual a cero retorno el mismo cero
	if (isNaN(amount) || amount === 0) 
		return parseFloat(0).toFixed(decimals);

	// si es mayor o menor que cero retorno el valor formateado como numero
	amount = '' + amount.toFixed(decimals);

	var amount_parts = amount.split('.'),
		regexp = /(\d+)(\d{3})/;

	while (regexp.test(amount_parts[0]))
		amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

	return amount_parts.join('.');
}