<?php
class Usuario {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }
}
?>
