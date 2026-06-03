CREATE TABLE `marketplace_productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_vendedor` int(11) NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `ciudad` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `latitud` decimal(10,8) NOT NULL,
  `longitud` decimal(11,8) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1 COMMENT '1: Activo, 0: Vendido',
  `fecha_publicacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
