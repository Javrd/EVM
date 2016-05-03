<?php
    require_once("../gestion/gestionBD.php");
    require_once("../gestion/gestionarUsuarios.php");
    $conexion = crearConexionBD();
    $usuarios = listaUsuarios($conexion);
    echo '<datalist id="suggestions">';
    foreach ($usuarios as $usuario){
        echo "<option value=".$usuario["NOMBRE"]." ".$usuario["APELLIDOS"].">";
    }
    echo "</datalist>";
?>