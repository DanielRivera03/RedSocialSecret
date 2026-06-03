-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-06-2026 a las 18:48:27
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
-- Base de datos: `secretbd`
--
CREATE DATABASE IF NOT EXISTS `secretbd` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `secretbd`;

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `AceptarSolicitudesNuevosAmigos` (IN `_id` INT, IN `_idsolicitudamigo` INT)  NO SQL INSERT INTO amigos (id,idsolicitudamigo) VALUES (_id,_idsolicitudamigo)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `BorrarEventosSociales` (IN `_ideventos` INT)  NO SQL DELETE FROM eventos WHERE ideventos=_ideventos$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `BorrarHistoriasPublicadasPerfilUsuarios` (IN `_idpublicacion` INT)  NO SQL DELETE FROM publicaciones WHERE idpublicacion=_idpublicacion$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CancelarPerfilUsuarios` (IN `_nombres` VARCHAR(255), IN `_apellidos` VARCHAR(255), IN `_correo` VARCHAR(255), IN `_motivo` VARCHAR(100), IN `_detalle` VARCHAR(150), IN `_id` INT)  NO SQL BEGIN
INSERT INTO cancelacioncuenta (nombres,apellidos,correo,motivo,detalle,id) VALUES (_nombres,_apellidos,_correo,_motivo,_detalle,_id);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CompletarRegistroNuevosUsuarios` (IN `_id` INT, IN `_nombres` VARCHAR(255), IN `_apellidos` VARCHAR(255), IN `_usuario` VARCHAR(255), IN `_correo` VARCHAR(255), IN `_fotoperfil` VARCHAR(255), IN `_pais` VARCHAR(255), IN `_ciudad` VARCHAR(255), IN `_telefono` VARCHAR(100), IN `_genero` CHAR(1), IN `_fechanacimiento` DATE, IN `_privacidad` TINYINT(1), IN `_completarperfil` TINYINT(1))  NO SQL BEGIN
	UPDATE usuarios SET nombres = _nombres, apellidos = _apellidos, usuario = _usuario, correo = _correo, fotoperfil = _fotoperfil, pais = _pais, ciudad = _ciudad, telefono = _telefono, genero = _genero, fechanacimiento = _fechanacimiento, privacidad = _privacidad, completarperfil = _completarperfil WHERE id=_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CompletarRegistroNuevosUsuariosSinFoto` (IN `_id` INT, IN `_nombres` VARCHAR(255), IN `_apellidos` VARCHAR(255), IN `_usuario` VARCHAR(255), IN `_correo` VARCHAR(255), IN `_pais` VARCHAR(255), IN `_ciudad` VARCHAR(255), IN `_telefono` VARCHAR(100), IN `_genero` CHAR(1), IN `_fechanacimiento` DATE, IN `_privacidad` TINYINT(1), IN `_completarperfil` TINYINT(1))  NO SQL BEGIN
	UPDATE usuarios SET nombres = _nombres, apellidos = _apellidos, usuario = _usuario, correo = _correo, pais = _pais, ciudad = _ciudad, telefono = _telefono, genero = _genero, fechanacimiento = _fechanacimiento, privacidad = _privacidad, completarperfil = _completarperfil WHERE id=_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultaNotificacionesAmigosCompleta` (IN `_id` INT)  NO SQL SELECT * FROM vista_notificacionesamigos WHERE id=_id ORDER BY fecha_notificacion DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultaNotificacionesComentariosCompleta` (IN `_id` INT)  NO SQL SELECT * FROM vista_notificacionescomentarios WHERE id=_id ORDER BY fecha_notificacion DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarAmigosMiniaturaPerfilesGeneral` (IN `_id` INT)  NO SQL SELECT * FROM vista_amigosconfirmadosminiaturas WHERE id=_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarAmigosMiniaturaPerfilesPropietarios` (IN `_id` INT)  NO SQL SELECT * FROM vista_amigosconfirmadosminiaturas WHERE id=_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarAmigosPerfilesGenerales` (IN `_id` VARCHAR(255))  NO SQL SELECT * FROM vista_amigosconfirmados WHERE id=_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarAmigosPerfilesPropietarios` (IN `_id` INT)  NO SQL SELECT * FROM vista_amigosconfirmados WHERE id=_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarBuscadorSecret` (IN `_busqueda` VARCHAR(255))  NO SQL SELECT * FROM usuarios WHERE estado_usuario = 'activo' AND nombres LIKE _busqueda OR apellidos LIKE _busqueda OR usuario LIKE _busqueda$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarComentariosPerfilPropietario` (IN `_idpublicacion` INT)  NO SQL SELECT * FROM vista_comentariosperfilpropietario WHERE idpublicacion=_idpublicacion ORDER BY fechacomentario DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarCumpleanosEsteDia` (IN `_id` INT)  NO SQL SELECT * FROM vista_cumpleanerodiaahora WHERE id=_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarDetallesPerfilUsuarios` (IN `_usuario` VARCHAR(255))  NO SQL SELECT * FROM vista_detallesusuarioscompleta WHERE usuario=_usuario$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarDisponibilidadUsuario` (IN `_usuario` VARCHAR(200))  NO SQL SELECT * FROM usuarios WHERE usuario=_usuario$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultaReaccionesPublicaciones` (IN `_idpublicacion` INT)  NO SQL SELECT megusta,id FROM publicaciones WHERE idpublicacion=_idpublicacion$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarEventosRegistrados` (IN `_pais` VARCHAR(255))  NO SQL SELECT * FROM vista_eventosregistradoscompleta WHERE pais=_pais ORDER BY fechainicio ASC LIMIT 31$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarEventosRegistradosMiniatura` (IN `_pais` VARCHAR(255))  NO SQL SELECT * FROM vista_eventosregistradoscompleta WHERE pais=_pais ORDER BY fechainicio ASC LIMIT 16$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarExplorarAmigos` ()  NO SQL SELECT * FROM vista_listadoexploraramigos WHERE completarperfil=0 ORDER by nombres ASC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarFotosSubidasPerfilPropietario` (IN `_usuario` VARCHAR(255))  NO SQL SELECT * FROM vista_fotossubidasperfilespropietarios WHERE usuario=_usuario$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarMensajesRecibidos` ()  NO SQL SELECT * FROM vista_mensajeriarecibidausuarios ORDER BY fechamensaje DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarNombresComentarios` (IN `_idpublicacion` INT)  NO SQL SELECT nombres, apellidos, fechacomentario FROM vista_comentariosperfilpropietario WHERE idpublicacion = _idpublicacion ORDER BY fechacomentario DESC LIMIT 10$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarNotificacionesAmigos` (IN `_id` INT)  NO SQL SELECT * FROM vista_notificacionesamigos WHERE id=_id ORDER BY fecha_notificacion DESC LIMIT 6$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarPerfilesGeneralPublicaciones` (IN `_usuario` VARCHAR(255))  NO SQL SELECT * FROM vista_publicacionesperfilusuarios WHERE usuario=_usuario$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarPerfilUsuariosPublicaciones` (IN `_id` INT)  NO SQL SELECT * FROM vista_publicacionesperfilusuarios WHERE id=_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarPeticionEditarPerfil` (IN `_usuario` VARCHAR(255))  NO SQL SELECT * FROM vista_usuarioscompleta WHERE usuario=_usuario$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarPublicacionesInicio` (IN `_id` INT)  NO SQL SELECT * FROM vista_publicacionesinicio WHERE id=_id LIMIT 21$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarVideosMusicalesSubidos` ()  NO SQL SELECT * FROM vista_videosmusicalessubidos ORDER BY fechasubida DESC LIMIT 61$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarVistaCompletaFotosSubidasPerfilesPropietarios` (IN `_usuario` VARCHAR(255))  NO SQL SELECT * FROM vista_fotossubidascompletaperfilespropietarios WHERE usuario=_usuario$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultaSolicitudesAmistad` (IN `_idsolicitudamigo` INT)  NO SQL SELECT * FROM vista_solicitudesamistad WHERE idsolicitudamigo=_idsolicitudamigo LIMIT 7$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultaSolicitudesAmistadCompleta` (IN `_idsolicitudamigo` INT)  NO SQL SELECT * FROM vista_solicitudesamistad WHERE idsolicitudamigo=_idsolicitudamigo$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ContadorAmigosPerfilPropietario` (IN `_id` INT)  NO SQL SELECT * FROM vista_amigosconfirmados WHERE id=_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ContadorComentariosPublicaciones` (IN `_idpublicacion` INT)  NO SQL SELECT * FROM vista_comentariosperfilpropietario WHERE idpublicacion=_idpublicacion$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ContadorNotificacionesAmigos` (IN `_id` INT)  NO SQL SELECT * FROM vista_notificacionesamigos WHERE id=_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ContadorPublicacionesPerfilesPropietarios` (IN `_id` INT)  NO SQL SELECT * FROM vista_contadorpublicacionespropietarios WHERE id=_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ContadorSolicitudesAmistad` (IN `_idsolicitudamigo` INT)  NO SQL SELECT * FROM vista_solicitudesamistad WHERE idsolicitudamigo=_idsolicitudamigo AND estado=0$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EditarPerfilSinFotoPerfil` (IN `_id` INT, IN `_nombres` VARCHAR(255), IN `_apellidos` VARCHAR(255), IN `_usuario` VARCHAR(255), IN `_correo` VARCHAR(255), IN `_contrasenia` VARCHAR(255), IN `_foto_portada` VARCHAR(255), IN `_pais` VARCHAR(255), IN `_ciudad` VARCHAR(255), IN `_telefono` VARCHAR(100), IN `_genero` CHAR(1), IN `_fechanacimiento` DATE, IN `_privacidad` TINYINT(1), IN `_completarperfil` TINYINT(1), IN `_estado_usuario` VARCHAR(40))  NO SQL BEGIN
	UPDATE usuarios SET nombres = _nombres, apellidos = _apellidos, usuario = _usuario, correo = _correo, contrasenia = _contrasenia, foto_portada = _foto_portada, pais = _pais, ciudad = _ciudad, telefono = _telefono, genero = _genero, fechanacimiento = _fechanacimiento, privacidad = _privacidad, completarperfil = _completarperfil, estado_usuario = _estado_usuario WHERE id=_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EditarPerfilSinFotos` (IN `_id` INT, IN `_nombres` VARCHAR(255), IN `_apellidos` VARCHAR(255), IN `_usuario` VARCHAR(255), IN `_correo` VARCHAR(255), IN `_contrasenia` VARCHAR(255), IN `_pais` VARCHAR(255), IN `_ciudad` VARCHAR(255), IN `_telefono` VARCHAR(100), IN `_genero` CHAR(1), IN `_fechanacimiento` DATE, IN `_privacidad` TINYINT(1), IN `_completarperfil` TINYINT(1), IN `_estado_usuario` VARCHAR(40))  NO SQL BEGIN
	UPDATE usuarios SET nombres = _nombres, apellidos = _apellidos, usuario = _usuario, correo = _correo, contrasenia = _contrasenia, pais = _pais, ciudad = _ciudad, telefono = _telefono, genero = _genero, fechanacimiento = _fechanacimiento, privacidad = _privacidad, completarperfil = _completarperfil, estado_usuario = _estado_usuario WHERE id=_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EditarPerfilUsuariosConFoto` (IN `_id` INT, IN `_nombres` VARCHAR(255), IN `_apellidos` VARCHAR(255), IN `_usuario` VARCHAR(255), IN `_correo` VARCHAR(255), IN `_contrasenia` VARCHAR(255), IN `_fotoperfil` VARCHAR(255), IN `_fotoportada` VARCHAR(255), IN `_pais` VARCHAR(255), IN `_ciudad` VARCHAR(255), IN `_telefono` VARCHAR(100), IN `_genero` CHAR(1), IN `_fechanacimiento` DATE, IN `_privacidad` TINYINT(1), IN `_completarperfil` TINYINT(1), IN `_estado_usuario` VARCHAR(40))  NO SQL BEGIN
	UPDATE usuarios SET nombres = _nombres, apellidos = _apellidos, usuario = _usuario, correo = _correo, contrasenia = _contrasenia, fotoperfil = _fotoperfil, foto_portada = _fotoportada, pais = _pais, ciudad = _ciudad, telefono = _telefono, genero = _genero, fechanacimiento = _fechanacimiento, privacidad = _privacidad, completarperfil = _completarperfil, estado_usuario = _estado_usuario WHERE id=_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EditarPerfilUsuariosSinFotoPortada` (IN `_id` INT, IN `_nombres` VARCHAR(255), IN `_apellidos` VARCHAR(255), IN `_usuario` VARCHAR(255), IN `_correo` VARCHAR(255), IN `_contrasenia` VARCHAR(255), IN `_fotoperfil` VARCHAR(255), IN `_pais` VARCHAR(255), IN `_ciudad` VARCHAR(255), IN `_telefono` VARCHAR(100), IN `_genero` CHAR(1), IN `_fechanacimiento` DATE, IN `_privacidad` TINYINT(1), IN `_completarperfil` TINYINT(1), IN `_estado_usuario` VARCHAR(40))  NO SQL BEGIN
	UPDATE usuarios SET nombres = _nombres, apellidos = _apellidos, usuario = _usuario, correo = _correo, contrasenia = _contrasenia, fotoperfil = _fotoperfil, pais = _pais, ciudad = _ciudad, telefono = _telefono, genero = _genero, fechanacimiento = _fechanacimiento, privacidad = _privacidad, completarperfil = _completarperfil, estado_usuario = _estado_usuario WHERE id=_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarAmigosConfirmados` (IN `_idamigo` INT)  NO SQL DELETE FROM amigos WHERE idamigo=_idamigo$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarComentariosRegistrados` (IN `_idcomenterio` INT)  NO SQL DELETE FROM comentarios WHERE idcomenterio=_idcomenterio$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarMensajesChatGeneral` (IN `_id` INT)  NO SQL DELETE FROM mensajeria WHERE id=_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarMensajesIndividualesChatGeneral` (IN `_idmensaje` INT)  NO SQL DELETE FROM mensajeria WHERE idmensaje=_idmensaje$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarNotificacionesComentariosRegistrados` (IN `_idnotificacioncomentarios` INT)  NO SQL DELETE FROM notificacioncomentarios WHERE idnotificacioncomentarios=_idnotificacioncomentarios$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarNotificacionesSolicitudesAceptadas` (IN `_idnotificacionamigos` INT)  NO SQL DELETE FROM notificacionamigos WHERE idnotificacionamigos=_idnotificacionamigos$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarSolicitudesAmistad` (IN `_idsolicitudamistad` INT)  NO SQL DELETE FROM solicitudamistad WHERE idsolicitudamistad=_idsolicitudamistad$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarUsuarioRegistrado` (IN `_usuario` VARCHAR(255))  NO SQL DELETE FROM usuarios WHERE usuario=_usuario$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarVideosMusicales` (IN `_idvideos` INT)  NO SQL DELETE FROM videos WHERE idvideos=_idvideos$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InicioSesion` (IN `Usuario` VARCHAR(255), IN `Pass` VARCHAR(255))  NO SQL SELECT * FROM usuarios WHERE correo=Usuario and contrasenia=Pass and estado_usuario="activo"$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MantenimientoDetallesPerfilUsuarios` (IN `_id` INT, IN `_religion` VARCHAR(255), IN `_empleo` VARCHAR(255), IN `_escuela` VARCHAR(255), IN `_universidad` VARCHAR(255), IN `_deportes` VARCHAR(255), IN `_intereses` VARCHAR(255), IN `_generosmusicales` VARCHAR(255), IN `_situacionsentimental` VARCHAR(255), IN `_comprobacionperfil` TINYINT(1), IN `_sobremi` VARCHAR(100))  NO SQL UPDATE detalleusuarios SET religion = _religion, empleo = _empleo, escuela = _escuela, universidad = _universidad, deportes = _deportes, intereses = _intereses, generosmusicales = _generosmusicales, situacionsentimental = _situacionsentimental, comprobacionperfil = _comprobacionperfil, sobremi = _sobremi WHERE id=_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistrarComentariosPublicacionesPerfiles` (IN `_comentario` VARCHAR(255), IN `_id` INT, IN `_idpublicacion` INT)  NO SQL BEGIN
INSERT INTO comentarios (comentario,id,idpublicacion) VALUES (_comentario,_id,_idpublicacion);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistrarDetallesUsuariosPerfiles` (IN `_id` INT, IN `_religion` VARCHAR(255), IN `_empleo` VARCHAR(255), IN `_escuela` VARCHAR(255), IN `_universidad` VARCHAR(255), IN `_deportes` VARCHAR(255), IN `_intereses` VARCHAR(255), IN `_generosmusicales` VARCHAR(255), IN `_situacionsentimental` VARCHAR(255), IN `_comprobacionperfil` TINYINT(1), IN `_sobremi` VARCHAR(100))  NO SQL INSERT INTO detalleusuarios (religion,empleo,escuela,universidad,deportes,intereses,generosmusicales,situacionsentimental,comprobacionperfil,sobremi,id) VALUES (_religion,_empleo,_escuela,_universidad,_deportes,_intereses,_generosmusicales,_situacionsentimental,_comprobacionperfil,_sobremi,_id)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistrarMensajesChatGeneral` (IN `_mensaje` VARCHAR(1000), IN `_id` INT)  NO SQL INSERT INTO mensajeria (mensaje,id) VALUES (_mensaje,_id)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistrarNuevasReaccionesPublicaciones` (IN `_id` INT, IN `_idpublicacion` INT)  NO SQL INSERT INTO reacciones (id,idpublicacion) VALUES (_id,_idpublicacion)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistrarPublicacionesNuevas` (IN `_mensaje_publicacion` VARCHAR(150), IN `_foto_publicacion` VARCHAR(1500), IN `_id` INT)   BEGIN
    INSERT INTO publicaciones (mensaje_publicacion, foto_publicacion, id)
    VALUES (_mensaje_publicacion, _foto_publicacion, _id);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistrarUsuariosNuevos` (IN `_nombres` VARCHAR(255), IN `_apellidos` VARCHAR(255), IN `_correo` VARCHAR(255), IN `_contrasenia` VARCHAR(255))  NO SQL BEGIN 
INSERT INTO usuarios (nombres, apellidos, correo, contrasenia) VALUES (_nombres, _apellidos, _correo, _contrasenia);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistroNuevosEventosSociales` (IN `_nombre` VARCHAR(255), IN `_descripcion` VARCHAR(255), IN `_direccion` VARCHAR(255), IN `_usuario` VARCHAR(255), IN `_pais` VARCHAR(255), IN `_fechainicio` DATETIME, IN `_fechafin` DATETIME, IN `_fotoevento` VARCHAR(255), IN `_id` INT)  NO SQL INSERT INTO eventos (nombre,descripcion,direccion,usuario,pais,fechainicio,fechafin,fotoevento,id) VALUES (_nombre,_descripcion,_direccion,_usuario,_pais,_fechainicio,_fechafin,_fotoevento,_id)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistroSolicitudesAmistadUsuarios` (IN `_id` INT, IN `_idsolicitudamigo` INT)  NO SQL INSERT INTO solicitudamistad (id,idsolicitudamigo) VALUES (_id,_idsolicitudamigo)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistroVideosMusicales` (IN `_titulo_video` VARCHAR(40), IN `_video` VARCHAR(255), IN `_id` INT)  NO SQL INSERT INTO videos (titulo_video,video,id) VALUES (_titulo_video,_video,_id)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RetirarMensajesChatGeneral` (IN `_idmensaje` INT)  NO SQL UPDATE mensajeria SET mensaje="[Este mensaje ha sido retirado]", estado=1 WHERE idmensaje=_idmensaje$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `amigos`
--

