<?php
session_start();

include("../gestion/gestionBD.php");
include("../gestion/gestionarLogin.php");
$conexion = crearConexionBD();

if (isset($_POST["login"]) ){
    
    $login["usuario"] = $_REQUEST["usuario"];
    $login["contrasenia"] = $_REQUEST["contrasenia"];
 
    
    $errores = validar($login);
    
    cerrarConexionBD($conexion);
    
    if ( count ($errores) > 0 ) {
        $_SESSION["errores"] = $errores;
        Header("Location: ../index.php");
    }
    else {
        $_SESSION["login"] = "";
        Header("Location: ../inicio.php");
    }
} 
else Header("Location: ../index.php");
    
function validar($login) {
    
    global $conexion;
    $errores = null;
        // Campos vacios
    if (empty($login["usuario"])) {
        $errores["usuario"] = "El usuario no se puede dejar vacío.";
    }
    if (empty($login["contrasenia"])) {
        $errores["contrasenia"] = "La contraseña no se puede dejar vacía.";
    }
    
    if (!isset($errores)){
        if(!compruebaUsuario($conexion,$login["usuario"],$login["contrasenia"])){
            $errores["login"] = "El usuario o la contraseña no son correctos";
        }
    }
    return $errores;
}
?>