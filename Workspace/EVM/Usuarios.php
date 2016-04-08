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
	</head>

	<body>
		
		<?php include(header.html) ?>
		
		<nav id="UsuariosNavBar">
			<ul>
				<?php //TODO ¿Enlaces, formularios? ?> 
				<li>Todos</li>
				<li>Usuarios con prestamos</li>
				<li><a href="RegistraUsuario.php">Nuevo</a></li>
			</ul>
		</nav>

		<div id="ConsultaUsuarios">
			<?php //TODO Tabla de la consulta (por defecto "Todos") ?>
		</div>

		
		<?php include(footer.html) ?>
		</div>
	</body>
</html>