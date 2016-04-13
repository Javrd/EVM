<?php
	//TODO Datos de sesion
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>Inicio</title>
		<meta name="description" content="">
		<meta name="author" content="Javi">

		<meta name="viewport" content="width=device-width; initial-scale=1.0">

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico">
		<link rel="apple-touch-icon" href="/apple-touch-icon.png">
        <link rel="stylesheet" type="text/css" href="evm.css">
	</head>

	<body>
		
		<?php include("header.html") ?>
		
		<div id="div_inicio">
			<ul class="menu">
				<li class="button"><a href="usuarios.php">Usuarios</a></li>
				<li class="button"><a href="matriculas.php">Matriculas</a</li>
				<li class="button"><a href="prestamos.php">Prestamos</a</li>
				<li class="button"><a href="faltas.php">Faltas</a</li>
				<li class="button"><a href="pagos.php">Pagos</a</li>
				<li class="button"><a href="asignaturas.php">Asignaturas</a></li>
			</ul>
		</div>
        
		<!-- <?php include("footer.html") ?> -->
	</body>
</html>