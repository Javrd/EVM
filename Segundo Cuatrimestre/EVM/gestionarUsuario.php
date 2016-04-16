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
    
    function guardaUsuarios($conexion, $nombre, $apellidos, $fecha, $direccion, $email, $telefono, $derechos){
        try{
            $stmt = $conexion->prepare("crear_usuario(:nombre, :apellidos, :fecha, :direccion, :email, :telefono, :derechos);");
            $stmt->bindParam(':nombre',$nombre);
            $stmt->bindParam(':apellidos',$apellidos);
            $stmt->bindParam(':fecha',$fecha);
            $stmt->bindParam(':direccion',$direccion);
            $stmt->bindParam(':email',$email);
            $stmt->bindParam(':telefono',$telefono);
            $stmt->bindParam(':derechos',$derechos);
            $stmt->execute();
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