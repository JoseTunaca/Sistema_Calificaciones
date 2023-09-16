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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Usuarios</title>
    <style>
        /* Estilos para centrar la imagen y el texto */
        .image-container {
            text-align: center;
            margin-top: 50px; /* Ajusta el margen superior para centrar la imagen */
        }
    </style>
</head>
<body>
    <div class="image-container">
        <?php 
        if ($rol_db == 1) { // Rol Admin
            echo "<h1>Bienvenido señor $name $apellido (Admin)</h1>";
        } elseif ($rol_db == 2) { // Rol User
            echo "<h1>Bienvenido  $name $apellido(Instructor)</h1>";
        }

        // Imprimir el valor del rol para depuración
       // echo "Rol: $rol_db";
        ?>
    
        <img src="../imagenes/pillan2.jpg" alt="Imagen centrada">
    </div>
</body>
</html>




