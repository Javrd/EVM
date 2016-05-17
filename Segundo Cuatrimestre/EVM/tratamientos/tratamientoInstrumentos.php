<?php
session_start();

if (isset($_REQUEST["devolver"])){
        echo "test";
        $instrumento["oid_i"] = $_REQUEST["oid_i"];
        $instrumento["devolver"] = True; //Para el cambio en exito.
        $_SESSION["instrumentoExito"] = $instrumento;
        Header("Location: ../exito/exitoInstrumento.php");
    }

elseif (isset($_SESSION["registroInstrumento"]) ){
    
    if (isset($_REQUEST["oid_i"])){
        $instrumento["oid_i"] = $_REQUEST["oid_i"];
    }
    $instrumento["nombre"] = $_REQUEST["nombre"];
    $instrumento["tipo"] = $_REQUEST["tipo"];
    $instrumento["ESTADO_INSTRUMENTO"] = $_REQUEST["ESTADO_INSTRUMENTO"];
    if(isset($_REQUEST['instrumentoLibre'])) {
        if ($_REQUEST['instrumentoLibre'] == '1'){
            $instrumento['instrumentoLibre'] = 1;
        }else {
            $instrumento['instrumentoLibre'] = 0;
        }

         
    }
    $errores = validar($instrumento);
    
    if ( count ($errores) > 0 ) {
        $_SESSION["registroInstrumento"] = $instrumento;
        $_SESSION["errores"] = $errores;
        Header("Location: ../registros/registraInstrumento.php");
    }
    else {
        unset($_SESSION["registroInstrumento"]);
        $_SESSION["instrumentoExito"] = $instrumento;
        Header("Location: ../exito/exitoInstrumento.php");
    }
} 
else Header("Location: ../registros/registraInstrumento.php");
    
function validar($instrumento) {
    
    $errores = null;
        // Campos vacios
    if (empty($instrumento["nombre"])) {
        $errores["nombre"] = "El nombre no se puede dejar vacío.";
    }

    if(($instrumento['tipo']) == -1){
        $errores["tipo"] = "El tipo del instrumento no se puede dejar vacío.";
    }

    if(($instrumento['ESTADO_INSTRUMENTO']) == -1){
        $errores["ESTADO_INSTRUMENTO"] = "El estado del instrumento no se puede dejar vacío.";
    }
    
    
   
    return $errores;
}
?>