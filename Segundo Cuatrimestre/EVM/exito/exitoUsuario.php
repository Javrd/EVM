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
        $fecha = $usuario['fechaNacimiento']->format("dmY");
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
        
        if(!isset($usuario['oid_u'])){
            
            $oid_u = guardaUsuario($conexion, $nombre, $apellidos, $fecha, $direccion, $email, $telefono, $derechos);
            $res = oid_u;
        } else {
            $res = actualizaUsuario($conexion, $usuario['oid_u'], $nombre, $apellidos, $fecha, $direccion, $email, $telefono, $derechos);
        }
        if ($oid_u != null || $res!=null){
            $res = null;
            if(isset($usuario['checkResponsable'])){
                $responsable = $usuario['responsable'];   
                $relacion = $usuario['tipoRelacion'];
                if (!isset($usuario['oid_u']))
                    $res = guardaRelacion($conexion,$oid_u,$responsable,$relacion);
                else
                    $res = actualizaRelacion($conexion, $usuario['oid_u'], $responsable, $relacion);
                    
            }
        }
        cerrarConexionBD($conexion);
        if ($res!=null)
            Header("Location: ../vistas/usuarios.php");
    } else {
        header("Location: ../registros/registraUsuario.php");
    }
?>