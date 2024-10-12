<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/gestion_embargos/config/database.php'; 
include_once $_SERVER['DOCUMENT_ROOT'] . '/gestion_embargos/app/models/Credito.php';

class CreditoController {
    private $creditoModel;
    private $conn;

    public function __construct() {
        global $conn; 
        $this->conn = $conn; 
        $this->creditoModel = new Credito($this->conn); 

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['agregar'])) {
                $this->agregarCredito();
            } elseif (isset($_POST['eliminar'])) {
                $this->eliminarCredito();
            } elseif (isset($_POST['guardar'])) { // Cambiar 'actualizar' a 'guardar'
                $this->actualizarCredito();
            }
        }
    }

    public function listarCreditos() {
        return $this->creditoModel->listarCreditos();
    }

    public function obtenerCreditoPorId($id_credito) {
        return $this->creditoModel->obtenerCreditoPorId($id_credito);
    }

    private function agregarCredito() {
        $monto = $_POST['monto'] ?? null; 
        $tasa_interes = $_POST['tasa_interes'] ?? null;
        $plazo = $_POST['plazo'] ?? null;
        $condiciones = $_POST['condiciones'] ?? null;
        $estado_credito = $_POST['estado_credito'] ?? 'Activo'; 

        if ($monto && $tasa_interes && $plazo && $condiciones) {
            $this->creditoModel->agregarCredito($monto, $tasa_interes, $plazo, $condiciones, $estado_credito);
        }
    }

    private function eliminarCredito() {
        $id_credito = $_POST['id_credito'] ?? null; 
        if ($id_credito) {
            $this->creditoModel->eliminarCredito($id_credito);
        }
    }

    private function actualizarCredito() {
        $id_credito = $_POST['id_credito'] ?? null; 
        $monto = $_POST['monto'] ?? null;
        $tasa_interes = $_POST['tasa_interes'] ?? null;
        $plazo = $_POST['plazo'] ?? null;
        $condiciones = $_POST['condiciones'] ?? null;
        $estado_credito = $_POST['estado_credito'] ?? 'Activo'; 

        if ($id_credito && $monto && $tasa_interes && $plazo && $condiciones) {
            $this->creditoModel->actualizarCredito($id_credito, $monto, $tasa_interes, $plazo, $condiciones, $estado_credito);
        }
    }
}
?>