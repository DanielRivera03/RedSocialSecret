<?php
require('modelo/conexion.php');

if (!$conectarsistema) {
    die("Conexión fallida: " . mysqli_connect_error());
}

echo "Iniciando migración de base de datos para notificaciones...\n";

// 1. Crear tabla notificacionreacciones
$sql1 = "CREATE TABLE IF NOT EXISTS `notificacionreacciones` (
  `idnotificacionreacciones` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `idpublicacion` int(11) NOT NULL,
  `fecha_notificacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`idnotificacionreacciones`),
  KEY `id` (`id`),
  KEY `idpublicacion` (`idpublicacion`),
  CONSTRAINT `notificacionreacciones_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `notificacionreacciones_ibfk_2` FOREIGN KEY (`idpublicacion`) REFERENCES `publicaciones` (`idpublicacion`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if (mysqli_query($conectarsistema, $sql1)) {
    echo "Tabla 'notificacionreacciones' creada o ya existía.\n";
} else {
    echo "Error al crear tabla 'notificacionreacciones': " . mysqli_error($conectarsistema) . "\n";
}

// 2. Crear tabla notificacionmensajes
$sql2 = "CREATE TABLE IF NOT EXISTS `notificacionmensajes` (
  `idnotificacionmensajes` int(11) NOT NULL AUTO_INCREMENT,
  `id_remitente` int(11) NOT NULL,
  `id_receptor` int(11) NOT NULL,
  `id_mensaje` int(11) NOT NULL,
  `fecha_notificacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`idnotificacionmensajes`),
  KEY `id_remitente` (`id_remitente`),
  KEY `id_receptor` (`id_receptor`),
  KEY `id_mensaje` (`id_mensaje`),
  CONSTRAINT `notificacionmensajes_ibfk_1` FOREIGN KEY (`id_remitente`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `notificacionmensajes_ibfk_2` FOREIGN KEY (`id_receptor`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `notificacionmensajes_ibfk_3` FOREIGN KEY (`id_mensaje`) REFERENCES `chat_mensajes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if (mysqli_query($conectarsistema, $sql2)) {
    echo "Tabla 'notificacionmensajes' creada o ya existía.\n";
} else {
    echo "Error al crear tabla 'notificacionmensajes': " . mysqli_error($conectarsistema) . "\n";
}

// 3. Crear triggers para reacciones
mysqli_query($conectarsistema, "DROP TRIGGER IF EXISTS `RegistrarNotificacionesReacciones`");
$sql3 = "CREATE TRIGGER `RegistrarNotificacionesReacciones` AFTER INSERT ON `reacciones` FOR EACH ROW
INSERT INTO notificacionreacciones (id, idpublicacion, fecha_notificacion) VALUES(new.id, new.idpublicacion, CURRENT_TIMESTAMP);";
if (mysqli_query($conectarsistema, $sql3)) {
    echo "Trigger 'RegistrarNotificacionesReacciones' creado.\n";
} else {
    echo "Error al crear trigger 'RegistrarNotificacionesReacciones': " . mysqli_error($conectarsistema) . "\n";
}

mysqli_query($conectarsistema, "DROP TRIGGER IF EXISTS `EliminarNotificacionesReacciones`");
$sql4 = "CREATE TRIGGER `EliminarNotificacionesReacciones` AFTER DELETE ON `reacciones` FOR EACH ROW
DELETE FROM notificacionreacciones WHERE idpublicacion=old.idpublicacion AND id=old.id;";
if (mysqli_query($conectarsistema, $sql4)) {
    echo "Trigger 'EliminarNotificacionesReacciones' creado.\n";
} else {
    echo "Error al crear trigger 'EliminarNotificacionesReacciones': " . mysqli_error($conectarsistema) . "\n";
}

// 4. Crear trigger para mensajes
mysqli_query($conectarsistema, "DROP TRIGGER IF EXISTS `RegistrarNotificacionesMensajes`");
$sql5 = "CREATE TRIGGER `RegistrarNotificacionesMensajes` AFTER INSERT ON `chat_mensajes` FOR EACH ROW
BEGIN
  DECLARE _receptor INT;
  SELECT CASE WHEN id_usuario_1 = NEW.id_remitente THEN id_usuario_2 ELSE id_usuario_1 END INTO _receptor
  FROM chat_conversaciones WHERE id = NEW.id_conversacion;
  
  INSERT INTO notificacionmensajes (id_remitente, id_receptor, id_mensaje, fecha_notificacion)
  VALUES (NEW.id_remitente, _receptor, NEW.id, CURRENT_TIMESTAMP);
END;";
if (mysqli_query($conectarsistema, $sql5)) {
    echo "Trigger 'RegistrarNotificacionesMensajes' creado.\n";
} else {
    echo "Error al crear trigger 'RegistrarNotificacionesMensajes': " . mysqli_error($conectarsistema) . "\n";
}

// 5. Crear vista_notificacionesreacciones
$sql6 = "CREATE OR REPLACE VIEW `vista_notificacionesreacciones` AS
SELECT 
  `publicaciones`.`id` AS `id`, -- owner of publication (notification recipient)
  `notificacionreacciones`.`idnotificacionreacciones` AS `idnotificacionreacciones`,
  `notificacionreacciones`.`idpublicacion` AS `idpublicacion`,
  `notificacionreacciones`.`fecha_notificacion` AS `fecha_notificacion`,
  `usuarios`.`id` AS `id_reaccionador`,
  `usuarios`.`nombres` AS `nombres`,
  `usuarios`.`apellidos` AS `apellidos`,
  `usuarios`.`fotoperfil` AS `fotoperfil`,
  `usuarios`.`usuario` AS `usuario`
FROM `notificacionreacciones`
JOIN `usuarios` ON `notificacionreacciones`.`id` = `usuarios`.`id`
JOIN `publicaciones` ON `notificacionreacciones`.`idpublicacion` = `publicaciones`.`idpublicacion`
WHERE `notificacionreacciones`.`idpublicacion` <> 0;";

if (mysqli_query($conectarsistema, $sql6)) {
    echo "Vista 'vista_notificacionesreacciones' creada.\n";
} else {
    echo "Error al crear vista 'vista_notificacionesreacciones': " . mysqli_error($conectarsistema) . "\n";
}

// 6. Crear vista_notificacionesmensajes
$sql7 = "CREATE OR REPLACE VIEW `vista_notificacionesmensajes` AS
SELECT 
  `notificacionmensajes`.`id_receptor` AS `id`, -- notification recipient
  `notificacionmensajes`.`idnotificacionmensajes` AS `idnotificacionmensajes`,
  `notificacionmensajes`.`id_mensaje` AS `id_mensaje`,
  `notificacionmensajes`.`fecha_notificacion` AS `fecha_notificacion`,
  `usuarios`.`id` AS `id_remitente`,
  `usuarios`.`nombres` AS `nombres`,
  `usuarios`.`apellidos` AS `apellidos`,
  `usuarios`.`fotoperfil` AS `fotoperfil`,
  `usuarios`.`usuario` AS `usuario`,
  `chat_mensajes`.`mensaje` AS `mensaje`
FROM `notificacionmensajes`
JOIN `usuarios` ON `notificacionmensajes`.`id_remitente` = `usuarios`.`id`
JOIN `chat_mensajes` ON `notificacionmensajes`.`id_mensaje` = `chat_mensajes`.`id`
WHERE `notificacionmensajes`.`id_receptor` <> 0;";

if (mysqli_query($conectarsistema, $sql7)) {
    echo "Vista 'vista_notificacionesmensajes' creada.\n";
} else {
    echo "Error al crear vista 'vista_notificacionesmensajes': " . mysqli_error($conectarsistema) . "\n";
}

$conectarsistema->close();
echo "Migración completada con éxito.\n";
?>
