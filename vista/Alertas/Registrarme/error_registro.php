<?php 
/*
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
*/
    // NO PERMITIR INGRESO SIN ENVIO DE PARAMETRO
    if(!isset($_GET['nuevoregistro'])){
        header('location:../AccesoDenegado=restringido');
    }
    // NO PERMITIR INGRESO SI NO ES IGUAL AL PARAMETRO DECLARADO
    if($_GET['nuevoregistro']!="error_registro"){
        header('location:../AccesoDenegado=restringido');
    }
    // NO PERMITIR EL INGRESO SIN PREVIO REGISTRO
    if(!isset($_SESSION['nombre_usuarioregistro'])){
        header('location:../AccesoDenegado=restringido');
    }
    // NO PERMITIR LA ESTANCIA EN ESTA PAGINA POR MAS DE 100 SEGUNDOS
    if(isset($_SESSION['tiempo_sesion'])){
        $Inactividad = 100; // 1.66 MINUTOS
        $TiempoVida = time() - $_SESSION['tiempo_sesion'];
            if($TiempoVida > $Inactividad){
                // RETIRAR Y DESTRUIR LA SESION
                session_unset();
                session_destroy();        
                // REDIRIGIR AL FORMULARIO DE INICIO DE SESION      
                header("location:../IniciarSesion/inicio");
                exit(); // SALIR DE TODA EJECUCION
            }
    }
    $_SESSION['tiempo_sesion'] = time(); // CONTADOR DE TIEMPO
?>
<!doctype html>
<html lang="ES-SV">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Secret - Error en el registro de usuario</title>
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
      <!-- Alerts -->
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
   </head>
   <body onload="MensajeErrorConfirmacion();">
      <!-- loader Start -->
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
                            <a class="sign-in-logo mb-5" href="#"><img src="../vista/images/logo-full.png" class="img-fluid" alt="logo"></a>
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
                            <img src="../vista/images/login/mail.png" width="80"  alt="">
                            <h1 class="mt-3 mb-0">Lo sentimos &#128546;</h1>
                            <p> <strong><h4>Estimado(a) <?php echo $_SESSION['nombre_usuarioregistro']; ?></h4></strong> Lamentablemente ha ocurrido un error a la hora de registrar tu nuevo usuario.
                            ¡No te preocupes &#128512;! Los problemas pueden deberse a:</p>
                            <ul>
                                <li>Correo electr&oacute;nico no disponible y/o err&oacute;neo</li>
                                <li>Problemas de conectividad con el servidor</li>
                                <li>Mantenimientos en la plataforma</li>
                                <li>Registro a nuestra plataforma cancelado</li>
                            </ul>
                            <p>Por favor haz clic en el bot&oacute;n para volver a intentarlo, si el problema persiste por favor int&eacute;ntelo m&aacute;s tarde.</p>
                            <div class="d-inline-block w-100">
                                <a href="../Registrarme/altanuevousuario"><button type="submit" class="btn btn-primary mt-3">Registrarme</button></a>
                            </div>
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
      <!-- lottie JavaScript -->
      <script src="../vista/js/lottie.js"></script>
      <!-- Chart Custom JavaScript -->
      <script src="../vista/js/chart-custom.js"></script>
      <!-- Custom JavaScript -->
      <script src="../vista/js/custom.js"></script>
      <!-- Alert -->
      <script src="../vista/Alertas/Registrarme/error_registro.js"></script>
   </body>
</html>