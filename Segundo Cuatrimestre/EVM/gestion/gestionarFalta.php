<?php

    require_once("gestionBD.php");
    
    function listaUsuariosActivos($conexion){
        try{
            $total_query = "SELECT NOMBRE, APELLIDOS, OID_M FROM MATRICULAS NATURAL JOIN USUARIOS 
            							WHERE FECHA_MATRICULACION>(SYSDATE - 365) ORDER BY APELLIDOS, NOMBRE ";
            $stmt = $conexion->query( $total_query );
            return $stmt;
        }catch(PDOException $e){
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
            exit();
        }
    }
    
    function guardaFalta($conexion, $tipo_falta,  $fecha,  $oid_m){
        try{
            $stmt = $conexion->prepare("INSERT INTO FALTAS (tipo_falta,fecha_falta,justificada,oid_m)
				VALUES (:tipo_falta,TO_DATE(:fecha,'ddmmYYYY'),0,:oid_m)");
            $stmt->bindParam(':tipo_falta',$tipo_falta);
            $stmt->bindParam(':fecha',$fecha->format('dmY'));
            $stmt->bindParam(':oid_m',$oid_m);
            return $stmt->execute();
                        
        }catch(PDOException $e){
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
            exit();
        }
    }
    
    function actualizaFalta($conexion, $oid_f,$justificada){
       try{
            $stmt = $conexion->prepare("UPDATE FALTAS SET justificada=:justificada WHERE oid_f=:oid_f");
            $stmt->bindParam(':oid_f',$oid_f);
			$stmt->bindParam(':justificada',$justificada);
            $stmt->execute();
                        
        } catch(PDOException $e){
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
            exit();
        } 
    }
        
    function consultaPaginadaFaltas($conexion,$pagina_seleccionada,$intervalo,$total,$constulta){
        try{     
            $select = "SELECT USUARIOS.NOMBRE, USUARIOS.APELLIDOS, FALTAS.OID_F, FALTAS.TIPO_FALTA, FALTAS.FECHA_FALTA,
                	FALTAS.JUSTIFICADA FROM FALTAS NATURAL JOIN MATRICULAS NATURAL JOIN USUARIOS ORDER BY USUARIOS.APELLIDOS, USUARIOS.NOMBRE";
            $stmt = consultaPaginada($conexion,$pagina_seleccionada,$intervalo,$total,$select);
            $stmt->execute();
            return $stmt;
        } catch(PDOException $e){
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
            exit();
        } 
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
	
    function consultarTotalFaltas($conexion)  {
        try {
            $consulta = "SELECT COUNT(*) AS TOTAL FROM FALTAS";
            $stmt = $conexion->query($consulta);
            $result = $stmt->fetch();
            $total = $result['TOTAL' ];
            return (int)$total;
        }
        catch ( PDOException $e ) {
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
            exit();
        }
    }
?>