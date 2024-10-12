<?php

require_once __DIR__ . '/../models/Pago.php';

class PagoController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function obtenerPagos() {
        $pagoModel = new Pago($this->conn);
        return $pagoModel->obtenerPagos();
    }

    public function registrarPago($id_credito, $monto_pagado, $fecha_pago) {
        $pagoModel = new Pago($this->conn);
        $pagoModel->registrarPago($id_credito, $monto_pagado, $fecha_pago);
    }

    public function actualizarPago($id_pago, $monto_pagado, $fecha_pago) {
        $pagoModel = new Pago($this->conn);
        $pagoModel->actualizarPago($id_pago, $monto_pagado, $fecha_pago);
    }

    public function eliminarPago($id_pago) {
        $pagoModel = new Pago($this->conn);
        $pagoModel->eliminarPago($id_pago);
    }
}
?>



