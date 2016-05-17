<?php
session_start();
require_once("../gestion/gestionBD.php");
require_once("../gestion/gestionarFalta.php");
$conexion = crearConexionBD();
if(isset($_REQUEST['borrar'])){
	$falta["oid_f"] = $_REQUEST["oid_f"];
	$falta["borrar"]="";
    $_SESSION["faltaExito"] = $falta;
    Header("Location: ../exito/exitoFalta.php");
}else{
	if (isset($_REQUEST["actu"])){
	 		$falta["oid_f"] = $_REQUEST["oid_f"];
		  	$falta["actu"]="";
	        $_SESSION["faltaExito"] = $falta;
	        Header("Location: ../exito/exitoFalta.php");
	    }else{
			if (isset($_SESSION["registroFalta"]) ){    
			  
				    $falta["tipo_falta"] = $_REQUEST["tipo_falta"];
					$falta["dia"] = $_REQUEST["dia"];
					$falta["mes"] = $_REQUEST["mes"];
					$falta["anio"] = $_REQUEST["anio"];
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
}

function validar($falta) {
    global $conexion;
    $errores = null;

	if ($falta["usuario"]=="-1") {
        $errores["usuario"] = "Seleccione un usuario.";
    }else {
    	if(!checkdate($falta["mes"], $falta["dia"], $falta["anio"])){
			$errores['fecha_falta'] = "Introduzca una fecha válida.";
		}else{			
	 		$fecha_falta = DateTime::createFromFormat("d/m/Y", ($falta["dia"]."/".$falta["mes"]."/".$falta["anio"]));		
			 $fecha = DateTime::createFromFormat("d/m/y",getFechaMatriculacion($conexion, $falta['usuario']));
			if($fecha>$fecha_falta){
				$errores['fecha_falta'] = "La fecha no puede ser anterior a la fecha de Matriculación.";
			}
		}
	}
	if(!checkdate($falta["mes"], $falta["dia"], $falta["anio"])){
		$errores['fecha_falta'] = "Introduzca una fecha válida.";
	}else{
	 $fecha_falta= DateTime::createFromFormat("d/m/Y", ($falta["dia"]."/".$falta["mes"]."/".$falta["anio"]));		
	 if($fecha_falta>new DateTime()){
		$errores['fecha_falta'] = "La fecha no puede ser posterior a hoy.";
		}
	}
    return $errores;
}

     cerrarConexionBD($conexion);  
?>