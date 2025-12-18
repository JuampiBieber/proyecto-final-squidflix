<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: /proyecto-final-main/app/views/PANTALLA.php?error=" . urlencode("Debes iniciar sesión primero"));
    exit;
}

require_once __DIR__ . '/../../config/database.php';

$stmt = $mysqli->prepare("SELECT nombre FROM usuarios WHERE id_usuario = ?");
$stmt->bind_param("i", $_SESSION['id_usuario']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$nombreUsuario = $user['nombre'] ?? 'Usuario';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PERFILES</title>
  <link rel="stylesheet" href="../../public/css/stylesPERFILES.css" />
  <link rel="icon" href="../../public/img/CALAMAR.png" type="image/png" />
  <style>
    .nombre-usuario {
      font-family: "Poppins", sans-serif;
      color: white;
      text-align: center;
      font-size: 1.5rem;
      margin-top: 15px;
    }
  </style>
</head>
<body>
  <a href="/proyecto-final-main/app/views/PROYECTITO.php" style="text-decoration: none;">
  <div style="text-align: center;">
    <img id="logoPERFIL_1" src="../../public/img/SCOOBY.png" class="iconos" alt="Logo" />
    <div class="nombre-usuario">
      <?php echo htmlspecialchars($nombreUsuario); ?>
    </div>
  </div>
</a>
  </div>
</body>
</html>

