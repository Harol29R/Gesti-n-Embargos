<?php
require_once '../../app/controllers/EmbargoController.php'; 
require_once '../../config/database.php';

$embargoController = new EmbargoController($conn);

session_start();

if (!isset($_SESSION['nombre_usuario'])) {
    header("Location: ../auth/login.php"); 
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['agregar'])) {
        $fecha_notificacion = $_POST['fecha_notificacion'];
        $descripcion = $_POST['descripcion'];
        $numero_identificacion = $_POST['numero_identificacion'];
        $matricula = $_POST['matricula'];
        $embargoController->agregarNotificacion($fecha_notificacion, $descripcion, $numero_identificacion, $matricula);
    } elseif (isset($_POST['actualizar'])) {
        $id_notificacion = $_POST['id_notificacion'];
        $fecha_notificacion = $_POST['fecha_notificacion'];
        $descripcion = $_POST['descripcion'];
        $numero_identificacion = $_POST['numero_identificacion'];
        $matricula = $_POST['matricula'];
        $embargoController->actualizarNotificacion($id_notificacion, $fecha_notificacion, $descripcion, $numero_identificacion, $matricula);
    } elseif (isset($_POST['eliminar'])) {
        $id_notificacion = $_POST['id_notificacion'];
        $embargoController->eliminarNotificacion($id_notificacion);
    }
}

$notificaciones = $embargoController->obtenerNotificaciones();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Notificaciones de Embargo</title>
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
        <h1>Gestión de Notificaciones de Embargo</h1>

        <form method="POST" action="">
            <label for="fecha_notificacion">Fecha de Notificación:</label>
            <input type="date" name="fecha_notificacion" required><br>

            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" required></textarea><br>

            <label for="numero_identificacion">Número de Identificación del Cliente:</label>
            <input type="text" name="numero_identificacion" required><br>

            <label for="matricula">Matrícula del Vehículo:</label>
            <input type="text" name="matricula" required><br>

            <button type="submit" name="agregar">Agregar Nueva Notificación</button>
        </form>

        <h2>Lista de Notificaciones</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Descripción</th>
                <th>Número de Identificación</th>
                <th>Matrícula</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($notificaciones as $notificacion): ?>
            <tr>
                <td><?= $notificacion['id_notificacion'] ?></td>
                <td><?= $notificacion['fecha_notificacion'] ?></td>
                <td><?= $notificacion['descripcion'] ?></td>
                <td><?= $notificacion['numero_identificacion'] ?></td>
                <td><?= $notificacion['matricula'] ?></td>
                <td>
                <form method="POST" class="form-botones" style="display:inline-block;">
                    <input type="hidden" name="id_notificacion" value="<?= $notificacion['id_notificacion'] ?>">
                    <button type="submit" name="eliminar">Eliminar</button>
                </form>

                    <button onclick="llenarFormulario(<?= $notificacion['id_notificacion'] ?>)">Actualizar</button>
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
