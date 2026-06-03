<?php
   $active_page = '';

   // NO PERMITIR INGRESO SIN ENVIO DE PARAMETRO
   if(!isset($_GET['nuevoregistro'])){
    header('location:../AccesoDenegado=restringido');
   }
   // NO PERMITIR INGRESO SIN INICIAR SESION
   if(!isset($_SESSION['nombre_usuario'])){
      header('location:../AccesoDenegado=restringido');
   }
   // NO PERMITIR INGRESO SI PARAMETRO NO ES IGUAL AL INDICADO
   if($_GET['nuevoregistro']!="resultados-busqueda"){
      header('location:../AccesoDenegado=restringido');
   }
   // INCLUIR ARCHIVO CONTADOR DE PUBLICACIONES -> EXCLUSIVO PERFILES PROPIETARIOS
   require('../modelo/mConteoPublicacionesPerfilPropietario.php');
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
<?php
   // SOLAMENTE LOS USUARIOS CON PERFIL COMPLETO PODRAN CONSULTAR TODAS LAS PAGINAS
   // DE ESTA PLATAFORMA
   if($_SESSION['comprobar_perfil']==0){
?>
<!doctype html>
<html lang="ES-SV">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Secret - Buscador</title>
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
       <!-- Variables y Dark Mode CSS -->
       <link rel="stylesheet" href="../vista/css/variable.css">
      <!-- Bootstrap Dropzone CSS -->
      <link href="../vista/dropzone/dist/dropzone.css" rel="stylesheet" type="text/css"/>
      <!-- Bootstrap Dropzone CSS -->
      <link href="../vista/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css"/>
     <!-- Alerts -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
   </head>
   <body class="sidebar-main-active right-column-fixed">
      <!-- loader Start -->
      <div id="loading">
         <div id="loading-center">
         </div>
      </div>
      <!-- loader END -->
      <!-- Wrapper Start -->
      <div class="wrapper">
                  <?php include __DIR__ . '/premium_sidebar.php'; ?>
         <?php include __DIR__ . '/premium_topnav.php'; ?>
         <div class="header-for-bg">
            <div class="background-header position-relative">
               <img src="../vista/images/bg_portadausuarios.jpg" class="img-fluid w-100 dimension_portada" alt="header-bg">
               <div class="title-on-header">
                  <div class="data-block">
                     <h2>Resultados de B&uacute;squeda</h2>
                  </div>
               </div>
            </div>
         </div>
         <!-- Page Content  -->
         <div id="content-page" class="content-page">
            <div class="container">
               <nav aria-label="breadcrumb">
                  <ol class="breadcrumb iq-bg-danger">
                     <li class="breadcrumb-item"><a href="#" class="text-danger"><i class="las la-search"></i> Resultados de su b&uacute;squeda</a></li>
                     <li class="breadcrumb-item active" aria-current="page"><?php echo $Busqueda; ?> [ <?php echo ContadorResultadosBusqueda($conectarsistema2,$Busqueda) ?> resultados ].</li>
                  </ol>
               </nav>
               <div class="row">
                  <!-- TABS PARA BUSCADOR -->
                  <ul class="nav nav-tabs justify-content-center mb-4" id="searchTabs" role="tablist" style="border-bottom: 2px solid #e4e6eb; width: 100%;">
                     <li class="nav-item" style="margin-bottom: -2px;">
                        <a class="nav-link active" id="people-tab" data-toggle="tab" href="#people" role="tab" aria-controls="people" aria-selected="true" style="font-weight: 700; font-size: 16px; color: var(--iq-primary); border: none; border-bottom: 3px solid var(--iq-primary); padding: 12px 24px;"><i class="las la-user-friends"></i> Personas</a>
                     </li>
                     <li class="nav-item" style="margin-bottom: -2px;">
                        <a class="nav-link" id="posts-tab" data-toggle="tab" href="#posts" role="tab" aria-controls="posts" aria-selected="false" style="font-weight: 700; font-size: 16px; color: #555; border: none; padding: 12px 24px;"><i class="las la-newspaper"></i> Publicaciones</a>
                     </li>
                  </ul>

                  <div class="tab-content" id="searchTabsContent" style="width: 100%;">
                     <!-- TAB PERSONAS -->
                     <div class="tab-pane fade show active" id="people" role="tabpanel" aria-labelledby="people-tab">
                        <div class="row">
                           <!-- INICIO LISTADO DE AMIGOS -->
                           <?php 
                           if(mysqli_num_rows($consulta2) > 0) {
                              while($filas=mysqli_fetch_array($consulta2)){
                                 // NO MOSTRAR USUARIO QUE COINCIDA CON LA SESION INICIADA
                                 if($filas['usuario']!=$_SESSION['usuario_unico']){
                                    // Resaltar palabra clave
                                    $fullName = htmlspecialchars($filas['nombres'] . ' ' . $filas['apellidos']);
                                    $usernameClean = htmlspecialchars($filas['usuario']);
                                    if(!empty($Busqueda)) {
                                       $fullName = preg_replace('/(' . preg_quote($Busqueda, '/') . ')/i', '<mark style="background-color: #ffeb3b; padding: 0 2px; border-radius: 2px;">$1</mark>', $fullName);
                                       $usernameClean = preg_replace('/(' . preg_quote($Busqueda, '/') . ')/i', '<mark style="background-color: #ffeb3b; padding: 0 2px; border-radius: 2px;">$1</mark>', $usernameClean);
                                    }
                                  echo '
                                  <div class="col-md-6">
                                  <div class="iq-card">
                                     <div class="iq-card-body profile-page p-0">
                                        <div class="profile-header-image">
                                           <div class="cover-container">
                                              <img src="../vista/images/fotosportadas/'; echo $filas['foto_portada']; echo'" alt="profile-bg" class="rounded img-fluid w-100 dimension_portadaminiatura">
                                           </div>
                                           <div class="profile-info p-4">
                                              <div class="user-detail">
                                                 <div class="d-flex flex-wrap justify-content-between align-items-start">
                                                    <div class="profile-detail d-flex">
                                                       <div class="profile-img-edit">
                                                          <img src="../vista/images/fotosperfiles/'; echo $filas['fotoperfil']; echo'" alt="profile-img" class="profile-pic avatar-img avatar-110" />
                                                       </div>
                                                       <div class="user-data-block">
                                                          <h4 class=""><i class="ri-vip-crown-2-line"> </i>'; echo $fullName; echo ' <i class="ri-vip-crown-2-line"></i></h4>
                                                          <h6><a href="#">@'; if($filas['usuario']==""){echo 'Usuario nuevo, a&uacute;n no posee su perfil completo';} else { echo $usernameClean; } echo'</a></h6>
                                                          <p>';echo '<i class="ri-vip-crown-line"></i> Residente de: '; echo $filas['pais']; echo ' '; 
                                                          // VALIDACION DE BANDERAS
                                                          if($filas['pais']=="El Salvador"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/015-el-salvador.svg">';
                                                          }else if($filas['pais']=="Alemania"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/162-germany.svg">';
                                                          }else if($filas['pais']=="Argentina"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/198-argentina.svg">';
                                                          }else if($filas['pais']=="Estados Unidos de America"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/226-united-states.svg">';
                                                          }else if($filas['pais']=="EspaÃ±a"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/128-spain.svg">';
                                                          }else if($filas['pais']=="Mexico"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/252-mexico.svg">';
                                                          }else if($filas['pais']=="Venezuela"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/139-venezuela.svg">';
                                                          }else{
                                                              echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/incognito-1.svg">';
                                                          }
                                                          echo '</p>
                                                       </div>
                                                    </div>';
                                                    if($filas['id']==$_SESSION['id_usuario']){
                                                        echo '
                                                        <a href="../Perfil/' . $_SESSION['usuario_unico'] . '" class="btn btn-primary"><i class="fa fa-external-link"></i> Ver Perfil</a>';
                                                     }else{
                                                        $searched_user_id = $filas['id'];
                                                        if (in_array($searched_user_id, $my_friends)) {
                                                           echo '
                                                           <button class="btn btn-secondary mr-2" disabled><i class="ri-check-line mr-1"></i> Amigos</button>
                                                           ';
                                                        } elseif (in_array($searched_user_id, $pending_sent)) {
                                                           echo '
                                                           <button class="btn btn-secondary mr-2" disabled><i class="ri-time-line mr-1"></i> Pendiente</button>
                                                           ';
                                                        } elseif (in_array($searched_user_id, $pending_received)) {
                                                           echo '
                                                           <a style="color: #fff;" id="aceptar-solicitudes" data-id="'; echo $filas['id']; echo'" class="btn btn-success mr-2"><i class="ri-user-shared-line mr-1"></i> Aceptar</a>
                                                           ';
                                                        } else {
                                                           echo '
                                                           <a style="color: #fff;" id="enviosolicitud" data-id="'; echo $filas['id']; echo'" class="btn btn-primary mr-2"><i class="fa fa-user-plus mr-1"></i> Agregar</a>
                                                           ';
                                                        }
                                                        echo '
                                                        <a href="../Perfiles/'; echo $filas['usuario']; echo'='; echo $filas['id']; echo'" class="btn btn-primary"><i class="fa fa-external-link"></i> Ver Perfil</a>';
                                                     } echo'
                                                  </div>
                                               </div>
                                            </div>
                                         </div>
                                      </div>
                                   </div>
                                </div>
                                   ';
                                 }
                              }
                           } else {
                              echo '
                              <div class="col-12 text-center py-5">
                                  <i class="ri-user-search-line" style="font-size: 48px; color: #ccc;"></i>
                                  <h5 class="mt-3 text-muted">No se encontraron usuarios coincidentes con tu bÃºsqueda.</h5>
                              </div>';
                           }
                           ?>
                        </div>
                     </div>

                     <!-- TAB PUBLICACIONES -->
                      <div class="tab-pane fade" id="posts" role="tabpanel" aria-labelledby="posts-tab">
                         <div class="row" style="width: 100%;">
                            <?php
                            if(mysqli_num_rows($consultaPubs) > 0) {
                               while($pub = mysqli_fetch_array($consultaPubs)) {
                                  // Resaltar palabra clave
                                  $text = htmlspecialchars($pub['mensaje_publicacion']);
                                  if(!empty($Busqueda)) {
                                     $text = preg_replace('/(' . preg_quote($Busqueda, '/') . ')/i', '<mark style="background-color: #ffeb3b; padding: 0 2px; border-radius: 2px;">$1</mark>', $text);
                                  }
                                  $profile_url = ($pub['id'] == $_SESSION['id_usuario']) ? '../Perfil/' . $_SESSION['usuario_unico'] : '../Perfiles/' . $pub['usuario'] . '=' . $pub['id'];
                                  echo '
                                  <div class="col-md-6 mb-4">
                                     <div class="iq-card shadow-sm h-100" style="border-radius: 12px; overflow: hidden; border: 1px solid #e4e6eb;">
                                        <div class="iq-card-body p-4 d-flex flex-column h-100">
                                           <div class="d-flex align-items-center mb-3">
                                              <img src="../vista/images/fotosperfiles/' . (empty($pub['fotoperfil']) ? 'usuarioblanco.png' : $pub['fotoperfil']) . '" class="avatar-45 rounded-circle mr-3" style="width:45px; height:45px; object-fit:cover;">
                                              <div>
                                                 <h6 class="mb-0 font-weight-bold" style="font-size: 15px;">' . htmlspecialchars($pub['nombres']) . ' ' . htmlspecialchars($pub['apellidos']) . '</h6>
                                                 <a href="' . $profile_url . '" class="text-muted font-size-12">@' . htmlspecialchars($pub['usuario']) . '</a>
                                              </div>
                                           </div>
                                           <p class="card-text flex-grow-1" style="font-size: 14px; line-height: 1.5; color: #1c1e21;">' . $text . '</p>';
                                           if(!empty($pub['foto_publicacion'])) {
                                               $fotos = explode(',', $pub['foto_publicacion']);
                                               $primerFoto = trim($fotos[0]);
                                               echo '
                                               <div class="post-img mb-3" style="border-radius: 8px; overflow: hidden; max-height: 250px;">
                                                  <img src="../vista/images/fotospublicaciones/' . htmlspecialchars($primerFoto, ENT_QUOTES, 'UTF-8') . '" class="img-fluid w-100" style="object-fit: cover; max-height: 250px;">
                                               </div>';
                                            }
                                           echo '
                                           <div class="d-flex justify-content-between align-items-center mt-auto pt-3" style="border-top: 1px solid #f0f2f5;">
                                              <span class="text-muted font-size-12"><i class="ri-calendar-line"></i> ' . date("d/m/Y H:i", strtotime($pub['fecha_publicacion'])) . '</span>
                                              <a href="' . $profile_url . '" class="btn btn-sm btn-outline-primary" style="border-radius: 20px; font-weight: 600; font-size: 12px;">Ver Perfil</a>
                                           </div>
                                        </div>
                                     </div>
                                  </div>
                                  ';
                              }
                           } else {
                              echo '
                              <div class="col-12 text-center py-5">
                                  <i class="ri-chat-search-line" style="font-size: 48px; color: #ccc;"></i>
                                  <h5 class="mt-3 text-muted">No se encontraron publicaciones coincidentes con tu bÃºsqueda.</h5>
                              </div>';
                           }
                           ?>
                        </div>
                     </div>
                  </div>
               </div>

               <!-- CSS de pestañas activas -->
               <style>
                  #searchTabs .nav-link {
                     transition: all 0.2s;
                     border-bottom: 3px solid transparent;
                  }
                  #searchTabs .nav-link.active {
                     color: var(--iq-primary) !important;
                     border-bottom: 3px solid var(--iq-primary) !important;
                  }
                  #searchTabs .nav-link:not(.active):hover {
                     color: var(--iq-primary) !important;
                     background: rgba(var(--iq-primary-rgb), 0.05);
                  }
               </style>
            </div>
         </div>
      </div>
      <!-- Wrapper END -->
      <!-- Footer -->
      <footer class="bg-white iq-footer">
         <div class="container-fluid">
            <div class="row">
               <div class="col-lg-6">
                  <ul class="list-inline mb-0">
                     <li class="list-inline-item"><a href="../Secret/privacidad-condiciones">T&eacute;rminos y Condiciones de Uso</a></li>
                  </ul>
               </div>
               <div class="col-lg-6 text-right">
               &copy; Copyright <?php echo date('Y'); ?> Secret&reg;<br>Derechos Reservados
               </div>
            </div>
         </div>
      </footer>
      <!-- Footer END -->
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
      <!-- am core JavaScript -->
      <script src="../vista/js/core.js"></script>
      <!-- am charts JavaScript -->
      <script src="../vista/js/charts.js"></script>
      <!-- am animated JavaScript -->
      <script src="../vista/js/animated.js"></script>
      <!-- am kelly JavaScript -->
      <script src="../vista/js/kelly.js"></script>
      <!-- am maps JavaScript -->
      <script src="../vista/js/maps.js"></script>
      <!-- am worldLow JavaScript -->
      <script src="../vista/js/worldLow.js"></script>
      <!-- Chart Custom JavaScript -->
      <script src="../vista/js/chart-custom.js"></script>
      <!-- Custom JavaScript -->
      <script src="../vista/js/custom.js"></script>
      <!-- Alerts -->
      <script src="../vista/js/alerta-enviosolicitudamistad.js"></script>
      <script src="../vista/js/alerta-solicitudesaceptadas.js"></script>
      <script src="../vista/js/alerta-eliminarsolicitudamistad.js"></script>
       <script src="../vista/js/floating_chat.js"></script>
     <?php include __DIR__ . '/fb_viewer_modal.php'; ?>
   </body>
</html>
<?php
/*SI UN USUARIO CON PERFIL INCOMPLETO INTENTA ACCEDER AL FEED DE LA APLICACION
SE LE BLOQUEA SU ACCESO Y DEBE OBLIGATORIAMENTE COMPLETAR SU PERFIL PARA PODER
ACCEDER A TODAS LAS FUNCIONES DE ESTA APLICACION*/
}else{header('location:../Controlador/cRegistroNuevosUsuarios.php?nuevoregistro=completarperfil');}
?>