<?php 
session_start();
include '../includes/navbar.php';

$name = $_SESSION['usuario'];
$apellido =$_SESSION['apellido'];
$rol_db = $_SESSION['rol']; // Obtener el rol desde la sesión

// Para no ingresar al panel de forma local.
if (!isset($_SESSION['usuario'])) {
    header('location: index.html');
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Administrador</title>
    <!-- <link rel="stylesheet" type="text/css" href="style.css"> -->
</head>
<body>
    <div class="image-container" style="text-align: center;">
        <?php
        if ($rol_db == 1) { // Rol Admin
            echo "<h1>Bienvenido $name $apellido (Administrador) </h1>";
        } elseif ($rol_db == 2) { // Rol User
            echo "<h1>Acceso como Instructor</h1>";
        }

        // Imprimir el valor del rol para depuración
       // echo "Rol: $rol_db";
        ?>
        
        <img src="../imagenes/pillan3.jpg" alt="Imagen centrada">
    </div>
</body>
</html>






