<?php
    session_start();
    
    require_once ("../gestion/gestionarAsignatura.php");
    require_once("../gestion/gestionBD.php");
    
    if(isset($_SESSION["asignaturaExito"])){
        $conexion = crearConexionBD();
        $asignatura = $_SESSION["asignaturaExito"];
        $nombre = $asignatura["nombre"];
        
        if(!isset($asignatura['oid_a'])){
            
            guardaAsignatura($conexion, $nombre);
            
        } else {
            $res = actualizaAsignatura($conexion, $asignatura['oid_a'], $nombre);
        }
        cerrarConexionBD($conexion);
        Header("Location: ../vistas/asignaturas.php");
    } else {
        Header("Location: ../vistas/asignaturas.php");
    }
?>