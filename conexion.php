<?php
    $host = "localhost";
    $usuario = "root";
    $clave = "root";
    $bd = "tienda";
    $conexion = mysqli_connect($host, $usuario, $clave, $bd);
    if($conexion -> connect_errno){
        die("Error de conexión ... !");
    }else{
        die("BIENVENIDO¡¡¡¡");
    }

?>