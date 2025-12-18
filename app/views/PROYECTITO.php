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
    <title>SQUIDFLIX</title>

    <link rel="stylesheet" href="../../public/css/styles.css" />
    <link rel="icon" href="../../public/img/CALAMAR.png" type="image/png" />
</head>

<body>

    <nav>
        <div class="logo">
            <img src="../../public/img/CALAMAR.png" alt="Logo" class="logo-img" />
        </div>

        <div class="hamburguesa" id="hamburguesa">
            <span></span><span></span><span></span>
        </div>

        <div class="nav-menu" id="nav-menu">
            <div class="nav-links">
                <a href="PROYECTITO.php">Inicio</a>
                <a href="PROYECTITO.php?filtro=peliculas">Películas</a>
                <a href="PROYECTITO.php?filtro=series">Series</a>
                <a href="PROYECTITO.php?filtro=mi_lista">Mi Lista</a>
                
                <div class="user-dropdown">
                    <span class="nombre-usuario"><?php echo htmlspecialchars($nombreUsuario); ?></span>
                    <div class="user-actions">
                        <a href="/proyecto-final-main/app/controllers/LogoutController.php">Cerrar sesión</a>
                        <a href="/proyecto-final-main/app/controllers/DeleteAccountController.php"
                        onclick="return confirm('¿Seguro que querés eliminar tu cuenta?');">Eliminar cuenta</a>
                    </div>
                </div>
            </div>
            
            <div class="busqueda-bar" style="position:relative;">
                <span id="zonaAdmin"></span>
                <input type="text" id="searchBar" placeholder="Buscar..." class="busqueda-class" />
                <div id="dropdown-results"
                style="position:absolute;background:#111;width:250px;max-height:300px;overflow-y:auto;border:1px solid #444;
                    display:none;z-index:999;top:100%;left:0;border-radius:5px;">
                </div>
            </div>
        </div>
    </nav>

    <?php

    $filtro = $_GET['filtro'] ?? '';
    $conn = new mysqli("localhost", "root", "", "plataforma_peliculas");

    if ($filtro === ""):
    ?>

        <section class="banner">
            <div class="carrusel">
                <div class="carrusel-item active" style="background-image: url('../../public/img/ELPINGUINOBANNER.avif')"></div>
                <div class="carrusel-item" style="background-image: url('../../public/img/JURASSICWORLDBANNER.jpg')"></div>
                <div class="carrusel-item" style="background-image: url('../../public/img/TEDBANNER.webp')"></div>
                <div class="carrusel-item" style="background-image: url('../../public/img/TOPGUNM.webp')"></div>
            </div>
        </section>

        <?php
        $resultTopPeliculas = $conn->query("
        SELECT id_contenido, titulo, imagen
        FROM contenido
        WHERE tipo = 'pelicula' AND top10 = 1
        ORDER BY titulo ASC
        LIMIT 10
    ");
        ?>

        <section class="contenido-section">
            <h2>Top 10 Películas</h2>

            <div class="carrusel-container">
                <button class="carrusel-prev" data-target="movies-row">&#10094;</button>

                <div class="contenido-row filtro-contenido" id="movies-row">
                    <?php while ($row = $resultTopPeliculas->fetch_assoc()): ?>
                        <div class="contenido-item"
                            data-title="<?php echo htmlspecialchars($row['titulo']); ?>">

                            <a href="reproductor.php?id=<?php echo $row['id_contenido']; ?>">
                                <img src="../../public/img/<?php echo htmlspecialchars($row['imagen']); ?>">
                            </a>

                            <button
                                class="btn-mi-lista"
                                data-id="<?php echo $row['id_contenido']; ?>">
                                + Mi Lista
                            </button>

                        </div>
                    <?php endwhile; ?>
                </div>

                <button class="carrusel-next" data-target="movies-row">&#10095;</button>
            </div>
        </section>

        <?php
        $resultTopSeries = $conn->query("
        SELECT id_contenido, titulo, imagen
        FROM contenido
        WHERE tipo = 'serie' AND top10 = 1
        ORDER BY titulo ASC
        LIMIT 10
    ");
        ?>

        <section class="contenido-section">
            <h2>Top 10 Series</h2>

            <div class="carrusel-container">
                <button class="carrusel-prev" data-target="series-row">&#10094;</button>

                <div class="contenido-row filtro-contenido" id="series-row">
                    <?php while ($row = $resultTopSeries->fetch_assoc()): ?>
                        <div class="contenido-item"
                            data-title="<?php echo htmlspecialchars($row['titulo']); ?>">

                            <a href="reproductor.php?id=<?php echo $row['id_contenido']; ?>">
                                <img src="../../public/img/<?php echo htmlspecialchars($row['imagen']); ?>">
                            </a>

                            <button
                                class="btn-mi-lista"
                                data-id="<?php echo $row['id_contenido']; ?>">
                                + Mi Lista
                            </button>

                        </div>
                    <?php endwhile; ?>
                </div>

                <button class="carrusel-next" data-target="series-row">&#10095;</button>
            </div>
        </section>


    <?php endif; ?>

    <?php
    if ($filtro === "peliculas") {
        echo "<br><br>";
        $tituloCatalogo = "Catálogo - Películas";
        $query = "SELECT id_contenido, titulo, imagen FROM contenido WHERE tipo = 'pelicula' ORDER BY titulo ASC";
    } elseif ($filtro === "series") {
        echo "<br><br>";
        $tituloCatalogo = "Catálogo – Solo Series";
        $query = "SELECT id_contenido, titulo, imagen FROM contenido WHERE tipo = 'serie' ORDER BY titulo ASC";
    } elseif ($filtro === "mi_lista") {

        echo "<br><br>";
        $tituloCatalogo = "Mi Lista";

        $idPerfil = $_SESSION['id_perfil'] ?? 1;

        $query = "
        SELECT c.id_contenido, c.titulo, c.imagen
        FROM contenido c
        INNER JOIN mi_lista ml ON c.id_contenido = ml.id_contenido
        WHERE ml.id_perfil = $idPerfil
        ORDER BY c.titulo ASC
    ";
    } else {
        $tituloCatalogo = "Catálogo Completo";
        $query = "SELECT id_contenido, titulo, imagen FROM contenido ORDER BY titulo ASC";
    }

    $resultCatalogo = $conn->query($query);
    ?>

    <section class="contenido-section">
        <h2><?php echo $tituloCatalogo; ?></h2>

        <div class="catalogo-grid filtro-contenidoPRINCIPAL" id="catalogo-grid">

            <?php while ($row = $resultCatalogo->fetch_assoc()): ?>
                <div class="contenido-item"
                    data-title="<?php echo htmlspecialchars($row['titulo']); ?>">

                    <a href="reproductor.php?id=<?php echo $row['id_contenido']; ?>">
                        <img src="../../public/img/<?php echo htmlspecialchars($row['imagen']); ?>">
                    </a>

                    <button
                        class="btn-mi-lista"
                        data-id="<?php echo $row['id_contenido']; ?>">
                        + Mi Lista
                    </button>

                </div>
            <?php endwhile; ?>

        </div>
    </section>

    <script>
        fetch("/proyecto-final-main/app/controllers/getRol.php")
    .then(respuesta => respuesta.json())
    .then(data => {
        if (data.rol === "admin") {

            const contenedor = document.getElementById("zonaAdmin");

            contenedor.innerHTML = `
                <a id="botonAdmin" href="../controllers/admin_agregar.php">
                    Panel de contenido
                </a>
            `;

            const boton = document.querySelector("#botonAdmin");

            if (!boton) return;

            boton.style.display = "inline-block";
            boton.style.padding = "10px 20px";
            boton.style.marginRight = "15px";
            boton.style.backgroundColor = "red";
            boton.style.color = "white"; 
            boton.style.cursor = "pointer";
            boton.style.borderRadius = "8px";
            boton.style.fontWeight = "bold";
            boton.style.textDecoration = "none";
            boton.style.transition = "0.3s";

            boton.addEventListener("mouseover", () => {
                boton.style.color = "black";
            });

            boton.addEventListener("mouseout", () => {
                boton.style.color = "white";
            });
        }
    })
    .catch(e => console.log(e));

        let currentIndex = 0;
        const items = document.querySelectorAll('.carrusel-item');
        if (items.length > 0) {
            setInterval(() => {
                currentIndex = (currentIndex + 1) % items.length;
                items.forEach((item, i) => {
                    item.style.transform = `translateX(${(i - currentIndex) * 100}%)`;
                    item.classList.toggle('active', i === currentIndex);
                });
            }, 5000);
        }

        document.querySelectorAll('.carrusel-prev').forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById(btn.dataset.target).scrollBy({
                    left: -400,
                    behavior: 'smooth'
                });
            });
        });
        document.querySelectorAll('.carrusel-next').forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById(btn.dataset.target).scrollBy({
                    left: 400,
                    behavior: 'smooth'
                });
            });
        });

        const searchBar = document.getElementById('searchBar');
        const dropdown = document.getElementById('dropdown-results');

        searchBar.addEventListener('input', () => {
            const q = searchBar.value.toLowerCase();
            dropdown.innerHTML = "";

            if (q.trim() === "") {
                dropdown.style.display = "none";
                return;
            }

            const results = [];

            document.querySelectorAll('.filtro-contenidoPRINCIPAL .contenido-item').forEach(item => {
                const titulo = item.dataset.title.toLowerCase();
                const imagen = item.querySelector("img").getAttribute("src");
                const link = item.querySelector("a").getAttribute("href");

                if (titulo.includes(q)) {
                    results.push({
                        titulo: item.dataset.title,
                        imagen: imagen,
                        link: link
                    });
                }
            });

            if (results.length === 0) {
                dropdown.innerHTML = `
            <div style="padding:10px;color:#ccc;">
                Sin resultados
            </div>`;
                dropdown.style.display = "block";
                return;
            }

            results.forEach(item => {
                let div = document.createElement('div');

                div.style.display = "flex";
                div.style.alignItems = "center";
                div.style.gap = "10px";
                div.style.padding = "10px";
                div.style.cursor = "pointer";
                div.style.borderBottom = "1px solid #333";

                let img = document.createElement('img');
                img.src = item.imagen;
                img.style.width = "45px";
                img.style.height = "65px";
                img.style.objectFit = "cover";
                img.style.borderRadius = "4px";

                let text = document.createElement('span');
                text.textContent = item.titulo;
                text.style.color = "white";

                div.appendChild(img);
                div.appendChild(text);

                div.addEventListener('click', () => {
                    window.location.href = item.link;
                });

                div.addEventListener('mouseover', () => div.style.background = "#222");
                div.addEventListener('mouseout', () => div.style.background = "none");

                dropdown.appendChild(div);
            });

            dropdown.style.display = "block";
        });
        document.getElementById('hamburguesa').addEventListener('click', () => {
            document.getElementById('nav-menu').classList.toggle('active');
        });
    </script>

    <script src="../../public/js/mi_lista.js"></script>

</body>
</html>