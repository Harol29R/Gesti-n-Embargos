<?php
require_once __DIR__ . '/../models/Usuario.php';

class AuthController {
    private $conn;

    public function __construct() {
        require_once '../../config/database.php';
        $this->conn = $GLOBALS['conn'];
    }

    public function register($data) {
        $nombre = $data['nombre'];
        $apellido = $data['apellido'];
        $correo_electronico = $data['correo_electronico'];
        $nombre_usuario = $data['nombre_usuario'];
        $contraseña = $data['contraseña'];
        $confirmar_contraseña = $data['confirmar_contraseña'];

        // Validar que las contraseñas coincidan
        if ($contraseña !== $confirmar_contraseña) {
            echo "Las contraseñas no coinciden.";
            exit;
        }

        // Encriptar la contraseña
        $contraseña_encriptada = password_hash($contraseña, PASSWORD_BCRYPT);

        // Insertar el nuevo usuario en la base de datos
        $sql = "INSERT INTO Usuarios (nombre, apellido, correo_electronico, nombre_usuario, contraseña) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssss", $nombre, $apellido, $correo_electronico, $nombre_usuario, $contraseña_encriptada);

        if ($stmt->execute()) {
            echo "Registro exitoso.";
            header("Location: ../dashboard/dashboard.php"); 
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    public function login($data) {
        $nombre_usuario = $data['nombre_usuario'];
        $contraseña = $data['contraseña'];

        // Consulta para verificar el usuario
        $sql = "SELECT contraseña FROM Usuarios WHERE nombre_usuario = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $nombre_usuario);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($contraseña_encriptada);
            $stmt->fetch();

            // Verificar la contraseña
            if (password_verify($contraseña, $contraseña_encriptada)) {
                echo "Inicio de sesión exitoso.";
                // Almacenar el nombre del usuario en la sesión
                $_SESSION['nombre_usuario'] = $nombre_usuario;
                header("Location: ../dashboard/dashboard.php");
                exit;
            } else {
                echo "Contraseña incorrecta.";
            }
        } else {
            echo "Nombre de usuario no encontrado.";
        }

        $stmt->close();
        $this->conn->close();
    }
}
?>
