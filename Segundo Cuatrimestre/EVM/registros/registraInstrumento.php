<?php
session_start();
    if(isset($_POST['nuevo'])){ // se solicita un registro de nuevo instrumento
        unset($_SESSION['registroInstrumento']); // se borra la session
    }
    if(isset($_POST['oid_i'])){ // se solicita un actualizacion de los datos ya existente de un instrumento para modificacion
            $registroInstrumento["oid_i"] = $_POST['oid_i'];
            $registroInstrumento["nombre"] = $_POST['nombre'];
            $registroInstrumento["tipo"] = $_POST['tipo'];
            $registroInstrumento["ESTADO_INSTRUMENTO"] = $_POST['ESTADO_INSTRUMENTO'];
            if ($_POST['libre']==1){
                $registroInstrumento["libre"] = $_POST['libre'];
            }
            $_SESSION["registroInstrumento"] = $registroInstrumento;
    } else{  // se inilizia las variables por defectos para nuevo instrumento
    	if (!isset($_SESSION['registroInstrumento'])){
    		$registroInstrumento["nombre"] = "";
    		$registroInstrumento["tipo"] = "--Tipo--";
    		$registroInstrumento["ESTADO_INSTRUMENTO"] = "";
            $registroInstrumento["libre"]=1;
    		$_SESSION["registroInstrumento"] = $registroInstrumento;
    	} else {
    		$registroInstrumento = $_SESSION['registroInstrumento'];
    	}
    }
	
	// Gestion de errores.
	if (isset($_SESSION['errores'])){	
		$errores = $_SESSION['errores'];
		unset($_SESSION['errores']);		
	}	
	
    require_once ("../gestion/gestionarInstrumento.php");
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
		if (isset($registroInstrumento["oid_i"])){
			echo "<title>Modificar instrumento</title>";	
		} else {
			echo "<title>Nuevo instrumento</title>";
		}
		 ?>

		<meta name="viewport" content="width=device-width; initial-scale=1.0">
        <script src="../js/evm.js"></script>
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
    	       <form action="../tratamientos/tratamientoInstrumentos.php" method="post">
    	  
                    <div id="div_nombre" class="lineaFormulario">  
                      <label id="label_nombre" for="input_nombre">Nombre:</label>
                      <input id="input_nombre" class="box <?php if(isset($errores["nombre"])) echo "error"?>" name="nombre" value="<?php echo $registroInstrumento['nombre'] ?>" type="text"/>
                      <?php if(isset($errores["nombre"])) echo '<span class="error">'.$errores["nombre"]."</span>"?>
                    </div>
        
                    <div id="div_tipo" class="lineaFormulario">
                        <label id="label_tipo" for="select_responsable">Tipo</label>
                    	<select id="select_tipo" <?php if(isset($errores["tipo"])) echo 'class="error"'?> name="tipo" >
                    	    <option value = -1 >--Tipos--</option>
        	              	<?php
        	              	$tipos = ["cuerda", "viento"];
        	              	foreach ($tipos as $tipo) { 
        						echo "<option value='".$tipo."' ";
        						if ($registroInstrumento['tipo'] == $tipo ) echo "selected='selected'";
        						echo ">";
        						echo $tipo."</option>";
        				  	}
        					?>
                      	</select>
                      	<span class="error"><?php if(isset($errores["tipo"])) echo $errores["tipo"]?></span>
                    </div>
        
        			<div id="div_estado" class="lineaFormulario">
                        <label id="label_estado" for="select_estado">Estado de instrumento
                    	<select id="select_estado" <?php if(isset($errores["ESTADO_INSTRUMENTO"])) echo 'class="error"'?> name="ESTADO_INSTRUMENTO">
                    	    <option value = -1>--Estado Instrumento--</option>
        	              	<?php
        	              	$estados = ["Nuevo","Usado","Deteriorado"];
        	              	foreach ($estados as $estado) { 
        						echo "<option value='".$estado."' ";
        						if ($registroInstrumento['ESTADO_INSTRUMENTO'] == $estado ) echo "selected='selected'";
        						echo ">";
        						echo $estado."</option>";
        				  	}
        					?>
                      	</select>
                      	<span class="error"><?php if(isset($errores["ESTADO_INSTRUMENTO"])) echo $errores["ESTADO_INSTRUMENTO"]?></span>
                    </div>

                    <div id="div_checkboxLibre" class="lineaFormulario">
                		<label id="label_libre" for="input_libre">Instrumento libre</label>
              			<input id="input_libre" name="instrumentoLibre" <?php if(isset($registroInstrumento['libre'])) echo 'checked' ?> type="checkbox"/>   
                	</div>

                    <?php if(isset($registroInstrumento["oid_i"])) { ?>
                    	<input type="hidden" name="oid_i" value="<?php echo $registroInstrumento["oid_i"] ?>"/>
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