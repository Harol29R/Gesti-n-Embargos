<?php

class Alerta {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Obtener todas las alertas
    public function obtenerAlertas() {
        $sql = "SELECT * FROM alertas";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Crear nueva alerta
    public function crearAlerta($descripcion, $fecha_alerta, $estado_alerta, $id_credito) {
        $sql = "INSERT INTO alertas (descripcion, fecha_alerta, estado_alerta, id_credito) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssi", $descripcion, $fecha_alerta, $estado_alerta, $id_credito);
        return $stmt->execute();
    }

    // Actualizar alerta
    public function actualizarAlerta($id_alerta, $descripcion, $fecha_alerta, $estado_alerta) {
        $sql = "UPDATE alertas SET descripcion = ?, fecha_alerta = ?, estado_alerta = ? WHERE id_alerta = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssi", $descripcion, $fecha_alerta, $estado_alerta, $id_alerta);
        return $stmt->execute();
    }

    // Eliminar alerta
    public function eliminarAlerta($id_alerta) {
        $sql = "DELETE FROM alertas WHERE id_alerta = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_alerta);
        return $stmt->execute();
    }
}
?>
