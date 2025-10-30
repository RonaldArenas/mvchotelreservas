<?php
require_once "../../models/conexion.php";
header('Content-Type: application/json; charset=utf-8');

try {
    if (!isset($_POST['type'])) {
        echo json_encode(["status" => "error", "message" => "Falta el parámetro type"]);
        exit;
    }

    $tipo = trim($_POST['type']); // Ej: 1, 2, 3 según el tipo seleccionado

    $conexion = new conexion();
    $conexion->conectar();

    // 🔹 Ajustamos para usar tu tabla 'rooms'
    $sql = "SELECT id, numero FROM rooms WHERE type = '$tipo' AND status_id = 1";
    $conexion->query($sql);
    $result = $conexion->getResult();

    $habitaciones = [];
    while ($row = $result->fetch_assoc()) {
        $habitaciones[] = [
            "id" => $row["id"],
            "numero" => $row["numero"]
        ];
    }

    echo json_encode([
        "status" => "success",
        "data" => $habitaciones
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
