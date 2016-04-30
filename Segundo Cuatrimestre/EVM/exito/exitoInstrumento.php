<?php
    session_start();
    
    require_once ("../gestion/gestionarInstrumento.php");
    require_once("../gestion/gestionBD.php");
    
    if(isset($_SESSION["instrumentoExito"])){
        $conexion = crearConexionBD();
        $instrumento = $_SESSION["instrumentoExito"];
        $nombre = $instrumento["nombre"];
        $tipo = $instrumento["tipo"];
        $ESTADO_INSTRUMENTO = $instrumento['ESTADO_INSTRUMENTO'];
        if(isset($instrumento['instrumentoLibre'])){
            $instrumentoLibre = 1;
        } else {
            $instrumentoLibre = 0;
        }
        if(!isset($instrumento['oid_i'])){
            guardaInstrumento($conexion, $tipo, $instrumentoLibre, $nombre, $ESTADO_INSTRUMENTO);
        
        } else {
            actualizaInstrumento($conexion, $instrumento['oid_i'], $tipo, $instrumentoLibre, $nombre, $ESTADO_INSTRUMENTO);
        }
        
        cerrarConexionBD($conexion);
        
        Header("Location: ../vistas/instrumentos.php");
    } else {
        header("Location: ../registros/registraInstrumento.php");
    }
?>