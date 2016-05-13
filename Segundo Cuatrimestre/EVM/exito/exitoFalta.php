<?php
    session_start();
    
    require_once ("../gestion/gestionarFalta.php");
    require_once("../gestion/gestionBD.php");
    
    if(isset($_SESSION["faltaExito"])){
        $conexion = crearConexionBD();
        $falta = $_SESSION["faltaExito"];
		if(isset($falta['borrar'])){
			borraFalta($conexion,$falta['oid_f']);
		}else{
			if(isset($falta['actu'])){		
				actualizaFalta($conexion, $falta['oid_f'], 1);
			}else{
		        $tipo_falta = $falta["tipo_falta"];
		        $fecha = $falta['fecha_falta']->format("dmY");
		        $oid_m = $falta["usuario"];
		            
		        guardaFalta($conexion, $tipo_falta,  $fecha,  $oid_m);
	        
			}
		}
        
        cerrarConexionBD($conexion);
        Header("Location: ../vistas/faltas.php");
    } else {
        header("Location: ../registros/registraFalta.php");
    }
?>