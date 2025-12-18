<?php

file_put_contents(
    __DIR__ . '/debug.txt',
    date('H:i:s') . " METHOD=" . $_SERVER['REQUEST_METHOD'] . "\n",
    FILE_APPEND
);

session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../config/database.php';

$idPerfil = $_SESSION['id_perfil'] ?? 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = json_decode(file_get_contents("php://input"), true);
    $idContenido = $data['id_contenido'] ?? null;

    if (!$idContenido) {
        echo json_encode(["error" => "id faltante"]);
        exit;
    }

    $stmt = $mysqli->prepare("
        SELECT 1 FROM mi_lista 
        WHERE id_perfil = ? AND id_contenido = ?
    ");
    $stmt->bind_param("ii", $idPerfil, $idContenido);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->close();

        $del = $mysqli->prepare("
            DELETE FROM mi_lista 
            WHERE id_perfil = ? AND id_contenido = ?
        ");
        $del->bind_param("ii", $idPerfil, $idContenido);
        $del->execute();
        $del->close();

        echo json_encode(["status" => "removed"]);
        exit;
    }

    $stmt->close();

    $ins = $mysqli->prepare("
        INSERT INTO mi_lista (id_perfil, id_contenido)
        VALUES (?, ?)
    ");
    $ins->bind_param("ii", $idPerfil, $idContenido);
    $ins->execute();
    $ins->close();

    echo json_encode(["status" => "added"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $stmt = $mysqli->prepare("
        SELECT c.id_contenido, c.titulo, c.imagen
        FROM contenido c
        INNER JOIN mi_lista ml ON c.id_contenido = ml.id_contenido
        WHERE ml.id_perfil = ?
        ORDER BY c.titulo ASC
    ");
    $stmt->bind_param("i", $idPerfil);
    $stmt->execute();
    $result = $stmt->get_result();

    $lista = [];
    while ($row = $result->fetch_assoc()) {
        $lista[] = $row;
    }

    echo json_encode($lista);
    exit;
}
