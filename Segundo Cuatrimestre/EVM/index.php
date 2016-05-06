<?php
session_start();
    if(isset($_SESSION['login'])){
        Header("Location: inicio.php");
    } else {
            $login["usuario"] = "";
            $login["contrasenia"] = "";
    }
    // Gestion de errores.
    if (isset($_SESSION['errores'])){   
        $errores = $_SESSION['errores'];
        unset($_SESSION['errores']);        
    }
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>Login</title>

		<meta name="viewport" content="width=device-width; initial-scale=1.0">

        <link rel="shortcut icon" href="img/favicon.png">
        <link rel="apple-touch-icon" href="img/favicon.png">
        <link rel="stylesheet" type="text/css" href="evm.css">
        <link rel="Shortcut Icon" href="favicon.png" type="image/x-icon" />          
	</head>

    <body>
        <div id="container">
        
            <?php include('header.html') ?>
            
            <div id="content">
               <div id="login">
               <form action="tratamientos/tratamientoLogin.php" method="post">
                    <div id="titulo">
                        <p class="p_titulo2">
                            Login
                        </p>
                    </div>
                    <span class="error error2"><?php if(isset($errores["login"])) echo $errores["login"]?></span>
                    <div id="div_usuario" class="lineaFormulario">  
                      <input id="input_usuario" class="box <?php if(isset($errores["usuario"])) echo "error"?>" placeholder="Usuario" name="usuario" value="<?php echo $login['usuario'] ?>"  type="text"/>
                      <span class="error error2"><?php if(isset($errores["usuario"])) echo $errores["usuario"]?></span>
                    </div>
        
                    <div id="div_contrasenia" class="lineaFormulario">  
                      <input id="input_contrasenia" class="box <?php if(isset($errores["contrasenia"])) echo "error"?>" placeholder="Contraseña" name="contrasenia" value="<?php echo $login['contrasenia'] ?>" type="password"/>
                      <span class="error error2"><?php if(isset($errores["contrasenia"])) echo $errores["contrasenia"]?></span>
                    </div>
                    <div id="div_submit">
                          <button name="login" class="botonLogin" type="submit">Enviar</button>
                    </div>
               </form>
               </div>
            </div> <!-- Fin content -->
            
            <?php    
            include("footer.html");
            ?>
        </div>
        
    </body>
</html>