<?php
session_start();
    if(!isset($_SESSION["login"])){
        header("Location: ../index.php");
    }
		if(isset($_REQUEST['nuevo'])){
			unset($_SESSION['registroFalta']);
		}
    	if (!isset($_SESSION['registroFalta'])){
            $fecha_falta = new DateTime();
    		$registroFalta["fecha_falta"] = $fecha_falta;
    		$registroFalta["tipo_falta"] = "Asistencia";
			$registroFalta['usuario'] = "-1";
    		$_SESSION["registroFalta"] = $registroFalta;
    	} else {
    		$registroFalta = $_SESSION['registroFalta'];
    	}
	
	// Gestion de errores.
	if (isset($_SESSION['errores'])){	
		$errores = $_SESSION['errores'];
		unset($_SESSION['errores']);		
	}	
	
    require_once ("../gestion/gestionarFalta.php");
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
		
			echo "<title>Nueva falta</title>";
		
		 ?>

		<meta name="viewport" content="width=device-width; initial-scale=1.0">
        <script src="../js/faltasJS.js"></script>
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
    	       <form onsubmit="return validarFaltas()" action="../tratamientos/tratamientoFaltas.php" method="post">
    	  				
    	  				<div id="div_tipo_falta" class="lineaFormulario">
                		<label id="label_tipo_falta" for="input_tipo_falta">Tipo de Falta:</label>
                    	<input id="input_tipo_falta" name="tipo_falta" value="Asistencia" <?php if($registroFalta['tipo_falta']=='Asistencia')echo "checked='checked'"?> type="radio">Asistencia</input>
                    	<input id="input_tipo_falta" name="tipo_falta" value="Pago" <?php if($registroFalta['tipo_falta']=='Pago')echo "checked='checked'"?> type="radio">Pago</input>
                  		</div>
                  	
               			<div id="div_fecha_falta" class="lineaFormulario">
                    	<label id="label_fecha_falta">Fecha de Falta:</label>
                    	   <div id="select_fecha">
                        	<select id="select_dia" <?php if(isset($errores["fecha_falta"])) echo 'class="error"'?> name="dia">
            	            <optgroup label="Día">
            	              	<?php
            	              	for ($i=1; $i < 32 ; $i++) { 
            						echo "<option ";
            						if ($registroFalta['fecha_falta']->format('j') == $i ) echo "selected='selected'";
            						echo ">";
            						echo "$i</option>";
            				  	}
            					?>
                          	</optgroup>
                          	</select>
                          	
                          	<select id="select_mes" <?php if(isset($errores["fecha_falta"])) echo 'class="error"'?> name="mes">
            	            <optgroup label="Mes">
                            <option value = "01" <?php if ($registroFalta['fecha_falta']->format('m')=="01") echo "selected='selected'"; ?> >Enero</option>
                            <option value = "02" <?php if ($registroFalta['fecha_falta']->format('m')=="02") echo "selected='selected'"; ?> >Febrero</option>
                            <option value = "03" <?php if ($registroFalta['fecha_falta']->format('m')=="03") echo "selected='selected'"; ?> >Marzo</option>
                            <option value = "04" <?php if ($registroFalta['fecha_falta']->format('m')=="04") echo "selected='selected'"; ?> >Abril</option>
                            <option value = "05" <?php if ($registroFalta['fecha_falta']->format('m')=="05") echo "selected='selected'"; ?> >Mayo</option>
                            <option value = "06" <?php if ($registroFalta['fecha_falta']->format('m')=="06") echo "selected='selected'"; ?> >Junio</option>
                            <option value = "07" <?php if ($registroFalta['fecha_falta']->format('m')=="07") echo "selected='selected'"; ?> >Julio</option>
                            <option value = "08" <?php if ($registroFalta['fecha_falta']->format('m')=="08") echo "selected='selected'"; ?> >Agosto</option>
                            <option value = "09" <?php if ($registroFalta['fecha_falta']->format('m')=="09") echo "selected='selected'"; ?> >Septiembre</option>
                            <option value = "10" <?php if ($registroFalta['fecha_falta']->format('m')=="10") echo "selected='selected'"; ?> >Octubre</option>
                            <option value = "11" <?php if ($registroFalta['fecha_falta']->format('m')=="11") echo "selected='selected'"; ?> >Noviembre</option>
                            <option value = "12" <?php if ($registroFalta['fecha_falta']->format('m')=="12") echo "selected='selected'"; ?> >Diciembre</option>
                          	</optgroup>
                          	</select>
            	              	
                        	<select id="select_anio" <?php if(isset($errores["fecha_falta"])) echo 'class="error"'?> name="anio">
            	            <optgroup label="Año">
            	              	<?php
            	              	for ($i=date('Y'); $i > date('Y')-2 ; $i--) { 
            						echo "<option ";
            						if ($registroFalta['fecha_falta']->format('Y') == $i ) echo "selected='selected'";
            						echo ">$i</option>";
            				  	}
            					?>
                          	</optgroup>
                          	</select>
                        </div>
                       <span id="errorFaltasFecha" class="error"><?php if(isset($errores["fecha_falta"])) echo $errores["fecha_falta"] ?></span>
                  	</div>
                   	                    
                    	<div id="div_usuario" class="lineaFormulario">
                        <label id="label_usuario" for="select_usuario">Usuario:</label>
                    	<select id="select_usuario" <?php if(isset($errores["usuario"])) echo 'class="error"'?> name="usuario" >
                    	    <option value="-1" <?php if ("-1" == $registroFalta['usuario'] ) echo "selected='selected'" ?>>--Usuario--</option>
        	              	<?php
        	              	$usuarios = listaUsuariosActivos($conexion);
        	              	foreach ($usuarios as $usuario) { 
        						echo "<option value='".$usuario['OID_M']."' ";
        						if ($usuario['OID_M'] == $registroFalta['usuario'] ) echo "selected='selected'";
        						echo ">";
        						echo $usuario['NOMBRE']." ".$usuario['APELLIDOS']."</option>";
        				  	}
        					?>
                      	</select>
                      	<span id="errorFaltasUsuario" class="error"><?php if(isset($errores["usuario"])) echo $errores["usuario"]?></span>
                    </div>
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