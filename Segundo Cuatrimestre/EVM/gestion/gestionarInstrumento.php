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
            exit();
        }
    }

    
    function guardaInstrumento($conexion, $tipo, $nombre, $ESTADO_INSTRUMENTO){
        try{
            $stmt = $conexion->prepare("CALL CREAR_INSTRUMENTO(:tipo, :instrumentoLibre, :nombre, :ESTADO_INSTRUMENTO)"); 
            $libre = 1;
            $stmt->bindParam(':tipo',$tipo);
            $stmt->bindParam(':instrumentoLibre', $libre);
            $stmt->bindParam(':nombre',$nombre);
            $stmt->bindParam(':ESTADO_INSTRUMENTO',$ESTADO_INSTRUMENTO);
            $stmt->execute();
                        
        }catch(PDOException $e){
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
            exit();
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
            exit();
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
            exit();
        } 
    }
        
    function consultaPaginadaInstrumentos($conexion,$pagina_seleccionada,$intervalo,$total,$constulta){
        try{
            if ($constulta == 'instrumentosLibres')
                $select = "SELECT * FROM INSTRUMENTOS WHERE LIBRE = 1 ORDER BY TIPO, NOMBRE";
            else
                $select = "SELECT * FROM INSTRUMENTOS ORDER BY TIPO, NOMBRE";
            $stmt = consultaPaginada($conexion,$pagina_seleccionada,$intervalo,$total,$select);
            $stmt->execute();
            return $stmt;
        } catch(PDOException $e){
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
            exit();
        } 
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
            exit();
        }
    }
    
    function consultarInstrumentosLibres($conexion)  {
        try {
            $consulta = "SELECT COUNT(*) AS TOTAL FROM INSTRUMENTOS WHERE LIBRE=1";
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