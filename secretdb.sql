-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-02-2021 a las 23:24:32
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 8.0.0

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
CREATE DEFINER=`root`@`localhost` PROCEDURE `AceptarSolicitudesNuevosAmigos` (IN `_id` INT, IN `_idsolicitudamigo` INT)  NO SQL
INSERT INTO amigos (id,idsolicitudamigo) VALUES (_id,_idsolicitudamigo)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `BorrarEventosSociales` (IN `_ideventos` INT)  NO SQL
DELETE FROM eventos WHERE ideventos=_ideventos$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `BorrarHistoriasPublicadasPerfilUsuarios` (IN `_idpublicacion` INT)  NO SQL
DELETE FROM publicaciones WHERE idpublicacion=_idpublicacion$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CancelarPerfilUsuarios` (IN `_nombres` VARCHAR(255), IN `_apellidos` VARCHAR(255), IN `_correo` VARCHAR(255), IN `_motivo` VARCHAR(100), IN `_detalle` VARCHAR(150), IN `_id` INT)  NO SQL
BEGIN
INSERT INTO cancelacioncuenta (nombres,apellidos,correo,motivo,detalle,id) VALUES (_nombres,_apellidos,_correo,_motivo,_detalle,_id);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CompletarRegistroNuevosUsuarios` (IN `_id` INT, IN `_nombres` VARCHAR(255), IN `_apellidos` VARCHAR(255), IN `_usuario` VARCHAR(255), IN `_correo` VARCHAR(255), IN `_fotoperfil` VARCHAR(255), IN `_pais` VARCHAR(255), IN `_ciudad` VARCHAR(255), IN `_telefono` VARCHAR(100), IN `_genero` CHAR(1), IN `_fechanacimiento` DATE, IN `_privacidad` TINYINT(1), IN `_completarperfil` TINYINT(1))  NO SQL
BEGIN
	UPDATE usuarios SET nombres = _nombres, apellidos = _apellidos, usuario = _usuario, correo = _correo, fotoperfil = _fotoperfil, pais = _pais, ciudad = _ciudad, telefono = _telefono, genero = _genero, fechanacimiento = _fechanacimiento, privacidad = _privacidad, completarperfil = _completarperfil WHERE id=_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CompletarRegistroNuevosUsuariosSinFoto` (IN `_id` INT, IN `_nombres` VARCHAR(255), IN `_apellidos` VARCHAR(255), IN `_usuario` VARCHAR(255), IN `_correo` VARCHAR(255), IN `_pais` VARCHAR(255), IN `_ciudad` VARCHAR(255), IN `_telefono` VARCHAR(100), IN `_genero` CHAR(1), IN `_fechanacimiento` DATE, IN `_privacidad` TINYINT(1), IN `_completarperfil` TINYINT(1))  NO SQL
BEGIN
	UPDATE usuarios SET nombres = _nombres, apellidos = _apellidos, usuario = _usuario, correo = _correo, pais = _pais, ciudad = _ciudad, telefono = _telefono, genero = _genero, fechanacimiento = _fechanacimiento, privacidad = _privacidad, completarperfil = _completarperfil WHERE id=_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultaNotificacionesAmigosCompleta` (IN `_id` INT)  NO SQL
