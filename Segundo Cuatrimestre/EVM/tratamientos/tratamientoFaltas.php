<?php
session_start();
if (isset($_REQUEST["actu"])){
 		$falta["oid_f"] = $_REQUEST["oid_f"];
	  	$falta["actu"]="";
        $_SESSION["faltaExito"] = $falta;
        Header("Location: ../exito/exitoFalta.php");
    }else{
if (isset($_SESSION["registroFalta"]) ){    
  
	    $falta["tipo_falta"] = $_REQUEST["tipo_falta"];
	    $falta["fecha_falta"] = DateTime::createFromFormat("d/m/Y", ($_REQUEST["dia"]."/".$_REQUEST["mes"]."/".$_REQUEST["anio"]));
		$falta["usuario"] = $_REQUEST["usuario"];
	
    
    $errores = validar($falta);
    
    if ( count ($errores) > 0 ) {
        $_SESSION["registroFalta"] = $falta;
        $_SESSION["errores"] = $errores;
        Header("Location: ../registros/registraFalta.php");
    }
    else {
        unset($_SESSION["registroFalta"]);
        $_SESSION["faltaExito"] = $falta;
        Header("Location: ../exito/exitoFalta.php");
    }
} 
else Header("Location: ../registros/registraFalta.php");
}
function validar($falta) {
    
    $errores = null;
        // Campos vacios
    if (empty($falta["tipo_falta"])) {
        $errores["tipo_falta"] = "El tipo_falta no se puede dejar vacío.";
    }
	// if (empty($falta["usuario"])) {
        // $errores["usuario"] = "Seleccione un usuario.";
    // }
    
    return $errores;
}
?>