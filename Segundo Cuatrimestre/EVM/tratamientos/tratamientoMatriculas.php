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
	$date = new DateTime();
	$date->setDate($matricula["anio"], $matricula["mes"], $matricula["dia"]);
	$matricula['fecha_matricula'] = $date;
    $matricula["codigo"] = $_REQUEST["codigo"];
    $matricula["usuario"] = $_REQUEST["usuario"];
    $matricula["asignaturas"] = $_POST['check_list'];
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
    if ($matricula["codigo"]== 'Codigo') {
        $errores["codigo"] = "Seleccione un Codigo.";
    }
    if ($matricula["usuario"] == -1){
        $errores["usuario"] = "Seleccione un Usuario.";
    }

    $usuario = edadDeUsuario($conexion,$matricula['usuario']);
    $hoy =  new DateTime();
    $nacimiento = DateTime::createFromFormat("d/m/Y",$usuario['FECHA_NACIMIENTO']);
    $edad = $nacimiento->diff($hoy);
    echo $edad->format('%y');

    if ((intval($edad->format('%y')) <+ 6) and (!in_array(13, $matricula['asignaturas']))){
    	$errores['asignaturas'] = "el alumno tiene que elegir Expresion Corporal y Danza";
    }


	if ($matricula['curso'] >= 3 and (!in_array(11, $matricula['asignaturas']))){
		$errores['asignaturas'] = "tienes que elegir una asignatura de tercero";
	}
	if ((!in_array(12, $matricula['asignaturas']))){
		$errores['asignaturas'] = "tienes que tener la asignatura Lenguaje musical";
	}
	if (empty($_POST['check_list'])){
		$errores['asignaturas'] = "Seleccione las asignaturas de la matricula que desea crear.";

	}
	return $errores;
}
    

cerrarConexionBD($conexion);  
?>