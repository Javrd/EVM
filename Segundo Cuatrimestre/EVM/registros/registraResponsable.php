<?php
session_start();
    if(!isset($_SESSION["login"])){
        header("Location: ../index.php");
    }
    if(isset($_POST['nuevo'])){
        unset($_SESSION['registroResponsable']);
    }
    if(isset($_POST['oid_r'])){
            $registroResponsable["oid_r"] = $_POST['oid_r'];
            $registroResponsable["nombre"] = $_POST['nombre'];
            $registroResponsable["apellidos"] = $_POST['apellidos'];
            $registroResponsable["email"] = $_POST['email'];
            $registroResponsable["telefono"] = $_POST['telefono'];
            $_SESSION["registroResponsable"] = $registroResponsable;
    } else{
    	if (!isset($_SESSION['registroResponsable'])){
    		$registroResponsable["nombre"] = "";
    		$registroResponsable["apellidos"] = "";
    		$registroResponsable["email"] = "";
    		$registroResponsable["telefono"] = "";
    		$_SESSION["registroResponsable"] = $registroResponsable;
    	} else {
    		$registroResponsable = $_SESSION['registroResponsable'];
    	}
    }
	
	// Gestion de errores.
	if (isset($_SESSION['errores'])){	
		$errores = $_SESSION['errores'];
		unset($_SESSION['errores']);		
	}	
	
    require_once ("../gestion/gestionarResponsable.php");
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
        if (isset($registroUsuario["oid_r"])){
            echo "<title>Modificar responsable</title>";    
        } else {
            echo "<title>Nuevo responsable</title>";
        }
         ?>

		<meta name="viewport" content="width=device-width; initial-scale=1.0">
        <script src="../js/usuarios.js"></script>
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
    	       <form action="../tratamientos/tratamientoResponsables.php" method="post" onsubmit="return validarResponsables()">
    	  
                    <div id="div_nombre" class="lineaFormulario">  
                      <label id="label_nombre" for="input_nombre">Nombre:</label>
                      <input id="input_nombre" maxlength="50" class="box <?php if(isset($errores["nombre"])) echo "error"?>" name="nombre" value="<?php echo $registroResponsable['nombre'] ?>" type="text"/>
                      <span id="error_nombre" class="error"><?php if(isset($errores["nombre"])) echo $errores["nombre"]?></span>
                    </div>
        
                    <div id="div_apellidos" class="lineaFormulario">  
                      <label id="label_apellidos" for="input_apellidos">Apellidos:</label>
                      <input id="input_apellidos" maxlength="50" class="box <?php if(isset($errores["apellidos"])) echo "error"?>" name="apellidos" value="<?php echo $registroResponsable['apellidos'] ?>" type="text"/>
                      <span id="error_apellidos" class="error"><?php if(isset($errores["apellidos"])) echo $errores["apellidos"]?></span>
                    </div>
                    <div id="div_email" class="lineaFormulario">  
                      	<label id="label_email" for="input_email">Email:</label>
                      	<input id="input_email" maxlength="60" class="box <?php if(isset($errores["email"])) echo "error"?>" name="email" value="<?php echo $registroResponsable['email'] ?>" type="email"/>
                        <span id="error_email" class="error"><?php if(isset($errores["email"])) echo $errores["email"]?></span>
                    </div>
                    <div id="div_telefono" class="lineaFormulario">  
                      	<label id="label_telefono" for="input_telefono">Teléfono:</label>
                      	<input id="input_telefono" class="box <?php if(isset($errores["telefono"])) echo "error"?>" name="telefono" value="<?php echo $registroResponsable['telefono'] ?>" type="tel" pattern="\d{9}"/>
                        <span id="error_telefono" class="error"><?php if(isset($errores["telefono"])) echo $errores["telefono"]?></span>
                    </div>
                    <?php if(isset($registroResponsable["oid_r"])) { ?>
                    <input type="hidden" name="oid_r" value="<?php echo $registroResponsable["oid_r"] ?>"/>
                    <?php } ?>
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