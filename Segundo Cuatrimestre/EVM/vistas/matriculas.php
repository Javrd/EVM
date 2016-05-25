<?php
    session_start();
    if(!isset($_SESSION["login"])){
        header("Location: ../index.php");
    }
    
    require_once ("../gestion/gestionarMatricula.php");
    require_once("../gestion/gestionBD.php");
    $conexion = crearConexionBD();
    
    /* Recuperacion de sesion de las variables que no se hayan pasado como get */
    
    if(isset($_SESSION['matriculas'])){
        $matriculas = $_SESSION["matriculas"];
        $page_num = $matriculas["page_num"];
        $page_size = $matriculas["page_size"];
        unset($_SESSION["matriculas"]);
    } else {
        $page_num = 1;
        $page_size   = 10;
    }

    /* Gets de formularios de paginación y tipo de consulta */
    
    $consulta = "Todas";
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
    if ($consulta == "Todas")
        $total = consultarTotalMatriculas($conexion);  // Cuenta de total de faltas por defecto. Por defecto, consulta = Todas, si no, $consulta = oid_u
    else 
        $total = 1;
    
    $total_pages = ( $total / $page_size );
    
    if ( $total % $page_size > 0 ) // resto de la división
        $total_pages++;
    
    if ( $page_num < 1 ) 
        $page_num = 1;
    else if ( $page_num > $total_pages )
        $page_num = (int)$total_pages;  
    
    $matriculas["page_num"] = $page_num;
    $matriculas["page_size"] = $page_size;
    $_SESSION["matriculas"] = $matriculas;
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>Matriculas</title>
		
		<meta name="viewport" content="width=device-width; initial-scale=1.0">

        <link rel="shortcut icon" href="../img/favicon.png">
        <link rel="apple-touch-icon" href="../img/favicon.png">
        <link rel="stylesheet" type="text/css" href="../evm.css">
	</head>

	<body class="vistaMatriculas">
		  <div id="container">
		      
    		<?php include("../header.html") ?>
    		
    		<div id="content">
        		<nav>
        			<ul class="menu">
        				<form  method="post" action="../registros/registraMatricula.php">
        				<li><button id = "button_nuevo" name="nuevo">Nueva</button></li>    
        				</form>
        			</ul>
        		</nav>
                <div id="Paginacion">
                <form method="get" action="matriculas.php">
                <?php
                    $filas = consultaPaginadaMatriculas($conexion,$page_num,$page_size,$total,$consulta);
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
        		<div id="ConsultaMatriculas" class="consultas">
        		    <div class="titlerow">
        		    	<div class="col6">Nombre</div>
                        <div class="col15">Apellidos</div>
                        <div class="col6">Codigo</div>
                        <div class="col6">Fecha de Matriculacion</div>
                        <div class="col6">Curso</div>
                        <div class="col9">Asignaturas</div>                        
                        
                    </div>
        			<?php
                        $i = 0;
                        foreach ($filas as $matricula) {
                            
                            $row = $i%2?'oddrow':'evenrow';
                            $fecha = DateTime::createFromFormat("d/m/y",$matricula['FECHA_MATRICULACION']);
                    ?>
                            <div class=<?php echo $row ?>>
                            	
                                <div class="col6"><span><?php echo $matricula['NOMBRE']?></span></div>
                                <div class="col15"><span><?php echo $matricula['APELLIDOS']?></span></div>
                                <div class="col6"><span><?php echo $matricula['CODIGO']?></span></div>
                                <div class="col6"><span><?php echo $fecha->format("d/m/y")?></span></div>
                                <div class="col6"><span><?php echo $matricula['CURSO']?></span></div>
                                <div class="col9"><select>
                                <?php
                                    $filasAsignaturas = consultaAsignaturasDeMatricula($conexion,$matricula['OID_M']);
                                    foreach ($filasAsignaturas as $asignatura){
                                        echo "<option>".$asignatura["NOMBRE"]."</option>";
                                    }
                                ?>
                                </select></div>
                   
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