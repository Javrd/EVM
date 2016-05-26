<?php
session_start();

if (isset($_POST["nombre"]) ){
    
    if (isset($_REQUEST['oid']))
        $asignatura['oid_a']=$_REQUEST['oid'];
    $asignatura["nombre"] = $_REQUEST["nombre"];
 
    $error = validar($asignatura);
    
    if ( count ($error) > 0 ) {
        $_SESSION["nuevaAsignatura"] = $asignatura;
            if (!isset($asignatura['oid_a']))
                $_SESSION["modalError"] = $error;
            else
                $_SESSION["error"] = $error;
        Header("Location: ../vistas/asignaturas.php");
    }
    else {
        unset($_SESSION["registroUsuario"]);
        $_SESSION["asignaturaExito"] = $asignatura;
        Header("Location: ../exito/exitoAsignatura.php");
    }
} 
else Header("Location: ../vistas/asignaturas.php");
    
function validar($asignatura) {
    
    $error = null;
        // Campos vacios
    if (empty($asignatura["nombre"])) {
        $error["nombre"] = "El nombre no se puede dejar vacío.";
    }
    return $error;
}
?>