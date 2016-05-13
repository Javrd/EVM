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
	
	function listaInstrumentosActivos($conexion){
        try{
            $total_query = "SELECT NOMBRE, OID_I FROM INSTRUMENTOS WHERE LIBRE=1";
            $stmt = $conexion->query( $total_query );
            return $stmt;
        }catch(PDOException $e){
        $_SESSION['error']=$e->GetMessage();
        header("Location:../error.php");
        }
    }
    
    function guardaPrestamo($conexion, $oid_i, $oid_m){
        try{
        	$fecha= new DateTime();
            $stmt = $conexion->prepare("INSERT INTO PRESTAMOS (oid_i,fecha_prestamo,oid_m)
				VALUES (:oid_i,TO_DATE(".$fecha->format('dmY').",'ddmmYYYY'),:oid_m)");
            $stmt->bindParam(':oid_i',$oid_i);
            $stmt->bindParam(':oid_m',$oid_m);
            return $stmt->execute();
                        
        }catch(PDOException $e){
        $_SESSION['error']=$e->GetMessage();
        header("Location:../error.php");
        }
    }
        
    function consultaPaginadaPrestamos($conexion,$pagina_seleccionada,$intervalo,$total,$constulta){
         $select = "SELECT USUARIOS.NOMBRE AS USUARIOSNOMBRE, USUARIOS.APELLIDOS, INSTRUMENTOS.NOMBRE, FECHA_PRESTAMO
          FROM INSTRUMENTOS, PRESTAMOS, MATRICULAS, USUARIOS WHERE INSTRUMENTOS.OID_I=PRESTAMOS.OID_I AND
          PRESTAMOS.OID_M=MATRICULAS.OID_M AND MATRICULAS.OID_U=USUARIOS.OID_U ORDER BY FECHA_PRESTAMO DESC";
        return consultaPaginada($conexion,$pagina_seleccionada,$intervalo,$total,$select);
    }  
    
    function consultarTotalPrestamos($conexion)  {
        try {
            $consulta = "SELECT COUNT(*) AS TOTAL FROM PRESTAMOS";
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