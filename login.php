<?php
session_start();
include("includes/conexion.php");

$usuario = $_POST["user"];
$password = $_POST["pass"];

$sql = "SELECT * FROM usuarios WHERE user = '$usuario'";
$resultado = mysqli_query($conexion, $sql);

if ($resultado) {
    $row = mysqli_fetch_assoc($resultado);
    $usuar = $row['user'];
    $stored_password = $row['password']; // Asegúrate de que el nombre de la columna sea 'password'
    $rol_db = $row['rol'];

    if ($usuario == $usuar && $password == $stored_password) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['rol'] = $rol_db; // Obtener el rol desde la base de datos
        
        // Redirigir según el rol
        if ($rol_db == 1) {
            header('location:vista/panel.php'); // Admin va a panel.php
        } elseif ($rol_db == 2) {
            header('location:vista/user.php'); // User va a user.php
        }
    } else {
        echo "No puedes ingresar";
    }
}
?>