SELECT * FROM vista_notificacionesamigos WHERE id=_id ORDER BY fecha_notificacion DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultaNotificacionesComentariosCompleta` (IN `_id` INT)  NO SQL
SELECT * FROM vista_notificacionescomentarios WHERE id=_id ORDER BY fecha_notificacion DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarAmigosMiniaturaPerfilesGeneral` (IN `_id` INT)  NO SQL
SELECT * FROM vista_amigosconfirmadosminiaturas WHERE id=_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarAmigosMiniaturaPerfilesPropietarios` (IN `_id` INT)  NO SQL
SELECT * FROM vista_amigosconfirmadosminiaturas WHERE id=_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarAmigosPerfilesGenerales` (IN `_id` VARCHAR(255))  NO SQL
SELECT * FROM vista_amigosconfirmados WHERE id=_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarAmigosPerfilesPropietarios` (IN `_id` INT)  NO SQL
SELECT * FROM vista_amigosconfirmados WHERE id=_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarBuscadorSecret` (IN `_busqueda` VARCHAR(255))  NO SQL
SELECT * FROM usuarios WHERE estado_usuario = 'activo' AND nombres LIKE _busqueda OR apellidos LIKE _busqueda OR usuario LIKE _busqueda$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarComentariosPerfilPropietario` (IN `_idpublicacion` INT)  NO SQL
SELECT * FROM vista_comentariosperfilpropietario WHERE idpublicacion=_idpublicacion ORDER BY fechacomentario DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarCumpleanosEsteDia` (IN `_id` INT)  NO SQL
SELECT * FROM vista_cumpleanerodiaahora WHERE id=_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarDetallesPerfilUsuarios` (IN `_usuario` VARCHAR(255))  NO SQL
SELECT * FROM vista_detallesusuarioscompleta WHERE usuario=_usuario$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarDisponibilidadUsuario` (IN `_usuario` VARCHAR(200))  NO SQL
SELECT * FROM usuarios WHERE usuario=_usuario$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultaReaccionesPublicaciones` (IN `_idpublicacion` INT)  NO SQL
SELECT megusta,id FROM publicaciones WHERE idpublicacion=_idpublicacion$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarEventosRegistrados` (IN `_pais` VARCHAR(255))  NO SQL
SELECT * FROM vista_eventosregistradoscompleta WHERE pais=_pais ORDER BY fechainicio ASC LIMIT 31$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarEventosRegistradosMiniatura` (IN `_pais` VARCHAR(255))  NO SQL
SELECT * FROM vista_eventosregistradoscompleta WHERE pais=_pais ORDER BY fechainicio ASC LIMIT 16$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarExplorarAmigos` ()  NO SQL
SELECT * FROM vista_listadoexploraramigos WHERE completarperfil=0 ORDER by nombres ASC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarFotosSubidasPerfilPropietario` (IN `_usuario` VARCHAR(255))  NO SQL
SELECT * FROM vista_fotossubidasperfilespropietarios WHERE usuario=_usuario$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarMensajesRecibidos` ()  NO SQL
SELECT * FROM vista_mensajeriarecibidausuarios ORDER BY fechamensaje DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarNombresComentarios` (IN `_idpublicacion` INT)  NO SQL
SELECT nombres, apellidos, fechacomentario FROM vista_comentariosperfilpropietario WHERE idpublicacion = _idpublicacion ORDER BY fechacomentario DESC LIMIT 10$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarNotificacionesAmigos` (IN `_id` INT)  NO SQL
SELECT * FROM vista_notificacionesamigos WHERE id=_id ORDER BY fecha_notificacion DESC LIMIT 6$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarPerfilesGeneralPublicaciones` (IN `_usuario` VARCHAR(255))  NO SQL
SELECT * FROM vista_publicacionesperfilusuarios WHERE usuario=_usuario$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarPerfilUsuariosPublicaciones` (IN `_id` INT)  NO SQL
SELECT * FROM vista_publicacionesperfilusuarios WHERE id=_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarPeticionEditarPerfil` (IN `_usuario` VARCHAR(255))  NO SQL
SELECT * FROM vista_usuarioscompleta WHERE usuario=_usuario$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarPublicacionesInicio` (IN `_id` INT)  NO SQL
SELECT * FROM vista_publicacionesinicio WHERE id=_id LIMIT 21$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarVideosMusicalesSubidos` ()  NO SQL
SELECT * FROM vista_videosmusicalessubidos ORDER BY fechasubida DESC LIMIT 61$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarVistaCompletaFotosSubidasPerfilesPropietarios` (IN `_usuario` VARCHAR(255))  NO SQL
SELECT * FROM vista_fotossubidascompletaperfilespropietarios WHERE usuario=_usuario$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultaSolicitudesAmistad` (IN `_idsolicitudamigo` INT)  NO SQL
SELECT * FROM vista_solicitudesamistad WHERE idsolicitudamigo=_idsolicitudamigo LIMIT 7$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultaSolicitudesAmistadCompleta` (IN `_idsolicitudamigo` INT)  NO SQL
SELECT * FROM vista_solicitudesamistad WHERE idsolicitudamigo=_idsolicitudamigo$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ContadorAmigosPerfilPropietario` (IN `_id` INT)  NO SQL
SELECT * FROM vista_amigosconfirmados WHERE id=_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ContadorComentariosPublicaciones` (IN `_idpublicacion` INT)  NO SQL
SELECT * FROM vista_comentariosperfilpropietario WHERE idpublicacion=_idpublicacion$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ContadorNotificacionesAmigos` (IN `_id` INT)  NO SQL
SELECT * FROM vista_notificacionesamigos WHERE id=_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ContadorPublicacionesPerfilesPropietarios` (IN `_id` INT)  NO SQL
SELECT * FROM vista_contadorpublicacionespropietarios WHERE id=_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ContadorSolicitudesAmistad` (IN `_idsolicitudamigo` INT)  NO SQL
SELECT * FROM vista_solicitudesamistad WHERE idsolicitudamigo=_idsolicitudamigo AND estado=0$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EditarPerfilSinFotoPerfil` (IN `_id` INT, IN `_nombres` VARCHAR(255), IN `_apellidos` VARCHAR(255), IN `_usuario` VARCHAR(255), IN `_correo` VARCHAR(255), IN `_contrasenia` VARCHAR(255), IN `_foto_portada` VARCHAR(255), IN `_pais` VARCHAR(255), IN `_ciudad` VARCHAR(255), IN `_telefono` VARCHAR(100), IN `_genero` CHAR(1), IN `_fechanacimiento` DATE, IN `_privacidad` TINYINT(1), IN `_completarperfil` TINYINT(1), IN `_estado_usuario` VARCHAR(40))  NO SQL
BEGIN
	UPDATE usuarios SET nombres = _nombres, apellidos = _apellidos, usuario = _usuario, correo = _correo, contrasenia = _contrasenia, foto_portada = _foto_portada, pais = _pais, ciudad = _ciudad, telefono = _telefono, genero = _genero, fechanacimiento = _fechanacimiento, privacidad = _privacidad, completarperfil = _completarperfil, estado_usuario = _estado_usuario WHERE id=_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EditarPerfilSinFotos` (IN `_id` INT, IN `_nombres` VARCHAR(255), IN `_apellidos` VARCHAR(255), IN `_usuario` VARCHAR(255), IN `_correo` VARCHAR(255), IN `_contrasenia` VARCHAR(255), IN `_pais` VARCHAR(255), IN `_ciudad` VARCHAR(255), IN `_telefono` VARCHAR(100), IN `_genero` CHAR(1), IN `_fechanacimiento` DATE, IN `_privacidad` TINYINT(1), IN `_completarperfil` TINYINT(1), IN `_estado_usuario` VARCHAR(40))  NO SQL
BEGIN
	UPDATE usuarios SET nombres = _nombres, apellidos = _apellidos, usuario = _usuario, correo = _correo, contrasenia = _contrasenia, pais = _pais, ciudad = _ciudad, telefono = _telefono, genero = _genero, fechanacimiento = _fechanacimiento, privacidad = _privacidad, completarperfil = _completarperfil, estado_usuario = _estado_usuario WHERE id=_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EditarPerfilUsuariosConFoto` (IN `_id` INT, IN `_nombres` VARCHAR(255), IN `_apellidos` VARCHAR(255), IN `_usuario` VARCHAR(255), IN `_correo` VARCHAR(255), IN `_contrasenia` VARCHAR(255), IN `_fotoperfil` VARCHAR(255), IN `_fotoportada` VARCHAR(255), IN `_pais` VARCHAR(255), IN `_ciudad` VARCHAR(255), IN `_telefono` VARCHAR(100), IN `_genero` CHAR(1), IN `_fechanacimiento` DATE, IN `_privacidad` TINYINT(1), IN `_completarperfil` TINYINT(1), IN `_estado_usuario` VARCHAR(40))  NO SQL
