<?php
    session_start();
    if(!isset($_SESSION["login"])){
        header("Location: ../index.php");
    }
    
    require_once ("../gestion/gestionarInstrumento.php");
    require_once("../gestion/gestionBD.php");
    $conexion = crearConexionBD();
    
    /* Recuperacion de sesion de las variables que no se hayan pasado como get */
    
    if(isset($_SESSION['instrumentos'])){
        $instrumentos = $_SESSION["instrumentos"];
        $page_num = $instrumentos["page_num"];
        $page_size = $instrumentos["page_size"];
        $consulta = $instrumentos["consulta"];
        unset($_SESSION["instrumentos"]);
    } else {
        $page_num = 1;
        $page_size   = 10;
        $consulta = "todos";
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
    
    if ($consulta == "instrumentosLibres")
        $total = consultarInstrumentosLibres($conexion); // Cuenta el total de usuarios para consulta de usuarios con prestamos
    else 
        $total = consultarTotalInstrumentos($conexion);  // Cuenta de total de usuarios por defecto. Por defecto, consulta = Todos
    $total_pages = ( $total / $page_size );
    
    if ( $total % $page_size > 0 ) // resto de la división
        $total_pages++;
    
    if ( $page_num < 1 ) 
        $page_num = 1;
    else if ( $page_num > $total_pages )
        $page_num = (int)$total_pages;  
    
    $instrumentos["page_num"] = $page_num;
    $instrumentos["page_size"] = $page_size;
    $instrumentos["consulta"] = $consulta;
    $_SESSION["instrumentos"] = $instrumentos;
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>Instrumentos</title>
		
		<meta name="viewport" content="width=device-width; initial-scale=1.0">

        <link rel="shortcut icon" href="../img/favicon.png">
        <link rel="apple-touch-icon" href="../img/favicon.png">
        <link rel="stylesheet" type="text/css" href="../evm.css">
	</head>

	<body class="vista">
		  <div id="container">
		      
    		<?php include("../header.html") ?>
    		
    		<div id="content">
        		<nav>
        			<ul class="menu">
                        <form method="get" action="instrumentos.php">
                        <li><button id = "button_nuevo" name="consulta" value="instrumentosLibres">Instrumentos Libres</button></li>    
                        <li><button id = "button_nuevo" name="consulta" value="todos">Todos</button></li>   
        				</form>
        				<form  method="post" action="../registros/registraInstrumento.php">
        				<li><button id = "button_nuevo" name="nuevo">Nuevo</button></li>    
        				</form>
        			</ul>
        		</nav>
                <div id="Paginacion">
                    <form method="get" action="instrumentos.php">
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
        		<div id="ConsultaInstrumentos" class="consultas">
        		    <div class="titlerow">
                        <div class="col6">Tipo</div>
                        <div class="col15">Nombre</div>
                        <div class="col6">Estado Instrumento</div>
                        <div class="col6">Libre</div>
                        <div class="col6">Devolver</div>
                        <div class="col6">Editar</div>
                    </div>
        			<?php 
                        $filas = consultaPaginadaInstrumentos($conexion,$page_num,$page_size,$total,$consulta);
                        $i = 0;
                        foreach ($filas as $instrumento) {
                            
                            $row = $i%2?'oddrow':'evenrow';
                    ?>
                            <div class=<?php echo $row ?>>
                                <div class="col6"><span><?php echo $instrumento['TIPO']?></span></div>
                                <div class="col15"><span><?php echo $instrumento['NOMBRE']?></span></div>
                                <div class="col6"><span><?php echo $instrumento['ESTADO_INSTRUMENTO']?></span></div>
                                <div class="col6">
                    <?php   
                            if($instrumento['LIBRE']==1){
                                echo'<img src="../img/1024px-Green_tick_pointed.png" style="width:20px;height:20px;"/>';
                            }
                    ?>
                                </div>
                                <div class="col6"> 

                                    <form  method="post" action="../tratamientos/tratamientoInstrumentos.php">

                                        <input type="hidden" name="oid_i" value="<?php echo $instrumento['OID_I']?>"></input>

                                        <?php   
                                        if($instrumento['LIBRE']==0){
                                             echo "<button name='devolver'><img src='../img/botonDevolver.png' style='width:20px;height:20px;'/></button>";
                                        }
                                        ?>                                
                                    </form>
                                </div>

                                <div class="col6">                                        
                                    <form  method="post" action="../registros/registraInstrumento.php">
                                        <input type="hidden" name="oid_i" value="<?php echo $instrumento['OID_I']?>"/>
                                        <input type="hidden" name="nombre" value="<?php echo $instrumento['NOMBRE']?>"/>
                                        <input type="hidden" name="tipo" value="<?php echo $instrumento['TIPO']?>"/>
                                        <input type="hidden" name="libre" value="<?php echo $instrumento['LIBRE']?>"/>
                                        <input type="hidden" name="ESTADO_INSTRUMENTO" value="<?php echo $instrumento['ESTADO_INSTRUMENTO']?>"/>
                                        
                                        <button><img src="../img/Edit_Notepad_Icon.png" style="width:20px;height:20px;"/></button>
                                    </form>
                                </div>



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