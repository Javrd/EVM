<?php
    session_start();
    
    require_once ("../gestion/gestionarFalta.php");
    require_once("../gestion/gestionBD.php");
    
    if(isset($_SESSION["matriculaExito"])){
        $conexion = crearConexionBD();
        $matricula = $_SESSION["matriculaExito"];
		//$tipo_falta = $falta["tipo_falta"];
		//$fecha= DateTime::createFromFormat("d/m/Y", ($falta["dia"]."/".$falta["mes"]."/".$falta["anio"]));
		//$oid_m = $falta["usuario"];
        //guardaMatricula($conexion);

		echo $matricula["curso"];
		echo $matricula['usuario'];
        
        cerrarConexionBD($conexion);
        //Header("Location: ../vistas/matriculas.php");
    } else {
        header("Location: ../registros/registraMatricula.php");
    }
?>