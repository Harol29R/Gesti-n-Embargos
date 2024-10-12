<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/controllers/AlertaController.php';

$alertaController = new AlertaController($conn);

session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['nombre_usuario'])) {
    header("Location: ../auth/login.php"); 
    exit();
}

// Manejando el formulario de creación de alertas
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['crear_alerta'])) {
        $descripcion = $_POST['descripcion'];
        $fecha_alerta = $_POST['fecha_alerta'];
        $estado_alerta = $_POST['estado_alerta'];
        $id_credito = $_POST['id_credito'];

        $alertaController->crearAlerta($descripcion, $fecha_alerta, $estado_alerta, $id_credito);
    }
}

// Manejando la actualización de alertas
if (isset($_POST['actualizar_alerta'])) {
    $id_alerta = $_POST['id_alerta'];
    $descripcion = $_POST['descripcion'];
    $fecha_alerta = $_POST['fecha_alerta'];
    $estado_alerta = $_POST['estado_alerta'];

    $alertaController->actualizarAlerta($id_alerta, $descripcion, $fecha_alerta, $estado_alerta);
}

// Manejando la eliminación de alertas
if (isset($_POST['eliminar_alerta'])) {
    $id_alerta = $_POST['id_alerta'];
    $alertaController->eliminarAlerta($id_alerta);
}

// Obtener todas las alertas
$alertas = $alertaController->obtenerAlertas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Alertas</title>
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
        <h1>Gestión de Alertas</h1>

        <form method="POST">
            <label for="descripcion">Descripción:</label>
            <input type="text" name="descripcion" required><br>

            <label for="fecha_alerta">Fecha de Alerta:</label>
            <input type="date" name="fecha_alerta" required><br>

            <label for="estado_alerta">Estado de Alerta:</label>
            <select name="estado_alerta" required>
                <option value="Pendiente">Pendiente</option>
                <option value="Vencida">Vencida</option>
                <option value="Resuelta">Resuelta</option>
            </select><br>

            <label for="id_credito">ID de Crédito:</label>
            <input type="number" name="id_credito" required><br>

            <button type="submit" name="crear_alerta">Agregar nueva alerta</button>
        </form>

        <h2>Lista de Alertas</h2>
        <table>
            <tr>
                <th>ID Alerta</th>
                <th>Descripción</th>
                <th>Fecha de Alerta</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>

            <?php foreach ($alertas as $alerta): ?>
            <tr>
                <td><?php echo $alerta['id_alerta']; ?></td>
                <td><?php echo $alerta['descripcion']; ?></td>
                <td><?php echo $alerta['fecha_alerta']; ?></td>
                <td><?php echo $alerta['estado_alerta']; ?></td>
                <td>
                    <form method="POST" style="display:inline-block;">
                        <input type="hidden" name="id_alerta" value="<?php echo $alerta['id_alerta']; ?>">
                        <input type="text" name="descripcion" value="<?php echo $alerta['descripcion']; ?>" required>
                        <input type="date" name="fecha_alerta" value="<?php echo $alerta['fecha_alerta']; ?>" required>
                        <select name="estado_alerta">
                            <option value="Pendiente" <?php if ($alerta['estado_alerta'] === 'Pendiente') echo 'selected'; ?>>Pendiente</option>
                            <option value="Vencida" <?php if ($alerta['estado_alerta'] === 'Vencida') echo 'selected'; ?>>Vencida</option>
                            <option value="Resuelta" <?php if ($alerta['estado_alerta'] === 'Resuelta') echo 'selected'; ?>>Resuelta</option>
                        </select>
                        <button type="submit" name="actualizar_alerta">Actualizar</button>
                    </form>

                    <form method="POST" style="display:inline-block;">
                        <input type="hidden" name="id_alerta" value="<?php echo $alerta['id_alerta']; ?>">
                        <button type="submit" name="eliminar_alerta">Eliminar</button>
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
