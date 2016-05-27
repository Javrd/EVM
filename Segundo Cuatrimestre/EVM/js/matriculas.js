
function validarMatriculas(){
	var res = true;
	var curso = document.getElementById("select_curso").value;
    var dia = document.getElementById("select_dia").value;
    var mes = document.getElementById("select_mes").value;
    var anio = document.getElementById("select_anio").value;
    var fecha = new Date(anio+"-" + mes + "-" + dia);
    var actual = new Date();
	var codigo = document.getElementById("input_codigo").value;
    var concate = document.getElementById("select_usuario").value;
    usuario = concate.split(" ")[0];
    var checkItems = document.getElementsByClassName("checkItems");
    var asignaturas = new Array;
    for (var i = 0; i < checkItems.length; i++) {
    	if (checkItems[i].checked){
    		asignaturas.push(checkItems[i].value.split("/")[0]);
    	}
    }
	if (curso=="-1") {
		res= false;
        document.getElementById("errorCurso").innerHTML = "Seleccione un curso.";
        document.getElementById("select_curso").className = "error";
       }else{
       	document.getElementById("errorCurso").innerHTML = "";
        document.getElementById("select_curso").className = "";
       }
	if (fecha.getTime()>actual.getTime()){
    	res = false;
    	document.getElementById("errorMatriculasFecha").innerHTML = "La fecha no puede ser posterior a hoy.";
    	document.getElementById("select_dia").className = "error";
    	document.getElementById("select_mes").className = "error";
    	document.getElementById("select_anio").className = "error";
    }else{
    	document.getElementById("errorMatriculasFecha").innerHTML = "";
    	document.getElementById("select_dia").className = "";
    	document.getElementById("select_mes").className = "";
    	document.getElementById("select_anio").className = "";
    }
    if (codigo == ""){
		res= false;
        document.getElementById("errorCodigo").innerHTML = "Inscribe un codigo";
        document.getElementById("input_codigo").className = "error";
       }else{
       	document.getElementById("errorCodigo").innerHTML = "";
        document.getElementById("input_codigo").className = "";
       }
    if (usuario == "-1"){
		res= false;
        document.getElementById("errorMatriculaUsuario").innerHTML = "Elige un Usuario";
        document.getElementById("select_usuario").className = "error";
       }else{
	       	document.getElementById("errorMatriculaUsuario").innerHTML = "";
	        document.getElementById("select_usuario").className = "";

	        var edadUsuario = concate.split(" ")[1];
	        console.log(asignaturas);
	        console.log(asignaturas.indexOf("Expresion Corporal y Danza") > -1);
	        if ((parseInt(edadUsuario) <= 6) &&  (!(asignaturas.indexOf("Expresion Corporal y Danza") > -1))){
	        	res= false;
	        	document.getElementById("errorMatriculaAsignaturas").innerHTML = "El alumno es menor de 6 anos y tiene que elegir ECD";
	        }
	        else if ((parseInt(curso) >= 3) &&  (!(asignaturas.indexOf("Piano y guitarra") > -1))){
	        	res= false;
	        	document.getElementById("errorMatriculaAsignaturas").innerHTML = "El alumno tiene que elegir una asignatura de tercero";
	        }
	        else if ((parseInt(edadUsuario) >= 6) &&  (!(asignaturas.indexOf("Lenguaje Musical") > -1))){
	        	res= false;
	        	document.getElementById("errorMatriculaAsignaturas").innerHTML = "Debe estar matriculado en la asignatura Lenguaje musical si es mayor de 6 años";
	        }

       }
    if (asignaturas.length == 0){
    	res = false;
    	document.getElementById("errorMatriculaAsignaturas").innerHTML = "Tiene que elegir asignaturas";
    }
    console.log(res);
    return res;
}

