<?php
require('../modelo/conexion.php');
?>
<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Recuperar Contraseña</title>
      <link rel="shortcut icon" href="../vista/images/favicon.ico" />
      <link rel="stylesheet" href="../vista/css/bootstrap.min.css">
      <link rel="stylesheet" href="../vista/css/typography.css">
      <link rel="stylesheet" href="../vista/css/style.css">
      <link rel="stylesheet" href="../vista/css/responsive.css">
   </head>
   <body>
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
                  <div class="col-md-6 text-center pt-5">
                      <div class="sign-in-detail text-white">
                          <a class="sign-in-logo mb-5" href="#"><img src="../vista/images/logo-full.png" class="img-fluid" alt="logo"></a>
                          <h4 class="mb-1 text-white">Recupera tu acceso</h4>
                          <p>Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.</p>
                      </div>
                  </div>
                  <div class="col-md-6 bg-white pt-5">
                      <div class="sign-in-from">
                          <h1 class="mb-0">Recuperar Contraseña</h1>
                          <p>Ingresa tu correo electrónico.</p>
                          <form id="form-recuperar" class="mt-4" action="javascript:void(0);">
                              <div class="form-group">
                                  <label for="exampleInputEmail1">Correo Electrónico</label>
                                  <input type="email" class="form-control mb-0" id="correo" name="correo" placeholder="Ej: micorreo@gmail.com" required>
                              </div>
                              <div class="d-inline-block w-100">
                                  <button type="submit" class="btn btn-primary float-right">Enviar Enlace</button>
                              </div>
                              <div id="msg" class="mt-3"></div>
                              <div class="sign-info text-center mt-3">
                                  <span class="dark-color d-inline-block line-height-2">¿Recordaste tu contraseña? <a href="../Feed/login">Inicia Sesión</a></span>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </section>
      
      <script src="../vista/js/jquery.min.js"></script>
      <script>
          $('#form-recuperar').submit(function(e){
              let correo = $('#correo').val();
              $('#msg').html('<div class="spinner-border text-primary"></div>');
              $.post('../controlador/cRecuperar.php', {accion: 'enviar', correo: correo}, function(res){
                  if(res.status == 'OK') {
                      $('#msg').html('<div class="alert alert-success">Se ha enviado un enlace a tu correo. (Si estás en localhost, revisa tu carpeta sendmail). <br><a href="'+res.link+'">Enlace directo de prueba</a></div>');
                  } else {
                      $('#msg').html('<div class="alert alert-danger">'+res.error+'</div>');
                  }
              });
          });
      </script>
   </body>
</html>
