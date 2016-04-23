<?php
    session_start();
    
    require_once ("../gestion/gestionarUsuario.php");
    require_once("../gestion/gestionBD.php");
    $conexion = crearConexionBD();

    if ( isset($_GET["page_num"]) && isset($_GET["page_size"]) && isset($_SESSION['usuario']["consulta"]) ){
        $page_num = (int)$_GET["page_num"];
        $page_size = (int)$_GET["page_size"];
        $consulta = $_SESSION['usuario']["consulta"];
        
    }else if ( isset($_GET["page_num"]) && isset($_GET["page_size"]) ){
        $page_num = (int)$_GET["page_num"];
        $page_size = (int)$_GET["page_size"];
        
    } else if (isset($_GET["consulta"])&& isset($_GET["page_size"]) && isset($_SESSION['usuario']["page_num"])){
        $consulta = $_GET["consulta"];
        $page_size = (int)$_GET["page_size"];
        $page_num = $_SESSION['usuario']["page_num"];
        
    } else if (isset($_GET["consulta"])&& isset($_GET["page_size"])){
        $consulta = $_GET["consulta"];
        $page_size = (int)$_GET["page_size"];
        $page_num = 1;
        
    } else if(isset($_SESSION['usuario'])){
        $usuario = $_SESSION["usuario"]; 
        $page_num = $usuario["page_num"];
        $page_size = $usuario["page_size"];
        $consulta = $usuario["consulta"];
    } else {
        $page_num = 1;
        $page_size   = 10;
        $consulta = "Todos";
    }
    unset($_SESSION["usuario"]);
    if ( $page_num < 1 ) 
        $page_num = 1;
    if ( $page_size < 1 ) 
        $page_size = 10;

    if ($consulta == "Usuarios con prestamos")
        $total = consultarUsuariosConPrestamos($conexion);
    else 
        $total = consultarTotalUsuarios($conexion);  
    $total_pages = ( $total / $page_size );
    if ( $total % $page_size > 0 ) // resto de la división
        $total_pages++;
    if ( $page_num > $total_pages )
        $page_num = $total_pages;  
    $usuario["page_num"] = $page_num;
    $usuario["page_size"] = $page_size;
    $usuario["consulta"] = $consulta;
    $_SESSION["usuario"] = $usuario;
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

	<body>
		  <div id="container">
		      
    		<?php include("../header.html") ?>
    		
    		<div id="content">
                <form method="get" action="usuarios.php">
        		<div id="UsuariosNavBar">
        			<ul class="menu">
                        <li><button id = "button_usuarios" name="consulta" value="Todos">Todos</button></li>
        				<li><button id = "button_prestamos" name="consulta"  value="Usuarios con prestamos">Usuarios con préstamos</button></li>
        				<li><button id = "button_nuevo" name="nuevo">Nuevo</button></li>    
        			</ul>
        		</div>
                <div id="Paginacion">
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

                </div>                
                </form>
        		<div id="ConsultaUsuarios">
        		    
        			<?php 
                        $usuarios = consultarPaginaUsuarios($conexion,$page_num,$page_size,$total,$consulta);
                        $i = 0;
                        foreach ($usuarios as $usuario) {
                            $row = $i%2?'oddrow':'evenrow';
                            echo "<div class=$row><span>"; 
                            echo $usuario['NOMBRE']." ".$usuario['APELLIDOS'];
                            echo '</span></div>';
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