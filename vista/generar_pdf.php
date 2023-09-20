<?php
require('fpdf.php');
header('Content-Type: text/html; charset=UTF-8');
include '../includes/conexion.php';

// Obtén los datos del formulario (ajusta los nombres de los campos según tu formulario)
$alumno = $_POST['alumno'];
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
$pdf->Cell(0, 10, 'Alumno: ' . $alumno, 0, 1);
$pdf->Cell(0, 10, 'Misión: ' . $mision, 0, 1);
$pdf->Cell(0, 10, 'Tiempo de Vuelo: ' . $tiempo_vuelo, 0, 1);
$pdf->Cell(0, 10, 'Fecha: ' . $fecha, 0, 1);
$pdf->Cell(0, 10, 'Calificación Final: ' . $calificacionFinal, 0, 1);

// Output the PDF (opcional: guardar en un archivo o mostrar en el navegador)
$pdf->Output();
?>
