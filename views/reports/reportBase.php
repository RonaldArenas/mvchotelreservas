<?php
// views/reports/reportBase.php

// helper: conversión segura similar a utf8_decode
function conv($text) {
    if ($text === null) return '';
    // prefer mb_convert_encoding, si no está disponible usar iconv, si no, devolver original
    if (function_exists('mb_convert_encoding')) {
        return mb_convert_encoding($text, 'ISO-8859-1', 'UTF-8');
    } elseif (function_exists('iconv')) {
        return iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $text);
    } else {
        return $text; // última opción: devolver tal cual
    }
}

// cargar FPDF (ruta relativa desde este archivo)
require_once __DIR__ . '/../../lib/fpdf/fpdf.php';

// Si el controlador ya pasó $users o $postData['users'], lo usamos.
// Puede ser un mysqli_result, un array de arrays, o un objeto iterable.
$rowsSource = null;
if (isset($users)) {
    $rowsSource = $users;
} elseif (isset($postData) && isset($postData['users'])) {
    $rowsSource = $postData['users'];
}

// Si no hay datos pasados por el controlador, hacemos la consulta directamente:
if ($rowsSource === null) {
    require_once __DIR__ . '/../../models/conexion.php';
    $c = new Conexion();
    $db = $c->conectar();

    if ($db === null) {
        // Manejo simple de error si la conexión falla
        echo "Error: no se pudo conectar a la base de datos.";
        exit;
    }

    $sql = "SELECT id, nombre, apellido, fecha_entrada, fecha_salida, habitacion, personas, comentarios FROM reservations";
    $result = $db->query($sql);

    if ($result === false) {
        echo "Error en la consulta: " . $db->error;
        exit;
    }

    // Normalizamos $rowsSource a un array para iterar fácilmente
    $rows = [];
    while ($r = $result->fetch_assoc()) {
        $rows[] = $r;
    }
} else {
    // $rowsSource viene del controlador: puede ser mysqli_result o array
    if ($rowsSource instanceof mysqli_result) {
        $rows = [];
        while ($r = $rowsSource->fetch_assoc()) {
            $rows[] = $r;
        }
    } elseif (is_array($rowsSource)) {
        // si viene como array de objetos (por ejemplo fetch_object) convertimos a arrays
        $rows = [];
        foreach ($rowsSource as $item) {
            if (is_object($item)) $rows[] = (array)$item;
            else $rows[] = $item;
        }
    } else {
        // fallback: intentar iterar
        $rows = [];
        foreach ($rowsSource as $item) {
            if (is_object($item)) $rows[] = (array)$item;
            else $rows[] = $item;
        }
    }
}

// --- Generación del PDF ---
date_default_timezone_set('America/Bogota');
$pdf = new FPDF();
$pdf->AddPage();

// logo: usar ruta absoluta si es posible
$logoPath = realpath(__DIR__ . '/../../views/img/logo_hotel.png'); // ajusta nombre si corresponde
if ($logoPath && file_exists($logoPath)) {
    // x, y, width
    $pdf->Image($logoPath, 160, 10, 35);
}

// Encabezado
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, conv('Hotel Naturaleza'), 0, 1, 'C');

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 6, conv('Ubicación: Bogotá, Colombia'), 0, 1, 'C');
$pdf->Cell(0, 6, conv('Teléfono: +57 300 123 4567'), 0, 1, 'C');
$pdf->Cell(0, 6, conv('Correo: contacto@hotelnaturaleza.com'), 0, 1, 'C');
$pdf->Ln(8);

// Título
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, conv('REPORTE DE RESERVAS'), 0, 1, 'C');
$pdf->Ln(4);

// --- Encabezados de la tabla centrados ---
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(0, 100, 0);
$pdf->SetTextColor(255, 255, 255);

// Definimos los anchos de columna (deben sumar menos de 190 aprox.)
$w = [10, 30, 30, 25, 25, 25, 15, 40];
$totalWidth = array_sum($w);
$pageWidth = 210; // ancho A4 en mm
$marginLeft = ($pageWidth - $totalWidth) / 2; // margen izquierdo calculado

$pdf->SetX($marginLeft);
$pdf->Cell($w[0], 8, conv('ID'), 1, 0, 'C', true);
$pdf->Cell($w[1], 8, conv('Nombre'), 1, 0, 'C', true);
$pdf->Cell($w[2], 8, conv('Apellido'), 1, 0, 'C', true);
$pdf->Cell($w[3], 8, conv('Entrada'), 1, 0, 'C', true);
$pdf->Cell($w[4], 8, conv('Salida'), 1, 0, 'C', true);
$pdf->Cell($w[5], 8, conv('Habitación'), 1, 0, 'C', true);
$pdf->Cell($w[6], 8, conv('Pers.'), 1, 0, 'C', true);
$pdf->Cell($w[7], 8, conv('Comentarios'), 1, 1, 'C', true);

// --- Filas de datos centradas ---
$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(0, 0, 0);

if (empty($rows)) {
    $pdf->SetX($marginLeft);
    $pdf->Cell($totalWidth, 8, conv('No hay reservas para mostrar'), 1, 1, 'C');
} else {
    foreach ($rows as $row) {
        $pdf->SetX($marginLeft);

        $id = isset($row['id']) ? $row['id'] : '';
        $nombre = isset($row['nombre']) ? conv($row['nombre']) : '';
        $apellido = isset($row['apellido']) ? conv($row['apellido']) : '';
        $entrada = isset($row['fecha_entrada']) ? $row['fecha_entrada'] : '';
        $salida = isset($row['fecha_salida']) ? $row['fecha_salida'] : '';
        $habitacion = isset($row['habitacion']) ? conv($row['habitacion']) : '';
        $personas = isset($row['personas']) ? $row['personas'] : '';
        $comentarios = isset($row['comentarios']) ? conv($row['comentarios']) : '';

        $pdf->Cell($w[0], 8, $id, 1, 0, 'C');
        $pdf->Cell($w[1], 8, $nombre, 1, 0, 'C');
        $pdf->Cell($w[2], 8, $apellido, 1, 0, 'C');
        $pdf->Cell($w[3], 8, $entrada, 1, 0, 'C');
        $pdf->Cell($w[4], 8, $salida, 1, 0, 'C');
        $pdf->Cell($w[5], 8, $habitacion, 1, 0, 'C');
        $pdf->Cell($w[6], 8, $personas, 1, 0, 'C');
        $pdf->Cell($w[7], 8, $comentarios, 1, 1, 'C');
    }
}



// Pie
$pdf->Ln(6);
$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(0, 10, conv('Reporte generado el ' . date('d/m/Y h:i A') . ' (Hora local Bogotá)'), 0, 1, 'R');


// Enviar al navegador en pestaña (I = inline)
$pdf->Output('I', 'reporte_reservas.pdf');
exit;
?>
