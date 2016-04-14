<?php

    function listaUsuarios($conexion){
        try{
            $total_query = "SELECT * FROM USUARIOS";
            $stmt = $conexion->query( $total_query );
            return $stmt;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    
    function listaResponsables($conexion){
    	try{
    		$total_query = "SELECT OID_R, NOMBRE, APELLIDOS FROM RESPONSABLES";
    		$stmt = $conexion->query( $total_query );
    		return $stmt;
    	}catch(PDOException $e){
    		echo $e->getMessage();
    	}
    }
?>