<?php

function calcularCalificacion($radios) {
    // Depura y verifica si los valores de los radios se están recibiendo correctamente
    var_dump($radios);

    // Realiza los cálculos de calificación aquí
    $porcentaje = 0; // Cambia esto a tu lógica de cálculo
    $esInseguro = false; // Cambia esto según tu lógica

    // Devuelve la calificación calculada como un objeto JSON
    $resultado = array('porcentaje' => $porcentaje, 'esInseguro' => $esInseguro);
    echo json_encode($resultado);
}

// Verifica si se recibieron datos POST para calcular la calificación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['radios'])) {
        $radios = $_POST['radios'];
        calcularCalificacion($radios);
    } else {
        // Si no se recibieron datos POST válidos, devuelve una respuesta de error
        echo json_encode(array('error' => 'No se recibieron datos POST válidos'));
    }
} else {
    // Si no es una solicitud POST, devuelve una respuesta de error
    echo json_encode(array('error' => 'Esta página solo acepta solicitudes POST'));
}
?>







