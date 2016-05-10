<label for="buscador">Buscador</label>
<input id="buscador" name="buscador" type="text" list="suggestions" onkeyup="buscadorUsuarios()"/>
<datalist id="suggestions">
<?php
    require_once("../gestion/gestionBD.php");
    require_once("../gestion/gestionarUsuario.php");
    $conexion = crearConexionBD();
    
    $usuarios = listaUsuarios($conexion);
    foreach ($usuarios as $usuario){
        echo "<option value=".$usuario["NOMBRE"]." ".$usuario["APELLIDOS"].">";
    }
?>
</datalist>