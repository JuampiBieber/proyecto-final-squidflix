<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: /proyecto-final-main/app/views/PANTALLA.php?error=" . urlencode("Debes iniciar sesión primero"));
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

$stmt = $mysqli->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
$stmt->bind_param("i", $id_usuario);
$success = $stmt->execute();
$stmt->close();

if ($success) {
    session_destroy();
    header("Location: /proyecto-final-main/app/views/PANTALLA.php?mensaje=" . urlencode("Cuenta eliminada correctamente"));
    exit;
} else {
    header("Location: /proyecto-final-main/app/views/PANTALLA.php?error=" . urlencode("No se pudo eliminar la cuenta"));
    exit;
}
