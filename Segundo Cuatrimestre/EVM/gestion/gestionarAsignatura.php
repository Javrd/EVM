<?php

    require_once("gestionBD.php");
    
    
    function guardaAsignatura($conexion, $nombre){
        try{
            $stmt = $conexion->prepare("INSERT INTO ASIGNATURAS (nombre) VALUES (:nombre)");
            $stmt->bindParam(':nombre',$nombre);
            $stmt->execute();
                        
        }catch(PDOException $e){
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
            exit();
        }
    }
    
    function actualizaAsignatura($conexion, $oid_a, $nombre){
       try{
            $stmt = $conexion->prepare("UPDATE ASIGNATURAS SET nombre=:nombre WHERE oid_a=:oid_a");
            $stmt->bindParam(':oid_a',$oid_a);
            $stmt->bindParam(':nombre',$nombre);
            return $stmt->execute();
                        
        } catch(PDOException $e){
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
            exit();
        } 
    }
        
    function consultaPaginadaAsignaturas($conexion,$pagina_seleccionada,$intervalo,$total){
        try{
            $select = "SELECT oid_a, nombre FROM ASIGNATURAS ORDER BY NOMBRE";
            $stmt = consultaPaginada($conexion,$pagina_seleccionada,$intervalo,$total,$select);
            $stmt->execute();
            return $stmt;
        } catch(PDOException $e){
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
            exit();
        } 
    }  
    
    function consultarTotalAsignaturas($conexion)  {
        try {
            $consulta = "SELECT COUNT(*) AS TOTAL FROM ASIGNATURAS";
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