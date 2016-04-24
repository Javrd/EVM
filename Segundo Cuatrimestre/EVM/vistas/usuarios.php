<?php
    session_start();
    
    require_once ("../gestion/gestionarUsuario.php");
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
    
    if ($consulta == "Usuarios con prestamos")
        $total = consultarUsuariosConPrestamos($conexion); // Cuenta el total de usuarios para consulta de usuarios con prestamos
    else 
        $total = consultarTotalUsuarios($conexion);  // Cuenta de total de usuarios por defecto. Por defecto, consulta = Todos
    $total_pages = ( $total / $page_size );
    
    if ( $page_size < 1 ) 
        $page_size = 10;
    
    if ( $total % $page_size > 0 ) // resto de la división
        $total_pages++;
    
    if ( $page_num < 1 ) 
        $page_num = 1;
    else if ( $page_num > $total_pages )
        $page_num = $total_pages;  
    
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

	<body>
		  <div id="container">
		      
    		<?php include("../header.html") ?>
    		
    		<div id="content">
        		<div id="UsuariosNavBar">
        			<ul class="menu">
                        <form method="get" action="usuarios.php">
                        <li><button id = "button_usuarios" name="consulta" value="Todos">Todos</button></li>
        				<li><button id = "button_prestamos" name="consulta"  value="Usuarios con prestamos">Usuarios con préstamos</button></li>
        				</form>
        				<form  method="post" action="../registros/registraUsuario.php">
        				<li><button id = "button_nuevo" name="nuevo">Nuevo</button></li>    
        				</form>
        			</ul>
        		</div>
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
        		<div id="ConsultaUsuarios">
        		    <div class="hrow">
                        <div class=col><button>Nombre</button></div>
                        <div class=col><button>Apellidos</button></div>
                        <div class=col><button>Edad</button></div>
                        <div class=col><button>Direccion</button></div>
                        <div class=col><button>Email</button></div>
                        <div class=col><button>Telefono</button></div>
                        <div class=col><button>Derechos de imagen</button></div>
        		    </div>
        			<?php 
                        $filas = consultarPaginaUsuarios($conexion,$page_num,$page_size,$total,$consulta);
                        $i = 0;
                        
                        foreach ($filas as $usuario) {
                            $row = $i%2?'oddrow':'evenrow';
                            echo "<div class=$row>"; 
                            echo "<div class=col><span>".$usuario['NOMBRE']."</span></div>";
                            echo "<div class=col><span>".$usuario['APELLIDOS']."</span></div>";
                            echo "</div>";
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