BEGIN
	UPDATE usuarios SET nombres = _nombres, apellidos = _apellidos, usuario = _usuario, correo = _correo, contrasenia = _contrasenia, fotoperfil = _fotoperfil, foto_portada = _fotoportada, pais = _pais, ciudad = _ciudad, telefono = _telefono, genero = _genero, fechanacimiento = _fechanacimiento, privacidad = _privacidad, completarperfil = _completarperfil, estado_usuario = _estado_usuario WHERE id=_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EditarPerfilUsuariosSinFotoPortada` (IN `_id` INT, IN `_nombres` VARCHAR(255), IN `_apellidos` VARCHAR(255), IN `_usuario` VARCHAR(255), IN `_correo` VARCHAR(255), IN `_contrasenia` VARCHAR(255), IN `_fotoperfil` VARCHAR(255), IN `_pais` VARCHAR(255), IN `_ciudad` VARCHAR(255), IN `_telefono` VARCHAR(100), IN `_genero` CHAR(1), IN `_fechanacimiento` DATE, IN `_privacidad` TINYINT(1), IN `_completarperfil` TINYINT(1), IN `_estado_usuario` VARCHAR(40))  NO SQL
BEGIN
	UPDATE usuarios SET nombres = _nombres, apellidos = _apellidos, usuario = _usuario, correo = _correo, contrasenia = _contrasenia, fotoperfil = _fotoperfil, pais = _pais, ciudad = _ciudad, telefono = _telefono, genero = _genero, fechanacimiento = _fechanacimiento, privacidad = _privacidad, completarperfil = _completarperfil, estado_usuario = _estado_usuario WHERE id=_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarAmigosConfirmados` (IN `_idamigo` INT)  NO SQL
