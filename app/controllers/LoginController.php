<?php
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'] ?? null;
    $password = $_POST['password'] ?? null;

    if (!$correo || !$password) {
        die("Faltan datos");
    }

    $stmt = $mysqli->prepare("SELECT id_usuario, contraseña, rol FROM usuarios WHERE correo = ?");

    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 0) {
        die("El correo no está registrado");
    }

    $usuario = $resultado->fetch_assoc();

    if (!password_verify($password, $usuario['contraseña'])) {
        die("Contraseña incorrecta");
    }

    session_start();
    $_SESSION['id_usuario'] = $usuario['id_usuario'];

    $_SESSION['rol'] = $usuario['rol'];

    header("Location: /app/views/PROYECTITO.php");
    exit;
}

