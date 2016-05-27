<?php
session_start();
require_once("../gestion/gestionBD.php");
require_once("../gestion/gestionarMatricula.php");
$conexion = crearConexionBD();

if (isset($_SESSION["registroMatricula"]) ){
    
    $matricula["curso"] = $_REQUEST["curso"];
    $matricula["dia"] = $_REQUEST["dia"];
	$matricula["mes"] = $_REQUEST["mes"];
	$matricula["anio"] = $_REQUEST["anio"];
    $matricula["codigo"] = $_REQUEST["codigo"];
    $string = $_REQUEST["usuario"];
    $matricula["usuario"] = explode(" ", $string)[0];
    $checked = $_POST['check_list'];
    $matricula["asignaturas"] = array();
    foreach ($checked as $asignatura) {
    	array_push($matricula["asignaturas"],explode("/", $asignatura)[0]);	
    }
	}
else {Header("Location: ../registros/registraMatricula.php");}

$errores = validar($matricula);

if ( count ($errores) > 0 ) {
    $_SESSION["registroMatricula"] = $matricula;
    $_SESSION["errores"] = $errores;
    Header("Location: ../registros/registraMatricula.php");
}
else {
    unset($_SESSION["registroMatricula"]);
    $_SESSION["matriculaExito"] = $matricula;
    Header("Location: ../exito/exitoMatricula.php");
}

function validar($matricula) {
    global $conexion;
    $errores = null;

	if ($matricula["curso"]==-1) {
        $errores["curso"] = "Seleccione un Curso.";
    }
    if ($matricula["codigo"]== '') {
        $errores["codigo"] = "El código no se puede dejar vacío.";
    }
    if ($matricula["usuario"] == -1){
        $errores["usuario"] = "Seleccione un Usuario.";
    }else{
	    $usuario = edadDeUsuario($conexion,$matricula['usuario']);
	    $hoy =  new DateTime();
	    $nacimiento = DateTime::createFromFormat("d/m/Y",$usuario['FECHA_NACIMIENTO']);
	    $edad = $nacimiento->diff($hoy);
	    if ((intval($edad->format('%y')) <+ 6) and (!in_array("Expresion Corporal y Danza", $matricula['asignaturas']))){
    		$errores['asignaturas'] = "Debe estar matriculado en Expresion Corporal y Danza, si es menor de 6 años";
	    }else if (!(intval($edad->format('%y')) <+ 6) and (!in_array("Lenguaje Musical", $matricula['asignaturas']))){
			$errores['asignaturas'] = "Debe estar matriculado en la asignatura Lenguaje musical si es mayor de 6 años";
		}
	    	
	}
	if(!checkdate($matricula["mes"], $matricula["dia"], $matricula["anio"])){
		$errores["fecha_matricula"]="Seleccione una fecha válida";
	}
    

	if ($matricula['curso'] >= 3 and (!in_array("Piano y guitarra", $matricula['asignaturas']))){
		$errores['asignaturas'] = "Debe estar matriculado en una asignatura de tercero";
	}
	if (empty($_POST['check_list'])){
		$errores['asignaturas'] = "Seleccione las asignaturas de la matricula que desea crear.";

	}
	return $errores;
}
    

cerrarConexionBD($conexion);  
?>