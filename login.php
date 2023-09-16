<?php
session_start();
include("includes/conexion.php");
include("js/java_login.js");

$rut = $_POST["rut"]; // Obtén el valor del campo "rut" del formulario
$password = md5($_POST["pass"]);

// Consulta SQL para seleccionar un usuario por su rut
$sql = "SELECT * FROM usuarios WHERE rut = '$rut'";
$resultado = mysqli_query($conexion, $sql);

if ($resultado) {
    $row = mysqli_fetch_assoc($resultado);
    $stored_rut = $row['rut']; // Cambia la variable para almacenar el valor del rut
    $stored_password = $row['password'];
    $rol_db = $row['rol'];

    // Compara el rut en la base de datos con el valor proporcionado en el formulario
    if ($rut == $stored_rut && $password == $stored_password) {
        $_SESSION['usuario'] = $row['user']; // Almacena el nombre de usuario en la sesión
        $_SESSION['apellido'] = $row['apellido']; // Almacena el apellido en la sesión
        $_SESSION['rol'] = $rol_db; // Obtener el rol desde la base de datos

        // Resto del código sigue igual
        if ($rol_db == 1) {
            header('location: vista/administrador.php'); // Admin va a panel.php
        } elseif ($rol_db == 2) {
            header('location: vista/instructor.php'); // User va a user.php
        }
    } else {
        $_SESSION['error_message'] = "No puedes ingresar";
        header('location: index.php'); // Redirige de nuevo a la página de inicio de sesión (index.php)
        exit();
    }
}
?>









