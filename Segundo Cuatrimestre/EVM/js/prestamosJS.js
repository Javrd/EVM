
function validarPrestamos(){
	var res = true;
	var oid_m = document.getElementById("select_usuario").value;
	var oid_i = document.getElementById("select_instrumento").value;	
	if (oid_m=="-1") {
		res= false;
        document.getElementById("errorPrestamosUsuario").innerHTML = "Seleccione un usuario.";
        document.getElementById("select_usuario").className = "error";
       }else{
       	document.getElementById("errorPrestamosUsuario").innerHTML = "";
        document.getElementById("select_usuario").className = "";
     }
     if (oid_i=="-1") {
		res= false;
        document.getElementById("errorPrestamosInstrumento").innerHTML = "Seleccione un instrumento.";
        document.getElementById("select_instrumento").className = "error";
       }else{
       	document.getElementById("errorPrestamosInstrumento").innerHTML = "";
        document.getElementById("select_instrumento").className = "";
     }
    
	return res;
}
