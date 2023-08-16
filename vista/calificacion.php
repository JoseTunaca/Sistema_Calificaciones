<?php 
session_start();
include '../includes/navbar.php';

$name = $_SESSION['usuario'];
$rol_db = $_SESSION['rol']; // Obtener el rol desde la sesión

// Para no ingresar al panel de forma local.
if (!isset($_SESSION['usuario'])) {
    header('location: index.html');
    exit();
}
?> <!-- Incluir la barra de navegación -->


<!DOCTYPE html>
<html>
<head>
    <title>Calificación</title>
   
</head>
<body>

<h1>Página para realizar  Calificación</h1>

</body>
</html>
