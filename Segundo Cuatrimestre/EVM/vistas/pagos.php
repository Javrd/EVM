<?php
    session_start();
    if(!isset($_SESSION["login"])){
        header("Location: ../index.php");
    }
    
    require_once ("../gestion/gestionarPago.php");
    require_once("../gestion/gestionBD.php");
    $conexion = crearConexionBD();
    
    /* Recuperacion de sesion de las variables que no se hayan pasado como get */
    
    if(isset($_SESSION['pagos'])){
        $pagos = $_SESSION["pagos"];
        $page_num = $pagos["page_num"];
        $page_size = $pagos["page_size"];
        unset($_SESSION["pagos"]);
    } else {
        $page_num = 1;
        $page_size   = 10;
    }

    /* Gets de formularios de paginación y tipo de consulta */
    
    if ( isset($_GET["page_num"]) && isset($_GET["page_size"])){
        $page_num = (int)$_GET["page_num"];
        $page_size = (int)$_GET["page_size"];
        
    } else if (isset($_GET["page_size"])){
        $page_size = (int)$_GET["page_size"];
        
    }

    /* Definicion y comprobacion de variables de paginacion */

    if ( $page_size < 1 ) 
        $page_size = 10;
    
    $total = consultarTotalPagos($conexion);  // Cuenta de total de pagos
    
    $total_pages = ( $total / $page_size );
    
    if ( $total % $page_size > 0 ) // resto de la división
        $total_pages++;
    
    if ( $page_num < 1 ) 
        $page_num = 1;
    else if ( $page_num > $total_pages )
        $page_num = (int)$total_pages;  
    
    $pagos["page_num"] = $page_num;
    $pagos["page_size"] = $page_size;
    $_SESSION["pagos"] = $pagos;
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>Pagos</title>
		
		<meta name="viewport" content="width=device-width; initial-scale=1.0">

        <link rel="shortcut icon" href="../img/favicon.png">
        <link rel="apple-touch-icon" href="../img/favicon.png">
        <link rel="stylesheet" type="text/css" href="../evm.css">
	</head>

	<body class="vistaPagos">
		  <div id="container">
		      
    		<?php include("../header.html") ?>
    		
    		<div id="content">
        		<nav>
        			<ul class="menu">
        				<form  method="post" action="../registros/registraPago.php">
        				<li><button id = "button_nuevo" name="nuevo">Nuevo</button></li>    
        				</form> 
        			</ul>
        		</nav>
                <div id="Paginacion">
                <form method="get" action="pagos.php">
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
        		<div id="ConsultaPagos" class="consultas">
        		    <div class="titlerow">
        		    	<div class="col6">Nombre</div>
                        <div class="col15">Apellidos</div>
                        <div class="col6">Cantidad</div>
                        <div class="col6">Concepto</div>
                        <div class="col6">Fecha</div>
                        <div class="col6">Estado</div>                        
                        <div class="col6">Registrar pago</div>
                        
                    </div>
        			<?php 
                        $filas = consultaPaginadaPagos($conexion,$page_num,$page_size,$total);
                        $i = 0;
                        foreach ($filas as $pago) {
                            
                            $row = $i%2?'oddrow':'evenrow';
                            $fecha = DateTime::createFromFormat("d/m/y",$pago['FECHA_PAGO']);
                    ?>
                            <div class=<?php echo $row ?>>
                            	
                                <div class="col6"><span><?php echo $pago['NOMBRE']?></span></div>
                                <div class="col15"><span><?php echo $pago['APELLIDOS']?></span></div>
                                <div class="col6"><span><?php echo $pago['TIPO_FALTA']?></span></div>
                                <div class="col6"><span><?php echo $fecha->format("d/m/y")?></span></div>
                                <div class="col6">
                    <?php   
                            if($pago['JUSTIFICADA']==1){
                                echo'<img src="../img/1024px-Green_tick_pointed.png" style="width:20px;height:20px;"/>';
                            }
                    ?>
                                </div>
                                <div class="col6">                                        
                                    <form  method="post" action="../tratamientos/tratamientoPagos.php">
                                        <input type="hidden" name="oid_f" value="<?php echo $pago['OID_F']?>"/>  
                                        <button <?php if($pago['JUSTIFICADA']==1){ echo "hidden='hidden'";} ?> name="actu"><img src="../img/icono_m_signdoc.png" class="botonJustificar"/></button>
                                    </form>
                                </div>
                                <div class="col6">                                        
                                    <form  method="post" action="../tratamientos/tratamientoPagos.php">
                                        <input type="hidden" name="oid_f" value="<?php echo $pago['OID_F']?>"/>  
                                        <button name="borrar"><img src="../img/botonEliminar.png" class="botonJustificar"/></button>
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