<?php
    function listaResponsables($conexion){
    	try{
		$total_query = "SELECT * FROM RESPONSABLES";
		$stmt = $conexion->query( $total_query );
		return $stmt;
	}catch(PDOException $e){
		echo $e->getMessage();
	}
    }
?>