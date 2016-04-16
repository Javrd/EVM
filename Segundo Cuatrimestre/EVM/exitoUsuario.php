<?php
    // TODO
    session_start();
    
    require_once ("GestionarUsuario.php");
    require_once("GestionBD.php");
    $conexion = crearConexionBD();
    
    if(isset($_SESSION["usuario"])){
        $usuario = $_SESSION["usuario"];
        $usuario["fechaNacimiento"]['dia'];
        $usuario["fechaNacimiento"]['mes'];
        $usuario["fechaNacimiento"]['anio'];
        if ($usuario["email"] == "") $usuario["email"] = null;
        if ($usuario["telefono"] == "") $usuario["telefono"] = null;
        $usuario["email"] = $_REQUEST["email"];
        $usuario["telefono"] = $_REQUEST["telefono"];
        if(isset($_REQUEST['derechosImagen'])) $usuario['derechosImagen']=$_REQUEST['derechosImagen'];
        if(isset($_REQUEST['checkResponsable'])) $usuario['checkResponsable']=$_REQUEST['checkResponsable'];
        $usuario["responsable"] = $_REQUEST["responsable"];
        $_SESSION["usuario"] = $usuario;
    } else {
        
    }
    guardaUsuarios($conexion, $nombre, $apellidos, $fecha, $direccion, $email, $telefono, $derechos);
?>