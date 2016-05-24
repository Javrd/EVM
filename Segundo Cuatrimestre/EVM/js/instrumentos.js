
function validarInstrumentos(){
	var res = true;
	var nombre = document.getElementById("input_nombre").value;
	var tipo = document.getElementById("select_tipo").value;
    var estado = document.getElementById("select_estado").value;
	if (nombre=="") {
		res= false;
        document.getElementById("errorNombre").innerHTML = "Escribe un nombre del instrumento.";
        nombre.className = "error";
       }else{
       	document.getElementById("errorNombre").innerHTML = "";
        nombre.className = "";
       }
    if (tipo == ""){
    	res = false;
    	document.getElementById("errorTipo").innerHTML = "El tipo no se puede dejar vacio.";
    	tipo.className = "error";
    }else{
    	document.getElementById("errorTipo").innerHTML = "";
    	tipo.className = "";
    }
    if (estado == -1){
        res = false;
        document.getElementById("errorEstado").innerHTML = "Debe selecionnar un estado del instrumento.";
        estado.className = "error";
    }else{
        document.getElementById("errorEstado").innerHTML = "";
        estado.className = "";
    }
	return res;
}
