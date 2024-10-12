<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'gestion_embargos';
$port = '3306';

$conn = new mysqli($host, $user, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
