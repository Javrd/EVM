<?php
// (nombre2 IN usuarios.nombre%TYPE,
// apellidos2 IN usuarios.apellidos%TYPE,
// fecha_nacimiento2 IN usuarios.fecha_nacimiento%TYPE,
// direccion2 IN usuarios.direccion%TYPE,
// email2 IN usuarios.email%TYPE,
// telefono2 IN usuarios.telefono%TYPE,
// derechos_imagen2 IN usuarios.derechos_imagen%TYPE) IS

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
		$responsable['OID_R']="";
		$usuario["responsable"] = $responsable;
		$_SESSION["usuario"] = $usuario;
	} else {
		$usuario = $_SESSION['usuario'];

	}
	
	// Gestion de errores.
	if (isset($_SESSION['error'])){	
		$error = $_SESSION['error'];
		unset($_SESSION['error']);
		
		// Definición de class error para css en campos que tengan error.
		if (isset($error["nombre"])){
			$class["nombre"] = "error";	
		}
		if (isset($error["apellidos"])){
			$class["apellidos"] = "error";	
		}
		if (isset($error["fechaNacimiento"])){
			$class["fechaNacimiento"] = "error";	
		}
		if (isset($error["direccion"])){
			$class["direccion"] = "error";	
		}
		if (isset($error["email"])){
			$class["email"] = "error";	
		}
		if (isset($error["telefono"])){
			$class["telefono"] = "error";	
		}
		
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
		if (isset($_SESSION['modificarUsuario'])){
			echo "<title>Modificar usuario</title>";	
		} elseif(isset($_SESSION['modificarUsuario'])){
			echo "<tittle>Nuevo usuario</title>";
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
	    <form action="mostrarDatos.php" method="post">
	  

        <div id="datosAlumno">

          <fieldset>

            <legend>Datos del Alumno</legend>

            <div id="div_nombre">  
              <label id="label_nombre" for="nombre">Nombre:</label>
              <input id="input_nombre" class="<?php echo $class['nombre']?>" name="nombre" value="<?php echo $usuario['nombre'] ?>" type="text"/>
            </div>

            <div id="div_apellidos">  
              <label id="label_apellidos" for="apellidos">Apellidos:</label>
              <input id="input_apellidos <?php echo "".$class['apellidos']?>" name="apellidos" value="<?php echo $usuario['apellidos'] ?>" type="text"/>
            </div>

			<div id="div_fechaNacimiento">
            	<label id="label_fechaNacimiento">Fecha de nacimiento:</label>
            	<select id="select_dia" name="dia">
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
              	
              	<select id="select_mes" name="mes">
	            <optgroup label="Mes">
                <option <?php if ($usuario['fechaNacimiento']['mes']=="Enero") echo "selected='selected'"; ?> >Enero</option>
                <option <?php if ($usuario['fechaNacimiento']['mes']=="Febrero") echo "selected='selected'"; ?> >Febrero</option>
                <option <?php if ($usuario['fechaNacimiento']['mes']=="Marzo") echo "selected='selected'"; ?> >Marzo</option>
                <option <?php if ($usuario['fechaNacimiento']['mes']=="Abril") echo "selected='selected'"; ?> >Abril</option>
                <option <?php if ($usuario['fechaNacimiento']['mes']=="Mayo") echo "selected='selected'"; ?> >Mayo</option>
                <option <?php if ($usuario['fechaNacimiento']['mes']=="Junio") echo "selected='selected'"; ?> >Junio</option>
                <option <?php if ($usuario['fechaNacimiento']['mes']=="Julio") echo "selected='selected'"; ?> >Julio</option>
                <option <?php if ($usuario['fechaNacimiento']['mes']=="Agosto") echo "selected='selected'"; ?> >Agosto</option>
                <option <?php if ($usuario['fechaNacimiento']['mes']=="Septiembre") echo "selected='selected'"; ?> >Septiembre</option>
                <option <?php if ($usuario['fechaNacimiento']['mes']=="Octubre") echo "selected='selected'"; ?> >Octubre</option>
                <option <?php if ($usuario['fechaNacimiento']['mes']=="Noviembre") echo "selected='selected'"; ?> >Noviembre</option>
                <option <?php if ($usuario['fechaNacimiento']['mes']=="Diciembre") echo "selected='selected'"; ?> >Diciembre</option>
              	</optgroup>
              	</select>
	              	
            	<select id="select_anio" name="anio">
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
          	</div>
           	<div id="div_direccion">
        		<label id="label_direccion" for="direccion">Dirección:</label>
            	<input id="direccion" name="direccion" value="<?php echo $usuario['direccion'] ?>" type="text"/>   
          	</div>
            <div id="div_email">  
              	<label id="label_email" for="email">Email:</label>
              	<input id="input_email" name="email" value="<?php echo $usuario['email'] ?>" type="text"/>
            </div>
            <div id="div_telefono">  
              	<label id="label_telefono" for="telefono">Teléfono:</label>
              	<input id="input_telefono" name="telefono" value="<?php echo $usuario['telefono'] ?>" type="text"/>
            </div>
            <div id="div_derechosImagen">
            	<label id="label_derechosImagen" for="derechosImagen">Cede los derechos de imagen</label>
          		<input id="input_derechosImagen" name="derechosImagen" <?php if(isset($usuario['derechosImagen'])) echo "checked='checked'" ?> type="checkbox"/>
          	</div>
            <div id="div_responsable">
            	<label id="label_responsable" for="responsable">Vincular responsable</label>
            	<input id="input_responsable" name="check_responsable" <?php if(isset($usuario['checkResponsable'])) echo "checked='checked'" ?> type="checkbox"/>
            	<select id="select_responsable" name="select_responsable">
	              	<?php
	              	$responsables = listaResponsables($conexion);
	              	foreach ($responsables as $responsable) { 
						echo "<option value='".$responsable['OID_R']."' ";
						if ($usuario['responsable']['OID_R'] == $responsable['OID_R'] ) echo "selected='selected'";
						echo ">";
						echo $responsable['NOMBRE']." ".$responsable['APELLIDOS']."</option>";
				  	}
					?>
              	</select>
            </div>
          </fieldset>

        </div>


    <div id="div_submit">
          <button id="submit" >Enviar</button>
	</div>

	</form>
	</div>

		
		<!-- <?php include(footer.html) ?> -->
		<?php cerrarConexionBD($conexion); ?>
	</body>
</html>