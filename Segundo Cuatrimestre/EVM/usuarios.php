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

		<title>Usuarios</title>
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
		
		<nav id="UsuariosNavBar">
			<ul>
				<li>Todos</li>
				<li>Usuarios con prestamos</li>
                <form action="registraUsuario.php" method="post">
				<li><button id = "button_nuevo" name="nuevo">Nuevo</button></li>
				</form>
			</ul>
		</nav>

		<div id="ConsultaUsuarios">
			<?php //TODO Tabla de la consulta (por defecto "Todos") ?>
		</div>
		
		<?php include("footer.html") ?>

	</body>
</html>