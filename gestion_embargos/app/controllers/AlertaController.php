<?php
require_once __DIR__ . '/../models/Alerta.php';

class AlertaController {
    private $alerta;

    public function __construct($conn) {
        $this->alerta = new Alerta($conn);
    }

    // Obtener alertas
    public function obtenerAlertas() {
        return $this->alerta->obtenerAlertas();
    }

    // Crear alerta
    public function crearAlerta($descripcion, $fecha_alerta, $estado_alerta, $id_credito) {
        return $this->alerta->crearAlerta($descripcion, $fecha_alerta, $estado_alerta, $id_credito);
    }

    // Actualizar alerta
    public function actualizarAlerta($id_alerta, $descripcion, $fecha_alerta, $estado_alerta) {
        return $this->alerta->actualizarAlerta($id_alerta, $descripcion, $fecha_alerta, $estado_alerta);
    }

    // Eliminar alerta
    public function eliminarAlerta($id_alerta) {
        return $this->alerta->eliminarAlerta($id_alerta);
    }
}
?>
