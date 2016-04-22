<?php
    session_start();
    
    require_once ("GestionarUsuario.php");
    require_once ("GestionarResponsable.php");
    require_once("GestionBD.php");
    
    if(isset($_SESSION["usuarioExito"])){
        $conexion = crearConexionBD();
        $usuario = $_SESSION["usuarioExito"];
        $nombre = $usuario["nombre"];
        $apellidos = $usuario["apellidos"];
        $fecha = $usuario['fechaNacimiento']['dia'].$usuario['fechaNacimiento']['mes']
        .$usuario['fechaNacimiento']['anio'];
        $direccion = $usuario["direccion"];
        if ($usuario["email"] == ""){
            $email = null;   
        } else{
            $email = $usuario["email"];
        }
        if ($usuario["telefono"] == ""){
            $telefono = null;   
        } else{
            $telefono = $usuario["telefono"];
        }
        if(isset($usuario['derechosImagen'])){
            $derechos = 1;
        } else {
            $derechos = 0;
        }
        
        $oid_u = guardaUsuarios($conexion, $nombre, $apellidos, $fecha, $direccion, $email, $telefono, $derechos);
        
        if(isset($usuario['checkResponsable'])){
            $responsable = $usuario['responsable'];   
            $relacion = $usuario['tipoRelacion']; 
            guardaRelacion($conexion,$oid_u,$responsable,$relacion);
        }
        
        cerrarConexionBD($conexion);
        
        Header("Location: usuarios.php");
    } else {
        header("Location: registraUsuario.php");
    }
?>