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
        $consulta = $pagos["consulta"];
        unset($_SESSION["pagos"]);
    } else {
        $page_num = 1;
        $page_size   = 10;
        $consulta = "";
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
    
    
    if ($consulta != "")
        $total = consultarPagosDeUsuarios($conexion,$consulta);
    else 
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
    $pagos["consulta"] = $consulta;
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
        		    <form  method="get" action="pagos.php">
                      <button class="toLeft navButton" name="consulta" value="" placeholder="Buscador de usuarios">Todos</button>
        		      <input class="toLeft buscador" type="text" name="consulta" placeholder="Buscador de usuarios"/>
        		    </form>
        		</nav>
                <div id="Paginacion">
                <form method="get" action="pagos.php">
                <?php
                    $filas = consultaPaginadaPagos($conexion,$page_num,$page_size,$total,$consulta);
                    if ($total!=0){
                        if ($total_pages>10){
                            if($page_num>3){
                                echo "<button id='Primera' name='page_num' type='submit' class='pagina' value='1'>Primera</button>...";
                            }
                            if($page_num>2 && $page_num<$total_pages-2){
                                $inicio = $page_num-2;
                                $fin = $page_num+2;
                            } else if ($page_num>2){
                                $inicio = (int) $total_pages-4;
                                $fin = (int) $total_pages;
                            } else {
                                $inicio = 1;
                                $fin = 5;
                            }
                        } else {
                            $inicio = 1;
                            $fin = $total_pages;
                        }
                        for( $page = $inicio; $page <= $fin; $page++ ) {
                            if ( $page == $page_num ) { // página actual
                                echo "<button id='".$page."' name='page_num' type='submit' class='seleccionada' value='".$page."' disabled='disabled'>".$page."</button>";
                            } else { // resto de páginas
                                echo "<button id='".$page."' name='page_num' type='submit' class='pagina' value='".$page."'>".$page."</button>";
                            }
                        }
                        if ($total_pages>10 && $page_num<$total_pages-3){
                            echo "...<button id='ultima' name='page_num' type='submit' class='pagina' value='".(int) $total_pages."'>Última</button>";
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
                            $i = 0;
                            foreach ($filas as $pago) {
                                $row = $i%2?'oddrow':'evenrow';
                                if ($pago['FECHA_PAGO']!=null)
                                    $fecha = DateTime::createFromFormat("d/m/y",$pago['FECHA_PAGO'])->format("d/m/y");
                                else
                                    $fecha = "-";
                    ?>
                                <div class=<?php echo $row ?>>
                                	
                                    <div class="col6"><span><?php echo $pago['NOMBRE']?></span></div>
                                    <div class="col15"><span><?php echo $pago['APELLIDOS']?></span></div>
                                    <div class="col6"><span><?php echo $pago['CANTIDAD']?></span></div>
                                    <div class="col6"><span><?php echo $pago['CONCEPTO']?></span></div>
                                    <div class="col6"><span><?php echo $fecha?></span></div>
                                    <div class="col6"><span><?php echo $pago['ESTADO']?></span></div>
                        
                                    <div class="col6">
                                        <form  method="post" action="../exito/exitoPago.php">
                                            <input type="hidden" name="oid_pa" value="<?php echo $pago['OID_PA']?>"/>  
                                            <button <?php if($pago['ESTADO']=="Pagado"){ echo "hidden='hidden'";} ?> name="actu"><img src="../img/icono_m_signdoc.png" class="botonJustificar"/></button>
                                        </form>
                                    </div>
                                </div>
                    <?php  
                                $i++;
                            } 
                        } else {
                            echo "<span class='noResults'>Sin resultados</span>";
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