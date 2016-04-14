<?php
session_start();
if (isset($_SESSION["usuario"]) ){
    $usuario["action"] = $_SESSION["usuario"]["action"];
    $usuario["nombre"] = $_REQUEST["nombre"];
    $usuario["apellidos"] = $_REQUEST["apellidos"];
    $usuario["fechaNacimiento"]['dia']= $_REQUEST["dia"];
    $usuario["fechaNacimiento"]['mes']= $_REQUEST["mes"];
    $usuario["fechaNacimiento"]['anio']= $_REQUEST["anio"];
    $usuario["direccion"] = $_REQUEST["direccion"];
    $usuario["email"] = $_REQUEST["email"];
    $usuario["telefono"] = $_REQUEST["telefono"];
    $usuario["responsable"] = $_REQUEST["responsable"];
    $_SESSION["usuario"] = $usuario;
    
    $errores = validar($usuario);
    
    if ( count ($errores) > 0 ) {
        $_SESSION["errores"] = $errores;
        Header("Location: registraUsuario.php");
    }
    else Header("Location: exito.php");
} 
else Header("Location: registraUsuario.php");
    
    function validar($usuario) {
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
    
    
    $anios = date("Y") - $usuario["fechaNacimiento"]['anio'];
    $meses = date("m") - ($usuario["fechaNacimiento"]['mes']);
    $dias = date("d") - ($usuario["fechaNacimiento"]['dia']);
    
        // Menor de 18 años
        
    if (!isset($_REQUEST["checkResponsable"]) && 
        ( $anios < 18 || ( $anios == 18 && 
        ( $meses < 0 || ( $meses == 0 && $dias < 0 ))))){  
        $errores["responsable"] = "Los menores deben tener un responsable.";
    } 
        
    return $errores;
}
?>