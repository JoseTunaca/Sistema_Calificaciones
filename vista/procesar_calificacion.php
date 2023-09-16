<?php
session_start();

// Verificar si el usuario ha iniciado sesión y tiene permiso para acceder a esta página
if (!isset($_SESSION['usuario'])) {
    header('location: index.html');
    exit();
}

// Asegúrate de incluir la conexión a la base de datos y las funciones de calificación
include '../includes/conexion.php';
include '../funciones/funciones_calificacion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores del formulario
    $alumnoId = $_POST['alumno'];
    $tiempoVuelo = $_POST['tiempo_vuelo'];
    $misionId = $_POST['mision'];

    // Obtener los valores de los radios
    $radios = [];
    foreach ($_POST as $clave => $valor) {
        if (strpos($clave, 'R1_man') === 0) {
            $radios[] = $valor;
        }
    }

    // Calcular la calificación
    $resultadoCalificacion = calcularCalificacion($radios);

    // Obtener la calificación, porcentaje y si es inseguro
    $calificacion = $resultadoCalificacion['calificacion'];
    $porcentajeObtenido = $resultadoCalificacion['porcentaje'];
    $esInseguro = $resultadoCalificacion['esInseguro'];

    // Resto del código para procesar y guardar la calificación en la base de datos
    // Aquí puedes realizar las operaciones necesarias para guardar la calificación, como una inserción en la base de datos o cualquier otra acción que necesites.

    // Redireccionar a una página de éxito o mostrar un mensaje de éxito
    // Por ejemplo:
    // header('Location: calificacion_exitosa.php');
    // exit();
}

// Cierra las etiquetas PHP
?>
