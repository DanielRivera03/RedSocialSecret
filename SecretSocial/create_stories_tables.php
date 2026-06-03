<?php
require('modelo/conexion.php');

echo "Creando tablas de historias si no existen...\n";

// Table 1: historias
$sql1 = "CREATE TABLE IF NOT EXISTS `historias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `texto` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `fecha_publicacion` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if (mysqli_query($conectarsistema, $sql1)) {
    echo "Tabla 'historias' creada o ya existe.\n";
} else {
    echo "Error creando tabla 'historias': " . mysqli_error($conectarsistema) . "\n";
}

// Table 2: historia_vistas
$sql2 = "CREATE TABLE IF NOT EXISTS `historia_vistas` (
  `id_vista` int(11) NOT NULL AUTO_INCREMENT,
  `id_historia` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_vista` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_vista`),
  UNIQUE KEY `historia_usuario_vista` (`id_historia`, `id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if (mysqli_query($conectarsistema, $sql2)) {
    echo "Tabla 'historia_vistas' creada o ya existe.\n";
} else {
    echo "Error creando tabla 'historia_vistas': " . mysqli_error($conectarsistema) . "\n";
}

// Table 3: historia_megusta
$sql3 = "CREATE TABLE IF NOT EXISTS `historia_megusta` (
  `id_megusta` int(11) NOT NULL AUTO_INCREMENT,
  `id_historia` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_megusta` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_megusta`),
  UNIQUE KEY `historia_usuario_like` (`id_historia`, `id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if (mysqli_query($conectarsistema, $sql3)) {
    echo "Tabla 'historia_megusta' creada o ya existe.\n";
} else {
    echo "Error creando tabla 'historia_megusta': " . mysqli_error($conectarsistema) . "\n";
}

$conectarsistema->close();
echo "Listo.\n";
?>
