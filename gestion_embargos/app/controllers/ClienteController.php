<?php
require_once __DIR__ . '/../models/Cliente.php';

class ClienteController {
    private $conn;

    public function __construct() {
        require_once '../../config/database.php';
        $this->conn = $GLOBALS['conn'];
    }

    public function crearCliente($data) {
        $cliente = new Cliente($data['numero_identificacion'], $data['nombre'], $data['direccion'], $data['contacto'], $data['historial_embargos'], $data['historial_creditos']);
        $sql = "INSERT INTO clientes (numero_identificacion, nombre, direccion, contacto, historial_embargos, historial_creditos)
                VALUES ('$cliente->numero_identificacion', '$cliente->nombre', '$cliente->direccion', '$cliente->contacto', '$cliente->historial_embargos', '$cliente->historial_creditos')";
        
        if ($this->conn->query($sql) === TRUE) {
            echo "Cliente creado exitosamente.";
        } else {
            echo "Error al crear cliente: " . $this->conn->error;
        }
    }

    public function actualizarCliente($data) {
        $cliente = new Cliente($data['numero_identificacion'], $data['nombre'], $data['direccion'], $data['contacto'], $data['historial_embargos'], $data['historial_creditos']);
        $sql = "UPDATE clientes SET nombre='$cliente->nombre', direccion='$cliente->direccion', contacto='$cliente->contacto', 
                historial_embargos='$cliente->historial_embargos', historial_creditos='$cliente->historial_creditos' 
                WHERE numero_identificacion='$cliente->numero_identificacion'";
        
        if ($this->conn->query($sql) === TRUE) {
            echo "Cliente actualizado exitosamente.";
        } else {
            echo "Error al actualizar cliente: " . $this->conn->error;
        }
    }

    public function eliminarCliente($numero_identificacion) {
        $sql = "DELETE FROM clientes WHERE numero_identificacion='$numero_identificacion'";
        
        if ($this->conn->query($sql) === TRUE) {
            echo "Cliente eliminado exitosamente.";
        } else {
            echo "Error al eliminar cliente: " . $this->conn->error;
        }
    }

    public function buscarClientePorIdentificacion($numero_identificacion) {
        $sql = "SELECT * FROM clientes WHERE numero_identificacion='$numero_identificacion'";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerTodosLosClientes() {
        $sql = "SELECT * FROM clientes";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
