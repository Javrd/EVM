<?php

    require_once("gestionBD.php");
    
    function listaUsuarios($conexion){
        try{
            $total_query = "SELECT * FROM USUARIOS ORDER BY nombre";
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
            $stmt->bindParam(':fecha',$fecha);
            $stmt->bindParam(':oid_m',$oid_m);
            return $stmt->execute();
                        
        }catch(PDOException $e){
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
            exit();
        }
    }
    
    function edadDeUsuario($conexion, $oid_u){
        try{
            $stmt = $conexion->prepare("SELECT FECHA_NACIMIENTO FROM USUARIOS WHERE oid_u=:oid_u");
            $stmt->bindParam(':oid_u',$oid_u);
            $stmt->execute();
            $hoy = new Datetime('today');
            $stmt = $stmt->fetch();
            $fechaNac = DateTime::createFromFormat("d/m/Y", ($stmt['FECHA_NACIMIENTO']));
            $age = $fechaNac->diff($hoy)->y;
            return $age;

        } catch(PDOException $e){
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
            exit();
        } 
    }

    function consultaAsignaturasDeMatricula($conexion, $oid_m){
        try{
            $stmt = $conexion->prepare("SELECT NOMBRE FROM PERTENECE_A NATURAL JOIN ASIGNATURAS WHERE oid_m=:oid_m");
            $stmt->bindParam(':oid_m',$oid_m);
            $stmt->execute();
            return $stmt;
        } catch(PDOException $e){
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
            exit();
        } 
    }

    function consultaAsignaturas($conexion){
        try{
            $stmt = $conexion->prepare("SELECT NOMBRE FROM ASIGNATURAS");
            $stmt->bindParam(':oid_m',$oid_m);
            $stmt->execute();
            return $stmt;
        } catch(PDOException $e){
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
            exit();
        } 
    }



    function consultaPaginadaMatriculas($conexion,$pagina_seleccionada,$intervalo,$total,$constulta){
         $select = "SELECT USUARIOS.NOMBRE, USUARIOS.APELLIDOS, MATRICULAS.OID_M, MATRICULAS.CODIGO, MATRICULAS.FECHA_MATRICULACION ,
            	MATRICULAS.CURSO FROM MATRICULAS NATURAL JOIN USUARIOS ORDER BY USUARIOS.APELLIDOS, USUARIOS.NOMBRE";
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
	
    function consultarTotalMatriculas($conexion)  {
        try {
            $consulta = "SELECT COUNT(*) AS TOTAL FROM MATRICULAS";
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