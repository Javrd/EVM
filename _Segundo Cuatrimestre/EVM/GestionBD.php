<?php

function crearConexionBD()
{
	$host="oci:dbname=localhost/XE;charset=UTF8";
	$usuario="evm2";
	$password="evm2";
	$conexion=null;
	
	try{
		$conexion=new PDO($host,$usuario,$password,array(PDO::ATTR_PERSISTENT => true));
    	
     /* Indicar que queremos que lance excepciones cuando ocurra un error*/ 
     $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    	
	}catch(PDOException $e){
		$_SESSION['error']=$e->GetMessage();
		header("Location:error.php");
	}
	return $conexion;
}

function cerrarConexionBD($conexion){
	$conexion=null;
}

?>