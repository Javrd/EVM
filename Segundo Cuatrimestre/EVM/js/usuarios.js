
/************* Funciones de Usuarios ************/
function validaVacio(id, errorMsg){
	
	var input = document.getElementById("input_"+id);
	var error = document.getElementById("error_"+id);
	var res = true;
	if (input.value == "") {
		input.className += " error";
		error.innerHTML = errorMsg;
        res = false;
   	} else {
		input.className = input.className.replace(" error", "");
		error.innerHTML = "";
   	}
   	return res;
}

function validarUsuarios(){
	
	var res = true;

   	res = validaVacio("nombre", "El nombre no se puede dejar vacío.");;
    res = validaVacio("apellidos", "Los apellidos no se pueden dejar vacíos.");;
    res = validaVacio("direccion", "La direccion no se puede dejar vacía.");
    
    // if(isset($_REQUEST['checkResponsable']) && empty($usuario['tipoRelacion'])){
        // $errores["tipoRelacion"] = "El tipo de relacion no se puede dejar vacío.";
    // }
    
//     
//     
    // $edad = $usuario["fechaNacimiento"]->diff( new DateTime());
//     
        // // Menor de 3 años
//           
    // if  ( $edad->format("%y") < 3){
//           
        // $errores["fechaNacimiento"] = "El niño debe tener al menor 3 años para poder registrarse.";
//         
        // // Menor de 18 años
    // } elseif (!isset($_REQUEST["checkResponsable"]) && $edad->format("%y") < 18){
//               
        // $errores["responsable"] = "Los menores deben tener un responsable.";
//         
    // } 
    // return $errores;
	return res;
}

function toggleResponsables(){
	var select = $("#select_responsable");
	var text = $("#input_tipoRelación");
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