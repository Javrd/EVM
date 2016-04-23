<?php

    function listaUsuarios($conexion){
        try{
            $total_query = "SELECT * FROM USUARIOS ORDER BY apellidos";
            $stmt = $conexion->query( $total_query );
            return $stmt;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    
    function guardaUsuarios($conexion, $nombre, $apellidos, $fecha, $direccion, $email, $telefono, $derechos){
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
            echo $e->getMessage();
        }
    }
        
    function consultarPaginaUsuarios($conexion,$pagina_seleccionada,$intervalo,$total,$constulta){
        try {
            $first = ($pagina_seleccionada - 1) * $intervalo + 1;
            $last = $pagina_seleccionada * $intervalo;
            if ($last > $total){
                $last = $total;
            }
            if ($constulta == 'Usuarios con prestamos')
                $select = "SELECT NOMBRE, APELLIDOS FROM PRESTAMOS NATURAL JOIN MATRICULAS NATURAL JOIN USUARIOS WHERE MATRICULAS.FECHA_MATRICULACION>(SYSDATE - 365) ORDER BY APELLIDOS, NOMBRE";
            else
                $select = "SELECT * FROM USUARIOS ORDER BY APELLIDOS, NOMBRE";
            
            $paged_query = "SELECT * FROM ("
                                ." SELECT ROWNUM RNUM, AUX.* FROM ("
                                    .$select
                                    // 
                                    // ."MATRICULAS.CODIGO, MATRICULAS.FECHA_MATRICULACION FROM USUARIOS, RELACIONES, RESPONSABLES, MATRICULAS"
                                    // ." WHERE (USUARIOS.OID_U = MATRICULAS.OID_U"
                                    // ." AND USUARIOS.OID_U = RELACIONES.OID_U"
                                    // ." AND RELACIONES.OID_R = RESPONSABLES.OID_R)"
                                    // ." ORDER BY APELLIDOS, NOMBRE"
                                ." ) AUX WHERE ROWNUM <= :last"
                            ." ) WHERE RNUM >= :first";
            $stmt = $conexion->prepare( $paged_query );
            $stmt->bindParam( ':first', $first );
            $stmt->bindParam( ':last', $last );
            $stmt->execute();
            return $stmt;
        }
        catch ( PDOException $e ) {
            echo "Error : $e";
    }
    return $stmt;
        
        
    }  
    
    function consultarTotalUsuarios($conexion)  {
        $consulta = "SELECT COUNT(*) AS TOTAL FROM USUARIOS";
        $stmt = $conexion->query($consulta);
        $result = $stmt->fetch();
        $total = $result['TOTAL' ];
        return (int)$total;
    }
    
    function consultarUsuariosConPrestamos($conexion)  {
        $consulta = "SELECT COUNT(*) AS TOTAL FROM PRESTAMOS NATURAL JOIN MATRICULAS NATURAL JOIN USUARIOS WHERE MATRICULAS.FECHA_MATRICULACION>(SYSDATE - 365) ORDER BY APELLIDOS, NOMBRE";
        $stmt = $conexion->query($consulta);
        $result = $stmt->fetch();
        $total = $result['TOTAL' ];
        return (int)$total;
    }
?>