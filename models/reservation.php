<?php

require_once "models/conexion.php";

class Reservation {

    private $conexion;
    private $result;
    private $filasAfectadas;

    public function __construct() {
        $this->conexion = new conexion();
        $this->conexion->conectar();
    }

    // 🔹 Crear una nueva reserva
    public function registrar($datos, $userEmail) {
        $nombre = $datos['nombre'];
        $apellido = $datos['apellido'];
        $fechaEntrada = $datos['fecha_entrada'];
        $fechaSalida = $datos['fecha_salida'];
        $habitacion = $datos['habitacion'];
        $personas = $datos['personas'];
        $comentarios = !empty(trim($datos['comentarios'] ?? '')) ? trim($datos['comentarios']) : '';
        $userId = $_SESSION['user']['id'];

        $sql = "INSERT INTO reservations (nombre, apellido, fecha_entrada, fecha_salida, habitacion, personas, comentarios, user_id)
                VALUES ('$nombre', '$apellido', '$fechaEntrada', '$fechaSalida', '$habitacion', '$personas', '$comentarios', '$userId')";

        $this->conexion->setUsuario($userEmail);
        $this->conexion->query($sql);
        $this->filasAfectadas = $this->conexion->getFilasAfectadas();
    }

    // 🔹 Obtener una reserva específica
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM reservations WHERE id = $id";
        $this->conexion->query($sql);
        return $this->conexion->getResult();
    }

    // 🔹 Editar una reserva
    public function editar($datos, $userEmail) {
        $id = intval($datos['id']);
        $nombre = $datos['nombre'];
        $apellido = $datos['apellido'];
        $fechaEntrada = $datos['fecha_entrada'];
        $fechaSalida = $datos['fecha_salida'];
        $habitacion = $datos['habitacion'];
        $personas = $datos['personas'];
        $comentarios = trim($datos['comentarios']);

        $sql = "UPDATE reservations 
                SET nombre='$nombre', apellido='$apellido', fecha_entrada='$fechaEntrada',
                    fecha_salida='$fechaSalida', habitacion='$habitacion',
                    personas='$personas', comentarios='$comentarios'
                WHERE id=$id";

        $this->conexion->setUsuario($userEmail);
        $this->conexion->query($sql);
        $this->filasAfectadas = $this->conexion->getFilasAfectadas();
    }

    // 🔹 Eliminar una reserva
    public function eliminar($id, $userEmail) {
        $sql = "DELETE FROM reservations WHERE id = $id";
        $this->conexion->setUsuario($userEmail);
        $this->conexion->query($sql);
        $this->filasAfectadas = $this->conexion->getFilasAfectadas();
    }

    // 🔹 Obtener todas las reservas del usuario logueado
    public function obtenerPorUsuario($userId) {
        $sql = "SELECT * FROM reservations WHERE user_id = $userId";
        $this->conexion->query($sql);
        return $this->conexion->getResult();
    }

    // 🔹 Obtener cuántas filas fueron afectadas
    public function getFilasAfectadas() {
        return $this->filasAfectadas;
    }

    // 🔹 Desconectar base de datos
    public function desconectar() {
        $this->conexion->desconectar();
    }
}
