<?php
     // NO PERMITIR INGRESO SIN ENVIO DE PARAMETRO
     if(!isset($_GET['nuevoregistro'])){
        header('location:../AccesoDenegado=restringido');
       }
?>
<!-- 
--------------------------------------------------------
║            SECRET - RED SOCIAL PHP NATIVO            ║
--------------------------------------------------------           
    AUTOR: DANIEL RIVERA (danielrivera03)
    Github: https://github.com/DanielRivera03
    VERSIONES TESTEADAS: 7.3 a 8.0
    -> VERSIONES INFERIORES PROBABLEMENTE TENGAN
    ALGUN CONFLICTO. TOMAR EN CUENTA.
    COPYRIGHT © 2020 - 2021
--------------------------------------------------------
-->
<!doctype html>
<html lang="ES-SV">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Secret - Registrarme</title>
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
      <!-- Estilos alertas personalizadas -->
      <link rel="stylesheet" href="../vista/SweetAlert/sweetalert2.min.css">
   </head>
   <body>
   <div id="loading">
         <div id="loading-center">
         </div>
      </div>
      <!-- loader END -->
        <!-- Sign in Start -->
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
                            <a class="sign-in-logo mb-5" href="../IniciarSesion/inicio"><img src="../vista/images/logo-full.png" class="img-fluid" alt="logo"></a>
                            <div class="owl-carousel" data-autoplay="true" data-loop="true" data-nav="false" data-dots="true" data-items="1" data-items-laptop="1" data-items-tab="1" data-items-mobile="1" data-items-mobile-sm="1" data-margin="0">
                            <div class="item">
                                    <img src="../vista/images/login/image1.jpg" class="img-fluid mb-4 rounded" alt="logo">
                                    <h4 class="mb-1 text-white">Con&eacute;ctate con todos</h4>
                                    <p>Secret es muy vers&aacute;til, te ofrece conectarte con los que
                                        m&aacute;s quieres.</p>
                                </div>
                                <div class="item">
                                    <img src="../vista/images/login/image2.jpg" class="img-fluid mb-4 rounded" alt="logo"> 
                                    <h4 class="mb-1 text-white">No importan las distancias</h4>
                                    <p>En cuesti&oacute;n de segundos, puedes comunicarte con quien quieras.</p>
                                </div>
                                <div class="item">
                                    <img src="../vista/images/login/image3.jpg" class="img-fluid mb-4" alt="logo">
                                    <h4 class="mb-1 text-white">¡Bienvenido a Secret!</h4>
                                    <p>Nos apasiona tenerte aqu&iacute;, te damos nuestra cordial bienvenida a esta gran red social.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bg-white pt-5">
                        <div class="sign-in-from">
                            <h1 class="mb-0">Registrarme</h1>
                            <p>Por favor complete todos los campos <span style="color: #F00;">(*)</span></p>
                            <form class="mt-4 needs-validation" novalidate method="POST" action="../RegistrarUsuario/nuevoregistro" autocomplete="off">
                                <!-- NOMBRE DE USUARIO -->
                                <div class="form-group">
                                <label for="exampleInputEmail1">&#128549; Ingrese su nombre <span style="color: #F00;">(*)</span></label>
                                    <div class="input-group">
                                       <input type="text" class="form-control mb-0" id="validationTooltipUsername" aria-describedby="validationTooltipUsernamePrepend" name="nombre_usuario" placeholder="Por favor ingrese su nombre..." minlength="3" maxlength="255" required>
                                       <div class="invalid-tooltip">
                                          Nombre es requerido, complete este campo
                                       </div>
                                       <div class="valid-tooltip">
                                          Campo completado con &eacute;xito
                                       </div>
                                    </div>    
                                </div>
                                <!-- APELLIDO DE USUARIO -->
                                <div class="form-group">
                                <label for="exampleInputEmail1">&#128549; Ingrese su apellido <span style="color: #F00;">(*)</span></label>
                                    <div class="input-group">
                                       <input type="text" class="form-control mb-0" id="validationTooltipUsername" aria-describedby="validationTooltipUsernamePrepend" name="apellido_usuario" placeholder="Por favor ingrese su apellido..." minlength="3" maxlength="255" required>
                                       <div class="invalid-tooltip">
                                          Apellido es requerido, complete este campo
                                       </div>
                                       <div class="valid-tooltip">
                                          Campo completado con &eacute;xito
                                       </div>
                                    </div>    
                                </div>
                                <!--div class="form-group">
                                    <label for="exampleInputPassword1">Ingrese su nombre de usuario <span style="color: #F00;">(*)</span></label>
                                    <input type="text" class="form-control mb-0" id="exampleInputPassword1" name="usuario_unico" placeholder="Por favor ingrese su nombre de usuario...">
                                </div-->
                                <!-- CORREO DE USUARIO -->
                                <div class="form-group">
                                <label for="exampleInputEmail1">&#128235; Ingrese su correo electr&oacute;nico <span style="color: #F00;">(*)</span></label>
                                    <div class="input-group">
                                       <input type="email" class="form-control mb-0" id="validationTooltipUsername" aria-describedby="validationTooltipUsernamePrepend" name="correo_usuario" placeholder="Por favor ingrese su correo...." minlength="8" maxlength="255" required>
                                       <div class="invalid-tooltip">
                                          Correo es requerido, complete este campo
                                       </div>
                                       <div class="valid-tooltip">
                                          Campo completado con &eacute;xito
                                       </div>
                                    </div>    
                                </div>
                                <!-- CONTRASEÑA DE USUARIO -->
                                <div class="form-group">
                                <label for="exampleInputEmail1">&#128273; Ingrese su contrase&ntilde;a<span style="color: #F00;">(*)</span></label>
                                    <div class="input-group">
                                       <input type="password" class="form-control mb-0" id="validationTooltipUsername" aria-describedby="validationTooltipUsernamePrepend" name="clave_usuario" placeholder="Por favor ingrese su contrase&ntilde;a..." minlength="8" maxlength="255" required>
                                       <div class="invalid-tooltip">
                                        Contrase&ntilde;a es requerido, complete este campo
                                       </div>
                                       <div class="valid-tooltip">
                                          Campo completado con &eacute;xito
                                       </div>
                                    </div>    
                                </div>
                                <div class="d-inline-block w-100">
                                    <div class="custom-control custom-checkbox d-inline-block mt-2 pt-1">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1" required>
                                        <label class="custom-control-label" for="customCheck1">¿Acepta todos los <a target="_blank" href="../Secret/privacidad-condiciones">t&eacute;rminos y condiciones</a> de uso?</label>
                                        <div class="invalid-tooltip">
                                            Usted debe aceptar los t&eacute;rminos y condiciones
                                       </div>
                                       <div class="valid-tooltip">
                                          Campo completado con &eacute;xito
                                       </div>
                                    </div><br><br>
                                    <button type="submit" class="btn btn-primary float-right">Crear Cuenta Nueva</button>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 offset-md-3"><br><br>&copy; Copyright <?php echo date('Y'); ?> Secret&reg;</div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Sign in END -->
      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="../vista/js/jquery.min.js"></script>
      <script src="../vista/js/popper.min.js"></script>
      <script src="../vista/js/bootstrap.min.js"></script>
      <!-- Appear JavaScript -->
      <script src="../vista/js/jquery.appear.js"></script>
      <!-- Countdown JavaScript -->
      <script src="../vista/js/countdown.min.js"></script>
      <!-- Counterup JavaScript -->
      <script src="../vista/js/waypoints.min.js"></script>
      <script src="../vista/js/jquery.counterup.min.js"></script>
      <!-- Wow JavaScript -->
      <script src="../vista/js/wow.min.js"></script>
      <!-- lottie JavaScript -->
      <script src="../vista/js/lottie.js"></script>
      <!-- Apexcharts JavaScript -->
      <script src="../vista/js/apexcharts.js"></script>
      <!-- Slick JavaScript -->
      <script src="../vista/js/slick.min.js"></script>
      <!-- Select2 JavaScript -->
      <script src="../vista/js/select2.min.js"></script>
      <!-- Owl Carousel JavaScript -->
      <script src="../vista/js/owl.carousel.min.js"></script>
      <!-- Magnific Popup JavaScript -->
      <script src="../vista/js/jquery.magnific-popup.min.js"></script>
      <!-- Smooth Scrollbar JavaScript -->
      <script src="../vista/js/smooth-scrollbar.js"></script>
      <!-- Chart Custom JavaScript -->
      <script src="../vista/js/chart-custom.js"></script>
      <!-- Custom JavaScript -->
      <script src="../vista/js/custom.js"></script>
      <!-- Controlador de alertas personalizadas -->
      <script src="../vista/SweetAlert/controlador-alertas.js"></script>
      <script src="../vista/SweetAlert/sweetalert2.all.min.js"></script>
   </body>
</html>