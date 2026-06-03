<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "secretbd";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure trigger ActualizacionReaccionMeGustaDelete exists
$conn->query("DROP TRIGGER IF EXISTS `ActualizacionReaccionMeGustaDelete`");
$trigger_sql = "CREATE TRIGGER `ActualizacionReaccionMeGustaDelete` AFTER DELETE ON `reacciones` FOR EACH ROW UPDATE publicaciones SET megusta = GREATEST(0, megusta - 1) WHERE idpublicacion=old.idpublicacion";
if ($conn->query($trigger_sql) === TRUE) {
    echo "Trigger ActualizacionReaccionMeGustaDelete created/verified successfully.
";
} else {
    echo "Error creating trigger: " . $conn->error . "
";
}

// Ensure table asistencia_eventos exists
$asistencia_sql = "CREATE TABLE IF NOT EXISTS `asistencia_eventos` (
  `id_asistencia` int(11) NOT NULL AUTO_INCREMENT,
  `idevento` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `estado` varchar(20) NOT NULL,
  PRIMARY KEY (`id_asistencia`),
  UNIQUE KEY `idevento` (`idevento`,`id_usuario`),
  CONSTRAINT `asistencia_eventos_ibfk_1` FOREIGN KEY (`idevento`) REFERENCES `eventos` (`ideventos`) ON DELETE CASCADE,
  CONSTRAINT `asistencia_eventos_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
if ($conn->query($asistencia_sql) === TRUE) {
    echo "Table asistencia_eventos created/verified successfully.
";
} else {
    echo "Error creating table: " . $conn->error . "
";
}

$conn->close();
?>
