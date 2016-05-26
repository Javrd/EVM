<?php

    
    function actualizaPago($conexion, $oid_pa){
       try{
            $fecha= new DateTime();
            $stmt = $conexion->prepare("UPDATE PAGOS SET estado='Pagado', FECHA_PAGO=TO_DATE(".$fecha->format('dmY').",'ddmmYYYY') WHERE oid_pa=:oid_pa");
            $stmt->bindParam(':oid_pa',$oid_pa);
            $stmt->execute();
                        
        } catch(PDOException $e){
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
            exit();
        } 
    }
        
    function consultaPaginadaPagos($conexion,$pagina_seleccionada,$intervalo,$total, $consulta){
        try{
            if ($consulta==""){
                $select = "SELECT NOMBRE, APELLIDOS, OID_PA, CANTIDAD, CONCEPTO, FECHA_PAGO, ESTADO 
                FROM PAGOS NATURAL JOIN MATRICULAS NATURAL JOIN USUARIOS 
                ORDER BY ESTADO DESC, FECHA_PAGO, CONCEPTO";
                $stmt = consultaPaginada($conexion,$pagina_seleccionada,$intervalo,$total,$select);
            } else {
                $select =  "SELECT NOMBRE, APELLIDOS, OID_PA, CANTIDAD, CONCEPTO, FECHA_PAGO, ESTADO 
                FROM PAGOS NATURAL JOIN MATRICULAS NATURAL JOIN USUARIOS 
                WHERE LOWER(NOMBRE) LIKE '%'||LOWER(:consulta)||'%' OR LOWER(APELLIDOS) LIKE '%'||LOWER(:consulta)||'%' 
                ORDER BY APELLIDOS, NOMBRE, ESTADO DESC, FECHA_PAGO, CONCEPTO ";
                $stmt = consultaPaginada($conexion,$pagina_seleccionada,$intervalo,$total,$select);
                $stmt->bindParam(':consulta', $consulta);
            }
            $stmt->execute();
            return $stmt;
        } catch(PDOException $e){
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
            exit();
        } 
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
    
    function consultarPagosDeUsuarios($conexion,$consulta)  {
        try {
            $q = "SELECT COUNT(*) AS TOTAL FROM PAGOS NATURAL JOIN MATRICULAS NATURAL JOIN USUARIOS
                            WHERE LOWER(NOMBRE) LIKE '%'||LOWER(:consulta)||'%' OR LOWER(APELLIDOS) LIKE '%'||LOWER(:consulta)||'%'";
                            
            $stmt = $conexion->prepare($q);
            $stmt->bindParam(':consulta',$consulta);
            $stmt->execute();
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