<?php

require_once __DIR__ . '/../../app/controllers/VentaController.php';

$ventaController = new VentaController();
$ventas = $ventaController->obtenerVentas();

session_start();

if (!isset($_SESSION['nombre_usuario'])) {
    header("Location: ../auth/login.php"); 
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['registrar'])) {
        $ventaController->registrar();
    } elseif (isset($_POST['actualizar'])) {
        $ventaController->actualizar();
    } elseif (isset($_POST['eliminar'])) {
        $ventaController->eliminar();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Ventas</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        function toggleUpdateForm(id) {
            const form = document.getElementById('updateForm' + id);
            form.style.display = form.style.display === 'none' || form.style.display === '' ? 'block' : 'none';
        }
    </script>
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
        <h2 class="mt-5 text-center">Gestión de Ventas</h2>

        <form method="POST" class="mt-4">
            <div class="form-row">
                <div class="form-group">
                    <label for="matricula">Matrícula:</label>
                    <input type="text" name="matricula" required>
                </div>
                <div class="form-group">
                    <label for="precio_venta">Precio de Venta:</label>
                    <input type="number" name="precio_venta" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="comprador">Comprador:</label>
                    <input type="text" name="comprador" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="estado_venta">Estado de Venta:</label>
                    <select name="estado_venta" required>
                        <option value="En proceso">En proceso</option>
                        <option value="Completada">Completada</option>
                        <option value="Cancelada">Cancelada</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="fecha_venta">Fecha de Venta:</label>
                    <input type="date" name="fecha_venta" required>
                </div>
            </div>
            <button type="submit" name="registrar">Registrar Venta</button>
        </form>

        <h3 class="mt-5 text-center">Lista de Ventas</h3>
        <table>
            <thead>
                <tr>
                    <th>ID de Venta</th>
                    <th>Matrícula</th>
                    <th>Precio de Venta</th>
                    <th>Comprador</th>
                    <th>Estado</th>
                    <th>Fecha de Venta</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($ventas): ?>
                    <?php foreach($ventas as $venta): ?>
                        <tr>
                            <td><?php echo $venta["id_venta"]; ?></td>
                            <td><?php echo $venta["matricula"]; ?></td>
                            <td><?php echo number_format($venta["precio_venta"], 2); ?> COP</td>
                            <td><?php echo $venta["comprador"]; ?></td>
                            <td><?php echo $venta["estado_venta"]; ?></td>
                            <td><?php echo $venta["fecha_venta"]; ?></td>
                            <td>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="id_venta" value="<?php echo $venta['id_venta']; ?>">
                                    <button type="submit" name="eliminar" class="btn btn-danger">Eliminar</button>
                                </form>
                                <button type="button" class="btn btn-warning" onclick="toggleUpdateForm(<?php echo $venta['id_venta']; ?>)">Actualizar</button>

                                <div id="updateForm<?php echo $venta['id_venta']; ?>" style="display: none;">
                                    <form method="POST">
                                        <input type="hidden" name="id_venta" value="<?php echo $venta['id_venta']; ?>">
                                        <div class="form-group">
                                            <label for="matricula">Matrícula:</label>
                                            <input type="text" name="matricula" value="<?php echo $venta['matricula']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="precio_venta">Precio de Venta:</label>
                                            <input type="number" name="precio_venta" value="<?php echo $venta['precio_venta']; ?>" step="0.01" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="comprador">Comprador:</label>
                                            <input type="text" name="comprador" value="<?php echo $venta['comprador']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="estado_venta">Estado de Venta:</label>
                                            <select name="estado_venta" required>
                                                <option value="En proceso" <?php if($venta['estado_venta'] == 'En proceso') echo 'selected'; ?>>En proceso</option>
                                                <option value="Completada" <?php if($venta['estado_venta'] == 'Completada') echo 'selected'; ?>>Completada</option>
                                                <option value="Cancelada" <?php if($venta['estado_venta'] == 'Cancelada') echo 'selected'; ?>>Cancelada</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="fecha_venta">Fecha de Venta:</label>
                                            <input type="date" name="fecha_venta" value="<?php echo $venta['fecha_venta']; ?>" required>
                                        </div>
                                        <button type="submit" name="actualizar">Actualizar Venta</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">No hay ventas registradas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
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
