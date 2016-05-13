<?php
    session_start();
    if(!isset($_SESSION["login"])){
        header("Location: ../index.php");
    }
    
    require_once ("../gestion/gestionarPrestamo.php");
    require_once("../gestion/gestionBD.php");
    $conexion = crearConexionBD();
    
    /* Recuperacion de sesion de las variables que no se hayan pasado como get */
    
    if(isset($_SESSION['prestamos'])){
        $prestamos = $_SESSION["prestamos"];
        $page_num = $prestamos["page_num"];
        $page_size = $prestamos["page_size"];
        $consulta = $prestamos["consulta"];
        unset($_SESSION["prestamos"]);
    } else {
        $page_num = 1;
        $page_size   = 10;
        $consulta = "Todos";
    }

    /* Gets de formularios de paginación y tipo de consulta */
    
    if ( isset($_GET["page_num"]) && isset($_GET["page_size"])){
        $page_num = (int)$_GET["page_num"];
        $page_size = (int)$_GET["page_size"];
        
    } else if (isset($_GET["page_size"])){
        $page_size = (int)$_GET["page_size"];
        
    } else if (isset($_GET["consulta"])){
        $consulta = $_GET["consulta"];
        
    }

    /* Definicion y comprobacion de variables de paginacion */

    if ( $page_size < 1 ) 
        $page_size = 10;
    
    $total = consultarTotalPrestamos($conexion);  // Cuenta de total de prestamos por defecto. Por defecto, consulta = Todos
    
    $total_pages = ( $total / $page_size );
    
    if ( $total % $page_size > 0 ) // resto de la división
        $total_pages++;
    
    if ( $page_num < 1 ) 
        $page_num = 1;
    else if ( $page_num > $total_pages )
        $page_num = (int)$total_pages;  
    
    $prestamos["page_num"] = $page_num;
    $prestamos["page_size"] = $page_size;
    $prestamos["consulta"] = $consulta;
    $_SESSION["prestamos"] = $prestamos;
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>Préstamos</title>
		
		<meta name="viewport" content="width=device-width; initial-scale=1.0">

        <link rel="shortcut icon" href="../img/favicon.png">
        <link rel="apple-touch-icon" href="../img/favicon.png">
        <link rel="stylesheet" type="text/css" href="../evm.css">
	</head>

	<body class="vistaPrestamos">
		  <div id="container">
		      
    		<?php include("../header.html") ?>
    		
    		<div id="content">
        		<nav>
        			<ul class="menu">
        				<form  method="post" action="../registros/registraPrestamo.php">
        				<li><button id = "button_nuevo" name="nuevo">Nuevo</button></li>    
        				</form>
        			</ul>
        		</nav>
                <div id="Paginacion">
                <form method="get" action="prestamos.php">
                <?php

                    for( $page = 1; $page <= $total_pages; $page++ ) {
                        if ( $page == $page_num ) { // página actual
                            echo "<button id='".$page."' name='page_num' type='submit' class='seleccionada' value='".$page."' disabled='disabled'>".$page."</button>";
                        } else { // resto de páginas
                            echo "<button id='".$page."' name='page_num' type='submit' class='pagina' value='".$page."'>".$page."</button>";
                        }
                    }
                ?>
                Número de resultados por página: <input id='input_page_size' name='page_size' type='text' size='10' onchange='submit();' value='<?php echo "$page_size" ?>'/>
             
                </form>
                </div>   
        		<div id="ConsultaPrestamos" class="consultas">
        		    <div class="titlerow">
        		    	<div class="col6">Nombre</div>
                        <div class="col15">Apellidos</div>
                        <div class="col6">Fecha</div>
                        <div class="col6">Instrumento</div>  
                        
                    </div>
        			<?php 
                        $filas = consultaPaginadaPrestamos($conexion,$page_num,$page_size,$total,$consulta);
                        $i = 0;
                        foreach ($filas as $prestamo) {
                            
                            $row = $i%2?'oddrow':'evenrow';
                            $fecha = DateTime::createFromFormat("d/m/y",$prestamo['FECHA_PRESTAMO']);
                    ?>
                            <div class=<?php echo $row ?>>
                            	
                                <div class="col6"><span><?php echo $prestamo['USUARIOSNOMBRE']?></span></div>
                                <div class="col15"><span><?php echo $prestamo['APELLIDOS']?></span></div>
                                <div class="col6"><span><?php echo $fecha->format("d/m/y")?></span></div>
                                <div class="col6"><span><?php echo $prestamo['NOMBRE']?></span></div>
                            </div>
                    <?php  
                            $i++;
                        } 
                    ?>
        		</div>
    		</div>
    		
    		<?php 
            	include("../footer.html");
                cerrarConexionBD($conexion);  
            ?>
            
        </div>

	</body>
</html>