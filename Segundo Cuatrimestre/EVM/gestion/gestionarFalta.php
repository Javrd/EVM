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
        }
    }
    
    function guardaFalta($conexion, $tipo_falta,  $fecha,  $oid_m){
        try{
            $stmt = $conexion->prepare("INSERT INTO FALTAS (tipo_falta,fecha_falta,justificada,oid_m)
				VALUES (:tipo_falta,TO_DATE(:fecha,'ddmmYYYY'),0,:oid_m) RETURNING oid_f INTO :oid_f");
            $stmt->bindParam(':tipo_falta',$tipo_falta);
            $stmt->bindParam(':fecha',$fecha);
            $stmt->bindParam(':oid_m',$oid_m);
            $stmt->bindParam(':oid_f',$oid_f, PDO::PARAM_INT, 8);
            $stmt->execute();
            return $oid_f;
                        
        }catch(PDOException $e){
        $_SESSION['error']=$e->GetMessage();
        header("Location:../error.php");
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
        } 
    }
        
    function consultaPaginadaFaltas($conexion,$pagina_seleccionada,$intervalo,$total,$constulta){
         $select = "SELECT USUARIOS.NOMBRE, USUARIOS.APELLIDOS, FALTAS.OID_F, FALTAS.TIPO_FALTA, FALTAS.FECHA_FALTA,
            	FALTAS.JUSTIFICADA FROM FALTAS NATURAL JOIN MATRICULAS NATURAL JOIN USUARIOS ORDER BY USUARIOS.APELLIDOS, USUARIOS.NOMBRE";
        return consultaPaginada($conexion,$pagina_seleccionada,$intervalo,$total,$select);
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
        }
    }
?>