DELETE FROM amigos WHERE idamigo=_idamigo$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarComentariosRegistrados` (IN `_idcomenterio` INT)  NO SQL
DELETE FROM comentarios WHERE idcomenterio=_idcomenterio$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarMensajesChatGeneral` (IN `_id` INT)  NO SQL
DELETE FROM mensajeria WHERE id=_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarMensajesIndividualesChatGeneral` (IN `_idmensaje` INT)  NO SQL
DELETE FROM mensajeria WHERE idmensaje=_idmensaje$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarNotificacionesComentariosRegistrados` (IN `_idnotificacioncomentarios` INT)  NO SQL
DELETE FROM notificacioncomentarios WHERE idnotificacioncomentarios=_idnotificacioncomentarios$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarNotificacionesSolicitudesAceptadas` (IN `_idnotificacionamigos` INT)  NO SQL
DELETE FROM notificacionamigos WHERE idnotificacionamigos=_idnotificacionamigos$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarSolicitudesAmistad` (IN `_idsolicitudamistad` INT)  NO SQL
DELETE FROM solicitudamistad WHERE idsolicitudamistad=_idsolicitudamistad$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarUsuarioRegistrado` (IN `_usuario` VARCHAR(255))  NO SQL
DELETE FROM usuarios WHERE usuario=_usuario$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarVideosMusicales` (IN `_idvideos` INT)  NO SQL
DELETE FROM videos WHERE idvideos=_idvideos$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InicioSesion` (IN `Usuario` VARCHAR(255), IN `Pass` VARCHAR(255))  NO SQL
SELECT * FROM usuarios WHERE correo=Usuario and contrasenia=Pass and estado_usuario="activo"$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MantenimientoDetallesPerfilUsuarios` (IN `_id` INT, IN `_religion` VARCHAR(255), IN `_empleo` VARCHAR(255), IN `_escuela` VARCHAR(255), IN `_universidad` VARCHAR(255), IN `_deportes` VARCHAR(255), IN `_intereses` VARCHAR(255), IN `_generosmusicales` VARCHAR(255), IN `_situacionsentimental` VARCHAR(255), IN `_comprobacionperfil` TINYINT(1), IN `_sobremi` VARCHAR(100))  NO SQL
UPDATE detalleusuarios SET religion = _religion, empleo = _empleo, escuela = _escuela, universidad = _universidad, deportes = _deportes, intereses = _intereses, generosmusicales = _generosmusicales, situacionsentimental = _situacionsentimental, comprobacionperfil = _comprobacionperfil, sobremi = _sobremi WHERE id=_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistrarComentariosPublicacionesPerfiles` (IN `_comentario` VARCHAR(255), IN `_id` INT, IN `_idpublicacion` INT)  NO SQL
BEGIN
INSERT INTO comentarios (comentario,id,idpublicacion) VALUES (_comentario,_id,_idpublicacion);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistrarDetallesUsuariosPerfiles` (IN `_id` INT, IN `_religion` VARCHAR(255), IN `_empleo` VARCHAR(255), IN `_escuela` VARCHAR(255), IN `_universidad` VARCHAR(255), IN `_deportes` VARCHAR(255), IN `_intereses` VARCHAR(255), IN `_generosmusicales` VARCHAR(255), IN `_situacionsentimental` VARCHAR(255), IN `_comprobacionperfil` TINYINT(1), IN `_sobremi` VARCHAR(100))  NO SQL
INSERT INTO detalleusuarios (religion,empleo,escuela,universidad,deportes,intereses,generosmusicales,situacionsentimental,comprobacionperfil,sobremi,id) VALUES (_religion,_empleo,_escuela,_universidad,_deportes,_intereses,_generosmusicales,_situacionsentimental,_comprobacionperfil,_sobremi,_id)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistrarMensajesChatGeneral` (IN `_mensaje` VARCHAR(1000), IN `_id` INT)  NO SQL
INSERT INTO mensajeria (mensaje,id) VALUES (_mensaje,_id)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistrarNuevasReaccionesPublicaciones` (IN `_id` INT, IN `_idpublicacion` INT)  NO SQL
INSERT INTO reacciones (id,idpublicacion) VALUES (_id,_idpublicacion)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistrarPublicacionesNuevas` (IN `_mensaje_publicacion` VARCHAR(150), IN `_foto_publicacion` VARCHAR(255), IN `_id` INT)  NO SQL
BEGIN
INSERT INTO publicaciones (mensaje_publicacion,foto_publicacion,id) VALUES (_mensaje_publicacion,_foto_publicacion,_id);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistrarUsuariosNuevos` (IN `_nombres` VARCHAR(255), IN `_apellidos` VARCHAR(255), IN `_correo` VARCHAR(255), IN `_contrasenia` VARCHAR(255))  NO SQL
BEGIN 
INSERT INTO usuarios (nombres, apellidos, correo, contrasenia) VALUES (_nombres, _apellidos, _correo, _contrasenia);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistroNuevosEventosSociales` (IN `_nombre` VARCHAR(255), IN `_descripcion` VARCHAR(255), IN `_direccion` VARCHAR(255), IN `_usuario` VARCHAR(255), IN `_pais` VARCHAR(255), IN `_fechainicio` DATETIME, IN `_fechafin` DATETIME, IN `_fotoevento` VARCHAR(255), IN `_id` INT)  NO SQL
INSERT INTO eventos (nombre,descripcion,direccion,usuario,pais,fechainicio,fechafin,fotoevento,id) VALUES (_nombre,_descripcion,_direccion,_usuario,_pais,_fechainicio,_fechafin,_fotoevento,_id)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistroSolicitudesAmistadUsuarios` (IN `_id` INT, IN `_idsolicitudamigo` INT)  NO SQL
INSERT INTO solicitudamistad (id,idsolicitudamigo) VALUES (_id,_idsolicitudamigo)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistroVideosMusicales` (IN `_titulo_video` VARCHAR(40), IN `_video` VARCHAR(255), IN `_id` INT)  NO SQL
INSERT INTO videos (titulo_video,video,id) VALUES (_titulo_video,_video,_id)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RetirarMensajesChatGeneral` (IN `_idmensaje` INT)  NO SQL
UPDATE mensajeria SET mensaje="[Este mensaje ha sido retirado]", estado=1 WHERE idmensaje=_idmensaje$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `amigos`
--

