<?php
session_start();
require_once("../gestion/gestionBD.php");
require_once("../gestion/gestionarPrestamo.php");
$conexion = crearConexionBD();

if (isset($_SESSION["registroPrestamo"]) ){    
  		
	    $prestamo["instrumento"] = $_REQUEST["instrumento"];
		$prestamo["usuario"] = $_REQUEST["usuario"];
	
    
    $errores = validar($prestamo);
    
    if ( count ($errores) > 0 ) {
        $_SESSION["registroPrestamo"] = $prestamo;
        $_SESSION["errores"] = $errores;
        Header("Location: ../registros/registraPrestamo.php");
    }
    else {
        unset($_SESSION["registroPrestamo"]);
        $_SESSION["prestamoExito"] = $prestamo;
        Header("Location: ../exito/exitoPrestamo.php");
    }
    
}
else Header("Location: ../registros/registraPrestamo.php");
		

function validar($prestamo) {
    global $conexion;
    $errores = null;

	if ($prestamo["usuario"]=="-1") {
        $errores["usuario"] = "Seleccione un usuario.";
    }if ($prestamo["instrumento"]=="-1") {
        $errores["instrumento"] = "Seleccione un instrumento.";
    }
    return $errores;
}

     cerrarConexionBD($conexion);  
?>