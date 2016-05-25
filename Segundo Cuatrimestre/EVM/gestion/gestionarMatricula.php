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
    
    function guardaMatricula($conexion,  $fecha, $curso, $codigo, $oid_u){
        try{
            $stmt = $conexion->prepare("INSERT INTO MATRICULAS (FECHA_MATRICULACION,CURSO,CODIGO,OID_U)
				VALUES (TO_DATE(:FECHA_MATRICULACION,'ddmmYYYY'),:CURSO,:CODIGO,:OID_U) RETURNING OID_M INTO :OID_M");
            $stmt->bindParam(':FECHA_MATRICULACION',$fecha->format('dmY'));
            $stmt->bindParam(':CURSO',$curso);
            $stmt->bindParam(':CODIGO',$codigo);
            $stmt->bindParam(':OID_U',$oid_u);
            $stmt->bindParam(':OID_M',$oid_m, PDO::PARAM_INT, 8);
            $stmt->execute();
            return $oid_m;
                        
        }catch(PDOException $e){
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
            exit();
        }
    }

    function guardaPerteneceA($conexion,  $oid_m, $oid_a){
        try{
            $stmt = $conexion->prepare("INSERT INTO PERTENECE_A (oid_m, oid_a)
                VALUES (:oid_m,:oid_a)");
            $stmt->bindParam(':oid_m',$oid_m);
            $stmt->bindParam(':oid_a',$oid_a);
            return $stmt->execute();
                        
        }catch(PDOException $e){
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
            exit();
        }
    }

    
    function edadDeUsuario($conexion, $oid_u){
        try{
            $stmt = $conexion->prepare("SELECT to_char(fecha_nacimiento, 'dd/mm/yyyy') as FECHA_NACIMIENTO FROM USUARIOS WHERE oid_u=:oid_u");
            $stmt->bindParam(':oid_u',$oid_u);
            $stmt->execute();
            $stmt = $stmt->fetch();
            return $stmt;

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
            $stmt = $conexion->prepare("SELECT OID_A, NOMBRE FROM ASIGNATURAS");
            $stmt->execute();
            return $stmt;
        } catch(PDOException $e){
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
            exit();
        } 
    }

    function consultarBusqueda($conexion,$palabra)  {
        try {
            $stmt = $conexion-> prepare("SELECT COUNT(*) AS TOTAL FROM MATRICULAS WHERE CODIGO=:palabra or NOMBRE=:palabra");
            $stmt->bindParam(':palabra',$palabra);
            $stmt->execute();
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



    function consultaPaginadaMatriculas($conexion,$pagina_seleccionada,$intervalo,$total,$consulta){
        if ($consulta == 'Todas'){
            $select = "SELECT USUARIOS.NOMBRE, USUARIOS.APELLIDOS, MATRICULAS.OID_M, MATRICULAS.CODIGO, MATRICULAS.FECHA_MATRICULACION ,
            	MATRICULAS.CURSO FROM MATRICULAS NATURAL JOIN USUARIOS ORDER BY USUARIOS.APELLIDOS, USUARIOS.NOMBRE";
        	return consultaPaginada($conexion,$pagina_seleccionada,$intervalo,$total,$select);
        }else{
            try {
                $stmt = $conexion->prepare("SELECT USUARIOS.NOMBRE, USUARIOS.APELLIDOS, MATRICULAS.OID_M, MATRICULAS.CODIGO, MATRICULAS.FECHA_MATRICULACION ,
                    MATRICULAS.CURSO FROM MATRICULAS NATURAL JOIN USUARIOS WHERE MATRICULAS.OID_M=:consulta ORDER BY USUARIOS.APELLIDOS, USUARIOS.NOMBRE");
                $stmt->bindParam( ':consulta', $consulta);
                $stmt->execute();
                return $stmt;
            }
            catch ( PDOException $e ) {
                $_SESSION['error']=$e->GetMessage();
                header("Location:../error.php");
                exit();
            }
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