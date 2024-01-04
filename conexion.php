<?php

function crearConexion() {
    // Cambiar en el caso en que se monte la base de datos en otro lugar
    $host = "localhost";
    $user = "luis";
    $pass = "%eYK7]E7LkaHw-M";
    $baseDatos = "pac3_daw";

    // Crear una conexión
    $conexion = new mysqli($host, $user, $pass, $baseDatos);

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Establecer el juego de caracteres a utf8
    $conexion->set_charset("utf8");

    return $conexion;
}

function cerrarConexion($conexion) {    
    $conexion->close();
}
?>
