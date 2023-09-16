<?php
// Asegúrate de incluir la configuración de conexión a la base de datos aquí
include '../includes/conexion.php';

// Crear un arreglo para la respuesta
$response = array();

// Verifica si se recibieron datos mediante POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recopila los datos del formulario
    $alumno_id = $_POST['alumno'];
    $mision = $_POST['mision'];
    $tiempo_vuelo = $_POST['tiempo_vuelo'];
    $fecha = $_POST['fecha'];
    
    // Puedes agregar un echo aquí para ver los datos que estás recibiendo
    // Esto es útil para depurar y verificar los datos
    echo "Alumno ID: " . $alumno_id . "<br>";
    echo "Misión: " . $mision . "<br>";
    echo "Tiempo de Vuelo: " . $tiempo_vuelo . "<br>";
    echo "Fecha: " . $fecha . "<br>";

    // Realiza la inserción en la base de datos
    $sql = "INSERT INTO calificaciones (alumno_id, mision, tiempo_vuelo, fecha) VALUES ('$alumno_id', '$mision', '$tiempo_vuelo', '$fecha')";
    
    if (mysqli_query($conexion, $sql)) {
        $response['success'] = true;
        $response['message'] = "Calificación guardada correctamente.";
    } else {
        $response['success'] = false;
        $response['message'] = "Error al guardar la calificación: " . mysqli_error($conexion);
    }
} else {
    $response['success'] = false;
    $response['message'] = "Método de solicitud incorrecto. Debe ser POST.";
}

// Devuelve la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);
?>



