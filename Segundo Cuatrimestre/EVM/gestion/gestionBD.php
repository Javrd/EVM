<?php

function crearConexionBD()
{
	$host="oci:dbname=localhost/XE;charset=UTF8";
	$usuario="evm";
	$password="evm";
	$conexion=null;
	
	try{
		$conexion=new PDO($host,$usuario,$password,array(PDO::ATTR_PERSISTENT => true));
    	
     /* Indicar que queremos que lance excepciones cuando ocurra un error*/ 
     $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    	
	}catch(PDOException $e){
		$_SESSION['error']=$e->GetMessage();
		header("Location:../error.php");
        exit();
	}
	return $conexion;
}

function cerrarConexionBD($conexion){
	$conexion=null;
}

function consultaPaginada($conexion,$pagina_seleccionada,$intervalo,$total,$query){
    try {
        $first = ($pagina_seleccionada - 1) * $intervalo + 1;
        $last = $pagina_seleccionada * $intervalo;
        if ($last > $total){
            $last = $total;
        }
        $paged_query = "SELECT * FROM ("
                            ." SELECT ROWNUM RNUM, AUX.* FROM ("
                                .$query
                            ." ) AUX WHERE ROWNUM <= :last"
                        ." ) WHERE RNUM >= :first";
        $stmt = $conexion->prepare( $paged_query );
        $stmt->bindParam( ':first', $first );
        $stmt->bindParam( ':last', $last );
        $stmt->execute();
        return $stmt;
    }
    catch ( PDOException $e ) {
        $_SESSION['error']=$e->GetMessage();
        header("Location:../error.php");
        exit();
    }
} 
?>