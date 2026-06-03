CREATE TABLE `chat_conversaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario_1` int(11) NOT NULL,
  `id_usuario_2` int(11) NOT NULL,
  `ultima_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE TABLE `chat_mensajes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_conversacion` int(11) NOT NULL,
  `id_remitente` int(11) NOT NULL,
  `mensaje` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 0 COMMENT '0: No leido, 1: Leido',
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
