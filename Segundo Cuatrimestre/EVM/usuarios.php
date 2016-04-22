<?php
    session_start();
    
    require_once ("GestionarUsuario.php");
    require_once("GestionBD.php");
    $conexion = crearConexionBD();
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>Usuarios</title>
		<meta name="description" content="">
		<meta name="author" content="Javi">

		<meta name="viewport" content="width=device-width; initial-scale=1.0">

        <link rel="shortcut icon" href="favicon.png">
        <link rel="apple-touch-icon" href="favicon.png">
        <link rel="stylesheet" type="text/css" href="evm.css">
	</head>

	<body>
		  <div id="container">
		      
    		<?php include("header.html") ?>
    		
    		<div id="content">
        		<div id="UsuariosNavBar">
        			<ul>
        				<li>Todos</li>
        				<li>Usuarios con préstamos</li>
                        <form action="registraUsuario.php" method="post">
        				<li><button id = "button_nuevo" name="nuevo">Nuevo</button></li>
        				</form>
        			</ul>
        		</div>
        
        		<div id="ConsultaUsuarios">
        			<?php //TODO Tabla de la consulta (por defecto "Todos")
                        $usuarios = listaUsuarios($conexion);
                        $i = 0;
                        foreach ($usuarios as $usuario) {
                            $row = $i%2?'oddrow':'evenrow';
                            echo "<div class=$row>"; 
                            echo $usuario['NOMBRE']." ".$usuario['APELLIDOS'];
                            echo '</div>';
                            $i++;
                        } 
                    ?>
        		</div>
    		</div>
    		
    		<?php 
            	include("footer.html");
                cerrarConexionBD($conexion);  
            ?>
            
        </div>

	</body>
</html>