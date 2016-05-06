
/************* Funciones de Usuarios ************/

function validarUsuarios(){
	
	var res = true;
	/* Campos vacios */
	
	// if ($("#input_nombre").val() == "") {
		// $("#input_nombre").className += " error"; // Mirar como poner el class
		// $("#error_nombre").html("El nombre no se puede dejar vacío.");
        // res = false;
   	// } 
   	var inputNombre = document.getElementById("input_nombre");
   	var errorNombre = document.getElementById("error_nombre");
	if (inputNombre.value == "") {
		inputNombre.className += " error";
		errorNombre.innerHTML = "El nombre no se puede dejar vacío.";
        res = false;
   	} else {
		inputNombre.className = inputNombre.className.replace(" error", "");
		errorNombre.innerHTML = "";
   	}
   	
    if (document.getElementById("input_apellidos").value == "") {
		document.getElementById("input_apellidos").className += " error";
		document.getElementById("error_apellidos").innerHTML = "Los apellidos no se pueden dejar vacíos.";
        res = false;
    }
    // if (empty($usuario["direccion"])) {
        // $errores["direccion"] = "La direccion no se puede dejar vacía.";
    // }
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

function buscadorUsuarios(){
	var buscador = document.getElementById("buscador");
	var input = buscador.value;
	var xhttp; 
	if (window.XMLHttpRequest) {
    	xhttp = new XMLHttpRequest();
    } else {
    	// code for IE6, IE5
    	xhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
    if (input.length == 0) { 
        document.getElementById("txtHint").autocomplete = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "gethint.php?q=" + str, true);
        xmlhttp.send();
    }
	
}

/************************************************/