<?php
session_start();
if (isset($_SESSION["usuario"]) ){
    $usuario["nombre"] = $_REQUEST["nombre"];
    $usuario["apellidos"] = $_REQUEST["apellidos"];
    $usuario["fechaNacimiento"]['dia']= $_REQUEST["dia"];
    $usuario["fechaNacimiento"]['mes']= $_REQUEST["mes"];
    $usuario["fechaNacimiento"]['anio']= $_REQUEST["anio"];
    $usuario["direccion"] = $_REQUEST["direccion"];
    $usuario["email"] = $_REQUEST["email"];
    $usuario["telefono"] = $_REQUEST["telefono"];
    if(isset($_REQUEST['derechosImagen'])) $usuario['derechosImagen']=$_REQUEST['derechosImagen'];
    if(isset($_REQUEST['checkResponsable'])) $usuario['checkResponsable']=$_REQUEST['checkResponsable'];
    $usuario["responsable"] = $_REQUEST["responsable"];
    $usuario['tipoRelacion'] = $_REQUEST["tipoRelacion"];
    
    $errores = validar($usuario);
    
    if ( count ($errores) > 0 ) {
        $_SESSION["usuario"] = $usuario;
        $_SESSION["errores"] = $errores;
        Header("Location: registraUsuario.php");
    }
    else {
        $_SESSION["usuarioExito"] = $usuario;
        Header("Location: exitoUsuario.php");
    }
} 
else Header("Location: registraUsuario.php");
    
    function validar($usuario) {
    
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
    if(isset($_REQUEST['checkResponsable']) && empty($usuario['tipoRelacion'])){
        $errores["tipoRelacion"] = "El tipo de relacion no se puede dejar vacío.";
    }
    
    
    $anios = date("Y") - $usuario["fechaNacimiento"]['anio'];
    $meses = date("m") - ($usuario["fechaNacimiento"]['mes']);
    $dias = date("d") - ($usuario["fechaNacimiento"]['dia']);
    
        // Menor de 3 años
          
    if  ( $anios == 3 && ( $meses < 0 || ( $meses == 0 && $dias < 0 ) ) ){
          
        $errores["fechaNacimiento"] = "El niño debe tener al menor 3 años para poder registrarse.";
        
        // Menor de 18 años
    } elseif (!isset($_REQUEST["checkResponsable"]) && 
        ( $anios < 18 || ( $anios == 18 && 
        ( $meses < 0 || ( $meses == 0 && $dias < 0 ) ) ))){
              
        $errores["responsable"] = "Los menores deben tener un responsable.";
        
    } 
    return $errores;
}
?>