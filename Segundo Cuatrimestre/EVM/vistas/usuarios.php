<?php
    session_start();
    
    require_once ("../gestion/gestionarUsuario.php");
    require_once ("../gestion/gestionarResponsable.php");
    require_once("../gestion/gestionBD.php");
    $conexion = crearConexionBD();
    
    /* Recuperacion de sesion de las variables que no se hayan pasado como get */
    
    if(isset($_SESSION['usuarios'])){
        $usuarios = $_SESSION["usuarios"];
        $page_num = $usuarios["page_num"];
        $page_size = $usuarios["page_size"];
        $consulta = $usuarios["consulta"];
        unset($_SESSION["usuarios"]);
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
    
    if ($consulta == "Usuarios con prestamos")
        $total = consultarUsuariosConPrestamos($conexion); // Cuenta el total de usuarios para consulta de usuarios con prestamos
    else 
        $total = consultarTotalUsuarios($conexion);  // Cuenta de total de usuarios por defecto. Por defecto, consulta = Todos
    $total_pages = ( $total / $page_size );
    
    if ( $total % $page_size > 0 ) // resto de la división
        $total_pages++;
    
    if ( $page_num < 1 ) 
        $page_num = 1;
    else if ( $page_num > $total_pages )
        $page_num = (int)$total_pages;  
    
    $usuarios["page_num"] = $page_num;
    $usuarios["page_size"] = $page_size;
    $usuarios["consulta"] = $consulta;
    $_SESSION["usuarios"] = $usuarios;
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>Usuarios</title>
		
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
                        <form method="get" action="usuarios.php">
                        <li><button id = "button_usuarios" name="consulta" value="Todos">Todos</button></li>
        				<li><button id = "button_prestamos" name="consulta"  value="Usuarios con prestamos">Usuarios con préstamos</button></li>
        				</form>
        				<form  method="post" action="../registros/registraUsuario.php">
        				<li><button id = "button_nuevo" name="nuevo">Nuevo</button></li>    
        				</form>
        			</ul>
        		</nav>
                <div id="Paginacion">
                <form method="get" action="usuarios.php">
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
        		<div id="ConsultaUsuarios" class="consultas">
        		    <div class="titlerow">
                        <div class="col6">Nombre</div>
                        <div class="col15">Apellidos</div>
                        <div class="col6">Edad</div>
                        <div class="col12">Direccion</div>
                        <div class="col12">Email</div>
                        <div class="col6">Telefono</div>
                        <div class="col12">Derechos de imagen</div>
                        <div class="col6">Editar</div>
                    </div>
        			<?php 
                        $filas = consultaPaginadaUsuarios($conexion,$page_num,$page_size,$total,$consulta);
                        $i = 0;
                        foreach ($filas as $usuario) {
                            
                            $row = $i%2?'oddrow':'evenrow';
                            $nacimiento = DateTime::createFromFormat("d/m/y",$usuario['FECHA_NACIMIENTO']);
                            $edad = $nacimiento->diff( new DateTime());
                    ?>
                            <div class=<?php echo $row ?>>
                                <div class="col6"><span><?php echo $usuario['NOMBRE']?></span></div>
                                <div class="col15"><span><?php echo $usuario['APELLIDOS']?></span></div>
                                <div class="col6"><span><?php echo $edad->format('%y')?></span></div>
                                <div class="col12"><span><?php echo $usuario['DIRECCION']?></span></div>
                                <div class="col12"><span><?php echo $usuario['EMAIL']?></span></div>
                                <div class="col6"><span><?php echo $usuario['TELEFONO']?></span></div>
                                <div class="col12">
                    <?php   
                            if($usuario['DERECHOS_IMAGEN']==1){
                                echo'<img src="../img/1024px-Green_tick_pointed.png" style="width:20px;height:20px;"/>';
                            }
                    ?>
                                </div>
                                <div class="col6">                                        
                                    <form  method="post" action="../registros/registraUsuario.php">
                                        <input type="hidden" name="oid_u" value="<?php echo $usuario['OID_U']?>"/>
                                        <input type="hidden" name="nombre" value="<?php echo $usuario['NOMBRE']?>"/>
                                        <input type="hidden" name="apellidos" value="<?php echo $usuario['APELLIDOS']?>"/>
                                        <input type="hidden" name="fechaNacimiento" value="<?php echo $usuario['FECHA_NACIMIENTO']?>"/>
                                        <input type="hidden" name="direccion" value="<?php echo $usuario['DIRECCION']?>"/>
                                        <input type="hidden" name="email" value="<?php echo $usuario['EMAIL']?>"/>
                                        <input type="hidden" name="telefono" value="<?php echo $usuario['TELEFONO']?>"/>
                                        <input type="hidden" name="derechos" value="<?php echo $usuario['DERECHOS_IMAGEN']?>"/>
                                        <?php $res=getRelacion($conexion, $usuario['OID_U'])?>                                      
                                        <input type="hidden" name="oid_r" value="<?php echo $res['OID_R'] ?>"/>
                                        <input type="hidden" name="tipoRelacion" value="<?php echo $res['TIPO_RELACION'] ?>"/>
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