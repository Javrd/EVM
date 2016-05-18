<?php
    
    function listaResponsables($conexion){
        try{
            $total_query = "SELECT OID_R, NOMBRE, APELLIDOS FROM RESPONSABLES";
            $stmt = $conexion->query( $total_query );
            return $stmt;
        }catch(PDOException $e){
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
            exit();
        }
    }
    function getRelacion($conexion, $oid_u){
        try{
            $stmt = $conexion->prepare("SELECT OID_R, TIPO_RELACION FROM RELACIONES WHERE OID_U=:oid_u");
            $stmt ->bindParam(':oid_u',$oid_u);
            $stmt->execute();
            return $stmt->fetch();
        }catch(PDOException $e){
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
            exit();
        }
    }
    function guardaRelacion($conexion, $oid_u, $oid_r, $tipoRelacion){
        try{
            $stmt = $conexion->prepare("CALL CREAR_RELACION(:oid_u, :oid_r, :tipoRelacion)");
            $stmt->bindParam(':oid_u',$oid_u);
            $stmt->bindParam(':oid_r',$oid_r);
            $stmt->bindParam(':tipoRelacion',$tipoRelacion);
            return $stmt->execute();
                        
        }catch(PDOException $e){
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
            exit();
        }
    }
    
    function actualizaRelacion($conexion, $oid_u, $oid_r, $tipoRelacion){
        try{
            $stmt = $conexion->prepare("UPDATE RELACIONES SET oid_r=:oid_r, tipo_relacion=:tipoRelacion
             WHERE oid_u=:oid_u");
            $stmt->bindParam(':oid_u',$oid_u);
            $stmt->bindParam(':oid_r',$oid_r);
            $stmt->bindParam(':tipoRelacion',$tipoRelacion);
            return $stmt->execute();
                        
        }catch(PDOException $e){
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
            exit();
        }
    }
    
    function guardaResponsable($conexion, $nombre, $apellidos, $email, $telefono){
        $exito = false;
        try{
            $stmt = $conexion->prepare("CALL crear_responsable(:nombre,:apellidos,:email,:telefono)");
            $stmt->bindParam(':nombre',$nombre);
            $stmt->bindParam(':apellidos',$apellidos);
            $stmt->bindParam(':email',$email);
            $stmt->bindParam(':telefono',$telefono);
            $exito = $stmt->execute();
                        
        }catch(PDOException $e){
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
            exit();
        }
        return $exito;
    }
    
    function actualizaResponsable($conexion, $oid_r, $nombre, $apellidos, $email, $telefono){
        $exito = false;
       try{
            $stmt = $conexion->prepare("UPDATE RESPONSABLES SET nombre=:nombre, apellidos=:apellidos,
            email=:email, telefono=:telefono WHERE oid_r=:oid_r");
            $stmt->bindParam(':oid_r',$oid_r);
            $stmt->bindParam(':nombre',$nombre);
            $stmt->bindParam(':apellidos',$apellidos);
            $stmt->bindParam(':email',$email);
            $stmt->bindParam(':telefono',$telefono);
            $exito = $stmt->execute();
                        
        } catch(PDOException $e){
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
            exit();
        } 
        return $exito;
    }
    
        function existeEmailResponsable($conexion, $email){
        try{
            $stmt = $conexion->prepare("SELECT OID_R FROM RESPONSABLES WHERE EMAIL=:email");
            $stmt->bindParam(':email',$email);
            $stmt->execute();
            $res = $stmt->fetch();
            return $res!=null;
        }catch(PDOException $e){
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
            exit();
        }   
    }
    
    function consultarTotalResponsables($conexion)  {
        try {
            $consulta = "SELECT COUNT(*) AS TOTAL FROM RESPONSABLES";
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
    
    function consultaPaginadaResponsables($conexion,$pagina_seleccionada,$intervalo,$total){
            $select = "SELECT * FROM RESPONSABLES ORDER BY APELLIDOS, NOMBRE";
        return consultaPaginada($conexion,$pagina_seleccionada,$intervalo,$total,$select);
    }  
    
?>