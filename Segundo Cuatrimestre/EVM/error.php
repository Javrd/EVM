<?php 
	session_start();
	if(isset($_SESSION["error"])){
	$error = $_SESSION["error"];
	unset($_SESSION["error"]);
	}else{
		Header("Location: index.php");
	}
		
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Error</title>
		<link rel="shortcut icon" href="img/favicon.png">
        <link rel="apple-touch-icon" href="img/favicon.png">		
        <link rel="stylesheet" type="text/css" href="evm.css">  
	</head>
	<body>	
	<div id="container">
	<?php include("header.html") ?>
	<div id="content">
	<div class="p_titulo">Error</div>
	<div class="p_descripcion">Se ha producido el siguiente error:</div> 
	<div class="error"><?php echo $error ?></div>	
	<div class="p_descripcion">Pulse <a href="index.php">aquí</a> para volver a la página principal.</div>
	</div>
	<?php include("footer.html") ?>
	</div>
	</body>
</html>