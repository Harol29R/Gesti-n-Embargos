<?php
require_once __DIR__ . '../../models/Vehiculo.php';

class VehiculoController {
    private $conn;

    public function __construct() {
        require_once '../../config/database.php';
        $this->conn = $GLOBALS['conn'];
    }

    public function crearVehiculo($data) {
        // Comprobar si la matrícula ya existe
        $matricula = $data['matricula'];
        $checkSql = "SELECT * FROM vehiculos WHERE matricula='$matricula'";
        $checkResult = $this->conn->query($checkSql);

        if ($checkResult->num_rows > 0) {
            echo "Error: La matrícula ya existe.";
            return;
        }

        $vehiculo = new Vehiculo($data['matricula'], $data['marca'], $data['modelo'], $data['ano'], $data['estado'], $data['numero_identificacion']);
        $sql = "INSERT INTO vehiculos (matricula, marca, modelo, ano, estado, numero_identificacion)
                VALUES ('$vehiculo->matricula', '$vehiculo->marca', '$vehiculo->modelo', '$vehiculo->ano', '$vehiculo->estado', '$vehiculo->numero_identificacion')";

        if ($this->conn->query($sql) === TRUE) {
            echo "Vehículo creado exitosamente.";
        } else {
            echo "Error al crear vehículo: " . $this->conn->error;
        }
    }

    public function actualizarVehiculo($data) {
        $vehiculo = new Vehiculo($data['matricula'], $data['marca'], $data['modelo'], $data['ano'], $data['estado'], $data['numero_identificacion']);
        $sql = "UPDATE vehiculos SET marca='$vehiculo->marca', modelo='$vehiculo->modelo', ano='$vehiculo->ano', estado='$vehiculo->estado', numero_identificacion='$vehiculo->numero_identificacion' 
                WHERE matricula='$vehiculo->matricula'";

        if ($this->conn->query($sql) === TRUE) {
            echo "Vehículo actualizado exitosamente.";
        } else {
            echo "Error al actualizar vehículo: " . $this->conn->error;
        }
    }

    public function eliminarVehiculo($matricula) {
        $sql = "DELETE FROM vehiculos WHERE matricula='$matricula'";

        if ($this->conn->query($sql) === TRUE) {
            echo "Vehículo eliminado exitosamente.";
        } else {
            echo "Error al eliminar vehículo: " . $this->conn->error;
        }
    }

    public function obtenerTodosLosVehiculos() {
        $sql = "SELECT * FROM vehiculos";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function buscarVehiculoPorMatricula($matricula) {
        $sql = "SELECT * FROM vehiculos WHERE matricula='$matricula'";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc();
    }

    public function obtenerClientes() {
        $sql = "SELECT numero_identificacion, nombre FROM clientes";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
