<?php
$user = "root";
$pass = "";
$database = "tutoriales";

$conexion = new mysqli("localhost", $user, $pass, $database);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// No es necesario cerrar la conexión aquí, ya que se cerrará al final del script

?>


