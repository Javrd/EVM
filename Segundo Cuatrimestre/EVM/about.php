<?php 
	session_start();
		
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Sobre esta página</title>
		<link rel="shortcut icon" href="img/favicon.png">
        <link rel="apple-touch-icon" href="img/favicon.png">		
        <link rel="stylesheet" type="text/css" href="evm.css">  
	</head>
	<body>	
	<div id="container">
	<?php include("header.html") ?>
	<div id="content">
    	<div class="p_titulo">Sobre esta página</div>
        	<p>Esta página esta creada con el objetivo de administrar la asociación Espacio Vida &amp; Música de una manera más ordenada y fácil.</p>
        	<p>Los integrantes que han hecho posible este proyecto son:</p>
            <ul class="ul_circle">
            	<li>Javier Rodríguez Martín </li>
            	<li>Daniel Iglesias Pérez </li>
            	<li>Louis Outin </li>
            	<li>Carlos Muñoz de Souza</li>
            </ul>
        	<div>Pulse <a href="index.php">aquí</a> para volver a la página principal.</div>
        </div>
    	<?php include("footer.html") ?>
	</div>
	</body>
</html>