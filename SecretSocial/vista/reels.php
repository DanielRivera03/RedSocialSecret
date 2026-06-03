<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params(0, '/');
    session_start();
}
// NO PERMITIR INGRESO DIRECTO SIN INICIAR SESION
if(!isset($_SESSION['nombre_usuario'])){
    header('location:../AccesoDenegado=restringido');
    exit();
}

$postMax = ini_get('post_max_size');
$uploadMax = ini_get('upload_max_filesize');

function toBytes($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    $val = (int)$val;
    switch($last) {
        case 'g': $val *= 1024;
        case 'm': $val *= 1024;
        case 'k': $val *= 1024;
    }
    return $val;
}

$maxLimitBytes = min(toBytes($postMax), toBytes($uploadMax));
if ($maxLimitBytes <= 0) {
    $maxLimitBytes = 40 * 1024 * 1024; // 40MB fallback
}
$maxLimitMB = round($maxLimitBytes / (1024 * 1024), 1);
?>
<!doctype html>
<html lang="es">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Secret - Reels</title>
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

          /* Reels layout */
          .reels-container {
              display: flex;
              flex-direction: column;
              align-items: center;
              width: 100%;
              max-width: 480px;
              margin: 0 auto;
              height: calc(100vh - 120px);
              overflow-y: scroll;
              scroll-snap-type: y mandatory;
              scrollbar-width: none; /* Hide scrollbar Firefox */
              -ms-overflow-style: none;  /* Hide scrollbar IE/Edge */
              border-radius: 20px;
              box-shadow: 0 10px 30px rgba(0,0,0,0.1);
              background: #000;
          }
          .reels-container::-webkit-scrollbar {
              display: none; /* Hide scrollbar Chrome/Safari */
          }

          .reel-card {
              position: relative;
              width: 100%;
              height: 100%;
              min-height: calc(100vh - 120px);
              scroll-snap-align: start;
              scroll-snap-stop: always;
              display: flex;
              align-items: center;
              justify-content: center;
              background: #000;
              overflow: hidden;
          }

          .reel-video-wrapper {
              position: relative;
              width: 100%;
              height: 100%;
              display: flex;
              align-items: center;
              justify-content: center;
          }

          .reel-video {
              width: 100%;
              height: 100%;
              object-fit: cover;
              cursor: pointer;
          }

          /* Overlay details */
          .reel-overlay {
              position: absolute;
              bottom: 0;
              left: 0;
              right: 0;
              padding: 24px;
              background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 60%, transparent 100%);
              color: #fff;
              z-index: 10;
              display: flex;
              flex-direction: column;
              gap: 8px;
              pointer-events: none;
          }

          .reel-author {
              display: flex;
              align-items: center;
              gap: 12px;
              pointer-events: auto;
          }

          .reel-author-img {
              width: 40px;
              height: 40px;
              border-radius: 50%;
              object-fit: cover;
              border: 2px solid #fff;
          }

          .reel-author-name {
              font-weight: 700;
              font-size: 14px;
              text-shadow: 0 1px 3px rgba(0,0,0,0.5);
              color: #fff !important;
          }

          .reel-title {
              font-size: 13.5px;
              line-height: 1.4;
              text-shadow: 0 1px 2px rgba(0,0,0,0.5);
              margin: 4px 0 0 0;
          }

          /* Right side actions */
          .reel-actions {
              position: absolute;
              right: 16px;
              bottom: 80px;
              display: flex;
              flex-direction: column;
              align-items: center;
              gap: 20px;
              z-index: 12;
          }

          .reel-action-btn {
              background: rgba(0, 0, 0, 0.4);
              border: 1px solid rgba(255, 255, 255, 0.15);
              backdrop-filter: blur(8px);
              width: 48px;
              height: 48px;
              border-radius: 50%;
              display: flex;
              align-items: center;
              justify-content: center;
              color: #fff;
              cursor: pointer;
              transition: all 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
              box-shadow: 0 4px 10px rgba(0,0,0,0.3);
          }

          .reel-action-btn:hover {
              transform: scale(1.1);
              background: rgba(0, 0, 0, 0.6);
          }

          .reel-action-btn i {
              font-size: 20px;
          }

          .reel-action-btn.liked {
              color: #ff304f;
              border-color: rgba(255, 48, 79, 0.3);
              background: rgba(255, 48, 79, 0.15);
          }

          .reel-action-label {
              font-size: 11px;
              font-weight: 700;
              color: #fff;
              text-shadow: 0 1px 4px rgba(0,0,0,0.6);
              margin-top: -15px;
          }

          /* Floating heart pop animation */
          .floating-heart {
              position: absolute;
              color: #ff304f;
              font-size: 80px;
              opacity: 0;
              z-index: 15;
              pointer-events: none;
              transform: scale(0);
              animation: heartPop 0.8s ease-in-out forwards;
              filter: drop-shadow(0 4px 15px rgba(255, 48, 79, 0.4));
          }

          @keyframes heartPop {
              0% { transform: scale(0); opacity: 0; }
              15% { transform: scale(1.2); opacity: 0.9; }
              30% { transform: scale(1); opacity: 1; }
              80% { transform: scale(0.9) translateY(-15px); opacity: 0.8; }
              100% { transform: scale(0.7) translateY(-30px); opacity: 0; }
          }

          /* Play/Pause overlay */
          .play-pause-overlay {
              position: absolute;
              top: 50%;
              left: 50%;
              transform: translate(-50%, -50%) scale(0.8);
              background: rgba(0, 0, 0, 0.6);
              color: #fff;
              border-radius: 50%;
              width: 70px;
              height: 70px;
              display: flex;
              align-items: center;
              justify-content: center;
              font-size: 35px;
              opacity: 0;
              pointer-events: none;
              transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
              z-index: 15;
          }
          .play-pause-overlay.show {
              opacity: 1;
              transform: translate(-50%, -50%) scale(1.1);
          }

          /* Volume Alert Overlay */
          .volume-alert {
              position: absolute;
              top: 20px;
              right: 20px;
              background: rgba(0, 0, 0, 0.7);
              color: #fff;
              padding: 6px 12px;
              border-radius: 12px;
              font-size: 12px;
              font-weight: 600;
              opacity: 0;
              transition: opacity 0.3s ease;
              pointer-events: none;
              z-index: 15;
          }
          .volume-alert.show {
              opacity: 1;
          }

          /* Custom Upload Modal styling */
          .premium-modal .modal-content {
              border-radius: 20px;
              border: none;
              background: var(--iq-white);
              box-shadow: 0 15px 40px rgba(0,0,0,0.15);
          }
          body.dark-theme .premium-modal .modal-content {
              background: var(--iq-dark-card-bg);
              color: #fff;
          }

          /* Upload button */
          .btn-upload-reel-trigger {
              position: fixed;
              right: 30px;
              bottom: 30px;
              z-index: 999;
              box-shadow: 0 8px 25px rgba(191, 23, 23, 0.4);
          }

          .custom-file-upload {
              border: 2px dashed rgba(191, 23, 23, 0.3);
              border-radius: 15px;
              padding: 30px;
              text-align: center;
              cursor: pointer;
              background: rgba(191, 23, 23, 0.02);
              transition: all 0.25s ease;
          }
          .custom-file-upload:hover {
              background: rgba(191, 23, 23, 0.05);
              border-color: rgba(191, 23, 23, 0.6);
          }
          .custom-file-upload i {
              font-size: 40px;
              color: var(--iq-primary);
          }
      </style>
   </head>
   <body class="right-column-fixed">
      <!-- loader Start -->
      <div id="loading">
         <div id="loading-center">
         </div>
      </div>
      <!-- loader END -->
      <!-- Wrapper Start -->
      <div class="wrapper">
         
         <?php include __DIR__ . '/premium_sidebar.php'; ?>
         
         <!-- TOP Nav Bar -->
         <?php include __DIR__ . '/premium_topnav.php'; ?>
         <!-- TOP Nav Bar END -->

         <!-- Page Content  -->
         <div id="content-page" class="content-page">
            <div class="container d-flex flex-column align-items-center justify-content-center">
               
               <!-- Vertical Reels Snapping Container -->
               <div class="reels-container" id="reels-feed">
                   <!-- Carga dinámica por AJAX -->
               </div>

            </div>
         </div>
      </div>
      <!-- Wrapper END -->

      <!-- Floating action button: Subir Reel -->
      <button class="btn btn-primary rounded-circle p-0 d-flex align-items-center justify-content-center btn-upload-reel-trigger" style="width: 56px; height: 56px;" data-toggle="modal" data-target="#upload-reel-modal" title="Subir nuevo Reel">
          <i class="ri-add-line" style="font-size:28px;"></i>
      </button>

      <!-- Modal Subir Reel -->
      <div class="modal fade premium-modal" id="upload-reel-modal" tabindex="-1" role="dialog" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" style="font-weight:700;"><i class="ri-video-add-line text-primary"></i> Subir Secret Reel</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <form id="form-upload-reel" enctype="multipart/form-data">
                      <div class="form-group">
                          <label>Título / Descripción del Reel *</label>
                          <input type="text" name="titulo" class="form-control" placeholder="Escribe un título llamativo..." required>
                      </div>
                      <div class="form-group">
                          <label>Vídeo Vertical (MP4 o WebM) *</label>
                          <label class="custom-file-upload d-block">
                              <i class="ri-upload-cloud-2-line"></i>
                              <span id="file-upload-label" class="d-block mt-2 font-weight-600 text-muted">Selecciona tu vídeo vertical</span>
                              <input type="file" name="video_file" id="reel-file-input" class="d-none" accept="video/mp4,video/webm" required>
                          </label>
                      </div>
                      <button type="submit" class="btn btn-primary w-100 rounded-pill btn-lg mt-3" id="btn-submit-upload"><i class="ri-checkbox-circle-line"></i> Publicar Reel</button>
                  </form>
               </div>
            </div>
         </div>
      </div>

      <script src="../vista/js/jquery.min.js"></script>
      <script src="../vista/js/popper.min.js"></script>
      <script src="../vista/js/bootstrap.min.js"></script>
      <script src="../vista/js/custom.js"></script>

      <script>
          $(document).ready(function() {
              let activeVideo = null;
              let isMuted = true; // Start muted by default to allow autoplay in modern browsers

              // Handle file upload preview label
              $('#reel-file-input').on('change', function() {
                  let filename = $(this).val().split('\\').pop();
                  if (filename) {
                      $('#file-upload-label').text(filename).css('color', 'var(--iq-primary)');
                  } else {
                      $('#file-upload-label').text('Selecciona tu vídeo vertical').css('color', '');
                  }
              });

              // Load Reels AJAX
              function loadReels() {
                  $.ajax({
                      url: '../controlador/cPublicacionesUsuarios.php?publicaciones=listar-reels',
                      type: 'GET',
                      success: function(res) {
                          let reels = res;
                          if (typeof res === 'string') {
                              try {
                                  let jsonStart = res.indexOf('[');
                                  if (jsonStart !== -1) {
                                      reels = JSON.parse(res.substring(jsonStart));
                                  } else {
                                      reels = [];
                                  }
                              } catch (e) {
                                  reels = [];
                              }
                          }

                          if (!Array.isArray(reels)) {
                              reels = [];
                          }

                          let html = '';
                          reels.forEach(r => {
                              let likedClass = r.liked == 1 ? 'liked' : '';
                              let heartIcon = r.liked == 1 ? '<i class="ri-heart-fill"></i>' : '<i class="ri-heart-line"></i>';
                              let muteIcon = isMuted ? 'ri-volume-mute-fill' : 'ri-volume-up-fill';
                              
                              html += `
                              <div class="reel-card" data-id="${r.idvideos}">
                                  <div class="reel-video-wrapper">
                                      <video class="reel-video" loop playsinline ${isMuted ? 'muted' : ''} preload="metadata">
                                          <source src="../vista/multimedia/reels/${r.video}" type="video/mp4">
                                          Tu navegador no soporta reproducción de vídeos.
                                      </video>
                                      
                                      <div class="volume-alert">Silenciado</div>
                                      <div class="play-pause-overlay"><i class="ri-play-fill"></i></div>
                                      
                                      <div class="reel-overlay">
                                          <a href="../Perfiles/${r.usuario}=${r.id}" class="reel-author">
                                              <img src="../vista/images/fotosperfiles/${r.fotoperfil}" class="reel-author-img">
                                              <span class="reel-author-name">${r.nombres} ${r.apellidos}</span>
                                          </a>
                                          <p class="reel-title">${r.titulo_video}</p>
                                      </div>

                                      <div class="reel-actions">
                                          <div class="reel-action-btn ${likedClass}" onclick="likeReel(event, ${r.idvideos}, this)">
                                              ${heartIcon}
                                          </div>
                                          <span class="reel-action-label count-likes">${r.total_likes}</span>

                                          <div class="reel-action-btn mt-3 btn-mute-toggle" onclick="toggleMuteReel(event)">
                                              <i class="${muteIcon}"></i>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              `;
                          });

                          if (reels.length === 0) {
                              html = `
                              <div class="w-100 text-center text-white py-5 d-flex flex-column align-items-center justify-content-center" style="height:100%;">
                                  <i class="ri-video-line" style="font-size: 55px; opacity:0.4; margin-bottom:10px;"></i>
                                  <h5 class="text-muted">No hay Reels subidos aún</h5>
                                  <p class="text-muted font-size-12">¡Sé el primero en compartir un Reel!</p>
                              </div>
                              `;
                          }

                          $('#reels-feed').html(html);

                          // Set up IntersectionObserver for Scroll Autoplay
                          setupIntersectionObserver();
                      }
                  });
              }

              // Set up IntersectionObserver
              function setupIntersectionObserver() {
                  const observerOptions = {
                      root: document.getElementById('reels-feed'),
                      rootMargin: '0px',
                      threshold: 0.6 // 60% of the video card must be visible
                  };

                  const observer = new IntersectionObserver((entries) => {
                      entries.forEach(entry => {
                          const video = entry.target.querySelector('video');
                          if (video) {
                              if (entry.isIntersecting) {
                                  video.play().then(() => {
                                      // If autoplay succeeded, hide play overlay
                                  }).catch(e => {
                                      console.log("Autoplay block:", e);
                                  });
                                  activeVideo = video;
                              } else {
                                  video.pause();
                              }
                          }
                      });
                  }, observerOptions);

                  document.querySelectorAll('.reel-card').forEach(card => {
                      observer.observe(card);
                  });
              }

              // Double-tap/click to like and single-click to toggle play/pause
              $(document).on('click', '.reel-video', function(e) {
                  const video = this;
                  const wrapper = $(this).parent();
                  const card = $(this).closest('.reel-card');
                  const id = card.data('id');

                  // Double-click/tap detection
                  let clickTimer = $(video).data('click-timer');
                  if (clickTimer) {
                      clearTimeout(clickTimer);
                      $(video).data('click-timer', null);
                      
                      // Double-click action (Like)
                      triggerDoubleTapLike(id, wrapper, card);
                  } else {
                      // Set single click timer
                      let timer = setTimeout(function() {
                          $(video).data('click-timer', null);
                          
                          // Single click action (Play/Pause)
                          togglePlayPause(video);
                      }, 250);
                      $(video).data('click-timer', timer);
                  }
              });

              function togglePlayPause(video) {
                  const wrapper = $(video).parent();
                  const playOverlay = wrapper.find('.play-pause-overlay');
                  
                  if (video.paused) {
                      video.play().then(() => {
                          playOverlay.html('<i class="ri-play-fill"></i>').addClass('show');
                          setTimeout(() => playOverlay.removeClass('show'), 500);
                      }).catch(err => {
                          console.log("Play failed:", err);
                      });
                  } else {
                      video.pause();
                      playOverlay.html('<i class="ri-pause-fill"></i>').addClass('show');
                      setTimeout(() => playOverlay.removeClass('show'), 500);
                  }
              }

              // Global mute toggle
              window.toggleMuteReel = function(event) {
                  if (event) {
                      event.stopPropagation();
                  }
                  isMuted = !isMuted;
                  document.querySelectorAll('.reel-video').forEach(video => {
                      video.muted = isMuted;
                  });
                  
                  document.querySelectorAll('.btn-mute-toggle i').forEach(icon => {
                      $(icon).attr('class', isMuted ? 'ri-volume-mute-fill' : 'ri-volume-up-fill');
                  });

                  if (activeVideo) {
                      const activeCard = $(activeVideo).closest('.reel-card');
                      const alertEl = activeCard.find('.volume-alert');
                      alertEl.text(isMuted ? 'Silenciado 🔇' : 'Sonido Activado 🔊');
                      alertEl.addClass('show');
                      setTimeout(() => {
                          alertEl.removeClass('show');
                      }, 800);
                  }
              };

              // Double click heart pop animation
              function triggerDoubleTapLike(id, wrapper, card) {
                  const heart = $('<i class="ri-heart-fill floating-heart"></i>');
                  wrapper.append(heart);
                  
                  setTimeout(() => {
                      heart.remove();
                  }, 800);

                  const likeBtn = card.find('.reel-action-btn').first();
                  if (!likeBtn.hasClass('liked')) {
                      likeReel(null, id, likeBtn[0]);
                  }
              }

              // Global like toggle
              window.likeReel = function(event, id, btnEl) {
                  if (event) {
                      event.stopPropagation();
                  }

                  const btn = $(btnEl);
                  const countLabel = btn.next('.count-likes');
                  
                  $.ajax({
                      url: '../controlador/cPublicacionesUsuarios.php?publicaciones=reaccion-reel',
                      type: 'POST',
                      data: { id_video: id },
                      success: function(res) {
                          if (res.status === 'OK') {
                              if (res.liked === 1) {
                                  btn.addClass('liked').html('<i class="ri-heart-fill"></i>');
                              } else {
                                  btn.removeClass('liked').html('<i class="ri-heart-line"></i>');
                              }
                              countLabel.text(res.total);
                          }
                      }
                  });
              };

              // Submit upload Reel form
              $('#form-upload-reel').submit(function(e) {
                  e.preventDefault();
                  
                  const maxLimitBytes = <?php echo $maxLimitBytes; ?>;
                  const maxLimitMB = <?php echo $maxLimitMB; ?>;
                  
                  let fileInput = document.getElementById('reel-file-input');
                  if (fileInput.files && fileInput.files[0]) {
                      let fileSize = fileInput.files[0].size;
                      if (fileSize > maxLimitBytes) {
                          Swal.fire({
                              title: 'Video demasiado grande',
                              text: 'El tamaño de este video es de ' + (fileSize / (1024 * 1024)).toFixed(1) + 'MB, lo cual supera el límite máximo permitido de ' + maxLimitMB + 'MB. Por favor, sube un video más corto o comprimido.',
                              icon: 'warning',
                              confirmButtonColor: '#bf1717'
                          });
                          return;
                      }
                  }
                  
                  let formData = new FormData(this);
                  let submitBtn = $('#btn-submit-upload');
                  submitBtn.prop('disabled', true).html('<i class="ri-loader-4-line rotate"></i> Subiendo...');

                  $.ajax({
                      url: '../controlador/cPublicacionesUsuarios.php?publicaciones=registro-reel',
                      type: 'POST',
                      data: formData,
                      contentType: false,
                      processData: false,
                      success: function(res) {
                          submitBtn.prop('disabled', false).html('<i class="ri-checkbox-circle-line"></i> Publicar Reel');
                          
                          let data = res;
                          if (typeof res === 'string') {
                              if (res.includes('exceeds the limit') || (res.includes('Warning') && res.includes('limit'))) {
                                  data = { error: 'LIMITE_EXCEDIDO' };
                              } else {
                                  let jsonStart = res.indexOf('{');
                                  if (jsonStart !== -1) {
                                      try {
                                          data = JSON.parse(res.substring(jsonStart));
                                      } catch (e) {
                                          data = { error: 'UNKNOWN' };
                                      }
                                  } else {
                                      data = { error: 'UNKNOWN' };
                                  }
                              }
                          }
                          
                          if (data.status === 'OK') {
                              $('#upload-reel-modal').modal('hide');
                              $('#form-upload-reel')[0].reset();
                              $('#file-upload-label').text('Selecciona tu vídeo vertical').css('color', '');
                              
                              Swal.fire({
                                  title: '¡Subido con éxito!',
                                  text: 'Tu nuevo Reel ya está publicado.',
                                  icon: 'success',
                                  confirmButtonColor: '#bf1717'
                              }).then(() => {
                                  loadReels();
                              });
                           } else {
                               let msg = 'No se pudo subir el reel.';
                               if (data.error === 'LIMITE_EXCEDIDO') {
                                   msg = 'El archivo supera el límite de subida configurado en el servidor (' + maxLimitMB + 'MB).';
                               } else if (data.error === 'FORMATO_INVALIDO') {
                                   msg = 'El formato del video es inválido. Solo se admiten archivos MP4 o WebM.';
                               } else if (data.error === 'CAMPOS_VACIOS') {
                                   msg = 'Por favor, completa todos los campos requeridos.';
                               } else if (data.error === 'ERROR_UPLOAD') {
                                   msg = 'Ocurrió un error al cargar el archivo. Asegúrate de que el archivo no esté dañado y esté bajo el límite de tamaño.';
                               }
                               Swal.fire('Error', msg, 'error');
                           }
                      },
                      error: function() {
                          submitBtn.prop('disabled', false).html('<i class="ri-checkbox-circle-line"></i> Publicar Reel');
                          Swal.fire('Error', 'Ha ocurrido un error en la conexión.', 'error');
                      }
                  });
              });

              // Initial load
              loadReels();
          });
      </script>
   </body>
</html>