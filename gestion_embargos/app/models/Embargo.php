<?php
class Embargo {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function obtenerNotificaciones() {
        $sql = "SELECT * FROM notificacionesembargo";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function agregarNotificacion($fecha_notificacion, $descripcion, $numero_identificacion, $matricula) {
        $stmt = $this->conn->prepare("INSERT INTO notificacionesembargo (fecha_notificacion, descripcion, numero_identificacion, matricula) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $fecha_notificacion, $descripcion, $numero_identificacion, $matricula);
        $stmt->execute();
    }

    public function actualizarNotificacion($id_notificacion, $fecha_notificacion, $descripcion, $numero_identificacion, $matricula) {
        $stmt = $this->conn->prepare("UPDATE notificacionesembargo SET fecha_notificacion = ?, descripcion = ?, numero_identificacion = ?, matricula = ? WHERE id_notificacion = ?");
        $stmt->bind_param('ssssi', $fecha_notificacion, $descripcion, $numero_identificacion, $matricula, $id_notificacion);
        $stmt->execute();
    }

    public function eliminarNotificacion($id_notificacion) {
        $stmt = $this->conn->prepare("DELETE FROM notificacionesembargo WHERE id_notificacion = ?");
        $stmt->bind_param('i', $id_notificacion);
        $stmt->execute();
    }
}
