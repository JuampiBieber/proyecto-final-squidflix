-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-12-2025 a las 21:51:56
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `plataforma_peliculas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre`) VALUES
(1, 'accion'),
(2, 'terror'),
(3, 'comedia'),
(4, 'romance'),
(5, 'ciencia_ficcion'),
(6, 'familiar'),
(7, 'suspenso'),
(8, 'drama');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contenido`
--

CREATE TABLE `contenido` (
  `id_contenido` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `tipo` enum('pelicula','serie') NOT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `nsfw` tinyint(1) DEFAULT 0,
  `top10` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contenido`
--

INSERT INTO `contenido` (`id_contenido`, `titulo`, `descripcion`, `tipo`, `categoria_id`, `imagen`, `nsfw`, `top10`) VALUES
(1, 'Batman', 'Batman (2022) sigue a Bruce Wayne en sus primeros años como el Caballero Oscuro, enfrentando al asesino serial llamado Enigma.La película muestra una versión más oscura y detectivesca de Gotham, con acción intensa y misterio.También explora los conflictos internos de Batman y su lucha por la justicia frente a la corrupción.', 'pelicula', 1, 'B.webp', 0, 1),
(2, 'The Walking Dead', 'The Walking Dead sigue a un grupo de sobrevivientes en un mundo postapocalíptico lleno de zombis. 2 La historia se centra en la lucha por la supervivencia, la moral y las relaciones entre los personajes. 3 A medida que enfrentan amenazas humanas y no muertas, deben adaptarse para protegerse y mantener la esperanza.', 'serie', 5, 'TWD.jpg', 1, 1),
(3, 'megalodon', 'Megalodón es una película de acción y terror sobre un tiburón prehistórico gigante que se creía extinto.\r\nUn submarino queda atrapado en las profundidades tras ser atacado por la criatura de más de 20 metros.\r\nUn equipo de científicos y militares desciende al fondo del océano para detener al monstruo antes de que llegue a la superficie.', 'pelicula', 1, 'MEGALODON.jpg', 0, 1),
(4, 'el rey leon', 'Es la historia de un joven heredero que debe enfrentar la tragedia, el exilio y la traición para reclamar su lugar en el reino. A lo largo del camino, comprende el valor de la responsabilidad y el legado familiar. La trama combina aventura, drama y crecimiento personal en un mundo inspirado en la sabana africana.\r\n', 'pelicula', 6, 'ERL.webp', 0, 1),
(5, 'game of thrones', 'Relata la lucha por el control de un continente dividido, donde diversas casas nobles compiten por el poder absoluto. A medida que las alianzas cambian, la traición y la guerra moldean el destino de sus habitantes. En paralelo, una amenaza sobrenatural avanza desde el norte, poniendo en riesgo a todo el mundo conocido.\r\n', 'serie', 5, 'GOT.jpg', 1, 1),
(6, 'indiana jones', 'Sigue las aventuras de un arqueólogo que recorre el mundo enfrentando trampas, peligros y enemigos mientras busca reliquias antiguas. La historia mezcla acción, misterio y exploración en escenarios exóticos. Cada misión pone a prueba su ingenio y su determinación por proteger tesoros históricos.\r\n', 'pelicula', 1, 'IJ.jpg', 0, 1),
(7, 'pretty little liars', 'Cuenta la historia de un grupo de amigas que empieza a recibir mensajes anónimos que revelan secretos oscuros tras la desaparición de una de ellas. La tensión crece cuando descubren que alguien las vigila y manipula constantemente. La trama combina misterio, drama y giros inesperados alrededor de mentiras que salen a la luz.\r\n', 'serie', 7, 'PLL.webp', 0, 1),
(8, 'euphoria', 'Sigue la vida de un grupo de adolescentes que enfrenta adicciones, inseguridades y relaciones intensas en un entorno emocionalmente caótico. Cada personaje lidia con traumas y deseos que chocan entre sí, generando conflictos constantes. La serie explora temas como identidad, vulnerabilidad y búsqueda de sentido en medio del descontrol.\r\n', 'serie', 8, 'e.jpg', 1, 1),
(9, 'dahmer', 'Explora la vida de un asesino serial y muestra cómo sus crímenes se desarrollaron a lo largo de los años, desde su infancia hasta su captura. La historia revela fallas institucionales que permitieron que sus acciones pasaran desapercibidas. El tono es crudo y se centra en el impacto emocional y social de sus actos.\r\n', 'serie', 2, 'DAHMER.jpg', 1, 1),
(10, 'toy story', 'Relata la vida secreta de los juguetes cuando los humanos no están presentes, mostrando sus lazos de amistad y rivalidad. La llegada de un nuevo integrante provoca tensiones que los llevan a una aventura inesperada. La historia combina humor, emoción y un mensaje sobre el valor de la lealtad.\r\n', 'pelicula', 6, 'TS.jpg', 0, 1),
(11, 'stranger things', 'Sigue a un grupo de chicos que intenta resolver la desaparición de uno de sus amigos mientras fenómenos sobrenaturales comienzan a afectar su pueblo. La historia mezcla ciencia ficción, misterio y tensión creciente. Un mundo paralelo y fuerzas desconocidas ponen en peligro a todos los involucrados.\r\n', 'serie', 5, 'ST.jpg', 1, 1),
(12, 'madagascar', 'Cuenta la historia de un grupo de animales de zoológico que termina accidentalmente en la naturaleza tras una serie de eventos caóticos. Allí descubren instintos que nunca habían experimentado y deben aprender a sobrevivir lejos de la comodidad. La trama combina humor, aventura y el choque entre vida salvaje y vida domesticada.\r\n', 'pelicula', 6, 'M.webp', 0, 1),
(13, 'the last of us', 'Sigue el viaje de dos sobrevivientes en un mundo devastado por una infección que transformó a gran parte de la humanidad. Mientras atraviesan territorios peligrosos, aprenden a confiar el uno en el otro pese a sus diferencias. La historia explora el vínculo humano en medio de la pérdida, la violencia y la esperanza.\r\n', 'serie', 5, 'TLOU.jpg', 1, 1),
(14, 'tiburon', 'Relata cómo un pueblo costero entra en pánico cuando un enorme tiburón comienza a atacar en sus aguas. Las autoridades deben decidir entre proteger a los habitantes o mantener activo el turismo. La tensión crece hasta una cacería final que pone a prueba el coraje de quienes se enfrentan a la criatura.\r\n', 'pelicula', 7, 'T.jpg', 0, 1),
(15, 'ted (serie)', 'Sigue la convivencia caótica entre un adolescente y su oso de peluche que, tras cobrar vida, se comporta como un adulto irresponsable. La trama combina humor irreverente con situaciones familiares y problemas cotidianos. Cada episodio muestra cómo su amistad genera conflictos tan absurdos como divertidos.\r\n', 'serie', 3, 'TED.jpg', 1, 1),
(16, 'mi primer amor', 'Cuenta la historia de un adolescente que experimenta por primera vez el amor, enfrentando inseguridades y emociones desconocidas. A medida que se enamora, aprende lecciones sobre la amistad, la honestidad y el crecimiento personal. La trama mezcla ternura, humor y momentos emotivos de la juventud.\r\n', 'pelicula', 4, 'MPA.jpg', 0, 1),
(17, 'scooby doo', 'Sigue a un grupo de amigos y su perro parlante mientras investigan misteriosos crímenes y fenómenos sobrenaturales. Cada caso los lleva a descubrir que los villanos detrás de los sucesos son, en realidad, personas disfrazadas. La serie combina misterio, humor y aventuras llenas de ingenio.\r\n', 'serie', 6, 'SD.jpg', 0, 1),
(18, 'black mirror', 'Cada episodio presenta una historia independiente que explora los peligros y dilemas éticos de la tecnología en la sociedad moderna. La serie combina ciencia ficción, suspenso y crítica social. Los relatos suelen ser oscuros y provocativos, mostrando consecuencias extremas de la interacción humana con la tecnología.\r\n', 'serie', 6, '81UcD17TMrL._UF1000,1000_QL80_.jpg', 1, 1),
(19, 'plantas vs zombies', 'Se centra en la defensa de un hogar frente a hordas de zombis usando plantas con habilidades especiales. Cada nivel presenta estrategias diferentes para detener a los invasores. La historia combina humor, acción y creatividad en un contexto absurdo pero entretenido.\r\n', 'pelicula', 6, 'PVZ.jpg', 0, 1),
(20, 'top gun', 'Relata la historia de un joven piloto talentoso que ingresa a una escuela de élite de aviación para competir y superarse. A lo largo del entrenamiento, enfrenta desafíos profesionales y personales mientras desarrolla rivalidades y romances. La trama combina acción aérea intensa con drama y crecimiento personal.\r\n', 'pelicula', 1, 'TP.jpg', 0, 1),
(21, 'guerra mundial z', 'Muestra la lucha de la humanidad por sobrevivir ante una pandemia global que convierte a las personas en zombis. Un exinvestigador debe encontrar la causa y la posible cura mientras el mundo se desmorona a su alrededor. La historia mezcla acción, tensión y supervivencia en escenarios caóticos.\r\n', 'pelicula', 5, 'GMZ.jpg', 1, 0),
(22, 'el pinguino', 'Sigue la vida de un joven villano que planea ascender en el mundo del crimen mientras enfrenta a héroes y rivales en su ciudad. La serie explora sus orígenes, motivaciones y estrategias para consolidar su poder. Combina acción, intriga y momentos de humor oscuro en un entorno urbano.\r\n', 'serie', 1, 'ELPINGUINO.webp', 1, 0),
(23, 'jurassic world', 'Muestra un parque temático con dinosaurios clonados que se descontrolan tras un experimento genético fallido. Los visitantes y el personal deben luchar por sobrevivir mientras los depredadores causan caos. La historia combina acción, aventuras y el peligro de jugar con la naturaleza.\r\n', 'pelicula', 5, 'JWPELI.jpg', 0, 0),
(24, 'ted', 'Cuenta la historia de un hombre cuya infancia cambió cuando su oso de peluche cobró vida, convirtiéndose en su mejor amigo y compañero de travesuras. La relación provoca situaciones cómicas y conflictos en su vida adulta. La trama mezcla humor irreverente con temas de amistad y responsabilidad.', 'pelicula', 3, 'TEDPELI.jpg', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mi_lista`
--

CREATE TABLE `mi_lista` (
  `id` int(11) NOT NULL,
  `id_perfil` int(11) NOT NULL,
  `id_contenido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mi_lista`
--

INSERT INTO `mi_lista` (`id`, `id_perfil`, `id_contenido`) VALUES
(3, 1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles`
--

CREATE TABLE `perfiles` (
  `id_perfil` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo` enum('adulto','infantil') DEFAULT 'adulto',
  `avatar` varchar(255) DEFAULT 'default_avatar.png',
  `fecha_creacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `perfiles`
--

INSERT INTO `perfiles` (`id_perfil`, `id_usuario`, `nombre`, `tipo`, `avatar`, `fecha_creacion`) VALUES
(1, 6, 'Perfil principal', 'adulto', 'default_avatar.png', '2025-12-17 16:54:48'),
(2, 8, 'Perfil principal', 'adulto', 'default_avatar.png', '2025-12-17 18:18:59'),
(3, 9, 'Perfil principal', 'adulto', 'default_avatar.png', '2025-12-17 18:21:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','usuario') DEFAULT 'usuario',
  `fecha_registro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `email`, `password`, `rol`, `fecha_registro`) VALUES
(3, 'Franco', 'franco@gmail.com', '$2y$10$sI5iVP8n5kPm.yUEDNrU9Op77w5HU.mmnDN1NttfKCx7YtqLJdGFu', 'usuario', '2025-11-19 20:47:54'),
(4, 'Francoo', 'francoo@gmial.com', '$2y$10$nHudRSR0LhkSjUOJkDdaNuUT8sN0oCcKIqvKES.x1eiCKk2uBj266', 'usuario', '2025-11-19 20:55:44'),
(5, 'Gian', 'gian@gmail.com', '$2y$10$08V7zwn/BOTu03Jzcr/.uuhwhQKyXoPNil7OUzN0nvtYeoHxVHP86', 'usuario', '2025-11-20 20:03:47'),
(6, 'papa', 'papa@gmail.com', '$2y$10$5gIW0M56H5Vd9To4eaFiwuYhpRcytGOcpAjbuwSMRUkAP7b9ifcNe', 'usuario', '2025-12-17 16:54:48'),
(8, 'augusto', 'augusto@gmail.com', '$2y$10$a9DVNOP4JAc3nB52duPzCO88svLy9A8JHxAGs43LB/AUzu5v8Up6m', 'usuario', '2025-12-17 18:18:59'),
(9, 'admin', 'administrador@gmail.com', '$2y$10$..lYhXii6.Cy.TztAt8Khuc1JfJs0oiHcD/CmNcJj/UKi0L.QVdiu', 'admin', '2025-12-17 18:21:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videos`
--

CREATE TABLE `videos` (
  `id_video` int(11) NOT NULL,
  `id_contenido` int(11) NOT NULL,
  `url_video` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `videos`
--

INSERT INTO `videos` (`id_video`, `id_contenido`, `url_video`) VALUES
(1, 1, 'BATMAN_TRAILER.mp4'),
(2, 2, 'THE_WALKING_DEAD_TRAILER.mp4'),
(3, 3, 'MEGALODON_TRAILER.mp4'),
(4, 4, 'EL_REY_LEON_TRAILER.mp4'),
(5, 5, 'GAME_OF_THRONES_TRAILER.mp4'),
(6, 6, 'INDIANA_JONES_TRAILER.mp4'),
(7, 7, 'PRETTY_LITTLE_LIARS_TRAILER.mp4'),
(8, 8, 'EUPHORIA_TRAILER.mp4'),
(9, 9, 'DAHMER_TRAILER.mp4'),
(10, 10, 'TOY_STORY_TRAILER.mp4'),
(11, 11, 'STRANGER_THINGS_TRAILER.mp4'),
(12, 12, 'MADAGASCAR_TRAILER.mp4'),
(13, 13, 'THE_LAST_OF_US_TRAILER.mp4'),
(14, 14, 'TIBURON_TRAILER.mp4'),
(15, 15, 'TED_SERIE_TRAILER.mp4'),
(16, 16, 'MI_PRIMER_AMOR_TRAILER.mp4'),
(17, 17, 'SCOOBYDOO_TRAILER.mp4'),
(18, 18, 'BLACK_MIRROR_TRAILER.mp4'),
(19, 19, 'PLANTAS_VS_ZOMBIES_TRAILER.mp4'),
(20, 20, 'TOP_GUN_TRAILER.mp4'),
(21, 21, 'GUERRA_MUNDIAL_Z_TRAILER.mp4'),
(22, 22, 'EL_PINGUINO_TRAILER.mp4'),
(23, 23, 'JURASSIC_WORLD_TRAILER.mp4'),
(24, 24, 'TED_TRAILER.mp4');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `contenido`
--
ALTER TABLE `contenido`
  ADD PRIMARY KEY (`id_contenido`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `mi_lista`
--
ALTER TABLE `mi_lista`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_perfil` (`id_perfil`),
  ADD KEY `id_contenido` (`id_contenido`);

--
-- Indices de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  ADD PRIMARY KEY (`id_perfil`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id_video`),
  ADD KEY `id_contenido` (`id_contenido`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `contenido`
--
ALTER TABLE `contenido`
  MODIFY `id_contenido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `mi_lista`
--
ALTER TABLE `mi_lista`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  MODIFY `id_perfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `videos`
--
ALTER TABLE `videos`
  MODIFY `id_video` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `contenido`
--
ALTER TABLE `contenido`
  ADD CONSTRAINT `contenido_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id_categoria`);

--
-- Filtros para la tabla `mi_lista`
--
ALTER TABLE `mi_lista`
  ADD CONSTRAINT `mi_lista_ibfk_1` FOREIGN KEY (`id_perfil`) REFERENCES `perfiles` (`id_perfil`),
  ADD CONSTRAINT `mi_lista_ibfk_2` FOREIGN KEY (`id_contenido`) REFERENCES `contenido` (`id_contenido`);

--
-- Filtros para la tabla `perfiles`
--
ALTER TABLE `perfiles`
  ADD CONSTRAINT `perfiles_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `videos_ibfk_1` FOREIGN KEY (`id_contenido`) REFERENCES `contenido` (`id_contenido`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
