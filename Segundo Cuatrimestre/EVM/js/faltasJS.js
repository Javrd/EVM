
function validarFaltas(){
	var res = true;
	var oid_m = document.getElementById("select_usuario").value;
	var dia = document.getElementById("select_dia").value;
	var mes = document.getElementById("select_mes").value;
	var anio = document.getElementById("select_anio").value;
	var fecha = new Date(anio+"-" + mes + "-" + dia);
	var actual = new Date();
	if (oid_m=="-1") {
		res= false;
        document.getElementById("errorFaltasUsuario").innerHTML = "Seleccione un usuario.";
        document.getElementById("select_usuario").className = "error";
       }else{
       	document.getElementById("errorFaltasUsuario").innerHTML = "";
        document.getElementById("select_usuario").className = "";
       }
    if (fecha.getTime()>actual.getTime()){
    	res = false;
    	document.getElementById("errorFaltasFecha").innerHTML = "La fecha no puede ser posterior a hoy.";
    	document.getElementById("select_dia").className = "error";
    	document.getElementById("select_mes").className = "error";
    	document.getElementById("select_anio").className = "error";
    }else{
    	document.getElementById("errorFaltasFecha").innerHTML = "";
    	document.getElementById("select_dia").className = "";
    	document.getElementById("select_mes").className = "";
    	document.getElementById("select_anio").className = "";
    }
	return res;
}
