<?php
require('../modelo/conexion.php');
$token = isset($_GET['token']) ? $_GET['token'] : '';
?>
<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Restablecer Contraseña</title>
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
                          <h4 class="mb-1 text-white">Elige tu nueva contraseña</h4>
                      </div>
                  </div>
                  <div class="col-md-6 bg-white pt-5">
                      <div class="sign-in-from">
                          <h1 class="mb-0">Restablecer</h1>
                          <form id="form-restablecer" class="mt-4" action="javascript:void(0);">
                              <input type="hidden" id="token" value="<?php echo htmlspecialchars($token); ?>">
                              <div class="form-group">
                                  <label>Nueva Contraseña</label>
                                  <input type="password" class="form-control mb-0" id="password" required>
                              </div>
                              <div class="d-inline-block w-100">
                                  <button type="submit" class="btn btn-primary float-right">Guardar</button>
                              </div>
                              <div id="msg" class="mt-3"></div>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </section>
      
      <script src="../vista/js/jquery.min.js"></script>
      <script>
          $('#form-restablecer').submit(function(){
              let token = $('#token').val();
              let password = $('#password').val();
              $.post('../controlador/cRecuperar.php', {accion: 'restablecer', token: token, password: password}, function(res){
                  if(res.status == 'OK') {
                      $('#msg').html('<div class="alert alert-success">Contraseña restablecida. Redirigiendo...</div>');
                      setTimeout(() => { window.location.href = '../Feed/login'; }, 2000);
                  } else {
                      $('#msg').html('<div class="alert alert-danger">'+res.error+'</div>');
                  }
              });
          });
      </script>
   </body>
</html>
