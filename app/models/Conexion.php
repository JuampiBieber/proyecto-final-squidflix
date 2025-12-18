<?php
class Conexion {
    private $host = "localhost";
    private $puerto = "3307";
    private $bd = "plataforma_peliculas";
    private $usuario = "root";
    private $pass = "";
    public $conexion;

    public function __construct() {
        try {
            $this->conexion = new PDO(
                "mysql:host={$this->host};port={$this->puerto};dbname={$this->bd};charset=utf8mb4",
                $this->usuario,
                $this->pass
            );
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
