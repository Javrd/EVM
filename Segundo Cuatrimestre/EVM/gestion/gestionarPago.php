<?php

    require_once("gestionBD.php");
    
    function actualizaPago($conexion, $oid_f){
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
         $select = "SELECT NOMBRE, APELLIDOS, OID_PA, CANTIDAD, CONCEPTO, FECHA_PAGOS,
            	ESTADO FROM FALTAS NATURAL JOIN MATRICULAS NATURAL JOIN USUARIOS ORDER BY FECHA_PAGOS";
        return consultaPaginada($conexion,$pagina_seleccionada,$intervalo,$total,$select);
    }  
    
	function getFechaMatriculacion($conexion, $oid_m){
		 try{
            $stmt = $conexion->prepare("SELECT FECHA_MATRICULACION FROM MATRICULAS WHERE oid_m=:oid_m");
            $stmt->bindParam(':oid_m',$oid_m);
            $stmt->execute();
			$result = $stmt->fetch();
            $total = $result['FECHA_MATRICULACION'];
			return $total;
                        
        } catch(PDOException $e){
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
            exit();
        } 
	}
	
	function borraFalta($conexion,$oid_f){
		try{
            $stmt = $conexion->prepare("DELETE FROM FALTAS WHERE oid_f=:oid_f");
            $stmt->bindParam(':oid_f',$oid_f);
            $stmt->execute();
                        
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
?>