"<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "secretbd";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 1. Column ultima_conexion to usuarios table
$check = $conn->query("SHOW COLUMNS FROM `usuarios` LIKE 'ultima_conexion'");
if ($check->num_rows == 0) {
    $sql1 = "ALTER TABLE `usuarios` ADD COLUMN `ultima_conexion` timestamp NULL DEFAULT NULL;";
    if ($conn->query($sql1) === TRUE) {
        echo "Column ultima_conexion added successfully\
";
    } else {
        echo "Error adding column: " . $conn->error . "\
";
    }
} else {
    echo "Column ultima_conexion already exists\
";
}

// 2. Table publicacion_imagenes
$sql2 = "CREATE TABLE IF NOT EXISTS `publicacion_imagenes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idpublicacion` int(11) NOT NULL,
  `foto_publicacion` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`idpublicacion`) REFERENCES `publicaciones` (`idpublicacion`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
if ($conn->query($sql2) === TRUE) {
    echo "Table publicacion_imagenes created successfully\
";
} else {
    echo "Error creating table publicacion_imagenes: " . $conn->error . "\
";
}

// 3. Table historias
$sql3 = "CREATE TABLE IF NOT EXISTS `historias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `texto` varchar(150) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `fecha_publicacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
if ($conn->query($sql3) === TRUE) {
    echo "Table historias created successfully\
";
} else {
    echo "Error creating table historias: " . $conn->error . "\
";
}

// 4. Table notas_musica
$sql4 = "CREATE TABLE IF NOT EXISTS `notas_musica` (
  `id` int(
<truncated 675 bytes>