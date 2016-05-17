<?php
    session_start();
    if(!isset($_SESSION["login"])){
        header("Location: ../index.php");
    }
    require_once ("../gestion/gestionarAsignaturas.php");
    require_once("../gestion/gestionBD.php");
    $conexion = crearConexionBD();
    
    /* Recuperacion de sesion de las variables que no se hayan pasado como get */
    
    if(isset($_SESSION['asignaturas'])){
        $asignaturas = $_SESSION["asignaturas"];
        $page_num = $asignaturas["page_num"];
        $page_size = $asignaturas["page_size"];
        unset($_SESSION["asignaturas"]);
    } else {
        $page_num = 1;
        $page_size = 10;
    }

    /* Gets de formularios de paginación */
    
    if ( isset($_GET["page_num"]) && isset($_GET["page_size"])){
        $page_num = (int)$_GET["page_num"];
        $page_size = (int)$_GET["page_size"];
        
    } else if (isset($_GET["page_size"])){
        $page_size = (int)$_GET["page_size"];
        
    }

    /* Definicion y comprobacion de variables de paginacion */

    if ( $page_size < 1 ) 
        $page_size = 10;
    
    $total = consultarTotalAsignaturas($conexion);
    $total_pages = ( $total / $page_size );
    
    if ( $total % $page_size > 0 ) // resto de la división
        $total_pages++;
    
    if ( $page_num < 1 ) 
        $page_num = 1;
    else if ( $page_num > $total_pages )
        $page_num = (int)$total_pages;
    
    $asignaturas["page_num"] = $page_num;
    $asignaturas["page_size"] = $page_size;
    $_SESSION["asignaturas"] = $asignaturas;
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>Asignaturas</title>
		
		<meta name="viewport" content="width=device-width; initial-scale=1.0">

        <link rel="shortcut icon" href="../img/favicon.png">
        <link rel="apple-touch-icon" href="../img/favicon.png">
        <link rel="stylesheet" type="text/css" href="../evm.css">
	</head>

	<body class="vistaAsignaturas">
		  <div id="container">
		      
    		<?php include("../header.html") ?>
    		
    		<div id="content">
        		<nav>
        			<ul class="menu">
        				<form  method="post" action="../registros/registraAsignatura.php">
        				<li><button id = "button_nuevo" name="nuevo">Nuevo</button></li>    
        				</form>
        			</ul>
        		</nav>
                <div id="Paginacion">
                <form method="get" action="asignaturas.php">
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
        		<div id="ConsultaAsignaturas" class="consultas">
        		    <table>
        		        <th>
        		            <td>Nombre</td>
                            <td>Editar</td>
        		        </th>
        			<?php 
                        $filas = consultaPaginadaAsignaturas($conexion,$page_num,$page_size,$total);
                        foreach ($filas as $asignatura) {
                            
                    ?>
                    
                        <tr>
                            <td><?php echo $asignatura['NOMBRE']?></td>
                            <div class=<?php echo $row ?>>
                                <div class="col6"><span><?php echo $asignatura['NOMBRE']?></span></div>
                                <div class="col6">                                        
                                    <form  method="post" action="../registros/registraAsignatura.php">
                                        <input type="hidden" name="oid_a" value="<?php echo $asignatura['OID_A']?>"/>
                                        <input type="hidden" name="nombre" value="<?php echo $asignatura['NOMBRE']?>"/>
                                        <button><img src="../img/Edit_Notepad_Icon.png" class="notepadIcon"/></button>
                                    </form>
                                </div>
                            </div>
                        </tr>
                    <?php  
                        } 
                    ?>
                    </table>
        		</div>
    		
    		<?php 
            	include("../footer.html");
                cerrarConexionBD($conexion);  
            ?>
            
        </div>

	</body>
</html>