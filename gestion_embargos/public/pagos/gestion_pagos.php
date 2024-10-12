<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/controllers/PagoController.php';

$pagoController = new PagoController($conn);

session_start();

if (!isset($_SESSION['nombre_usuario'])) {
    header("Location: ../auth/login.php"); 
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['registrar_pago'])) {
        $id_credito = $_POST['id_credito'];
        $monto_pagado = $_POST['monto_pagado'];
        $fecha_pago = $_POST['fecha_pago'];
        $pagoController->registrarPago($id_credito, $monto_pagado, $fecha_pago);
    } elseif (isset($_POST['actualizar_pago'])) {
        $id_pago = $_POST['id_pago'];
        $monto_pagado = $_POST['monto_pagado'];
        $fecha_pago = $_POST['fecha_pago'];
        $pagoController->actualizarPago($id_pago, $monto_pagado, $fecha_pago);
    } elseif (isset($_POST['eliminar_pago'])) {
        $id_pago = $_POST['id_pago'];
        $pagoController->eliminarPago($id_pago);
    }
}

$pagos = $pagoController->obtenerPagos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Pagos</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-user">
            <i class="fas fa-user-circle" aria-hidden="true"></i>
            <p><?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?></p>
        </div>
        <ul class="sidebar-list">
            <li class="sidebar-section">
                <h3 class="sidebar-title">Gestión de Activos</h3>
                <ul class="sidebar-items">
                    <li><a href="../clientes/gestion_clientes.php">Gestión de Clientes</a></li>
                    <li><a href="../vehiculos/gestion_vehiculos.php">Gestión de Vehículos</a></li>
                    <li><a href="../creditos/gestion_creditos.php">Administración de Créditos</a></li>
                </ul>
            </li>
            <li class="sidebar-section">
                <h3 class="sidebar-title">Operaciones Financieras</h3>
                <ul class="sidebar-items">
                    <li><a href="../pagos/gestion_pagos.php">Pagos</a></li>
                    <li><a href="../ventas/gestion_ventas.php">Ventas</a></li>
                </ul>
            </li>
            <li class="sidebar-section">
                <h3 class="sidebar-title">Alertas y Seguimiento</h3>
                <ul class="sidebar-items">
                    <li><a href="../alertas/gestion_alertas.php">Alertas</a></li>
                    <li><a href="../embargos/gestion_embargos.php">Embargos</a></li>
                </ul>
            </li>
            <li class="sidebar-section">
                <h3 class="sidebar-title">Acciones</h3>
                <ul class="sidebar-items">
                    <li><a href="../dashboard/dashboard.php">Regresar al inicio</a></li>
                    <li><a href="../auth/logout.php">Cerrar Sesión</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <div class="content">
        <h1>Gestión de Pagos</h1>

        <form method="POST">
            <label for="id_credito">ID Crédito:</label>
            <input type="number" name="id_credito" required><br>

            <label for="monto_pagado">Monto Pagado:</label>
            <input type="text" name="monto_pagado" required><br>

            <label for="fecha_pago">Fecha de Pago:</label>
            <input type="date" name="fecha_pago" required><br>

            <button type="submit" name="registrar_pago">Registrar Pago</button>
        </form>

        <h2>Lista de Pagos</h2>
        <table border="1">
            <tr>
                <th>ID Pago</th>
                <th>ID Crédito</th>
                <th>Monto Pagado</th>
                <th>Fecha de Pago</th>
                <th>Acciones</th>
            </tr>

            <?php foreach ($pagos as $pago): ?>
            <tr>
                <td><?php echo $pago['id_pago']; ?></td>
                <td><?php echo $pago['id_credito']; ?></td>
                <td><?php echo $pago['monto_pagado']; ?></td>
                <td><?php echo $pago['fecha_pago']; ?></td>
                <td>
                    <form method="POST" style="display: inline-block;">
                        <input type="hidden" name="id_pago" value="<?php echo $pago['id_pago']; ?>">
                        <input type="text" name="monto_pagado" value="<?php echo $pago['monto_pagado']; ?>" required>
                        <input type="date" name="fecha_pago" value="<?php echo $pago['fecha_pago']; ?>" required>
                        <button type="submit" name="actualizar_pago">Actualizar</button>
                    </form>

                    <form method="POST" style="display: inline-block;">
                        <input type="hidden" name="id_pago" value="<?php echo $pago['id_pago']; ?>">
                        <button type="submit" name="eliminar_pago">Eliminar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <footer class="dashboard-footer">
        <div class="footer-content">
            <p>&copy; 2024 Gestión de Embargos y Créditos. Todos los derechos reservados.</p>
            <div class="footer-links">
                <a href="#">Política de Privacidad</a> |
                <a href="#">Términos de Uso</a> |
                <a href="#">Contacto</a>
            </div>
        </div>
    </footer>
</body>
</html>
