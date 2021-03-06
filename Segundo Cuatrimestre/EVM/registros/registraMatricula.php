<?php
session_start();
    if(!isset($_SESSION["login"])){
        header("Location: ../index.php");
    }
		if(isset($_REQUEST['nuevo'])){
			unset($_SESSION['registroMatricula']);
		}
    	if (!isset($_SESSION['registroMatricula'])){
            $fecha_matricula = new DateTime();
			$registroMatricula["dia"]= $fecha_matricula->format("j");
			$registroMatricula["anio"]= $fecha_matricula->format('Y');
			$registroMatricula["mes"]= $fecha_matricula->format('m');
    		$registroMatricula["curso"] = "-1";
            $registroMatricula["usuario"] = "-1";
			$registroMatricula['codigo'] = "";
            $registroMatricula["asignaturas"] = [];
    		$_SESSION["registroMatricula"] = $registroMatricula;
    	} else {
    		$registroMatricula = $_SESSION['registroMatricula'];
    	}
	
	// Gestion de errores.
	if (isset($_SESSION['errores'])){	
		$errores = $_SESSION['errores'];
		unset($_SESSION['errores']);		
	}	
	
    require_once ("../gestion/gestionarMatricula.php");
	require_once("../gestion/gestionBD.php");
	
	$conexion = crearConexionBD();
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<?php
		
			echo "<title>Nueva matricula</title>";
		
		 ?>

		<meta name="viewport" content="width=device-width; initial-scale=1.0">
        <script src="../js/evm.js"></script>
        <script src="../js/matriculas.js"></script>
        <script src="../js/jquery-1.12.3.min.js"></script>
        <link rel="shortcut icon" href="../img/favicon.png">
        <link rel="apple-touch-icon" href="../img/favicon.png">
        <link rel="stylesheet" type="text/css" href="../evm.css">
        
	</head>
	
	<body>
        <div id="container">
		
    		<?php include('../header.html') ?>
    		
    		<div id="content">
    		   <div id="formulario">
    	       <form action="../tratamientos/tratamientoMatriculas.php" method="post" onsubmit="return validarMatriculas()">

                              

    	  				<div id="div_curso" class="lineaFormulario">
                            <label id="label_curso" for="select_curso">Curso de la matricula:</label>
                            <select id="select_curso" <?php if(isset($errores["curso"])) echo 'class="error"'?> name="curso" >
                                <option value="-1" <?php if ("-1" == $registroMatricula['curso'] ) echo "selected='selected'" ?>>--Curso--</option>
                                <?php
                                for ($i=1; $i < 5 ; $i++) { 
                                    echo "<option ";
                                    echo 'value="'.$i.'"';
                                    if ($registroMatricula['curso'] == $i ) echo "selected='selected'";
                                    echo ">";
                                    echo "$i</option>";
                                }
                                ?>
                            </select>
                            <span id="errorCurso" class="error"><?php if(isset($errores["curso"])) echo $errores["curso"]?></span>
                        </div>
               			<div id="div_fecha_matricula" class="lineaFormulario">
                    	<label id="label_fecha_matricula">Fecha de Matriculacion:</label>
                    	   <div id="select_fecha">
                            	<select id="select_dia" <?php if(isset($errores["fecha_matricula"])) echo 'class="error"'?> name="dia">
                    	            <optgroup label="Día">
                    	              	<?php
                    	              	for ($i=1; $i < 32 ; $i++) { 
                    						echo "<option ";
                    						if ($registroMatricula['dia'] == $i ) echo "selected='selected'";
                    						echo ">";
                    						echo "$i</option>";
                    				  	}
                    					?>
                                  	</optgroup>
                              	</select>
                          	
                          	<select id="select_mes" onchange="checkDate()" <?php if(isset($errores["fecha_matricula"])) echo 'class="error"'?> name="mes">
                	            <optgroup label="Mes">
                                    <?php
                                    $meses = Array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Noviembre","Diciembre");
                                    for ($i=1; $i < 12 ; $i++) { 
                                        echo ' <option value = "';
                                        if ($i<11) {
                                            $num = "0" . $i;
                                        }
                                        else{
                                            $num = $i;
                                        }
                                        echo $num;
                                        echo '"';
                                        if ($registroMatricula['mes']==$num) echo "selected='selected'";
                                        echo ">";
                                        echo $meses[$i-1]."</option>";
                                    }
                                    ?>
                                </optgroup>
                            </select>

                           
                        	<select id="select_anio" onchange="checkDate()" <?php if(isset($errores["fecha_matricula"])) echo 'class="error"'?> name="anio">
            	            <optgroup label="Año">
            	              	<?php
            	              	for ($i=date('Y'); $i > date('Y')-2 ; $i--) { 
            						echo "<option ";
            						if ($registroMatricula['anio']== $i ) echo "selected='selected'";
            						echo ">$i</option>";
            				  	}
            					?>
                          	</optgroup>
                          	</select>
                        </div>
                       <span id="errorMatriculasFecha" class="error"><?php if(isset($errores["fecha_matricula"])) echo $errores["fecha_matricula"] ?></span>
                  	</div>

                    <div id="div_codigo" class="lineaFormulario">   
                        <label id="label codigo" for="input_codigo">Codigo:</label>
                        <input id="input_codigo" maxlength="5" class="box <?php if(isset($errores["codigo"])) echo "error"?>" name="codigo" value="<?php echo $registroMatricula['codigo'] ?>" type="text"/>
                        <span id="errorCodigo" class="error"><?php if(isset($errores["codigo"])) echo $errores["codigo"]?></span>
                    </div>

                   	                    
                    <div id="div_usuario" class="lineaFormulario">
                        <label id="label_usuario" for="select_usuario">Usuario:</label>
                    	<select id="select_usuario" <?php if(isset($errores["usuario"])) echo 'class="error"'?> name="usuario" >
                    	    <option value="-1" <?php if ("-1" == $registroMatricula['usuario'] ) echo "selected='selected'" ?>>--Usuario--</option>
        	              	<?php
        	              	$usuarios = listaUsuarios($conexion);
        	              	foreach ($usuarios as $usuario) { 

                                $edadUsuario = edadDeUsuario($conexion,$usuario['OID_U']);
                                $hoy =  new DateTime();
                                $nacimiento = DateTime::createFromFormat("d/m/Y",$edadUsuario['FECHA_NACIMIENTO']);
                                $edad = $nacimiento->diff($hoy);
                                $edadStr = $edad->format('%y');
        						echo "<option value='".$usuario['OID_U']." ".$edadStr."' ";
        						if ($usuario['OID_U'] == $registroMatricula['usuario'] ) echo "selected='selected'";
        						echo ">";
        						echo $usuario['NOMBRE']." ".$usuario['APELLIDOS']."</option>";

        				  	}
        					?>
                      	</select>
                      	<span id="errorMatriculaUsuario" class="error"><?php if(isset($errores["usuario"])) echo $errores["usuario"]?></span>
                    </div>

                    <div id="div_asignaturas" class="lineaFormulario">

                        <?php
                        $asignaturas = consultaAsignaturas($conexion);
                        foreach ($asignaturas as $asignatura) {
                            if ((!$registroMatricula['asignaturas']==null) and (in_array($asignatura['NOMBRE'],$registroMatricula['asignaturas']))){
                                echo '<label for="'.$asignatura["NOMBRE"].'">'.$asignatura["NOMBRE"].'</label>'.'<input checked class="checkItems" type="checkbox" id="'.$asignatura["NOMBRE"].'" name="check_list[]" value="'.$asignatura["NOMBRE"]."/".$asignatura["OID_A"].'"> ';
                            }else{
                                echo '<label for="'.$asignatura["NOMBRE"].'">'.$asignatura["NOMBRE"].'</label>'.'<input class="checkItems" type="checkbox" id="'.$asignatura["NOMBRE"].'" name="check_list[]" value="'.$asignatura["NOMBRE"]."/".$asignatura["OID_A"].'"> ';
                            }
                           
                        }

                        ?> 
                    </div>
                    <span id="errorMatriculaAsignaturas" class="error"><?php if(isset($errores["asignaturas"])) echo $errores["asignaturas"]?></span>
                    <div id="div_submit">
                          <button id="button_enviar" class="submit" type="submit">Enviar</button>
                	</div>
        	   </form>
        	   </div>
            </div> <!-- Fin content -->
            
    		<?php    
    		include("../footer.html");
            cerrarConexionBD($conexion); 
            ?>
        </div>
        
	</body>
</html>