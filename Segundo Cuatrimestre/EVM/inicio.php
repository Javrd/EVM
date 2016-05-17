<?php
    session_start();
    if(!isset($_SESSION["login"])){
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>Inicio</title>

		<meta name="viewport" content="width=device-width; initial-scale=1.0">

        <link rel="shortcut icon" href="img/favicon.png">
        <link rel="apple-touch-icon" href="img/favicon.png">
        <link rel="stylesheet" type="text/css" href="evm.css">
        <link rel="Shortcut Icon" href="favicon.png" type="image/x-icon" />          
	</head>

	<body>
        <div id="container">
            
    		<?php include("header.html") ?>
    		
    		<div id="content" class="menu">
    			<ul id="menuInicio" class ="menu">
                    <li class="button"><a href="vistas/usuarios.php">Usuarios</a></li>
                    <li class="button"><a href="vistas/responsables.php">Responsables</a></li>
    				<li class="button"><a href="vistas/matriculas.php">Matrículas</a></li>
    				<li class="button"><a href="vistas/instrumentos.php">Instrumentos</a></li>
    				<li class="button"><a href="vistas/prestamos.php">Préstamos</a></li>
    				<li class="button"><a href="vistas/faltas.php">Faltas</a></li>
    				<li class="button"><a href="vistas/pagos.php">Pagos</a></li>
    				<li class="button"><a href="vistas/asignaturas.php">Asignaturas</a></li>
    			</ul>
    		</div>
            
    		<?php include("footer.html") ?>
    		
		</div>
	</body>
</html>