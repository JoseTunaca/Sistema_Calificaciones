<?php
require('fpdf.php');
include '../includes/conexion.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$jsonData=file_get_contents('php://input');
// Verifica si los datos del formulario se han recibido correctamente
if (isset($_POST['alumno'], $_POST['mision'], $_POST['tiempo_vuelo'], $_POST['fecha'], $_POST['calificacionFinal'])) {
    // Obtén los datos del formulario
    $alumno_id = $_POST['alumno'];
    $mision = $_POST['mision'];
    $tiempo_vuelo = $_POST['tiempo_vuelo'];
    $fecha = $_POST['fecha'];
    $calificacionFinal = $_POST['calificacionFinal'];

    // Crear una instancia de FPDF
    $pdf = new FPDF();
    $pdf->AddPage();

    // Agregar contenido al PDF
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Calificación de Vuelo', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Alumno: ' . $alumno_id, 0, 1);
    $pdf->Cell(0, 10, 'Misión: ' . $mision, 0, 1);
    $pdf->Cell(0, 10, 'Tiempo de Vuelo: ' . $tiempo_vuelo, 0, 1);
    $pdf->Cell(0, 10, 'Fecha: ' . $fecha, 0, 1);
    $pdf->Cell(0, 10, 'Calificación Final: ' . $calificacionFinal, 0, 1);

    // Output the PDF (opcional: guardar en un archivo o mostrar en el navegador)
    $pdf->Output('D', 'd/calificaciones/calificacion.pdf');
} else {
    // Si los datos del formulario no se recibieron correctamente, muestra un mensaje de error
    echo "Error: Datos del formulario no recibidos correctamente.";
    var_dump($_POST);
}
?>


