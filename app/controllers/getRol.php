<?php
session_start();
require_once __DIR__ . "/../../config/database.php";

$id = $_SESSION['id_usuario'];

$stmt = $mysqli->prepare("SELECT rol FROM usuarios WHERE id_usuario = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$data = $result->fetch_assoc();

echo json_encode($data);
?>
