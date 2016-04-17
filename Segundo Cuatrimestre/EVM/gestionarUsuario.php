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
            $stmt = $conexion->prepare("INSERT INTO USUARIOS (nombre,apellidos,fecha_nacimiento,direccion,email,telefono,derechos_imagen)
VALUES (:nombre, :apellidos, TO_DATE(:fecha,'ddmmYYYY'), :direccion, :email, :telefono, :derechos) RETURNING oid_u INTO :oid_u");
            $oid_u = null;
            $stmt->bindParam(':nombre',$nombre);
            $stmt->bindParam(':apellidos',$apellidos);
            $stmt->bindParam(':fecha',$fecha);
            $stmt->bindParam(':direccion',$direccion);
            $stmt->bindParam(':email',$email);
            $stmt->bindParam(':telefono',$telefono);
            $stmt->bindParam(':derechos',$derechos);
            $stmt->bindParam(':oid_u',$oid_u, PDO::PARAM_INT, 8);
            $stmt->execute();
            return $oid_u;
                        
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
?>