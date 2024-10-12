
<?php
class Credito {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function listarCreditos() {
        $query = "SELECT * FROM creditos"; 
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $resultados = $stmt->get_result(); 
        return $resultados->fetch_all(MYSQLI_ASSOC); 
    }

    public function agregarCredito($monto, $tasa_interes, $plazo, $condiciones, $estado_credito) {
        $query = "INSERT INTO creditos (monto, tasa_interes, plazo, condiciones, estado_credito) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ddiss', $monto, $tasa_interes, $plazo, $condiciones, $estado_credito); 
        return $stmt->execute();
    }

    public function eliminarCredito($id_credito) {
        $query = "DELETE FROM creditos WHERE id_credito = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id_credito); 
        return $stmt->execute();
    }

    public function obtenerCreditoPorId($id_credito) {
        $query = "SELECT * FROM creditos WHERE id_credito = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id_credito); 
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc(); 
    }

    public function actualizarCredito($id_credito, $monto, $tasa_interes, $plazo, $condiciones, $estado_credito) {
        $query = "UPDATE creditos SET monto = ?, tasa_interes = ?, plazo = ?, condiciones = ?, estado_credito = ? WHERE id_credito = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ddissi', $monto, $tasa_interes, $plazo, $condiciones, $estado_credito, $id_credito); 
        return $stmt->execute();
    }
}
?>
