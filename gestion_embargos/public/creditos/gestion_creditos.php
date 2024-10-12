<?php
include_once '../../config/database.php';
include_once '../../app/controllers/CreditoController.php';

$creditoController = new CreditoController();

$creditos = $creditoController->listarCreditos();

session_start();

if (!isset($_SESSION['nombre_usuario'])) {
    header("Location: ../auth/login.php"); 
    exit();
}

if (isset($_POST['actualizar'])) {
    $id_credito = $_POST['id_credito'];
    $credito = $creditoController->obtenerCreditoPorId($id_credito); 
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Gestión de Créditos</title>
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
        <h1>Gestión de Créditos</h1>

        <form method="POST" action="gestion_creditos.php">
            <input type="text" name="monto" required placeholder="Monto">
            <input type="text" name="tasa_interes" required placeholder="Tasa de interés">
            <input type="number" name="plazo" required placeholder="Plazo (en meses)">
            <textarea name="condiciones" required placeholder="Condiciones"></textarea>
            <select name="estado_credito" required>
                <option value="Activo">Activo</option>
                <option value="Vencido">Vencido</option>
                <option value="Cancelado">Cancelado</option>
            </select>
            <button type="submit" name="agregar">Agregar Crédito</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Monto</th>
                    <th>Tasa de Interés</th>
                    <th>Plazo</th>
                    <th>Condiciones</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($creditos as $credito): ?>
                    <tr>
                        <td><?= $credito['id_credito'] ?></td>
                        <td><?= $credito['monto'] ?></td>
                        <td><?= $credito['tasa_interes'] ?></td>
                        <td><?= $credito['plazo'] ?></td>
                        <td><?= $credito['condiciones'] ?></td>
                        <td><?= $credito['estado_credito'] ?></td>
                        <td>
                            <form method="POST" class="form-eliminar" action="gestion_creditos.php" style="display:inline;">
                                <input type="hidden" name="id_credito" value="<?= $credito['id_credito'] ?>">
                                <button type="submit" name="eliminar">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if (isset($credito)): ?>
            <h2>Actualizar Crédito</h2>
            <form method="POST" action="gestion_creditos.php">
                <input type="hidden" name="id_credito" value="<?= $credito['id_credito'] ?>">
                <input type="text" name="monto" required value="<?= $credito['monto'] ?>" placeholder="Monto">
                <input type="text" name="tasa_interes" required value="<?= $credito['tasa_interes'] ?>" placeholder="Tasa de interés">
                <input type="number" name="plazo" required value="<?= $credito['plazo'] ?>" placeholder="Plazo (en meses)">
                <textarea name="condiciones" required placeholder="Condiciones"><?= $credito['condiciones'] ?></textarea>
                <select name="estado_credito" required>
                    <option value="Activo" <?= $credito['estado_credito'] === 'Activo' ? 'selected' : '' ?>>Activo</option>
                    <option value="Vencido" <?= $credito['estado_credito'] === 'Vencido' ? 'selected' : '' ?>>Vencido</option>
                    <option value="Cancelado" <?= $credito['estado_credito'] === 'Cancelado' ? 'selected' : '' ?>>Cancelado</option>
                </select>
                <button type="submit" name="guardar">Guardar Cambios</button>
            </form>
        <?php endif; ?>
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