CREATE TABLE `amigos` (
  `idamigo` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `idsolicitudamigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `amigos`
--

INSERT INTO `amigos` (`idamigo`, `id`, `idsolicitudamigo`) VALUES
(1, 1, 2),
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
-- Estructura de tabla para la tabla `cancelacioncuenta`
--

CREATE TABLE `cancelacioncuenta` (
  `idcancelacion` int(11) NOT NULL,
  `nombres` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `motivo` varchar(100) NOT NULL,
  `detalle` varchar(150) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Disparadores `cancelacioncuenta`
--
DELIMITER $$
CREATE TRIGGER `CambioEstadoUsuarios` AFTER INSERT ON `cancelacioncuenta` FOR EACH ROW UPDATE usuarios SET estado_usuario="inactivo" WHERE id=NEW.id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `idcomenterio` int(11) NOT NULL,
  `comentario` varchar(255) NOT NULL,
  `fechacomentario` timestamp NOT NULL DEFAULT current_timestamp(),
  `id` int(11) NOT NULL,
  `idpublicacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`idcomenterio`, `comentario`, `fechacomentario`, `id`, `idpublicacion`) VALUES
(1, '😁😁👍', '2021-02-08 21:53:53', 1, 4),
(2, '🙊🙊😝😊', '2021-02-08 21:54:48', 2, 1);

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

