<?php
    session_start();
    
    require_once ("../gestion/gestionarUsuario.php");
    require_once ("../gestion/gestionarResponsable.php");
    require_once("../gestion/gestionBD.php");
    
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
        
        Header("Location: ../vistas/usuarios.php");
    } else {
        header("Location: ../registros/registraUsuario.php");
    }
?>