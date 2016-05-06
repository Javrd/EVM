<?php

    require_once("gestionBD.php");
    
    function listaUsuarios($conexion){
        try{
            $total_query = "SELECT * FROM USUARIOS ORDER BY apellidos";
            $stmt = $conexion->query( $total_query );
            return $stmt;
        }catch(PDOException $e){
        $_SESSION['error']=$e->GetMessage();
        header("Location:../error.php");
        }
    }
    
    function existeEmail($conexion, $email){
        try{
            $stmt = $conexion->prepare("SELECT OID_U FROM USUARIOS WHERE EMAIL=:email");
            $stmt->bindParam(':email',$email);
            $stmt->execute();
            $res = $stmt->fetch();
            return $res!=null;
        }catch(PDOException $e){
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
        }   
    }
    
    function guardaUsuario($conexion, $nombre, $apellidos, $fecha, $direccion, $email, $telefono, $derechos){
        try{
            $stmt = $conexion->prepare("INSERT INTO USUARIOS (nombre,apellidos,fecha_nacimiento,direccion,email,telefono,derechos_imagen)
VALUES (:nombre, :apellidos, TO_DATE(:fecha,'ddmmYYYY'), :direccion, :email, :telefono, :derechos) RETURNING oid_u INTO :oid_u");
            $stmt->bindParam(':nombre',$nombre);
            $stmt->bindParam(':apellidos',$apellidos);
            $stmt->bindParam(':fecha',$fecha);
            $stmt->bindParam(':direccion',$direccion);
            $stmt->bindParam(':email',$email);
            $stmt->bindParam(':telefono',$telefono);
            $stmt->bindParam(':derechos',$derechos);
            $stmt->bindParam(':oid_u',$oid_u, PDO::PARAM_INT, 8);
            $stmt->execute();
            return $oid_u;
                        
        }catch(PDOException $e){
        $_SESSION['error']=$e->GetMessage();
        header("Location:../error.php");
        }
    }
    
    function actualizaUsuario($conexion, $oid_u, $nombre, $apellidos, $fecha, $direccion, $email, $telefono, $derechos){
       try{
            $stmt = $conexion->prepare("UPDATE USUARIOS SET nombre=:nombre, apellidos=:apellidos, fecha_nacimiento=TO_DATE(:fecha,'ddmmYYYY'), direccion=:direccion,
            email=:email, telefono=:telefono, derechos_imagen=:derechos WHERE oid_u=:oid_u");
            $stmt->bindParam(':oid_u',$oid_u);
            $stmt->bindParam(':nombre',$nombre);
            $stmt->bindParam(':apellidos',$apellidos);
            $stmt->bindParam(':fecha',$fecha);
            $stmt->bindParam(':direccion',$direccion);
            $stmt->bindParam(':email',$email);
            $stmt->bindParam(':telefono',$telefono);
            $stmt->bindParam(':derechos',$derechos);
            $stmt->execute();
                        
        } catch(PDOException $e){
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
        } 
    }
        
    function consultaPaginadaUsuarios($conexion,$pagina_seleccionada,$intervalo,$total,$constulta){
        if ($constulta == 'Usuarios con prestamos')
            $select = "SELECT oid_u, nombre, apellidos, fecha_nacimiento, direccion, email, telefono, derechos_imagen FROM PRESTAMOS NATURAL JOIN MATRICULAS NATURAL JOIN USUARIOS WHERE MATRICULAS.FECHA_MATRICULACION>(SYSDATE - 365) ORDER BY APELLIDOS, NOMBRE";
        else
            $select = "SELECT * FROM USUARIOS ORDER BY APELLIDOS, NOMBRE";
        return consultaPaginada($conexion,$pagina_seleccionada,$intervalo,$total,$select);
    }  
    
    function consultarTotalUsuarios($conexion)  {
        try {
            $consulta = "SELECT COUNT(*) AS TOTAL FROM USUARIOS";
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