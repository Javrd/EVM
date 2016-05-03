<?php
session_start();
    if(isset($_POST['nuevo'])){
        unset($_SESSION['registroUsuario']);
    }
    if(isset($_POST['oid_u'])){
            $registroUsuario["oid_u"] = $_POST['oid_u'];
            $registroUsuario["nombre"] = $_POST['nombre'];
            $registroUsuario["apellidos"] = $_POST['apellidos'];
            $fechaNacimiento = DateTime::createFromFormat("d/m/y",$_POST['fechaNacimiento']);
            $registroUsuario["fechaNacimiento"] = $fechaNacimiento;
            $registroUsuario["direccion"] = $_POST['direccion'];
            $registroUsuario["email"] = $_POST['email'];
            $registroUsuario["telefono"] = $_POST['telefono'];
            if ($_POST['derechos']==1){
                $registroUsuario["derechosImagen"] = $_POST['derechos'];
            }
            if($_POST['oid_r']!=""){
            $registroUsuario["responsable"]=$_POST['oid_r'];
            $registroUsuario["tipoRelacion"]=$_POST['tipoRelacion'];
            $registroUsuario["checkResponsable"]="";
            } else {
                unset($registroUsuario['checkResponsable']);
                $registroUsuario["responsable"]="--Responsable--";                
                $registroUsuario["tipoRelacion"]="";
            }
            $_SESSION["registroUsuario"] = $registroUsuario;
    } else{
    	if (!isset($_SESSION['registroUsuario'])){
    		$registroUsuario["nombre"] = "";
    		$registroUsuario["apellidos"] = "";
            $fechaNacimiento = DateTime::createFromFormat("d/m/y","01/01/".(date('y')-3));
    		$registroUsuario["fechaNacimiento"] = $fechaNacimiento;
    		$registroUsuario["direccion"] = "";
    		$registroUsuario["email"] = "";
    		$registroUsuario["telefono"] = "";
            $registroUsuario["responsable"]="--Responsable--";
            $registroUsuario["tipoRelacion"]="";
    		$_SESSION["registroUsuario"] = $registroUsuario;
    	} else {
    		$registroUsuario = $_SESSION['registroUsuario'];
    	}
    }
	
	// Gestion de errores.
	if (isset($_SESSION['errores'])){	
		$errores = $_SESSION['errores'];
		unset($_SESSION['errores']);		
	}	
	
    require_once ("../gestion/gestionarResponsable.php");
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
		if (isset($registroUsuario["oid_u"])){
			echo "<title>Modificar usuario</title>";	
		} else {
			echo "<title>Nuevo usuario</title>";
		}
		 ?>

		<meta name="viewport" content="width=device-width; initial-scale=1.0">
        <script src="../js/usuarios.js"></script>
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
    	       <form action="../tratamientos/tratamientoUsuarios.php" method="post" onsubmit="return validarUsuarios()">
    	  
                    <div id="div_nombre" class="lineaFormulario">  
                      <label id="label_nombre" for="input_nombre">Nombre:</label>
                      <input id="input_nombre" class="box <?php if(isset($errores["nombre"])) echo "error"?>" name="nombre" value="<?php echo $registroUsuario['nombre'] ?>" type="text"/>
                      <span id="error_nombre" class="error"><?php if(isset($errores["nombre"])) echo $errores["nombre"]?></span>
                    </div>
        
                    <div id="div_apellidos" class="lineaFormulario">  
                      <label id="label_apellidos" for="input_apellidos">Apellidos:</label>
                      <input id="input_apellidos" class="box <?php if(isset($errores["apellidos"])) echo "error"?>" name="apellidos" value="<?php echo $registroUsuario['apellidos'] ?>" type="text"/>
                      <span id="error_apellidos" class="error"><?php if(isset($errores["apellidos"])) echo $errores["apellidos"]?></span>
                    </div>
        
        			<div id="div_fechaNacimiento" class="lineaFormulario">
                    	<label id="label_fechaNacimiento">Fecha de nacimiento:</label>
                    	   <div id="select_fecha">
                        	<select id="select_dia" <?php if(isset($errores["fechaNacimiento"])) echo 'class="error"'?> name="dia">
            	            <optgroup label="Día">
            	              	<?php
            	              	for ($i=1; $i < 32 ; $i++) { 
            						echo "<option ";
            						if ($registroUsuario['fechaNacimiento']->format('j') == $i ) echo "selected='selected'";
            						echo ">";
            						echo "$i</option>";
            				  	}
            					?>
                          	</optgroup>
                          	</select>
                          	
                          	<select id="select_mes" <?php if(isset($errores["fechaNacimiento"])) echo 'class="error"'?> name="mes">
            	            <optgroup label="Mes">
                            <option value = "01" <?php if ($registroUsuario['fechaNacimiento']->format('m')=="01") echo "selected='selected'"; ?> >Enero</option>
                            <option value = "02" <?php if ($registroUsuario['fechaNacimiento']->format('m')=="02") echo "selected='selected'"; ?> >Febrero</option>
                            <option value = "03" <?php if ($registroUsuario['fechaNacimiento']->format('m')=="03") echo "selected='selected'"; ?> >Marzo</option>
                            <option value = "04" <?php if ($registroUsuario['fechaNacimiento']->format('m')=="04") echo "selected='selected'"; ?> >Abril</option>
                            <option value = "05" <?php if ($registroUsuario['fechaNacimiento']->format('m')=="05") echo "selected='selected'"; ?> >Mayo</option>
                            <option value = "06" <?php if ($registroUsuario['fechaNacimiento']->format('m')=="06") echo "selected='selected'"; ?> >Junio</option>
                            <option value = "07" <?php if ($registroUsuario['fechaNacimiento']->format('m')=="07") echo "selected='selected'"; ?> >Julio</option>
                            <option value = "08" <?php if ($registroUsuario['fechaNacimiento']->format('m')=="08") echo "selected='selected'"; ?> >Agosto</option>
                            <option value = "09" <?php if ($registroUsuario['fechaNacimiento']->format('m')=="09") echo "selected='selected'"; ?> >Septiembre</option>
                            <option value = "10" <?php if ($registroUsuario['fechaNacimiento']->format('m')=="10") echo "selected='selected'"; ?> >Octubre</option>
                            <option value = "11" <?php if ($registroUsuario['fechaNacimiento']->format('m')=="11") echo "selected='selected'"; ?> >Noviembre</option>
                            <option value = "12" <?php if ($registroUsuario['fechaNacimiento']->format('m')=="12") echo "selected='selected'"; ?> >Diciembre</option>
                          	</optgroup>
                          	</select>
            	              	
                        	<select id="select_anio" <?php if(isset($errores["fechaNacimiento"])) echo 'class="error"'?> name="anio">
            	            <optgroup label="Año">
            	              	<?php
            	              	for ($i=date('Y')-3; $i > date('Y')-99 ; $i--) { 
            						echo "<option ";
            						if ($registroUsuario['fechaNacimiento']->format('Y') == $i ) echo "selected='selected'";
            						echo ">$i</option>";
            				  	}
            					?>
                          	</optgroup>
                          	</select>
                        </div>
                        <?php if(isset($errores["fechaNacimiento"])) echo '<span class="error">'.$errores["fechaNacimiento"]."</span>"?>
                  	</div>
                   	<div id="div_direccion" class="lineaFormulario">
                		<label id="label_direccion" for="input_direccion">Dirección:</label>
                    	<input id="input_direccion" class="box <?php if(isset($errores["direccion"])) echo "error"?>" name="direccion" value="<?php echo $registroUsuario['direccion'] ?>" type="text"/>
                        <?php if(isset($errores["direccion"])) echo '<span class="error">'.$errores["direccion"].'</span>'?>  
                  	</div>
                    <div id="div_email" class="lineaFormulario">  
                      	<label id="label_email" for="input_email">Email:</label>
                      	<input id="input_email" class="box <?php if(isset($errores["email"])) echo "error"?>" name="email" value="<?php echo $registroUsuario['email'] ?>" type="email"/>
                    </div>
                    <div id="div_telefono" class="lineaFormulario">  
                      	<label id="label_telefono" for="input_telefono">Teléfono:</label>
                      	<input id="input_telefono" class="box <?php if(isset($errores["telefono"])) echo "error"?>" name="telefono" value="<?php echo $registroUsuario['telefono'] ?>" type="tel" pattern="\d{9}"/>
                    </div>
                    <div id="div_checkboxsUsuarios" class="lineaFormulario">
                    	<label id="label_derechosImagen" for="input_derechosImagen">Cede los derechos de imagen</label>
                  		<input id="input_derechosImagen" name="derechosImagen" <?php if(isset($registroUsuario['derechosImagen'])) echo 'checked' ?> type="checkbox"/>   
                        <label id="label_checkResponsable" for="input_checkResponsable">Vincular responsable</label>
                        <input id="input_checkResponsable" name="checkResponsable" onclick="toggleResponsables()" <?php if(isset($registroUsuario['checkResponsable'])) echo "checked='checked'" ?> type="checkbox"/>
                  	</div>
                    <div id="div_responsable" class="lineaFormulario">
                        <label id="label_responsable" for="select_responsable">Responsable</label>
                    	<select id="select_responsable" <?php if(isset($errores["responsable"])) echo 'class="error"'?> name="responsable" <?php if(!isset($registroUsuario['checkResponsable'])) echo 'disabled' ?>>
                    	    <option>--Responsable--</option>
        	              	<?php
        	              	$responsables = listaResponsables($conexion);
        	              	foreach ($responsables as $responsable) { 
        						echo "<option value='".$responsable['OID_R']."' ";
        						if ($registroUsuario['responsable'] == $responsable['OID_R'] ) echo "selected='selected'";
        						echo ">";
        						echo $responsable['NOMBRE']." ".$responsable['APELLIDOS']."</option>";
        				  	}
        					?>
                      	</select>
                      	<span class="error"><?php if(isset($errores["responsable"])) echo $errores["responsable"]?></span>
                    </div>
                    <div id="div_tipoRelación" class="lineaFormulario">
                        <label id="label_tipoRelación" for="input_tipoRelación">Tipo de relación:</label>
                        <input id="input_tipoRelación" class="box <?php if(isset($errores["tipoRelacion"])) echo "error"?>" name="tipoRelacion" type="text"
                        value="<?php echo $registroUsuario['tipoRelacion']?>"  <?php if(!isset($registroUsuario['checkResponsable'])) echo 'disabled' ?>/>
                        <?php if(isset($errores["tipoRelacion"])) echo '<span class="error">'.$errores["tipoRelacion"].'</span>'?>
                    </div>
                    <?php if(isset($registroUsuario["oid_u"])) { ?>
                    <input type="hidden" name="oid_u" value="<?php echo $registroUsuario["oid_u"] ?>"/>
                    <?php } ?>
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