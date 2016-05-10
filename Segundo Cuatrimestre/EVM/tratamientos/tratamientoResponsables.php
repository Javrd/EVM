<?php
session_start();

include("../gestion/gestionBD.php");
include("../gestion/gestionarResponsable.php");
$conexion = crearConexionBD();

if (isset($_SESSION["registroResponsable"]) ){
    
    if (isset($_REQUEST["oid_r"])){
        $responsable["oid_r"] = $_REQUEST["oid_r"];
    }
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
        
    global $conexion;
    $errores = null;
        // Campos vacios
    if (empty($responsable["nombre"])) {
        $errores["nombre"] = "El nombre no se puede dejar vacío.";
    }
    if (empty($responsable["apellidos"])) {
        $errores["apellidos"] = "Los apellidos no se pueden dejar vacíos.";
    }
    if (empty($responsable["telefono"])) {
        $errores["telefono"] = "El teléfono no se puede dejar vacío.";
    }
        // Email
     if ($responsable["email"] != "" && !isset($responsable["oid_r"]) && existeEmailResponsable($conexion, $responsable["email"])){
        $errores["email"] = "Este email ya esta registrado";
     }
    return $errores;
}
?>