<?php

    
    function actualizaPago($conexion, $oid_pa){
       try{
            $stmt = $conexion->prepare("UPDATE PAGOS SET estado='Pagado' WHERE oid_pa=:oid_pa");
            $stmt->bindParam(':oid_pa',$oid_pa);
            $stmt->execute();
                        
        } catch(PDOException $e){
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
            exit();
        } 
    }
        
    function consultaPaginadaPagos($conexion,$pagina_seleccionada,$intervalo,$total){
         $select = "SELECT NOMBRE, APELLIDOS, OID_PA, CANTIDAD, CONCEPTO, FECHA_PAGO,
            	ESTADO FROM PAGOS NATURAL JOIN MATRICULAS NATURAL JOIN USUARIOS ORDER BY ESTADO DESC, FECHA_PAGO, CONCEPTO";
        return consultaPaginada($conexion,$pagina_seleccionada,$intervalo,$total,$select);
    }  
    
    function consultarTotalPagos($conexion)  {
        try {
            $consulta = "SELECT COUNT(*) AS TOTAL FROM PAGOS";
            $stmt = $conexion->query($consulta);
            $result = $stmt->fetch();
            $total = $result['TOTAL'];
            return (int)$total;
        }
        catch ( PDOException $e ) {
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
            exit();
        }
    }
?>