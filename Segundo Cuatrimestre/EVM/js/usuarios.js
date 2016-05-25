
/* TODO 
 * - SI EMAIL O TELEFONO NO VACIOS, ¿SON VALIDOS? TAMBIEN EN SERVIDOR
 * - COMPROBAR FECHA VALIDA EN CLIENTE Y SERVIDOR
 * - REALIZAR FUNCION JS QUE NO TE PERMITA ELEJIR FECHA NO VALIDA (en el punto anterior sobraría en cliente)
 */ 

/************* Funciones de Usuarios ************/
function validaVacio(id){
 	// Devuelve true si el campo esta vacio
   	return document.getElementById("input_"+id).value == "";
}

function inputError(fracaso, msg, idInput, idError){
	// Introduce el texto de error si "error" es true o lo borra del campo en caso contrario.
	if (idError == null) idError = idInput;
	var input = document.getElementById("input_"+idInput);
	var error = document.getElementById("error_"+idError);
	if (fracaso) {
		if (!input.className.includes("error"))
			input.className += " error";
		error.innerHTML = msg;
   	} else {
		input.className = input.className.replace(" error", "");
		error.innerHTML = "";
   	}
}

function validarUsuarios(){
	
	// Campos vacios
   	var errorNombreVacio = validaVacio("nombre");
	var errorApellidosVacios = validaVacio("apellidos");
	var errorDireccionVacia = validaVacio("direccion");
	var checkResponsable = document.getElementById('input_checkResponsable').checked;
    var errorRelacionVacia = validaVacio("tipoRelacion") && checkResponsable;   
	
	// Campos no válidos	
	var errorResponsable = (document.getElementById('input_responsable').value == "--Responsable--" && checkResponsable);
	
	
	// Fecha
	var selectDia = document.getElementById('select_dia');
	var selectMes = document.getElementById('select_mes');
	var selectAnio = document.getElementById('select_anio');
	
	var dia = selectDia.value;
	var mes = selectMes.value;
	var anio = +selectAnio.value+3;
	var anio2 = +anio +15;
	var fecha1 = new Date(anio+"-" + mes + "-" + dia);
	var fecha2 = new Date(anio2+"-" + mes + "-" + dia);
	var hoy = new Date();
		
	var menorTresAnios = fecha1.getTime() > hoy.getTime();
	var menorEdadSinResponsable = (fecha2.getTime() > hoy.getTime()) && !checkResponsable;
	
	var errorFecha = document.getElementById("error_fecha");
	
	//Muestra o quita los errores del formulario
	
	inputError(errorNombreVacio, "El nombre no se puede dejar vacío.", "nombre");
	inputError(errorApellidosVacios, "Los apellidos no se pueden dejar vacíos.", "apellidos");
	inputError(errorDireccionVacia, "La direccion no se puede dejar vacía.", "direccion");
	inputError(errorRelacionVacia, "El tipo de relacion no se puede dejar vacío.", "tipoRelacion");
	inputError(menorEdadSinResponsable || errorResponsable, "Los menores deben tener un responsable.", "responsable");
	if (menorTresAnios) {
		if (!selectDia.className.includes("error")) selectDia.className += " error";
		if (!selectMes.className.includes("error")) selectMes.className += " error";
		if (!selectAnio.className.includes("error")) selectAnio.className += " error";
		errorFecha.innerHTML = "El niño debe tener al menos 3 años para poder registrarse.";
   	} else {
		selectDia.className = selectDia.className.replace(" error", "");
		selectMes.className = selectMes.className.replace(" error", "");
		selectAnio.className = selectAnio.className.replace(" error", "");
		errorFecha.innerHTML = "";
   	}
   	
	return !(errorNombreVacio || errorApellidosVacios || errorDireccionVacia || errorRelacionVacia || menorTresAnios 
		|| menorEdadSinResponsable || errorResponsable);
}

function validarResponsables(){
	
	// Campos vacios
   	var errorNombreVacio = validaVacio("nombre");
	var errorApellidosVacios = validaVacio("apellidos");
	var errorTelefonoVacio = validaVacio("telefono");  
	
	// Campos no válidos	

	//Muestra o quita los errores del formulario
	
	inputError(errorNombreVacio, "El nombre no se puede dejar vacío.", "nombre");
	inputError(errorApellidosVacios, "Los apellidos no se pueden dejar vacíos.", "apellidos");
	inputError(errorTelefonoVacio, "El teléfono no se puede dejar vacío.", "telefono");
   	
	return !(errorNombreVacio || errorApellidosVacios || errorTelefonoVacio );
}

function toggleDetalles(oid_u){
	div_detalles = document.getElementById("id"+oid_u);
	clase = div_detalles.className;
	if(clase.includes("hidden"))
		div_detalles.className = div_detalles.className.replace("hidden", "");
	else
		div_detalles.className += "hidden";
}

function toggleResponsables(){
	var select = $("#input_responsable");
	var text = $("#input_tipoRelacion");
	if(select.attr('disabled')){
		select.removeAttr('disabled');
		text.removeAttr('disabled');
	} else {
		select.attr({
			'disabled': 'disabled'
		});
		text.attr({
			'disabled': 'disabled'
		});
	}
	
}

/************************************************/