<?php
   $active_page = 'musica';
 
/*
--------------------------------------------------------
║            SECRET - RED SOCIAL PHP NATIVO            ║
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
   if($_SESSION['comprobar_perfil']==0){
      // Deteccion y helpers de fuentes multimedia
      if (!function_exists('getMediaSource')) {
          function getMediaSource($video) {
              $video = trim($video);
              if (stripos($video, 'spotify.com') !== false) {
                  return 'spotify';
              } elseif (stripos($video, 'youtube.com') !== false || stripos($video, 'youtu.be') !== false) {
                  return 'youtube';
              } elseif (stripos($video, 'apple.com') !== false || stripos($video, 'itunes.apple.com') !== false || preg_match('/\.m4a$/i', $video) || preg_match('/\.mp3$/i', $video)) {
                  return 'itunes';
              } else {
                  return 'local';
              }
          }
      }

      if (!function_exists('getYouTubeId')) {
          function getYouTubeId($url) {
              $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i';
              if (preg_match($pattern, $url, $match)) {
                  return $match[1];
              }
              return null;
          }
      }

      if (!function_exists('getSpotifyEmbedUrl')) {
          function getSpotifyEmbedUrl($url) {
              if (stripos($url, '/embed/') !== false) {
                  return $url;
              }
              return str_ireplace('open.spotify.com/', 'open.spotify.com/embed/', $url);
          }
      }
?>
<!doctype html>
<html lang="ES-SV">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Secret - Música & Clips</title>
      <!-- Favicon -->
      <link rel="apple-touch-icon" sizes="180x180" href="../vista/favicon/apple-touch-icon.png">
      <link rel="icon" type="image/png" sizes="32x32" href="../vista/favicon/favicon-32x32.png">
      <link rel="icon" type="image/png" sizes="16x16" href="../vista/favicon/favicon-16x16.png">
      <link rel="manifest" href="../vista/favicon/site.webmanifest">
      
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
      
      <!-- Bootstrap Dropify CSS -->
      <link href="../vista/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css"/>
      
      <!-- Remix Icons -->
      <link href="https://cdn.jsdelivr.net/npm/remixicon@2.2.0/fonts/remixicon.css" rel="stylesheet">
      
      <!-- Alerts -->
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

      <style>
         /* ========================================================
            SPOTIFY/APPLE MUSIC PREMIUM LIGHT/DARK REDESIGN
            ======================================================== */
         body, input, textarea, button, select, label {
             font-family: 'Montserrat', sans-serif !important;
         }
         h1, h2, h3, h4, h5, h6, .card-title {
             font-family: 'Poppins', sans-serif !important;
         }
         
         body {
            background-color: var(--iq-light-secondary) !important;
            color: var(--iq-body-text) !important;
         }
         #content-page {
            background-color: var(--iq-light-secondary) !important;
            padding-bottom: 120px; /* space for player bar */
         }
         .iq-card {
            background-color: var(--iq-white) !important;
            border: 1px solid var(--iq-border-light) !important;
            border-radius: 16px !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03) !important;
         }
         .iq-card h4, .iq-card h5, .iq-card h6 {
            color: var(--iq-title-text) !important;
         }
         
         /* Tab selection */
         .nav-pills-music .nav-link {
            color: var(--iq-body-text);
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 30px;
            transition: all 0.2s;
            background: var(--iq-white);
            margin-right: 10px;
            border: 1px solid var(--iq-border-light);
         }
         .nav-pills-music .nav-link:hover {
            color: var(--iq-primary);
            background: var(--iq-light-primary);
         }
         .nav-pills-music .nav-link.active {
            background: #b92025 !important;
            color: #fff !important;
            border-color: #b92025;
            box-shadow: 0 4px 15px rgba(185,32,37,0.3);
         }

         /* Search Input */
         .search-music-wrap {
            position: relative;
            max-width: 480px;
         }
         .search-music-input {
            width: 100%;
            background: var(--iq-white);
            border: 1.5px solid var(--iq-border-light);
            border-radius: 30px;
            padding: 12px 20px 12px 48px;
            color: var(--iq-body-text);
            font-size: 15px;
            outline: none;
            transition: all 0.2s;
         }
         .search-music-input:focus {
            background: var(--iq-white);
            border-color: #b92025;
            box-shadow: 0 0 0 3px rgba(185,32,37,0.15);
         }
         .search-music-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #71717a;
            font-size: 20px;
         }

         /* Cover header */
         .music-hero {
            background: linear-gradient(135deg, #180303 0%, #30080a 40%, #5c0d12 100%);
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            border: 1px solid rgba(255,255,255,0.05);
         }
         .music-hero::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(185,32,37,0.3);
            border-radius: 50%;
            filter: blur(80px);
            bottom: -100px;
            right: -50px;
            z-index: 1;
         }
         .music-hero-content {
            position: relative;
            z-index: 2;
         }
         .music-hero h2 {
            font-size: 36px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
         }
         .music-hero p {
            color: rgba(255,255,255,0.7);
            font-size: 15px;
            max-width: 600px;
            margin-bottom: 0;
         }

         /* Modal Search Results styling */
         .modal-search-results-container {
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,0.2) transparent;
         }
         .modal-search-results-container::-webkit-scrollbar {
            width: 6px;
         }
         .modal-search-results-container::-webkit-scrollbar-thumb {
            background-color: rgba(255,255,255,0.2);
            border-radius: 3px;
         }
         .modal-search-item {
            display: flex;
            align-items: center;
            background: #2b3035;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
         }
         .modal-search-item:hover {
            background: #3a4148;
            transform: translateY(-2px);
            border-color: rgba(255,255,255,0.25);
         }
         .modal-search-item.selected {
            background: rgba(185, 32, 37, 0.15) !important;
            border-color: #b92025 !important;
            box-shadow: 0 0 10px rgba(185, 32, 37, 0.3);
         }
         .modal-search-item img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 12px;
         }
         .modal-search-item .item-details {
            flex-grow: 1;
            min-width: 0;
         }
         .modal-search-item .item-title {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: #fff;
         }
         .modal-search-item .item-artist {
            font-size: 12px;
            color: #a0aec0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
         }
         .modal-search-item .item-badge {
            margin-left: 8px;
            flex-shrink: 0;
         }

         /* Song / Clip Cards Grid - 5 columnas tipo poster */
         .music-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
            margin-top: 20px;
         }
         @media (max-width: 1400px) { .music-grid { grid-template-columns: repeat(4, 1fr); } }
         @media (max-width: 1100px) { .music-grid { grid-template-columns: repeat(3, 1fr); } }
         @media (max-width: 768px)  { .music-grid { grid-template-columns: repeat(2, 1fr); } }
         @media (max-width: 480px)  { .music-grid { grid-template-columns: repeat(1, 1fr); } }
         .music-card {
            background: var(--iq-white);
            border-radius: 16px;
            padding: 16px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid var(--iq-border-light);
            cursor: pointer;
            position: relative;
            display: flex;
            flex-direction: column;
         }
         .music-card:hover {
            background: var(--iq-light-secondary);
            transform: translateY(-8px);
            border-color: var(--iq-primary);
            box-shadow: 0 12px 30px rgba(0,0,0,0.05);
         }
         .music-card-art {
            position: relative;
            width: 100%;
            aspect-ratio: 1;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 14px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            background: var(--iq-light-secondary);
         }
         .music-card-art img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
         }
         .music-card:hover .music-card-art img {
            transform: scale(1.05);
         }
         .music-card-play {
            position: absolute;
            bottom: 8px;
            right: 8px;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: #b92025;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            opacity: 0;
            transform: translateY(8px);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px rgba(185,32,37,0.5);
         }
         .music-card:hover .music-card-play {
            opacity: 1;
            transform: translateY(0);
         }
         .music-card-play:hover {
            transform: scale(1.1);
            background: #e53935;
         }
         
         .music-card-title {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--iq-title-text);
            margin: 0 0 3px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
         }
         .music-card-artist {
            font-size: 12px;
            color: var(--iq-body-text);
            margin: 0 0 8px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
         }
         .music-card-footer {
            margin-top: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid var(--iq-border-light);
            padding-top: 8px;
            font-size: 11px;
            color: var(--iq-body-text);
         }

         /* Skeleton Loading */
         .skeleton-card {
            background: var(--iq-white);
            border-radius: 16px;
            padding: 12px;
            border: 1px solid var(--iq-border-light);
            animation: skeleton-pulse 1.5s ease-in-out infinite;
         }
         .skeleton-art {
            width: 100%;
            aspect-ratio: 1;
            border-radius: 10px;
            background: linear-gradient(90deg, var(--iq-light-secondary) 25%, rgba(0,0,0,0.04) 50%, var(--iq-light-secondary) 75%);
            background-size: 200% 100%;
            margin-bottom: 10px;
         }
         .skeleton-line {
            height: 12px;
            border-radius: 6px;
            background: linear-gradient(90deg, var(--iq-light-secondary) 25%, rgba(0,0,0,0.04) 50%, var(--iq-light-secondary) 75%);
            background-size: 200% 100%;
            margin-bottom: 6px;
         }
         .skeleton-line.short { width: 60%; }
         @keyframes skeleton-pulse {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
         }
         body.dark-theme .skeleton-card { background: #121214; border-color: rgba(255,255,255,0.03); }
         body.dark-theme .skeleton-art,
         body.dark-theme .skeleton-line {
            background: linear-gradient(90deg, #1c1c1f 25%, #27272a 50%, #1c1c1f 75%);
            background-size: 200% 100%;
         }

         /* Inline player embed in card */
         .music-card-embed {
            display: none;
            width: 100%;
            margin-top: 8px;
            border-radius: 10px;
            overflow: hidden;
         }
         .music-card-embed iframe {
            width: 100%;
            border: none;
            border-radius: 10px;
            display: block;
         }
         .music-card.is-playing .music-card-embed { display: block; }
         .music-card.is-playing .music-card-art { display: none; }

         /* YT badge */
         .badge-youtube { background-color: #ff0000; }

         /* Spotify-Style Fixed Bottom Player Bar */
         #spotify-player-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 90px;
            background: var(--iq-white);
            border-top: 1px solid var(--iq-border-light);
            display: none; /* hidden until song starts */
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            z-index: 10000;
            box-shadow: 0 -8px 40px rgba(0,0,0,0.05);
            backdrop-filter: blur(12px);
         }
         
         /* Left section: Track Info */
         .player-track-info {
            display: flex;
            align-items: center;
            gap: 14px;
            width: 30%;
            min-width: 180px;
         }
         .player-album-art {
            width: 56px;
            height: 56px;
            border-radius: 8px;
            object-fit: cover;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            background: #27272a;
         }
         .player-text {
            min-width: 0;
         }
         .player-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--iq-title-text);
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
         }
         .player-artist {
            font-size: 12px;
            color: var(--iq-body-text);
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
         }
         
         /* Middle section: Controls & Scrubber */
         .player-controls-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 40%;
            max-width: 600px;
         }
         .player-btns {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 6px;
         }
         .player-btn {
            background: none;
            border: none;
            color: var(--iq-body-text);
            font-size: 20px;
            cursor: pointer;
            transition: color 0.2s, transform 0.1s;
         }
         .player-btn:hover {
            color: var(--iq-primary);
         }
         .player-btn-play {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--iq-primary);
            color: #fff;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(185,32,37,0.2);
         }
         .player-btn-play:hover {
            transform: scale(1.05);
            background: #e53935;
            color: #fff;
         }
         
         /* Progress Scrubber */
         .player-progress-container {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
         }
         .player-time {
            font-size: 11px;
            color: var(--iq-body-text);
            min-width: 35px;
         }
         .player-progress-bg {
            flex: 1;
            height: 4px;
            background: var(--iq-border-light);
            border-radius: 2px;
            cursor: pointer;
            position: relative;
         }
         .player-progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #b92025, #e53935);
            border-radius: 2px;
            width: 0%;
            position: relative;
         }
         .player-progress-thumb {
            position: absolute;
            right: -6px;
            top: 50%;
            transform: translateY(-50%);
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--iq-primary);
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            display: none;
         }
         .player-progress-bg:hover .player-progress-thumb {
            display: block;
         }

         /* Right section: volume / video mode toggle */
         .player-extra-controls {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 16px;
            width: 30%;
         }
         .volume-bar-bg {
            width: 90px;
            height: 4px;
            background: var(--iq-border-light);
            border-radius: 2px;
            cursor: pointer;
            position: relative;
         }
         .volume-bar-fill {
            height: 100%;
            background: var(--iq-primary);
            border-radius: 2px;
            width: 80%;
         }

         /* Premium overlay for video playback */
         .video-preview-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.9);
            z-index: 20000;
            display: none;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(15px);
         }
         .video-preview-container {
            width: 90%;
            max-width: 800px;
            background: #000;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
            border: 1px solid rgba(255,255,255,0.1);
            position: relative;
         }
         .video-preview-header {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 10;
         }
         .video-preview-close {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(0,0,0,0.5);
            color: #fff;
            border: none;
            font-size: 22px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
         }
         .video-preview-close:hover {
            background: rgba(185,32,37,0.8);
         }
         
         /* PLATFORM BADGES IN GRID */
         .badge-platform {
            font-size: 11px;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            color: #fff;
         }
         .badge-spotify { background-color: #1ed760; }
         .badge-youtube { background-color: #ff0000; }
         .badge-apple { background-color: #000000; }
         .badge-local { background-color: #6c757d; }

         /* ========================================================
            DARK THEME OVERRIDES
            ======================================================== */
         body.dark-theme {
            background-color: #09090b !important;
            color: #f4f4f5 !important;
         }
         body.dark-theme #content-page {
            background-color: #09090b !important;
         }
         body.dark-theme .iq-card {
            background-color: #121214 !important;
            border-color: rgba(255,255,255,0.03) !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3) !important;
         }
         body.dark-theme .iq-card h4, body.dark-theme .iq-card h5, body.dark-theme .iq-card h6 {
            color: #fff !important;
         }
         body.dark-theme .nav-pills-music .nav-link {
            color: #a1a1aa;
            background: rgba(255,255,255,0.03);
            border-color: rgba(255,255,255,0.05);
         }
         body.dark-theme .nav-pills-music .nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,0.08);
         }
         body.dark-theme .search-music-input {
            background: #18181b;
            border-color: rgba(255,255,255,0.08);
            color: #fff;
         }
         body.dark-theme .search-music-input:focus {
            background: #202024;
         }
         body.dark-theme .music-card {
            background: #121214;
            border-color: rgba(255,255,255,0.03);
         }
         body.dark-theme .music-card:hover {
            background: #1c1c1f;
            border-color: rgba(255,255,255,0.08);
            box-shadow: 0 12px 30px rgba(0,0,0,0.4);
         }
         body.dark-theme .music-card-art {
            background: #1d1d21;
         }
         body.dark-theme .music-card-title {
            color: #fff;
         }
         body.dark-theme .music-card-artist {
            color: #a1a1aa;
         }
         body.dark-theme .music-card-footer {
            border-top-color: rgba(255,255,255,0.05);
            color: #a1a1aa;
         }
         body.dark-theme #spotify-player-bar {
            background: #0f0f11;
            border-top-color: rgba(255,255,255,0.05);
            box-shadow: 0 -8px 40px rgba(0,0,0,0.6);
         }
         body.dark-theme .player-title {
            color: #fff;
         }
         body.dark-theme .player-artist {
            color: #a1a1aa;
         }
         body.dark-theme .player-btn {
            color: #a1a1aa;
         }
         body.dark-theme .player-btn-play {
            background: #fff;
            color: #000;
            box-shadow: 0 4px 10px rgba(255,255,255,0.1);
         }
         body.dark-theme .player-btn-play:hover {
            color: #b92025;
            background: #fff;
         }
         body.dark-theme .player-progress-bg {
            background: rgba(255,255,255,0.1);
         }
         body.dark-theme .player-progress-thumb {
            background: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.3);
         }
         body.dark-theme .volume-bar-bg {
            background: rgba(255,255,255,0.1);
         }
         body.dark-theme .volume-bar-fill {
            background: #fff;
         }
         body.dark-theme .badge-apple {
            background-color: #ffffff;
            color: #000000;
         }
      </style>
   </head>
   <body class="right-column-fixed">
      <!-- loader Start -->
      <div id="loading">
         <div id="loading-center"></div>
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
         
         <!-- Page Content  -->
         <div id="content-page" class="content-page">
            <div class="container-fluid">
               
               <!-- Hero Area -->
               <div class="music-hero">
                  <div class="music-hero-content">
                     <h2>Música & Clips Favoritos</h2>
                     <p>Escucha los fragmentos de canciones del momento de iTunes o mira y comparte clips de vídeo de la comunidad.</p>
                     <div class="d-flex mt-4 gap-2">
                        <button type="button" class="btn shadow-sm" style="background:#b92025; color:#fff; border-radius:30px; font-weight:700; padding:10px 24px;" data-toggle="modal" data-target="#exampleModalCenter"><i class="las la-file-video mr-1"></i> Compartir Clip</button>
                     </div>
                  </div>
               </div>

               <!-- Filters & Search Unificado YT + iTunes -->
               <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
                  <ul class="nav nav-pills nav-pills-music m-0" id="music-tabs" role="tablist">
                     <li class="nav-item">
                        <a class="nav-link active" id="clips-tab" data-toggle="pill" href="#tab-clips" role="tab">Clips de la Comunidad</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" id="buscar-tab" data-toggle="pill" href="#tab-buscar" role="tab">🔍 Buscar Música</a>
                     </li>
                  </ul>
                  
                  <!-- Filter by type buttons -->
                  <div class="d-flex gap-2 align-items-center" id="media-type-filters-container">
                     <span class="text-muted mr-2 font-weight-bold" style="font-size:12px;">Filtrar:</span>
                     <button class="btn btn-sm btn-outline-danger btn-media-filter active" data-type="all">Todo</button>
                     <button class="btn btn-sm btn-outline-danger btn-media-filter" data-type="audio">🎧 Solo Audio</button>
                     <button class="btn btn-sm btn-outline-danger btn-media-filter" data-type="video">📺 Solo Video</button>
                         <!-- Barra de búsqueda iTunes (visible en tab buscar) -->
                  <div class="search-music-wrap d-none w-100 mt-2" id="search-bar-container" style="max-width:100%;">
                     <div class="search-music-wrap" style="max-width:600px;">
                        <i class="ri-search-2-line search-music-icon"></i>
                        <input type="text" id="unified-music-search" class="search-music-input" placeholder="Busca cualquier artista o canción en iTunes...">
                     </div>
                  </div>
                     </div>
                  </div>
               </div>

               <!-- Tab Content -->
               <div class="tab-content" id="music-tabContent">
                  
                  <!-- Tab: Local Clips -->
                  <div class="tab-pane fade show active" id="tab-clips" role="tabpanel">
                     <div class="music-grid" id="clips-grid">
                         <?php 
                           if(mysqli_num_rows($consulta2) == 0) {
                               echo '<div style="grid-column:1/-1;" class="text-center py-5"><p class="text-muted">Aún no se han compartido clips de vídeo o audio.</p></div>';
                           } else {
                               while($filas=mysqli_fetch_array($consulta2)){
                                   $videoRaw = $filas['video'];
                                   $sourceType = getMediaSource($videoRaw);
                                   
                                   if ($sourceType === 'spotify') {
                                       $mediaType = 'audio';
                                       $platformClass = 'badge-spotify';
                                       $platformName = 'Spotify';
                                       $platformIcon = 'ri-spotify-fill';
                                       $poster = '../vista/images/logo.png';
                                       $playSrc = getSpotifyEmbedUrl($videoRaw);
                                   } elseif ($sourceType === 'youtube') {
                                       $mediaType = 'video';
                                       $platformClass = 'badge-youtube';
                                       $platformName = 'YouTube';
                                       $platformIcon = 'ri-youtube-fill';
                                       $ytId = getYouTubeId($videoRaw);
                                       $poster = $ytId ? "https://img.youtube.com/vi/{$ytId}/hqdefault.jpg" : '../vista/multimedia/videos/PosterVideos.png';
                                       $playSrc = $ytId ? "https://www.youtube.com/embed/{$ytId}?autoplay=1" : $videoRaw;
                                   } elseif ($sourceType === 'itunes') {
                                        $mediaType = 'audio';
                                        $platformClass = 'badge-apple';
                                        $platformName = 'iTunes';
                                        $platformIcon = 'ri-apple-fill';
                                        
                                        $parts = explode('|', $videoRaw);
                                        $playSrc = $parts[0];
                                        $poster = (count($parts) > 1 && !empty($parts[1])) ? $parts[1] : '../vista/multimedia/videos/PosterVideos.png';
                                   } else {
                                       $mediaType = 'video';
                                       $platformClass = 'badge-local';
                                       $platformName = 'Local';
                                       $platformIcon = 'ri-file-video-fill';
                                       $poster = '../vista/multimedia/videos/PosterVideos.png';
                                       $playSrc = '../vista/multimedia/videos/' . $videoRaw;
                                   }
                                   $isIframe = in_array($sourceType, ['youtube','spotify']);
                         ?>
                                   <div class="music-card" 
                                        data-src="<?php echo htmlspecialchars($playSrc); ?>" 
                                        data-title="<?php echo htmlspecialchars($filas['titulo_video']); ?>" 
                                        data-author="<?php echo htmlspecialchars($filas['nombres'] . ' ' . $filas['apellidos']); ?>"
                                        data-platform="<?php echo $sourceType; ?>"
                                        data-media-type="<?php echo $mediaType; ?>"
                                        data-is-iframe="<?php echo $isIframe ? '1' : '0'; ?>"
                                        data-img="<?php echo $poster; ?>">
                                      <div class="music-card-art">
                                         <img src="<?php echo $poster; ?>" alt="cover art" loading="lazy">
                                         <div class="music-card-play">
                                            <i class="ri-play-fill"></i>
                                         </div>
                                      </div>
                                      <!-- Inline embed player -->
                                      <div class="music-card-embed">
                                         <?php if($isIframe): ?>
                                         <iframe src="" data-src="<?php echo htmlspecialchars($playSrc); ?>" height="<?php echo $sourceType==='youtube'?'200':'152'; ?>" allowfullscreen allow="autoplay; encrypted-media"></iframe>
                                         <?php elseif($sourceType === 'local'): ?>
                                         <audio controls autoplay style="width:100%; border-radius:8px;"><source src="<?php echo htmlspecialchars($playSrc); ?>"></audio>
                                         <?php endif; ?>
                                      </div>
                                      <h6 class="music-card-title mt-2"><?php echo htmlspecialchars($filas['titulo_video']); ?></h6>
                                      <p class="music-card-artist">Subido por: <?php echo htmlspecialchars($filas['nombres'] . ' ' . $filas['apellidos']); ?></p>
                                      <div class="music-card-footer">
                                         <span class="badge-platform <?php echo $platformClass; ?>">
                                            <i class="<?php echo $platformIcon; ?>"></i> <?php echo $platformName; ?>
                                         </span>
                                         <?php if($filas['id']==$_SESSION['id_usuario']): ?>
                                            <a id="borrarvideo" data-id="<?php echo $filas['idvideos']; ?>" class="text-danger" style="cursor: pointer;" title="Eliminar Clip"><i class="las la-trash-alt" style="font-size:16px;"></i></a>
                                         <?php endif; ?>
                                      </div>
                                   </div>
                         <?php 
                               }
                           }
                         ?>
                     </div>
                      
                      <!-- Paginación Premium -->
                      <?php if (isset($totalPaginas) && $totalPaginas > 1): ?>
                      <div class="d-flex justify-content-center mt-5">
                          <nav aria-label="Navegación de música">
                              <ul class="pagination pagination-rounded justify-content-center" style="gap: 6px; display: flex; list-style: none; padding: 0;">
                                  <?php if ($pagina > 1): ?>
                                      <li class="page-item">
                                          <a class="page-link" href="?publicaciones=multimedia-secretvideos&pagina=<?php echo ($pagina - 1); ?>" style="border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background: var(--iq-white); color: #b92025; border: 1px solid var(--iq-border-light); font-weight: 600;"><i class="ri-arrow-left-s-line"></i></a>
                                      </li>
                                  <?php endif; ?>
                                  <?php
                                  $rango = 2;
                                  $inicio_rango = max(1, $pagina - $rango);
                                  $fin_rango = min($totalPaginas, $pagina + $rango);
                                  for ($i = $inicio_rango; $i <= $fin_rango; $i++) {
                                      $active_style = ($i === $pagina) ? 'background: #b92025; color: #fff; border-color: #b92025;' : 'background: var(--iq-white); color: #b92025; border: 1px solid var(--iq-border-light);';
                                      echo '<li class="page-item ' . ($i === $pagina ? 'active' : '') . '"><a class="page-link" href="?publicaciones=multimedia-secretvideos&pagina=' . $i . '" style="border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; font-weight: 600; ' . $active_style . '">' . $i . '</a></li>';
                                  }
                                  ?>
                                  <?php if ($pagina < $totalPaginas): ?>
                                      <li class="page-item">
                                          <a class="page-link" href="?publicaciones=multimedia-secretvideos&pagina=<?php echo ($pagina + 1); ?>" style="border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background: var(--iq-white); color: #b92025; border: 1px solid var(--iq-border-light); font-weight: 600;"><i class="ri-arrow-right-s-line"></i></a>
                                      </li>
                                  <?php endif; ?>
                              </ul>
                          </nav>
                      </div>
                      <?php endif; ?>
                  </div>
                  
                  <!-- Tab: Búsqueda Unificada YT + iTunes -->
                  <div class="tab-pane fade" id="tab-buscar" role="tabpanel">
                     <!-- Grid de resultados con skeleton -->
                     <div class="music-grid" id="search-music-grid">
                        <div style="grid-column:1/-1;" class="text-center py-5">
                           <i class="ri-search-line" style="font-size:48px; opacity:0.2;"></i>
                           <p class="text-muted mt-2">Usa la barra de búsqueda para encontrar cualquier canción o video</p>
                        </div>
                     </div>
                  </div>

               </div>

            </div>
         </div>
      </div>
      <!-- Wrapper END -->

      <!-- FIXED BOTTOM PLAYER BAR (Spotify Style) -->
      <div id="spotify-player-bar">
         <!-- Left: Cover + Song details -->
         <div class="player-track-info">
            <img class="player-album-art" id="player-art-img" src="../vista/multimedia/videos/PosterVideos.png" alt="Album Art">
            <div class="player-text">
               <h6 class="player-title" id="player-track-title">Ninguna reproducción activa</h6>
               <p class="player-artist" id="player-track-artist">Elige una canción</p>
            </div>
         </div>
         
         <!-- Middle: Playback controls -->
         <div class="player-controls-wrap">
            <div class="player-btns">
               <button class="player-btn" id="player-prev-btn"><i class="ri-skip-back-fill"></i></button>
               <button class="player-btn player-btn-play" id="player-toggle-btn"><i class="ri-play-fill" style="margin-left:2px;"></i></button>
               <button class="player-btn" id="player-next-btn"><i class="ri-skip-forward-fill"></i></button>
            </div>
            <div class="player-progress-container">
               <span class="player-time" id="player-current-time">0:00</span>
               <div class="player-progress-bg" id="player-progress-track">
                  <div class="player-progress-fill" id="player-progress-bar">
                     <div class="player-progress-thumb"></div>
                  </div>
               </div>
               <span class="player-time" id="player-total-time">0:00</span>
            </div>
         </div>
         
         <!-- Right: Volume controls -->
         <div class="player-extra-controls">
            <i class="ri-volume-up-fill text-muted" id="player-volume-icon" style="font-size:16px;"></i>
            <div class="volume-bar-bg" id="volume-track">
               <div class="volume-bar-fill" id="volume-bar"></div>
            </div>
         </div>
      </div>

      <!-- PREMIUM OVERLAY VIDEO PLAYER (For Local MP4 clips, YouTube, and Spotify) -->
      <div class="video-preview-overlay" id="video-overlay">
         <div class="video-preview-container">
            <div class="video-preview-header">
               <button class="video-preview-close" id="btn-close-video-overlay"><i class="ri-close-line"></i></button>
            </div>
            <div id="media-player-container" style="width:100%; background:#000;">
               <video id="global-video-player" controls autoplay style="width:100%; display:block; outline:none; max-height:80vh;"></video>
            </div>
         </div>
      </div>

      <!-- Hidden Global Audio Player for iTunes Streaming -->
      <audio id="global-itunes-audio"></audio>

      <!-- Video Upload Modal (Premium Dynamic Search Picker) -->
      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
              <div class="modal-content" style="border-radius:16px; border:none; overflow:hidden;">
                  <div class="modal-header bg-dark border-0 p-3">
                      <h5 class="modal-title text-white" id="exampleModalCenterTitle">Compartir Nueva Música o Clip</h5>
                      <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body bg-dark text-white p-4">
                      <form id="videos" class="needs-validation" novalidate method="POST" autocomplete="off">
                          <!-- Hidden form inputs populated dynamically via JS -->
                          <input type="hidden" id="tipo_fuente" name="tipo_fuente" value="">
                          <input type="hidden" id="video_url" name="video_url" value="">
                          
                          <!-- Modal Search Input -->
                          <div class="form-group mb-3">
                              <label class="form-label font-weight-bold text-white">Buscar Canción en iTunes:</label>
                              <div class="search-music-wrap w-100" style="max-width: 100%; position: relative;">
                                  <i class="ri-search-2-line search-music-icon"></i>
                                  <input type="text" id="modal-music-search-input" class="search-music-input" placeholder="Escribe el nombre del artista o canción..." style="background:#2b3035; color:#fff; border:1px solid rgba(255,255,255,0.15); border-radius:30px; padding-left:45px; height:46px;">
                              </div>
                          </div>

                          <!-- Scrollable Search Results Area -->
                          <div id="modal-search-results" class="modal-search-results-container mb-3" style="max-height: 280px; overflow-y: auto; display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; padding: 4px; border-radius: 8px; background: rgba(0,0,0,0.2);">
                              <div style="grid-column: 1/-1;" class="text-center py-4 text-muted">
                                  <i class="ri-search-line" style="font-size:36px; opacity:0.2;"></i>
                                  <p class="mt-2 mb-0" style="font-size:13px;">Escribe arriba para buscar música...</p>
                              </div>
                          </div>

                          <!-- Selected Track Preview Banner -->
                          <div id="modal-selected-banner" class="d-none mb-3 p-3" style="background: rgba(40, 167, 69, 0.1); border: 1.5px solid #28a745; border-radius: 12px; display: flex; align-items: center; gap: 12px;">
                              <img id="modal-selected-img" src="" style="width: 50px; height: 50px; border-radius: 8px; object-fit: cover;">
                              <div style="flex-grow: 1; min-width: 0;">
                                  <h6 class="text-white mb-1" id="modal-selected-title" style="font-size: 14px; font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"></h6>
                                  <p class="text-muted mb-0" id="modal-selected-artist" style="font-size: 12px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"></p>
                              </div>
                              <span id="modal-selected-badge" class="badge-platform"></span>
                          </div>

                          <!-- Editable Title Field (Appears only when a track is selected) -->
                          <div class="form-group mb-4 d-none" id="modal-title-container">
                              <label for="titulo" class="form-label font-weight-bold text-white">Título de la publicación (puedes editarlo):</label>
                              <input type="text" class="form-control text-white bg-secondary border-0" id="titulo" name="titulo_video" placeholder="Ingrese el título..." required style="border-radius:8px; height:46px;">
                              <div class="invalid-tooltip">Por favor completa el título.</div>
                          </div>

                          <!-- Share Button -->
                          <button type="submit" id="btn-modal-submit" class="btn w-100 font-weight-bold disabled" style="background:#555; color:#aaa; border-radius:8px; padding:12px; cursor: not-allowed;" disabled><i class="las la-film"></i> Compartir Clip</button>
                      </form>   
                  </div>
              </div>
          </div>
      </div>

      <!-- Footer -->
      <footer class="bg-white iq-footer">
         <div class="container-fluid">
            <div class="row">
               <div class="col-lg-6">
                  <ul class="list-inline mb-0">
                     <li class="list-inline-item"><a href="../Secret/privacidad-condiciones">Términos y Condiciones de Uso</a></li>
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
      <script src="../vista/js/jquery.min.js"></script>
      <script src="../vista/js/popper.min.js"></script>
      <script src="../vista/js/bootstrap.min.js"></script>
      <script src="../vista/js/jquery.appear.js"></script>
      <script src="../vista/js/countdown.min.js"></script>
      <script src="../vista/js/waypoints.min.js"></script>
      <script src="../vista/js/jquery.counterup.min.js"></script>
      <script src="../vista/js/wow.min.js"></script>
      <script src="../vista/js/apexcharts.js"></script>
      <script src="../vista/js/slick.min.js"></script>
      <script src="../vista/js/select2.min.js"></script>
      <script src="../vista/js/owl.carousel.min.js"></script>
      <script src="../vista/js/jquery.magnific-popup.min.js"></script>
      <script src="../vista/js/smooth-scrollbar.js"></script>
      <script src="../vista/js/lottie.js"></script>
      <script src="../vista/js/chart-custom.js"></script>
      <script src="../vista/js/custom.js"></script>
      <script src="../vista/dropify/dist/js/dropify.min.js"></script>
      
      <!-- Alerts -->
      <script src="../vista/js/alerta_videos.js"></script>
      <script src="../vista/js/alerta_eliminarvideos.js"></script>
      <script src="../vista/js/alerta-solicitudesaceptadas.js"></script>
      <script src="../vista/js/alerta-eliminarsolicitudamistad.js"></script>
      <script src="../vista/js/floating_chat.js"></script>

      <script>
         $(document).ready(function() {
            // Global player state (declared at top for scope availability)
            let activeTrackType = null; // 'local', 'itunes', 'video-iframe'
            let audioPlayer = document.getElementById('global-itunes-audio');
            let videoPlayer = document.getElementById('global-video-player');
            if (audioPlayer) audioPlayer.volume = 0.8;
            if (videoPlayer) videoPlayer.volume = 0.8;

            // Toggle URL input placeholder based on selected platform
            $('#tipo_fuente').change(function() {
               let val = $(this).val();
               let placeholder = 'Pegue la URL aquí...';
               if (val === 'youtube') {
                  placeholder = 'https://www.youtube.com/watch?v=...';
               } else if (val === 'spotify') {
                  placeholder = 'https://open.spotify.com/track/...';
               } else if (val === 'itunes') {
                  placeholder = 'https://music.apple.com/...';
               }
               $('#video_url').attr('placeholder', placeholder);
            }).trigger('change');

             // =======================================================
             // TAB SWITCHING: show/hide search bar and filters
             // =======================================================
             $('#music-tabs a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
                if ($(e.target).attr('href') === '#tab-buscar') {
                   $('#search-bar-container').removeClass('d-none');
                   $('#media-type-filters-container').addClass('d-none');
                } else {
                   $('#search-bar-container').addClass('d-none');
                   $('#media-type-filters-container').removeClass('d-none');
                }
             });

             // Media Type Filters (clips tab)
             $('.btn-media-filter').click(function() {
                $('.btn-media-filter').removeClass('active');
                $(this).addClass('active');
                let type = $(this).data('type');
                if (type === 'all') {
                   $('#clips-grid .music-card').fadeIn(300);
                } else {
                   $('#clips-grid .music-card').each(function() {
                      let card = $(this);
                      card.data('media-type') === type ? card.fadeIn(300) : card.fadeOut(200);
                   });
                }
             });

             // Click on local clips cards (play inline)
             $(document).on('click', '#clips-grid .music-card', function() {
                let $card = $(this);
                let isIframe = $card.data('is-iframe') == '1';
                let platform = $card.data('platform');
                let src = $card.data('src');
                let title = $card.data('title');
                let author = $card.data('author');
                let img = $card.data('img');

                // If already playing — toggle off
                if ($card.hasClass('is-playing')) {
                   $card.removeClass('is-playing');
                   $card.find('iframe').attr('src', ''); // stop iframe
                   return;
                }
                // Close others
                $('#clips-grid .music-card.is-playing').removeClass('is-playing').find('iframe').attr('src', '');

                if (isIframe) {
                   // activate iframe embed
                   $card.addClass('is-playing');
                   $card.find('.music-card-embed iframe').attr('src', src);
                } else if (platform === 'itunes') {
                   // play in bottom bar audio player
                   let audioPlayer = document.getElementById('global-itunes-audio');
                   audioPlayer.src = src;
                   audioPlayer.play();
                   activeTrackType = 'itunes';
                   $('#player-track-title').text(title);
                   $('#player-track-artist').text(author);
                   $('#player-art-img').attr('src', img);
                   $('#spotify-player-bar').addClass('active').fadeIn();
                   $('#player-toggle-btn').html('<i class="ri-pause-fill"></i>');
                } else {
                   // local video: show overlay
                   $('#media-player-container').html('<video id="global-video-player" controls autoplay style="width:100%; display:block; outline:none; max-height:80vh;"></video>');
                   let newVid = document.getElementById('global-video-player');
                   newVid.src = src;
                   newVid.volume = 0.8;
                   newVid.play();
                   $('#video-overlay').fadeIn(300).css('display','flex');
                   $('#player-track-title').text(title);
                   $('#player-track-artist').text(author);
                   $('#player-art-img').attr('src', img);
                   $('#spotify-player-bar').addClass('active').fadeIn();
                   $('#player-toggle-btn').html('<i class="ri-pause-fill"></i>');
                   activeTrackType = 'local';
                }
             });

             // ============================================================
             // MODAL DYNAMIC MUSIC SEARCH & SELECTION PICKER
             // ============================================================
             let modalSearchTimer = null;
             let currentModalSearchQuery = '';

             // Reset modal state when it's closed/opened
             $('#exampleModalCenter').on('show.bs.modal', function () {
                $('#modal-music-search-input').val('');
                resetModalSearchGrid();
                $('#modal-selected-banner').addClass('d-none');
                $('#modal-title-container').addClass('d-none');
                $('#titulo').val('').removeAttr('required');
                $('#tipo_fuente').val('');
                $('#video_url').val('');
                $('#btn-modal-submit').addClass('disabled').attr('disabled', true).css({
                   'background': '#555',
                   'color': '#aaa',
                   'cursor': 'not-allowed'
                });
             });

             // Modal search input handler
             $('#modal-music-search-input').on('keyup', function() {
                let q = $(this).val().trim();
                currentModalSearchQuery = q;
                clearTimeout(modalSearchTimer);
                if (q.length > 2) {
                   showSkeletons('#modal-search-results', 6);
                   modalSearchTimer = setTimeout(function() { performModalSearch(q); }, 500);
                } else if (q.length === 0) {
                   resetModalSearchGrid();
                }
             });

             function resetModalSearchGrid() {
                $('#modal-search-results').html('<div style="grid-column:1/-1;" class="text-center py-4 text-muted"><i class="ri-search-line" style="font-size:36px;opacity:0.2;"></i><p class="mt-2 mb-0" style="font-size:13px;">Escribe arriba para buscar música...</p></div>');
             }

             function performModalSearch(q) {
                fetchItunes(q).then(function(results) {
                   if (results.length === 0) {
                      $('#modal-search-results').html('<div style="grid-column:1/-1;" class="text-center py-4 text-muted"><p class="mb-0" style="font-size:13px;">No se encontraron resultados para "' + escapeHtml(q) + '"</p></div>');
                      return;
                   }
                   renderModalSearchResults(results);
                }).catch(function() {
                   $('#modal-search-results').html('<div style="grid-column:1/-1;" class="text-center py-4 text-danger"><p class="mb-0" style="font-size:13px;">Error al buscar. Inténtalo de nuevo.</p></div>');
                });
             }

             function renderModalSearchResults(results) {
                let html = '';
                let activeUrl = $('#video_url').val();
                results.forEach(function(item) {
                   let platformIcon = 'ri-apple-fill';
                   let platformClass = 'badge-apple';
                   let rawUrl = item.src + '|' + item.img; // Save both preview URL and artwork URL separated by '|'
                   let isSelected = activeUrl === rawUrl;
                   
                   html += `<div class="modal-search-item ${isSelected ? 'selected' : ''}" 
                                 data-type="itunes" 
                                 data-url="${escapeAttr(rawUrl)}" 
                                 data-title="${escapeAttr(item.title)}" 
                                 data-artist="${escapeAttr(item.artist)}" 
                                 data-img="${escapeAttr(item.img)}">
                      <img src="${escapeAttr(item.img)}" alt="${escapeHtml(item.title)}" onerror="this.src='../vista/images/logo.png'">
                      <div class="item-details">
                         <div class="item-title">${escapeHtml(item.title)}</div>
                         <div class="item-artist">${escapeHtml(item.artist)}</div>
                      </div>
                      <div class="item-badge">
                         <span class="badge-platform ${platformClass}"><i class="${platformIcon}"></i> iTunes</span>
                      </div>
                   </div>`;
                });
                $('#modal-search-results').html(html);
             }

             // Handle dynamic search item selection in modal
             $(document).on('click', '.modal-search-item', function() {
                let $item = $(this);
                
                $('.modal-search-item').removeClass('selected');
                $item.addClass('selected');
                
                let type = $item.data('type');
                let url = $item.data('url');
                let title = $item.data('title');
                let artist = $item.data('artist');
                let img = $item.data('img');
                
                // Populate form fields
                $('#tipo_fuente').val(type);
                $('#video_url').val(url);
                
                let combinedTitle = title;
                if (artist) {
                   combinedTitle += ' - ' + artist;
                }
                $('#titulo').val(combinedTitle).attr('required', true);
                
                // Show title input container with smooth animation
                $('#modal-title-container').removeClass('d-none').hide().fadeIn(300);
                
                // Update & Show Selected Preview Banner
                $('#modal-selected-img').attr('src', img);
                $('#modal-selected-title').text(title);
                $('#modal-selected-artist').text(artist || 'Artista desconocido');
                
                let badgeClass = 'badge-apple';
                let badgeIcon = 'ri-apple-fill';
                let badgeText = 'iTunes';
                
                $('#modal-selected-badge').attr('class', 'badge-platform ' + badgeClass)
                                           .html(`<i class="${badgeIcon}"></i> ${badgeText}`);
                
                $('#modal-selected-banner').removeClass('d-none').hide().fadeIn(300);
                
                // Enable Submit Button
                $('#btn-modal-submit').removeClass('disabled').removeAttr('disabled').css({
                   'background': '#b92025',
                   'color': '#fff',
                   'cursor': 'pointer'
                });
             });

             // ============================================================
             // BÚSQUEDA UNIFICADA: iTunes
             // ============================================================
             let searchTimer = null;
             let currentSearchQuery = '';

             // Search input handler
             $('#unified-music-search').on('keyup', function() {
                let q = $(this).val().trim();
                currentSearchQuery = q;
                clearTimeout(searchTimer);
                if (q.length > 2) {
                   searchTimer = setTimeout(function() { performSearch(q); }, 500);
                } else if (q.length === 0) {
                   resetSearchGrid();
                }
             });

             function showSkeletons(container, count) {
                let html = '';
                for (let i = 0; i < count; i++) {
                   html += `<div class="skeleton-card">
                      <div class="skeleton-art"></div>
                      <div class="skeleton-line"></div>
                      <div class="skeleton-line short"></div>
                   </div>`;
                }
                $(container).html(html);
             }

             function resetSearchGrid() {
                $('#search-music-grid').html('<div style="grid-column:1/-1;" class="text-center py-5"><i class="ri-search-line" style="font-size:48px;opacity:0.2;"></i><p class="text-muted mt-2">Usa la barra de búsqueda para encontrar cualquier canción</p></div>');
             }

             function performSearch(q) {
                showSkeletons('#search-music-grid', 10);
                fetchItunes(q).then(function(results) {
                   if (results.length === 0) {
                      $('#search-music-grid').html('<div style="grid-column:1/-1;" class="text-center py-5"><p class="text-muted">No se encontraron resultados para "' + escapeHtml(q) + '"</p></div>');
                      return;
                   }
                   renderSearchResults(results);
                }).catch(function() {
                   $('#search-music-grid').html('<div style="grid-column:1/-1;" class="text-center py-5"><p class="text-danger">Error al buscar. Inténtalo de nuevo.</p></div>');
                });
             }

             function fetchItunes(q) {
                 return new Promise(function(resolve) {
                    $.ajax({
                       url: '../controlador/cNotasMusica.php?accion=buscar_itunes&q=' + encodeURIComponent(q),
                       type: 'GET',
                       dataType: 'json'
                    }).done(function(res) {
                       let tracks = [];
                       if (res && res.results) {
                          res.results.forEach(function(t) {
                             if (!t.previewUrl) return;
                             tracks.push({
                                type: 'itunes',
                                title: t.trackName || t.collectionName || '',
                                artist: t.artistName || '',
                                img: (t.artworkUrl100 || '').replace('100x100', '300x300'),
                                src: t.previewUrl,
                                duration: t.trackTimeMillis ? Math.round(t.trackTimeMillis/1000) + 's' : '30s',
                                badge: '<span class="badge-platform badge-apple"><i class="ri-apple-fill"></i> iTunes</span>'
                             });
                          });
                       }
                       resolve(tracks);
                    }).fail(function() {
                       resolve([]);
                    });
                 });
              }

              function renderSearchResults(results) {
                 let html = '';
                 results.forEach(function(item, idx) {
                    // Insert skeleton batch placeholder every 20 items
                    if (idx > 0 && idx % 20 === 0) {
                       html += `<div style="grid-column:1/-1;" class="py-1"></div>`;
                    }
                    html += `<div class="music-card search-result-card" data-type="itunes" data-src="${escapeAttr(item.src)}" data-title="${escapeAttr(item.title)}" data-artist="${escapeAttr(item.artist)}" data-img="${escapeAttr(item.img)}">
                       <div class="music-card-art">
                          <img src="${escapeAttr(item.img)}" alt="${escapeHtml(item.title)}" loading="lazy" onerror="this.src='../vista/images/logo.png'">
                          <div class="music-card-play"><i class="ri-play-fill"></i></div>
                       </div>
                       <div class="music-card-embed">
                          <!-- Native controls removed to avoid layout distortion and autoplay issues -->
                       </div>
                       <h6 class="music-card-title mt-2">${escapeHtml(item.title)}</h6>
                       <p class="music-card-artist">${escapeHtml(item.artist)}</p>
                       <div class="music-card-footer">${item.badge}</div>
                    </div>`;
                 });
                 $('#search-music-grid').html(html);
              }

              // Click on search result cards (stream to bottom player bar)
              $(document).on('click', '.search-result-card', function(e) {
                 let $card = $(this);
                 let src = $card.data('src');
                 let title = $card.data('title');
                 let artist = $card.data('artist');
                 let img = $card.data('img');

                 // Stop any active video
                 let videoPlayer = document.getElementById('global-video-player');
                 if (videoPlayer && typeof videoPlayer.pause === 'function') videoPlayer.pause();
                 $('#video-overlay').hide();
                 $('#media-player-container').html('');

                 // Stream in bottom player bar
                 let audioPlayer = document.getElementById('global-itunes-audio');
                 activeTrackType = 'itunes';
                 audioPlayer.src = src;
                 audioPlayer.play();

                 // Update bottom bar UI
                 $('#player-track-title').text(title);
                 $('#player-track-artist').text(artist);
                 $('#player-art-img').attr('src', img);
                 $('#spotify-player-bar').addClass('active').fadeIn();
                 $('#player-toggle-btn').html('<i class="ri-pause-fill"></i>');
              });

             // ============================================
             // OLD ITUNES SEARCH (kept for compat)
             // ============================================
             let _itunesLegacyTimer = null;
             $('#itunes-music-search').on('keyup', function() {
                let q = $(this).val().trim();
                clearTimeout(_itunesLegacyTimer);
                if (q.length > 2) {
                   $('#itunes-music-grid').html('<div class="text-center py-5 w-100" style="grid-column:1/-1;"><div class="spinner-border text-danger" role="status"></div><p class="text-muted mt-2">Buscando canciones...</p></div>');
                   _itunesLegacyTimer = setTimeout(function() {
                       $.get('../controlador/cNotasMusica.php?accion=buscar_itunes&q=' + encodeURIComponent(q), function(res) {
                         let data = typeof res === 'string' ? JSON.parse(res) : res;
                         if (!data.results || data.results.length === 0) {
                            $('#itunes-music-grid').html('<div class="text-center py-5 w-100" style="grid-column:1/-1;"><p class="text-muted">No se encontraron resultados</p></div>');
                            return;
                         }
                         let html = '';
                         data.results.forEach(track => {
                            let img = track.artworkUrl100 || '../vista/multimedia/videos/PosterVideos.png';
                            let preview = track.previewUrl || '';
                            if(!preview) return; // Skip tracks without preview
                            
                            html += `
                               <div class="music-card play-itunes-btn" data-src="${preview}" data-title="${escapeAttr(track.trackName)}" data-artist="${escapeAttr(track.artistName)}" data-img="${img}" data-media-type="audio">
                                  <div class="music-card-art">
                                     <img src="${img}" alt="album art">
                                     <div class="music-card-play">
                                        <i class="ri-play-fill"></i>
                                     </div>
                                  </div>
                                  <h6 class="music-card-title">${escapeHtml(track.trackName)}</h6>
                                  <p class="music-card-artist">${escapeHtml(track.artistName)}</p>
                                  <div class="music-card-footer" style="padding-top:6px;">
                                     <span class="badge-platform badge-apple">
                                        <i class="ri-apple-fill"></i> iTunes
                                     </span>
                                  </div>
                               </div>
                            `;
                         });
                         $('#itunes-music-grid').html(html);
                      }).fail(function() {
                         $('#itunes-music-grid').html('<div class="text-center py-5 w-100" style="grid-column:1/-1;"><p class="text-danger">Error al buscar canciones. Inténtalo de nuevo.</p></div>');
                      });
                  }, 500);
               } else if (q.length === 0) {
                  $('#itunes-music-grid').html(`
                     <div class="text-center py-5 w-100" style="grid-column: 1/-1;">
                        <i class="ri-music-2-fill text-muted" style="font-size:40px; opacity:0.3;"></i>
                        <p class="text-muted mt-2">Busca arriba cualquier artista o canción para escucharla.</p>
                     </div>
                  `);
               }
            });

            // ============================================
            // DYNAMIC PLAYER CONTROLS (Spotify Style)
            // ============================================
            audioPlayer = document.getElementById('global-itunes-audio');
            videoPlayer = document.getElementById('global-video-player');
            activeTrackType = null; // 'local', 'itunes', 'video-iframe'
            
            // Volume control (80% default)
            audioPlayer.volume = 0.8;
            videoPlayer.volume = 0.8;

            // Clicking any media card (Local, Spotify, YouTube, iTunes):
            $(document).on('click', '.play-any-media-btn', function() {
               let src = $(this).data('src');
               let title = $(this).data('title');
               let author = $(this).data('author');
               let platform = $(this).data('platform');
               let mediaType = $(this).data('media-type');
               let img = $(this).data('img');

               // Stop any active players first
               audioPlayer.pause();
               if (videoPlayer) videoPlayer.pause();
               $('#video-overlay').hide();
               $('#media-player-container').html(''); // empty container
               $('#player-toggle-btn').html('<i class="ri-play-fill" style="margin-left:2px;"></i>');

               if (platform === 'youtube') {
                  activeTrackType = 'video-iframe';
                  let ytId = getYouTubeId(src);
                  let embedHtml = `<iframe src="https://www.youtube.com/embed/${ytId}?autoplay=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="width:100%; height:450px; display:block; border:none;"></iframe>`;
                  $('#media-player-container').html(embedHtml);
                  $('#video-overlay').fadeIn(300).css('display','flex');
                  
                  // Update bottom bar info
                  $('#player-track-title').text(title);
                  $('#player-track-artist').text(author);
                  $('#player-art-img').attr('src', img);
                  $('#spotify-player-bar').addClass('active').fadeIn();
                  $('#player-toggle-btn').html('<i class="ri-pause-fill"></i>');
               } else if (platform === 'spotify') {
                  activeTrackType = 'video-iframe';
                  let embedUrl = getSpotifyEmbedUrl(src);
                  let embedHtml = `<iframe src="${embedUrl}" width="100%" height="350" frameborder="0" allowtransparency="true" allow="encrypted-media" style="border:none; display:block;"></iframe>`;
                  $('#media-player-container').html(embedHtml);
                  $('#video-overlay').fadeIn(300).css('display','flex');
                  
                  // Update bottom bar info
                  $('#player-track-title').text(title);
                  $('#player-track-artist').text(author);
                  $('#player-art-img').attr('src', img);
                  $('#spotify-player-bar').addClass('active').fadeIn();
                  $('#player-toggle-btn').html('<i class="ri-pause-fill"></i>');
               } else if (platform === 'itunes') {
                  activeTrackType = 'itunes';
                  audioPlayer.src = src;
                  audioPlayer.play();

                  // Update bottom bar UI
                  $('#player-track-title').text(title);
                  $('#player-track-artist').text(author);
                  $('#player-art-img').attr('src', img);
                  $('#spotify-player-bar').addClass('active').fadeIn();
                  $('#player-toggle-btn').html('<i class="ri-pause-fill"></i>');
               } else { // local clip
                  activeTrackType = 'local';
                  let videoHtml = `<video id="global-video-player" controls autoplay style="width:100%; display:block; outline:none; max-height:80vh;"></video>`;
                  $('#media-player-container').html(videoHtml);
                  
                  // Need to re-bind events or get the newly injected video element
                  let newVideoPlayer = document.getElementById('global-video-player');
                  newVideoPlayer.volume = audioPlayer.volume;
                  newVideoPlayer.src = src;
                  newVideoPlayer.addEventListener('timeupdate', function() {
                     if (activeTrackType === 'local' && newVideoPlayer.duration) {
                        updateProgressBar(newVideoPlayer.currentTime, newVideoPlayer.duration);
                     }
                  });
                  newVideoPlayer.addEventListener('ended', function() {
                     $('#player-toggle-btn').html('<i class="ri-play-fill" style="margin-left:2px;"></i>');
                     $('#player-progress-bar').css('width', '0%');
                     $('#player-current-time').text('0:00');
                  });
                  videoPlayer = newVideoPlayer; // update reference
                  
                  $('#video-overlay').fadeIn(300).css('display','flex');
                  newVideoPlayer.play();

                  // Update bottom bar info
                  $('#player-track-title').text(title);
                  $('#player-track-artist').text(author);
                  $('#player-art-img').attr('src', img);
                  $('#spotify-player-bar').addClass('active').fadeIn();
                  $('#player-toggle-btn').html('<i class="ri-pause-fill"></i>');
               }
            });

            // Close video overlay
            $('#btn-close-video-overlay, .video-preview-overlay').click(function(e) {
               if(e.target !== this && e.target.id !== 'btn-close-video-overlay' && !$(e.target).hasClass('ri-close-line')) return;
               if (videoPlayer && typeof videoPlayer.pause === 'function') videoPlayer.pause();
               $('#video-overlay').fadeOut(200);
               $('#media-player-container').html('');
               $('#spotify-player-bar').removeClass('active').fadeOut();
            });

            // Clicking iTunes track card: Stream in bottom player bar
            $(document).on('click', '.play-itunes-btn', function() {
               let src = $(this).data('src');
               let title = $(this).data('title');
               let artist = $(this).data('artist');
               let img = $(this).data('img');

               // Stop any active video
               if (videoPlayer && typeof videoPlayer.pause === 'function') videoPlayer.pause();
               $('#video-overlay').hide();
               $('#media-player-container').html('');

               activeTrackType = 'itunes';
               audioPlayer.src = src;
               audioPlayer.play();

               // Update bottom bar UI
               $('#player-track-title').text(title);
               $('#player-track-artist').text(artist);
               $('#player-art-img').attr('src', img);
               $('#spotify-player-bar').addClass('active').fadeIn();
               $('#player-toggle-btn').html('<i class="ri-pause-fill"></i>');
            });

            // Play/Pause button in bottom player bar
            $('#player-toggle-btn').click(function(e) {
               e.stopPropagation();
               if (activeTrackType === 'itunes') {
                  if (audioPlayer.paused) {
                     audioPlayer.play();
                     $(this).html('<i class="ri-pause-fill"></i>');
                  } else {
                     audioPlayer.pause();
                     $(this).html('<i class="ri-play-fill" style="margin-left:2px;"></i>');
                  }
               } else if (activeTrackType === 'local') {
                  if (videoPlayer.paused) {
                     videoPlayer.play();
                     $(this).html('<i class="ri-pause-fill"></i>');
                  } else {
                     videoPlayer.pause();
                     $(this).html('<i class="ri-play-fill" style="margin-left:2px;"></i>');
                  }
               }
            });

            // Audio Player Progress Updates
            audioPlayer.addEventListener('timeupdate', function() {
               if (activeTrackType === 'itunes' && audioPlayer.duration) {
                  updateProgressBar(audioPlayer.currentTime, audioPlayer.duration);
               }
            });
            audioPlayer.addEventListener('ended', function() {
               $('#player-toggle-btn').html('<i class="ri-play-fill" style="margin-left:2px;"></i>');
               $('#player-progress-bar').css('width', '0%');
               $('#player-current-time').text('0:00');
            });

            function updateProgressBar(current, duration) {
               let pct = (current / duration) * 100;
               $('#player-progress-bar').css('width', pct + '%');
               
               let curMin = Math.floor(current / 60);
               let curSec = Math.floor(current % 60);
               $('#player-current-time').text(curMin + ':' + (curSec < 10 ? '0' + curSec : curSec));
               
               let durMin = Math.floor(duration / 60);
               let durSec = Math.floor(duration % 60);
               $('#player-total-time').text(durMin + ':' + (durSec < 10 ? '0' + durSec : durSec));
            }

            // Click progress track to seek
            $('#player-progress-track').click(function(e) {
               let track = $(this);
               let clickX = e.pageX - track.offset().left;
               let width = track.width();
               let pct = clickX / width;
               
               if (activeTrackType === 'itunes' && audioPlayer.duration) {
                  audioPlayer.currentTime = pct * audioPlayer.duration;
               } else if (activeTrackType === 'local' && videoPlayer.duration) {
                  videoPlayer.currentTime = pct * videoPlayer.duration;
               }
            });

            // Volume bar click logic
            $('#volume-track').click(function(e) {
               let track = $(this);
               let clickX = e.pageX - track.offset().left;
               let width = track.width();
               let vol = clickX / width;
               
               vol = Math.max(0, Math.min(1, vol));
               $('#volume-bar').css('width', (vol * 100) + '%');
               
               audioPlayer.volume = vol;
               if (videoPlayer) videoPlayer.volume = vol;

               let icon = $('#player-volume-icon');
               if (vol === 0) {
                  icon.attr('class', 'ri-volume-mute-fill text-muted');
               } else if (vol < 0.5) {
                  icon.attr('class', 'ri-volume-down-fill text-muted');
               } else {
                  icon.attr('class', 'ri-volume-up-fill text-muted');
               }
            });

            // Helper escape functions
            function escapeHtml(text) {
               return $('<div>').text(text || '').html();
            }
            function escapeAttr(text) {
               return (text || '').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
            }

            // Helper to get YouTube ID
            function getYouTubeId(url) {
               let regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
               let match = url.match(regExp);
               return (match && match[2].length === 11) ? match[2] : null;
            }

            function getSpotifyEmbedUrl(url) {
               if (url.includes('/embed/')) return url;
               return url.replace('open.spotify.com/', 'open.spotify.com/embed/');
            }
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