<?php
    session_start();
    
    require_once ("../gestion/gestionarInstrumento.php");
    require_once("../gestion/gestionBD.php");
    
    if(isset($_SESSION["instrumentoExito"])){
        $conexion = crearConexionBD();
        $instrumento = $_SESSION["instrumentoExito"];
        if (isset($instrumento["devolver"])){
            devolverInstrumento($conexion,$instrumento['oid_i']);
        }
        else{

            $nombre = $instrumento["nombre"];
            $tipo = $instrumento["tipo"];
            $instrumentoLibre = $instrumento['instrumentoLibre'];
            $ESTADO_INSTRUMENTO = $instrumento['ESTADO_INSTRUMENTO'];
            if(!isset($instrumento['oid_i'])){
                guardaInstrumento($conexion, $tipo, $instrumentoLibre, $nombre, $ESTADO_INSTRUMENTO);
            
            } else {
                actualizaInstrumento($conexion, $instrumento['oid_i'], $tipo, $instrumentoLibre, $nombre, $ESTADO_INSTRUMENTO);
            }
        }
        
        cerrarConexionBD($conexion);
        
        Header("Location: ../vistas/instrumentos.php");
    } else {
        header("Location: ../registros/registraInstrumento.php");
    }
?>