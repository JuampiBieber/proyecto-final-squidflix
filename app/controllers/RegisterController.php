<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $accion   = $_POST['accion'] ?? '';
    $nombre   = trim($_POST['nombre'] ?? '');
    $correo   = trim($_POST['correo'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!$correo || !$password || ($accion === 'register' && !$nombre)) {
        header("Location: /proyecto-final-main/app/views/PANTALLA.php?error=" . urlencode("Faltan datos"));
        exit;
    }

    if ($accion === 'register') {

        $stmt = $mysqli->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows > 0) {
            header("Location: /proyecto-final-main/app/views/PANTALLA.php?error=" . urlencode("El correo ya está registrado"));
            exit;
        }

        $passHash = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $mysqli->prepare("
            INSERT INTO usuarios (nombre, email, password)
            VALUES (?, ?, ?)
        ");
        $stmt->bind_param("sss", $nombre, $correo, $passHash);
        $stmt->execute();

        if ($stmt->affected_rows <= 0) {
            $stmt->close();
            header("Location: /proyecto-final-main/app/views/PANTALLA.php?error=" . urlencode("Error al registrar usuario"));
            exit;
        }

        $idUsuario = $mysqli->insert_id;
        $stmt->close();

        $stmtPerfil = $mysqli->prepare("
            INSERT INTO perfiles (id_usuario, nombre)
            VALUES (?, ?)
        ");
        $nombrePerfil = 'Perfil principal';
        $stmtPerfil->bind_param("is", $idUsuario, $nombrePerfil);
        $stmtPerfil->execute();
        $stmtPerfil->close();

        header("Location: /proyecto-final-main/app/views/PANTALLA.php?success=" . urlencode("Registro exitoso"));
        exit;
    }
    if ($accion === 'login') {

        $stmt = $mysqli->prepare("
            SELECT id_usuario, password 
            FROM usuarios 
            WHERE email = ?
        ");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if (!$user || !password_verify($password, $user['password'])) {
            header("Location: /proyecto-final-main/app/views/PANTALLA.php?error=" . urlencode("Correo o contraseña incorrectos"));
            exit;
        }

        $_SESSION['id_usuario'] = $user['id_usuario'];

        $stmtPerfil = $mysqli->prepare("
            SELECT id_perfil 
            FROM perfiles 
            WHERE id_usuario = ?
        ");
        $stmtPerfil->bind_param("i", $user['id_usuario']);
        $stmtPerfil->execute();
        $resultPerfil = $stmtPerfil->get_result();
        $perfil = $resultPerfil->fetch_assoc();
        $stmtPerfil->close();

        $_SESSION['id_perfil'] = $perfil['id_perfil'];

        header("Location: /proyecto-final-main/app/views/PERFILES.php");
        exit;
    }
}

