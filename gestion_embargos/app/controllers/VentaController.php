<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Venta.php';

class VentaController {

    // Registrar venta
    public function registrar() {
        if (isset($_POST['registrar'])) {
            $matricula = $_POST['matricula'];
            $precio_venta = $_POST['precio_venta'];
            $comprador = $_POST['comprador'];
            $estado_venta = $_POST['estado_venta'];
            $fecha_venta = $_POST['fecha_venta'];

            $venta = new Venta();
            $venta->registrarVenta($matricula, $precio_venta, $comprador, $estado_venta, $fecha_venta);

            header("Location: /gestion_embargos/public/ventas/gestion_ventas.php");
            exit;
        }
    }

    // Actualizar venta
    public function actualizar() {
        if (isset($_POST['actualizar'])) {
            $id_venta = $_POST['id_venta'];
            $matricula = $_POST['matricula'];
            $precio_venta = $_POST['precio_venta'];
            $comprador = $_POST['comprador'];
            $estado_venta = $_POST['estado_venta'];
            $fecha_venta = $_POST['fecha_venta'];

            $venta = new Venta();
            $venta->actualizarVenta($id_venta, $matricula, $precio_venta, $comprador, $estado_venta, $fecha_venta);

            header("Location: /gestion_embargos/public/ventas/gestion_ventas.php");
            exit;
        }
    }

    // Eliminar venta
    public function eliminar() {
        if (isset($_POST['eliminar'])) {
            $id_venta = $_POST['id_venta'];

            $venta = new Venta();
            $venta->eliminarVenta($id_venta);

            header("Location: /gestion_embargos/public/ventas/gestion_ventas.php");
            exit;
        }
    }

    // Obtener lista de ventas
    public function obtenerVentas() {
        $venta = new Venta();
        return $venta->obtenerVentas();
    }
}
