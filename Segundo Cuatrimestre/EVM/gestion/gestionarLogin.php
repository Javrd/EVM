<?php

    require_once("gestionBD.php");
    
    function compruebaUsuario($conexion, $usuario, $pass){
        try{
            $stmt = $conexion->prepare("SELECT OID_L FROM LOGIN WHERE USUARIO=:usuario AND PASS=:pass");
            $stmt->bindParam(':usuario',$usuario);
            $stmt->bindParam(':pass',$pass);
            $stmt->execute();
            $res = $stmt->fetch();
            return $res!=null;
                        
        }catch(PDOException $e){
            $_SESSION['error']=$e->GetMessage();
            header("Location:../error.php");
            exit();
        }
    }
?>