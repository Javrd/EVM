<?php
session_start();
    if(!isset($_SESSION["login"])){
        header("Location: ../index.php");
    }
		if(isset($_REQUEST['nuevo'])){
			unset($_SESSION['registroPrestamo']);
		}
    	if (!isset($_SESSION['registroPrestamo'])){
    		$registroPrestamo["instrumento"] = "-1";
			$registroPrestamo['usuario'] = "-1";
    		$_SESSION["registroPrestamo"] = $registroPrestamo;
    	} else {
    		$registroPrestamo = $_SESSION['registroPrestamo'];
    	}
	
	// Gestion de errores.
	if (isset($_SESSION['errores'])){	
		$errores = $_SESSION['errores'];
		unset($_SESSION['errores']);		
	}	
	
    require_once ("../gestion/gestionarPrestamo.php");
	require_once("../gestion/gestionBD.php");
	
	$conexion = crearConexionBD();
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<?php
		
			echo "<title>Nuevo préstamo</title>";
		
		 ?>

		<meta name="viewport" content="width=device-width; initial-scale=1.0">
        <script src="../js/prestamosJS.js"></script>
        <script src="../js/jquery-1.12.3.min.js"></script>
        <link rel="shortcut icon" href="../img/favicon.png">
        <link rel="apple-touch-icon" href="../img/favicon.png">
        <link rel="stylesheet" type="text/css" href="../evm.css">
        
	</head>
	
	<body>
        <div id="container">
		
    		<?php include('../header.html') ?>
    		
    		<div id="content">
    		   <div id="formulario">
    	       <form onsubmit="return validarPrestamos()" action="../tratamientos/tratamientoPrestamos.php" method="post">
    	  				
    	  				<div id="div_instrumento" class="lineaFormulario">
                        <label id="label_instrumento" for="select_instrumento">Instrumento:</label>
                    	<select id="select_instrumento" <?php if(isset($errores["instrumento"])) echo 'class="error"'?> name="instrumento" >
                    	    <option value="-1" <?php if ("-1" == $registroPrestamo['instrumento'] ) echo "selected='selected'" ?>>--Instrumento--</option>
        	              	<?php
        	              	$instrumentos = listaInstrumentosActivos($conexion);
        	              	foreach ($instrumentos as $instrumento) { 
        						echo "<option value='".$instrumento['OID_I']."' ";
        						if ($instrumento['OID_I'] == $registroPrestamo['instrumento'] ) echo "selected='selected'";
        						echo ">";
        						echo $instrumento['NOMBRE']."</option>";
        				  	}
        					?>
                      	</select>
                      	<span id="errorPrestamosInstrumento" class="error"><?php if(isset($errores["instrumento"])) echo $errores["instrumento"]?></span>
                    	</div>
                   	                    
                    	<div id="div_usuario" class="lineaFormulario">
                        <label id="label_usuario" for="select_usuario">Usuario:</label>
                    	<select id="select_usuario" <?php if(isset($errores["usuario"])) echo 'class="error"'?> name="usuario" >
                    	    <option value="-1" <?php if ("-1" == $registroPrestamo['usuario'] ) echo "selected='selected'" ?>>--Usuario--</option>
        	              	<?php
        	              	$usuarios = listaUsuariosActivos($conexion);
        	              	foreach ($usuarios as $usuario) { 
        						echo "<option value='".$usuario['OID_M']."' ";
        						if ($usuario['OID_M'] == $registroPrestamo['usuario'] ) echo "selected='selected'";
        						echo ">";
        						echo $usuario['NOMBRE']." ".$usuario['APELLIDOS']."</option>";
        				  	}
        					?>
                      	</select>
                      	<span id="errorPrestamosUsuario" class="error"><?php if(isset($errores["usuario"])) echo $errores["usuario"]?></span>
                    	</div>
                    <div id="div_submit">
                          <button id="button_enviar" class="submit" type="submit">Enviar</button>
                	</div>
        	   </form>
        	   </div>
            </div> <!-- Fin content -->
            
    		<?php    
    		include("../footer.html");
            cerrarConexionBD($conexion); 
            ?>
        </div>
        
	</body>
</html>