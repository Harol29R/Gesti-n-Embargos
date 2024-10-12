<?php
session_start();
include '../../config/database.php';
include '../../app/controllers/AuthController.php';

// Verificar si el usuario ya está autenticado
if (isset($_SESSION['nombre_usuario'])) {
    header("Location: ../dashboard/dashboard.php"); 
    exit();
}

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $authController = new AuthController();
    $authController->login($_POST);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <div class="container mt-5">
        <h2>Inicio de Sesión</h2>
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="nombre_usuario">Nombre de Usuario</label>
                <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" required>
            </div>
            <div class="form-group">
                <label for="contraseña">Contraseña</label>
                <input type="password" class="form-control" id="contraseña" name="contraseña" required>
            </div>
            <button type="submit" class="btn btn-primary">Iniciar sesión</button>
            <a href="recover_password.php" class="btn btn-link">Recuperar contraseña</a>
            <a href="register.php" class="btn btn-link">Registrarse</a>
        </form>
    </div>
</body>
</html>
