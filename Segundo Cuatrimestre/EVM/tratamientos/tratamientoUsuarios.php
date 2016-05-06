<?php
session_start();

include("../gestion/gestionBD.php");
include("../gestion/gestionarUsuario.php");
$conexion = crearConexionBD();

if (isset($_SESSION["registroUsuario"]) ){
    
    if (isset($_REQUEST["oid_u"])){
        $usuario["oid_u"] = $_REQUEST["oid_u"];
    }
    $usuario["nombre"] = $_REQUEST["nombre"];
    $usuario["apellidos"] = $_REQUEST["apellidos"];
    $usuario["fechaNacimiento"] = DateTime::createFromFormat("d/m/Y", ($_REQUEST["dia"]."/".$_REQUEST["mes"]."/".$_REQUEST["anio"]));
    $usuario["direccion"] = $_REQUEST["direccion"];
    $usuario["email"] = $_REQUEST["email"];
    $usuario["telefono"] = $_REQUEST["telefono"];
    if(isset($_REQUEST['derechosImagen'])) 
        $usuario['derechosImagen']=$_REQUEST['derechosImagen'];
    if(isset($_REQUEST['checkResponsable'])){
        $usuario['checkResponsable']=$_REQUEST['checkResponsable'];
        $usuario["responsable"] = $_REQUEST["responsable"];
        $usuario['tipoRelacion'] = $_REQUEST["tipoRelacion"];
    } else {
        $usuario["responsable"] = null;
        $usuario['tipoRelacion'] = null;
    }
    
    $errores = validar($usuario);
    
    cerrarConexionBD($conexion);
    
    if ( count ($errores) > 0 ) {
        $_SESSION["registroUsuario"] = $usuario;
        $_SESSION["errores"] = $errores;
        Header("Location: ../registros/registraUsuario.php");
    }
    else {
        unset($_SESSION["registroUsuario"]);
        $_SESSION["usuarioExito"] = $usuario;
        Header("Location: ../exito/exitoUsuario.php");
    }
} 
else Header("Location: ../registros/registraUsuario.php");
    
function validar($usuario) {
    
    global $conexion;
    $errores = null;
        // Campos vacios
    if (empty($usuario["nombre"])) {
        $errores["nombre"] = "El nombre no se puede dejar vacío.";
    }
    if (empty($usuario["apellidos"])) {
        $errores["apellidos"] = "Los apellidos no se pueden dejar vacíos.";
    }
    if (empty($usuario["direccion"])) {
        $errores["direccion"] = "La direccion no se puede dejar vacía.";
    }
    if(isset($usuario['checkResponsable']) && empty($usuario['tipoRelacion'])){
        $errores["tipoRelacion"] = "El tipo de relacion no se puede dejar vacío.";
    }
    
    $edad = $usuario["fechaNacimiento"]->diff( new DateTime());
    
        // Menor de 3 años
          
    if  ( $edad->format("%y") < 3){
          
        $errores["fechaNacimiento"] = "El niño debe tener al menor 3 años para poder registrarse.";
        
        // Menor de 18 años
    } elseif (!isset($usuario["checkResponsable"]) && $edad->format("%y") < 18) {
        $errores["checkResponsable"] = true;
        $errores["responsable"] = "Los menores deben tener un responsable.";
        
    } elseif ((isset($usuario['checkResponsable']) && $usuario["responsable"] == "--Responsable--")){
        $errores["responsable"] = "Los menores deben tener un responsable.";
    }
    
        // Comprobacion email
     if ($usuario["email"] != "" && existeEmail($conexion, $usuario["email"])){
        $errores["email"] = "Este email ya esta registrado";
     }
    return $errores;
}
?>