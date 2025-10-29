<?php
// reportExcel.php

require_once 'C:/laragon/www/excel/vendor/autoload.php'; // ruta correcta a tu autoload

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

// Asegurarse de que $rows esté definido
if (!isset($rows) || !is_array($rows)) {
    $rows = []; // Evita errores si no hay datos
}

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Reservas');

// Encabezados
$headers = ['ID','Nombre','Apellido','Entrada','Salida','Habitación','Personas','Comentarios'];
$col = 'A';
foreach ($headers as $header) {
    $sheet->setCellValue($col.'1', $header);
    $col++;
}

// Llenar datos
$rowNum = 2;
foreach ($rows as $row) {
    $sheet->setCellValue("A{$rowNum}", $row['id'] ?? '');
    $sheet->setCellValue("B{$rowNum}", $row['nombre'] ?? '');
    $sheet->setCellValue("C{$rowNum}", $row['apellido'] ?? '');
    $sheet->setCellValue("D{$rowNum}", $row['fecha_entrada'] ?? '');
    $sheet->setCellValue("E{$rowNum}", $row['fecha_salida'] ?? '');
    $sheet->setCellValue("F{$rowNum}", $row['habitacion'] ?? '');
    $sheet->setCellValue("G{$rowNum}", $row['personas'] ?? '');
    $sheet->setCellValue("H{$rowNum}", $row['comentarios'] ?? '');
    $rowNum++;
}

// Estilo opcional: encabezado centrado y con color
$sheet->getStyle('A1:H1')->applyFromArray([
    'font' => ['bold' => true],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFDCE6F1']]
]);

// Auto ancho columnas
foreach (range('A','H') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Limpiar buffer y descargar Excel
if (ob_get_length()) ob_end_clean();
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="reporte_reservas.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
