<?php
require_once '../../config/database.php';
require_once '../../app/controllers/VehiculoController.php';

$vehiculoController = new VehiculoController($conn);
$vehiculo = null;

session_start();

if (!isset($_SESSION['nombre_usuario'])) {
    header("Location: ../auth/login.php"); 
    exit();
}

if (isset($_POST['buscar'])) {
    $matriculaBuscada = $_POST['matricula_buscar'];
    $vehiculo = $vehiculoController->buscarVehiculoPorMatricula($matriculaBuscada);
}

if (isset($_POST['crear'])) {
    $vehiculoController->crearVehiculo($_POST);
}

if (isset($_POST['actualizar'])) {
    $vehiculoController->actualizarVehiculo($_POST);
}

if (isset($_GET['eliminar'])) {
    $vehiculoController->eliminarVehiculo($_GET['matricula']);
}

$vehiculos = $vehiculoController->obtenerTodosLosVehiculos();
$clientes = $vehiculoController->obtenerClientes();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Vehículos</title>
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
        <h1>Gestión de Vehículos</h1>

        <form method="POST">
            <label for="matricula_buscar">Buscar Vehículo por Matrícula:</label>
            <input type="text" name="matricula_buscar" required>
            <button type="submit" name="buscar">Buscar</button>
        </form>

        <form method="POST">
            <label for="matricula">Matrícula:</label>
            <input type="text" name="matricula" value="<?= $vehiculo['matricula'] ?? '' ?>" required>

            <label for="marca">Marca:</label>
            <input type="text" name="marca" value="<?= $vehiculo['marca'] ?? '' ?>" required>

            <label for="modelo">Modelo:</label>
            <input type="text" name="modelo" value="<?= $vehiculo['modelo'] ?? '' ?>" required>

            <label for="ano">Año:</label>
            <input type="number" name="ano" value="<?= $vehiculo['ano'] ?? '' ?>" required>

            <label for="estado">Estado:</label>
            <select name="estado" required>
                <option value="Embargado" <?= isset($vehiculo) && $vehiculo['estado'] == 'Embargado' ? 'selected' : '' ?>>Embargado</option>
                <option value="En garantía" <?= isset($vehiculo) && $vehiculo['estado'] == 'En garantía' ? 'selected' : '' ?>>En garantía</option>
                <option value="Propiedad de la empresa" <?= isset($vehiculo) && $vehiculo['estado'] == 'Propiedad de la empresa' ? 'selected' : '' ?>>Propiedad de la empresa</option>
            </select>

            <label for="numero_identificacion">Número de Identificación del Cliente:</label>
            <select name="numero_identificacion" required>
                <?php foreach ($clientes as $cliente): ?>
                    <option value="<?= $cliente['numero_identificacion'] ?>" <?= isset($vehiculo) && $vehiculo['numero_identificacion'] == $cliente['numero_identificacion'] ? 'selected' : '' ?>>
                        <?= $cliente['nombre'] ?> (<?= $cliente['numero_identificacion'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit" name="<?= isset($vehiculo) ? 'actualizar' : 'crear' ?>">
                <?= isset($vehiculo) ? 'Actualizar' : 'Agregar nuevo vehículo' ?>
            </button>
        </form>

        <h2>Lista de Vehículos</h2>
        <table>
            <thead>
                <tr>
                    <th>Matrícula</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Año</th>
                    <th>Estado</th>
                    <th>Número de Identificación del Cliente</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vehiculos as $vehiculo): ?>
                    <tr>
                        <td><?= $vehiculo['matricula'] ?></td>
                        <td><?= $vehiculo['marca'] ?></td>
                        <td><?= $vehiculo['modelo'] ?></td>
                        <td><?= $vehiculo['ano'] ?></td>
                        <td><?= $vehiculo['estado'] ?></td>
                        <td><?= $vehiculo['numero_identificacion'] ?></td>
                        <td>
                            <a href="gestion_vehiculos.php?eliminar=true&matricula=<?= $vehiculo['matricula'] ?>">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <footer class="dashboard-footer">
        <div class="footer-content">
            <p>&copy; 2024 Sistema de Gestión de Embargos y Créditos</p>
            <div class="footer-links">
                <a href="#">Aviso Legal</a> | <a href="#">Política de Privacidad</a>
            </div>
        </div>
    </footer>
</body>
</html>