CREATE TABLE `detalleusuarios` (
  `iddetalle` int(11) NOT NULL,
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
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

CREATE TABLE `eventos` (
  `ideventos` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `pais` varchar(255) NOT NULL,
  `fechainicio` datetime NOT NULL,
  `fechafin` datetime NOT NULL,
  `fotoevento` varchar(255) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajeria`
--

CREATE TABLE `mensajeria` (
  `idmensaje` int(11) NOT NULL,
  `mensaje` varchar(1000) NOT NULL,
  `fechamensaje` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` int(11) NOT NULL DEFAULT 0,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `mensajeria`
--

INSERT INTO `mensajeria` (`idmensaje`, `mensaje`, `fechamensaje`, `estado`, `id`) VALUES
(1, 'Gracias por visitar Secret. Este es un chat general para comunicarte con todos los usuarios. Recuerda no es en tiempo real.', '2021-02-08 21:25:21', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacionamigos`
--

CREATE TABLE `notificacionamigos` (
  `idnotificacionamigos` int(11) NOT NULL,
  `idamigo` int(11) NOT NULL,
  `idsolicitudamigo` int(11) NOT NULL,
  `fecha_notificacion` timestamp NULL DEFAULT current_timestamp(),
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `notificacionamigos`
--

INSERT INTO `notificacionamigos` (`idnotificacionamigos`, `idamigo`, `idsolicitudamigo`, `fecha_notificacion`, `id`) VALUES
(1, 1, 2, '2021-02-08 21:53:25', 1),
(2, 2, 1, '2021-02-08 21:54:24', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacioncomentarios`
--

CREATE TABLE `notificacioncomentarios` (
  `idnotificacioncomentarios` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `idpublicacion` int(11) NOT NULL,
  `fecha_notificacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `notificacioncomentarios`
--

INSERT INTO `notificacioncomentarios` (`idnotificacioncomentarios`, `id`, `idpublicacion`, `fecha_notificacion`) VALUES
(1, 1, 4, '2021-02-08 21:53:53'),
(2, 2, 1, '2021-02-08 21:54:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicaciones`
--

CREATE TABLE `publicaciones` (
  `idpublicacion` int(11) NOT NULL,
  `mensaje_publicacion` varchar(150) NOT NULL,
  `foto_publicacion` varchar(255) NOT NULL,
  `fecha_publicacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `megusta` int(11) NOT NULL DEFAULT 0,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `publicaciones`
--

INSERT INTO `publicaciones` (`idpublicacion`, `mensaje_publicacion`, `foto_publicacion`, `fecha_publicacion`, `megusta`, `id`) VALUES
(1, 'Actualizó su foto del perfil.', 'PngItem_3555159.png', '2021-02-08 21:04:23', 1, 1),
(2, 'Actualizó su foto de portada.', 'cgi-wallpaper-hd-1080p-209621.jpg', '2021-02-08 21:04:23', 0, 1),
(3, 'Gracias por obtener este repositorio. Te adjuntó una publicación técnica necesaria con el desglose de información de como está compuesto este proyecto', 'publicacionsistema.png', '2021-02-08 21:17:04', 0, 1),
(4, 'Actualizó su foto del perfil.', 'pngegg.png', '2021-02-08 21:50:38', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reacciones`
--

CREATE TABLE `reacciones` (
  `idreacciones` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `id` int(11) NOT NULL,
  `idpublicacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `reacciones`
--

INSERT INTO `reacciones` (`idreacciones`, `fecha`, `id`, `idpublicacion`) VALUES
(1, '2021-02-08 21:53:36', 1, 4),
(2, '2021-02-08 21:54:34', 2, 1);

--
-- Disparadores `reacciones`
--
DELIMITER $$
CREATE TRIGGER `ActualizacionReaccionMeGusta` AFTER INSERT ON `reacciones` FOR EACH ROW UPDATE publicaciones SET megusta = megusta + 1 WHERE idpublicacion=new.idpublicacion
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudamistad`
--

CREATE TABLE `solicitudamistad` (
  `idsolicitudamistad` int(11) NOT NULL,
  `idsolicitudamigo` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `estado` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `solicitudamistad`
--

INSERT INTO `solicitudamistad` (`idsolicitudamistad`, `idsolicitudamigo`, `id`, `estado`) VALUES
(4, 1, 2, 1),
(5, 2, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
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
  `estado_usuario` varchar(40) NOT NULL DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombres`, `apellidos`, `usuario`, `correo`, `contrasenia`, `fotoperfil`, `foto_portada`, `pais`, `ciudad`, `telefono`, `genero`, `fechanacimiento`, `privacidad`, `completarperfil`, `estado_usuario`) VALUES
(1, 'Daniel', 'Rivera', 'Elmismisimos', 'dan@gmail.com', '3cD3E5Ut4NFZ2', 'PngItem_3555159.png', 'cgi-wallpaper-hd-1080p-209621.jpg', 'El Salvador', 'San Salvador', '+50322334455', 'm', '2003-12-03', 0, 0, 'activo'),
(2, 'Olivo', 'Oliva', 'olivapopeye', 'oliva@gmail.com', '3cD3E5Ut4NFZ2', 'pngegg.png', 'img-ciudadpredeterminada.jpg', 'El Salvador', 'San Salvador', '+50322334411', 'f', '1985-02-09', 1, 0, 'activo');

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

CREATE TABLE `videos` (
  `idvideos` int(11) NOT NULL,
  `titulo_video` varchar(40) NOT NULL,
  `video` varchar(255) NOT NULL,
  `fechasubida` timestamp NOT NULL DEFAULT current_timestamp(),
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `videos`
--

INSERT INTO `videos` (`idvideos`, `titulo_video`, `video`, `fechasubida`, `id`) VALUES
(1, 'Skrillex & Kill The Noise Recess', 'Skrillex  Kill The Noise  Recess.mp4', '2021-02-08 21:23:09', 1),
(2, 'Yogi & Skrillex - Burial', 'Yogi  Skrillex  Burial feat Pusha.mp4', '2021-02-08 21:24:00', 1),
(3, 'Dillon Francis Skrillex Bun Up the Dance', 'Dillon Francis Skrillex  Bun Up the Dance.mp4', '2021-02-08 21:31:48', 1),
(4, 'Juicy J Wiz Khalifa Shell Shocked', 'Juicy J Wiz KhalifaTy Dolla ign  Shell Shocked feat Kill The Noise.mp4', '2021-02-08 21:34:43', 1);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_amigosconfirmados`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_amigosconfirmados` (
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
CREATE TABLE `vista_amigosconfirmadosminiaturas` (
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
CREATE TABLE `vista_comentariosperfilpropietario` (
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
CREATE TABLE `vista_contadorpublicacionespropietarios` (
`idpublicacion` int(11)
,`mensaje_publicacion` varchar(150)
,`foto_publicacion` varchar(255)
,`fecha_publicacion` timestamp
,`id` int(11)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_cumpleanerodiaahora`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_cumpleanerodiaahora` (
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
CREATE TABLE `vista_detallesusuarioscompleta` (
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
CREATE TABLE `vista_eventosregistradoscompleta` (
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
CREATE TABLE `vista_fotossubidascompletaperfilespropietarios` (
`idpublicacion` int(11)
,`foto_publicacion` varchar(255)
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
CREATE TABLE `vista_fotossubidasperfilespropietarios` (
`idpublicacion` int(11)
,`foto_publicacion` varchar(255)
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
CREATE TABLE `vista_listadoexploraramigos` (
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
CREATE TABLE `vista_mensajeriarecibidausuarios` (
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
CREATE TABLE `vista_notificacionesamigos` (
`idnotificacionamigos` int(11)
,`idamigo` int(11)
,`fecha_notificacion` timestamp
,`id` int(11)
,`nombres` varchar(255)
,`apellidos` varchar(255)
,`fotoperfil` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_notificacionescomentarios`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_notificacionescomentarios` (
`id` int(11)
,`idnotificacioncomentarios` int(11)
,`idpublicacion` int(11)
,`fecha_notificacion` timestamp
,`nombres` varchar(255)
,`apellidos` varchar(255)
,`fotoperfil` varchar(255)
,`usuario` varchar(255)
,`foto_publicacion` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_publicacionesinicio`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_publicacionesinicio` (
`id` int(11)
,`idsolicitudamigo` int(11)
,`nombres` varchar(255)
,`apellidos` varchar(255)
,`usuario` varchar(255)
,`fotoperfil` varchar(255)
,`mensaje_publicacion` varchar(150)
,`foto_publicacion` varchar(255)
,`idpublicacion` int(11)
,`fecha_publicacion` timestamp
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_publicacionesperfilusuarios`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_publicacionesperfilusuarios` (
`idpublicacion` int(11)
,`mensaje_publicacion` varchar(150)
,`foto_publicacion` varchar(255)
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
CREATE TABLE `vista_solicitudesamistad` (
`idsolicitudamistad` int(11)
,`id` int(11)
,`idsolicitudamigo` int(11)
,`estado` int(11)
,`nombres` varchar(255)
,`apellidos` varchar(255)
,`fotoperfil` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_usuarioscompleta`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_usuarioscompleta` (
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
CREATE TABLE `vista_videosmusicalessubidos` (
`idvideos` int(11)
,`id` int(11)
,`nombres` varchar(255)
,`apellidos` varchar(255)
,`usuario` varchar(255)
,`titulo_video` varchar(40)
,`video` varchar(255)
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

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_notificacionesamigos`  AS SELECT `notificacionamigos`.`idnotificacionamigos` AS `idnotificacionamigos`, `notificacionamigos`.`idamigo` AS `idamigo`, `notificacionamigos`.`fecha_notificacion` AS `fecha_notificacion`, `notificacionamigos`.`id` AS `id`, `usuarios`.`nombres` AS `nombres`, `usuarios`.`apellidos` AS `apellidos`, `usuarios`.`fotoperfil` AS `fotoperfil` FROM (`notificacionamigos` join `usuarios` on(`notificacionamigos`.`idsolicitudamigo` = `usuarios`.`id`)) WHERE `notificacionamigos`.`idsolicitudamigo` <> 0 ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_notificacionescomentarios`
--
DROP TABLE IF EXISTS `vista_notificacionescomentarios`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_notificacionescomentarios`  AS SELECT `publicaciones`.`id` AS `id`, `notificacioncomentarios`.`idnotificacioncomentarios` AS `idnotificacioncomentarios`, `notificacioncomentarios`.`idpublicacion` AS `idpublicacion`, `notificacioncomentarios`.`fecha_notificacion` AS `fecha_notificacion`, `usuarios`.`nombres` AS `nombres`, `usuarios`.`apellidos` AS `apellidos`, `usuarios`.`fotoperfil` AS `fotoperfil`, `usuarios`.`usuario` AS `usuario`, `publicaciones`.`foto_publicacion` AS `foto_publicacion` FROM ((`notificacioncomentarios` join `usuarios` on(`notificacioncomentarios`.`id` = `usuarios`.`id`)) join `publicaciones` on(`notificacioncomentarios`.`idpublicacion` = `publicaciones`.`idpublicacion`)) WHERE `notificacioncomentarios`.`idpublicacion` <> 0 ;

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

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_solicitudesamistad`  AS SELECT `solicitudamistad`.`idsolicitudamistad` AS `idsolicitudamistad`, `solicitudamistad`.`id` AS `id`, `solicitudamistad`.`idsolicitudamigo` AS `idsolicitudamigo`, `solicitudamistad`.`estado` AS `estado`, `usuarios`.`nombres` AS `nombres`, `usuarios`.`apellidos` AS `apellidos`, `usuarios`.`fotoperfil` AS `fotoperfil` FROM (`solicitudamistad` join `usuarios` on(`solicitudamistad`.`id` = `usuarios`.`id`)) WHERE `solicitudamistad`.`idsolicitudamigo` <> 0 ;

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
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `amigos`
--
ALTER TABLE `amigos`
  ADD PRIMARY KEY (`idamigo`),
  ADD UNIQUE KEY `id` (`id`,`idsolicitudamigo`),
  ADD KEY `idsolicitudamigo` (`idsolicitudamigo`);

--
-- Indices de la tabla `cancelacioncuenta`
--
ALTER TABLE `cancelacioncuenta`
  ADD PRIMARY KEY (`idcancelacion`),
  ADD UNIQUE KEY `id_2` (`id`),
  ADD KEY `id` (`id`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`idcomenterio`),
  ADD KEY `id` (`id`),
  ADD KEY `idpublicacion` (`idpublicacion`);

--
-- Indices de la tabla `detalleusuarios`
--
ALTER TABLE `detalleusuarios`
  ADD PRIMARY KEY (`iddetalle`),
  ADD UNIQUE KEY `id_2` (`id`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`ideventos`),
  ADD KEY `id` (`id`);

--
-- Indices de la tabla `mensajeria`
--
ALTER TABLE `mensajeria`
  ADD PRIMARY KEY (`idmensaje`),
  ADD KEY `id` (`id`);

--
-- Indices de la tabla `notificacionamigos`
--
ALTER TABLE `notificacionamigos`
  ADD PRIMARY KEY (`idnotificacionamigos`),
  ADD KEY `idamigo` (`idamigo`),
  ADD KEY `idsolicitudamigo` (`idsolicitudamigo`),
  ADD KEY `notificacionamigos_ibfk_3` (`id`);

--
-- Indices de la tabla `notificacioncomentarios`
--
ALTER TABLE `notificacioncomentarios`
  ADD PRIMARY KEY (`idnotificacioncomentarios`),
  ADD KEY `notificacioncomentarios_ibfk_3` (`idpublicacion`),
  ADD KEY `id` (`id`);

--
-- Indices de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD PRIMARY KEY (`idpublicacion`),
  ADD KEY `publicaciones_ibfk_1` (`id`);

--
-- Indices de la tabla `reacciones`
--
ALTER TABLE `reacciones`
  ADD PRIMARY KEY (`idreacciones`),
  ADD KEY `idpublicacion` (`idpublicacion`),
  ADD KEY `reacciones_ibfk_1` (`id`);

--
-- Indices de la tabla `solicitudamistad`
--
ALTER TABLE `solicitudamistad`
  ADD PRIMARY KEY (`idsolicitudamistad`),
  ADD UNIQUE KEY `id` (`id`,`idsolicitudamigo`),
  ADD KEY `solicitudamistad_ibfk_2` (`idsolicitudamigo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indices de la tabla `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`idvideos`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `amigos`
--
ALTER TABLE `amigos`
  MODIFY `idamigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cancelacioncuenta`
--
ALTER TABLE `cancelacioncuenta`
  MODIFY `idcancelacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `idcomenterio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `detalleusuarios`
--
ALTER TABLE `detalleusuarios`
  MODIFY `iddetalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `ideventos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mensajeria`
--
ALTER TABLE `mensajeria`
  MODIFY `idmensaje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `notificacionamigos`
--
ALTER TABLE `notificacionamigos`
  MODIFY `idnotificacionamigos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `notificacioncomentarios`
--
ALTER TABLE `notificacioncomentarios`
  MODIFY `idnotificacioncomentarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  MODIFY `idpublicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `reacciones`
--
ALTER TABLE `reacciones`
  MODIFY `idreacciones` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `solicitudamistad`
--
ALTER TABLE `solicitudamistad`
  MODIFY `idsolicitudamistad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `videos`
--
ALTER TABLE `videos`
  MODIFY `idvideos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- Filtros para la tabla `mensajeria`
--
ALTER TABLE `mensajeria`
  ADD CONSTRAINT `mensajeria_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

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
-- Filtros para la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD CONSTRAINT `publicaciones_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

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
