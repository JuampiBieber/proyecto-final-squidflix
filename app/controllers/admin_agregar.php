<?php
require "../../config/database.php";


if(isset($_POST["insert"])){

    $imagen_nombre = "";
    if(isset($_FILES["imagen_file"]) && $_FILES["imagen_file"]["error"] == 0){
        $upload_dir = "../../public/img/";
        $imagen_nombre = basename($_FILES["imagen_file"]["name"]);
        $destino = $upload_dir . $imagen_nombre;
        move_uploaded_file($_FILES["imagen_file"]["tmp_name"], $destino);
    }

    $stmt = $mysqli->prepare("
        INSERT INTO contenido (titulo, descripcion, tipo, categoria_id, imagen, nsfw, top10)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param(
        "sssissi",
        $_POST["titulo"],
        $_POST["descripcion"],
        $_POST["tipo"],
        $_POST["categoria_id"],
        $imagen_nombre,
        $_POST["nsfw"],
        $_POST["top10"]
    );
    $stmt->execute();


    $stmt2 = $mysqli->prepare("INSERT INTO videos (id_contenido, url_video) VALUES (?, ?)");
    $id_contenido = $mysqli->insert_id;
    $stmt2->bind_param("is", $id_contenido, $_POST["url_video"]);
    $stmt2->execute();

    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}


if(isset($_POST["update"])){

    $imagen_nombre = $_POST["imagen_antigua"];

    if(isset($_FILES["imagen_file"]) && $_FILES["imagen_file"]["error"] == 0){
        $upload_dir = "../../public/img/";
        $imagen_nombre = basename($_FILES["imagen_file"]["name"]);
        $destino = $upload_dir . $imagen_nombre;
        move_uploaded_file($_FILES["imagen_file"]["tmp_name"], $destino);
    }


    $stmt = $mysqli->prepare("
        UPDATE contenido 
        SET titulo=?, descripcion=?, tipo=?, categoria_id=?, imagen=?, nsfw=?, top10=?
        WHERE id_contenido=?
    ");
    $stmt->bind_param(
        "sssissii",
        $_POST["titulo"],
        $_POST["descripcion"],
        $_POST["tipo"],
        $_POST["categoria_id"],
        $imagen_nombre,
        $_POST["nsfw"],
        $_POST["top10"],
        $_POST["id_contenido"]
    );
    $stmt->execute();


    $stmt2 = $mysqli->prepare("
        UPDATE videos SET url_video=? WHERE id_contenido=?
    ");
    $stmt2->bind_param("si", $_POST["url_video"], $_POST["id_contenido"]);
    $stmt2->execute();

    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}


if(isset($_POST["delete"])){
    $id = $_POST["id_contenido"];


    $mysqli->query("DELETE FROM videos WHERE id_contenido=$id");


    $mysqli->query("DELETE FROM contenido WHERE id_contenido=$id");

    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}


$result = $mysqli->query("
    SELECT c.*, v.url_video
    FROM contenido c
    LEFT JOIN videos v ON c.id_contenido = v.id_contenido
    ORDER BY c.id_contenido ASC
");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Panel Admin</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
<style>
body {background-color:#000; color:#fff; font-family:"Oswald",sans-serif;}
table{border-collapse:collapse;width:100%;}
td,th{padding:5px; vertical-align: middle;}
img{width:70px;height:auto;border-radius:4px;}
input, select, button{padding:5px;border-radius:4px;border:1px solid #ccc;font-size:14px;}
button{cursor:pointer; transition:0.3s;}
button:hover{opacity:0.8;}
.btn-agregar{background-color:#3c803fff;color:#fff;padding:8px 16px;border:none;border-radius:4px;}
.btn-agregar:active{background-color:#275d2aff;}
.form-agregar td, .form-agregar th{border:none;}
</style>
</head>
<body>

<h2>Agregar Contenido</h2>
<form method="POST" enctype="multipart/form-data">
<table class="form-agregar">
<tr>
<td><b>Título</b></td>
<td><input type="text" name="titulo" required></td>
</tr>
<tr>
<td><b>Descripción</b></td>
<td><input type="text" name="descripcion" required style="width:350px;"></td>
</tr>
<tr>
<td><b>Tipo</b></td>
<td>
<select name="tipo">
<option value="pelicula">Película</option>
<option value="serie">Serie</option>
</select>
</td>
</tr>
<tr>
<td><b>Categoría</b></td>
<td><input type="number" name="categoria_id" min="0" max="10" required></td>
</tr>
<tr>
<td><b>Imagen</b></td>
<td><input type="file" name="imagen_file" accept="image/*" required></td>
</tr>
<tr>
<td><b>NSFW</b></td>
<td><input type="number" name="nsfw" min="0" max="1" value="0"></td>
</tr>
<tr>
<td><b>URL Video</b></td>
<td><input type="text" name="url_video" style="width:300px;"></td>
</tr>
<tr>
<td colspan="2"><button name="insert" class="btn-agregar">Agregar</button></td>
</tr>
</table>
<input type="hidden" name="top10" value="0">
</form>

<hr>
<h2>Lista de Contenidos</h2>
<table border="1">
<tr>
<th>ID</th>
<th>Título</th>
<th>Descripción</th>
<th>Tipo</th>
<th>Categoría</th>
<th>Imagen</th>
<th>Vista previa</th>
<th>NSFW</th>
<th>URL Video</th>
<th>Acciones</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>
<tr>
<form method="POST" enctype="multipart/form-data">
<td><?= $row["id_contenido"]; ?></td>
<input type="hidden" name="id_contenido" value="<?= $row["id_contenido"]; ?>">
<td><input type="text" name="titulo" value="<?= $row["titulo"]; ?>"></td>
<td><input type="text" name="descripcion" value="<?= $row["descripcion"]; ?>"></td>
<td><input type="text" name="tipo" value="<?= $row["tipo"]; ?>"></td>
<td><input type="number" name="categoria_id" value="<?= $row["categoria_id"]; ?>" min="0" max="10"></td>
<td>
<input type="file" name="imagen_file" accept="image/*">
<input type="hidden" name="imagen_antigua" value="<?= $row["imagen"]; ?>">
</td>
<td>
<?php if($row["imagen"]!=""): ?><img src="../../public/img/<?= $row["imagen"]; ?>"><?php endif; ?>
</td>
<td><input type="number" name="nsfw" value="<?= $row["nsfw"]; ?>" min="0" max="1"></td>
<td><input type="text" name="url_video" value="<?= $row["url_video"]; ?>" style="width:250px;"></td>
<td>
<button name="update">💾</button>
<button name="delete" onclick="return confirm('Eliminar?')">❌</button>
<input type="hidden" name="top10" value="<?= $row["top10"]; ?>">
</td>
</form>
</tr>
<?php endwhile; ?>
</table>

</body>
</html>


