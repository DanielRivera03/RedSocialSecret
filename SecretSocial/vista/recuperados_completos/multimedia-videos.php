"<?php 
/*
--------------------------------------------------------
|            SECRET - RED SOCIAL PHP NATIVO            |
--------------------------------------------------------           
    AUTOR: DANIEL RIVERA (danielrivera03)
    Github: https://github.com/DanielRivera03
    VERSIONES TESTEADAS: 7.3 a 8.0
    COPYRIGHT © 2020 - 2021
--------------------------------------------------------
*/
   // NO PERMITIR INGRESO SIN ENVIO DE PARAMETRO
   if(!isset($_GET['publicaciones'])){
      header('location:../AccesoDenegado=restringido');
    }
     // NO PERMITIR INGRESO SIN INICIAR SESION
     if(!isset($_SESSION['nombre_usuario'])){
        header('location:../AccesoDenegado=restringido');
    }
     // NO PERMITIR INGRESO SI PARAMETRO NO ES IGUAL AL INDICADO
     if($_GET['publicaciones']!="multimedia-secretvideos"){
        header('location:../AccesoDenegado=restringido');
     }
    // INCLUIR ARCHIVO CONTADOR DE PUBLICACIONES -> EXCLUSIVO PERFILES PROPIETARIOS
   require('../modelo/mConteoPublicacionesPerfilPropietario.php');
?>
<?php
   // SOLAMENTE LOS USUARIOS CON PERFIL COMPLETO PODRAN CONSULTAR TODAS LAS PAGINAS
   if($_SESSION['comprobar_perfil']==0){
?>
<!doctype html>
<html lang="ES-SV">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <meta name="description" content="Música Favorita - Comparte tus canciones y videos preferidos con tu comunidad Secret">
   <title>Secret - Música Favorita</title>
   <!-- Favicon -->
   <link rel="apple-touch-icon" sizes="180x180" href="../vista/favicon/apple-touch-icon.png">
   <link rel="icon" type="image/png" sizes="32x32" href="../vista/favicon/favicon-32x32.png">
   <link rel="icon" type="image/png" sizes="16x16" href="../vista/favicon/favicon-16x16.png">
   <link rel="manifest" href="../vista/favicon/site.webmanifest">
   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="../vista/css/boots
<truncated 61217 bytes>