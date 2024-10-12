<?php
require_once __DIR__ . '/../models/Embargo.php'; 
require_once __DIR__ . '/../../config/database.php'; 

class EmbargoController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function obtenerNotificaciones() {
        $embargo = new Embargo($this->conn);
        return $embargo->obtenerNotificaciones();
    }

    public function agregarNotificacion($fecha_notificacion, $descripcion, $numero_identificacion, $matricula) {
        $embargo = new Embargo($this->conn);
        $embargo->agregarNotificacion($fecha_notificacion, $descripcion, $numero_identificacion, $matricula);
    }

    public function actualizarNotificacion($id_notificacion, $fecha_notificacion, $descripcion, $numero_identificacion, $matricula) {
        $embargo = new Embargo($this->conn);
        $embargo->actualizarNotificacion($id_notificacion, $fecha_notificacion, $descripcion, $numero_identificacion, $matricula);
    }

    public function eliminarNotificacion($id_notificacion) {
        $embargo = new Embargo($this->conn);
        $embargo->eliminarNotificacion($id_notificacion);
    }
}
