<?php

    require_once("gestionBD.php");
    
    function listaInstrumentos($conexion){
        try{
            $total_query = "SELECT * FROM INSTRUMENTOS ORDER BY tipo";
            $stmt = $conexion->query( $total_query );
            return $stmt;
        }catch(PDOException $e){
        $_SESSION['error']=$e->GetMessage();
        header("Location:../error.php");
        }
    }

    
    function guardaInstrumento($conexion, $tipo, $instrumentoLibre, $nombre, $ESTADO_INSTRUMENTO){
        try{
            $stmt = $conexion->prepare("CALL CREAR_INSTRUMENTO(:tipo, :instrumentoLibre, :nombre, :ESTADO_INSTRUMENTO)"); 
            
            $stmt->bindParam(':tipo',$tipo);
            $stmt->bindParam(':instrumentoLibre',$instrumentoLibre);
            $stmt->bindParam(':nombre',$nombre);
            $stmt->bindParam(':ESTADO_INSTRUMENTO',$ESTADO_INSTRUMENTO);
            $stmt->execute();
                        
        }catch(PDOException $e){
        $_SESSION['error']=$e->GetMessage();
        header("Location:../error.php");
        }
    }

    function devolverInstrumento($conexion, $oid_i){
        try{
            $stmt = $conexion->prepare("UPDATE INSTRUMENTOS SET libre=:instrumentoLibre WHERE oid_i=:oid_i");
            $stmt->bindParam(':oid_i',$oid_i);
            $var = 1;
            $stmt->bindParam(':instrumentoLibre',$var);
            $stmt->execute();
                        
        } catch(PDOException $e){
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
        } 
    }
    
    function actualizaInstrumento($conexion, $oid_i, $tipo, $instrumentoLibre, $nombre, $ESTADO_INSTRUMENTO){
       try{
            $stmt = $conexion->prepare("UPDATE INSTRUMENTOS SET tipo=:tipo, libre=:instrumentoLibre, nombre=:nombre,
            estado_instrumento=:ESTADO_INSTRUMENTO WHERE oid_i=:oid_i");
            $stmt->bindParam(':oid_i',$oid_i);
            $stmt->bindParam(':tipo',$tipo);
            $stmt->bindParam(':instrumentoLibre',$instrumentoLibre);
            $stmt->bindParam(':nombre',$nombre);
            $stmt->bindParam(':ESTADO_INSTRUMENTO',$ESTADO_INSTRUMENTO);
            $stmt->execute();
                        
        } catch(PDOException $e){
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
        } 
    }
        
    function consultaPaginadaInstrumentos($conexion,$pagina_seleccionada,$intervalo,$total,$constulta){
        // if ($constulta == 'Usuarios con prestamos')
        //     $select = "SELECT oid_u, nombre, apellidos, fecha_nacimiento, direccion, email, telefono, derechos_imagen FROM PRESTAMOS NATURAL JOIN MATRICULAS NATURAL JOIN USUARIOS WHERE MATRICULAS.FECHA_MATRICULACION>(SYSDATE - 365) ORDER BY APELLIDOS, NOMBRE";
        // else
        $select = "SELECT * FROM INSTRUMENTOS ORDER BY TIPO, NOMBRE";
        return consultaPaginada($conexion,$pagina_seleccionada,$intervalo,$total,$select);
    }  
    
    function consultarTotalInstrumentos($conexion)  {
        try {
            $consulta = "SELECT COUNT(*) AS TOTAL FROM INSTRUMENTOS";
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
    
    function consultarUsuariosConPrestamos($conexion)  {
        try {
            $consulta = "SELECT COUNT(*) AS TOTAL FROM PRESTAMOS NATURAL JOIN MATRICULAS NATURAL JOIN USUARIOS WHERE MATRICULAS.FECHA_MATRICULACION>(SYSDATE - 365) ORDER BY APELLIDOS, NOMBRE";
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