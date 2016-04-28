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
    function getRelacion($conexion, $oid_u){
        try{
            $stmt = $conexion->prepare("SELECT OID_R, TIPO_RELACION FROM RELACIONES WHERE OID_U=:oid_u");
            $stmt ->bindParam(':oid_u',$oid_u);
            $stmt->execute();
            return $stmt->fetch();
        }catch(PDOException $e){
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
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
    
    function consultarTotalResponsables($conexion)  {
        try {
            $consulta = "SELECT COUNT(*) AS TOTAL FROM USUARIOS";
            $stmt = $conexion->query($consulta);
            $result = $stmt->fetch();
            $total = $result['TOTAL' ];
            return (int)$total;
        }
        catch ( PDOException $e ) {
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
        }
    }
    
    function consultaPaginadaResponsables($conexion,$pagina_seleccionada,$intervalo,$total){
            $select = "SELECT * FROM RESPONSABLES ORDER BY APELLIDOS, NOMBRE";
        return consultaPaginada($conexion,$pagina_seleccionada,$intervalo,$total,$select);
    }  
    
?>