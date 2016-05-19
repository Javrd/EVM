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
    $matricula["usuario"] = $_REQUEST["usuario"];
    if(!empty($_POST['check_list'])) {
    	$matricula["asignaturas"] = $_POST['check_list'];
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
    $_SESSION["registroMatricula"] = $matricula;
    Header("Location: ../exito/exitoMatricula.php");
}

function validar($falta) {
    global $conexion;
    $errores = null;

	if ($matricula["curso"]=="Curso") {
        $errores["curso"] = "Seleccione un Curso.";
    }
    if(!checkdate($matricula["mes"], $matricula["dia"], $matricula["anio"])){
			$errores['fecha_matricula'] = "Introduzca una fecha válida.";
	}
	else{
	 $fecha_falta= DateTime::createFromFormat("d/m/Y", ($falta["dia"]."/".$falta["mes"]."/".$falta["anio"]));		
	 if($fecha_falta>new DateTime()){
		$errores['fecha_matricula'] = "La fecha no puede ser posterior a hoy.";
		}
	}
    return $errores;
}
cerrarConexionBD($conexion);  
?>