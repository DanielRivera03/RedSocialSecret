<?php
   $active_page = 'notificaciones';
 
   // NO PERMITIR INGRESO SIN ENVIO DE PARAMETRO
   if(!isset($_GET['publicaciones'])){
      header('location:../AccesoDenegado=restringido');
     }
     // NO PERMITIR INGRESO SIN INICIAR SESION
     if(!isset($_SESSION['nombre_usuario'])){
        header('location:../AccesoDenegado=restringido');
     }
     // NO PERMITIR INGRESO SI PARAMETRO NO ES IGUAL AL INDICADO
     if($_GET['publicaciones']!="mostrar-notificaciones"){
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
      <title>Secret - Mis Notificaciones</title>
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
      <!-- Bootstrap Dropzone CSS -->
      <link href="../vista/dropzone/dist/dropzone.css" rel="stylesheet" type="text/css"/>
      <!-- Bootstrap Dropzone CSS -->
      <link href="../vista/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css"/>
      <!-- Remix Icons -->
      <link href="https://cdn.jsdelivr.net/npm/remixicon@2.2.0/fonts/remixicon.css" rel="stylesheet">
      <!-- Alerts -->
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

      <style>
         .notification-panel-card {
             border-radius: 20px !important;
             border: 1px solid var(--iq-border-light) !important;
             box-shadow: 0 10px 30px rgba(0,0,0,0.03) !important;
             overflow: hidden;
             background: var(--iq-white);
             margin-bottom: 30px;
         }
         body.dark-theme .notification-panel-card {
             border-color: #3a3b3c !important;
             box-shadow: 0 10px 30px rgba(0,0,0,0.3) !important;
             background: #242526 !important;
         }

         .notification-feed-list {
             display: flex;
             flex-direction: column;
         }

         .notif-item {
             display: flex;
             align-items: center;
             padding: 20px 24px;
             border-bottom: 1px solid var(--iq-border-light);
             transition: all 0.3s ease;
             position: relative;
         }
         body.dark-theme .notif-item {
             border-color: #3a3b3c;
         }
         .notif-item:last-child {
             border-bottom: none;
         }
         .notif-item:hover {
             background-color: var(--iq-light-primary);
         }
         body.dark-theme .notif-item:hover {
             background-color: rgba(255, 255, 255, 0.02);
         }

         .notif-avatar-wrapper {
             position: relative;
             margin-right: 18px;
             flex-shrink: 0;
         }

         .notif-avatar {
             width: 48px;
             height: 48px;
             border-radius: 50%;
             object-fit: cover;
             border: 2px solid var(--iq-white);
             box-shadow: 0 4px 10px rgba(0,0,0,0.05);
         }
         body.dark-theme .notif-avatar {
             border-color: #242526;
         }

         .notif-badge-icon {
             position: absolute;
             bottom: -2px;
             right: -2px;
             width: 20px;
             height: 20px;
             border-radius: 50%;
             display: flex;
             align-items: center;
             justify-content: center;
             color: white;
             font-size: 11px;
             border: 2px solid var(--iq-white);
             box-shadow: 0 2px 5px rgba(0,0,0,0.1);
         }
         body.dark-theme .notif-badge-icon {
             border-color: #242526;
         }

         .notif-badge-friend {
             background: linear-gradient(135deg, #10b981, #059669);
         }

         .notif-badge-comment {
             background: linear-gradient(135deg, #3b82f6, #1d4ed8);
         }

         .notif-content {
             flex-grow: 1;
             margin-right: 15px;
         }

         .notif-title {
             font-size: 14.5px;
             font-weight: 500;
             line-height: 1.4;
             color: var(--iq-title-text);
             margin-bottom: 5px;
         }
         body.dark-theme .notif-title {
             color: #e4e6eb;
         }
         .notif-title strong {
             font-weight: 700;
         }

         .notif-time {
             font-size: 12px;
             color: var(--iq-body-text);
             display: flex;
             align-items: center;
             gap: 4px;
         }
         body.dark-theme .notif-time {
             color: #a1a1aa;
         }

         .notif-actions {
             display: flex;
             align-items: center;
             gap: 10px;
         }

         .btn-notif-action {
             width: 36px;
             height: 36px;
             border-radius: 50%;
             display: flex;
             align-items: center;
             justify-content: center;
             background: var(--iq-light-secondary);
             color: var(--iq-body-text) !important;
             transition: all 0.2s ease;
             border: none;
         }
         body.dark-theme .btn-notif-action {
             background: #3a3b3c;
             color: #b0b3b8 !important;
         }
         .btn-notif-action:hover {
             background: var(--iq-primary);
             color: white !important;
             transform: scale(1.05);
         }

         .notif-empty-state {
             padding: 60px 24px;
             text-align: center;
         }
         .notif-empty-icon {
             font-size: 55px;
             color: var(--iq-body-text);
             opacity: 0.4;
             margin-bottom: 15px;
             display: block;
         }
         body.dark-theme .notif-empty-icon {
             color: #8c91b6;
         }

         /* Premium Skeleton Loader */
         .notif-skeleton {
             display: none;
             flex-direction: column;
         }
         .skeleton-item {
             display: flex;
             align-items: center;
             padding: 20px 24px;
             border-bottom: 1px solid var(--iq-border-light);
         }
         body.dark-theme .skeleton-item {
             border-color: #3a3b3c;
         }
         .skeleton-avatar {
             width: 48px;
             height: 48px;
             border-radius: 50%;
             background: #e4e6eb;
             margin-right: 18px;
             position: relative;
             overflow: hidden;
         }
         .skeleton-content {
             flex-grow: 1;
         }
         .skeleton-line {
             height: 12px;
             background: #e4e6eb;
             border-radius: 6px;
             margin-bottom: 8px;
             position: relative;
             overflow: hidden;
         }
         .skeleton-line.short {
             width: 60%;
         }
         .skeleton-line.mini {
             width: 30%;
             height: 8px;
         }
         body.dark-theme .skeleton-avatar,
         body.dark-theme .skeleton-line {
             background: #3a3b3c;
         }

         /* Shimmer animation */
         .skeleton-avatar::after,
         .skeleton-line::after {
             content: "";
             position: absolute;
             top: 0; left: 0; right: 0; bottom: 0;
             background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
             animation: shimmer 1.5s infinite;
         }
         body.dark-theme .skeleton-avatar::after,
         body.dark-theme .skeleton-line::after {
             background: linear-gradient(90deg, transparent, rgba(255,255,255,0.08), transparent);
         }
         @keyframes shimmer {
             0% { transform: translateX(-100%); }
             100% { transform: translateX(100%); }
         }

         /* Filter controls style */
         .notif-filters {
             display: flex;
             gap: 12px;
             padding: 15px 24px;
             background: var(--iq-light-secondary);
             border-bottom: 1px solid var(--iq-border-light);
             align-items: center;
         }
         body.dark-theme .notif-filters {
             background: #2b2c2d;
             border-color: #3a3b3c;
         }
         .filter-select {
             padding: 8px 16px;
             border-radius: 20px;
             border: 1px solid var(--iq-border-light);
             background: var(--iq-white);
             color: var(--iq-body-text);
             font-size: 13.5px;
             outline: none;
             cursor: pointer;
             min-width: 130px;
             transition: all 0.25s;
         }
         .filter-select:focus {
             border-color: var(--iq-primary);
             box-shadow: 0 0 0 3px rgba(185, 32, 37, 0.15);
         }
         body.dark-theme .filter-select {
             background: #242526;
             border-color: #3a3b3c;
             color: #e4e6eb;
         }
      </style>
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
         <!-- Page Content  -->
         <div id="content-page" class="content-page">
            <div class="container">
               <div class="row">
                  <div class="col-sm-12">
                     <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                           <h4 class="card-title">Todas tus notificaciones</h4>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-12">
                     <div class="iq-card notification-panel-card">
                        <div class="iq-card-header d-flex justify-content-between align-items-center">
                           <div class="iq-header-title">
                              <h4 class="card-title"><i class="ri-notification-3-line text-primary mr-2"></i> Todas tus notificaciones</h4>
                           </div>
                         </div>
                         <div class="notif-filters">
                            <div style="font-size: 13.5px; font-weight: 600; color: var(--iq-title-text);">Filtrar por fecha:</div>
                            <select id="filter-month" class="filter-select">
                               <option value="all">Cualquier mes</option>
                               <option value="01">Enero</option>
                               <option value="02">Febrero</option>
                               <option value="03">Marzo</option>
                               <option value="04">Abril</option>
                               <option value="05">Mayo</option>
                               <option value="06">Junio</option>
                               <option value="07">Julio</option>
                               <option value="08">Agosto</option>
                               <option value="09">Septiembre</option>
                               <option value="10">Octubre</option>
                               <option value="11">Noviembre</option>
                               <option value="12">Diciembre</option>
                            </select>
                            <select id="filter-year" class="filter-select">
                               <option value="all">Cualquier año</option>
                               <option value="2026">2026</option>
                               <option value="2025">2025</option>
                               <option value="2024">2024</option>
                               <option value="2023">2023</option>
                               <option value="2022">2022</option>
                               <option value="2021">2021</option>
                            </select>
                         </div>
                         <div class="iq-card-body p-0">
                            <!-- SKELETON LOADER -->
                            <div class="notif-skeleton" id="notif-skeleton">
                               <?php for($i = 0; $i < 4; $i++): ?>
                               <div class="skeleton-item">
                                  <div class="skeleton-avatar"></div>
                                  <div class="skeleton-content" style="flex:1;">
                                     <div class="skeleton-line" style="width: 80%;"></div>
                                     <div class="skeleton-line short" style="width: 50%;"></div>
                                     <div class="skeleton-line mini" style="width: 25%;"></div>
                                  </div>
                                </div>
                               <?php endfor; ?>
                            </div>
                            <div class="notification-feed-list">
                              <?php
                              // Helper function inside scope (checked before function_exists to prevent redeclaration)
                              if (!function_exists('tiempoRelativo')) {
                                  function tiempoRelativo($fecha) {
                                      $timestamp = strtotime($fecha);
                                      $diferencia = time() - $timestamp;
                                      
                                      if ($diferencia < 1) {
                                          return 'Ahora mismo';
                                      }
                                      
                                      $intervalos = [
                                          31536000 => 'año',
                                          2592000  => 'mes',
                                          604800   => 'sem',
                                          86400    => 'día',
                                          3600     => 'h',
                                          60       => 'min',
                                          1        => 'seg'
                                      ];
                                      
                                      foreach ($intervalos as $segundos => $nombre) {
                                          $division = $diferencia / $segundos;
                                          if ($division >= 1) {
                                              $valor = round($division);
                                              if ($nombre == 'mes' && $valor > 1) {
                                                  return 'Hace ' . $valor . ' meses';
                                              }
                                              if ($nombre == 'día') {
                                                  return 'Hace ' . $valor . ' ' . ($valor > 1 ? 'días' : 'día');
                                              }
                                              return 'Hace ' . $valor . ' ' . $nombre . ($valor > 1 && $nombre != 'sem' && $nombre != 'min' && $nombre != 'seg' ? 's' : '');
                                          }
                                      }
                                      return $fecha;
                                  }
                              }

                              $num_notif = 0;

                              // Loop for Friend requests accepted
                              while($filas=mysqli_fetch_array($consulta2)){
                                  $num_notif++;
                                  $timeText = tiempoRelativo($filas['fecha_notificacion']);
                                  echo '
                                  <div class="notif-item" data-fecha="' . $filas['fecha_notificacion'] . '">
                                     <div class="notif-avatar-wrapper">
                                        <img src="../vista/images/fotosperfiles/' . $filas['fotoperfil'] . '" class="notif-avatar" alt="avatar">
                                        <span class="notif-badge-icon notif-badge-friend"><i class="ri-heart-fill"></i></span>
                                     </div>
                                     <div class="notif-content">
                                        <div class="notif-title">
                                           ¡Felicidades! Ahora eres amigo de <strong>' . htmlspecialchars($filas['nombres'] . ' ' . $filas['apellidos']) . '</strong>. ¡Salúdalo!
                                        </div>
                                        <div class="notif-time">
                                           <i class="ri-time-line"></i> ' . $timeText . '
                                        </div>
                                     </div>
                                     <div class="notif-actions">
                                        <a id="eliminar-notificacion-amigos" data-id="' . $filas['idnotificacionamigos'] . '" class="btn-notif-action" title="Eliminar"><i class="ri-delete-bin-line"></i></a>
                                     </div>
                                  </div>';
                              }

                              // Loop for Comment notifications
                              while($filas=mysqli_fetch_array($consulta3)){
                                  if($filas['usuario'] != $_SESSION['usuario_unico']){
                                      $num_notif++;
                                      $timeText = tiempoRelativo($filas['fecha_notificacion']);
                                      echo '
                                      <div class="notif-item" data-fecha="' . $filas['fecha_notificacion'] . '">
                                         <div class="notif-avatar-wrapper">
                                            <img src="../vista/images/fotosperfiles/' . $filas['fotoperfil'] . '" class="notif-avatar" alt="avatar">
                                            <span class="notif-badge-icon notif-badge-comment"><i class="ri-chat-3-fill"></i></span>
                                         </div>
                                         <div class="notif-content">
                                            <div class="notif-title">
                                               <strong>' . htmlspecialchars($filas['nombres'] . ' ' . $filas['apellidos']) . '</strong> ha comentado tu publicación. ¡Interactúa con él!
                                            </div>
                                            <div class="notif-time">
                                               <i class="ri-time-line"></i> ' . $timeText . '
                                            </div>
                                         </div>
                                         <div class="notif-actions">
                                            <a id="eliminar-notificacion-comentarios" data-id="' . $filas['idnotificacioncomentarios'] . '" class="btn-notif-action" title="Eliminar"><i class="ri-delete-bin-line"></i></a>
                                         </div>
                                      </div>';
                                  }
                              }

                              // Loop for Reaction notifications
                              while($filas=mysqli_fetch_array($consulta4)){
                                  if($filas['usuario'] != $_SESSION['usuario_unico']){
                                      $num_notif++;
                                      $timeText = tiempoRelativo($filas['fecha_notificacion']);
                                      echo '
                                      <div class="notif-item" data-fecha="' . $filas['fecha_notificacion'] . '">
                                         <div class="notif-avatar-wrapper">
                                            <img src="../vista/images/fotosperfiles/' . $filas['fotoperfil'] . '" class="notif-avatar" alt="avatar">
                                            <span class="notif-badge-icon" style="background: linear-gradient(135deg, #ec4899, #db2777);"><i class="ri-heart-fill"></i></span>
                                         </div>
                                         <div class="notif-content">
                                            <div class="notif-title">
                                               A <strong>' . htmlspecialchars($filas['nombres'] . ' ' . $filas['apellidos']) . '</strong> le gusta tu publicación. ¡Interactúa con él!
                                            </div>
                                            <div class="notif-time">
                                               <i class="ri-time-line"></i> ' . $timeText . '
                                            </div>
                                         </div>
                                         <div class="notif-actions">
                                            <a id="eliminar-notificacion-reacciones" data-id="' . $filas['idnotificacionreacciones'] . '" class="btn-notif-action" title="Eliminar"><i class="ri-delete-bin-line"></i></a>
                                         </div>
                                      </div>';
                                  }
                              }

                              // Loop for Message notifications
                              while($filas=mysqli_fetch_array($consulta5)){
                                  if($filas['usuario'] != $_SESSION['usuario_unico']){
                                      $num_notif++;
                                      $timeText = tiempoRelativo($filas['fecha_notificacion']);
                                      echo '
                                      <div class="notif-item" data-fecha="' . $filas['fecha_notificacion'] . '">
                                         <div class="notif-avatar-wrapper">
                                            <img src="../vista/images/fotosperfiles/' . $filas['fotoperfil'] . '" class="notif-avatar" alt="avatar">
                                            <span class="notif-badge-icon" style="background: linear-gradient(135deg, #8b5cf6, #6d28d9);"><i class="ri-chat-4-fill"></i></span>
                                         </div>
                                         <div class="notif-content">
                                            <div class="notif-title">
                                               <strong>' . htmlspecialchars($filas['nombres'] . ' ' . $filas['apellidos']) . '</strong> te envió un mensaje privado: "' . htmlspecialchars(substr($filas['mensaje'], 0, 60)) . '..."
                                            </div>
                                            <div class="notif-time">
                                               <i class="ri-time-line"></i> ' . $timeText . '
                                            </div>
                                         </div>
                                         <div class="notif-actions">
                                            <a id="eliminar-notificacion-mensajes" data-id="' . $filas['idnotificacionmensajes'] . '" class="btn-notif-action" title="Eliminar"><i class="ri-delete-bin-line"></i></a>
                                         </div>
                                      </div>';
                                  }
                              }

                              if($num_notif == 0){
                                  echo '
                                  <div class="notif-empty-state">
                                     <i class="ri-notification-off-line notif-empty-icon"></i>
                                     <h5>No tienes notificaciones por el momento</h5>
                                     <p class="text-muted mt-2 mb-0">Cuando la comunidad interactúe contigo, aparecerá aquí.</p>
                                  </div>';
                              }
                              ?>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
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
      <script src="../vista/js/alerta-solicitudesaceptadas.js"></script>
      <script src="../vista/js/alerta-eliminarsolicitudamistad.js"></script>
      <script src="../vista/js/alerta-eliminarnotificacionesamigos.js"></script>
      <script src="../vista/js/alerta-eliminarnotificacionescomentarios.js"></script>

      <!-- Polling script for notifications and filtering -->
      <script>
      $(document).ready(function() {
          let currentCount = <?php echo $num_notif; ?>;
          
          setInterval(function() {
              $.ajax({
                  url: '../controlador/cPublicacionesUsuarios.php?publicaciones=count-notificaciones',
                  type: 'GET',
                  dataType: 'json',
                  success: function(response) {
                      if (response && response.status === "OK") {
                          if (response.count !== currentCount) {
                              location.reload();
                          }
                      }
                  }
              });
          }, 15000); // 15 seconds

          // Delete Reaction Notification Handler
          $(document).on('click', '#eliminar-notificacion-reacciones', function(e) {
              e.preventDefault();
              var IDNotificaciones = $(this).data('id');
              var element = $(this);
              Swal.fire({
                  title: '¿Realmente desea eliminar esta notificación?',
                  text: "Al hacer clic en el botón confirmar, no habrá forma de recuperarlo",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#EA2027',
                  cancelButtonColor: '#5758BB',
                  confirmButtonText: 'Confirmar',
                  cancelButtonText: 'Cancelar',
                  showLoaderOnConfirm: true,
                  preConfirm: function() {
                      return new Promise(function(resolve) {
                          $.ajax({
                              url: '../controlador/cPublicacionesUsuarios.php?publicaciones=eliminar-notificaciones-reacciones&idnotificacion='+IDNotificaciones,
                              type: 'GET',
                              dataType: 'json'
                          })
                          .done(function(respuesta){
                              resolve(respuesta);
                          })
                          .fail(function() {
                              resolve("error");
                          });
                      });
                  },
                  allowOutsideClick: () => !Swal.isLoading()
              }).then((result) => {
                  if (result.isConfirmed) {
                      var respuesta = result.value;
                      if (respuesta == "OK" || respuesta === true) {
                          element.closest('.notif-item').fadeOut(400, function() {
                              $(this).remove();
                              if ($('.notification-feed-list').children('.notif-item').length === 0) {
                                  $('.notification-feed-list').html(`
                                      <div class="notif-empty-state">
                                         <i class="ri-notification-off-line notif-empty-icon"></i>
                                         <h5>No tienes notificaciones por el momento</h5>
                                         <p class="text-muted mt-2 mb-0">Cuando la comunidad interactúe contigo, aparecerá aquí.</p>
                                      </div>`);
                              }
                          });
                      } else {
                          Swal.fire("Error", "No se pudo eliminar la notificación", "error");
                      }
                  }
              });
          });

          // Delete Message Notification Handler
          $(document).on('click', '#eliminar-notificacion-mensajes', function(e) {
              e.preventDefault();
              var IDNotificaciones = $(this).data('id');
              var element = $(this);
              Swal.fire({
                  title: '¿Realmente desea eliminar esta notificación?',
                  text: "Al hacer clic en el botón confirmar, no habrá forma de recuperarlo",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#EA2027',
                  cancelButtonColor: '#5758BB',
                  confirmButtonText: 'Confirmar',
                  cancelButtonText: 'Cancelar',
                  showLoaderOnConfirm: true,
                  preConfirm: function() {
                      return new Promise(function(resolve) {
                          $.ajax({
                              url: '../controlador/cPublicacionesUsuarios.php?publicaciones=eliminar-notificaciones-mensajes&idnotificacion='+IDNotificaciones,
                              type: 'GET',
                              dataType: 'json'
                          })
                          .done(function(respuesta){
                              resolve(respuesta);
                          })
                          .fail(function() {
                              resolve("error");
                          });
                      });
                  },
                  allowOutsideClick: () => !Swal.isLoading()
              }).then((result) => {
                  if (result.isConfirmed) {
                      var respuesta = result.value;
                      if (respuesta == "OK" || respuesta === true) {
                          element.closest('.notif-item').fadeOut(400, function() {
                              $(this).remove();
                              if ($('.notification-feed-list').children('.notif-item').length === 0) {
                                  $('.notification-feed-list').html(`
                                      <div class="notif-empty-state">
                                         <i class="ri-notification-off-line notif-empty-icon"></i>
                                         <h5>No tienes notificaciones por el momento</h5>
                                         <p class="text-muted mt-2 mb-0">Cuando la comunidad interactúe contigo, aparecerá aquí.</p>
                                      </div>`);
                              }
                          });
                      } else {
                          Swal.fire("Error", "No se pudo eliminar la notificación", "error");
                      }
                  }
              });
          });

          // Filter by Month and Year Logic
          function filterNotifications() {
              let selectedMonth = $('#filter-month').val();
              let selectedYear = $('#filter-year').val();
              
              let container = $('.notification-feed-list');
              let skeleton = $('#notif-skeleton');
              
              // Hide existing empty state
              $('#notif-empty-filter').remove();
              
              // Show skeleton, hide actual content
              container.children('.notif-item').hide();
              container.children('.notif-empty-state').hide();
              skeleton.css('display', 'flex');
              
              setTimeout(function() {
                  // Hide skeleton
                  skeleton.css('display', 'none');
                  
                  let visibleCount = 0;
                  container.children('.notif-item').each(function() {
                      let item = $(this);
                      let dateStr = item.data('fecha'); // e.g. "2026-05-29 15:32:33"
                      if (!dateStr) {
                          item.fadeIn(200);
                          visibleCount++;
                          return;
                      }
                      
                      // Parse date
                      let parts = dateStr.split(' ')[0].split('-'); // ["2026", "05", "29"]
                      let year = parts[0];
                      let month = parts[1];
                      
                      let matchMonth = (selectedMonth === 'all' || selectedMonth === month);
                      let matchYear = (selectedYear === 'all' || selectedYear === year);
                      
                      if (matchMonth && matchYear) {
                          item.fadeIn(200);
                          visibleCount++;
                      } else {
                          item.hide();
                      }
                  });
                  
                  if (visibleCount === 0) {
                      // Show empty state for filter
                      container.append(`
                          <div class="notif-empty-state" id="notif-empty-filter">
                             <i class="ri-notification-off-line notif-empty-icon"></i>
                             <h5>No hay notificaciones para el período seleccionado</h5>
                             <p class="text-muted mt-2 mb-0">Prueba cambiando los filtros de mes o año.</p>
                          </div>
                      `);
                  }
              }, 700); // 700ms transition for skeleton feel
          }
          
          $('#filter-month, #filter-year').on('change', filterNotifications);
      });
      </script>
   </body>
</html>
<?php
/*SI UN USUARIO CON PERFIL INCOMPLETO INTENTA ACCEDER AL FEED DE LA APLICACION
SE LE BLOQUEA SU ACCESO Y DEBE OBLIGATORIAMENTE COMPLETAR SU PERFIL PARA PODER
ACCEDER A TODAS LAS FUNCIONES DE ESTA APLICACION*/
}else{header('location:../Controlador/cRegistroNuevosUsuarios.php?nuevoregistro=completarperfil');}
?>