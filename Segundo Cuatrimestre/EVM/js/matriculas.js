
function validarMatriculas(){
	var res = true;
	var curso = document.getElementById("select_curso").value;
    var dia = document.getElementById("select_dia").value;
    var mes = document.getElementById("select_mes").value;
    var anio = document.getElementById("select_anio").value;
    var fecha = new Date(anio+"-" + mes + "-" + dia);
    var actual = new Date();
	var codigo = document.getElementById("input_codigo").value;
    var usuario = document.getElementById("select_usuario").value;
    var asignaturas = 
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
