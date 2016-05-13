<?php
    session_start();
    
    require_once ("../gestion/gestionarPrestamo.php");
    require_once("../gestion/gestionBD.php");
    
    if(isset($_SESSION["prestamoExito"])){
        $conexion = crearConexionBD();
        $prestamo = $_SESSION["prestamoExito"];

        $oid_i = $prestamo["instrumento"];
        $oid_m = $prestamo["usuario"];
            
        guardaPrestamo($conexion, $oid_i, $oid_m);
          
        cerrarConexionBD($conexion);
       Header("Location: ../vistas/prestamos.php");
    } else {
        header("Location: ../registros/registraPrestamo.php");
    }
?>