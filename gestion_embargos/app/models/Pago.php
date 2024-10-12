<?php

class Pago {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Método para obtener todos los pagos
    public function obtenerPagos() {
        $query = "SELECT * FROM pagos";
        $result = $this->conn->query($query);
        $pagos = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $pagos[] = $row;
            }
        }
        return $pagos;
    }

    // Método para registrar un pago
    public function registrarPago($id_credito, $monto_pagado, $fecha_pago) {
        $stmt = $this->conn->prepare("INSERT INTO pagos (id_credito, monto_pagado, fecha_pago) VALUES (?, ?, ?)");
        $stmt->bind_param("ids", $id_credito, $monto_pagado, $fecha_pago);
        $stmt->execute();
    }

    // Método para actualizar un pago
    public function actualizarPago($id_pago, $monto_pagado, $fecha_pago) {
        $stmt = $this->conn->prepare("UPDATE pagos SET monto_pagado = ?, fecha_pago = ? WHERE id_pago = ?");
        $stmt->bind_param("dsi", $monto_pagado, $fecha_pago, $id_pago);
        $stmt->execute();
    }

    // Método para eliminar un pago
    public function eliminarPago($id_pago) {
        $stmt = $this->conn->prepare("DELETE FROM pagos WHERE id_pago = ?");
        $stmt->bind_param("i", $id_pago);
        $stmt->execute();
    }
}
?>

