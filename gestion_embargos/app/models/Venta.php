<?php

class Venta {

    // Método para registrar una venta
    public function registrarVenta($matricula, $precio_venta, $comprador, $estado_venta, $fecha_venta) {
        global $conn;
        $sql = "INSERT INTO ventas (matricula, precio_venta, comprador, estado_venta, fecha_venta)
                VALUES ('$matricula', '$precio_venta', '$comprador', '$estado_venta', '$fecha_venta')";
        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success'>Venta registrada exitosamente.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error al registrar la venta: " . $conn->error . "</div>";
        }
    }

    // Método para actualizar una venta
    public function actualizarVenta($id_venta, $matricula, $precio_venta, $comprador, $estado_venta, $fecha_venta) {
        global $conn;
        $sql = "UPDATE ventas SET matricula='$matricula', precio_venta='$precio_venta', comprador='$comprador', estado_venta='$estado_venta', fecha_venta='$fecha_venta' WHERE id_venta='$id_venta'";
        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success'>Venta actualizada exitosamente.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error al actualizar la venta: " . $conn->error . "</div>";
        }
    }

    // Método para eliminar una venta
    public function eliminarVenta($id_venta) {
        global $conn;
        $sql = "DELETE FROM ventas WHERE id_venta='$id_venta'";
        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success'>Venta eliminada exitosamente.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error al eliminar la venta: " . $conn->error . "</div>";
        }
    }

    // Método para obtener todas las ventas
    public function obtenerVentas() {
        global $conn;
        $sql = "SELECT * FROM ventas";
        return $conn->query($sql);
    }
}
