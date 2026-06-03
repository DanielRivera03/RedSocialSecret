"<?php
require('../modelo/conexion.php');
if(!isset($_GET['token']) || empty($_GET['token'])){
    die("Token invalido o inexistente.");
}
$token = $_GET['token'];

// Verificamos si el token es válido
$stmt = $conectarsistema->prepare("SELECT id FROM usuarios WHERE token_recuperacion = ? AND fecha_token > NOW() - INTERVAL 1 HOUR");
$stmt->bind_param("s", $token);
$stmt->execute();
$resultado = $stmt->get_result();

if($resultado->num_rows == 0){
    die("El token ha expirado o no es válido. Por favor, solicita uno nuevo.");
}
?>
<!doctype html>
<html lang="ES-SV">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Secret - Restablecer Contrase&ntilde;a</title>
      <link rel="apple-touch-icon" sizes="180x180" href="../vista/favicon/apple-touch-icon.png">
      <link rel="icon" type="image/png" sizes="32x32" href="../vista/favicon/favicon-32x32.png">
      <link rel="icon" type="image/png" sizes="16x16" href="../vista/favicon/favicon-16x16.png">
      <link rel="stylesheet" href="../vista/css/bootstrap.min.css">
      <link rel="stylesheet" href="../vista/css/typography.css">
      <link rel="stylesheet" href="../vista/css/style.css">
      <link rel="stylesheet" href="../vista/css/responsive.css">
      <!-- Alerts -->
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
   </head>
   <body>
      <div id="loading"><div id="loading-center"></div></div>
        <section class="sign-in-page">
          <div id="container-inside">
              <div id="circle-small"></div>
              <div id="circle-medium"></div>
              <div id="circle-large"></div>
              <div id="circle-xlarge"></div>
              <div id="circle-xxlarge"></div>
          </div>
            <div class="container p-0">
                <div class="row no-gutters">
                    <div cla
<truncated 3787 bytes>