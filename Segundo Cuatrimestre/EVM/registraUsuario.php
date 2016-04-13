<?php
 	session_start();
    
 
	if (!isset($_SESSION['usuario'])){
	    if (!isset($_REQUEST["modificar"]) && !isset($_REQUEST["nuevo"])){
            Header("Location: usuarios.php");
        }elseif (isset($_REQUEST['modificar'])){
            $usuario["title"] = "modificar";
        } else {
            $usuario["title"] = "nuevo";
        }
        
		$usuario["nombre"] = "";
		$usuario["apellidos"] = "";
		$fechaNacimiento['dia']="1";
		$fechaNacimiento['mes']="Enero";
		$fechaNacimiento['anio']=date('Y');
		$usuario["fechaNacimiento"] = $fechaNacimiento;
		$usuario["direccion"] = "";
		$usuario["email"] = "";
		$usuario["telefono"] = "";
		$usuario["responsable"]="";
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
		<?php 
		if ($usuario["title"]=="modificar"){
			echo "<title>Modificar usuario</title>";	
		} elseif($usuario["title"]=="nuevo"){
			echo "<title>Nuevo usuario</title>";
		}
		?>
		<meta name="description" content="">
		<meta name="author" content="Javi">

		<meta name="viewport" content="width=device-width; initial-scale=1.0">

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico">
		<link rel="apple-touch-icon" href="/apple-touch-icon.png">
	</head>
	
	<body>
		
		<!-- <?php include('header.html') ?> -->
		
		<div id="FormularioUsuarios">
	    <form action="tratamientoUsuarios.php" method="post">
	  

        <div id="datosAlumno">

          <fieldset>

            <legend>Datos del Alumno</legend>

            <div id="div_nombre">  
              <label id="label_nombre" for="input_nombre">Nombre:</label>
              <input id="input_nombre" <?php if(isset($errores["nombre"])) echo 'class="error"'?> name="nombre" value="<?php echo $usuario['nombre'] ?>" type="text"/>
              <span class="error"><?php if(isset($errores["nombre"])) echo $errores["nombre"]?></span>
            </div>

            <div id="div_apellidos">  
              <label id="label_apellidos" for="input_apellidos">Apellidos:</label>
              <input id="input_apellidos" <?php if(isset($errores["apellidos"])) echo 'class="error"'?> name="apellidos" value="<?php echo $usuario['apellidos'] ?>" type="text"/>
              <span class="error"><?php if(isset($errores["apellidos"])) echo $errores["apellidos"]?></span>
            </div>

			<div id="div_fechaNacimiento">
            	<label id="label_fechaNacimiento">Fecha de nacimiento:</label>
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
	              	for ($i=date('Y'); $i > 1919 ; $i--) { 
						echo "<option ";
						if ($usuario['fechaNacimiento']['anio'] == $i ) echo "selected='selected'";
						echo ">";
						echo "$i</option>";
				  	}
					?>
              	</optgroup>
              	</select>
                <span class="error"><?php if(isset($errores["fechaNacimiento"])) echo $errores["fechaNacimiento"]?></span>
          	</div>
           	<div id="div_direccion">
        		<label id="label_direccion" for="input_direccion">Dirección:</label>
            	<input id="input_direccion" <?php if(isset($errores["direccion"])) echo 'class="error"'?> name="direccion" value="<?php echo $usuario['direccion'] ?>" type="text"/>
                <span class="error"><?php if(isset($errores["direccion"])) echo $errores["direccion"]?></span>   
          	</div>
            <div id="div_email">  
              	<label id="label_email" for="input_email">Email:</label>
              	<input id="input_email" <?php if(isset($errores["email"])) echo 'class="error"'?> name="email" value="<?php echo $usuario['email'] ?>" type="text"/>
            </div>
            <div id="div_telefono">  
              	<label id="label_telefono" for="input_telefono">Teléfono:</label>
              	<input id="input_telefono" <?php if(isset($errores["telefono"])) echo 'class="error"'?> name="telefono" value="<?php echo $usuario['telefono'] ?>" type="text"/>
            </div>
            <div id="div_derechosImagen">
            	<label id="label_derechosImagen" for="input_derechosImagen">Cede los derechos de imagen</label>
          		<input id="input_derechosImagen" name="derechosImagen" <?php if(isset($usuario['derechosImagen'])) echo "checked='checked'" ?> type="checkbox"/>
          	</div>
            <div id="div_responsable">
            	<label id="label_responsable" for="input_responsable">Vincular responsable</label>
            	<input id="input_responsable" name="check_responsable" <?php if(isset($usuario['checkResponsable'])) echo "checked='checked'" ?> type="checkbox"/>
            	<select id="select_responsable" name="responsable">
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
            </div>
          </fieldset>

        </div>


    <div id="div_submit">
          <button id="button_enviar" type="submit">Enviar</button>
	</div>

	</form>
	</div>

		
		<!-- <?php include(footer.html) ?> -->
		<?php cerrarConexionBD($conexion); ?>
	</body>
</html>