CREATE TABLE IF NOT EXISTS `amigos` (
  `idamigo` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `idsolicitudamigo` int(11) NOT NULL,
  PRIMARY KEY (`idamigo`),
  UNIQUE KEY `id` (`id`,`idsolicitudamigo`),
  KEY `idsolicitudamigo` (`idsolicitudamigo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `amigos`
--

INSERT INTO `amigos` (`idamigo`, `id`, `idsolicitudamigo`) VALUES
(1, 1, 2),
(3, 1, 9),
(2, 2, 1);

--
-- Disparadores `amigos`
--
DELIMITER $$
CREATE TRIGGER `CambioEstadoSolicitudesAmistad` AFTER INSERT ON `amigos` FOR EACH ROW UPDATE solicitudamistad SET estado = 1 WHERE id=new.idsolicitudamigo
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `EliminarSolicitudesEnviadas` AFTER DELETE ON `amigos` FOR EACH ROW DELETE FROM solicitudamistad WHERE id=old.idsolicitudamigo
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `RegistrarNotificacionesAmigos` AFTER INSERT ON `amigos` FOR EACH ROW INSERT INTO notificacionamigos (idamigo, idsolicitudamigo,fecha_notificacion,id) VALUES(new.idamigo,new.idsolicitudamigo,CURRENT_TIMESTAMP,new.id)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia_eventos`
--

CREATE TABLE IF NOT EXISTS `asistencia_eventos` (
  `id_asistencia` int(11) NOT NULL AUTO_INCREMENT,
  `idevento` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `estado` varchar(20) NOT NULL,
  PRIMARY KEY (`id_asistencia`),
  UNIQUE KEY `idevento` (`idevento`,`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cancelacioncuenta`
--

CREATE TABLE IF NOT EXISTS `cancelacioncuenta` (
  `idcancelacion` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `motivo` varchar(100) NOT NULL,
  `detalle` varchar(150) NOT NULL,
  `id` int(11) NOT NULL,
  PRIMARY KEY (`idcancelacion`),
  UNIQUE KEY `id_2` (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Disparadores `cancelacioncuenta`
--
DELIMITER $$
CREATE TRIGGER `CambioEstadoUsuarios` AFTER INSERT ON `cancelacioncuenta` FOR EACH ROW UPDATE usuarios SET estado_usuario="inactivo" WHERE id=NEW.id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chat_conversaciones`
--

CREATE TABLE IF NOT EXISTS `chat_conversaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario_1` int(11) NOT NULL,
  `id_usuario_2` int(11) NOT NULL,
  `ultima_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `chat_conversaciones`
--

INSERT INTO `chat_conversaciones` (`id`, `id_usuario_1`, `id_usuario_2`, `ultima_actualizacion`) VALUES
(1, 1, 2, '2026-05-29 20:45:24'),
(2, 1, 9, '2026-06-02 15:25:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chat_llamadas`
--

CREATE TABLE IF NOT EXISTS `chat_llamadas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_remitente` int(11) NOT NULL,
  `id_receptor` int(11) NOT NULL,
  `tipo` varchar(20) NOT NULL COMMENT 'audio, video',
  `estado` varchar(20) NOT NULL DEFAULT 'calling' COMMENT 'calling, accepted, declined, hungup',
  `sdp_offer` text DEFAULT NULL,
  `sdp_answer` text DEFAULT NULL,
  `ice_candidates_remitente` text DEFAULT NULL,
  `ice_candidates_receptor` text DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `chat_llamadas`
--

INSERT INTO `chat_llamadas` (`id`, `id_remitente`, `id_receptor`, `tipo`, `estado`, `sdp_offer`, `sdp_answer`, `ice_candidates_remitente`, `ice_candidates_receptor`, `fecha`) VALUES
(1, 1, 2, 'video', 'hungup', 'v=0\r\no=- 3710351497350664319 2 IN IP4 127.0.0.1\r\ns=-\r\nt=0 0\r\na=group:BUNDLE 0 1\r\na=extmap-allow-mixed\r\na=msid-semantic: WMS b63d4d2b-fb65-42e0-a76c-a9e41d06141d\r\nm=audio 9 UDP/TLS/RTP/SAVPF 111 63 9 0 8 13 110 126\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:ZrE9\r\na=ice-pwd:t+XCtDgdc7wvXwSljDBR5gYN\r\na=ice-options:trickle\r\na=fingerprint:sha-256 9F:C9:02:29:B5:42:15:58:8F:06:9A:EC:CE:F0:0F:50:C5:AB:2D:C1:22:5D:7E:93:26:AF:49:05:DA:B2:C6:FC\r\na=setup:actpass\r\na=mid:0\r\na=extmap:1 urn:ietf:params:rtp-hdrext:ssrc-audio-level\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=sendrecv\r\na=msid:b63d4d2b-fb65-42e0-a76c-a9e41d06141d 112e8f17-b87a-4fc3-a87b-d5795165e06c\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:111 opus/48000/2\r\na=rtcp-fb:111 transport-cc\r\na=fmtp:111 minptime=10;useinbandfec=1\r\na=rtpmap:63 red/48000/2\r\na=fmtp:63 111/111\r\na=rtpmap:9 G722/8000\r\na=rtpmap:0 PCMU/8000\r\na=rtpmap:8 PCMA/8000\r\na=rtpmap:13 CN/8000\r\na=rtpmap:110 telephone-event/48000\r\na=rtpmap:126 telephone-event/8000\r\na=ssrc:3489131784 cname:UFfSEsBp6ImdSkSX\r\na=ssrc:3489131784 msid:b63d4d2b-fb65-42e0-a76c-a9e41d06141d 112e8f17-b87a-4fc3-a87b-d5795165e06c\r\nm=video 9 UDP/TLS/RTP/SAVPF 96 97 103 104 107 108 109 114 115 116 117 118 39 40 45 46 98 99 100 101 119 120 123 124 125\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:ZrE9\r\na=ice-pwd:t+XCtDgdc7wvXwSljDBR5gYN\r\na=ice-options:trickle\r\na=fingerprint:sha-256 9F:C9:02:29:B5:42:15:58:8F:06:9A:EC:CE:F0:0F:50:C5:AB:2D:C1:22:5D:7E:93:26:AF:49:05:DA:B2:C6:FC\r\na=setup:actpass\r\na=mid:1\r\na=extmap:14 urn:ietf:params:rtp-hdrext:toffset\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:13 urn:3gpp:video-orientation\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:5 http://www.webrtc.org/experiments/rtp-hdrext/playout-delay\r\na=extmap:6 http://www.webrtc.org/experiments/rtp-hdrext/video-content-type\r\na=extmap:7 http://www.webrtc.org/experiments/rtp-hdrext/video-timing\r\na=extmap:8 http://www.webrtc.org/experiments/rtp-hdrext/color-space\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=extmap:10 urn:ietf:params:rtp-hdrext:sdes:rtp-stream-id\r\na=extmap:11 urn:ietf:params:rtp-hdrext:sdes:repaired-rtp-stream-id\r\na=sendrecv\r\na=msid:b63d4d2b-fb65-42e0-a76c-a9e41d06141d 4fc94ea1-496d-4172-a28e-4323fd4ef77c\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:96 VP8/90000\r\na=rtcp-fb:96 goog-remb\r\na=rtcp-fb:96 transport-cc\r\na=rtcp-fb:96 ccm fir\r\na=rtcp-fb:96 nack\r\na=rtcp-fb:96 nack pli\r\na=rtpmap:97 rtx/90000\r\na=fmtp:97 apt=96\r\na=rtpmap:103 H264/90000\r\na=rtcp-fb:103 goog-remb\r\na=rtcp-fb:103 transport-cc\r\na=rtcp-fb:103 ccm fir\r\na=rtcp-fb:103 nack\r\na=rtcp-fb:103 nack pli\r\na=fmtp:103 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42001f\r\na=rtpmap:104 rtx/90000\r\na=fmtp:104 apt=103\r\na=rtpmap:107 H264/90000\r\na=rtcp-fb:107 goog-remb\r\na=rtcp-fb:107 transport-cc\r\na=rtcp-fb:107 ccm fir\r\na=rtcp-fb:107 nack\r\na=rtcp-fb:107 nack pli\r\na=fmtp:107 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42001f\r\na=rtpmap:108 rtx/90000\r\na=fmtp:108 apt=107\r\na=rtpmap:109 H264/90000\r\na=rtcp-fb:109 goog-remb\r\na=rtcp-fb:109 transport-cc\r\na=rtcp-fb:109 ccm fir\r\na=rtcp-fb:109 nack\r\na=rtcp-fb:109 nack pli\r\na=fmtp:109 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42e01f\r\na=rtpmap:114 rtx/90000\r\na=fmtp:114 apt=109\r\na=rtpmap:115 H264/90000\r\na=rtcp-fb:115 goog-remb\r\na=rtcp-fb:115 transport-cc\r\na=rtcp-fb:115 ccm fir\r\na=rtcp-fb:115 nack\r\na=rtcp-fb:115 nack pli\r\na=fmtp:115 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42e01f\r\na=rtpmap:116 rtx/90000\r\na=fmtp:116 apt=115\r\na=rtpmap:117 H264/90000\r\na=rtcp-fb:117 goog-remb\r\na=rtcp-fb:117 transport-cc\r\na=rtcp-fb:117 ccm fir\r\na=rtcp-fb:117 nack\r\na=rtcp-fb:117 nack pli\r\na=fmtp:117 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=4d001f\r\na=rtpmap:118 rtx/90000\r\na=fmtp:118 apt=117\r\na=rtpmap:39 H264/90000\r\na=rtcp-fb:39 goog-remb\r\na=rtcp-fb:39 transport-cc\r\na=rtcp-fb:39 ccm fir\r\na=rtcp-fb:39 nack\r\na=rtcp-fb:39 nack pli\r\na=fmtp:39 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=4d001f\r\na=rtpmap:40 rtx/90000\r\na=fmtp:40 apt=39\r\na=rtpmap:45 AV1/90000\r\na=rtcp-fb:45 goog-remb\r\na=rtcp-fb:45 transport-cc\r\na=rtcp-fb:45 ccm fir\r\na=rtcp-fb:45 nack\r\na=rtcp-fb:45 nack pli\r\na=fmtp:45 level-idx=5;profile=0;tier=0\r\na=rtpmap:46 rtx/90000\r\na=fmtp:46 apt=45\r\na=rtpmap:98 VP9/90000\r\na=rtcp-fb:98 goog-remb\r\na=rtcp-fb:98 transport-cc\r\na=rtcp-fb:98 ccm fir\r\na=rtcp-fb:98 nack\r\na=rtcp-fb:98 nack pli\r\na=fmtp:98 profile-id=0\r\na=rtpmap:99 rtx/90000\r\na=fmtp:99 apt=98\r\na=rtpmap:100 VP9/90000\r\na=rtcp-fb:100 goog-remb\r\na=rtcp-fb:100 transport-cc\r\na=rtcp-fb:100 ccm fir\r\na=rtcp-fb:100 nack\r\na=rtcp-fb:100 nack pli\r\na=fmtp:100 profile-id=2\r\na=rtpmap:101 rtx/90000\r\na=fmtp:101 apt=100\r\na=rtpmap:119 H264/90000\r\na=rtcp-fb:119 goog-remb\r\na=rtcp-fb:119 transport-cc\r\na=rtcp-fb:119 ccm fir\r\na=rtcp-fb:119 nack\r\na=rtcp-fb:119 nack pli\r\na=fmtp:119 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=64001f\r\na=rtpmap:120 rtx/90000\r\na=fmtp:120 apt=119\r\na=rtpmap:123 red/90000\r\na=rtpmap:124 rtx/90000\r\na=fmtp:124 apt=123\r\na=rtpmap:125 ulpfec/90000\r\na=ssrc-group:FID 49762152 2246213828\r\na=ssrc:49762152 cname:UFfSEsBp6ImdSkSX\r\na=ssrc:49762152 msid:b63d4d2b-fb65-42e0-a76c-a9e41d06141d 4fc94ea1-496d-4172-a28e-4323fd4ef77c\r\na=ssrc:2246213828 cname:UFfSEsBp6ImdSkSX\r\na=ssrc:2246213828 msid:b63d4d2b-fb65-42e0-a76c-a9e41d06141d 4fc94ea1-496d-4172-a28e-4323fd4ef77c\r\n', 'v=0\r\no=- 5063930439910279235 2 IN IP4 127.0.0.1\r\ns=-\r\nt=0 0\r\na=group:BUNDLE 0 1\r\na=extmap-allow-mixed\r\na=msid-semantic: WMS d5667a12-89b3-4d75-ab88-12d5ba0da80c\r\nm=audio 9 UDP/TLS/RTP/SAVPF 111 63 9 0 8 13 110 126\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:CP4j\r\na=ice-pwd:lHsOUOZ8fNH4psL45GaM0iuE\r\na=ice-options:trickle\r\na=fingerprint:sha-256 33:D1:B1:22:F5:F6:90:57:DC:BC:F1:39:00:BD:F3:80:5B:A0:B2:72:AB:EB:1C:1F:AD:75:2D:C6:F1:D0:19:EE\r\na=setup:active\r\na=mid:0\r\na=extmap:1 urn:ietf:params:rtp-hdrext:ssrc-audio-level\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=sendrecv\r\na=msid:d5667a12-89b3-4d75-ab88-12d5ba0da80c bee7309e-00ca-41d0-8ae0-a0b93aba43d8\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:111 opus/48000/2\r\na=rtcp-fb:111 transport-cc\r\na=fmtp:111 minptime=10;useinbandfec=1\r\na=rtpmap:63 red/48000/2\r\na=fmtp:63 111/111\r\na=rtpmap:9 G722/8000\r\na=rtpmap:0 PCMU/8000\r\na=rtpmap:8 PCMA/8000\r\na=rtpmap:13 CN/8000\r\na=rtpmap:110 telephone-event/48000\r\na=rtpmap:126 telephone-event/8000\r\na=ssrc:421525835 cname:URMGweWELQ88JdXM\r\nm=video 9 UDP/TLS/RTP/SAVPF 96 97 103 104 107 108 109 114 115 116 117 118 39 40 45 46 98 99 100 101 119 120 123 124 125\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:CP4j\r\na=ice-pwd:lHsOUOZ8fNH4psL45GaM0iuE\r\na=ice-options:trickle\r\na=fingerprint:sha-256 33:D1:B1:22:F5:F6:90:57:DC:BC:F1:39:00:BD:F3:80:5B:A0:B2:72:AB:EB:1C:1F:AD:75:2D:C6:F1:D0:19:EE\r\na=setup:active\r\na=mid:1\r\na=extmap:14 urn:ietf:params:rtp-hdrext:toffset\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:13 urn:3gpp:video-orientation\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:5 http://www.webrtc.org/experiments/rtp-hdrext/playout-delay\r\na=extmap:6 http://www.webrtc.org/experiments/rtp-hdrext/video-content-type\r\na=extmap:7 http://www.webrtc.org/experiments/rtp-hdrext/video-timing\r\na=extmap:8 http://www.webrtc.org/experiments/rtp-hdrext/color-space\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=extmap:10 urn:ietf:params:rtp-hdrext:sdes:rtp-stream-id\r\na=extmap:11 urn:ietf:params:rtp-hdrext:sdes:repaired-rtp-stream-id\r\na=sendrecv\r\na=msid:d5667a12-89b3-4d75-ab88-12d5ba0da80c 4f897481-bd8c-47d2-9bd8-82f5d09d96fa\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:96 VP8/90000\r\na=rtcp-fb:96 goog-remb\r\na=rtcp-fb:96 transport-cc\r\na=rtcp-fb:96 ccm fir\r\na=rtcp-fb:96 nack\r\na=rtcp-fb:96 nack pli\r\na=rtpmap:97 rtx/90000\r\na=fmtp:97 apt=96\r\na=rtpmap:103 H264/90000\r\na=rtcp-fb:103 goog-remb\r\na=rtcp-fb:103 transport-cc\r\na=rtcp-fb:103 ccm fir\r\na=rtcp-fb:103 nack\r\na=rtcp-fb:103 nack pli\r\na=fmtp:103 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42001f\r\na=rtpmap:104 rtx/90000\r\na=fmtp:104 apt=103\r\na=rtpmap:107 H264/90000\r\na=rtcp-fb:107 goog-remb\r\na=rtcp-fb:107 transport-cc\r\na=rtcp-fb:107 ccm fir\r\na=rtcp-fb:107 nack\r\na=rtcp-fb:107 nack pli\r\na=fmtp:107 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42001f\r\na=rtpmap:108 rtx/90000\r\na=fmtp:108 apt=107\r\na=rtpmap:109 H264/90000\r\na=rtcp-fb:109 goog-remb\r\na=rtcp-fb:109 transport-cc\r\na=rtcp-fb:109 ccm fir\r\na=rtcp-fb:109 nack\r\na=rtcp-fb:109 nack pli\r\na=fmtp:109 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42e01f\r\na=rtpmap:114 rtx/90000\r\na=fmtp:114 apt=109\r\na=rtpmap:115 H264/90000\r\na=rtcp-fb:115 goog-remb\r\na=rtcp-fb:115 transport-cc\r\na=rtcp-fb:115 ccm fir\r\na=rtcp-fb:115 nack\r\na=rtcp-fb:115 nack pli\r\na=fmtp:115 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42e01f\r\na=rtpmap:116 rtx/90000\r\na=fmtp:116 apt=115\r\na=rtpmap:117 H264/90000\r\na=rtcp-fb:117 goog-remb\r\na=rtcp-fb:117 transport-cc\r\na=rtcp-fb:117 ccm fir\r\na=rtcp-fb:117 nack\r\na=rtcp-fb:117 nack pli\r\na=fmtp:117 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=4d001f\r\na=rtpmap:118 rtx/90000\r\na=fmtp:118 apt=117\r\na=rtpmap:39 H264/90000\r\na=rtcp-fb:39 goog-remb\r\na=rtcp-fb:39 transport-cc\r\na=rtcp-fb:39 ccm fir\r\na=rtcp-fb:39 nack\r\na=rtcp-fb:39 nack pli\r\na=fmtp:39 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=4d001f\r\na=rtpmap:40 rtx/90000\r\na=fmtp:40 apt=39\r\na=rtpmap:45 AV1/90000\r\na=rtcp-fb:45 goog-remb\r\na=rtcp-fb:45 transport-cc\r\na=rtcp-fb:45 ccm fir\r\na=rtcp-fb:45 nack\r\na=rtcp-fb:45 nack pli\r\na=fmtp:45 level-idx=5;profile=0;tier=0\r\na=rtpmap:46 rtx/90000\r\na=fmtp:46 apt=45\r\na=rtpmap:98 VP9/90000\r\na=rtcp-fb:98 goog-remb\r\na=rtcp-fb:98 transport-cc\r\na=rtcp-fb:98 ccm fir\r\na=rtcp-fb:98 nack\r\na=rtcp-fb:98 nack pli\r\na=fmtp:98 profile-id=0\r\na=rtpmap:99 rtx/90000\r\na=fmtp:99 apt=98\r\na=rtpmap:100 VP9/90000\r\na=rtcp-fb:100 goog-remb\r\na=rtcp-fb:100 transport-cc\r\na=rtcp-fb:100 ccm fir\r\na=rtcp-fb:100 nack\r\na=rtcp-fb:100 nack pli\r\na=fmtp:100 profile-id=2\r\na=rtpmap:101 rtx/90000\r\na=fmtp:101 apt=100\r\na=rtpmap:119 H264/90000\r\na=rtcp-fb:119 goog-remb\r\na=rtcp-fb:119 transport-cc\r\na=rtcp-fb:119 ccm fir\r\na=rtcp-fb:119 nack\r\na=rtcp-fb:119 nack pli\r\na=fmtp:119 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=64001f\r\na=rtpmap:120 rtx/90000\r\na=fmtp:120 apt=119\r\na=rtpmap:123 red/90000\r\na=rtpmap:124 rtx/90000\r\na=fmtp:124 apt=123\r\na=rtpmap:125 ulpfec/90000\r\na=ssrc-group:FID 2363905855 3223976907\r\na=ssrc:2363905855 cname:URMGweWELQ88JdXM\r\na=ssrc:3223976907 cname:URMGweWELQ88JdXM\r\n', NULL, '[{\"candidate\":\"candidate:4019403902 1 udp 2122260223 172.16.1.129 63940 typ host generation 0 ufrag CP4j network-id 1 network-cost 10\",\"sdpMid\":\"0\",\"sdpMLineIndex\":0,\"usernameFragment\":\"CP4j\"},{\"candidate\":\"candidate:2433554803 1 tcp 1518280447 172.16.1.129 9 typ host tcptype active generation 0 ufrag CP4j network-id 1 network-cost 10\",\"sdpMid\":\"0\",\"sdpMLineIndex\":0,\"usernameFragment\":\"CP4j\"},{\"candidate\":\"candidate:3404395412 1 udp 1686052607 216.184.111.2 63940 typ srflx raddr 172.16.1.129 rport 63940 generation 0 ufrag CP4j network-id 1 network-cost 10\",\"sdpMid\":\"0\",\"sdpMLineIndex\":0,\"usernameFragment\":\"CP4j\"}]', '2026-05-28 21:11:36'),
(2, 2, 1, 'video', 'hungup', 'v=0\r\no=- 1363977280542250107 2 IN IP4 127.0.0.1\r\ns=-\r\nt=0 0\r\na=group:BUNDLE 0 1\r\na=extmap-allow-mixed\r\na=msid-semantic: WMS aa3a8a8f-a510-400f-a072-cdc071365eaf\r\nm=audio 9 UDP/TLS/RTP/SAVPF 111 63 9 0 8 13 110 126\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:+q3z\r\na=ice-pwd:JNFhJuab3a5RKU8c3FvS4fhP\r\na=ice-options:trickle\r\na=fingerprint:sha-256 3A:DB:1D:F1:2B:85:FC:2E:1A:49:D9:54:18:1E:15:28:77:7B:86:26:50:31:46:F6:D7:1F:C1:F6:C0:D2:C5:8D\r\na=setup:actpass\r\na=mid:0\r\na=extmap:1 urn:ietf:params:rtp-hdrext:ssrc-audio-level\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=sendrecv\r\na=msid:aa3a8a8f-a510-400f-a072-cdc071365eaf fbd6b16f-4f69-46b0-b01c-79c521c7c7c0\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:111 opus/48000/2\r\na=rtcp-fb:111 transport-cc\r\na=fmtp:111 minptime=10;useinbandfec=1\r\na=rtpmap:63 red/48000/2\r\na=fmtp:63 111/111\r\na=rtpmap:9 G722/8000\r\na=rtpmap:0 PCMU/8000\r\na=rtpmap:8 PCMA/8000\r\na=rtpmap:13 CN/8000\r\na=rtpmap:110 telephone-event/48000\r\na=rtpmap:126 telephone-event/8000\r\na=ssrc:2506448948 cname:XIpGFz4080OrB+oH\r\na=ssrc:2506448948 msid:aa3a8a8f-a510-400f-a072-cdc071365eaf fbd6b16f-4f69-46b0-b01c-79c521c7c7c0\r\nm=video 9 UDP/TLS/RTP/SAVPF 96 97 103 104 107 108 109 114 115 116 117 118 39 40 45 46 98 99 100 101 119 120 123 124 125\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:+q3z\r\na=ice-pwd:JNFhJuab3a5RKU8c3FvS4fhP\r\na=ice-options:trickle\r\na=fingerprint:sha-256 3A:DB:1D:F1:2B:85:FC:2E:1A:49:D9:54:18:1E:15:28:77:7B:86:26:50:31:46:F6:D7:1F:C1:F6:C0:D2:C5:8D\r\na=setup:actpass\r\na=mid:1\r\na=extmap:14 urn:ietf:params:rtp-hdrext:toffset\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:13 urn:3gpp:video-orientation\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:5 http://www.webrtc.org/experiments/rtp-hdrext/playout-delay\r\na=extmap:6 http://www.webrtc.org/experiments/rtp-hdrext/video-content-type\r\na=extmap:7 http://www.webrtc.org/experiments/rtp-hdrext/video-timing\r\na=extmap:8 http://www.webrtc.org/experiments/rtp-hdrext/color-space\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=extmap:10 urn:ietf:params:rtp-hdrext:sdes:rtp-stream-id\r\na=extmap:11 urn:ietf:params:rtp-hdrext:sdes:repaired-rtp-stream-id\r\na=sendrecv\r\na=msid:aa3a8a8f-a510-400f-a072-cdc071365eaf e01c1321-5fa7-47d9-829a-b781d187c088\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:96 VP8/90000\r\na=rtcp-fb:96 goog-remb\r\na=rtcp-fb:96 transport-cc\r\na=rtcp-fb:96 ccm fir\r\na=rtcp-fb:96 nack\r\na=rtcp-fb:96 nack pli\r\na=rtpmap:97 rtx/90000\r\na=fmtp:97 apt=96\r\na=rtpmap:103 H264/90000\r\na=rtcp-fb:103 goog-remb\r\na=rtcp-fb:103 transport-cc\r\na=rtcp-fb:103 ccm fir\r\na=rtcp-fb:103 nack\r\na=rtcp-fb:103 nack pli\r\na=fmtp:103 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42001f\r\na=rtpmap:104 rtx/90000\r\na=fmtp:104 apt=103\r\na=rtpmap:107 H264/90000\r\na=rtcp-fb:107 goog-remb\r\na=rtcp-fb:107 transport-cc\r\na=rtcp-fb:107 ccm fir\r\na=rtcp-fb:107 nack\r\na=rtcp-fb:107 nack pli\r\na=fmtp:107 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42001f\r\na=rtpmap:108 rtx/90000\r\na=fmtp:108 apt=107\r\na=rtpmap:109 H264/90000\r\na=rtcp-fb:109 goog-remb\r\na=rtcp-fb:109 transport-cc\r\na=rtcp-fb:109 ccm fir\r\na=rtcp-fb:109 nack\r\na=rtcp-fb:109 nack pli\r\na=fmtp:109 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42e01f\r\na=rtpmap:114 rtx/90000\r\na=fmtp:114 apt=109\r\na=rtpmap:115 H264/90000\r\na=rtcp-fb:115 goog-remb\r\na=rtcp-fb:115 transport-cc\r\na=rtcp-fb:115 ccm fir\r\na=rtcp-fb:115 nack\r\na=rtcp-fb:115 nack pli\r\na=fmtp:115 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42e01f\r\na=rtpmap:116 rtx/90000\r\na=fmtp:116 apt=115\r\na=rtpmap:117 H264/90000\r\na=rtcp-fb:117 goog-remb\r\na=rtcp-fb:117 transport-cc\r\na=rtcp-fb:117 ccm fir\r\na=rtcp-fb:117 nack\r\na=rtcp-fb:117 nack pli\r\na=fmtp:117 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=4d001f\r\na=rtpmap:118 rtx/90000\r\na=fmtp:118 apt=117\r\na=rtpmap:39 H264/90000\r\na=rtcp-fb:39 goog-remb\r\na=rtcp-fb:39 transport-cc\r\na=rtcp-fb:39 ccm fir\r\na=rtcp-fb:39 nack\r\na=rtcp-fb:39 nack pli\r\na=fmtp:39 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=4d001f\r\na=rtpmap:40 rtx/90000\r\na=fmtp:40 apt=39\r\na=rtpmap:45 AV1/90000\r\na=rtcp-fb:45 goog-remb\r\na=rtcp-fb:45 transport-cc\r\na=rtcp-fb:45 ccm fir\r\na=rtcp-fb:45 nack\r\na=rtcp-fb:45 nack pli\r\na=fmtp:45 level-idx=5;profile=0;tier=0\r\na=rtpmap:46 rtx/90000\r\na=fmtp:46 apt=45\r\na=rtpmap:98 VP9/90000\r\na=rtcp-fb:98 goog-remb\r\na=rtcp-fb:98 transport-cc\r\na=rtcp-fb:98 ccm fir\r\na=rtcp-fb:98 nack\r\na=rtcp-fb:98 nack pli\r\na=fmtp:98 profile-id=0\r\na=rtpmap:99 rtx/90000\r\na=fmtp:99 apt=98\r\na=rtpmap:100 VP9/90000\r\na=rtcp-fb:100 goog-remb\r\na=rtcp-fb:100 transport-cc\r\na=rtcp-fb:100 ccm fir\r\na=rtcp-fb:100 nack\r\na=rtcp-fb:100 nack pli\r\na=fmtp:100 profile-id=2\r\na=rtpmap:101 rtx/90000\r\na=fmtp:101 apt=100\r\na=rtpmap:119 H264/90000\r\na=rtcp-fb:119 goog-remb\r\na=rtcp-fb:119 transport-cc\r\na=rtcp-fb:119 ccm fir\r\na=rtcp-fb:119 nack\r\na=rtcp-fb:119 nack pli\r\na=fmtp:119 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=64001f\r\na=rtpmap:120 rtx/90000\r\na=fmtp:120 apt=119\r\na=rtpmap:123 red/90000\r\na=rtpmap:124 rtx/90000\r\na=fmtp:124 apt=123\r\na=rtpmap:125 ulpfec/90000\r\na=ssrc-group:FID 3342233489 1608634717\r\na=ssrc:3342233489 cname:XIpGFz4080OrB+oH\r\na=ssrc:3342233489 msid:aa3a8a8f-a510-400f-a072-cdc071365eaf e01c1321-5fa7-47d9-829a-b781d187c088\r\na=ssrc:1608634717 cname:XIpGFz4080OrB+oH\r\na=ssrc:1608634717 msid:aa3a8a8f-a510-400f-a072-cdc071365eaf e01c1321-5fa7-47d9-829a-b781d187c088\r\n', 'v=0\r\no=- 7480167586315521009 2 IN IP4 127.0.0.1\r\ns=-\r\nt=0 0\r\na=group:BUNDLE 0 1\r\na=extmap-allow-mixed\r\na=msid-semantic: WMS c45173ac-70bf-4c60-88b1-83ea7903757b\r\nm=audio 9 UDP/TLS/RTP/SAVPF 111 63 9 0 8 13 110 126\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:eGr8\r\na=ice-pwd:CvWFgnyXXrbT+7eqoUcR93R5\r\na=ice-options:trickle\r\na=fingerprint:sha-256 5B:9F:04:A0:1F:48:52:DC:FA:44:E3:D0:6C:C8:F9:F8:48:2C:D2:0F:59:A8:72:1B:C6:66:77:4B:0C:AC:4A:46\r\na=setup:active\r\na=mid:0\r\na=extmap:1 urn:ietf:params:rtp-hdrext:ssrc-audio-level\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=sendrecv\r\na=msid:c45173ac-70bf-4c60-88b1-83ea7903757b a5a52e3c-0fdd-4ef9-8968-70170b26ac73\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:111 opus/48000/2\r\na=rtcp-fb:111 transport-cc\r\na=fmtp:111 minptime=10;useinbandfec=1\r\na=rtpmap:63 red/48000/2\r\na=fmtp:63 111/111\r\na=rtpmap:9 G722/8000\r\na=rtpmap:0 PCMU/8000\r\na=rtpmap:8 PCMA/8000\r\na=rtpmap:13 CN/8000\r\na=rtpmap:110 telephone-event/48000\r\na=rtpmap:126 telephone-event/8000\r\na=ssrc:1274806349 cname:kMX+CnYjTTqipSQT\r\nm=video 9 UDP/TLS/RTP/SAVPF 96 97 103 104 107 108 109 114 115 116 117 118 39 40 45 46 98 99 100 101 119 120 123 124 125\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:eGr8\r\na=ice-pwd:CvWFgnyXXrbT+7eqoUcR93R5\r\na=ice-options:trickle\r\na=fingerprint:sha-256 5B:9F:04:A0:1F:48:52:DC:FA:44:E3:D0:6C:C8:F9:F8:48:2C:D2:0F:59:A8:72:1B:C6:66:77:4B:0C:AC:4A:46\r\na=setup:active\r\na=mid:1\r\na=extmap:14 urn:ietf:params:rtp-hdrext:toffset\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:13 urn:3gpp:video-orientation\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:5 http://www.webrtc.org/experiments/rtp-hdrext/playout-delay\r\na=extmap:6 http://www.webrtc.org/experiments/rtp-hdrext/video-content-type\r\na=extmap:7 http://www.webrtc.org/experiments/rtp-hdrext/video-timing\r\na=extmap:8 http://www.webrtc.org/experiments/rtp-hdrext/color-space\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=extmap:10 urn:ietf:params:rtp-hdrext:sdes:rtp-stream-id\r\na=extmap:11 urn:ietf:params:rtp-hdrext:sdes:repaired-rtp-stream-id\r\na=sendrecv\r\na=msid:c45173ac-70bf-4c60-88b1-83ea7903757b 6a95ba40-55d4-4d94-b2cc-2137aa71a43c\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:96 VP8/90000\r\na=rtcp-fb:96 goog-remb\r\na=rtcp-fb:96 transport-cc\r\na=rtcp-fb:96 ccm fir\r\na=rtcp-fb:96 nack\r\na=rtcp-fb:96 nack pli\r\na=rtpmap:97 rtx/90000\r\na=fmtp:97 apt=96\r\na=rtpmap:103 H264/90000\r\na=rtcp-fb:103 goog-remb\r\na=rtcp-fb:103 transport-cc\r\na=rtcp-fb:103 ccm fir\r\na=rtcp-fb:103 nack\r\na=rtcp-fb:103 nack pli\r\na=fmtp:103 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42001f\r\na=rtpmap:104 rtx/90000\r\na=fmtp:104 apt=103\r\na=rtpmap:107 H264/90000\r\na=rtcp-fb:107 goog-remb\r\na=rtcp-fb:107 transport-cc\r\na=rtcp-fb:107 ccm fir\r\na=rtcp-fb:107 nack\r\na=rtcp-fb:107 nack pli\r\na=fmtp:107 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42001f\r\na=rtpmap:108 rtx/90000\r\na=fmtp:108 apt=107\r\na=rtpmap:109 H264/90000\r\na=rtcp-fb:109 goog-remb\r\na=rtcp-fb:109 transport-cc\r\na=rtcp-fb:109 ccm fir\r\na=rtcp-fb:109 nack\r\na=rtcp-fb:109 nack pli\r\na=fmtp:109 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42e01f\r\na=rtpmap:114 rtx/90000\r\na=fmtp:114 apt=109\r\na=rtpmap:115 H264/90000\r\na=rtcp-fb:115 goog-remb\r\na=rtcp-fb:115 transport-cc\r\na=rtcp-fb:115 ccm fir\r\na=rtcp-fb:115 nack\r\na=rtcp-fb:115 nack pli\r\na=fmtp:115 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42e01f\r\na=rtpmap:116 rtx/90000\r\na=fmtp:116 apt=115\r\na=rtpmap:117 H264/90000\r\na=rtcp-fb:117 goog-remb\r\na=rtcp-fb:117 transport-cc\r\na=rtcp-fb:117 ccm fir\r\na=rtcp-fb:117 nack\r\na=rtcp-fb:117 nack pli\r\na=fmtp:117 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=4d001f\r\na=rtpmap:118 rtx/90000\r\na=fmtp:118 apt=117\r\na=rtpmap:39 H264/90000\r\na=rtcp-fb:39 goog-remb\r\na=rtcp-fb:39 transport-cc\r\na=rtcp-fb:39 ccm fir\r\na=rtcp-fb:39 nack\r\na=rtcp-fb:39 nack pli\r\na=fmtp:39 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=4d001f\r\na=rtpmap:40 rtx/90000\r\na=fmtp:40 apt=39\r\na=rtpmap:45 AV1/90000\r\na=rtcp-fb:45 goog-remb\r\na=rtcp-fb:45 transport-cc\r\na=rtcp-fb:45 ccm fir\r\na=rtcp-fb:45 nack\r\na=rtcp-fb:45 nack pli\r\na=fmtp:45 level-idx=5;profile=0;tier=0\r\na=rtpmap:46 rtx/90000\r\na=fmtp:46 apt=45\r\na=rtpmap:98 VP9/90000\r\na=rtcp-fb:98 goog-remb\r\na=rtcp-fb:98 transport-cc\r\na=rtcp-fb:98 ccm fir\r\na=rtcp-fb:98 nack\r\na=rtcp-fb:98 nack pli\r\na=fmtp:98 profile-id=0\r\na=rtpmap:99 rtx/90000\r\na=fmtp:99 apt=98\r\na=rtpmap:100 VP9/90000\r\na=rtcp-fb:100 goog-remb\r\na=rtcp-fb:100 transport-cc\r\na=rtcp-fb:100 ccm fir\r\na=rtcp-fb:100 nack\r\na=rtcp-fb:100 nack pli\r\na=fmtp:100 profile-id=2\r\na=rtpmap:101 rtx/90000\r\na=fmtp:101 apt=100\r\na=rtpmap:119 H264/90000\r\na=rtcp-fb:119 goog-remb\r\na=rtcp-fb:119 transport-cc\r\na=rtcp-fb:119 ccm fir\r\na=rtcp-fb:119 nack\r\na=rtcp-fb:119 nack pli\r\na=fmtp:119 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=64001f\r\na=rtpmap:120 rtx/90000\r\na=fmtp:120 apt=119\r\na=rtpmap:123 red/90000\r\na=rtpmap:124 rtx/90000\r\na=fmtp:124 apt=123\r\na=rtpmap:125 ulpfec/90000\r\na=ssrc-group:FID 2949725841 160417753\r\na=ssrc:2949725841 cname:kMX+CnYjTTqipSQT\r\na=ssrc:160417753 cname:kMX+CnYjTTqipSQT\r\n', NULL, '[{\"candidate\":\"candidate:2327553892 1 udp 2122260223 172.16.1.129 62649 typ host generation 0 ufrag eGr8 network-id 1 network-cost 10\",\"sdpMid\":\"0\",\"sdpMLineIndex\":0,\"usernameFragment\":\"eGr8\"},{\"candidate\":\"candidate:636569178 1 udp 1686052607 216.184.111.2 62649 typ srflx raddr 172.16.1.129 rport 62649 generation 0 ufrag eGr8 network-id 1 network-cost 10\",\"sdpMid\":\"0\",\"sdpMLineIndex\":0,\"usernameFragment\":\"eGr8\"},{\"candidate\":\"candidate:1947300848 1 tcp 1518280447 172.16.1.129 9 typ host tcptype active generation 0 ufrag eGr8 network-id 1 network-cost 10\",\"sdpMid\":\"0\",\"sdpMLineIndex\":0,\"usernameFragment\":\"eGr8\"}]', '2026-05-28 21:12:00'),
(3, 2, 1, 'video', 'hungup', 'v=0\r\no=- 4017135782328459057 2 IN IP4 127.0.0.1\r\ns=-\r\nt=0 0\r\na=group:BUNDLE 0 1\r\na=extmap-allow-mixed\r\na=msid-semantic: WMS 9fae3cb6-94ec-4ba2-b385-24e40657d956\r\nm=audio 9 UDP/TLS/RTP/SAVPF 111 63 9 0 8 13 110 126\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:lBGH\r\na=ice-pwd:yYBTWxnmMGQEgFJOUtoCGiyu\r\na=ice-options:trickle\r\na=fingerprint:sha-256 81:89:4D:3B:B8:11:BF:71:F0:47:46:3D:5A:A7:DB:B5:A2:1C:19:C0:61:94:A2:8A:85:1D:3B:B5:9C:2E:8D:F0\r\na=setup:actpass\r\na=mid:0\r\na=extmap:1 urn:ietf:params:rtp-hdrext:ssrc-audio-level\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=sendrecv\r\na=msid:9fae3cb6-94ec-4ba2-b385-24e40657d956 70bbe614-aef1-4bf7-bc4f-08d7d76486cc\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:111 opus/48000/2\r\na=rtcp-fb:111 transport-cc\r\na=fmtp:111 minptime=10;useinbandfec=1\r\na=rtpmap:63 red/48000/2\r\na=fmtp:63 111/111\r\na=rtpmap:9 G722/8000\r\na=rtpmap:0 PCMU/8000\r\na=rtpmap:8 PCMA/8000\r\na=rtpmap:13 CN/8000\r\na=rtpmap:110 telephone-event/48000\r\na=rtpmap:126 telephone-event/8000\r\na=ssrc:1268525237 cname:qxn/PLhzQ3iPhBK5\r\na=ssrc:1268525237 msid:9fae3cb6-94ec-4ba2-b385-24e40657d956 70bbe614-aef1-4bf7-bc4f-08d7d76486cc\r\nm=video 9 UDP/TLS/RTP/SAVPF 96 97 103 104 107 108 109 114 115 116 117 118 39 40 45 46 98 99 100 101 119 120 123 124 125\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:lBGH\r\na=ice-pwd:yYBTWxnmMGQEgFJOUtoCGiyu\r\na=ice-options:trickle\r\na=fingerprint:sha-256 81:89:4D:3B:B8:11:BF:71:F0:47:46:3D:5A:A7:DB:B5:A2:1C:19:C0:61:94:A2:8A:85:1D:3B:B5:9C:2E:8D:F0\r\na=setup:actpass\r\na=mid:1\r\na=extmap:14 urn:ietf:params:rtp-hdrext:toffset\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:13 urn:3gpp:video-orientation\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:5 http://www.webrtc.org/experiments/rtp-hdrext/playout-delay\r\na=extmap:6 http://www.webrtc.org/experiments/rtp-hdrext/video-content-type\r\na=extmap:7 http://www.webrtc.org/experiments/rtp-hdrext/video-timing\r\na=extmap:8 http://www.webrtc.org/experiments/rtp-hdrext/color-space\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=extmap:10 urn:ietf:params:rtp-hdrext:sdes:rtp-stream-id\r\na=extmap:11 urn:ietf:params:rtp-hdrext:sdes:repaired-rtp-stream-id\r\na=sendrecv\r\na=msid:9fae3cb6-94ec-4ba2-b385-24e40657d956 29cb23a5-c88e-473f-b04a-3cf96025ad65\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:96 VP8/90000\r\na=rtcp-fb:96 goog-remb\r\na=rtcp-fb:96 transport-cc\r\na=rtcp-fb:96 ccm fir\r\na=rtcp-fb:96 nack\r\na=rtcp-fb:96 nack pli\r\na=rtpmap:97 rtx/90000\r\na=fmtp:97 apt=96\r\na=rtpmap:103 H264/90000\r\na=rtcp-fb:103 goog-remb\r\na=rtcp-fb:103 transport-cc\r\na=rtcp-fb:103 ccm fir\r\na=rtcp-fb:103 nack\r\na=rtcp-fb:103 nack pli\r\na=fmtp:103 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42001f\r\na=rtpmap:104 rtx/90000\r\na=fmtp:104 apt=103\r\na=rtpmap:107 H264/90000\r\na=rtcp-fb:107 goog-remb\r\na=rtcp-fb:107 transport-cc\r\na=rtcp-fb:107 ccm fir\r\na=rtcp-fb:107 nack\r\na=rtcp-fb:107 nack pli\r\na=fmtp:107 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42001f\r\na=rtpmap:108 rtx/90000\r\na=fmtp:108 apt=107\r\na=rtpmap:109 H264/90000\r\na=rtcp-fb:109 goog-remb\r\na=rtcp-fb:109 transport-cc\r\na=rtcp-fb:109 ccm fir\r\na=rtcp-fb:109 nack\r\na=rtcp-fb:109 nack pli\r\na=fmtp:109 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42e01f\r\na=rtpmap:114 rtx/90000\r\na=fmtp:114 apt=109\r\na=rtpmap:115 H264/90000\r\na=rtcp-fb:115 goog-remb\r\na=rtcp-fb:115 transport-cc\r\na=rtcp-fb:115 ccm fir\r\na=rtcp-fb:115 nack\r\na=rtcp-fb:115 nack pli\r\na=fmtp:115 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42e01f\r\na=rtpmap:116 rtx/90000\r\na=fmtp:116 apt=115\r\na=rtpmap:117 H264/90000\r\na=rtcp-fb:117 goog-remb\r\na=rtcp-fb:117 transport-cc\r\na=rtcp-fb:117 ccm fir\r\na=rtcp-fb:117 nack\r\na=rtcp-fb:117 nack pli\r\na=fmtp:117 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=4d001f\r\na=rtpmap:118 rtx/90000\r\na=fmtp:118 apt=117\r\na=rtpmap:39 H264/90000\r\na=rtcp-fb:39 goog-remb\r\na=rtcp-fb:39 transport-cc\r\na=rtcp-fb:39 ccm fir\r\na=rtcp-fb:39 nack\r\na=rtcp-fb:39 nack pli\r\na=fmtp:39 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=4d001f\r\na=rtpmap:40 rtx/90000\r\na=fmtp:40 apt=39\r\na=rtpmap:45 AV1/90000\r\na=rtcp-fb:45 goog-remb\r\na=rtcp-fb:45 transport-cc\r\na=rtcp-fb:45 ccm fir\r\na=rtcp-fb:45 nack\r\na=rtcp-fb:45 nack pli\r\na=fmtp:45 level-idx=5;profile=0;tier=0\r\na=rtpmap:46 rtx/90000\r\na=fmtp:46 apt=45\r\na=rtpmap:98 VP9/90000\r\na=rtcp-fb:98 goog-remb\r\na=rtcp-fb:98 transport-cc\r\na=rtcp-fb:98 ccm fir\r\na=rtcp-fb:98 nack\r\na=rtcp-fb:98 nack pli\r\na=fmtp:98 profile-id=0\r\na=rtpmap:99 rtx/90000\r\na=fmtp:99 apt=98\r\na=rtpmap:100 VP9/90000\r\na=rtcp-fb:100 goog-remb\r\na=rtcp-fb:100 transport-cc\r\na=rtcp-fb:100 ccm fir\r\na=rtcp-fb:100 nack\r\na=rtcp-fb:100 nack pli\r\na=fmtp:100 profile-id=2\r\na=rtpmap:101 rtx/90000\r\na=fmtp:101 apt=100\r\na=rtpmap:119 H264/90000\r\na=rtcp-fb:119 goog-remb\r\na=rtcp-fb:119 transport-cc\r\na=rtcp-fb:119 ccm fir\r\na=rtcp-fb:119 nack\r\na=rtcp-fb:119 nack pli\r\na=fmtp:119 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=64001f\r\na=rtpmap:120 rtx/90000\r\na=fmtp:120 apt=119\r\na=rtpmap:123 red/90000\r\na=rtpmap:124 rtx/90000\r\na=fmtp:124 apt=123\r\na=rtpmap:125 ulpfec/90000\r\na=ssrc-group:FID 3975407378 2640860009\r\na=ssrc:3975407378 cname:qxn/PLhzQ3iPhBK5\r\na=ssrc:3975407378 msid:9fae3cb6-94ec-4ba2-b385-24e40657d956 29cb23a5-c88e-473f-b04a-3cf96025ad65\r\na=ssrc:2640860009 cname:qxn/PLhzQ3iPhBK5\r\na=ssrc:2640860009 msid:9fae3cb6-94ec-4ba2-b385-24e40657d956 29cb23a5-c88e-473f-b04a-3cf96025ad65\r\n', 'v=0\r\no=- 900155794174711117 2 IN IP4 127.0.0.1\r\ns=-\r\nt=0 0\r\na=group:BUNDLE 0 1\r\na=extmap-allow-mixed\r\na=msid-semantic: WMS aa084aa5-debd-4a3b-a2e2-e9916b9a1fc6\r\nm=audio 9 UDP/TLS/RTP/SAVPF 111 63 9 0 8 13 110 126\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:to+Z\r\na=ice-pwd:AmK9CWpFq3ZffwCQRObep5RU\r\na=ice-options:trickle\r\na=fingerprint:sha-256 5B:77:FE:56:D7:EE:12:07:5B:1E:BC:73:C0:B8:F2:B2:3B:B9:AB:06:3A:E1:BC:F1:28:CB:18:CC:3B:19:D2:D1\r\na=setup:active\r\na=mid:0\r\na=extmap:1 urn:ietf:params:rtp-hdrext:ssrc-audio-level\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=sendrecv\r\na=msid:aa084aa5-debd-4a3b-a2e2-e9916b9a1fc6 2d343380-8253-402f-b558-aa3a5c3cfd95\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:111 opus/48000/2\r\na=rtcp-fb:111 transport-cc\r\na=fmtp:111 minptime=10;useinbandfec=1\r\na=rtpmap:63 red/48000/2\r\na=fmtp:63 111/111\r\na=rtpmap:9 G722/8000\r\na=rtpmap:0 PCMU/8000\r\na=rtpmap:8 PCMA/8000\r\na=rtpmap:13 CN/8000\r\na=rtpmap:110 telephone-event/48000\r\na=rtpmap:126 telephone-event/8000\r\na=ssrc:1292647025 cname:cSwGXRdzhVZzi/1g\r\nm=video 9 UDP/TLS/RTP/SAVPF 96 97 103 104 107 108 109 114 115 116 117 118 39 40 45 46 98 99 100 101 119 120 123 124 125\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:to+Z\r\na=ice-pwd:AmK9CWpFq3ZffwCQRObep5RU\r\na=ice-options:trickle\r\na=fingerprint:sha-256 5B:77:FE:56:D7:EE:12:07:5B:1E:BC:73:C0:B8:F2:B2:3B:B9:AB:06:3A:E1:BC:F1:28:CB:18:CC:3B:19:D2:D1\r\na=setup:active\r\na=mid:1\r\na=extmap:14 urn:ietf:params:rtp-hdrext:toffset\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:13 urn:3gpp:video-orientation\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:5 http://www.webrtc.org/experiments/rtp-hdrext/playout-delay\r\na=extmap:6 http://www.webrtc.org/experiments/rtp-hdrext/video-content-type\r\na=extmap:7 http://www.webrtc.org/experiments/rtp-hdrext/video-timing\r\na=extmap:8 http://www.webrtc.org/experiments/rtp-hdrext/color-space\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=extmap:10 urn:ietf:params:rtp-hdrext:sdes:rtp-stream-id\r\na=extmap:11 urn:ietf:params:rtp-hdrext:sdes:repaired-rtp-stream-id\r\na=sendrecv\r\na=msid:aa084aa5-debd-4a3b-a2e2-e9916b9a1fc6 8b52bf82-a449-4782-b9f3-c0702abfdf6c\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:96 VP8/90000\r\na=rtcp-fb:96 goog-remb\r\na=rtcp-fb:96 transport-cc\r\na=rtcp-fb:96 ccm fir\r\na=rtcp-fb:96 nack\r\na=rtcp-fb:96 nack pli\r\na=rtpmap:97 rtx/90000\r\na=fmtp:97 apt=96\r\na=rtpmap:103 H264/90000\r\na=rtcp-fb:103 goog-remb\r\na=rtcp-fb:103 transport-cc\r\na=rtcp-fb:103 ccm fir\r\na=rtcp-fb:103 nack\r\na=rtcp-fb:103 nack pli\r\na=fmtp:103 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42001f\r\na=rtpmap:104 rtx/90000\r\na=fmtp:104 apt=103\r\na=rtpmap:107 H264/90000\r\na=rtcp-fb:107 goog-remb\r\na=rtcp-fb:107 transport-cc\r\na=rtcp-fb:107 ccm fir\r\na=rtcp-fb:107 nack\r\na=rtcp-fb:107 nack pli\r\na=fmtp:107 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42001f\r\na=rtpmap:108 rtx/90000\r\na=fmtp:108 apt=107\r\na=rtpmap:109 H264/90000\r\na=rtcp-fb:109 goog-remb\r\na=rtcp-fb:109 transport-cc\r\na=rtcp-fb:109 ccm fir\r\na=rtcp-fb:109 nack\r\na=rtcp-fb:109 nack pli\r\na=fmtp:109 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42e01f\r\na=rtpmap:114 rtx/90000\r\na=fmtp:114 apt=109\r\na=rtpmap:115 H264/90000\r\na=rtcp-fb:115 goog-remb\r\na=rtcp-fb:115 transport-cc\r\na=rtcp-fb:115 ccm fir\r\na=rtcp-fb:115 nack\r\na=rtcp-fb:115 nack pli\r\na=fmtp:115 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42e01f\r\na=rtpmap:116 rtx/90000\r\na=fmtp:116 apt=115\r\na=rtpmap:117 H264/90000\r\na=rtcp-fb:117 goog-remb\r\na=rtcp-fb:117 transport-cc\r\na=rtcp-fb:117 ccm fir\r\na=rtcp-fb:117 nack\r\na=rtcp-fb:117 nack pli\r\na=fmtp:117 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=4d001f\r\na=rtpmap:118 rtx/90000\r\na=fmtp:118 apt=117\r\na=rtpmap:39 H264/90000\r\na=rtcp-fb:39 goog-remb\r\na=rtcp-fb:39 transport-cc\r\na=rtcp-fb:39 ccm fir\r\na=rtcp-fb:39 nack\r\na=rtcp-fb:39 nack pli\r\na=fmtp:39 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=4d001f\r\na=rtpmap:40 rtx/90000\r\na=fmtp:40 apt=39\r\na=rtpmap:45 AV1/90000\r\na=rtcp-fb:45 goog-remb\r\na=rtcp-fb:45 transport-cc\r\na=rtcp-fb:45 ccm fir\r\na=rtcp-fb:45 nack\r\na=rtcp-fb:45 nack pli\r\na=fmtp:45 level-idx=5;profile=0;tier=0\r\na=rtpmap:46 rtx/90000\r\na=fmtp:46 apt=45\r\na=rtpmap:98 VP9/90000\r\na=rtcp-fb:98 goog-remb\r\na=rtcp-fb:98 transport-cc\r\na=rtcp-fb:98 ccm fir\r\na=rtcp-fb:98 nack\r\na=rtcp-fb:98 nack pli\r\na=fmtp:98 profile-id=0\r\na=rtpmap:99 rtx/90000\r\na=fmtp:99 apt=98\r\na=rtpmap:100 VP9/90000\r\na=rtcp-fb:100 goog-remb\r\na=rtcp-fb:100 transport-cc\r\na=rtcp-fb:100 ccm fir\r\na=rtcp-fb:100 nack\r\na=rtcp-fb:100 nack pli\r\na=fmtp:100 profile-id=2\r\na=rtpmap:101 rtx/90000\r\na=fmtp:101 apt=100\r\na=rtpmap:119 H264/90000\r\na=rtcp-fb:119 goog-remb\r\na=rtcp-fb:119 transport-cc\r\na=rtcp-fb:119 ccm fir\r\na=rtcp-fb:119 nack\r\na=rtcp-fb:119 nack pli\r\na=fmtp:119 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=64001f\r\na=rtpmap:120 rtx/90000\r\na=fmtp:120 apt=119\r\na=rtpmap:123 red/90000\r\na=rtpmap:124 rtx/90000\r\na=fmtp:124 apt=123\r\na=rtpmap:125 ulpfec/90000\r\na=ssrc-group:FID 921237690 624837518\r\na=ssrc:921237690 cname:cSwGXRdzhVZzi/1g\r\na=ssrc:624837518 cname:cSwGXRdzhVZzi/1g\r\n', '[{\"candidate\":\"candidate:1075864661 1 tcp 1518280447 172.16.1.129 9 typ host tcptype active generation 0 ufrag lBGH network-id 1 network-cost 10\",\"sdpMid\":\"0\",\"sdpMLineIndex\":0,\"usernameFragment\":\"lBGH\"},{\"candidate\":\"candidate:1075864661 1 tcp 1518280447 172.16.1.129 9 typ host tcptype active generation 0 ufrag lBGH network-id 1 network-cost 10\",\"sdpMid\":\"1\",\"sdpMLineIndex\":1,\"usernameFragment\":\"lBGH\"}]', '[{\"candidate\":\"candidate:887736126 1 udp 2122260223 172.16.1.129 62838 typ host generation 0 ufrag to+Z network-id 1 network-cost 10\",\"sdpMid\":\"0\",\"sdpMLineIndex\":0,\"usernameFragment\":\"to+Z\"},{\"candidate\":\"candidate:1947448727 1 udp 1686052607 216.184.111.2 62838 typ srflx raddr 172.16.1.129 rport 62838 generation 0 ufrag to+Z network-id 1 network-cost 10\",\"sdpMid\":\"0\",\"sdpMLineIndex\":0,\"usernameFragment\":\"to+Z\"},{\"candidate\":\"candidate:1244013990 1 tcp 1518280447 172.16.1.129 9 typ host tcptype active generation 0 ufrag to+Z network-id 1 network-cost 10\",\"sdpMid\":\"0\",\"sdpMLineIndex\":0,\"usernameFragment\":\"to+Z\"}]', '2026-05-28 21:12:25'),
(4, 1, 2, 'video', 'missed', 'v=0\r\no=- 3165111841578950839 2 IN IP4 127.0.0.1\r\ns=-\r\nt=0 0\r\na=group:BUNDLE 0 1\r\na=extmap-allow-mixed\r\na=msid-semantic: WMS f8e30982-6a77-4979-8f0d-f0ffa2e5c2f0\r\nm=audio 9 UDP/TLS/RTP/SAVPF 111 63 9 0 8 13 110 126\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:ca15\r\na=ice-pwd:XkuLxo6wnHIbhi/sAl1XAAWm\r\na=ice-options:trickle\r\na=fingerprint:sha-256 1D:32:2E:70:B3:F1:06:DF:81:F3:43:BC:3D:BF:35:C2:64:BE:46:6F:DD:36:0F:3B:9F:B6:23:62:4F:97:32:58\r\na=setup:actpass\r\na=mid:0\r\na=extmap:1 urn:ietf:params:rtp-hdrext:ssrc-audio-level\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=sendrecv\r\na=msid:f8e30982-6a77-4979-8f0d-f0ffa2e5c2f0 298c73cb-35b4-4c8a-876d-5db72cca607a\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:111 opus/48000/2\r\na=rtcp-fb:111 transport-cc\r\na=fmtp:111 minptime=10;useinbandfec=1\r\na=rtpmap:63 red/48000/2\r\na=fmtp:63 111/111\r\na=rtpmap:9 G722/8000\r\na=rtpmap:0 PCMU/8000\r\na=rtpmap:8 PCMA/8000\r\na=rtpmap:13 CN/8000\r\na=rtpmap:110 telephone-event/48000\r\na=rtpmap:126 telephone-event/8000\r\na=ssrc:687085607 cname:2rZzGpVdvU4khxB0\r\na=ssrc:687085607 msid:f8e30982-6a77-4979-8f0d-f0ffa2e5c2f0 298c73cb-35b4-4c8a-876d-5db72cca607a\r\nm=video 9 UDP/TLS/RTP/SAVPF 96 97 103 104 107 108 109 114 115 116 117 118 39 40 45 46 98 99 100 101 119 120 123 124 125\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:ca15\r\na=ice-pwd:XkuLxo6wnHIbhi/sAl1XAAWm\r\na=ice-options:trickle\r\na=fingerprint:sha-256 1D:32:2E:70:B3:F1:06:DF:81:F3:43:BC:3D:BF:35:C2:64:BE:46:6F:DD:36:0F:3B:9F:B6:23:62:4F:97:32:58\r\na=setup:actpass\r\na=mid:1\r\na=extmap:14 urn:ietf:params:rtp-hdrext:toffset\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:13 urn:3gpp:video-orientation\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:5 http://www.webrtc.org/experiments/rtp-hdrext/playout-delay\r\na=extmap:6 http://www.webrtc.org/experiments/rtp-hdrext/video-content-type\r\na=extmap:7 http://www.webrtc.org/experiments/rtp-hdrext/video-timing\r\na=extmap:8 http://www.webrtc.org/experiments/rtp-hdrext/color-space\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=extmap:10 urn:ietf:params:rtp-hdrext:sdes:rtp-stream-id\r\na=extmap:11 urn:ietf:params:rtp-hdrext:sdes:repaired-rtp-stream-id\r\na=sendrecv\r\na=msid:f8e30982-6a77-4979-8f0d-f0ffa2e5c2f0 31d138d9-9156-4370-aa74-88a33c0bfe72\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:96 VP8/90000\r\na=rtcp-fb:96 goog-remb\r\na=rtcp-fb:96 transport-cc\r\na=rtcp-fb:96 ccm fir\r\na=rtcp-fb:96 nack\r\na=rtcp-fb:96 nack pli\r\na=rtpmap:97 rtx/90000\r\na=fmtp:97 apt=96\r\na=rtpmap:103 H264/90000\r\na=rtcp-fb:103 goog-remb\r\na=rtcp-fb:103 transport-cc\r\na=rtcp-fb:103 ccm fir\r\na=rtcp-fb:103 nack\r\na=rtcp-fb:103 nack pli\r\na=fmtp:103 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42001f\r\na=rtpmap:104 rtx/90000\r\na=fmtp:104 apt=103\r\na=rtpmap:107 H264/90000\r\na=rtcp-fb:107 goog-remb\r\na=rtcp-fb:107 transport-cc\r\na=rtcp-fb:107 ccm fir\r\na=rtcp-fb:107 nack\r\na=rtcp-fb:107 nack pli\r\na=fmtp:107 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42001f\r\na=rtpmap:108 rtx/90000\r\na=fmtp:108 apt=107\r\na=rtpmap:109 H264/90000\r\na=rtcp-fb:109 goog-remb\r\na=rtcp-fb:109 transport-cc\r\na=rtcp-fb:109 ccm fir\r\na=rtcp-fb:109 nack\r\na=rtcp-fb:109 nack pli\r\na=fmtp:109 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42e01f\r\na=rtpmap:114 rtx/90000\r\na=fmtp:114 apt=109\r\na=rtpmap:115 H264/90000\r\na=rtcp-fb:115 goog-remb\r\na=rtcp-fb:115 transport-cc\r\na=rtcp-fb:115 ccm fir\r\na=rtcp-fb:115 nack\r\na=rtcp-fb:115 nack pli\r\na=fmtp:115 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42e01f\r\na=rtpmap:116 rtx/90000\r\na=fmtp:116 apt=115\r\na=rtpmap:117 H264/90000\r\na=rtcp-fb:117 goog-remb\r\na=rtcp-fb:117 transport-cc\r\na=rtcp-fb:117 ccm fir\r\na=rtcp-fb:117 nack\r\na=rtcp-fb:117 nack pli\r\na=fmtp:117 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=4d001f\r\na=rtpmap:118 rtx/90000\r\na=fmtp:118 apt=117\r\na=rtpmap:39 H264/90000\r\na=rtcp-fb:39 goog-remb\r\na=rtcp-fb:39 transport-cc\r\na=rtcp-fb:39 ccm fir\r\na=rtcp-fb:39 nack\r\na=rtcp-fb:39 nack pli\r\na=fmtp:39 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=4d001f\r\na=rtpmap:40 rtx/90000\r\na=fmtp:40 apt=39\r\na=rtpmap:45 AV1/90000\r\na=rtcp-fb:45 goog-remb\r\na=rtcp-fb:45 transport-cc\r\na=rtcp-fb:45 ccm fir\r\na=rtcp-fb:45 nack\r\na=rtcp-fb:45 nack pli\r\na=fmtp:45 level-idx=5;profile=0;tier=0\r\na=rtpmap:46 rtx/90000\r\na=fmtp:46 apt=45\r\na=rtpmap:98 VP9/90000\r\na=rtcp-fb:98 goog-remb\r\na=rtcp-fb:98 transport-cc\r\na=rtcp-fb:98 ccm fir\r\na=rtcp-fb:98 nack\r\na=rtcp-fb:98 nack pli\r\na=fmtp:98 profile-id=0\r\na=rtpmap:99 rtx/90000\r\na=fmtp:99 apt=98\r\na=rtpmap:100 VP9/90000\r\na=rtcp-fb:100 goog-remb\r\na=rtcp-fb:100 transport-cc\r\na=rtcp-fb:100 ccm fir\r\na=rtcp-fb:100 nack\r\na=rtcp-fb:100 nack pli\r\na=fmtp:100 profile-id=2\r\na=rtpmap:101 rtx/90000\r\na=fmtp:101 apt=100\r\na=rtpmap:119 H264/90000\r\na=rtcp-fb:119 goog-remb\r\na=rtcp-fb:119 transport-cc\r\na=rtcp-fb:119 ccm fir\r\na=rtcp-fb:119 nack\r\na=rtcp-fb:119 nack pli\r\na=fmtp:119 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=64001f\r\na=rtpmap:120 rtx/90000\r\na=fmtp:120 apt=119\r\na=rtpmap:123 red/90000\r\na=rtpmap:124 rtx/90000\r\na=fmtp:124 apt=123\r\na=rtpmap:125 ulpfec/90000\r\na=ssrc-group:FID 3392223143 774748943\r\na=ssrc:3392223143 cname:2rZzGpVdvU4khxB0\r\na=ssrc:3392223143 msid:f8e30982-6a77-4979-8f0d-f0ffa2e5c2f0 31d138d9-9156-4370-aa74-88a33c0bfe72\r\na=ssrc:774748943 cname:2rZzGpVdvU4khxB0\r\na=ssrc:774748943 msid:f8e30982-6a77-4979-8f0d-f0ffa2e5c2f0 31d138d9-9156-4370-aa74-88a33c0bfe72\r\n', NULL, NULL, NULL, '2026-05-28 21:32:10');
INSERT INTO `chat_llamadas` (`id`, `id_remitente`, `id_receptor`, `tipo`, `estado`, `sdp_offer`, `sdp_answer`, `ice_candidates_remitente`, `ice_candidates_receptor`, `fecha`) VALUES
(5, 1, 2, 'video', 'hungup', 'v=0\r\no=- 7830950198755619973 2 IN IP4 127.0.0.1\r\ns=-\r\nt=0 0\r\na=group:BUNDLE 0 1\r\na=extmap-allow-mixed\r\na=msid-semantic: WMS c5a3fb2e-c7eb-423d-83d3-ce3f36f01e5b\r\nm=audio 9 UDP/TLS/RTP/SAVPF 111 63 9 0 8 13 110 126\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:WdeO\r\na=ice-pwd:u38WzbKifug0s8RkTUbSCBWy\r\na=ice-options:trickle\r\na=fingerprint:sha-256 38:4C:E7:E9:B5:28:C1:7B:71:10:08:97:56:4E:DE:22:AF:F2:73:E7:55:D6:2D:2B:E3:99:6E:A9:A8:49:C5:51\r\na=setup:actpass\r\na=mid:0\r\na=extmap:1 urn:ietf:params:rtp-hdrext:ssrc-audio-level\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=sendrecv\r\na=msid:c5a3fb2e-c7eb-423d-83d3-ce3f36f01e5b 42ddd5f8-f6a6-4267-bbdd-7fa90de936d5\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:111 opus/48000/2\r\na=rtcp-fb:111 transport-cc\r\na=fmtp:111 minptime=10;useinbandfec=1\r\na=rtpmap:63 red/48000/2\r\na=fmtp:63 111/111\r\na=rtpmap:9 G722/8000\r\na=rtpmap:0 PCMU/8000\r\na=rtpmap:8 PCMA/8000\r\na=rtpmap:13 CN/8000\r\na=rtpmap:110 telephone-event/48000\r\na=rtpmap:126 telephone-event/8000\r\na=ssrc:3270894275 cname:MkIJo2dVUw8Bk9Sb\r\na=ssrc:3270894275 msid:c5a3fb2e-c7eb-423d-83d3-ce3f36f01e5b 42ddd5f8-f6a6-4267-bbdd-7fa90de936d5\r\nm=video 9 UDP/TLS/RTP/SAVPF 96 97 103 104 107 108 109 114 115 116 117 118 39 40 45 46 98 99 100 101 119 120 123 124 125\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:WdeO\r\na=ice-pwd:u38WzbKifug0s8RkTUbSCBWy\r\na=ice-options:trickle\r\na=fingerprint:sha-256 38:4C:E7:E9:B5:28:C1:7B:71:10:08:97:56:4E:DE:22:AF:F2:73:E7:55:D6:2D:2B:E3:99:6E:A9:A8:49:C5:51\r\na=setup:actpass\r\na=mid:1\r\na=extmap:14 urn:ietf:params:rtp-hdrext:toffset\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:13 urn:3gpp:video-orientation\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:5 http://www.webrtc.org/experiments/rtp-hdrext/playout-delay\r\na=extmap:6 http://www.webrtc.org/experiments/rtp-hdrext/video-content-type\r\na=extmap:7 http://www.webrtc.org/experiments/rtp-hdrext/video-timing\r\na=extmap:8 http://www.webrtc.org/experiments/rtp-hdrext/color-space\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=extmap:10 urn:ietf:params:rtp-hdrext:sdes:rtp-stream-id\r\na=extmap:11 urn:ietf:params:rtp-hdrext:sdes:repaired-rtp-stream-id\r\na=sendrecv\r\na=msid:c5a3fb2e-c7eb-423d-83d3-ce3f36f01e5b 41f56152-b9a4-4897-b4a8-0c67403e86a7\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:96 VP8/90000\r\na=rtcp-fb:96 goog-remb\r\na=rtcp-fb:96 transport-cc\r\na=rtcp-fb:96 ccm fir\r\na=rtcp-fb:96 nack\r\na=rtcp-fb:96 nack pli\r\na=rtpmap:97 rtx/90000\r\na=fmtp:97 apt=96\r\na=rtpmap:103 H264/90000\r\na=rtcp-fb:103 goog-remb\r\na=rtcp-fb:103 transport-cc\r\na=rtcp-fb:103 ccm fir\r\na=rtcp-fb:103 nack\r\na=rtcp-fb:103 nack pli\r\na=fmtp:103 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42001f\r\na=rtpmap:104 rtx/90000\r\na=fmtp:104 apt=103\r\na=rtpmap:107 H264/90000\r\na=rtcp-fb:107 goog-remb\r\na=rtcp-fb:107 transport-cc\r\na=rtcp-fb:107 ccm fir\r\na=rtcp-fb:107 nack\r\na=rtcp-fb:107 nack pli\r\na=fmtp:107 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42001f\r\na=rtpmap:108 rtx/90000\r\na=fmtp:108 apt=107\r\na=rtpmap:109 H264/90000\r\na=rtcp-fb:109 goog-remb\r\na=rtcp-fb:109 transport-cc\r\na=rtcp-fb:109 ccm fir\r\na=rtcp-fb:109 nack\r\na=rtcp-fb:109 nack pli\r\na=fmtp:109 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42e01f\r\na=rtpmap:114 rtx/90000\r\na=fmtp:114 apt=109\r\na=rtpmap:115 H264/90000\r\na=rtcp-fb:115 goog-remb\r\na=rtcp-fb:115 transport-cc\r\na=rtcp-fb:115 ccm fir\r\na=rtcp-fb:115 nack\r\na=rtcp-fb:115 nack pli\r\na=fmtp:115 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42e01f\r\na=rtpmap:116 rtx/90000\r\na=fmtp:116 apt=115\r\na=rtpmap:117 H264/90000\r\na=rtcp-fb:117 goog-remb\r\na=rtcp-fb:117 transport-cc\r\na=rtcp-fb:117 ccm fir\r\na=rtcp-fb:117 nack\r\na=rtcp-fb:117 nack pli\r\na=fmtp:117 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=4d001f\r\na=rtpmap:118 rtx/90000\r\na=fmtp:118 apt=117\r\na=rtpmap:39 H264/90000\r\na=rtcp-fb:39 goog-remb\r\na=rtcp-fb:39 transport-cc\r\na=rtcp-fb:39 ccm fir\r\na=rtcp-fb:39 nack\r\na=rtcp-fb:39 nack pli\r\na=fmtp:39 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=4d001f\r\na=rtpmap:40 rtx/90000\r\na=fmtp:40 apt=39\r\na=rtpmap:45 AV1/90000\r\na=rtcp-fb:45 goog-remb\r\na=rtcp-fb:45 transport-cc\r\na=rtcp-fb:45 ccm fir\r\na=rtcp-fb:45 nack\r\na=rtcp-fb:45 nack pli\r\na=fmtp:45 level-idx=5;profile=0;tier=0\r\na=rtpmap:46 rtx/90000\r\na=fmtp:46 apt=45\r\na=rtpmap:98 VP9/90000\r\na=rtcp-fb:98 goog-remb\r\na=rtcp-fb:98 transport-cc\r\na=rtcp-fb:98 ccm fir\r\na=rtcp-fb:98 nack\r\na=rtcp-fb:98 nack pli\r\na=fmtp:98 profile-id=0\r\na=rtpmap:99 rtx/90000\r\na=fmtp:99 apt=98\r\na=rtpmap:100 VP9/90000\r\na=rtcp-fb:100 goog-remb\r\na=rtcp-fb:100 transport-cc\r\na=rtcp-fb:100 ccm fir\r\na=rtcp-fb:100 nack\r\na=rtcp-fb:100 nack pli\r\na=fmtp:100 profile-id=2\r\na=rtpmap:101 rtx/90000\r\na=fmtp:101 apt=100\r\na=rtpmap:119 H264/90000\r\na=rtcp-fb:119 goog-remb\r\na=rtcp-fb:119 transport-cc\r\na=rtcp-fb:119 ccm fir\r\na=rtcp-fb:119 nack\r\na=rtcp-fb:119 nack pli\r\na=fmtp:119 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=64001f\r\na=rtpmap:120 rtx/90000\r\na=fmtp:120 apt=119\r\na=rtpmap:123 red/90000\r\na=rtpmap:124 rtx/90000\r\na=fmtp:124 apt=123\r\na=rtpmap:125 ulpfec/90000\r\na=ssrc-group:FID 2718459780 3781211321\r\na=ssrc:2718459780 cname:MkIJo2dVUw8Bk9Sb\r\na=ssrc:2718459780 msid:c5a3fb2e-c7eb-423d-83d3-ce3f36f01e5b 41f56152-b9a4-4897-b4a8-0c67403e86a7\r\na=ssrc:3781211321 cname:MkIJo2dVUw8Bk9Sb\r\na=ssrc:3781211321 msid:c5a3fb2e-c7eb-423d-83d3-ce3f36f01e5b 41f56152-b9a4-4897-b4a8-0c67403e86a7\r\n', NULL, '[{\"candidate\":\"candidate:2711850942 1 tcp 1518280447 172.16.1.129 9 typ host tcptype active generation 0 ufrag WdeO network-id 1 network-cost 10\",\"sdpMid\":\"0\",\"sdpMLineIndex\":0,\"usernameFragment\":\"WdeO\"},{\"candidate\":\"candidate:2711850942 1 tcp 1518280447 172.16.1.129 9 typ host tcptype active generation 0 ufrag WdeO network-id 1 network-cost 10\",\"sdpMid\":\"1\",\"sdpMLineIndex\":1,\"usernameFragment\":\"WdeO\"}]', NULL, '2026-05-28 21:33:04'),
(6, 1, 2, 'video', 'hungup', 'v=0\r\no=- 6088484616488529599 2 IN IP4 127.0.0.1\r\ns=-\r\nt=0 0\r\na=group:BUNDLE 0 1\r\na=extmap-allow-mixed\r\na=msid-semantic: WMS 61c76c8e-3a00-4382-bb2c-271d22c13174\r\nm=audio 9 UDP/TLS/RTP/SAVPF 111 63 9 0 8 13 110 126\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:kJSx\r\na=ice-pwd:HbLm35ET3t2l0b+BqMVJ+m93\r\na=ice-options:trickle\r\na=fingerprint:sha-256 E0:03:F0:97:0D:5A:1E:57:F2:30:59:41:6F:63:7C:E2:48:21:3C:73:72:B8:B0:93:9E:71:9F:72:DB:83:D4:17\r\na=setup:actpass\r\na=mid:0\r\na=extmap:1 urn:ietf:params:rtp-hdrext:ssrc-audio-level\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=sendrecv\r\na=msid:61c76c8e-3a00-4382-bb2c-271d22c13174 3e722476-f437-4be3-888a-648a4fab4dd7\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:111 opus/48000/2\r\na=rtcp-fb:111 transport-cc\r\na=fmtp:111 minptime=10;useinbandfec=1\r\na=rtpmap:63 red/48000/2\r\na=fmtp:63 111/111\r\na=rtpmap:9 G722/8000\r\na=rtpmap:0 PCMU/8000\r\na=rtpmap:8 PCMA/8000\r\na=rtpmap:13 CN/8000\r\na=rtpmap:110 telephone-event/48000\r\na=rtpmap:126 telephone-event/8000\r\na=ssrc:2002607278 cname:7X9XS3YAdZn7227h\r\na=ssrc:2002607278 msid:61c76c8e-3a00-4382-bb2c-271d22c13174 3e722476-f437-4be3-888a-648a4fab4dd7\r\nm=video 9 UDP/TLS/RTP/SAVPF 96 97 103 104 107 108 109 114 115 116 117 118 39 40 45 46 98 99 100 101 119 120 123 124 125\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:kJSx\r\na=ice-pwd:HbLm35ET3t2l0b+BqMVJ+m93\r\na=ice-options:trickle\r\na=fingerprint:sha-256 E0:03:F0:97:0D:5A:1E:57:F2:30:59:41:6F:63:7C:E2:48:21:3C:73:72:B8:B0:93:9E:71:9F:72:DB:83:D4:17\r\na=setup:actpass\r\na=mid:1\r\na=extmap:14 urn:ietf:params:rtp-hdrext:toffset\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:13 urn:3gpp:video-orientation\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:5 http://www.webrtc.org/experiments/rtp-hdrext/playout-delay\r\na=extmap:6 http://www.webrtc.org/experiments/rtp-hdrext/video-content-type\r\na=extmap:7 http://www.webrtc.org/experiments/rtp-hdrext/video-timing\r\na=extmap:8 http://www.webrtc.org/experiments/rtp-hdrext/color-space\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=extmap:10 urn:ietf:params:rtp-hdrext:sdes:rtp-stream-id\r\na=extmap:11 urn:ietf:params:rtp-hdrext:sdes:repaired-rtp-stream-id\r\na=sendrecv\r\na=msid:61c76c8e-3a00-4382-bb2c-271d22c13174 65bbc245-62eb-42ae-88cd-5b190902a656\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:96 VP8/90000\r\na=rtcp-fb:96 goog-remb\r\na=rtcp-fb:96 transport-cc\r\na=rtcp-fb:96 ccm fir\r\na=rtcp-fb:96 nack\r\na=rtcp-fb:96 nack pli\r\na=rtpmap:97 rtx/90000\r\na=fmtp:97 apt=96\r\na=rtpmap:103 H264/90000\r\na=rtcp-fb:103 goog-remb\r\na=rtcp-fb:103 transport-cc\r\na=rtcp-fb:103 ccm fir\r\na=rtcp-fb:103 nack\r\na=rtcp-fb:103 nack pli\r\na=fmtp:103 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42001f\r\na=rtpmap:104 rtx/90000\r\na=fmtp:104 apt=103\r\na=rtpmap:107 H264/90000\r\na=rtcp-fb:107 goog-remb\r\na=rtcp-fb:107 transport-cc\r\na=rtcp-fb:107 ccm fir\r\na=rtcp-fb:107 nack\r\na=rtcp-fb:107 nack pli\r\na=fmtp:107 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42001f\r\na=rtpmap:108 rtx/90000\r\na=fmtp:108 apt=107\r\na=rtpmap:109 H264/90000\r\na=rtcp-fb:109 goog-remb\r\na=rtcp-fb:109 transport-cc\r\na=rtcp-fb:109 ccm fir\r\na=rtcp-fb:109 nack\r\na=rtcp-fb:109 nack pli\r\na=fmtp:109 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42e01f\r\na=rtpmap:114 rtx/90000\r\na=fmtp:114 apt=109\r\na=rtpmap:115 H264/90000\r\na=rtcp-fb:115 goog-remb\r\na=rtcp-fb:115 transport-cc\r\na=rtcp-fb:115 ccm fir\r\na=rtcp-fb:115 nack\r\na=rtcp-fb:115 nack pli\r\na=fmtp:115 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42e01f\r\na=rtpmap:116 rtx/90000\r\na=fmtp:116 apt=115\r\na=rtpmap:117 H264/90000\r\na=rtcp-fb:117 goog-remb\r\na=rtcp-fb:117 transport-cc\r\na=rtcp-fb:117 ccm fir\r\na=rtcp-fb:117 nack\r\na=rtcp-fb:117 nack pli\r\na=fmtp:117 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=4d001f\r\na=rtpmap:118 rtx/90000\r\na=fmtp:118 apt=117\r\na=rtpmap:39 H264/90000\r\na=rtcp-fb:39 goog-remb\r\na=rtcp-fb:39 transport-cc\r\na=rtcp-fb:39 ccm fir\r\na=rtcp-fb:39 nack\r\na=rtcp-fb:39 nack pli\r\na=fmtp:39 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=4d001f\r\na=rtpmap:40 rtx/90000\r\na=fmtp:40 apt=39\r\na=rtpmap:45 AV1/90000\r\na=rtcp-fb:45 goog-remb\r\na=rtcp-fb:45 transport-cc\r\na=rtcp-fb:45 ccm fir\r\na=rtcp-fb:45 nack\r\na=rtcp-fb:45 nack pli\r\na=fmtp:45 level-idx=5;profile=0;tier=0\r\na=rtpmap:46 rtx/90000\r\na=fmtp:46 apt=45\r\na=rtpmap:98 VP9/90000\r\na=rtcp-fb:98 goog-remb\r\na=rtcp-fb:98 transport-cc\r\na=rtcp-fb:98 ccm fir\r\na=rtcp-fb:98 nack\r\na=rtcp-fb:98 nack pli\r\na=fmtp:98 profile-id=0\r\na=rtpmap:99 rtx/90000\r\na=fmtp:99 apt=98\r\na=rtpmap:100 VP9/90000\r\na=rtcp-fb:100 goog-remb\r\na=rtcp-fb:100 transport-cc\r\na=rtcp-fb:100 ccm fir\r\na=rtcp-fb:100 nack\r\na=rtcp-fb:100 nack pli\r\na=fmtp:100 profile-id=2\r\na=rtpmap:101 rtx/90000\r\na=fmtp:101 apt=100\r\na=rtpmap:119 H264/90000\r\na=rtcp-fb:119 goog-remb\r\na=rtcp-fb:119 transport-cc\r\na=rtcp-fb:119 ccm fir\r\na=rtcp-fb:119 nack\r\na=rtcp-fb:119 nack pli\r\na=fmtp:119 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=64001f\r\na=rtpmap:120 rtx/90000\r\na=fmtp:120 apt=119\r\na=rtpmap:123 red/90000\r\na=rtpmap:124 rtx/90000\r\na=fmtp:124 apt=123\r\na=rtpmap:125 ulpfec/90000\r\na=ssrc-group:FID 201950311 2829918486\r\na=ssrc:201950311 cname:7X9XS3YAdZn7227h\r\na=ssrc:201950311 msid:61c76c8e-3a00-4382-bb2c-271d22c13174 65bbc245-62eb-42ae-88cd-5b190902a656\r\na=ssrc:2829918486 cname:7X9XS3YAdZn7227h\r\na=ssrc:2829918486 msid:61c76c8e-3a00-4382-bb2c-271d22c13174 65bbc245-62eb-42ae-88cd-5b190902a656\r\n', 'v=0\r\no=- 9077216158993761187 2 IN IP4 127.0.0.1\r\ns=-\r\nt=0 0\r\na=group:BUNDLE 0 1\r\na=extmap-allow-mixed\r\na=msid-semantic: WMS de3d4a81-f06a-4124-88d8-747d72003afd\r\nm=audio 9 UDP/TLS/RTP/SAVPF 111 63 9 0 8 13 110 126\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:UKwl\r\na=ice-pwd:sUb8zmmNw6pfpe11SvIwoCZa\r\na=ice-options:trickle\r\na=fingerprint:sha-256 06:2F:D5:67:D4:2A:11:62:44:1C:46:9E:DA:C7:A1:30:97:82:75:93:3C:29:2E:5E:7D:ED:E2:6F:BF:2C:20:FE\r\na=setup:active\r\na=mid:0\r\na=extmap:1 urn:ietf:params:rtp-hdrext:ssrc-audio-level\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=sendrecv\r\na=msid:de3d4a81-f06a-4124-88d8-747d72003afd b031afba-a42c-4d9a-90e8-b43a711c82bc\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:111 opus/48000/2\r\na=rtcp-fb:111 transport-cc\r\na=fmtp:111 minptime=10;useinbandfec=1\r\na=rtpmap:63 red/48000/2\r\na=fmtp:63 111/111\r\na=rtpmap:9 G722/8000\r\na=rtpmap:0 PCMU/8000\r\na=rtpmap:8 PCMA/8000\r\na=rtpmap:13 CN/8000\r\na=rtpmap:110 telephone-event/48000\r\na=rtpmap:126 telephone-event/8000\r\na=ssrc:3467305521 cname:T9NrhaxD2Dwd7r9+\r\nm=video 9 UDP/TLS/RTP/SAVPF 96 97 103 104 107 108 109 114 115 116 117 118 39 40 45 46 98 99 100 101 119 120 123 124 125\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:UKwl\r\na=ice-pwd:sUb8zmmNw6pfpe11SvIwoCZa\r\na=ice-options:trickle\r\na=fingerprint:sha-256 06:2F:D5:67:D4:2A:11:62:44:1C:46:9E:DA:C7:A1:30:97:82:75:93:3C:29:2E:5E:7D:ED:E2:6F:BF:2C:20:FE\r\na=setup:active\r\na=mid:1\r\na=extmap:14 urn:ietf:params:rtp-hdrext:toffset\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:13 urn:3gpp:video-orientation\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:5 http://www.webrtc.org/experiments/rtp-hdrext/playout-delay\r\na=extmap:6 http://www.webrtc.org/experiments/rtp-hdrext/video-content-type\r\na=extmap:7 http://www.webrtc.org/experiments/rtp-hdrext/video-timing\r\na=extmap:8 http://www.webrtc.org/experiments/rtp-hdrext/color-space\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=extmap:10 urn:ietf:params:rtp-hdrext:sdes:rtp-stream-id\r\na=extmap:11 urn:ietf:params:rtp-hdrext:sdes:repaired-rtp-stream-id\r\na=sendrecv\r\na=msid:de3d4a81-f06a-4124-88d8-747d72003afd 43f91275-4dc0-4b8c-8942-7588a800ad3e\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:96 VP8/90000\r\na=rtcp-fb:96 goog-remb\r\na=rtcp-fb:96 transport-cc\r\na=rtcp-fb:96 ccm fir\r\na=rtcp-fb:96 nack\r\na=rtcp-fb:96 nack pli\r\na=rtpmap:97 rtx/90000\r\na=fmtp:97 apt=96\r\na=rtpmap:103 H264/90000\r\na=rtcp-fb:103 goog-remb\r\na=rtcp-fb:103 transport-cc\r\na=rtcp-fb:103 ccm fir\r\na=rtcp-fb:103 nack\r\na=rtcp-fb:103 nack pli\r\na=fmtp:103 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42001f\r\na=rtpmap:104 rtx/90000\r\na=fmtp:104 apt=103\r\na=rtpmap:107 H264/90000\r\na=rtcp-fb:107 goog-remb\r\na=rtcp-fb:107 transport-cc\r\na=rtcp-fb:107 ccm fir\r\na=rtcp-fb:107 nack\r\na=rtcp-fb:107 nack pli\r\na=fmtp:107 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42001f\r\na=rtpmap:108 rtx/90000\r\na=fmtp:108 apt=107\r\na=rtpmap:109 H264/90000\r\na=rtcp-fb:109 goog-remb\r\na=rtcp-fb:109 transport-cc\r\na=rtcp-fb:109 ccm fir\r\na=rtcp-fb:109 nack\r\na=rtcp-fb:109 nack pli\r\na=fmtp:109 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42e01f\r\na=rtpmap:114 rtx/90000\r\na=fmtp:114 apt=109\r\na=rtpmap:115 H264/90000\r\na=rtcp-fb:115 goog-remb\r\na=rtcp-fb:115 transport-cc\r\na=rtcp-fb:115 ccm fir\r\na=rtcp-fb:115 nack\r\na=rtcp-fb:115 nack pli\r\na=fmtp:115 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42e01f\r\na=rtpmap:116 rtx/90000\r\na=fmtp:116 apt=115\r\na=rtpmap:117 H264/90000\r\na=rtcp-fb:117 goog-remb\r\na=rtcp-fb:117 transport-cc\r\na=rtcp-fb:117 ccm fir\r\na=rtcp-fb:117 nack\r\na=rtcp-fb:117 nack pli\r\na=fmtp:117 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=4d001f\r\na=rtpmap:118 rtx/90000\r\na=fmtp:118 apt=117\r\na=rtpmap:39 H264/90000\r\na=rtcp-fb:39 goog-remb\r\na=rtcp-fb:39 transport-cc\r\na=rtcp-fb:39 ccm fir\r\na=rtcp-fb:39 nack\r\na=rtcp-fb:39 nack pli\r\na=fmtp:39 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=4d001f\r\na=rtpmap:40 rtx/90000\r\na=fmtp:40 apt=39\r\na=rtpmap:45 AV1/90000\r\na=rtcp-fb:45 goog-remb\r\na=rtcp-fb:45 transport-cc\r\na=rtcp-fb:45 ccm fir\r\na=rtcp-fb:45 nack\r\na=rtcp-fb:45 nack pli\r\na=fmtp:45 level-idx=5;profile=0;tier=0\r\na=rtpmap:46 rtx/90000\r\na=fmtp:46 apt=45\r\na=rtpmap:98 VP9/90000\r\na=rtcp-fb:98 goog-remb\r\na=rtcp-fb:98 transport-cc\r\na=rtcp-fb:98 ccm fir\r\na=rtcp-fb:98 nack\r\na=rtcp-fb:98 nack pli\r\na=fmtp:98 profile-id=0\r\na=rtpmap:99 rtx/90000\r\na=fmtp:99 apt=98\r\na=rtpmap:100 VP9/90000\r\na=rtcp-fb:100 goog-remb\r\na=rtcp-fb:100 transport-cc\r\na=rtcp-fb:100 ccm fir\r\na=rtcp-fb:100 nack\r\na=rtcp-fb:100 nack pli\r\na=fmtp:100 profile-id=2\r\na=rtpmap:101 rtx/90000\r\na=fmtp:101 apt=100\r\na=rtpmap:119 H264/90000\r\na=rtcp-fb:119 goog-remb\r\na=rtcp-fb:119 transport-cc\r\na=rtcp-fb:119 ccm fir\r\na=rtcp-fb:119 nack\r\na=rtcp-fb:119 nack pli\r\na=fmtp:119 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=64001f\r\na=rtpmap:120 rtx/90000\r\na=fmtp:120 apt=119\r\na=rtpmap:123 red/90000\r\na=rtpmap:124 rtx/90000\r\na=fmtp:124 apt=123\r\na=rtpmap:125 ulpfec/90000\r\na=ssrc-group:FID 293674802 191173054\r\na=ssrc:293674802 cname:T9NrhaxD2Dwd7r9+\r\na=ssrc:191173054 cname:T9NrhaxD2Dwd7r9+\r\n', NULL, '[{\"candidate\":\"candidate:1465229182 1 udp 2122260223 172.16.1.129 57076 typ host generation 0 ufrag UKwl network-id 1 network-cost 10\",\"sdpMid\":\"0\",\"sdpMLineIndex\":0,\"usernameFragment\":\"UKwl\"}]', '2026-05-28 21:33:23'),
(7, 2, 1, 'video', 'hungup', 'v=0\r\no=- 8069620446790418402 2 IN IP4 127.0.0.1\r\ns=-\r\nt=0 0\r\na=group:BUNDLE 0 1\r\na=extmap-allow-mixed\r\na=msid-semantic: WMS 9ad16967-d504-405a-a1ec-45e1f526f327\r\nm=audio 9 UDP/TLS/RTP/SAVPF 111 63 9 0 8 13 110 126\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:NPma\r\na=ice-pwd:WOVxkNZwf9gaiZRZYYmIDZTa\r\na=ice-options:trickle\r\na=fingerprint:sha-256 6A:C0:D5:26:82:8F:E6:00:C7:6E:CA:4C:BD:30:F0:03:46:56:CE:46:81:58:29:18:5D:E0:82:86:00:86:3E:7B\r\na=setup:actpass\r\na=mid:0\r\na=extmap:1 urn:ietf:params:rtp-hdrext:ssrc-audio-level\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=sendrecv\r\na=msid:9ad16967-d504-405a-a1ec-45e1f526f327 efb9af08-5f01-4edc-ab1d-1b160d45875b\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:111 opus/48000/2\r\na=rtcp-fb:111 transport-cc\r\na=fmtp:111 minptime=10;useinbandfec=1\r\na=rtpmap:63 red/48000/2\r\na=fmtp:63 111/111\r\na=rtpmap:9 G722/8000\r\na=rtpmap:0 PCMU/8000\r\na=rtpmap:8 PCMA/8000\r\na=rtpmap:13 CN/8000\r\na=rtpmap:110 telephone-event/48000\r\na=rtpmap:126 telephone-event/8000\r\na=ssrc:3121128791 cname:CQ9rHkDr1XEYhmZX\r\na=ssrc:3121128791 msid:9ad16967-d504-405a-a1ec-45e1f526f327 efb9af08-5f01-4edc-ab1d-1b160d45875b\r\nm=video 9 UDP/TLS/RTP/SAVPF 96 97 103 104 107 108 109 114 115 116 117 118 39 40 45 46 98 99 100 101 119 120 123 124 125\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:NPma\r\na=ice-pwd:WOVxkNZwf9gaiZRZYYmIDZTa\r\na=ice-options:trickle\r\na=fingerprint:sha-256 6A:C0:D5:26:82:8F:E6:00:C7:6E:CA:4C:BD:30:F0:03:46:56:CE:46:81:58:29:18:5D:E0:82:86:00:86:3E:7B\r\na=setup:actpass\r\na=mid:1\r\na=extmap:14 urn:ietf:params:rtp-hdrext:toffset\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:13 urn:3gpp:video-orientation\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:5 http://www.webrtc.org/experiments/rtp-hdrext/playout-delay\r\na=extmap:6 http://www.webrtc.org/experiments/rtp-hdrext/video-content-type\r\na=extmap:7 http://www.webrtc.org/experiments/rtp-hdrext/video-timing\r\na=extmap:8 http://www.webrtc.org/experiments/rtp-hdrext/color-space\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=extmap:10 urn:ietf:params:rtp-hdrext:sdes:rtp-stream-id\r\na=extmap:11 urn:ietf:params:rtp-hdrext:sdes:repaired-rtp-stream-id\r\na=sendrecv\r\na=msid:9ad16967-d504-405a-a1ec-45e1f526f327 3f36bec8-ae44-4d5e-993f-96320870ecce\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:96 VP8/90000\r\na=rtcp-fb:96 goog-remb\r\na=rtcp-fb:96 transport-cc\r\na=rtcp-fb:96 ccm fir\r\na=rtcp-fb:96 nack\r\na=rtcp-fb:96 nack pli\r\na=rtpmap:97 rtx/90000\r\na=fmtp:97 apt=96\r\na=rtpmap:103 H264/90000\r\na=rtcp-fb:103 goog-remb\r\na=rtcp-fb:103 transport-cc\r\na=rtcp-fb:103 ccm fir\r\na=rtcp-fb:103 nack\r\na=rtcp-fb:103 nack pli\r\na=fmtp:103 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42001f\r\na=rtpmap:104 rtx/90000\r\na=fmtp:104 apt=103\r\na=rtpmap:107 H264/90000\r\na=rtcp-fb:107 goog-remb\r\na=rtcp-fb:107 transport-cc\r\na=rtcp-fb:107 ccm fir\r\na=rtcp-fb:107 nack\r\na=rtcp-fb:107 nack pli\r\na=fmtp:107 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42001f\r\na=rtpmap:108 rtx/90000\r\na=fmtp:108 apt=107\r\na=rtpmap:109 H264/90000\r\na=rtcp-fb:109 goog-remb\r\na=rtcp-fb:109 transport-cc\r\na=rtcp-fb:109 ccm fir\r\na=rtcp-fb:109 nack\r\na=rtcp-fb:109 nack pli\r\na=fmtp:109 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42e01f\r\na=rtpmap:114 rtx/90000\r\na=fmtp:114 apt=109\r\na=rtpmap:115 H264/90000\r\na=rtcp-fb:115 goog-remb\r\na=rtcp-fb:115 transport-cc\r\na=rtcp-fb:115 ccm fir\r\na=rtcp-fb:115 nack\r\na=rtcp-fb:115 nack pli\r\na=fmtp:115 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42e01f\r\na=rtpmap:116 rtx/90000\r\na=fmtp:116 apt=115\r\na=rtpmap:117 H264/90000\r\na=rtcp-fb:117 goog-remb\r\na=rtcp-fb:117 transport-cc\r\na=rtcp-fb:117 ccm fir\r\na=rtcp-fb:117 nack\r\na=rtcp-fb:117 nack pli\r\na=fmtp:117 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=4d001f\r\na=rtpmap:118 rtx/90000\r\na=fmtp:118 apt=117\r\na=rtpmap:39 H264/90000\r\na=rtcp-fb:39 goog-remb\r\na=rtcp-fb:39 transport-cc\r\na=rtcp-fb:39 ccm fir\r\na=rtcp-fb:39 nack\r\na=rtcp-fb:39 nack pli\r\na=fmtp:39 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=4d001f\r\na=rtpmap:40 rtx/90000\r\na=fmtp:40 apt=39\r\na=rtpmap:45 AV1/90000\r\na=rtcp-fb:45 goog-remb\r\na=rtcp-fb:45 transport-cc\r\na=rtcp-fb:45 ccm fir\r\na=rtcp-fb:45 nack\r\na=rtcp-fb:45 nack pli\r\na=fmtp:45 level-idx=5;profile=0;tier=0\r\na=rtpmap:46 rtx/90000\r\na=fmtp:46 apt=45\r\na=rtpmap:98 VP9/90000\r\na=rtcp-fb:98 goog-remb\r\na=rtcp-fb:98 transport-cc\r\na=rtcp-fb:98 ccm fir\r\na=rtcp-fb:98 nack\r\na=rtcp-fb:98 nack pli\r\na=fmtp:98 profile-id=0\r\na=rtpmap:99 rtx/90000\r\na=fmtp:99 apt=98\r\na=rtpmap:100 VP9/90000\r\na=rtcp-fb:100 goog-remb\r\na=rtcp-fb:100 transport-cc\r\na=rtcp-fb:100 ccm fir\r\na=rtcp-fb:100 nack\r\na=rtcp-fb:100 nack pli\r\na=fmtp:100 profile-id=2\r\na=rtpmap:101 rtx/90000\r\na=fmtp:101 apt=100\r\na=rtpmap:119 H264/90000\r\na=rtcp-fb:119 goog-remb\r\na=rtcp-fb:119 transport-cc\r\na=rtcp-fb:119 ccm fir\r\na=rtcp-fb:119 nack\r\na=rtcp-fb:119 nack pli\r\na=fmtp:119 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=64001f\r\na=rtpmap:120 rtx/90000\r\na=fmtp:120 apt=119\r\na=rtpmap:123 red/90000\r\na=rtpmap:124 rtx/90000\r\na=fmtp:124 apt=123\r\na=rtpmap:125 ulpfec/90000\r\na=ssrc-group:FID 2589351895 1177923209\r\na=ssrc:2589351895 cname:CQ9rHkDr1XEYhmZX\r\na=ssrc:2589351895 msid:9ad16967-d504-405a-a1ec-45e1f526f327 3f36bec8-ae44-4d5e-993f-96320870ecce\r\na=ssrc:1177923209 cname:CQ9rHkDr1XEYhmZX\r\na=ssrc:1177923209 msid:9ad16967-d504-405a-a1ec-45e1f526f327 3f36bec8-ae44-4d5e-993f-96320870ecce\r\n', NULL, '[{\"candidate\":\"candidate:3494059519 1 tcp 1518280447 172.16.1.129 9 typ host tcptype active generation 0 ufrag NPma network-id 1 network-cost 10\",\"sdpMid\":\"1\",\"sdpMLineIndex\":1,\"usernameFragment\":\"NPma\"},{\"candidate\":\"candidate:3494059519 1 tcp 1518280447 172.16.1.129 9 typ host tcptype active generation 0 ufrag NPma network-id 1 network-cost 10\",\"sdpMid\":\"0\",\"sdpMLineIndex\":0,\"usernameFragment\":\"NPma\"}]', NULL, '2026-05-28 21:39:43'),
(8, 2, 1, 'video', 'hungup', 'v=0\r\no=- 9153403761934809876 2 IN IP4 127.0.0.1\r\ns=-\r\nt=0 0\r\na=group:BUNDLE 0 1\r\na=extmap-allow-mixed\r\na=msid-semantic: WMS b8412690-6f99-4fc8-9810-6a20107c2601\r\nm=audio 9 UDP/TLS/RTP/SAVPF 111 63 9 0 8 13 110 126\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:+Kfn\r\na=ice-pwd:5RO58rb2ov3ciOcDxzHeyN/e\r\na=ice-options:trickle\r\na=fingerprint:sha-256 27:76:11:D1:5C:CC:47:FD:EB:CD:3E:2C:19:6C:55:67:FE:1F:74:45:44:FB:6C:AD:24:B0:0D:F4:1A:85:F9:6B\r\na=setup:actpass\r\na=mid:0\r\na=extmap:1 urn:ietf:params:rtp-hdrext:ssrc-audio-level\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=sendrecv\r\na=msid:b8412690-6f99-4fc8-9810-6a20107c2601 4b14a4fe-fdbb-4ed4-8c10-772447892d95\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:111 opus/48000/2\r\na=rtcp-fb:111 transport-cc\r\na=fmtp:111 minptime=10;useinbandfec=1\r\na=rtpmap:63 red/48000/2\r\na=fmtp:63 111/111\r\na=rtpmap:9 G722/8000\r\na=rtpmap:0 PCMU/8000\r\na=rtpmap:8 PCMA/8000\r\na=rtpmap:13 CN/8000\r\na=rtpmap:110 telephone-event/48000\r\na=rtpmap:126 telephone-event/8000\r\na=ssrc:3021092657 cname:SSW8v6HZ1Ckzj115\r\na=ssrc:3021092657 msid:b8412690-6f99-4fc8-9810-6a20107c2601 4b14a4fe-fdbb-4ed4-8c10-772447892d95\r\nm=video 9 UDP/TLS/RTP/SAVPF 96 97 103 104 107 108 109 114 115 116 117 118 39 40 45 46 98 99 100 101 119 120 123 124 125\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:+Kfn\r\na=ice-pwd:5RO58rb2ov3ciOcDxzHeyN/e\r\na=ice-options:trickle\r\na=fingerprint:sha-256 27:76:11:D1:5C:CC:47:FD:EB:CD:3E:2C:19:6C:55:67:FE:1F:74:45:44:FB:6C:AD:24:B0:0D:F4:1A:85:F9:6B\r\na=setup:actpass\r\na=mid:1\r\na=extmap:14 urn:ietf:params:rtp-hdrext:toffset\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:13 urn:3gpp:video-orientation\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:5 http://www.webrtc.org/experiments/rtp-hdrext/playout-delay\r\na=extmap:6 http://www.webrtc.org/experiments/rtp-hdrext/video-content-type\r\na=extmap:7 http://www.webrtc.org/experiments/rtp-hdrext/video-timing\r\na=extmap:8 http://www.webrtc.org/experiments/rtp-hdrext/color-space\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=extmap:10 urn:ietf:params:rtp-hdrext:sdes:rtp-stream-id\r\na=extmap:11 urn:ietf:params:rtp-hdrext:sdes:repaired-rtp-stream-id\r\na=sendrecv\r\na=msid:b8412690-6f99-4fc8-9810-6a20107c2601 3b77b281-7b57-400e-8d1b-086802956a13\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:96 VP8/90000\r\na=rtcp-fb:96 goog-remb\r\na=rtcp-fb:96 transport-cc\r\na=rtcp-fb:96 ccm fir\r\na=rtcp-fb:96 nack\r\na=rtcp-fb:96 nack pli\r\na=rtpmap:97 rtx/90000\r\na=fmtp:97 apt=96\r\na=rtpmap:103 H264/90000\r\na=rtcp-fb:103 goog-remb\r\na=rtcp-fb:103 transport-cc\r\na=rtcp-fb:103 ccm fir\r\na=rtcp-fb:103 nack\r\na=rtcp-fb:103 nack pli\r\na=fmtp:103 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42001f\r\na=rtpmap:104 rtx/90000\r\na=fmtp:104 apt=103\r\na=rtpmap:107 H264/90000\r\na=rtcp-fb:107 goog-remb\r\na=rtcp-fb:107 transport-cc\r\na=rtcp-fb:107 ccm fir\r\na=rtcp-fb:107 nack\r\na=rtcp-fb:107 nack pli\r\na=fmtp:107 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42001f\r\na=rtpmap:108 rtx/90000\r\na=fmtp:108 apt=107\r\na=rtpmap:109 H264/90000\r\na=rtcp-fb:109 goog-remb\r\na=rtcp-fb:109 transport-cc\r\na=rtcp-fb:109 ccm fir\r\na=rtcp-fb:109 nack\r\na=rtcp-fb:109 nack pli\r\na=fmtp:109 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42e01f\r\na=rtpmap:114 rtx/90000\r\na=fmtp:114 apt=109\r\na=rtpmap:115 H264/90000\r\na=rtcp-fb:115 goog-remb\r\na=rtcp-fb:115 transport-cc\r\na=rtcp-fb:115 ccm fir\r\na=rtcp-fb:115 nack\r\na=rtcp-fb:115 nack pli\r\na=fmtp:115 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42e01f\r\na=rtpmap:116 rtx/90000\r\na=fmtp:116 apt=115\r\na=rtpmap:117 H264/90000\r\na=rtcp-fb:117 goog-remb\r\na=rtcp-fb:117 transport-cc\r\na=rtcp-fb:117 ccm fir\r\na=rtcp-fb:117 nack\r\na=rtcp-fb:117 nack pli\r\na=fmtp:117 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=4d001f\r\na=rtpmap:118 rtx/90000\r\na=fmtp:118 apt=117\r\na=rtpmap:39 H264/90000\r\na=rtcp-fb:39 goog-remb\r\na=rtcp-fb:39 transport-cc\r\na=rtcp-fb:39 ccm fir\r\na=rtcp-fb:39 nack\r\na=rtcp-fb:39 nack pli\r\na=fmtp:39 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=4d001f\r\na=rtpmap:40 rtx/90000\r\na=fmtp:40 apt=39\r\na=rtpmap:45 AV1/90000\r\na=rtcp-fb:45 goog-remb\r\na=rtcp-fb:45 transport-cc\r\na=rtcp-fb:45 ccm fir\r\na=rtcp-fb:45 nack\r\na=rtcp-fb:45 nack pli\r\na=fmtp:45 level-idx=5;profile=0;tier=0\r\na=rtpmap:46 rtx/90000\r\na=fmtp:46 apt=45\r\na=rtpmap:98 VP9/90000\r\na=rtcp-fb:98 goog-remb\r\na=rtcp-fb:98 transport-cc\r\na=rtcp-fb:98 ccm fir\r\na=rtcp-fb:98 nack\r\na=rtcp-fb:98 nack pli\r\na=fmtp:98 profile-id=0\r\na=rtpmap:99 rtx/90000\r\na=fmtp:99 apt=98\r\na=rtpmap:100 VP9/90000\r\na=rtcp-fb:100 goog-remb\r\na=rtcp-fb:100 transport-cc\r\na=rtcp-fb:100 ccm fir\r\na=rtcp-fb:100 nack\r\na=rtcp-fb:100 nack pli\r\na=fmtp:100 profile-id=2\r\na=rtpmap:101 rtx/90000\r\na=fmtp:101 apt=100\r\na=rtpmap:119 H264/90000\r\na=rtcp-fb:119 goog-remb\r\na=rtcp-fb:119 transport-cc\r\na=rtcp-fb:119 ccm fir\r\na=rtcp-fb:119 nack\r\na=rtcp-fb:119 nack pli\r\na=fmtp:119 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=64001f\r\na=rtpmap:120 rtx/90000\r\na=fmtp:120 apt=119\r\na=rtpmap:123 red/90000\r\na=rtpmap:124 rtx/90000\r\na=fmtp:124 apt=123\r\na=rtpmap:125 ulpfec/90000\r\na=ssrc-group:FID 2604434023 1060890986\r\na=ssrc:2604434023 cname:SSW8v6HZ1Ckzj115\r\na=ssrc:2604434023 msid:b8412690-6f99-4fc8-9810-6a20107c2601 3b77b281-7b57-400e-8d1b-086802956a13\r\na=ssrc:1060890986 cname:SSW8v6HZ1Ckzj115\r\na=ssrc:1060890986 msid:b8412690-6f99-4fc8-9810-6a20107c2601 3b77b281-7b57-400e-8d1b-086802956a13\r\n', 'v=0\r\no=- 7469311971933446786 2 IN IP4 127.0.0.1\r\ns=-\r\nt=0 0\r\na=group:BUNDLE 0 1\r\na=extmap-allow-mixed\r\na=msid-semantic: WMS 2d71d35b-ce54-41e5-80c4-41ebf7084fe8\r\nm=audio 9 UDP/TLS/RTP/SAVPF 111 63 9 0 8 13 110 126\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:YAoJ\r\na=ice-pwd:E8xE2sw4GWgSM1Hu46SP4Xds\r\na=ice-options:trickle\r\na=fingerprint:sha-256 B1:0F:FD:8D:BB:41:A1:60:41:75:6D:9B:1C:14:47:03:AB:50:11:D5:2C:F4:45:77:9B:4A:77:B0:65:91:18:AD\r\na=setup:active\r\na=mid:0\r\na=extmap:1 urn:ietf:params:rtp-hdrext:ssrc-audio-level\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=sendrecv\r\na=msid:2d71d35b-ce54-41e5-80c4-41ebf7084fe8 f06ddcc2-4b58-4d86-91b9-76464c6c6770\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:111 opus/48000/2\r\na=rtcp-fb:111 transport-cc\r\na=fmtp:111 minptime=10;useinbandfec=1\r\na=rtpmap:63 red/48000/2\r\na=fmtp:63 111/111\r\na=rtpmap:9 G722/8000\r\na=rtpmap:0 PCMU/8000\r\na=rtpmap:8 PCMA/8000\r\na=rtpmap:13 CN/8000\r\na=rtpmap:110 telephone-event/48000\r\na=rtpmap:126 telephone-event/8000\r\na=ssrc:3017006049 cname:+ew48s8tMdxh4wul\r\nm=video 9 UDP/TLS/RTP/SAVPF 96 97 103 104 107 108 109 114 115 116 117 118 39 40 45 46 98 99 100 101 119 120 123 124 125\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:YAoJ\r\na=ice-pwd:E8xE2sw4GWgSM1Hu46SP4Xds\r\na=ice-options:trickle\r\na=fingerprint:sha-256 B1:0F:FD:8D:BB:41:A1:60:41:75:6D:9B:1C:14:47:03:AB:50:11:D5:2C:F4:45:77:9B:4A:77:B0:65:91:18:AD\r\na=setup:active\r\na=mid:1\r\na=extmap:14 urn:ietf:params:rtp-hdrext:toffset\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:13 urn:3gpp:video-orientation\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:5 http://www.webrtc.org/experiments/rtp-hdrext/playout-delay\r\na=extmap:6 http://www.webrtc.org/experiments/rtp-hdrext/video-content-type\r\na=extmap:7 http://www.webrtc.org/experiments/rtp-hdrext/video-timing\r\na=extmap:8 http://www.webrtc.org/experiments/rtp-hdrext/color-space\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=extmap:10 urn:ietf:params:rtp-hdrext:sdes:rtp-stream-id\r\na=extmap:11 urn:ietf:params:rtp-hdrext:sdes:repaired-rtp-stream-id\r\na=sendrecv\r\na=msid:2d71d35b-ce54-41e5-80c4-41ebf7084fe8 ed5ff7a1-bfc9-48df-b947-a352b6ff20f9\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:96 VP8/90000\r\na=rtcp-fb:96 goog-remb\r\na=rtcp-fb:96 transport-cc\r\na=rtcp-fb:96 ccm fir\r\na=rtcp-fb:96 nack\r\na=rtcp-fb:96 nack pli\r\na=rtpmap:97 rtx/90000\r\na=fmtp:97 apt=96\r\na=rtpmap:103 H264/90000\r\na=rtcp-fb:103 goog-remb\r\na=rtcp-fb:103 transport-cc\r\na=rtcp-fb:103 ccm fir\r\na=rtcp-fb:103 nack\r\na=rtcp-fb:103 nack pli\r\na=fmtp:103 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42001f\r\na=rtpmap:104 rtx/90000\r\na=fmtp:104 apt=103\r\na=rtpmap:107 H264/90000\r\na=rtcp-fb:107 goog-remb\r\na=rtcp-fb:107 transport-cc\r\na=rtcp-fb:107 ccm fir\r\na=rtcp-fb:107 nack\r\na=rtcp-fb:107 nack pli\r\na=fmtp:107 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42001f\r\na=rtpmap:108 rtx/90000\r\na=fmtp:108 apt=107\r\na=rtpmap:109 H264/90000\r\na=rtcp-fb:109 goog-remb\r\na=rtcp-fb:109 transport-cc\r\na=rtcp-fb:109 ccm fir\r\na=rtcp-fb:109 nack\r\na=rtcp-fb:109 nack pli\r\na=fmtp:109 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42e01f\r\na=rtpmap:114 rtx/90000\r\na=fmtp:114 apt=109\r\na=rtpmap:115 H264/90000\r\na=rtcp-fb:115 goog-remb\r\na=rtcp-fb:115 transport-cc\r\na=rtcp-fb:115 ccm fir\r\na=rtcp-fb:115 nack\r\na=rtcp-fb:115 nack pli\r\na=fmtp:115 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42e01f\r\na=rtpmap:116 rtx/90000\r\na=fmtp:116 apt=115\r\na=rtpmap:117 H264/90000\r\na=rtcp-fb:117 goog-remb\r\na=rtcp-fb:117 transport-cc\r\na=rtcp-fb:117 ccm fir\r\na=rtcp-fb:117 nack\r\na=rtcp-fb:117 nack pli\r\na=fmtp:117 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=4d001f\r\na=rtpmap:118 rtx/90000\r\na=fmtp:118 apt=117\r\na=rtpmap:39 H264/90000\r\na=rtcp-fb:39 goog-remb\r\na=rtcp-fb:39 transport-cc\r\na=rtcp-fb:39 ccm fir\r\na=rtcp-fb:39 nack\r\na=rtcp-fb:39 nack pli\r\na=fmtp:39 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=4d001f\r\na=rtpmap:40 rtx/90000\r\na=fmtp:40 apt=39\r\na=rtpmap:45 AV1/90000\r\na=rtcp-fb:45 goog-remb\r\na=rtcp-fb:45 transport-cc\r\na=rtcp-fb:45 ccm fir\r\na=rtcp-fb:45 nack\r\na=rtcp-fb:45 nack pli\r\na=fmtp:45 level-idx=5;profile=0;tier=0\r\na=rtpmap:46 rtx/90000\r\na=fmtp:46 apt=45\r\na=rtpmap:98 VP9/90000\r\na=rtcp-fb:98 goog-remb\r\na=rtcp-fb:98 transport-cc\r\na=rtcp-fb:98 ccm fir\r\na=rtcp-fb:98 nack\r\na=rtcp-fb:98 nack pli\r\na=fmtp:98 profile-id=0\r\na=rtpmap:99 rtx/90000\r\na=fmtp:99 apt=98\r\na=rtpmap:100 VP9/90000\r\na=rtcp-fb:100 goog-remb\r\na=rtcp-fb:100 transport-cc\r\na=rtcp-fb:100 ccm fir\r\na=rtcp-fb:100 nack\r\na=rtcp-fb:100 nack pli\r\na=fmtp:100 profile-id=2\r\na=rtpmap:101 rtx/90000\r\na=fmtp:101 apt=100\r\na=rtpmap:119 H264/90000\r\na=rtcp-fb:119 goog-remb\r\na=rtcp-fb:119 transport-cc\r\na=rtcp-fb:119 ccm fir\r\na=rtcp-fb:119 nack\r\na=rtcp-fb:119 nack pli\r\na=fmtp:119 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=64001f\r\na=rtpmap:120 rtx/90000\r\na=fmtp:120 apt=119\r\na=rtpmap:123 red/90000\r\na=rtpmap:124 rtx/90000\r\na=fmtp:124 apt=123\r\na=rtpmap:125 ulpfec/90000\r\na=ssrc-group:FID 1114932560 2594717038\r\na=ssrc:1114932560 cname:+ew48s8tMdxh4wul\r\na=ssrc:2594717038 cname:+ew48s8tMdxh4wul\r\n', NULL, '[{\"candidate\":\"candidate:849242682 1 udp 2122260223 172.16.1.129 62635 typ host generation 0 ufrag YAoJ network-id 1 network-cost 10\",\"sdpMid\":\"0\",\"sdpMLineIndex\":0,\"usernameFragment\":\"YAoJ\"}]', '2026-05-28 21:40:04'),
(9, 2, 1, 'video', 'ended', 'v=0\r\no=- 5817941065909310532 2 IN IP4 127.0.0.1\r\ns=-\r\nt=0 0\r\na=group:BUNDLE 0 1\r\na=extmap-allow-mixed\r\na=msid-semantic: WMS 04fda1f1-f027-47bb-8409-287ea2742662\r\nm=audio 9 UDP/TLS/RTP/SAVPF 111 63 9 0 8 13 110 126\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:lOxT\r\na=ice-pwd:MDz9IPyuwvYByL5X+X22bWGT\r\na=ice-options:trickle\r\na=fingerprint:sha-256 33:FE:BD:B7:AB:EC:4D:C7:04:2C:B6:0E:BC:B0:D6:AC:EF:07:BD:86:96:3A:1D:5E:BD:14:5C:D4:6C:C6:5E:ED\r\na=setup:actpass\r\na=mid:0\r\na=extmap:1 urn:ietf:params:rtp-hdrext:ssrc-audio-level\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=sendrecv\r\na=msid:04fda1f1-f027-47bb-8409-287ea2742662 539e8ef3-1083-4720-b348-2c94fbdec4d6\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:111 opus/48000/2\r\na=rtcp-fb:111 transport-cc\r\na=fmtp:111 minptime=10;useinbandfec=1\r\na=rtpmap:63 red/48000/2\r\na=fmtp:63 111/111\r\na=rtpmap:9 G722/8000\r\na=rtpmap:0 PCMU/8000\r\na=rtpmap:8 PCMA/8000\r\na=rtpmap:13 CN/8000\r\na=rtpmap:110 telephone-event/48000\r\na=rtpmap:126 telephone-event/8000\r\na=ssrc:3330614625 cname:JbbIYuU2NVq1hbTX\r\na=ssrc:3330614625 msid:04fda1f1-f027-47bb-8409-287ea2742662 539e8ef3-1083-4720-b348-2c94fbdec4d6\r\nm=video 9 UDP/TLS/RTP/SAVPF 96 97 103 104 107 108 109 114 115 116 117 118 39 40 45 46 98 99 100 101 119 120 123 124 125\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:lOxT\r\na=ice-pwd:MDz9IPyuwvYByL5X+X22bWGT\r\na=ice-options:trickle\r\na=fingerprint:sha-256 33:FE:BD:B7:AB:EC:4D:C7:04:2C:B6:0E:BC:B0:D6:AC:EF:07:BD:86:96:3A:1D:5E:BD:14:5C:D4:6C:C6:5E:ED\r\na=setup:actpass\r\na=mid:1\r\na=extmap:14 urn:ietf:params:rtp-hdrext:toffset\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:13 urn:3gpp:video-orientation\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:5 http://www.webrtc.org/experiments/rtp-hdrext/playout-delay\r\na=extmap:6 http://www.webrtc.org/experiments/rtp-hdrext/video-content-type\r\na=extmap:7 http://www.webrtc.org/experiments/rtp-hdrext/video-timing\r\na=extmap:8 http://www.webrtc.org/experiments/rtp-hdrext/color-space\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=extmap:10 urn:ietf:params:rtp-hdrext:sdes:rtp-stream-id\r\na=extmap:11 urn:ietf:params:rtp-hdrext:sdes:repaired-rtp-stream-id\r\na=sendrecv\r\na=msid:04fda1f1-f027-47bb-8409-287ea2742662 d409829b-6275-4436-afb4-2b80a1ef8d54\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:96 VP8/90000\r\na=rtcp-fb:96 goog-remb\r\na=rtcp-fb:96 transport-cc\r\na=rtcp-fb:96 ccm fir\r\na=rtcp-fb:96 nack\r\na=rtcp-fb:96 nack pli\r\na=rtpmap:97 rtx/90000\r\na=fmtp:97 apt=96\r\na=rtpmap:103 H264/90000\r\na=rtcp-fb:103 goog-remb\r\na=rtcp-fb:103 transport-cc\r\na=rtcp-fb:103 ccm fir\r\na=rtcp-fb:103 nack\r\na=rtcp-fb:103 nack pli\r\na=fmtp:103 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42001f\r\na=rtpmap:104 rtx/90000\r\na=fmtp:104 apt=103\r\na=rtpmap:107 H264/90000\r\na=rtcp-fb:107 goog-remb\r\na=rtcp-fb:107 transport-cc\r\na=rtcp-fb:107 ccm fir\r\na=rtcp-fb:107 nack\r\na=rtcp-fb:107 nack pli\r\na=fmtp:107 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42001f\r\na=rtpmap:108 rtx/90000\r\na=fmtp:108 apt=107\r\na=rtpmap:109 H264/90000\r\na=rtcp-fb:109 goog-remb\r\na=rtcp-fb:109 transport-cc\r\na=rtcp-fb:109 ccm fir\r\na=rtcp-fb:109 nack\r\na=rtcp-fb:109 nack pli\r\na=fmtp:109 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42e01f\r\na=rtpmap:114 rtx/90000\r\na=fmtp:114 apt=109\r\na=rtpmap:115 H264/90000\r\na=rtcp-fb:115 goog-remb\r\na=rtcp-fb:115 transport-cc\r\na=rtcp-fb:115 ccm fir\r\na=rtcp-fb:115 nack\r\na=rtcp-fb:115 nack pli\r\na=fmtp:115 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42e01f\r\na=rtpmap:116 rtx/90000\r\na=fmtp:116 apt=115\r\na=rtpmap:117 H264/90000\r\na=rtcp-fb:117 goog-remb\r\na=rtcp-fb:117 transport-cc\r\na=rtcp-fb:117 ccm fir\r\na=rtcp-fb:117 nack\r\na=rtcp-fb:117 nack pli\r\na=fmtp:117 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=4d001f\r\na=rtpmap:118 rtx/90000\r\na=fmtp:118 apt=117\r\na=rtpmap:39 H264/90000\r\na=rtcp-fb:39 goog-remb\r\na=rtcp-fb:39 transport-cc\r\na=rtcp-fb:39 ccm fir\r\na=rtcp-fb:39 nack\r\na=rtcp-fb:39 nack pli\r\na=fmtp:39 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=4d001f\r\na=rtpmap:40 rtx/90000\r\na=fmtp:40 apt=39\r\na=rtpmap:45 AV1/90000\r\na=rtcp-fb:45 goog-remb\r\na=rtcp-fb:45 transport-cc\r\na=rtcp-fb:45 ccm fir\r\na=rtcp-fb:45 nack\r\na=rtcp-fb:45 nack pli\r\na=fmtp:45 level-idx=5;profile=0;tier=0\r\na=rtpmap:46 rtx/90000\r\na=fmtp:46 apt=45\r\na=rtpmap:98 VP9/90000\r\na=rtcp-fb:98 goog-remb\r\na=rtcp-fb:98 transport-cc\r\na=rtcp-fb:98 ccm fir\r\na=rtcp-fb:98 nack\r\na=rtcp-fb:98 nack pli\r\na=fmtp:98 profile-id=0\r\na=rtpmap:99 rtx/90000\r\na=fmtp:99 apt=98\r\na=rtpmap:100 VP9/90000\r\na=rtcp-fb:100 goog-remb\r\na=rtcp-fb:100 transport-cc\r\na=rtcp-fb:100 ccm fir\r\na=rtcp-fb:100 nack\r\na=rtcp-fb:100 nack pli\r\na=fmtp:100 profile-id=2\r\na=rtpmap:101 rtx/90000\r\na=fmtp:101 apt=100\r\na=rtpmap:119 H264/90000\r\na=rtcp-fb:119 goog-remb\r\na=rtcp-fb:119 transport-cc\r\na=rtcp-fb:119 ccm fir\r\na=rtcp-fb:119 nack\r\na=rtcp-fb:119 nack pli\r\na=fmtp:119 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=64001f\r\na=rtpmap:120 rtx/90000\r\na=fmtp:120 apt=119\r\na=rtpmap:123 red/90000\r\na=rtpmap:124 rtx/90000\r\na=fmtp:124 apt=123\r\na=rtpmap:125 ulpfec/90000\r\na=ssrc-group:FID 4137186318 3289869844\r\na=ssrc:4137186318 cname:JbbIYuU2NVq1hbTX\r\na=ssrc:4137186318 msid:04fda1f1-f027-47bb-8409-287ea2742662 d409829b-6275-4436-afb4-2b80a1ef8d54\r\na=ssrc:3289869844 cname:JbbIYuU2NVq1hbTX\r\na=ssrc:3289869844 msid:04fda1f1-f027-47bb-8409-287ea2742662 d409829b-6275-4436-afb4-2b80a1ef8d54\r\n', 'v=0\r\no=- 2740284207762773431 2 IN IP4 127.0.0.1\r\ns=-\r\nt=0 0\r\na=group:BUNDLE 0 1\r\na=extmap-allow-mixed\r\na=msid-semantic: WMS bc4f7994-82fd-481b-af2e-b1c58d7e52a2\r\nm=audio 9 UDP/TLS/RTP/SAVPF 111 63 9 0 8 13 110 126\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:E2nC\r\na=ice-pwd:/4uXODa56oq1PyucN/JDrXEQ\r\na=ice-options:trickle\r\na=fingerprint:sha-256 B2:2D:4B:4E:55:4A:69:CD:10:23:95:CA:4B:4A:36:EE:46:1A:CB:41:21:0C:88:D4:2F:59:9B:34:57:3E:48:02\r\na=setup:active\r\na=mid:0\r\na=extmap:1 urn:ietf:params:rtp-hdrext:ssrc-audio-level\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=sendrecv\r\na=msid:bc4f7994-82fd-481b-af2e-b1c58d7e52a2 28f271ab-ac17-4be7-9904-6e20e629947b\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:111 opus/48000/2\r\na=rtcp-fb:111 transport-cc\r\na=fmtp:111 minptime=10;useinbandfec=1\r\na=rtpmap:63 red/48000/2\r\na=fmtp:63 111/111\r\na=rtpmap:9 G722/8000\r\na=rtpmap:0 PCMU/8000\r\na=rtpmap:8 PCMA/8000\r\na=rtpmap:13 CN/8000\r\na=rtpmap:110 telephone-event/48000\r\na=rtpmap:126 telephone-event/8000\r\na=ssrc:3344430526 cname:SuxgtdgVc26vFSMT\r\nm=video 9 UDP/TLS/RTP/SAVPF 96 97 103 104 107 108 109 114 115 116 117 118 39 40 45 46 98 99 100 101 119 120 123 124 125\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:E2nC\r\na=ice-pwd:/4uXODa56oq1PyucN/JDrXEQ\r\na=ice-options:trickle\r\na=fingerprint:sha-256 B2:2D:4B:4E:55:4A:69:CD:10:23:95:CA:4B:4A:36:EE:46:1A:CB:41:21:0C:88:D4:2F:59:9B:34:57:3E:48:02\r\na=setup:active\r\na=mid:1\r\na=extmap:14 urn:ietf:params:rtp-hdrext:toffset\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:13 urn:3gpp:video-orientation\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:5 http://www.webrtc.org/experiments/rtp-hdrext/playout-delay\r\na=extmap:6 http://www.webrtc.org/experiments/rtp-hdrext/video-content-type\r\na=extmap:7 http://www.webrtc.org/experiments/rtp-hdrext/video-timing\r\na=extmap:8 http://www.webrtc.org/experiments/rtp-hdrext/color-space\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=extmap:10 urn:ietf:params:rtp-hdrext:sdes:rtp-stream-id\r\na=extmap:11 urn:ietf:params:rtp-hdrext:sdes:repaired-rtp-stream-id\r\na=sendrecv\r\na=msid:bc4f7994-82fd-481b-af2e-b1c58d7e52a2 0498fa89-3c42-4b4b-8c26-8c25c0298698\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:96 VP8/90000\r\na=rtcp-fb:96 goog-remb\r\na=rtcp-fb:96 transport-cc\r\na=rtcp-fb:96 ccm fir\r\na=rtcp-fb:96 nack\r\na=rtcp-fb:96 nack pli\r\na=rtpmap:97 rtx/90000\r\na=fmtp:97 apt=96\r\na=rtpmap:103 H264/90000\r\na=rtcp-fb:103 goog-remb\r\na=rtcp-fb:103 transport-cc\r\na=rtcp-fb:103 ccm fir\r\na=rtcp-fb:103 nack\r\na=rtcp-fb:103 nack pli\r\na=fmtp:103 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42001f\r\na=rtpmap:104 rtx/90000\r\na=fmtp:104 apt=103\r\na=rtpmap:107 H264/90000\r\na=rtcp-fb:107 goog-remb\r\na=rtcp-fb:107 transport-cc\r\na=rtcp-fb:107 ccm fir\r\na=rtcp-fb:107 nack\r\na=rtcp-fb:107 nack pli\r\na=fmtp:107 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42001f\r\na=rtpmap:108 rtx/90000\r\na=fmtp:108 apt=107\r\na=rtpmap:109 H264/90000\r\na=rtcp-fb:109 goog-remb\r\na=rtcp-fb:109 transport-cc\r\na=rtcp-fb:109 ccm fir\r\na=rtcp-fb:109 nack\r\na=rtcp-fb:109 nack pli\r\na=fmtp:109 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42e01f\r\na=rtpmap:114 rtx/90000\r\na=fmtp:114 apt=109\r\na=rtpmap:115 H264/90000\r\na=rtcp-fb:115 goog-remb\r\na=rtcp-fb:115 transport-cc\r\na=rtcp-fb:115 ccm fir\r\na=rtcp-fb:115 nack\r\na=rtcp-fb:115 nack pli\r\na=fmtp:115 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42e01f\r\na=rtpmap:116 rtx/90000\r\na=fmtp:116 apt=115\r\na=rtpmap:117 H264/90000\r\na=rtcp-fb:117 goog-remb\r\na=rtcp-fb:117 transport-cc\r\na=rtcp-fb:117 ccm fir\r\na=rtcp-fb:117 nack\r\na=rtcp-fb:117 nack pli\r\na=fmtp:117 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=4d001f\r\na=rtpmap:118 rtx/90000\r\na=fmtp:118 apt=117\r\na=rtpmap:39 H264/90000\r\na=rtcp-fb:39 goog-remb\r\na=rtcp-fb:39 transport-cc\r\na=rtcp-fb:39 ccm fir\r\na=rtcp-fb:39 nack\r\na=rtcp-fb:39 nack pli\r\na=fmtp:39 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=4d001f\r\na=rtpmap:40 rtx/90000\r\na=fmtp:40 apt=39\r\na=rtpmap:45 AV1/90000\r\na=rtcp-fb:45 goog-remb\r\na=rtcp-fb:45 transport-cc\r\na=rtcp-fb:45 ccm fir\r\na=rtcp-fb:45 nack\r\na=rtcp-fb:45 nack pli\r\na=fmtp:45 level-idx=5;profile=0;tier=0\r\na=rtpmap:46 rtx/90000\r\na=fmtp:46 apt=45\r\na=rtpmap:98 VP9/90000\r\na=rtcp-fb:98 goog-remb\r\na=rtcp-fb:98 transport-cc\r\na=rtcp-fb:98 ccm fir\r\na=rtcp-fb:98 nack\r\na=rtcp-fb:98 nack pli\r\na=fmtp:98 profile-id=0\r\na=rtpmap:99 rtx/90000\r\na=fmtp:99 apt=98\r\na=rtpmap:100 VP9/90000\r\na=rtcp-fb:100 goog-remb\r\na=rtcp-fb:100 transport-cc\r\na=rtcp-fb:100 ccm fir\r\na=rtcp-fb:100 nack\r\na=rtcp-fb:100 nack pli\r\na=fmtp:100 profile-id=2\r\na=rtpmap:101 rtx/90000\r\na=fmtp:101 apt=100\r\na=rtpmap:119 H264/90000\r\na=rtcp-fb:119 goog-remb\r\na=rtcp-fb:119 transport-cc\r\na=rtcp-fb:119 ccm fir\r\na=rtcp-fb:119 nack\r\na=rtcp-fb:119 nack pli\r\na=fmtp:119 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=64001f\r\na=rtpmap:120 rtx/90000\r\na=fmtp:120 apt=119\r\na=rtpmap:123 red/90000\r\na=rtpmap:124 rtx/90000\r\na=fmtp:124 apt=123\r\na=rtpmap:125 ulpfec/90000\r\na=ssrc-group:FID 3442086438 266781691\r\na=ssrc:3442086438 cname:SuxgtdgVc26vFSMT\r\na=ssrc:266781691 cname:SuxgtdgVc26vFSMT\r\n', '[{\"candidate\":\"candidate:3073002071 1 tcp 1518280447 172.16.1.129 9 typ host tcptype active generation 0 ufrag lOxT network-id 1 network-cost 10\",\"sdpMid\":\"0\",\"sdpMLineIndex\":0,\"usernameFragment\":\"lOxT\"},{\"candidate\":\"candidate:3073002071 1 tcp 1518280447 172.16.1.129 9 typ host tcptype active generation 0 ufrag lOxT network-id 1 network-cost 10\",\"sdpMid\":\"1\",\"sdpMLineIndex\":1,\"usernameFragment\":\"lOxT\"}]', '[{\"candidate\":\"candidate:2427225218 1 udp 2122260223 172.16.1.129 60467 typ host generation 0 ufrag E2nC network-id 1 network-cost 10\",\"sdpMid\":\"0\",\"sdpMLineIndex\":0,\"usernameFragment\":\"E2nC\"},{\"candidate\":\"candidate:3495360043 1 udp 1686052607 216.184.111.2 60467 typ srflx raddr 172.16.1.129 rport 60467 generation 0 ufrag E2nC network-id 1 network-cost 10\",\"sdpMid\":\"0\",\"sdpMLineIndex\":0,\"usernameFragment\":\"E2nC\"},{\"candidate\":\"candidate:3999491610 1 tcp 1518280447 172.16.1.129 9 typ host tcptype active generation 0 ufrag E2nC network-id 1 network-cost 10\",\"sdpMid\":\"0\",\"sdpMLineIndex\":0,\"usernameFragment\":\"E2nC\"}]', '2026-05-28 21:44:01');
INSERT INTO `chat_llamadas` (`id`, `id_remitente`, `id_receptor`, `tipo`, `estado`, `sdp_offer`, `sdp_answer`, `ice_candidates_remitente`, `ice_candidates_receptor`, `fecha`) VALUES
(10, 2, 1, 'video', 'declined', 'v=0\r\no=- 2967554061447101742 2 IN IP4 127.0.0.1\r\ns=-\r\nt=0 0\r\na=group:BUNDLE 0 1\r\na=extmap-allow-mixed\r\na=msid-semantic: WMS 0a415cd7-4420-4e25-9884-354102e14425\r\nm=audio 9 UDP/TLS/RTP/SAVPF 111 63 9 0 8 13 110 126\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:hE2r\r\na=ice-pwd:Ydsd6RQuN3n7L/P2pzEi+WnB\r\na=ice-options:trickle\r\na=fingerprint:sha-256 D6:D6:9C:39:35:E9:01:39:24:AF:F5:FF:79:79:CF:B6:02:5E:27:35:43:4F:78:61:AC:61:BE:AA:4D:82:67:BD\r\na=setup:actpass\r\na=mid:0\r\na=extmap:1 urn:ietf:params:rtp-hdrext:ssrc-audio-level\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=sendrecv\r\na=msid:0a415cd7-4420-4e25-9884-354102e14425 97664e85-8cf5-405e-a45f-a8472cb60f73\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:111 opus/48000/2\r\na=rtcp-fb:111 transport-cc\r\na=fmtp:111 minptime=10;useinbandfec=1\r\na=rtpmap:63 red/48000/2\r\na=fmtp:63 111/111\r\na=rtpmap:9 G722/8000\r\na=rtpmap:0 PCMU/8000\r\na=rtpmap:8 PCMA/8000\r\na=rtpmap:13 CN/8000\r\na=rtpmap:110 telephone-event/48000\r\na=rtpmap:126 telephone-event/8000\r\na=ssrc:3206918691 cname:3lsnbkgtnvnlH08i\r\na=ssrc:3206918691 msid:0a415cd7-4420-4e25-9884-354102e14425 97664e85-8cf5-405e-a45f-a8472cb60f73\r\nm=video 9 UDP/TLS/RTP/SAVPF 96 97 103 104 107 108 109 114 115 116 117 118 39 40 45 46 98 99 100 101 119 120 123 124 125\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:hE2r\r\na=ice-pwd:Ydsd6RQuN3n7L/P2pzEi+WnB\r\na=ice-options:trickle\r\na=fingerprint:sha-256 D6:D6:9C:39:35:E9:01:39:24:AF:F5:FF:79:79:CF:B6:02:5E:27:35:43:4F:78:61:AC:61:BE:AA:4D:82:67:BD\r\na=setup:actpass\r\na=mid:1\r\na=extmap:14 urn:ietf:params:rtp-hdrext:toffset\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:13 urn:3gpp:video-orientation\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:5 http://www.webrtc.org/experiments/rtp-hdrext/playout-delay\r\na=extmap:6 http://www.webrtc.org/experiments/rtp-hdrext/video-content-type\r\na=extmap:7 http://www.webrtc.org/experiments/rtp-hdrext/video-timing\r\na=extmap:8 http://www.webrtc.org/experiments/rtp-hdrext/color-space\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=extmap:10 urn:ietf:params:rtp-hdrext:sdes:rtp-stream-id\r\na=extmap:11 urn:ietf:params:rtp-hdrext:sdes:repaired-rtp-stream-id\r\na=sendrecv\r\na=msid:0a415cd7-4420-4e25-9884-354102e14425 62d56c51-ea07-4269-b5e0-f559f4fea956\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:96 VP8/90000\r\na=rtcp-fb:96 goog-remb\r\na=rtcp-fb:96 transport-cc\r\na=rtcp-fb:96 ccm fir\r\na=rtcp-fb:96 nack\r\na=rtcp-fb:96 nack pli\r\na=rtpmap:97 rtx/90000\r\na=fmtp:97 apt=96\r\na=rtpmap:103 H264/90000\r\na=rtcp-fb:103 goog-remb\r\na=rtcp-fb:103 transport-cc\r\na=rtcp-fb:103 ccm fir\r\na=rtcp-fb:103 nack\r\na=rtcp-fb:103 nack pli\r\na=fmtp:103 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42001f\r\na=rtpmap:104 rtx/90000\r\na=fmtp:104 apt=103\r\na=rtpmap:107 H264/90000\r\na=rtcp-fb:107 goog-remb\r\na=rtcp-fb:107 transport-cc\r\na=rtcp-fb:107 ccm fir\r\na=rtcp-fb:107 nack\r\na=rtcp-fb:107 nack pli\r\na=fmtp:107 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42001f\r\na=rtpmap:108 rtx/90000\r\na=fmtp:108 apt=107\r\na=rtpmap:109 H264/90000\r\na=rtcp-fb:109 goog-remb\r\na=rtcp-fb:109 transport-cc\r\na=rtcp-fb:109 ccm fir\r\na=rtcp-fb:109 nack\r\na=rtcp-fb:109 nack pli\r\na=fmtp:109 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42e01f\r\na=rtpmap:114 rtx/90000\r\na=fmtp:114 apt=109\r\na=rtpmap:115 H264/90000\r\na=rtcp-fb:115 goog-remb\r\na=rtcp-fb:115 transport-cc\r\na=rtcp-fb:115 ccm fir\r\na=rtcp-fb:115 nack\r\na=rtcp-fb:115 nack pli\r\na=fmtp:115 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42e01f\r\na=rtpmap:116 rtx/90000\r\na=fmtp:116 apt=115\r\na=rtpmap:117 H264/90000\r\na=rtcp-fb:117 goog-remb\r\na=rtcp-fb:117 transport-cc\r\na=rtcp-fb:117 ccm fir\r\na=rtcp-fb:117 nack\r\na=rtcp-fb:117 nack pli\r\na=fmtp:117 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=4d001f\r\na=rtpmap:118 rtx/90000\r\na=fmtp:118 apt=117\r\na=rtpmap:39 H264/90000\r\na=rtcp-fb:39 goog-remb\r\na=rtcp-fb:39 transport-cc\r\na=rtcp-fb:39 ccm fir\r\na=rtcp-fb:39 nack\r\na=rtcp-fb:39 nack pli\r\na=fmtp:39 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=4d001f\r\na=rtpmap:40 rtx/90000\r\na=fmtp:40 apt=39\r\na=rtpmap:45 AV1/90000\r\na=rtcp-fb:45 goog-remb\r\na=rtcp-fb:45 transport-cc\r\na=rtcp-fb:45 ccm fir\r\na=rtcp-fb:45 nack\r\na=rtcp-fb:45 nack pli\r\na=fmtp:45 level-idx=5;profile=0;tier=0\r\na=rtpmap:46 rtx/90000\r\na=fmtp:46 apt=45\r\na=rtpmap:98 VP9/90000\r\na=rtcp-fb:98 goog-remb\r\na=rtcp-fb:98 transport-cc\r\na=rtcp-fb:98 ccm fir\r\na=rtcp-fb:98 nack\r\na=rtcp-fb:98 nack pli\r\na=fmtp:98 profile-id=0\r\na=rtpmap:99 rtx/90000\r\na=fmtp:99 apt=98\r\na=rtpmap:100 VP9/90000\r\na=rtcp-fb:100 goog-remb\r\na=rtcp-fb:100 transport-cc\r\na=rtcp-fb:100 ccm fir\r\na=rtcp-fb:100 nack\r\na=rtcp-fb:100 nack pli\r\na=fmtp:100 profile-id=2\r\na=rtpmap:101 rtx/90000\r\na=fmtp:101 apt=100\r\na=rtpmap:119 H264/90000\r\na=rtcp-fb:119 goog-remb\r\na=rtcp-fb:119 transport-cc\r\na=rtcp-fb:119 ccm fir\r\na=rtcp-fb:119 nack\r\na=rtcp-fb:119 nack pli\r\na=fmtp:119 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=64001f\r\na=rtpmap:120 rtx/90000\r\na=fmtp:120 apt=119\r\na=rtpmap:123 red/90000\r\na=rtpmap:124 rtx/90000\r\na=fmtp:124 apt=123\r\na=rtpmap:125 ulpfec/90000\r\na=ssrc-group:FID 3490289068 283016927\r\na=ssrc:3490289068 cname:3lsnbkgtnvnlH08i\r\na=ssrc:3490289068 msid:0a415cd7-4420-4e25-9884-354102e14425 62d56c51-ea07-4269-b5e0-f559f4fea956\r\na=ssrc:283016927 cname:3lsnbkgtnvnlH08i\r\na=ssrc:283016927 msid:0a415cd7-4420-4e25-9884-354102e14425 62d56c51-ea07-4269-b5e0-f559f4fea956\r\n', NULL, '[{\"candidate\":\"candidate:359241035 1 tcp 1518280447 172.16.1.129 9 typ host tcptype active generation 0 ufrag hE2r network-id 1 network-cost 10\",\"sdpMid\":\"0\",\"sdpMLineIndex\":0,\"usernameFragment\":\"hE2r\"},{\"candidate\":\"candidate:359241035 1 tcp 1518280447 172.16.1.129 9 typ host tcptype active generation 0 ufrag hE2r network-id 1 network-cost 10\",\"sdpMid\":\"1\",\"sdpMLineIndex\":1,\"usernameFragment\":\"hE2r\"},{\"candidate\":\"candidate:727451002 1 udp 1686052607 216.184.111.2 63058 typ srflx raddr 172.16.1.129 rport 63058 generation 0 ufrag hE2r network-id 1 network-cost 10\",\"sdpMid\":\"0\",\"sdpMLineIndex\":0,\"usernameFragment\":\"hE2r\"},{\"candidate\":\"candidate:727451002 1 udp 1686052607 216.184.111.2 63059 typ srflx raddr 172.16.1.129 rport 63059 generation 0 ufrag hE2r network-id 1 network-cost 10\",\"sdpMid\":\"1\",\"sdpMLineIndex\":1,\"usernameFragment\":\"hE2r\"}]', NULL, '2026-05-29 20:52:45'),
(11, 9, 1, 'video', 'hungup', 'v=0\r\no=- 5935180239410342520 2 IN IP4 127.0.0.1\r\ns=-\r\nt=0 0\r\na=group:BUNDLE 0 1\r\na=extmap-allow-mixed\r\na=msid-semantic: WMS ea6eb8ae-5df1-4cec-8e17-3558493b0a6b\r\nm=audio 9 UDP/TLS/RTP/SAVPF 111 63 9 0 8 13 110 126\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:DK0a\r\na=ice-pwd:Hhx66WsV46W7YT/e70WlM1aj\r\na=ice-options:trickle\r\na=fingerprint:sha-256 A0:A5:18:A9:C9:A2:BA:E7:8C:9B:52:D5:41:35:CE:0E:2C:DB:82:0F:E4:4B:E3:57:7F:0A:64:CC:50:2D:E5:D3\r\na=setup:actpass\r\na=mid:0\r\na=extmap:1 urn:ietf:params:rtp-hdrext:ssrc-audio-level\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=sendrecv\r\na=msid:ea6eb8ae-5df1-4cec-8e17-3558493b0a6b df74b3a1-d5c6-4731-9834-5e7f9b58f3f0\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:111 opus/48000/2\r\na=rtcp-fb:111 transport-cc\r\na=fmtp:111 minptime=10;useinbandfec=1\r\na=rtpmap:63 red/48000/2\r\na=fmtp:63 111/111\r\na=rtpmap:9 G722/8000\r\na=rtpmap:0 PCMU/8000\r\na=rtpmap:8 PCMA/8000\r\na=rtpmap:13 CN/8000\r\na=rtpmap:110 telephone-event/48000\r\na=rtpmap:126 telephone-event/8000\r\na=ssrc:1766787785 cname:UNvpGeK1lnNfUCBV\r\na=ssrc:1766787785 msid:ea6eb8ae-5df1-4cec-8e17-3558493b0a6b df74b3a1-d5c6-4731-9834-5e7f9b58f3f0\r\nm=video 9 UDP/TLS/RTP/SAVPF 96 97 103 104 107 108 109 114 115 116 117 118 39 40 45 46 98 99 100 101 119 120 123 124 125\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:DK0a\r\na=ice-pwd:Hhx66WsV46W7YT/e70WlM1aj\r\na=ice-options:trickle\r\na=fingerprint:sha-256 A0:A5:18:A9:C9:A2:BA:E7:8C:9B:52:D5:41:35:CE:0E:2C:DB:82:0F:E4:4B:E3:57:7F:0A:64:CC:50:2D:E5:D3\r\na=setup:actpass\r\na=mid:1\r\na=extmap:14 urn:ietf:params:rtp-hdrext:toffset\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:13 urn:3gpp:video-orientation\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:5 http://www.webrtc.org/experiments/rtp-hdrext/playout-delay\r\na=extmap:6 http://www.webrtc.org/experiments/rtp-hdrext/video-content-type\r\na=extmap:7 http://www.webrtc.org/experiments/rtp-hdrext/video-timing\r\na=extmap:8 http://www.webrtc.org/experiments/rtp-hdrext/color-space\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=extmap:10 urn:ietf:params:rtp-hdrext:sdes:rtp-stream-id\r\na=extmap:11 urn:ietf:params:rtp-hdrext:sdes:repaired-rtp-stream-id\r\na=sendrecv\r\na=msid:ea6eb8ae-5df1-4cec-8e17-3558493b0a6b af51e256-d1ec-4db0-8261-b4766d199fe5\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:96 VP8/90000\r\na=rtcp-fb:96 goog-remb\r\na=rtcp-fb:96 transport-cc\r\na=rtcp-fb:96 ccm fir\r\na=rtcp-fb:96 nack\r\na=rtcp-fb:96 nack pli\r\na=rtpmap:97 rtx/90000\r\na=fmtp:97 apt=96\r\na=rtpmap:103 H264/90000\r\na=rtcp-fb:103 goog-remb\r\na=rtcp-fb:103 transport-cc\r\na=rtcp-fb:103 ccm fir\r\na=rtcp-fb:103 nack\r\na=rtcp-fb:103 nack pli\r\na=fmtp:103 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42001f\r\na=rtpmap:104 rtx/90000\r\na=fmtp:104 apt=103\r\na=rtpmap:107 H264/90000\r\na=rtcp-fb:107 goog-remb\r\na=rtcp-fb:107 transport-cc\r\na=rtcp-fb:107 ccm fir\r\na=rtcp-fb:107 nack\r\na=rtcp-fb:107 nack pli\r\na=fmtp:107 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42001f\r\na=rtpmap:108 rtx/90000\r\na=fmtp:108 apt=107\r\na=rtpmap:109 H264/90000\r\na=rtcp-fb:109 goog-remb\r\na=rtcp-fb:109 transport-cc\r\na=rtcp-fb:109 ccm fir\r\na=rtcp-fb:109 nack\r\na=rtcp-fb:109 nack pli\r\na=fmtp:109 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42e01f\r\na=rtpmap:114 rtx/90000\r\na=fmtp:114 apt=109\r\na=rtpmap:115 H264/90000\r\na=rtcp-fb:115 goog-remb\r\na=rtcp-fb:115 transport-cc\r\na=rtcp-fb:115 ccm fir\r\na=rtcp-fb:115 nack\r\na=rtcp-fb:115 nack pli\r\na=fmtp:115 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42e01f\r\na=rtpmap:116 rtx/90000\r\na=fmtp:116 apt=115\r\na=rtpmap:117 H264/90000\r\na=rtcp-fb:117 goog-remb\r\na=rtcp-fb:117 transport-cc\r\na=rtcp-fb:117 ccm fir\r\na=rtcp-fb:117 nack\r\na=rtcp-fb:117 nack pli\r\na=fmtp:117 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=4d001f\r\na=rtpmap:118 rtx/90000\r\na=fmtp:118 apt=117\r\na=rtpmap:39 H264/90000\r\na=rtcp-fb:39 goog-remb\r\na=rtcp-fb:39 transport-cc\r\na=rtcp-fb:39 ccm fir\r\na=rtcp-fb:39 nack\r\na=rtcp-fb:39 nack pli\r\na=fmtp:39 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=4d001f\r\na=rtpmap:40 rtx/90000\r\na=fmtp:40 apt=39\r\na=rtpmap:45 AV1/90000\r\na=rtcp-fb:45 goog-remb\r\na=rtcp-fb:45 transport-cc\r\na=rtcp-fb:45 ccm fir\r\na=rtcp-fb:45 nack\r\na=rtcp-fb:45 nack pli\r\na=fmtp:45 level-idx=5;profile=0;tier=0\r\na=rtpmap:46 rtx/90000\r\na=fmtp:46 apt=45\r\na=rtpmap:98 VP9/90000\r\na=rtcp-fb:98 goog-remb\r\na=rtcp-fb:98 transport-cc\r\na=rtcp-fb:98 ccm fir\r\na=rtcp-fb:98 nack\r\na=rtcp-fb:98 nack pli\r\na=fmtp:98 profile-id=0\r\na=rtpmap:99 rtx/90000\r\na=fmtp:99 apt=98\r\na=rtpmap:100 VP9/90000\r\na=rtcp-fb:100 goog-remb\r\na=rtcp-fb:100 transport-cc\r\na=rtcp-fb:100 ccm fir\r\na=rtcp-fb:100 nack\r\na=rtcp-fb:100 nack pli\r\na=fmtp:100 profile-id=2\r\na=rtpmap:101 rtx/90000\r\na=fmtp:101 apt=100\r\na=rtpmap:119 H264/90000\r\na=rtcp-fb:119 goog-remb\r\na=rtcp-fb:119 transport-cc\r\na=rtcp-fb:119 ccm fir\r\na=rtcp-fb:119 nack\r\na=rtcp-fb:119 nack pli\r\na=fmtp:119 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=64001f\r\na=rtpmap:120 rtx/90000\r\na=fmtp:120 apt=119\r\na=rtpmap:123 red/90000\r\na=rtpmap:124 rtx/90000\r\na=fmtp:124 apt=123\r\na=rtpmap:125 ulpfec/90000\r\na=ssrc-group:FID 208358276 3043922484\r\na=ssrc:208358276 cname:UNvpGeK1lnNfUCBV\r\na=ssrc:208358276 msid:ea6eb8ae-5df1-4cec-8e17-3558493b0a6b af51e256-d1ec-4db0-8261-b4766d199fe5\r\na=ssrc:3043922484 cname:UNvpGeK1lnNfUCBV\r\na=ssrc:3043922484 msid:ea6eb8ae-5df1-4cec-8e17-3558493b0a6b af51e256-d1ec-4db0-8261-b4766d199fe5\r\n', NULL, NULL, NULL, '2026-06-02 15:25:49'),
(12, 1, 9, 'video', 'hungup', 'v=0\r\no=- 1523247191494152977 2 IN IP4 127.0.0.1\r\ns=-\r\nt=0 0\r\na=group:BUNDLE 0 1\r\na=extmap-allow-mixed\r\na=msid-semantic: WMS 00bc75af-b696-444d-ba2d-3bda150402ed\r\nm=audio 9 UDP/TLS/RTP/SAVPF 111 63 9 0 8 13 110 126\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:Tl1P\r\na=ice-pwd:jnBwZkDUYghjDiXmybNucy0/\r\na=ice-options:trickle\r\na=fingerprint:sha-256 D7:BB:BF:8E:A9:AB:87:A8:99:F2:12:AE:07:F1:3B:09:06:24:8E:B5:85:EA:78:A6:83:3C:90:14:8A:20:8D:8F\r\na=setup:actpass\r\na=mid:0\r\na=extmap:1 urn:ietf:params:rtp-hdrext:ssrc-audio-level\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=sendrecv\r\na=msid:00bc75af-b696-444d-ba2d-3bda150402ed 2ac08fcd-ea84-4085-8692-155b309dea72\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:111 opus/48000/2\r\na=rtcp-fb:111 transport-cc\r\na=fmtp:111 minptime=10;useinbandfec=1\r\na=rtpmap:63 red/48000/2\r\na=fmtp:63 111/111\r\na=rtpmap:9 G722/8000\r\na=rtpmap:0 PCMU/8000\r\na=rtpmap:8 PCMA/8000\r\na=rtpmap:13 CN/8000\r\na=rtpmap:110 telephone-event/48000\r\na=rtpmap:126 telephone-event/8000\r\na=ssrc:897600209 cname:js5o2+R1BPVWIGuH\r\na=ssrc:897600209 msid:00bc75af-b696-444d-ba2d-3bda150402ed 2ac08fcd-ea84-4085-8692-155b309dea72\r\nm=video 9 UDP/TLS/RTP/SAVPF 96 97 103 104 107 108 109 114 115 116 117 118 39 40 45 46 98 99 100 101 119 120 123 124 125\r\nc=IN IP4 0.0.0.0\r\na=rtcp:9 IN IP4 0.0.0.0\r\na=ice-ufrag:Tl1P\r\na=ice-pwd:jnBwZkDUYghjDiXmybNucy0/\r\na=ice-options:trickle\r\na=fingerprint:sha-256 D7:BB:BF:8E:A9:AB:87:A8:99:F2:12:AE:07:F1:3B:09:06:24:8E:B5:85:EA:78:A6:83:3C:90:14:8A:20:8D:8F\r\na=setup:actpass\r\na=mid:1\r\na=extmap:14 urn:ietf:params:rtp-hdrext:toffset\r\na=extmap:2 http://www.webrtc.org/experiments/rtp-hdrext/abs-send-time\r\na=extmap:13 urn:3gpp:video-orientation\r\na=extmap:3 http://www.ietf.org/id/draft-holmer-rmcat-transport-wide-cc-extensions-01\r\na=extmap:5 http://www.webrtc.org/experiments/rtp-hdrext/playout-delay\r\na=extmap:6 http://www.webrtc.org/experiments/rtp-hdrext/video-content-type\r\na=extmap:7 http://www.webrtc.org/experiments/rtp-hdrext/video-timing\r\na=extmap:8 http://www.webrtc.org/experiments/rtp-hdrext/color-space\r\na=extmap:4 urn:ietf:params:rtp-hdrext:sdes:mid\r\na=extmap:10 urn:ietf:params:rtp-hdrext:sdes:rtp-stream-id\r\na=extmap:11 urn:ietf:params:rtp-hdrext:sdes:repaired-rtp-stream-id\r\na=sendrecv\r\na=msid:00bc75af-b696-444d-ba2d-3bda150402ed 03ce7f3f-5eba-4a6d-a300-cc940bd777be\r\na=rtcp-mux\r\na=rtcp-rsize\r\na=rtpmap:96 VP8/90000\r\na=rtcp-fb:96 goog-remb\r\na=rtcp-fb:96 transport-cc\r\na=rtcp-fb:96 ccm fir\r\na=rtcp-fb:96 nack\r\na=rtcp-fb:96 nack pli\r\na=rtpmap:97 rtx/90000\r\na=fmtp:97 apt=96\r\na=rtpmap:103 H264/90000\r\na=rtcp-fb:103 goog-remb\r\na=rtcp-fb:103 transport-cc\r\na=rtcp-fb:103 ccm fir\r\na=rtcp-fb:103 nack\r\na=rtcp-fb:103 nack pli\r\na=fmtp:103 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42001f\r\na=rtpmap:104 rtx/90000\r\na=fmtp:104 apt=103\r\na=rtpmap:107 H264/90000\r\na=rtcp-fb:107 goog-remb\r\na=rtcp-fb:107 transport-cc\r\na=rtcp-fb:107 ccm fir\r\na=rtcp-fb:107 nack\r\na=rtcp-fb:107 nack pli\r\na=fmtp:107 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42001f\r\na=rtpmap:108 rtx/90000\r\na=fmtp:108 apt=107\r\na=rtpmap:109 H264/90000\r\na=rtcp-fb:109 goog-remb\r\na=rtcp-fb:109 transport-cc\r\na=rtcp-fb:109 ccm fir\r\na=rtcp-fb:109 nack\r\na=rtcp-fb:109 nack pli\r\na=fmtp:109 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=42e01f\r\na=rtpmap:114 rtx/90000\r\na=fmtp:114 apt=109\r\na=rtpmap:115 H264/90000\r\na=rtcp-fb:115 goog-remb\r\na=rtcp-fb:115 transport-cc\r\na=rtcp-fb:115 ccm fir\r\na=rtcp-fb:115 nack\r\na=rtcp-fb:115 nack pli\r\na=fmtp:115 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=42e01f\r\na=rtpmap:116 rtx/90000\r\na=fmtp:116 apt=115\r\na=rtpmap:117 H264/90000\r\na=rtcp-fb:117 goog-remb\r\na=rtcp-fb:117 transport-cc\r\na=rtcp-fb:117 ccm fir\r\na=rtcp-fb:117 nack\r\na=rtcp-fb:117 nack pli\r\na=fmtp:117 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=4d001f\r\na=rtpmap:118 rtx/90000\r\na=fmtp:118 apt=117\r\na=rtpmap:39 H264/90000\r\na=rtcp-fb:39 goog-remb\r\na=rtcp-fb:39 transport-cc\r\na=rtcp-fb:39 ccm fir\r\na=rtcp-fb:39 nack\r\na=rtcp-fb:39 nack pli\r\na=fmtp:39 level-asymmetry-allowed=1;packetization-mode=0;profile-level-id=4d001f\r\na=rtpmap:40 rtx/90000\r\na=fmtp:40 apt=39\r\na=rtpmap:45 AV1/90000\r\na=rtcp-fb:45 goog-remb\r\na=rtcp-fb:45 transport-cc\r\na=rtcp-fb:45 ccm fir\r\na=rtcp-fb:45 nack\r\na=rtcp-fb:45 nack pli\r\na=fmtp:45 level-idx=5;profile=0;tier=0\r\na=rtpmap:46 rtx/90000\r\na=fmtp:46 apt=45\r\na=rtpmap:98 VP9/90000\r\na=rtcp-fb:98 goog-remb\r\na=rtcp-fb:98 transport-cc\r\na=rtcp-fb:98 ccm fir\r\na=rtcp-fb:98 nack\r\na=rtcp-fb:98 nack pli\r\na=fmtp:98 profile-id=0\r\na=rtpmap:99 rtx/90000\r\na=fmtp:99 apt=98\r\na=rtpmap:100 VP9/90000\r\na=rtcp-fb:100 goog-remb\r\na=rtcp-fb:100 transport-cc\r\na=rtcp-fb:100 ccm fir\r\na=rtcp-fb:100 nack\r\na=rtcp-fb:100 nack pli\r\na=fmtp:100 profile-id=2\r\na=rtpmap:101 rtx/90000\r\na=fmtp:101 apt=100\r\na=rtpmap:119 H264/90000\r\na=rtcp-fb:119 goog-remb\r\na=rtcp-fb:119 transport-cc\r\na=rtcp-fb:119 ccm fir\r\na=rtcp-fb:119 nack\r\na=rtcp-fb:119 nack pli\r\na=fmtp:119 level-asymmetry-allowed=1;packetization-mode=1;profile-level-id=64001f\r\na=rtpmap:120 rtx/90000\r\na=fmtp:120 apt=119\r\na=rtpmap:123 red/90000\r\na=rtpmap:124 rtx/90000\r\na=fmtp:124 apt=123\r\na=rtpmap:125 ulpfec/90000\r\na=ssrc-group:FID 4249645869 1995977292\r\na=ssrc:4249645869 cname:js5o2+R1BPVWIGuH\r\na=ssrc:4249645869 msid:00bc75af-b696-444d-ba2d-3bda150402ed 03ce7f3f-5eba-4a6d-a300-cc940bd777be\r\na=ssrc:1995977292 cname:js5o2+R1BPVWIGuH\r\na=ssrc:1995977292 msid:00bc75af-b696-444d-ba2d-3bda150402ed 03ce7f3f-5eba-4a6d-a300-cc940bd777be\r\n', NULL, NULL, NULL, '2026-06-03 16:21:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chat_mensajes`
--

CREATE TABLE IF NOT EXISTS `chat_mensajes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_conversacion` int(11) NOT NULL,
  `id_remitente` int(11) NOT NULL,
  `mensaje` text NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 0 COMMENT '0: No leido, 1: Leido',
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `leido` tinyint(1) NOT NULL DEFAULT 0,
  `tipo` varchar(20) DEFAULT 'text',
  `archivo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `chat_mensajes`
--

INSERT INTO `chat_mensajes` (`id`, `id_conversacion`, `id_remitente`, `mensaje`, `estado`, `fecha`, `leido`, `tipo`, `archivo`) VALUES
(1, 1, 1, 'lorem', 1, '2026-05-26 20:07:29', 1, 'text', NULL),
(2, 1, 1, 'ipsum', 1, '2026-05-26 21:22:40', 1, 'text', NULL),
(3, 1, 2, 'ipsum', 1, '2026-05-26 21:50:05', 1, 'text', NULL),
(4, 1, 1, 'dolor', 1, '2026-05-26 21:57:11', 1, 'text', NULL),
(5, 1, 2, 'percent', 1, '2026-05-26 21:57:22', 1, 'text', NULL),
(6, 1, 1, 'lorem', 1, '2026-05-27 17:17:15', 0, 'text', NULL),
(7, 1, 1, 'dolor', 1, '2026-05-28 21:34:54', 0, 'text', NULL),
(8, 1, 1, 'lorem', 1, '2026-05-28 22:00:22', 0, 'text', ''),
(9, 1, 1, '', 1, '2026-05-28 22:00:29', 0, 'audio', '1780005629_1029.webm'),
(10, 1, 1, '', 1, '2026-05-28 22:00:36', 0, 'audio', '1780005636_1355.webm'),
(11, 1, 1, '', 1, '2026-05-28 22:00:42', 0, 'imagen', '1780005642_5692.png'),
(12, 1, 2, 'Respondió a tu historia \"lorem\": sera', 1, '2026-05-29 20:44:45', 0, 'text', ''),
(13, 1, 1, 'si', 1, '2026-05-29 20:45:24', 0, 'text', '');

--
-- Disparadores `chat_mensajes`
--
DELIMITER $$
CREATE TRIGGER `RegistrarNotificacionesMensajes` AFTER INSERT ON `chat_mensajes` FOR EACH ROW BEGIN
  DECLARE _receptor INT;
  SELECT CASE WHEN id_usuario_1 = NEW.id_remitente THEN id_usuario_2 ELSE id_usuario_1 END INTO _receptor
  FROM chat_conversaciones WHERE id = NEW.id_conversacion;
  
  INSERT INTO notificacionmensajes (id_remitente, id_receptor, id_mensaje, fecha_notificacion)
  VALUES (NEW.id_remitente, _receptor, NEW.id, CURRENT_TIMESTAMP);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE IF NOT EXISTS `comentarios` (
  `idcomenterio` int(11) NOT NULL AUTO_INCREMENT,
  `comentario` varchar(255) NOT NULL,
  `fechacomentario` timestamp NOT NULL DEFAULT current_timestamp(),
  `id` int(11) NOT NULL,
  `idpublicacion` int(11) NOT NULL,
  PRIMARY KEY (`idcomenterio`),
  KEY `id` (`id`),
  KEY `idpublicacion` (`idpublicacion`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`idcomenterio`, `comentario`, `fechacomentario`, `id`, `idpublicacion`) VALUES
(1, '😁😁👍', '2021-02-08 21:53:53', 1, 4),
(2, '🙊🙊😝😊', '2021-02-08 21:54:48', 2, 1),
(3, 'lorem', '2026-05-26 14:59:55', 2, 3),
(4, 'ipsum', '2026-05-26 15:15:56', 2, 3),
(5, 'dolor', '2026-05-26 15:16:19', 2, 3),
(6, 'lorem 1', '2026-05-26 15:45:32', 1, 4),
(7, 'lorem', '2026-05-26 16:45:16', 1, 3),
(8, 'uno', '2026-05-26 16:45:59', 2, 3),
(9, 'lorem', '2026-05-28 15:30:41', 1, 7),
(10, 'lorem', '2026-05-29 20:18:41', 1, 3),
(11, 'lorem', '2026-05-29 21:44:35', 2, 3),
(12, 'lorem', '2026-06-03 16:20:50', 1, 6);

--
-- Disparadores `comentarios`
--
DELIMITER $$
CREATE TRIGGER `EliminarNotificacionesComentarios` AFTER DELETE ON `comentarios` FOR EACH ROW DELETE FROM notificacioncomentarios WHERE idpublicacion=old.idpublicacion AND id=old.id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `RegistrarNotificacionesComentarios` AFTER INSERT ON `comentarios` FOR EACH ROW INSERT INTO notificacioncomentarios (id, idpublicacion,fecha_notificacion) VALUES(new.id,new.idpublicacion,CURRENT_TIMESTAMP)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleusuarios`
--

CREATE TABLE IF NOT EXISTS `detalleusuarios` (
  `iddetalle` int(11) NOT NULL AUTO_INCREMENT,
  `religion` varchar(100) DEFAULT NULL,
  `empleo` varchar(255) DEFAULT NULL,
  `escuela` varchar(255) DEFAULT NULL,
  `universidad` varchar(255) DEFAULT NULL,
  `deportes` varchar(255) DEFAULT NULL,
  `intereses` varchar(100) DEFAULT NULL,
  `generosmusicales` varchar(255) DEFAULT NULL,
  `situacionsentimental` varchar(255) DEFAULT NULL,
  `comprobacionperfil` tinyint(1) NOT NULL,
  `sobremi` varchar(100) NOT NULL,
  `id` int(11) NOT NULL,
  PRIMARY KEY (`iddetalle`),
  UNIQUE KEY `id_2` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalleusuarios`
--

INSERT INTO `detalleusuarios` (`iddetalle`, `religion`, `empleo`, `escuela`, `universidad`, `deportes`, `intereses`, `generosmusicales`, `situacionsentimental`, `comprobacionperfil`, `sobremi`, `id`) VALUES
(1, 'Prueba campo religión', 'Programador / Desarrollador Web', 'Prueba campo educación inicial', 'Prueba campo educación superior', 'Prueba campo deportes', 'Prueba campo intereses sentimentales', 'RAP, HIP HOP, EDM, ROCK, HARD ROCK, ELECTRONIC ROCK, DUBSTEP. Entre otros', 'Prueba campo situación sentimental actual', 0, 'Perfil creador de esta plataforma, si deseas mejorarlo ¡adelante! :)', 1),
(2, '', '', '', '', '', '', '', '', 0, 'Segunda cuenta de prueba.', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE IF NOT EXISTS `eventos` (
  `ideventos` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `pais` varchar(255) NOT NULL,
  `fechainicio` datetime NOT NULL,
  `fechafin` datetime NOT NULL,
  `fotoevento` varchar(255) NOT NULL,
  `id` int(11) NOT NULL,
  PRIMARY KEY (`ideventos`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`ideventos`, `nombre`, `descripcion`, `direccion`, `usuario`, `pais`, `fechainicio`, `fechafin`, `fotoevento`, `id`) VALUES
(1, 'PRUEBA EVENTO', 'PRUEBA EVENTO', 'PRUEBA EVENTO', 'Elmismisimos', 'El Salvador', '2026-06-10 13:27:03', '2026-06-10 19:27:15', 'Visa-reverso.png', 1),
(2, 'lorem', 'lorem', 'lorem', 'Elmismisimos', 'El Salvador', '2026-05-29 14:39:36', '2026-05-30 14:39:40', 'Interac-reverso.png', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historias`
--

CREATE TABLE IF NOT EXISTS `historias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `texto` varchar(150) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `fecha_publicacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historias`
--

INSERT INTO `historias` (`id`, `id_usuario`, `texto`, `foto`, `fecha_publicacion`) VALUES
(1, 2, 'LOREM IPSUM', '1779828711_Interac-reverso.png', '2026-05-26 20:51:51'),
(2, 1, 'lorem', 'story_1780085891_8029.png', '2026-05-29 20:18:11'),
(3, 1, '', 'story_1780349704_2638.png', '2026-06-01 21:35:04'),
(4, 1, 'lo', 'story_1780497943_2519.png', '2026-06-03 14:45:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historias_epimeras`
--

CREATE TABLE IF NOT EXISTS `historias_epimeras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `multimedia` varchar(255) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_usuario_hist` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historias_epimeras`
--

INSERT INTO `historias_epimeras` (`id`, `usuario_id`, `multimedia`, `tipo`, `fecha_creacion`) VALUES
(1, 1, 'story_6a1f4bc68612a.png', 'image', '2026-06-02 21:31:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historia_megusta`
--

CREATE TABLE IF NOT EXISTS `historia_megusta` (
  `id_megusta` int(11) NOT NULL AUTO_INCREMENT,
  `id_historia` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_megusta` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_megusta`),
  UNIQUE KEY `historia_usuario_like` (`id_historia`,`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historia_megusta`
--

INSERT INTO `historia_megusta` (`id_megusta`, `id_historia`, `id_usuario`, `fecha_megusta`) VALUES
(1, 2, 2, '2026-05-29 14:44:47'),
(2, 4, 2, '2026-06-03 09:54:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historia_vistas`
--

CREATE TABLE IF NOT EXISTS `historia_vistas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_historia` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_vista` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `historia_usuario_vista` (`id_historia`,`id_usuario`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historia_vistas`
--

INSERT INTO `historia_vistas` (`id`, `id_historia`, `id_usuario`, `fecha_vista`) VALUES
(1, 1, 2, '2026-05-26 21:04:43'),
(5, 1, 1, '2026-05-26 21:54:46'),
(8, 2, 2, '2026-05-29 20:44:42'),
(9, 4, 2, '2026-06-03 15:54:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `intentos_recuperacion`
--

CREATE TABLE IF NOT EXISTS `intentos_recuperacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `tipo` varchar(50) NOT NULL,
  `fecha_intento` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_ip` (`ip_address`),
  KEY `idx_correo` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `intentos_recuperacion`
--

INSERT INTO `intentos_recuperacion` (`id`, `ip_address`, `correo`, `tipo`, `fecha_intento`) VALUES
(3, '::1', 'daniel.r9712@gmail.com', 'envio_codigo', '2026-06-01 21:45:04'),
(4, '::1', 'daniel.r9712@gmail.com', 'envio_codigo', '2026-06-01 21:45:15'),
(5, '::1', 'daniel.r9712@gmail.com', 'envio_codigo', '2026-06-01 21:45:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marketplace_productos`
--

CREATE TABLE IF NOT EXISTS `marketplace_productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_vendedor` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `latitud` decimal(10,8) NOT NULL,
  `longitud` decimal(11,8) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1 COMMENT '1: Activo, 0: Vendido',
  `fecha_publicacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `categoria` varchar(100) NOT NULL DEFAULT 'Otros',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `marketplace_productos`
--

INSERT INTO `marketplace_productos` (`id`, `id_vendedor`, `titulo`, `descripcion`, `precio`, `imagen`, `ciudad`, `latitud`, `longitud`, `estado`, `fecha_publicacion`, `categoria`) VALUES
(1, 1, 'lorem', 'lorem', 124.00, '1779808526_Interac-reverso.png', 'san salvador', 13.67067425, -89.22181032, 1, '2026-05-26 15:15:26', 'Otros'),
(2, 1, 'PS5', 'PS5 USADO', 560.45, '1779829703_Mastercard-reverso.png', 'SAN SALVADOR', 13.68623601, -89.21321337, 2, '2026-05-26 21:08:23', 'Otros'),
(3, 1, 'PS5', 'LOREM', 124.00, 'prod_6a19f6433838f.png', 'SAN SALVADOR', 13.69290000, -89.21820000, 1, '2026-05-29 20:25:39', 'Otros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajeria`
--

CREATE TABLE IF NOT EXISTS `mensajeria` (
  `idmensaje` int(11) NOT NULL AUTO_INCREMENT,
  `mensaje` varchar(1000) NOT NULL,
  `fechamensaje` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` int(11) NOT NULL DEFAULT 0,
  `id` int(11) NOT NULL,
  PRIMARY KEY (`idmensaje`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mensajeria`
--

INSERT INTO `mensajeria` (`idmensaje`, `mensaje`, `fechamensaje`, `estado`, `id`) VALUES
(1, 'Gracias por visitar Secret. Este es un chat general para comunicarte con todos los usuarios. Recuerda no es en tiempo real.', '2021-02-08 21:25:21', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `musica_favorita`
--

CREATE TABLE IF NOT EXISTS `musica_favorita` (
  `id_musica` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `tipo` enum('audio','video') NOT NULL DEFAULT 'audio',
  `titulo` varchar(255) NOT NULL,
  `artista` varchar(255) NOT NULL,
  `album` varchar(255) DEFAULT NULL,
  `portada_url` varchar(500) DEFAULT NULL,
  `preview_url` varchar(500) DEFAULT NULL,
  `youtube_id` varchar(50) DEFAULT NULL,
  `duracion_ms` int(11) DEFAULT NULL,
  `fecha_publicacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_musica`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `musica_favorita`
--

INSERT INTO `musica_favorita` (`id_musica`, `id_usuario`, `tipo`, `titulo`, `artista`, `album`, `portada_url`, `preview_url`, `youtube_id`, `duracion_ms`, `fecha_publicacion`) VALUES
(1, 2, 'video', '666 - Diablo', 'BOOMBA FM', '', 'https://invidious.flokinet.to/vi/8U_6kwOTbNY/maxres.jpg', '', '8U_6kwOTbNY', 223000, '2026-05-26 21:45:51'),
(2, 2, 'audio', 'In the Name of Love', 'Martin Garrix & Bebe Rexha', 'In The Name Of Love - Single', 'https://is1-ssl.mzstatic.com/image/thumb/Music125/v4/fc/8a/d2/fc8ad2a2-c75b-c33f-5d1a-070539e647bd/886446028088.jpg/300x300bb.jpg', 'https://audio-ssl.itunes.apple.com/itunes-assets/AudioPreview116/v4/04/5b/65/045b6517-c917-9f02-d559-d01aeceed6be/mzaf_8202124789937422466.plus.aac.p.m4a', '', 198815, '2026-05-26 21:48:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas_musica`
--

CREATE TABLE IF NOT EXISTS `notas_musica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `cancion` varchar(100) NOT NULL,
  `artista` varchar(100) NOT NULL,
  `nota` varchar(100) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `audio_file` varchar(255) DEFAULT NULL,
  `start_time` int(11) DEFAULT 0,
  `end_time` int(11) DEFAULT 30,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario_nota_unica` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notas_musica`
--

INSERT INTO `notas_musica` (`id`, `id_usuario`, `cancion`, `artista`, `nota`, `fecha_creacion`, `audio_file`, `start_time`, `end_time`) VALUES
(1, 1, 'Be Her', 'Ella Langley', '', '2026-06-03 15:02:02', 'https://audio-ssl.itunes.apple.com/itunes-assets/AudioPreview221/v4/91/05/09/9105094b-6f98-220b-1f10-c8ed13119483/mzaf_6688838074304676200.plus.aac.p.m4a', 0, 15),
(2, 2, 'Golden', 'HUNTR/X, EJAE, AUDREY NUNA, REI AMI & KPop Demon Hunters Cast', 'AIUDA', '2026-05-26 21:47:27', 'https://audio-ssl.itunes.apple.com/itunes-assets/AudioPreview221/v4/4a/9d/a1/4a9da1c4-096f-8f45-4a3b-c883c45ca451/mzaf_3059921854949935161.plus.aac.p.m4a', 0, 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacionamigos`
--

CREATE TABLE IF NOT EXISTS `notificacionamigos` (
  `idnotificacionamigos` int(11) NOT NULL AUTO_INCREMENT,
  `idamigo` int(11) NOT NULL,
  `idsolicitudamigo` int(11) NOT NULL,
  `fecha_notificacion` timestamp NULL DEFAULT current_timestamp(),
  `id` int(11) NOT NULL,
  PRIMARY KEY (`idnotificacionamigos`),
  KEY `idamigo` (`idamigo`),
  KEY `idsolicitudamigo` (`idsolicitudamigo`),
  KEY `notificacionamigos_ibfk_3` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notificacionamigos`
--

INSERT INTO `notificacionamigos` (`idnotificacionamigos`, `idamigo`, `idsolicitudamigo`, `fecha_notificacion`, `id`) VALUES
(1, 1, 2, '2021-02-08 21:53:25', 1),
(2, 2, 1, '2021-02-08 21:54:24', 2),
(3, 3, 9, '2026-06-03 16:01:10', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacioncomentarios`
--

CREATE TABLE IF NOT EXISTS `notificacioncomentarios` (
  `idnotificacioncomentarios` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `idpublicacion` int(11) NOT NULL,
  `fecha_notificacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`idnotificacioncomentarios`),
  KEY `notificacioncomentarios_ibfk_3` (`idpublicacion`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notificacioncomentarios`
--

INSERT INTO `notificacioncomentarios` (`idnotificacioncomentarios`, `id`, `idpublicacion`, `fecha_notificacion`) VALUES
(1, 1, 4, '2021-02-08 21:53:53'),
(2, 2, 1, '2021-02-08 21:54:48'),
(3, 2, 3, '2026-05-26 14:59:55'),
(4, 2, 3, '2026-05-26 15:15:56'),
(5, 2, 3, '2026-05-26 15:16:19'),
(6, 1, 4, '2026-05-26 15:45:32'),
(7, 1, 3, '2026-05-26 16:45:16'),
(8, 2, 3, '2026-05-26 16:45:59'),
(9, 1, 7, '2026-05-28 15:30:41'),
(10, 1, 3, '2026-05-29 20:18:41'),
(11, 2, 3, '2026-05-29 21:44:35'),
(12, 1, 6, '2026-06-03 16:20:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacionmensajes`
--

CREATE TABLE IF NOT EXISTS `notificacionmensajes` (
  `idnotificacionmensajes` int(11) NOT NULL AUTO_INCREMENT,
  `id_remitente` int(11) NOT NULL,
  `id_receptor` int(11) NOT NULL,
  `id_mensaje` int(11) NOT NULL,
  `fecha_notificacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`idnotificacionmensajes`),
  KEY `id_remitente` (`id_remitente`),
  KEY `id_receptor` (`id_receptor`),
  KEY `id_mensaje` (`id_mensaje`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacionreacciones`
--

CREATE TABLE IF NOT EXISTS `notificacionreacciones` (
  `idnotificacionreacciones` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `idpublicacion` int(11) NOT NULL,
  `fecha_notificacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`idnotificacionreacciones`),
  KEY `id` (`id`),
  KEY `idpublicacion` (`idpublicacion`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notificacionreacciones`
--

INSERT INTO `notificacionreacciones` (`idnotificacionreacciones`, `id`, `idpublicacion`, `fecha_notificacion`) VALUES
(1, 2, 3, '2026-05-29 21:42:54'),
(2, 2, 2, '2026-05-29 21:44:53'),
(3, 9, 8, '2026-06-02 16:03:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicaciones`
--

CREATE TABLE IF NOT EXISTS `publicaciones` (
  `idpublicacion` int(11) NOT NULL AUTO_INCREMENT,
  `mensaje_publicacion` varchar(150) NOT NULL,
  `foto_publicacion` varchar(1500) NOT NULL,
  `fecha_publicacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `megusta` int(11) NOT NULL DEFAULT 0,
  `id` int(11) NOT NULL,
  `fondo_gradiente` varchar(255) DEFAULT NULL,
  `sentimiento` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idpublicacion`),
  KEY `publicaciones_ibfk_1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `publicaciones`
--

INSERT INTO `publicaciones` (`idpublicacion`, `mensaje_publicacion`, `foto_publicacion`, `fecha_publicacion`, `megusta`, `id`, `fondo_gradiente`, `sentimiento`) VALUES
(1, 'Actualizó su foto del perfil.', 'PngItem_3555159.png', '2021-02-08 21:04:23', 1, 1, NULL, NULL),
(2, 'Actualizó su foto de portada.', 'cgi-wallpaper-hd-1080p-209621.jpg', '2021-02-08 21:04:23', 1, 1, NULL, NULL),
(3, 'Gracias por obtener este repositorio. Te adjuntó una publicación técnica necesaria con el desglose de información de como está compuesto este proyecto', 'publicacionsistema.png', '2021-02-08 21:17:04', 1, 1, NULL, NULL),
(4, 'Actualizó su foto del perfil.', 'pngegg.png', '2021-02-08 21:50:38', 1, 2, NULL, NULL),
(6, '', '1779827695_Banco-Azul-Clásica-Visa-Reverso.png', '2026-05-26 20:34:55', 0, 2, NULL, NULL),
(7, '', '1779828778_Interac-reverso.png', '2026-05-26 20:52:58', 1, 2, NULL, NULL),
(8, 'PRUEBA DE MULTIPLES', 'story_6a1efeaeca9662.36393150_5350.png,story_6a1efeaecab864.73335649_6163.png,story_6a1efeaecac7e0.90478492_8687.png,story_6a1efeaecad5e8.21119725_4098.png', '2026-06-02 16:02:54', 1, 9, NULL, NULL),
(9, 'LOREM', 'story_6a2045a8a07014.17281416_4234.png,story_6a2045a8a08c88.35573558_2066.png,story_6a2045a8a09ee8.08749107_8156.png,story_6a2045a8a0ad24.27314314_7945.png', '2026-06-03 15:18:00', 0, 1, 'post-gradient-neon', '😎 feliz'),
(10, 'PRUEBA', 'story_6a2045c9b1f4a5.86485611_6570.png,story_6a2045c9b22402.43343681_2244.png,story_6a2045c9b234c5.33888262_6412.png,story_6a2045c9b24278.13108098_8517.png', '2026-06-03 15:18:33', 0, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicacion_imagenes`
--

CREATE TABLE IF NOT EXISTS `publicacion_imagenes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idpublicacion` int(11) NOT NULL,
  `foto_publicacion` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idpublicacion` (`idpublicacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reacciones`
--

CREATE TABLE IF NOT EXISTS `reacciones` (
  `idreacciones` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `id` int(11) NOT NULL,
  `idpublicacion` int(11) NOT NULL,
  `tipo_reaccion` int(11) DEFAULT 1,
  PRIMARY KEY (`idreacciones`),
  KEY `idpublicacion` (`idpublicacion`),
  KEY `reacciones_ibfk_1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reacciones`
--

INSERT INTO `reacciones` (`idreacciones`, `fecha`, `id`, `idpublicacion`, `tipo_reaccion`) VALUES
(1, '2021-02-08 21:53:36', 1, 4, 1),
(2, '2021-02-08 21:54:34', 2, 1, 1),
(5, '2026-05-26 21:44:34', 2, 7, 2),
(23, '2026-05-29 15:05:15', 1, 7, 3),
(25, '2026-05-29 21:42:54', 2, 3, 1),
(26, '2026-05-29 21:44:53', 2, 2, 1),
(27, '2026-06-02 16:03:40', 9, 8, 5);

--
-- Disparadores `reacciones`
--
DELIMITER $$
CREATE TRIGGER `ActualizacionReaccionMeGusta` AFTER INSERT ON `reacciones` FOR EACH ROW UPDATE publicaciones SET megusta = megusta + 1 WHERE idpublicacion=new.idpublicacion
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `ActualizacionReaccionMeGustaDelete` AFTER DELETE ON `reacciones` FOR EACH ROW UPDATE publicaciones SET megusta = GREATEST(0, megusta - 1) WHERE idpublicacion=old.idpublicacion
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `DecrementoReaccionMeGusta` AFTER DELETE ON `reacciones` FOR EACH ROW UPDATE publicaciones SET megusta = megusta - 1 WHERE idpublicacion=old.idpublicacion
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `EliminarNotificacionesReacciones` AFTER DELETE ON `reacciones` FOR EACH ROW DELETE FROM notificacionreacciones WHERE idpublicacion=old.idpublicacion AND id=old.id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `RegistrarNotificacionesReacciones` AFTER INSERT ON `reacciones` FOR EACH ROW INSERT INTO notificacionreacciones (id, idpublicacion, fecha_notificacion) VALUES(new.id, new.idpublicacion, CURRENT_TIMESTAMP)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reels`
--

CREATE TABLE IF NOT EXISTS `reels` (
  `idvideos` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `video` varchar(255) NOT NULL,
  `titulo_video` varchar(255) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`idvideos`),
  KEY `idx_usuario_reels` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reels_likes`
--

CREATE TABLE IF NOT EXISTS `reels_likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `reel_id` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user_reel` (`usuario_id`,`reel_id`),
  KEY `idx_reel` (`reel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sesiones_activas`
--

CREATE TABLE IF NOT EXISTS `sesiones_activas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `session_id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `ultimo_acceso` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_usuario` (`usuario_id`),
  KEY `idx_session` (`session_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sesiones_activas`
--

INSERT INTO `sesiones_activas` (`id`, `usuario_id`, `session_id`, `ip_address`, `user_agent`, `ultimo_acceso`) VALUES
(11, 10, 'aoh98fs2c96t9s4la0v7h2st1v', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-03 15:53:28'),
(12, 2, 'qmq6nsfa5c8a5c1ja02pl0iifa', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0', '2026-06-03 16:21:12'),
(13, 11, 'nb7cro1o3t4spghb5vl40saiga', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-03 16:15:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudamistad`
--

CREATE TABLE IF NOT EXISTS `solicitudamistad` (
  `idsolicitudamistad` int(11) NOT NULL AUTO_INCREMENT,
  `idsolicitudamigo` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `estado` int(11) DEFAULT 0,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`idsolicitudamistad`),
  UNIQUE KEY `id` (`id`,`idsolicitudamigo`),
  KEY `solicitudamistad_ibfk_2` (`idsolicitudamigo`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitudamistad`
--

INSERT INTO `solicitudamistad` (`idsolicitudamistad`, `idsolicitudamigo`, `id`, `estado`, `fecha_creacion`) VALUES
(4, 1, 2, 1, '2026-06-03 16:02:21'),
(5, 2, 1, 1, '2026-06-03 16:02:21'),
(8, 1, 9, 1, '2026-06-03 16:02:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `usuario` varchar(255) DEFAULT NULL,
  `correo` varchar(255) NOT NULL,
  `contrasenia` varchar(255) DEFAULT NULL,
  `fotoperfil` varchar(255) DEFAULT 'usuarioblanco.png',
  `foto_portada` varchar(255) DEFAULT 'img-ciudadpredeterminada.jpg',
  `pais` varchar(255) NOT NULL,
  `ciudad` varchar(255) NOT NULL,
  `telefono` varchar(100) NOT NULL,
  `genero` char(1) NOT NULL,
  `fechanacimiento` date DEFAULT NULL,
  `privacidad` tinyint(1) NOT NULL DEFAULT 0,
  `completarperfil` tinyint(1) NOT NULL DEFAULT 1,
  `estado_usuario` varchar(40) NOT NULL DEFAULT 'activo',
  `token_recuperacion` varchar(255) DEFAULT NULL,
  `fecha_token` datetime DEFAULT NULL,
  `ultima_conexion` timestamp NULL DEFAULT NULL,
  `typing_to` int(11) DEFAULT 0,
  `codigo_recuperacion` varchar(255) DEFAULT NULL,
  `fecha_codigo` datetime DEFAULT NULL,
  `ultimo_ip` varchar(45) DEFAULT NULL,
  `ultimo_user_agent` varchar(255) DEFAULT NULL,
  `id_sesion_activa` varchar(255) DEFAULT NULL,
  `token_cierre_sesion` varchar(64) DEFAULT NULL,
  `fecha_token_cierre` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `correo` (`correo`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombres`, `apellidos`, `usuario`, `correo`, `contrasenia`, `fotoperfil`, `foto_portada`, `pais`, `ciudad`, `telefono`, `genero`, `fechanacimiento`, `privacidad`, `completarperfil`, `estado_usuario`, `token_recuperacion`, `fecha_token`, `ultima_conexion`, `typing_to`, `codigo_recuperacion`, `fecha_codigo`, `ultimo_ip`, `ultimo_user_agent`, `id_sesion_activa`, `token_cierre_sesion`, `fecha_token_cierre`) VALUES
(1, 'Daniel', 'Rivera', 'Elmismisimos', 'dan@gmail.com', '07GbbbLLK8zBI', 'PngItem_3555159.png', 'cgi-wallpaper-hd-1080p-209621.jpg', 'El Salvador', 'San Salvador', '+50322334455', 'm', '2003-03-28', 0, 0, 'activo', NULL, NULL, '2026-06-03 16:22:24', 0, '$2y$10$W7RasJI3AYNK5Rc.o9s1zeWiVlPtEBaklZw2KDvxVHr.i6vlz7N1q', '2026-06-01 15:45:15', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0', '7ud2lh6693lasr479trmufnoav', NULL, NULL),
(2, 'Olivo', 'Oliva', 'olivapopeye', 'oliva@gmail.com', '2amd2u6R8VO3w', 'pngegg.png', 'img-ciudadpredeterminada.jpg', 'El Salvador', 'San Salvador', '+50322334411', 'f', '1985-02-09', 0, 0, 'activo', NULL, NULL, '2026-06-03 16:20:45', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Javier', 'Pineda', NULL, 'correo1@gmail.com', '2amd2u6R8VO3w', 'usuarioblanco.png', 'img-ciudadpredeterminada.jpg', '', '', '', '', NULL, 0, 1, 'activo', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'Daniel', 'Martinez', 'danielr03', 'correo2@gmail.com', 'cbdRM27XG/nfk', 'usuarioblanco.png', 'img-ciudadpredeterminada.jpg', 'El Salvador', 'San Salvador', '22334455', 'm', '2008-12-03', 0, 0, 'activo', NULL, NULL, '2026-06-02 17:07:09', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'Test', 'User', NULL, 'test_verification@example.com', 'cbg8tn3SVszY2', 'usuarioblanco.png', 'img-ciudadpredeterminada.jpg', '', '', '', '', NULL, 0, 1, 'activo', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Disparadores `usuarios`
--
DELIMITER $$
CREATE TRIGGER `NuevaFotoPerfil-Portada` AFTER UPDATE ON `usuarios` FOR EACH ROW IF old.fotoperfil <> new.fotoperfil THEN
INSERT INTO publicaciones (mensaje_publicacion,foto_publicacion,id) VALUES("Actualizó su foto del perfil.",new.fotoperfil,new.id);
IF old.foto_portada <> new.foto_portada THEN
INSERT INTO publicaciones (mensaje_publicacion,foto_publicacion,id) VALUES("Actualizó su foto de portada.",new.foto_portada,new.id);
ELSE
IF old.fotoperfil = new.fotoperfil THEN
INSERT INTO publicaciones (mensaje_publicacion,foto_publicacion,id) VALUES("Actualizó su foto de portada.",new.foto_portada,new.id);
IF old.foto_portada = new.foto_portada THEN
INSERT INTO publicaciones (mensaje_publicacion,foto_publicacion,id) VALUES("Actualizó su foto del perfil.",new.fotoperfil,new.id);
END IF;
END IF;
END IF;
END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videos`
--

CREATE TABLE IF NOT EXISTS `videos` (
  `idvideos` int(11) NOT NULL AUTO_INCREMENT,
  `titulo_video` varchar(40) NOT NULL,
  `video` varchar(500) DEFAULT NULL,
  `fechasubida` timestamp NOT NULL DEFAULT current_timestamp(),
  `id` int(11) NOT NULL,
  `es_reel` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`idvideos`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `videos`
--

INSERT INTO `videos` (`idvideos`, `titulo_video`, `video`, `fechasubida`, `id`, `es_reel`) VALUES
(6, 'Diablo - 666', 'https://audio-ssl.itunes.apple.com/itunes-assets/AudioPreview221/v4/57/6d/94/576d9467-0a68-2ef3-e041-5b04533a02d1/mzaf_15903176288875668520.plus.aac.p.m4a', '2026-05-29 20:59:23', 1, 0),
(7, 'Bla Bla Bla - Gigi D\'Agostino', 'https://audio-ssl.itunes.apple.com/itunes-assets/AudioPreview125/v4/3c/20/82/3c2082ae-3a18-e297-2468-b7571b9ef656/mzaf_18343138275219530704.plus.aac.p.m4a|https://is1-ssl.mzstatic.com/image/thumb/Features/9a/20/15/dj.erfgjfvf.jpg/300x300bb.jpg', '2026-05-29 21:28:17', 2, 0),
(9, 'TIK', 'reel_1780338740_6168.mp4', '2026-06-01 18:32:20', 1, 1);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_amigosconfirmados`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `vista_amigosconfirmados` (
`idamigo` int(11)
,`id` int(11)
,`idsolicitudamigo` int(11)
,`nombres` varchar(255)
,`apellidos` varchar(255)
,`fotoperfil` varchar(255)
,`foto_portada` varchar(255)
,`pais` varchar(255)
,`usuario` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_amigosconfirmadosminiaturas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `vista_amigosconfirmadosminiaturas` (
`id` int(11)
,`idsolicitudamigo` int(11)
,`nombres` varchar(255)
,`apellidos` varchar(255)
,`fotoperfil` varchar(255)
,`usuario` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_comentariosperfilpropietario`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `vista_comentariosperfilpropietario` (
`nombres` varchar(255)
,`apellidos` varchar(255)
,`usuario` varchar(255)
,`fotoperfil` varchar(255)
,`idcomenterio` int(11)
,`comentario` varchar(255)
,`fechacomentario` timestamp
,`id` int(11)
,`idpublicacion` int(11)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_contadorpublicacionespropietarios`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `vista_contadorpublicacionespropietarios` (
`idpublicacion` int(11)
,`mensaje_publicacion` varchar(150)
,`foto_publicacion` varchar(1500)
,`fecha_publicacion` timestamp
,`id` int(11)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_cumpleanerodiaahora`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `vista_cumpleanerodiaahora` (
`id` int(11)
,`idsolicitudamigo` int(11)
,`nombres` varchar(255)
,`apellidos` varchar(255)
,`fotoperfil` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_detallesusuarioscompleta`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `vista_detallesusuarioscompleta` (
`id` int(11)
,`religion` varchar(100)
,`empleo` varchar(255)
,`escuela` varchar(255)
,`universidad` varchar(255)
,`deportes` varchar(255)
,`intereses` varchar(100)
,`generosmusicales` varchar(255)
,`situacionsentimental` varchar(255)
,`sobremi` varchar(100)
,`nombres` varchar(255)
,`apellidos` varchar(255)
,`usuario` varchar(255)
,`correo` varchar(255)
,`fotoperfil` varchar(255)
,`foto_portada` varchar(255)
,`pais` varchar(255)
,`ciudad` varchar(255)
,`telefono` varchar(100)
,`fechanacimiento` date
,`privacidad` tinyint(1)
,`genero` char(1)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_eventosregistradoscompleta`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `vista_eventosregistradoscompleta` (
`ideventos` int(11)
,`nombre` varchar(255)
,`descripcion` varchar(255)
,`direccion` varchar(255)
,`usuario` varchar(255)
,`pais` varchar(255)
,`fechainicio` datetime
,`fechafin` datetime
,`fotoevento` varchar(255)
,`id` int(11)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_fotossubidascompletaperfilespropietarios`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `vista_fotossubidascompletaperfilespropietarios` (
`idpublicacion` int(11)
,`foto_publicacion` varchar(1500)
,`fecha_publicacion` timestamp
,`id` int(11)
,`fotoperfil` varchar(255)
,`usuario` varchar(255)
,`nombres` varchar(255)
,`apellidos` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_fotossubidasperfilespropietarios`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `vista_fotossubidasperfilespropietarios` (
`idpublicacion` int(11)
,`foto_publicacion` varchar(1500)
,`fecha_publicacion` timestamp
,`id` int(11)
,`fotoperfil` varchar(255)
,`usuario` varchar(255)
,`nombres` varchar(255)
,`apellidos` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_listadoexploraramigos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `vista_listadoexploraramigos` (
`id` int(11)
,`nombres` varchar(255)
,`apellidos` varchar(255)
,`usuario` varchar(255)
,`fotoperfil` varchar(255)
,`foto_portada` varchar(255)
,`pais` varchar(255)
,`ciudad` varchar(255)
,`completarperfil` tinyint(1)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_mensajeriarecibidausuarios`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `vista_mensajeriarecibidausuarios` (
`idmensaje` int(11)
,`id` int(11)
,`mensaje` varchar(1000)
,`fechamensaje` timestamp
,`estado` int(11)
,`nombres` varchar(255)
,`apellidos` varchar(255)
,`fotoperfil` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_notificacionesamigos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `vista_notificacionesamigos` (
`idnotificacionamigos` int(11)
,`idamigo` int(11)
,`fecha_notificacion` timestamp
,`id` int(11)
,`nombres` varchar(255)
,`apellidos` varchar(255)
,`fotoperfil` varchar(255)
,`usuario` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_notificacionescomentarios`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `vista_notificacionescomentarios` (
`id` int(11)
,`idnotificacioncomentarios` int(11)
,`idpublicacion` int(11)
,`fecha_notificacion` timestamp
,`nombres` varchar(255)
,`apellidos` varchar(255)
,`fotoperfil` varchar(255)
,`usuario` varchar(255)
,`foto_publicacion` varchar(1500)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_notificacionesmensajes`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `vista_notificacionesmensajes` (
`id` int(11)
,`idnotificacionmensajes` int(11)
,`id_mensaje` int(11)
,`fecha_notificacion` timestamp
,`id_remitente` int(11)
,`nombres` varchar(255)
,`apellidos` varchar(255)
,`fotoperfil` varchar(255)
,`usuario` varchar(255)
,`mensaje` text
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_notificacionesreacciones`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `vista_notificacionesreacciones` (
`id` int(11)
,`idnotificacionreacciones` int(11)
,`idpublicacion` int(11)
,`fecha_notificacion` timestamp
,`id_reaccionador` int(11)
,`nombres` varchar(255)
,`apellidos` varchar(255)
,`fotoperfil` varchar(255)
,`usuario` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_publicacionesinicio`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `vista_publicacionesinicio` (
`id` int(11)
,`idsolicitudamigo` int(11)
,`nombres` varchar(255)
,`apellidos` varchar(255)
,`usuario` varchar(255)
,`fotoperfil` varchar(255)
,`mensaje_publicacion` varchar(150)
,`foto_publicacion` varchar(1500)
,`idpublicacion` int(11)
,`fecha_publicacion` timestamp
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_publicacionesperfilusuarios`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `vista_publicacionesperfilusuarios` (
`idpublicacion` int(11)
,`mensaje_publicacion` varchar(150)
,`foto_publicacion` varchar(1500)
,`fecha_publicacion` timestamp
,`id` int(11)
,`fotoperfil` varchar(255)
,`usuario` varchar(255)
,`nombres` varchar(255)
,`apellidos` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_solicitudesamistad`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `vista_solicitudesamistad` (
`idsolicitudamistad` int(11)
,`id` int(11)
,`idsolicitudamigo` int(11)
,`estado` int(11)
,`fecha_creacion` timestamp
,`nombres` varchar(255)
,`apellidos` varchar(255)
,`fotoperfil` varchar(255)
,`usuario` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_usuarioscompleta`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `vista_usuarioscompleta` (
`nombres` varchar(255)
,`apellidos` varchar(255)
,`usuario` varchar(255)
,`correo` varchar(255)
,`contrasenia` varchar(255)
,`fotoperfil` varchar(255)
,`foto_portada` varchar(255)
,`pais` varchar(255)
,`ciudad` varchar(255)
,`telefono` varchar(100)
,`genero` char(1)
,`fechanacimiento` date
,`privacidad` tinyint(1)
,`completarperfil` tinyint(1)
,`estado_usuario` varchar(40)
,`iddetalle` int(11)
,`religion` varchar(100)
,`empleo` varchar(255)
,`escuela` varchar(255)
,`universidad` varchar(255)
,`deportes` varchar(255)
,`intereses` varchar(100)
,`generosmusicales` varchar(255)
,`situacionsentimental` varchar(255)
,`comprobacionperfil` tinyint(1)
,`sobremi` varchar(100)
,`id` int(11)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_videosmusicalessubidos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE IF NOT EXISTS `vista_videosmusicalessubidos` (
`idvideos` int(11)
,`id` int(11)
,`nombres` varchar(255)
,`apellidos` varchar(255)
,`usuario` varchar(255)
,`titulo_video` varchar(40)
,`video` varchar(500)
,`fechasubida` timestamp
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_amigosconfirmados`
--
DROP TABLE IF EXISTS `vista_amigosconfirmados`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_amigosconfirmados`  AS SELECT `amigos`.`idamigo` AS `idamigo`, `amigos`.`id` AS `id`, `amigos`.`idsolicitudamigo` AS `idsolicitudamigo`, `usuarios`.`nombres` AS `nombres`, `usuarios`.`apellidos` AS `apellidos`, `usuarios`.`fotoperfil` AS `fotoperfil`, `usuarios`.`foto_portada` AS `foto_portada`, `usuarios`.`pais` AS `pais`, `usuarios`.`usuario` AS `usuario` FROM (`amigos` join `usuarios` on(`amigos`.`idsolicitudamigo` = `usuarios`.`id`)) WHERE `amigos`.`idsolicitudamigo` <> 0 ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_amigosconfirmadosminiaturas`
--
DROP TABLE IF EXISTS `vista_amigosconfirmadosminiaturas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_amigosconfirmadosminiaturas`  AS SELECT `amigos`.`id` AS `id`, `amigos`.`idsolicitudamigo` AS `idsolicitudamigo`, `usuarios`.`nombres` AS `nombres`, `usuarios`.`apellidos` AS `apellidos`, `usuarios`.`fotoperfil` AS `fotoperfil`, `usuarios`.`usuario` AS `usuario` FROM (`amigos` join `usuarios` on(`amigos`.`idsolicitudamigo` = `usuarios`.`id`)) WHERE `amigos`.`idsolicitudamigo` <> 0 LIMIT 0, 10 ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_comentariosperfilpropietario`
--
DROP TABLE IF EXISTS `vista_comentariosperfilpropietario`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_comentariosperfilpropietario`  AS SELECT `usuarios`.`nombres` AS `nombres`, `usuarios`.`apellidos` AS `apellidos`, `usuarios`.`usuario` AS `usuario`, `usuarios`.`fotoperfil` AS `fotoperfil`, `comentarios`.`idcomenterio` AS `idcomenterio`, `comentarios`.`comentario` AS `comentario`, `comentarios`.`fechacomentario` AS `fechacomentario`, `comentarios`.`id` AS `id`, `comentarios`.`idpublicacion` AS `idpublicacion` FROM (`comentarios` join `usuarios` on(`comentarios`.`id` = `usuarios`.`id`)) WHERE `comentarios`.`idpublicacion` <> 0 ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_contadorpublicacionespropietarios`
--
DROP TABLE IF EXISTS `vista_contadorpublicacionespropietarios`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_contadorpublicacionespropietarios`  AS SELECT `publicaciones`.`idpublicacion` AS `idpublicacion`, `publicaciones`.`mensaje_publicacion` AS `mensaje_publicacion`, `publicaciones`.`foto_publicacion` AS `foto_publicacion`, `publicaciones`.`fecha_publicacion` AS `fecha_publicacion`, `publicaciones`.`id` AS `id` FROM `publicaciones` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_cumpleanerodiaahora`
--
DROP TABLE IF EXISTS `vista_cumpleanerodiaahora`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_cumpleanerodiaahora`  AS SELECT `amigos`.`id` AS `id`, `amigos`.`idsolicitudamigo` AS `idsolicitudamigo`, `usuarios`.`nombres` AS `nombres`, `usuarios`.`apellidos` AS `apellidos`, `usuarios`.`fotoperfil` AS `fotoperfil` FROM (`amigos` join `usuarios` on(`amigos`.`idsolicitudamigo` = `usuarios`.`id`)) WHERE `amigos`.`idsolicitudamigo` <> 0 AND dayofmonth(`usuarios`.`fechanacimiento`) = dayofmonth(current_timestamp()) AND month(`usuarios`.`fechanacimiento`) = month(current_timestamp()) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_detallesusuarioscompleta`
--
DROP TABLE IF EXISTS `vista_detallesusuarioscompleta`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_detallesusuarioscompleta`  AS SELECT `usuarios`.`id` AS `id`, `detalleusuarios`.`religion` AS `religion`, `detalleusuarios`.`empleo` AS `empleo`, `detalleusuarios`.`escuela` AS `escuela`, `detalleusuarios`.`universidad` AS `universidad`, `detalleusuarios`.`deportes` AS `deportes`, `detalleusuarios`.`intereses` AS `intereses`, `detalleusuarios`.`generosmusicales` AS `generosmusicales`, `detalleusuarios`.`situacionsentimental` AS `situacionsentimental`, `detalleusuarios`.`sobremi` AS `sobremi`, `usuarios`.`nombres` AS `nombres`, `usuarios`.`apellidos` AS `apellidos`, `usuarios`.`usuario` AS `usuario`, `usuarios`.`correo` AS `correo`, `usuarios`.`fotoperfil` AS `fotoperfil`, `usuarios`.`foto_portada` AS `foto_portada`, `usuarios`.`pais` AS `pais`, `usuarios`.`ciudad` AS `ciudad`, `usuarios`.`telefono` AS `telefono`, `usuarios`.`fechanacimiento` AS `fechanacimiento`, `usuarios`.`privacidad` AS `privacidad`, `usuarios`.`genero` AS `genero` FROM (`detalleusuarios` left join `usuarios` on(`detalleusuarios`.`id` = `usuarios`.`id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_eventosregistradoscompleta`
--
DROP TABLE IF EXISTS `vista_eventosregistradoscompleta`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_eventosregistradoscompleta`  AS SELECT `eventos`.`ideventos` AS `ideventos`, `eventos`.`nombre` AS `nombre`, `eventos`.`descripcion` AS `descripcion`, `eventos`.`direccion` AS `direccion`, `eventos`.`usuario` AS `usuario`, `eventos`.`pais` AS `pais`, `eventos`.`fechainicio` AS `fechainicio`, `eventos`.`fechafin` AS `fechafin`, `eventos`.`fotoevento` AS `fotoevento`, `eventos`.`id` AS `id` FROM `eventos` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_fotossubidascompletaperfilespropietarios`
--
DROP TABLE IF EXISTS `vista_fotossubidascompletaperfilespropietarios`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_fotossubidascompletaperfilespropietarios`  AS SELECT `publicaciones`.`idpublicacion` AS `idpublicacion`, `publicaciones`.`foto_publicacion` AS `foto_publicacion`, `publicaciones`.`fecha_publicacion` AS `fecha_publicacion`, `publicaciones`.`id` AS `id`, `usuarios`.`fotoperfil` AS `fotoperfil`, `usuarios`.`usuario` AS `usuario`, `usuarios`.`nombres` AS `nombres`, `usuarios`.`apellidos` AS `apellidos` FROM (`publicaciones` left join `usuarios` on(`publicaciones`.`id` = `usuarios`.`id`)) ORDER BY `publicaciones`.`fecha_publicacion` DESC ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_fotossubidasperfilespropietarios`
--
DROP TABLE IF EXISTS `vista_fotossubidasperfilespropietarios`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_fotossubidasperfilespropietarios`  AS SELECT `publicaciones`.`idpublicacion` AS `idpublicacion`, `publicaciones`.`foto_publicacion` AS `foto_publicacion`, `publicaciones`.`fecha_publicacion` AS `fecha_publicacion`, `publicaciones`.`id` AS `id`, `usuarios`.`fotoperfil` AS `fotoperfil`, `usuarios`.`usuario` AS `usuario`, `usuarios`.`nombres` AS `nombres`, `usuarios`.`apellidos` AS `apellidos` FROM (`publicaciones` left join `usuarios` on(`publicaciones`.`id` = `usuarios`.`id`)) ORDER BY `publicaciones`.`fecha_publicacion` DESC LIMIT 0, 10 ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_listadoexploraramigos`
--
DROP TABLE IF EXISTS `vista_listadoexploraramigos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_listadoexploraramigos`  AS SELECT `usuarios`.`id` AS `id`, `usuarios`.`nombres` AS `nombres`, `usuarios`.`apellidos` AS `apellidos`, `usuarios`.`usuario` AS `usuario`, `usuarios`.`fotoperfil` AS `fotoperfil`, `usuarios`.`foto_portada` AS `foto_portada`, `usuarios`.`pais` AS `pais`, `usuarios`.`ciudad` AS `ciudad`, `usuarios`.`completarperfil` AS `completarperfil` FROM `usuarios` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_mensajeriarecibidausuarios`
--
DROP TABLE IF EXISTS `vista_mensajeriarecibidausuarios`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_mensajeriarecibidausuarios`  AS SELECT `mensajeria`.`idmensaje` AS `idmensaje`, `mensajeria`.`id` AS `id`, `mensajeria`.`mensaje` AS `mensaje`, `mensajeria`.`fechamensaje` AS `fechamensaje`, `mensajeria`.`estado` AS `estado`, `usuarios`.`nombres` AS `nombres`, `usuarios`.`apellidos` AS `apellidos`, `usuarios`.`fotoperfil` AS `fotoperfil` FROM (`mensajeria` join `usuarios` on(`mensajeria`.`id` = `usuarios`.`id`)) WHERE `mensajeria`.`id` <> 0 ORDER BY `mensajeria`.`fechamensaje` ASC ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_notificacionesamigos`
--
DROP TABLE IF EXISTS `vista_notificacionesamigos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_notificacionesamigos`  AS SELECT `na`.`idnotificacionamigos` AS `idnotificacionamigos`, `na`.`idamigo` AS `idamigo`, `na`.`fecha_notificacion` AS `fecha_notificacion`, `na`.`id` AS `id`, `u`.`nombres` AS `nombres`, `u`.`apellidos` AS `apellidos`, `u`.`fotoperfil` AS `fotoperfil`, `u`.`usuario` AS `usuario` FROM (`notificacionamigos` `na` join `usuarios` `u` on(`na`.`idsolicitudamigo` = `u`.`id`)) WHERE `na`.`idsolicitudamigo` <> 0 ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_notificacionescomentarios`
--
DROP TABLE IF EXISTS `vista_notificacionescomentarios`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_notificacionescomentarios`  AS SELECT `publicaciones`.`id` AS `id`, `notificacioncomentarios`.`idnotificacioncomentarios` AS `idnotificacioncomentarios`, `notificacioncomentarios`.`idpublicacion` AS `idpublicacion`, `notificacioncomentarios`.`fecha_notificacion` AS `fecha_notificacion`, `usuarios`.`nombres` AS `nombres`, `usuarios`.`apellidos` AS `apellidos`, `usuarios`.`fotoperfil` AS `fotoperfil`, `usuarios`.`usuario` AS `usuario`, `publicaciones`.`foto_publicacion` AS `foto_publicacion` FROM ((`notificacioncomentarios` join `usuarios` on(`notificacioncomentarios`.`id` = `usuarios`.`id`)) join `publicaciones` on(`notificacioncomentarios`.`idpublicacion` = `publicaciones`.`idpublicacion`)) WHERE `notificacioncomentarios`.`idpublicacion` <> 0 ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_notificacionesmensajes`
--
DROP TABLE IF EXISTS `vista_notificacionesmensajes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_notificacionesmensajes`  AS SELECT `notificacionmensajes`.`id_receptor` AS `id`, `notificacionmensajes`.`idnotificacionmensajes` AS `idnotificacionmensajes`, `notificacionmensajes`.`id_mensaje` AS `id_mensaje`, `notificacionmensajes`.`fecha_notificacion` AS `fecha_notificacion`, `usuarios`.`id` AS `id_remitente`, `usuarios`.`nombres` AS `nombres`, `usuarios`.`apellidos` AS `apellidos`, `usuarios`.`fotoperfil` AS `fotoperfil`, `usuarios`.`usuario` AS `usuario`, `chat_mensajes`.`mensaje` AS `mensaje` FROM ((`notificacionmensajes` join `usuarios` on(`notificacionmensajes`.`id_remitente` = `usuarios`.`id`)) join `chat_mensajes` on(`notificacionmensajes`.`id_mensaje` = `chat_mensajes`.`id`)) WHERE `notificacionmensajes`.`id_receptor` <> 0 ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_notificacionesreacciones`
--
DROP TABLE IF EXISTS `vista_notificacionesreacciones`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_notificacionesreacciones`  AS SELECT `publicaciones`.`id` AS `id`, `notificacionreacciones`.`idnotificacionreacciones` AS `idnotificacionreacciones`, `notificacionreacciones`.`idpublicacion` AS `idpublicacion`, `notificacionreacciones`.`fecha_notificacion` AS `fecha_notificacion`, `usuarios`.`id` AS `id_reaccionador`, `usuarios`.`nombres` AS `nombres`, `usuarios`.`apellidos` AS `apellidos`, `usuarios`.`fotoperfil` AS `fotoperfil`, `usuarios`.`usuario` AS `usuario` FROM ((`notificacionreacciones` join `usuarios` on(`notificacionreacciones`.`id` = `usuarios`.`id`)) join `publicaciones` on(`notificacionreacciones`.`idpublicacion` = `publicaciones`.`idpublicacion`)) WHERE `notificacionreacciones`.`idpublicacion` <> 0 ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_publicacionesinicio`
--
DROP TABLE IF EXISTS `vista_publicacionesinicio`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_publicacionesinicio`  AS SELECT `amigos`.`id` AS `id`, `amigos`.`idsolicitudamigo` AS `idsolicitudamigo`, `usuarios`.`nombres` AS `nombres`, `usuarios`.`apellidos` AS `apellidos`, `usuarios`.`usuario` AS `usuario`, `usuarios`.`fotoperfil` AS `fotoperfil`, `publicaciones`.`mensaje_publicacion` AS `mensaje_publicacion`, `publicaciones`.`foto_publicacion` AS `foto_publicacion`, `publicaciones`.`idpublicacion` AS `idpublicacion`, `publicaciones`.`fecha_publicacion` AS `fecha_publicacion` FROM ((`amigos` join `usuarios` on(`amigos`.`idsolicitudamigo` = `usuarios`.`id`)) join `publicaciones` on(`amigos`.`idsolicitudamigo` = `publicaciones`.`id`)) WHERE `amigos`.`idsolicitudamigo` <> 0 ORDER BY `publicaciones`.`fecha_publicacion` DESC ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_publicacionesperfilusuarios`
--
DROP TABLE IF EXISTS `vista_publicacionesperfilusuarios`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_publicacionesperfilusuarios`  AS SELECT `publicaciones`.`idpublicacion` AS `idpublicacion`, `publicaciones`.`mensaje_publicacion` AS `mensaje_publicacion`, `publicaciones`.`foto_publicacion` AS `foto_publicacion`, `publicaciones`.`fecha_publicacion` AS `fecha_publicacion`, `publicaciones`.`id` AS `id`, `usuarios`.`fotoperfil` AS `fotoperfil`, `usuarios`.`usuario` AS `usuario`, `usuarios`.`nombres` AS `nombres`, `usuarios`.`apellidos` AS `apellidos` FROM (`publicaciones` left join `usuarios` on(`publicaciones`.`id` = `usuarios`.`id`)) ORDER BY `publicaciones`.`fecha_publicacion` DESC ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_solicitudesamistad`
--
DROP TABLE IF EXISTS `vista_solicitudesamistad`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_solicitudesamistad`  AS SELECT `sa`.`idsolicitudamistad` AS `idsolicitudamistad`, `sa`.`id` AS `id`, `sa`.`idsolicitudamigo` AS `idsolicitudamigo`, `sa`.`estado` AS `estado`, `sa`.`fecha_creacion` AS `fecha_creacion`, `u`.`nombres` AS `nombres`, `u`.`apellidos` AS `apellidos`, `u`.`fotoperfil` AS `fotoperfil`, `u`.`usuario` AS `usuario` FROM (`solicitudamistad` `sa` join `usuarios` `u` on(`sa`.`id` = `u`.`id`)) WHERE `sa`.`idsolicitudamigo` <> 0 ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_usuarioscompleta`
--
DROP TABLE IF EXISTS `vista_usuarioscompleta`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_usuarioscompleta`  AS SELECT `usuarios`.`nombres` AS `nombres`, `usuarios`.`apellidos` AS `apellidos`, `usuarios`.`usuario` AS `usuario`, `usuarios`.`correo` AS `correo`, `usuarios`.`contrasenia` AS `contrasenia`, `usuarios`.`fotoperfil` AS `fotoperfil`, `usuarios`.`foto_portada` AS `foto_portada`, `usuarios`.`pais` AS `pais`, `usuarios`.`ciudad` AS `ciudad`, `usuarios`.`telefono` AS `telefono`, `usuarios`.`genero` AS `genero`, `usuarios`.`fechanacimiento` AS `fechanacimiento`, `usuarios`.`privacidad` AS `privacidad`, `usuarios`.`completarperfil` AS `completarperfil`, `usuarios`.`estado_usuario` AS `estado_usuario`, `detalleusuarios`.`iddetalle` AS `iddetalle`, `detalleusuarios`.`religion` AS `religion`, `detalleusuarios`.`empleo` AS `empleo`, `detalleusuarios`.`escuela` AS `escuela`, `detalleusuarios`.`universidad` AS `universidad`, `detalleusuarios`.`deportes` AS `deportes`, `detalleusuarios`.`intereses` AS `intereses`, `detalleusuarios`.`generosmusicales` AS `generosmusicales`, `detalleusuarios`.`situacionsentimental` AS `situacionsentimental`, `detalleusuarios`.`comprobacionperfil` AS `comprobacionperfil`, `detalleusuarios`.`sobremi` AS `sobremi`, `detalleusuarios`.`id` AS `id` FROM (`usuarios` left join `detalleusuarios` on(`usuarios`.`id` = `detalleusuarios`.`id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_videosmusicalessubidos`
--
DROP TABLE IF EXISTS `vista_videosmusicalessubidos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_videosmusicalessubidos`  AS SELECT `videos`.`idvideos` AS `idvideos`, `usuarios`.`id` AS `id`, `usuarios`.`nombres` AS `nombres`, `usuarios`.`apellidos` AS `apellidos`, `usuarios`.`usuario` AS `usuario`, `videos`.`titulo_video` AS `titulo_video`, `videos`.`video` AS `video`, `videos`.`fechasubida` AS `fechasubida` FROM (`videos` join `usuarios` on(`usuarios`.`id` = `videos`.`id`)) WHERE `usuarios`.`id` <> 0 ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `amigos`
--
ALTER TABLE `amigos`
  ADD CONSTRAINT `amigos_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `amigos_ibfk_2` FOREIGN KEY (`idsolicitudamigo`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cancelacioncuenta`
--
ALTER TABLE `cancelacioncuenta`
  ADD CONSTRAINT `cancelacioncuenta_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`idpublicacion`) REFERENCES `publicaciones` (`idpublicacion`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalleusuarios`
--
ALTER TABLE `detalleusuarios`
  ADD CONSTRAINT `detalleusuarios_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `eventos_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `historias`
--
ALTER TABLE `historias`
  ADD CONSTRAINT `historias_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `historia_vistas`
--
ALTER TABLE `historia_vistas`
  ADD CONSTRAINT `historia_vistas_ibfk_1` FOREIGN KEY (`id_historia`) REFERENCES `historias` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `historia_vistas_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `mensajeria`
--
ALTER TABLE `mensajeria`
  ADD CONSTRAINT `mensajeria_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `musica_favorita`
--
ALTER TABLE `musica_favorita`
  ADD CONSTRAINT `musica_favorita_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `notas_musica`
--
ALTER TABLE `notas_musica`
  ADD CONSTRAINT `notas_musica_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `notificacionamigos`
--
ALTER TABLE `notificacionamigos`
  ADD CONSTRAINT `notificacionamigos_ibfk_1` FOREIGN KEY (`idamigo`) REFERENCES `amigos` (`idamigo`) ON DELETE CASCADE,
  ADD CONSTRAINT `notificacionamigos_ibfk_2` FOREIGN KEY (`idsolicitudamigo`) REFERENCES `amigos` (`idsolicitudamigo`) ON DELETE CASCADE,
  ADD CONSTRAINT `notificacionamigos_ibfk_3` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `notificacioncomentarios`
--
ALTER TABLE `notificacioncomentarios`
  ADD CONSTRAINT `notificacioncomentarios_ibfk_3` FOREIGN KEY (`idpublicacion`) REFERENCES `publicaciones` (`idpublicacion`) ON DELETE CASCADE,
  ADD CONSTRAINT `notificacioncomentarios_ibfk_4` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `notificacionmensajes`
--
ALTER TABLE `notificacionmensajes`
  ADD CONSTRAINT `notificacionmensajes_ibfk_1` FOREIGN KEY (`id_remitente`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notificacionmensajes_ibfk_2` FOREIGN KEY (`id_receptor`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notificacionmensajes_ibfk_3` FOREIGN KEY (`id_mensaje`) REFERENCES `chat_mensajes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `notificacionreacciones`
--
ALTER TABLE `notificacionreacciones`
  ADD CONSTRAINT `notificacionreacciones_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notificacionreacciones_ibfk_2` FOREIGN KEY (`idpublicacion`) REFERENCES `publicaciones` (`idpublicacion`) ON DELETE CASCADE;

--
-- Filtros para la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD CONSTRAINT `publicaciones_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `publicacion_imagenes`
--
ALTER TABLE `publicacion_imagenes`
  ADD CONSTRAINT `publicacion_imagenes_ibfk_1` FOREIGN KEY (`idpublicacion`) REFERENCES `publicaciones` (`idpublicacion`) ON DELETE CASCADE;

--
-- Filtros para la tabla `reacciones`
--
ALTER TABLE `reacciones`
  ADD CONSTRAINT `reacciones_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reacciones_ibfk_2` FOREIGN KEY (`idpublicacion`) REFERENCES `publicaciones` (`idpublicacion`) ON DELETE CASCADE;

--
-- Filtros para la tabla `solicitudamistad`
--
ALTER TABLE `solicitudamistad`
  ADD CONSTRAINT `solicitudamistad_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `solicitudamistad_ibfk_2` FOREIGN KEY (`idsolicitudamigo`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `videos_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
