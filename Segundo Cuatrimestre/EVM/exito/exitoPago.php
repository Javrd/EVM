<?php
    session_start();
    
    require_once ("../gestion/gestionarPago.php");
    require_once("../gestion/gestionBD.php");
    
    if (isset($_REQUEST["actu"])){
        
        $conexion = crearConexionBD();
        $oid_pa = $_REQUEST["oid_pa"];  
        actualizaPago($conexion, $oid_pa);    
        cerrarConexionBD($conexion);
    }
    
    Header("Location: ../vistas/pagos.php");
?>