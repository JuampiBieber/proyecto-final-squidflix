<?php
require_once 'Conexion.php';

class UsuarioModel {
    private $db;

    public function __construct() {
        $conexion = new Conexion();
        $this->db = $conexion->conexion;
    }

    public function existeUsuario($email) {
        $sql = "SELECT id_usuario FROM usuarios WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function registrarUsuario($nombre, $email, $password, $rol = 'usuario') {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (nombre, email, password, rol) VALUES (:nombre, :email, :password, :rol)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hash);
        $stmt->bindParam(':rol', $rol);
        $stmt->execute();
        return $this->db->lastInsertId();
    }
}
