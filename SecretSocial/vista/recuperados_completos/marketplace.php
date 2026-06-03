"<?php
session_start();
if(!isset($_SESSION['id_usuario'])){
    header('location:../AccesoDenegado=restringido');
}
require('../modelo/conexion.php');
require('../modelo/mConteoPublicacionesPerfilPropietario.php');
require('../modelo/mModeloPublicaciones.php');

$Publicaciones = new PublicacionesUsuarios();
$IdSolicitudAmigo = $_SESSION['id_usuario'];

// CONSULTAR SOLICITUDES DE AMISTAD RECIBIDAS
$consulta1 = $Publicaciones->ConsultarSolicitudesAmistad($conectarsistema14, $IdSolicitudAmigo);
// CONSULTAR NOTIFICACIONES AMIGOS ACEPTADOS -> TODOS LOS USUARIOS
$consulta2 = $Publicaciones->ConsultarNotificacionesAmigos($conectarsistema16, $IdSolicitudAmigo);
?>
<!doctype html>
<html lang="ES-SV">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Secret - Marketplace</title>
      <!-- Favicon -->
      <link rel="apple-touch-icon" sizes="180x180" href="../vista/favicon/apple-touch-icon.png">
      <link rel="icon" type="image/png" sizes="32x32" href="../vista/favicon/favicon-32x32.png">
      <link rel="icon" type="image/png" sizes="16x16" href="../vista/favicon/favicon-16x16.png">
      <link rel="manifest" href="../vista/favicon/site.webmanifest">
      <link rel="mask-icon" href="../vista/favicon/safari-pinned-tab.svg" color="#5bbad5">
      <meta name="msapplication-TileColor" content="#da532c">
      <meta name="theme-color" content="#ffffff">
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="../vista/css/bootstrap.min.css">
      <!-- Typography CSS -->
      <link rel="stylesheet" href="../vista/css/typography.css">
      <!-- Style CSS -->
      <link rel="stylesheet" href="../vista/css/style.css">
      <!-- Responsive CSS -->
      <link rel="stylesheet" href="../vista/css/responsive.css">
      <!-- Leaflet CSS para Mapas -->
      <link rel="stylesheet" href
<truncated 34069 bytes>