<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"> 
    <title>Recuperar Contraseña</title>
    <script>
        function mostrarAlerta() {
            alert("Se ha enviado un enlace de restablecimiento de contraseña a tu correo electrónico.");
            return false; 
        }
    </script>
</head>
<body>
    <h2>Recuperar Contraseña</h2>
    <form onsubmit="return mostrarAlerta();">
        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">Enviar Enlace de Restablecimiento</button>
    </form>
</body>
</html>
