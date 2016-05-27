<?php
    session_start();
    
    require_once ("../gestion/gestionarMatricula.php");
    require_once("../gestion/gestionBD.php");
    
    if(isset($_SESSION["matriculaExito"])){
        $conexion = crearConexionBD();
        $matricula = $_SESSION["matriculaExito"];
		$curso = $matricula["curso"];
        $codigo = $matricula['codigo'];
		$fecha = DateTime::createFromFormat("d/m/Y", ($matricula["dia"]."/".$matricula["mes"]."/".$matricula["anio"]));
        $string = $matricula['usuario'];
        $oid_u = explode(" ", $string)[0];
        $oid_m = guardaMatricula($conexion,$fecha,$curso,$codigo,$oid_u);
        foreach ($matricula['asignaturas'] as $asignatura) {
            $asignatura = explode("/", $asignatura)[1];
            guardaPerteneceA($conexion, $oid_m, $asignatura);
        }
        Header("Location: ../vistas/matriculas.php");
    } else {
        header("Location: ../registros/registraMatricula.php");
    }
?>