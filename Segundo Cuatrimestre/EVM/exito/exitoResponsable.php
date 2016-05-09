<?php
    session_start();
  
    require_once ("../gestion/gestionarResponsable.php");
    require_once("../gestion/gestionBD.php");
    
    if(isset($_SESSION["responsableExito"])){
        $conexion = crearConexionBD();
        $responsable = $_SESSION["responsableExito"];
        $nombre = $responsable["nombre"];
        $apellidos = $responsable["apellidos"];
        if ($responsable["email"] == ""){
            $email = null;   
        } else{
            $email = $responsable["email"];
        }
        $telefono = $responsable["telefono"];
        
        if(!isset($responsable['oid_r']))
           $exito = guardaResponsable($conexion, $nombre, $apellidos, $email, $telefono);
        else 
           $exito = actualizaResponsable($conexion, $responsable['oid_r'], $nombre, $apellidos, $email, $telefono);
        
        cerrarConexionBD($conexion);
        if ($exito)
            Header("Location: ../vistas/responsables.php");
    } else {
        header("Location: ../registros/registraResponsable.php");
    }
?>