<?php
session_start();
require_once("../gestion/gestionBD.php");
require_once("../gestion/gestionarFalta.php");
$conexion = crearConexionBD();
if(isset($_REQUEST['borrar'])){
	$falta["oid_f"] = $_REQUEST["oid_f"];
	$falta["borrar"]="";
    $_SESSION["faltaExito"] = $falta;
    Header("Location: ../exito/exitoFalta.php");
}
if (isset($_REQUEST["actu"])){
 		$falta["oid_f"] = $_REQUEST["oid_f"];
	  	$falta["actu"]="";
        $_SESSION["faltaExito"] = $falta;
        Header("Location: ../exito/exitoFalta.php");
    }
if (isset($_SESSION["registroFalta"]) ){    
  
	    $falta["tipo_falta"] = $_REQUEST["tipo_falta"];
	    $falta["fecha_falta"] = DateTime::createFromFormat("d/m/Y", ($_REQUEST["dia"]."/".$_REQUEST["mes"]."/".$_REQUEST["anio"]));
		$falta["usuario"] = $_REQUEST["usuario"];
	
    
    $errores = validar($falta);
    
    if ( count ($errores) > 0 ) {
        $_SESSION["registroFalta"] = $falta;
        $_SESSION["errores"] = $errores;
        Header("Location: ../registros/registraFalta.php");
    }
    else {
        unset($_SESSION["registroFalta"]);
        $_SESSION["faltaExito"] = $falta;
        Header("Location: ../exito/exitoFalta.php");
    }
}
else Header("Location: ../registros/registraFalta.php");

function validar($falta) {
    global $conexion;
    $errores = null;
        // Campos vacios
	if ($falta["usuario"]=="-1") {
        $errores["usuario"] = "Seleccione un usuario.";
    }else {
		 $fecha = DateTime::createFromFormat("d/m/Y",getFechaMatriculacion($conexion, $falta['usuario']));
		if($fecha->diff($falta['fecha_falta'])<0){
			$errores['fecha_falta'] = "La fecha no puede ser anterior a la fecha de Matriculación.";
		}
	}
	if ($falta['fecha_falta']->diff(new DateTime())->format('%a')>0){
		$errores['fecha_falta'] = "La fecha no puede ser posterior a hoy.";
	}
    return $errores;
}

     cerrarConexionBD($conexion);  
?>