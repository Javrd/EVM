<?php
    session_start();
    if(!isset($_SESSION["login"])){
        header("Location: ../index.php");
    }
    try{
        if (!file_exists('../gestion/gestionarResponsable.php' ))
          throw new Exception ('No existe el fichero gestionarResponsable.php');
        else
            require_once ("../gestion/gestionarResponsable.php");
    }
    catch ( Exception $e ) {
        $_SESSION['error']=$e->GetMessage();
        header("Location:../error.php");
    }
    require_once("../gestion/gestionBD.php");
    $conexion = crearConexionBD();
    
    /* Recuperacion de sesion de las variables que no se hayan pasado como get */
    
    if(isset($_SESSION['responsables'])){
        $responsables = $_SESSION["responsables"];
        $page_num = $responsables["page_num"];
        $page_size = $responsables["page_size"];
        unset($_SESSION["responsables"]);
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
    
    $total = consultarTotalResponsables($conexion);
    $total_pages = ( $total / $page_size );
    
    if ( $total % $page_size > 0 ) // resto de la división
        $total_pages++;
    
    if ( $page_num < 1 ) 
        $page_num = 1;
    else if ( $page_num > $total_pages )
        $page_num = (int)$total_pages;  
    
    $responsables["page_num"] = $page_num;
    $responsables["page_size"] = $page_size;
    $_SESSION["responsables"] = $responsables;
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>Responsables</title>
		
		<meta name="viewport" content="width=device-width; initial-scale=1.0">

        <link rel="shortcut icon" href="../img/favicon.png">
        <link rel="apple-touch-icon" href="../img/favicon.png">
        <link rel="stylesheet" type="text/css" href="../evm.css">
	</head>

	<body class="vistaResponsables">
		  <div id="container">
		      
    		<?php include("../header.html") ?>
    		
    		<div id="content">
        		<nav>
        			<ul class="menu">
        				<form  method="post" action="../registros/registraResponsable.php">
        				<li><button id = "button_nuevo" name="nuevo">Nuevo</button></li>    
        				</form>
        			</ul>
        		</nav>
                <div id="Paginacion">
                <form method="get" action="responsables.php">
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
        		<div id="ConsultaResponsables" class="consultas">
        		    <div class="titlerow">
                        <div class="col6">Nombre</div>
                        <div class="col15">Apellidos</div>
                        <div class="col12">Email</div>
                        <div class="col6">Telefono</div>
                        <div class="col6">Editar</div>
                    </div>
        			<?php 
                        $filas = consultaPaginadaResponsables($conexion,$page_num,$page_size,$total);
                        $i = 0;
                        foreach ($filas as $responsable) {
                            
                            $row = $i%2?'oddrow':'evenrow';
                    ?>
                            <div class=<?php echo $row ?>>
                                <div class="col6"><span><?php echo $responsable['NOMBRE']?></span></div>
                                <div class="col15"><span><?php echo $responsable['APELLIDOS']?></span></div>
                                <div class="col12"><span><?php if($responsable['EMAIL']!=null) echo $responsable['EMAIL']; else echo "-";?></span></div>
                                <div class="col6"><span><?php echo $responsable['TELEFONO']?></span></div>
                                <div class="col6">                                        
                                    <form  method="post" action="../registros/registraResponsable.php">
                                        <input type="hidden" name="oid_r" value="<?php echo $responsable['OID_R']?>"/>
                                        <input type="hidden" name="nombre" value="<?php echo $responsable['NOMBRE']?>"/>
                                        <input type="hidden" name="apellidos" value="<?php echo $responsable['APELLIDOS']?>"/>
                                        <input type="hidden" name="email" value="<?php echo $responsable['EMAIL']?>"/>
                                        <input type="hidden" name="telefono" value="<?php echo $responsable['TELEFONO']?>"/>        
                                        <button><img src="../img/Edit_Notepad_Icon.png" class="notepadIcon"/></button>
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