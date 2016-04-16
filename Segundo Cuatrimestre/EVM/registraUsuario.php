<?php
session_start();
    
	if (!isset($_SESSION['usuario'])){
		$usuario["nombre"] = "";
		$usuario["apellidos"] = "";
		$fechaNacimiento['dia']="1";
		$fechaNacimiento['mes']="Enero";
		$fechaNacimiento['anio']=date('Y');
		$usuario["fechaNacimiento"] = $fechaNacimiento;
		$usuario["direccion"] = "";
		$usuario["email"] = "";
		$usuario["telefono"] = "";
		$usuario["responsable"]="--Responsable--";
		$_SESSION["usuario"] = $usuario;
	} else {
		$usuario = $_SESSION['usuario'];
	}
	
	// Gestion de errores.
	if (isset($_SESSION['errores'])){	
		$errores = $_SESSION['errores'];
		unset($_SESSION['errores']);		
	}	
	
	require_once ("GestionarUsuario.php");
	require_once("GestionBD.php");
	
	$conexion = crearConexionBD();
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<!-- <?php 
		if ($usuario["action"]=="modificar"){
			echo "<title>Modificar usuario</title>";	
		} elseif($usuario["action"]=="nuevo"){
			echo "<title>Nuevo usuario</title>";
		}
		 ?> -->
		<meta name="description" content="">
		<meta name="author" content="Javi">

		<meta name="viewport" content="width=device-width; initial-scale=1.0">

        <link rel="shortcut icon" href="favicon.png">
        <link rel="apple-touch-icon" href="favicon.png">
        <link rel="stylesheet" type="text/css" href="evm.css">
	</head>
	
	<body>
        <div id="container">
		
    		<?php include('header.html') ?>
    		
    		<div id="content" class="formulario">
    	       <form action="tratamientoUsuarios.php" method="post">
    	  
                    <div id="div_nombre" class="lineaFormulario">  
                      <label id="label_nombre" for="input_nombre">Nombre:</label>
                      <input id="input_nombre" class="box <?php if(isset($errores["nombre"])) echo "error"?>" name="nombre" value="<?php echo $usuario['nombre'] ?>" type="text"/>
                      <span class="error"><?php if(isset($errores["nombre"])) echo $errores["nombre"]?></span>
                    </div>
        
                    <div id="div_apellidos" class="lineaFormulario">  
                      <label id="label_apellidos" for="input_apellidos">Apellidos:</label>
                      <input id="input_apellidos" class="box <?php if(isset($errores["apellidos"])) echo "error"?>" name="apellidos" value="<?php echo $usuario['apellidos'] ?>" type="text"/>
                      <span class="error"><?php if(isset($errores["apellidos"])) echo $errores["apellidos"]?></span>
                    </div>
        
        			<div id="div_fechaNacimiento" class="lineaFormulario">
                    	<label id="label_fechaNacimiento">Fecha de nacimiento:</label>
                    	   <div id="select_fecha">
                        	<select id="select_dia" <?php if(isset($errores["fechaNacimiento"])) echo 'class="error"'?> name="dia">
            	            <optgroup label="Día">
            	              	<?php
            	              	for ($i=1; $i < 32 ; $i++) { 
            						echo "<option ";
            						if ($usuario['fechaNacimiento']['dia'] == $i ) echo "selected='selected'";
            						echo ">";
            						echo "$i</option>";
            				  	}
            					?>
                          	</optgroup>
                          	</select>
                          	
                          	<select id="select_mes" <?php if(isset($errores["fechaNacimiento"])) echo 'class="error"'?> name="mes">
            	            <optgroup label="Mes">
                            <option value = "01" <?php if ($usuario['fechaNacimiento']['mes']=="01") echo "selected='selected'"; ?> >Enero</option>
                            <option value = "02" <?php if ($usuario['fechaNacimiento']['mes']=="02") echo "selected='selected'"; ?> >Febrero</option>
                            <option value = "03" <?php if ($usuario['fechaNacimiento']['mes']=="03") echo "selected='selected'"; ?> >Marzo</option>
                            <option value = "04" <?php if ($usuario['fechaNacimiento']['mes']=="04") echo "selected='selected'"; ?> >Abril</option>
                            <option value = "05" <?php if ($usuario['fechaNacimiento']['mes']=="05") echo "selected='selected'"; ?> >Mayo</option>
                            <option value = "06" <?php if ($usuario['fechaNacimiento']['mes']=="06") echo "selected='selected'"; ?> >Junio</option>
                            <option value = "07" <?php if ($usuario['fechaNacimiento']['mes']=="07") echo "selected='selected'"; ?> >Julio</option>
                            <option value = "08" <?php if ($usuario['fechaNacimiento']['mes']=="08") echo "selected='selected'"; ?> >Agosto</option>
                            <option value = "09" <?php if ($usuario['fechaNacimiento']['mes']=="09") echo "selected='selected'"; ?> >Septiembre</option>
                            <option value = "10" <?php if ($usuario['fechaNacimiento']['mes']=="10") echo "selected='selected'"; ?> >Octubre</option>
                            <option value = "11" <?php if ($usuario['fechaNacimiento']['mes']=="11") echo "selected='selected'"; ?> >Noviembre</option>
                            <option value = "12" <?php if ($usuario['fechaNacimiento']['mes']=="12") echo "selected='selected'"; ?> >Diciembre</option>
                          	</optgroup>
                          	</select>
            	              	
                        	<select id="select_anio" <?php if(isset($errores["fechaNacimiento"])) echo 'class="error"'?> name="anio">
            	            <optgroup label="Año">
            	              	<?php
            	              	for ($i=date('Y')-3; $i > 1919 ; $i--) { 
            						echo "<option ";
            						if ($usuario['fechaNacimiento']['anio'] == $i ) echo "selected='selected'";
            						echo ">";
            						echo "$i</option>";
            				  	}
            					?>
                          	</optgroup>
                          	</select>
                        </div>
                        <span class="error"><?php if(isset($errores["fechaNacimiento"])) echo $errores["fechaNacimiento"]?></span>
                  	</div>
                   	<div id="div_direccion" class="lineaFormulario">
                		<label id="label_direccion" for="input_direccion">Dirección:</label>
                    	<input id="input_direccion" class="box <?php if(isset($errores["direccion"])) echo "error"?>" name="direccion" value="<?php echo $usuario['direccion'] ?>" type="text"/>
                        <span class="error"><?php if(isset($errores["direccion"])) echo $errores["direccion"]?></span>   
                  	</div>
                    <div id="div_email" class="lineaFormulario">  
                      	<label id="label_email" for="input_email">Email:</label>
                      	<input id="input_email" class="box <?php if(isset($errores["email"])) echo "error"?>" name="email" value="<?php echo $usuario['email'] ?>" type="text"/>
                    </div>
                    <div id="div_telefono" class="lineaFormulario">  
                      	<label id="label_telefono" for="input_telefono">Teléfono:</label>
                      	<input id="input_telefono" class="box <?php if(isset($errores["telefono"])) echo "error"?>" name="telefono" value="<?php echo $usuario['telefono'] ?>" type="text"/>
                    </div>
                    <div id="div_derechosImagen" class="lineaFormulario">
                    	<label id="label_derechosImagen" for="input_derechosImagen">Cede los derechos de imagen</label>
                  		<input id="input_derechosImagen" name="derechosImagen" <?php if(isset($usuario['derechosImagen'])) echo 'checked' ?> type="checkbox"/>
                  	</div>
                    <div id="div_responsable" class="lineaFormulario">
                    	<label id="label_responsable" for="input_responsable">Vincular responsable</label>
                    	<input id="input_responsable" name="checkResponsable" <?php if(isset($usuario['checkResponsable'])) echo "checked='checked'" ?> type="checkbox"/>
                    	<select id="select_responsable " <?php if(isset($errores["responsable"])) echo 'class="error"'?> name="responsable">
                    	    <option>--Responsable--</option>
        	              	<?php
        	              	$responsables = listaResponsables($conexion);
        	              	foreach ($responsables as $responsable) { 
        						echo "<option value='".$responsable['OID_R']."' ";
        						if ($usuario['responsable'] == $responsable['OID_R'] ) echo "selected='selected'";
        						echo ">";
        						echo $responsable['NOMBRE']." ".$responsable['APELLIDOS']."</option>";
        				  	}
        					?>
                      	</select>
                      	<span class="error"><?php if(isset($errores["responsable"])) echo $errores["responsable"]?></span>
                    </div>
                    <div id="div_submit">
                          <button id="button_enviar" class="submit" type="submit">Enviar</button>
                	</div>
        	   </form>
            </div> <!-- Fin content -->
            
    		<?php    
    		include("footer.html");
            cerrarConexionBD($conexion); 
            ?>
        </div>
        
	</body>
</html>