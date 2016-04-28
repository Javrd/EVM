<?php
session_start();
if (isset($_SESSION["registroResponsable"]) ){
    $responsable["nombre"] = $_REQUEST["nombre"];
    $responsable["apellidos"] = $_REQUEST["apellidos"];
    $responsable["email"] = $_REQUEST["email"];
    $responsable["telefono"] = $_REQUEST["telefono"];
    
    $errores = validar($responsable);
    
    if ( count ($errores) > 0 ) {
        $_SESSION["registroResponsable"] = $responsable;
        $_SESSION["errores"] = $errores;
        Header("Location: ../registros/registraResponsable.php");
    }
    else {
        unset($_SESSION["registroResponsable"]);
        $_SESSION["responsableExito"] = $responsable;
        Header("Location: ../exito/exitoResponsable.php");
    }
} 
else Header("Location: ../registros/registraResponsable.php");
    
    function validar($responsable) {
    
    $errores = null;
        // Campos vacios
    if (empty($responsable["nombre"])) {
        $errores["nombre"] = "El nombre no se puede dejar vacío.";
    }
    if (empty($responsable["apellidos"])) {
        $errores["apellidos"] = "Los apellidos no se pueden dejar vacíos.";
    }
    if (empty($responsable["email"])) {
        $errores["telefono"] = "El telefono no se puede dejar vacío.";
    }
    
    return $errores;
}
?>