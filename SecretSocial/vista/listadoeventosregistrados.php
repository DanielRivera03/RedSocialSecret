<?php
   $active_page = 'mostrareventos';
 
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
   if(!isset($_GET['eventos_sociales'])){
      header('location:../AccesoDenegado=restringido');
   }
   // NO PERMITIR INGRESO SIN INICIAR SESION
   if(!isset($_SESSION['nombre_usuario'])){
      header('location:../AccesoDenegado=restringido');
   }
   // NO PERMITIR INGRESO SI PARAMETRO NO ES IGUAL AL INDICADO
   if($_GET['eventos_sociales']!="mostrareventos"){
      header('location:../AccesoDenegado=restringido');
   }
   // INCLUIR ARCHIVO CONTADOR DE PUBLICACIONES 
   require('../modelo/mConteoPublicacionesPerfilPropietario.php');

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
      <title>Secret - Eventos Disponibles (<?php echo $_SESSION['pais_usuarios']; ?>)</title>
      <!-- Favicon -->
      <link rel="apple-touch-icon" sizes="180x180" href="../vista/favicon/apple-touch-icon.png">
      <link rel="icon" type="image/png" sizes="32x32" href="../vista/favicon/favicon-32x32.png">
      <link rel="icon" type="image/png" sizes="16x16" href="../vista/favicon/favicon-16x16.png">
      <link rel="manifest" href="../vista/favicon/site.webmanifest">
      <link rel="mask-icon" href="../vista/favicon/safari-pinned-tab.svg" color="#5bbad5">
      <meta name="msapplication-TileColor" content="#da532c">
      <meta name="theme-color" content="#ffffff">
      <!-- Google Fonts -->
      <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
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
          body, input, textarea, button, select, label {
              font-family: 'Montserrat', sans-serif !important;
          }
          h1, h2, h3, h4, h5, h6, .card-title {
              font-family: 'Poppins', sans-serif !important;
          }
          /* Custom styles for Events grid */
          .event-card {
              border-radius: 20px !important;
              overflow: hidden;
              border: 1px solid var(--iq-border-light) !important;
              background: var(--iq-white);
              box-shadow: 0 10px 25px rgba(0, 0, 0, 0.03) !important;
              transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1) !important;
              display: flex;
              flex-direction: column;
              height: 100%;
          }
          body.dark-theme .event-card {
              background: #242526 !important;
              border-color: #3a3b3c !important;
              box-shadow: 0 10px 35px rgba(0, 0, 0, 0.4) !important;
          }
          .event-img-container {
              position: relative;
              overflow: hidden;
              height: 220px;
              background: #e9ecef;
          }
          .event-img-container img {
              width: 100%;
              height: 100%;
              object-fit: cover;
          }
          .badge-category {
              position: absolute;
              top: 15px;
              left: 15px;
              padding: 6px 12px;
              font-size: 11px;
              border-radius: 20px;
              font-weight: 600;
              color: #fff;
              border: 1px solid rgba(255, 255, 255, 0.1);
              z-index: 2;
          }
          .badge-location {
              position: absolute;
              top: 15px;
              right: 15px;
              padding: 6px 12px;
              font-size: 11px;
              border-radius: 20px;
              font-weight: 600;
              background: rgba(0, 0, 0, 0.6);
              backdrop-filter: blur(8px);
              color: #fff;
              border: 1px solid rgba(255, 255, 255, 0.1);
              z-index: 2;
          }
          .event-card-body {
              padding: 24px !important;
              display: flex;
              flex-direction: column;
              flex-grow: 1;
          }
          .event-title {
              font-size: 19px;
              font-weight: 700;
              color: var(--iq-title-text);
              margin-bottom: 8px;
          }
          body.dark-theme .event-title {
              color: #fff;
          }
          .event-desc {
              font-size: 13.5px;
              color: var(--iq-body-text);
              margin-bottom: 20px;
          }
          body.dark-theme .event-desc {
              color: #b0b3b8;
          }
          .event-details-box {
              background: var(--iq-light-secondary);
              border-radius: 12px;
              padding: 15px;
              margin-bottom: 20px;
              font-size: 13px;
              border: 1px solid var(--iq-border-light);
          }
          body.dark-theme .event-details-box {
              background: rgba(255, 255, 255, 0.02) !important;
              border-color: #3a3b3c !important;
          }
          .detail-item {
              display: flex;
              align-items: flex-start;
              margin-bottom: 10px;
          }
          .detail-item i {
              font-size: 16px;
              margin-right: 12px;
              color: var(--iq-primary);
          }
          .attendance-group {
              display: flex;
              gap: 8px;
              flex-wrap: wrap;
          }
          .btn-att {
              flex: 1;
              min-width: 100px;
              padding: 8px 12px;
              font-size: 12.5px;
              font-weight: 600;
              border-radius: 30px;
              border: 1px solid var(--iq-border-light);
              background: transparent;
              transition: all 0.2s;
              cursor: pointer;
          }
          body.dark-theme .btn-att {
              border-color: #3a3b3c;
              color: #b0b3b8;
          }
          .btn-att.active {
              background: var(--iq-primary) !important;
              color: white !important;
              border-color: var(--iq-primary) !important;
          }
          .event-organizer {
              display: flex;
              align-items: center;
              border-top: 1px solid var(--iq-border-light);
              padding-top: 15px;
              margin-top: 15px;
          }
          body.dark-theme .event-organizer {
              border-color: #3a3b3c;
          }
          .organizer-avatar {
              width: 32px;
              height: 32px;
              border-radius: 50%;
              object-fit: cover;
              margin-right: 10px;
              border: 2px solid var(--iq-primary);
          }
      </style>
   </head>
   <body class="sidebar-main-active right-column-fixed">
      <!-- loader Start -->
      <div id="loading">
         <div id="loading-center">
         </div>
      </div>
      <script>
          (function(){
              var loader = document.getElementById('loading');
              if (loader) {
                  window.addEventListener('load', function() {
                      setTimeout(function() {
                          loader.style.transition = 'opacity 0.5s ease';
                          loader.style.opacity = '0';
                          setTimeout(function() { loader.style.display = 'none'; }, 500);
                      }, 100);
                  });
                  setTimeout(function() {
                      if (loader.style.display !== 'none') {
                          loader.style.transition = 'opacity 0.5s ease';
                          loader.style.opacity = '0';
                          setTimeout(function() { loader.style.display = 'none'; }, 500);
                      }
                  }, 2500);
              }
          })();
      </script>
      <!-- loader END -->
      <!-- Wrapper Start -->
      <div class="wrapper">
                  <?php include __DIR__ . '/premium_sidebar.php'; ?>
         <?php include __DIR__ . '/premium_topnav.php'; ?>
         <div class="header-for-bg">
            <div class="background-header position-relative">
               <img style="height: 300px;" src="../vista/images/bg_portadaeventos.jpg" class="img-fluid w-100 rounded rounded" alt="header-bg">
               <div class="title-on-header">
                  <div class="data-block">
                     <h2>Eventos Sociales - <?php echo $_SESSION['pais_usuarios']; ?></h2>
                  </div>
               </div>
            </div>
         </div>
         <!-- Page Content  -->
         <div id="content-page" class="content-page">
            <div class="container">
               <div class="row">
               
               <!-- Alerta Responsabilidad Premium -->
               <div class="col-md-12 col-lg-12">
                   <div class="alert text-white alert-premium d-flex align-items-center" role="alert">
                       <div class="iq-alert-icon mr-3" style="font-size: 24px;">
                           <i class="ri-information-line"></i>
                       </div>
                       <div class="iq-alert-text">
                           Estimado(a) <strong><?php echo $_SESSION['nombre_usuario']; ?></strong>, estás consultando los eventos de <strong><?php echo $_SESSION['pais_usuarios']; ?></strong>. 
                           Publicaciones realizadas por la comunidad. Asistencia bajo tu propia discreción.
                       </div>
                       <button type="button" class="close ml-auto" data-dismiss="alert" aria-label="Close" style="color: #fff; opacity: 0.8;">
                           <i class="ri-close-line"></i>
                       </button>
                   </div>
               </div>

               <!-- Buscador y Filtros Premium -->
               <div class="col-12 mb-4">
                   <div class="iq-card p-3 filter-card">
                       <div class="row align-items-center">
                           <div class="col-lg-4 col-md-5 mb-3 mb-md-0">
                               <div class="search-wrapper">
                                   <i class="ri-search-line search-icon"></i>
                                   <input type="text" id="search-eventos" class="form-control" placeholder="Buscar por nombre, descripción o lugar...">
                               </div>
                           </div>
                           <div class="col-lg-8 col-md-7">
                               <div class="categories-tabs d-flex flex-wrap justify-content-md-end">
                                   <button class="btn btn-filter active" data-filter="all">Todos</button>
                                   <button class="btn btn-filter" data-filter="Música">🎵 Música</button>
                                   <button class="btn btn-filter" data-filter="Fiesta">🎉 Fiestas</button>
                                   <button class="btn btn-filter" data-filter="Educación">📚 Educación</button>
                                   <button class="btn btn-filter" data-filter="Deporte">⚽ Deportes</button>
                                   <button class="btn btn-filter" data-filter="Cultura">🎨 Cultura</button>
                                   <button class="btn btn-filter" data-filter="Comida">🍔 Comida</button>
                                   <button class="btn btn-filter" data-filter="General">✨ Otros</button>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>

               <!-- INICIO BANDERA -> EVENTOS -->
               <?php 
                  // Helper function inside scope (checked before function_exists to prevent redeclaration)
                  if (!function_exists('obtenerCategoriaEvento')) {
                      function obtenerCategoriaEvento($nombre, $descripcion) {
                          $texto = mb_strtolower($nombre . ' ' . $descripcion, 'UTF-8');
                          
                          if (preg_match('/(concierto|musica|música|banda|recital|festival|show|canto|karaoke|dj|tocada)/u', $texto)) {
                              return [
                                  'nombre' => 'Música',
                                  'icon' => 'ri-music-2-line',
                                  'class' => 'cat-musica',
                                  'gradient' => 'linear-gradient(135deg, #ec4899, #8b5cf6)'
                              ];
                          }
                          if (preg_match('/(fiesta|party|rumba|discoteca|cumpleaños|cumple|boda|celebracion|celebración|brindis|social)/u', $texto)) {
                              return [
                                  'nombre' => 'Fiesta',
                                  'icon' => 'ri-cake-3-line',
                                  'class' => 'cat-fiesta',
                                  'gradient' => 'linear-gradient(135deg, #f59e0b, #ef4444)'
                              ];
                          }
                          if (preg_match('/(charla|conferencia|taller|curso|seminario|clase|webinar|educacion|educación|aprender|confe)/u', $texto)) {
                              return [
                                  'nombre' => 'Educación',
                                  'icon' => 'ri-book-open-line',
                                  'class' => 'cat-educacion',
                                  'gradient' => 'linear-gradient(135deg, #3b82f6, #06b6d4)'
                              ];
                          }
                          if (preg_match('/(deporte|partido|torneo|futbol|fútbol|basquet|básquet|maraton|maratón|carrera|gym|entrenamiento|running)/u', $texto)) {
                              return [
                                  'nombre' => 'Deporte',
                                  'icon' => 'ri-football-line',
                                  'class' => 'cat-deporte',
                                  'gradient' => 'linear-gradient(135deg, #10b981, #3b82f6)'
                              ];
                          }
                          if (preg_match('/(exposicion|exposición|museo|arte|teatro|obra|cine|pelicula|película|cultura|cultural)/u', $texto)) {
                              return [
                                  'nombre' => 'Cultura',
                                  'icon' => 'ri-palette-line',
                                  'class' => 'cat-cultura',
                                  'gradient' => 'linear-gradient(135deg, #8b5cf6, #ec4899)'
                              ];
                          }
                          if (preg_match('/(comida|cena|almuerzo|desayuno|gastronomia|gastronomía|restaurante|cafe|café|bebida|tragos|degustacion)/u', $texto)) {
                              return [
                                  'nombre' => 'Comida',
                                  'icon' => 'ri-restaurant-line',
                                  'class' => 'cat-comida',
                                  'gradient' => 'linear-gradient(135deg, #f97316, #eab308)'
                              ];
                          }
                          return [
                              'nombre' => 'General',
                              'icon' => 'ri-sparkling-line',
                              'class' => 'cat-general',
                              'gradient' => 'linear-gradient(135deg, #6b7280, #4b5563)'
                          ];
                      }
                  }

                  // Loop through results
                  while($filas=mysqli_fetch_array($consulta2)){
                      $cat = obtenerCategoriaEvento($filas['nombre'], $filas['descripcion']);
                      
                      // Obtener estado de asistencia del usuario
                      $asistencia_actual = $EventosSociales->ObtenerAsistenciaUsuario($conectarsistema2, $filas['ideventos'], $_SESSION['id_usuario']);
                      
                      // Contar asistencia
                      $count_asistire = $EventosSociales->ContarAsistenciaEvento($conectarsistema2, $filas['ideventos'], 'asistire');
                      $count_talvez = $EventosSociales->ContarAsistenciaEvento($conectarsistema2, $filas['ideventos'], 'talvez');
                      $count_no_asistire = $EventosSociales->ContarAsistenciaEvento($conectarsistema2, $filas['ideventos'], 'no_asistire');

                      // Formatear fechas
                      $meses = ["", "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
                      
                      $t_inicio = strtotime($filas['fechainicio']);
                      $dia_inicio = date("d", $t_inicio);
                      $mes_inicio = $meses[intval(date("m", $t_inicio))];
                      $hora_inicio = date("H:i", $t_inicio);

                      $t_fin = strtotime($filas['fechafin']);
                      $dia_fin = date("d", $t_fin);
                      $mes_fin = $meses[intval(date("m", $t_fin))];
                      $hora_fin = date("H:i", $t_fin);

                      // Generamos una cadena para búsqueda en minúsculas
                      $search_string = htmlspecialchars(mb_strtolower(
                          $filas['nombre'] . ' ' . 
                          $filas['descripcion'] . ' ' . 
                          $filas['direccion'] . ' ' . 
                          $filas['usuario'] . ' ' . 
                          $filas['pais'], 
                          'UTF-8'
                      ));

                      echo '
                      <div class="col-md-6 col-lg-6 mb-4 event-card-col" data-category="' . $cat['nombre'] . '" data-search="' . $search_string . '">
                         <div class="event-card">
                            <div class="event-img-container">
                               <img src="../vista/images/fotoseventos/' . $filas['fotoevento'] . '" alt="event-cover">
                               <div class="event-card-overlay"></div>
                               <span class="badge-category" style="background: ' . $cat['gradient'] . ';">
                                   <i class="' . $cat['icon'] . '"></i> ' . $cat['nombre'] . '
                               </span>
                               <span class="badge-location">
                                   <i class="ri-map-pin-2-line"></i> ' . htmlspecialchars($filas['pais']) . '
                               </span>
                            </div>
                            
                            <div class="event-card-body">
                               <div class="d-flex justify-content-between align-items-start mb-2">
                                  <h4 class="event-title">' . htmlspecialchars($filas['nombre']) . '</h4>';
                                  if($filas['id'] == $_SESSION['id_usuario']){
                                     echo '<a id="eliminareventos" data-id="' . $filas['ideventos'] . '" class="btn-delete-event" title="Eliminar Evento"><i class="ri-delete-bin-7-line"></i></a>';
                                  }
                               echo '</div>
                               
                               <p class="event-desc">' . htmlspecialchars($filas['descripcion']) . '</p>
                               
                               <div class="event-details-box">
                                  <div class="detail-item">
                                     <i class="ri-map-pin-line"></i>
                                     <span><strong>Lugar:</strong> ' . htmlspecialchars($filas['direccion']) . '</span>
                                  </div>
                                  <div class="detail-item">
                                     <i class="ri-calendar-event-line"></i>
                                     <span><strong>Inicio:</strong> ' . $dia_inicio . ' ' . $mes_inicio . ' | ' . $hora_inicio . '</span>
                                  </div>
                                  <div class="detail-item">
                                     <i class="ri-time-line"></i>
                                     <span><strong>Fin:</strong> ' . $dia_fin . ' ' . $mes_fin . ' | ' . $hora_fin . '</span>
                                  </div>
                                </div>

                               <!-- Organizado por -->
                               <div class="event-organizer">
                                   <img src="../vista/images/logo.png" class="organizer-avatar" alt="organizer">
                                   <div class="organizer-text">
                                       Organizado por <strong>@' . htmlspecialchars($filas['usuario']) . '</strong>
                                   </div>
                               </div>

                               <!-- Botones de asistencia Rediseñados -->
                               <div class="mt-auto">
                                  <h6 class="attendance-header">Tu respuesta de asistencia</h6>
                                  <div class="attendance-group attendance-buttons" data-event-id="' . $filas['ideventos'] . '">
                                     <button type="button" class="btn-att att-yes ' . ($asistencia_actual == 'asistire' ? 'active' : '') . '" data-status="asistire">
                                        <i class="ri-checkbox-circle-line"></i> Asistiré <span class="badge badge-success">' . $count_asistire . '</span>
                                     </button>
                                     <button type="button" class="btn-att att-maybe ' . ($asistencia_actual == 'talvez' ? 'active' : '') . '" data-status="talvez">
                                        <i class="ri-question-line"></i> Tal vez <span class="badge badge-warning text-white">' . $count_talvez . '</span>
                                     </button>
                                     <button type="button" class="btn-att att-no ' . ($asistencia_actual == 'no_asistire' ? 'active' : '') . '" data-status="no_asistire">
                                        <i class="ri-close-circle-line"></i> No asistiré <span class="badge badge-danger">' . $count_no_asistire . '</span>
                                     </button>
                                  </div>
                               </div>
                            </div>
                         </div>
                      </div>';
                  }
               ?>
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
      <script src="../vista/js/alerta_eliminar-eventos.js"></script>
      <script src="../vista/js/alerta-solicitudesaceptadas.js"></script>
      <script src="../vista/js/alerta-eliminarsolicitudamistad.js"></script>
   
      <!-- Client side search & filter for events -->
      <script>
      // Loader Failsafe
      $(window).on('load', function() {
          $('#loading').fadeOut('slow');
      });
      $(document).ready(function() {
          function filterEvents() {
              let text = $('#search-eventos').val().toLowerCase().trim();
              let cat = $('.btn-filter.active').data('filter');
              
              $('.event-card-col').each(function() {
                  let card = $(this);
                  let cardText = card.data('search');
                  let cardCat = card.data('category');
                  
                  let textMatch = (text === "" || cardText.indexOf(text) > -1);
                  let catMatch = (cat === "all" || cardCat === cat);
                  
                  if (textMatch && catMatch) {
                      card.fadeIn(300);
                  } else {
                      card.fadeOut(200);
                  }
              });
          }
          
          $('#search-eventos').on('input', filterEvents);
          
          $('.btn-filter').on('click', function() {
              $('.btn-filter').removeClass('active');
              $(this).addClass('active');
              filterEvents();
          });
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