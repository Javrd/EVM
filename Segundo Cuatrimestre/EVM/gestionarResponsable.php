<?php
    
    function listaResponsables($conexion){
        try{
            $total_query = "SELECT OID_R, NOMBRE, APELLIDOS FROM RESPONSABLES";
            $stmt = $conexion->query( $total_query );
            return $stmt;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    
    function guardaRelacion($conexion, $oid_u, $oid_r, $tipoRelacion){
        try{
            $stmt = $conexion->prepare("CALL CREAR_RELACION(:oid_u, :oid_r, :tipoRelacion)");
            $stmt->bindParam(':oid_u',$oid_u);
            $stmt->bindParam(':oid_r',$oid_r);
            $stmt->bindParam(':tipoRelacion',$tipoRelacion);
            $stmt->execute();
                        
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
?>