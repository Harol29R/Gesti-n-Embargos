<?php
session_start();

if (!isset($_SESSION['nombre_usuario'])) {
    header("Location: ../auth/login.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control</title>
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
        <h2>Bienvenido al Panel de Control</h2>
        <p>Gestiona todos los aspectos de tu negocio de manera sencilla.</p>

        <div class="content-section">
            <h3>Secciones Rápidas</h3>
            <div class="icon-container">
                <div class="icon-item">
                    <img src="https://img.icons8.com/?size=100&id=23265&format=png&color=000000" alt="Clientes" class="icon-image">
                    <p>Clientes</p>
                </div>
                <div class="icon-item">
                    <img src="https://img.icons8.com/?size=100&id=61580&format=png&color=000000" alt="Vehículos" class="icon-image">
                    <p>Vehículos</p>
                </div>
                <div class="icon-item">
                    <img src="https://img.icons8.com/?size=100&id=61747&format=png&color=000000" alt="Créditos" class="icon-image">
                    <p>Créditos</p>
                </div>
                <div class="icon-item">
                    <img src="https://img.icons8.com/?size=100&id=12484&format=png&color=000000" alt="Alertas" class="icon-image">
                    <p>Alertas</p>
                </div>
                <div class="icon-item">
                    <img src="https://img.icons8.com/?size=100&id=70640&format=png&color=000000" alt="Ventas" class="icon-image">
                    <p>Ventas</p>
                </div>
                <div class="icon-item">
                    <img src="https://img.icons8.com/?size=100&id=2vOKg62yPJOz&format=png&color=000000" alt="Pagos" class="icon-image">
                    <p>Pagos</p>
                </div>
            </div>
        </div>

        <div class="content-section">
            <h3>¿Quiénes Somos?</h3>
            <p>Somos una empresa dedicada a ofrecer soluciones efectivas en créditos y embargos.</p>
        </div>

        <div class="content-section">
            <h3>Imágenes Relacionadas</h3>
            <div class="image-gallery">
                <img src="cliente,png.png" alt="Imagen de Vehículo" class="gallery-image">
                <img src="credito.png.png" alt="Imagen de Cliente" class="gallery-image">
                <img src="vehiculos.png.jpg" alt="Imagen de Proceso de Crédito" class="gallery-image">
            </div>
        </div>
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
