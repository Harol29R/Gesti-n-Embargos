<?php
require_once '../../config/database.php'; 
require_once '../../app/controllers/ClienteController.php'; 

$clienteController = new ClienteController($conn);

session_start();

if (!isset($_SESSION['nombre_usuario'])) {
    header("Location: ../auth/login.php"); 
    exit();
}

if (isset($_POST['crear'])) {
    $clienteController->crearCliente($_POST);
}

if (isset($_POST['actualizar'])) {
    $clienteController->actualizarCliente($_POST);
}

if (isset($_GET['eliminar'])) {
    $clienteController->eliminarCliente($_GET['numero_identificacion']);
}

$clientes = [];
if (isset($_GET['buscar']) && !empty($_GET['numero_identificacion'])) {
    $clientes = $clienteController->buscarClientePorIdentificacion($_GET['numero_identificacion']);
} else {
    $clientes = $clienteController->obtenerTodosLosClientes(); 
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes</title>
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
        <h1>Gestión de Clientes</h1>

        <form method="POST" action="gestion_clientes.php">
            <label for="numero_identificacion">Número de Identificación:</label>
            <input type="text" name="numero_identificacion" id="numero_identificacion" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>" required>

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" value="<?php echo isset($_GET['nombre']) ? $_GET['nombre'] : ''; ?>">

            <label for="direccion">Dirección:</label>
            <input type="text" name="direccion" id="direccion" value="<?php echo isset($_GET['direccion']) ? $_GET['direccion'] : ''; ?>">

            <label for="contacto">Contacto:</label>
            <input type="text" name="contacto" id="contacto" value="<?php echo isset($_GET['contacto']) ? $_GET['contacto'] : ''; ?>">

            <label for="historial_embargos">Historial de Embargos:</label>
            <input type="text" name="historial_embargos" id="historial_embargos" value="<?php echo isset($_GET['historial_embargos']) ? $_GET['historial_embargos'] : ''; ?>">

            <label for="historial_creditos">Historial de Créditos:</label>
            <input type="text" name="historial_creditos" id="historial_creditos" value="<?php echo isset($_GET['historial_creditos']) ? $_GET['historial_creditos'] : ''; ?>">

            <?php if (isset($_GET['id'])): ?>
                <button type="submit" name="actualizar">Actualizar Cliente</button>
            <?php else: ?>
                <button type="submit" name="crear">Crear Cliente</button>
            <?php endif; ?>
        </form>

        <form method="GET" action="gestion_clientes.php">
            <label for="numero_identificacion">Número de Identificación:</label>
            <input type="text" name="numero_identificacion" id="numero_identificacion" value="<?php echo isset($_GET['numero_identificacion']) ? $_GET['numero_identificacion'] : ''; ?>" required>

            <button type="submit" name="buscar">Buscar</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Número de Identificación</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Contacto</th>
                    <th>Historial de Embargos</th>
                    <th>Historial de Créditos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($clientes)): ?>
                    <?php foreach ($clientes as $cliente): ?>
                        <tr>
                            <td><?php echo $cliente['numero_identificacion']; ?></td>
                            <td><?php echo $cliente['nombre']; ?></td>
                            <td><?php echo $cliente['direccion']; ?></td>
                            <td><?php echo $cliente['contacto']; ?></td>
                            <td><?php echo $cliente['historial_embargos']; ?></td>
                            <td><?php echo $cliente['historial_creditos']; ?></td>
                            <td>
                                <a href="gestion_clientes.php?id=<?php echo $cliente['numero_identificacion']; ?>&nombre=<?php echo $cliente['nombre']; ?>&direccion=<?php echo $cliente['direccion']; ?>&contacto=<?php echo $cliente['contacto']; ?>&historial_embargos=<?php echo $cliente['historial_embargos']; ?>&historial_creditos=<?php echo $cliente['historial_creditos']; ?>">Editar</a>
                                <a href="gestion_clientes.php?eliminar=1&numero_identificacion=<?php echo $cliente['numero_identificacion']; ?>">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No se encontraron clientes.</td>
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


</body>
</html>

<?php $conn->close(); ?>
