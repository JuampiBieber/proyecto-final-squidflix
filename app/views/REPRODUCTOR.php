<?php
$conn = new mysqli("localhost", "root", "", "plataforma_peliculas");

if (!isset($_GET['id'])) {
    die("No se encontró el contenido.");
}

$id = intval($_GET['id']);


$queryContenido = "SELECT titulo, descripcion, imagen, tipo, nsfw 
                   FROM contenido 
                   WHERE id_contenido = $id";
$resultContenido = $conn->query($queryContenido);
$contenido = $resultContenido->fetch_assoc();

if (!$contenido) {
    die("Contenido no encontrado.");
}

$queryVideo = "SELECT url_video FROM videos WHERE id_contenido = $id";
$resultVideo = $conn->query($queryVideo);
$video = $resultVideo->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $contenido['titulo']; ?></title>

    <link rel="stylesheet" href="../../public/css/stylesREPRODUCTOR.css">
    <link rel="icon" href="../../public/img/CALAMAR.png" type="image/png">
</head>

<body>

<div class="contenedor-info">
    <?php if ($contenido['nsfw'] == 1): ?>
        <div class="nsfw">🔞 +18</div>
    <?php endif; ?>

    <img src="../../public/img/<?= $contenido['imagen']; ?>" alt="Poster">

    <h1><?= ucfirst($contenido['titulo']); ?></h1>
    <p><strong>Tipo:</strong> <?= ucfirst($contenido['tipo']); ?></p>
    <p><?= $contenido['descripcion']; ?></p>

    <div style="clear: both;"></div>
</div>

<div class="video-container">
    <video controls>
        <source src="../../public/trailer/<?= $video['url_video']; ?>" type="video/mp4">
        Tu navegador no soporta este formato de video.
    </video>
</div>

</body>
</html>
