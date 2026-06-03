<?php
   $active_page = 'mensajes';
 
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
     if($_GET['publicaciones']!="mensajeria-secret"){
        header('location:../AccesoDenegado=restringido');
     }
    // INCLUIR ARCHIVO CONTADOR DE PUBLICACIONES 
   require('../modelo/mConteoPublicacionesPerfilPropietario.php');
?>
<?php
   if($_SESSION['comprobar_perfil']==0){
?>
<!doctype html>
<html lang="ES-SV">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Secret — Mensajes</title>
      <meta name="description" content="Chat y mensajería privada en Secret Red Social">
      <link rel="apple-touch-icon" sizes="180x180" href="../vista/favicon/apple-touch-icon.png">
      <link rel="icon" type="image/png" sizes="32x32" href="../vista/favicon/favicon-32x32.png">
      <link rel="icon" type="image/png" sizes="16x16" href="../vista/favicon/favicon-16x16.png">
      <link rel="manifest" href="../vista/favicon/site.webmanifest">
      <!-- Google Fonts -->
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
      <!-- Remix Icons -->
      <link href="https://cdn.jsdelivr.net/npm/remixicon@2.2.0/fonts/remixicon.css" rel="stylesheet">
      <!-- SweetAlert2 -->
      <script src="../vista/js/notificaciones-premium.js"></script>

      <style>
        /* =====================================================
           MENSAJERÍA ESTILO MESSENGER — SECRET SOCIAL
        ===================================================== */
        * { font-family: 'Inter', sans-serif; box-sizing: border-box; }

        .messenger-wrapper {
          display: flex;
          height: calc(100vh - 110px);
          background: #f0f2f5;
          border-radius: 12px;
          overflow: hidden;
          box-shadow: 0 4px 30px rgba(0,0,0,0.12);
          margin-top: 15px;
          margin-bottom: 0;
        }

        /* ---- PANEL IZQUIERDO ---- */
        .messenger-sidebar {
          width: 340px;
          min-width: 340px;
          background: #fff;
          display: flex;
          flex-direction: column;
          border-right: 1px solid #e4e6eb;
        }

        .messenger-sidebar-header {
          padding: 20px 16px 12px;
          border-bottom: 1px solid #e4e6eb;
        }
        .messenger-sidebar-header h2 {
          font-size: 22px; font-weight: 700; color: #1c1e21; margin: 0 0 14px;
        }
        .messenger-search {
          position: relative;
        }
        .messenger-search input {
          width: 100%; background: #f0f2f5; border: none; border-radius: 20px;
          padding: 8px 16px 8px 38px; font-size: 14px; color: #1c1e21; outline: none;
          transition: background 0.2s;
        }
        .messenger-search input:focus { background: #e4e6eb; }
        .messenger-search i {
          position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
          color: #65676b; font-size: 16px;
        }

        .messenger-tabs {
          display: flex; gap: 4px; padding: 8px 12px;
          border-bottom: 1px solid #e4e6eb;
        }
        .messenger-tab {
          flex: 1; text-align: center; padding: 6px; border-radius: 8px;
          cursor: pointer; font-size: 13px; font-weight: 600; color: #65676b;
          transition: all 0.2s;
        }
        .messenger-tab.active { background: #e7f3ff; color: #1877f2; }
        .messenger-tab:hover:not(.active) { background: #f0f2f5; }

        .messenger-conv-list {
          flex: 1; overflow-y: auto; padding: 8px 0;
        }
        .messenger-conv-list::-webkit-scrollbar { width: 4px; }
        .messenger-conv-list::-webkit-scrollbar-thumb { background: #ccc; border-radius: 4px; }

        .conv-item {
          display: flex; align-items: center; gap: 12px;
          padding: 10px 16px; cursor: pointer; border-radius: 8px; margin: 2px 8px;
          transition: background 0.15s; position: relative;
        }
        .conv-item:hover { background: #f0f2f5; }
        .conv-item.active { background: #e7f3ff; }

        .conv-avatar-wrap { position: relative; flex-shrink: 0; }
        .conv-avatar {
          width: 52px; height: 52px; border-radius: 50%; object-fit: cover;
          border: 2px solid #e4e6eb;
        }
        .conv-online-dot {
          position: absolute; bottom: 2px; right: 2px;
          width: 12px; height: 12px; border-radius: 50%;
          border: 2px solid #fff; background: #42b72a;
        }
        .conv-online-dot.offline { background: #bcc0c4; }

        .conv-info { flex: 1; min-width: 0; }
        .conv-name { font-size: 14px; font-weight: 600; color: #1c1e21; margin: 0 0 2px; }
        .conv-preview {
          font-size: 13px; color: #65676b; margin: 0;
          white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .conv-preview.unread { color: #1c1e21; font-weight: 600; }
        .conv-meta { text-align: right; flex-shrink: 0; }
        .conv-time { font-size: 11px; color: #65676b; }
        .conv-badge {
          display: inline-flex; align-items: center; justify-content: center;
          min-width: 18px; height: 18px; background: #1877f2; color: #fff;
          border-radius: 10px; font-size: 11px; font-weight: 700; margin-top: 4px;
          padding: 0 5px;
        }

        /* ---- PANEL DERECHO — CHAT ---- */
        .messenger-chat {
          flex: 1; display: flex; flex-direction: column; background: #fff;
        }

        /* Estado vacío */
        .messenger-empty {
          flex: 1; display: flex; flex-direction: column; align-items: center;
          justify-content: center; color: #65676b;
        }
        .messenger-empty i { font-size: 60px; color: #e4e6eb; margin-bottom: 16px; }
        .messenger-empty h3 { font-size: 20px; font-weight: 700; color: #1c1e21; }
        .messenger-empty p { font-size: 14px; }

        /* Header del chat */
        .chat-header-msn {
          display: flex; align-items: center; gap: 12px;
          padding: 12px 20px; border-bottom: 1px solid #e4e6eb;
          background: #fff; flex-shrink: 0;
        }
        .chat-header-avatar-wrap { position: relative; }
        .chat-header-avatar {
          width: 42px; height: 42px; border-radius: 50%; object-fit: cover;
        }
        .chat-header-dot {
          position: absolute; bottom: 1px; right: 1px;
          width: 10px; height: 10px; border-radius: 50%;
          border: 2px solid #fff; background: #42b72a;
        }
        .chat-header-dot.offline { background: #bcc0c4; }

        .chat-header-info { flex: 1; }
        .chat-header-info h5 {
          font-size: 15px; font-weight: 700; color: #1c1e21; margin: 0 0 1px;
        }
        .chat-header-info small { font-size: 12px; color: #42b72a; }
        .chat-header-info small.offline-text { color: #65676b; }

        .chat-header-actions { display: flex; gap: 4px; }
        .chat-action-btn {
          width: 36px; height: 36px; border-radius: 50%; border: none;
          background: #e7f3ff; color: #1877f2; font-size: 18px;
          display: flex; align-items: center; justify-content: center;
          cursor: pointer; transition: all 0.2s;
        }
        .chat-action-btn:hover { background: #1877f2; color: #fff; transform: scale(1.08); }
        .chat-action-btn.danger { background: #ffeaea; color: #e53935; }
        .chat-action-btn.danger:hover { background: #e53935; color: #fff; }

        /* Mensajes */
        .chat-messages-msn {
          flex: 1; overflow-y: auto; padding: 16px 20px;
          display: flex; flex-direction: column; gap: 4px; background: #fff;
        }
        .chat-messages-msn::-webkit-scrollbar { width: 4px; }
        .chat-messages-msn::-webkit-scrollbar-thumb { background: #ccc; border-radius: 4px; }

        /* Fecha separadora */
        .msg-date-sep {
          text-align: center; font-size: 11px; color: #65676b;
          margin: 12px 0 4px; letter-spacing: 0.5px;
        }

        /* Burbuja */
        .msg-row { display: flex; align-items: flex-end; gap: 8px; max-width: 75%; }
        .msg-row.mine { align-self: flex-end; flex-direction: row-reverse; }
        .msg-row.theirs { align-self: flex-start; }

        .msg-row .msg-avatar {
          width: 26px; height: 26px; border-radius: 50%; object-fit: cover;
          flex-shrink: 0; margin-bottom: 2px;
        }
        .msg-row.mine .msg-avatar { display: none; }

        .msg-bubble-wrap { display: flex; flex-direction: column; max-width: 100%; }
        .msg-row.mine .msg-bubble-wrap { align-items: flex-end; }

        .msg-bubble {
          padding: 10px 14px; border-radius: 18px;
          font-size: 14px; line-height: 1.4; word-break: break-word;
          max-width: 480px;
        }
        .msg-row.mine .msg-bubble {
          background: #1877f2; color: #fff;
          border-bottom-right-radius: 4px;
        }
        .msg-row.theirs .msg-bubble {
          background: #f0f2f5; color: #1c1e21;
          border-bottom-left-radius: 4px;
        }

        .msg-time {
          font-size: 10px; color: #65676b; margin-top: 3px; padding: 0 2px;
        }
        .msg-row.mine .msg-time { text-align: right; }

        /* Indicador "escribiendo..." */
        .typing-indicator {
          display: flex; align-items: center; gap: 8px;
          padding: 6px 0; margin-bottom: 4px;
        }
        .typing-dots {
          display: flex; gap: 3px; background: #f0f2f5;
          padding: 10px 14px; border-radius: 18px;
        }
        .typing-dots span {
          width: 7px; height: 7px; background: #65676b; border-radius: 50%;
          animation: typingBounce 1.2s ease-in-out infinite;
        }
        .typing-dots span:nth-child(2) { animation-delay: 0.2s; }
        .typing-dots span:nth-child(3) { animation-delay: 0.4s; }
        @keyframes typingBounce {
          0%, 80%, 100% { transform: translateY(0); }
          40% { transform: translateY(-6px); }
        }

        /* Footer — Input */
        .chat-input-msn {
          padding: 12px 16px; border-top: 1px solid #e4e6eb;
          display: flex; align-items: center; gap: 8px; background: #fff;
          flex-shrink: 0;
        }
        .chat-input-msn .input-btn {
          width: 36px; height: 36px; border-radius: 50%; border: none;
          background: transparent; color: #1877f2; font-size: 20px;
          cursor: pointer; display: flex; align-items: center; justify-content: center;
          transition: background 0.15s;
        }
        .chat-input-msn .input-btn:hover { background: #e7f3ff; }

        .chat-input-msn .msg-input-field {
          flex: 1; background: #f0f2f5; border: none; border-radius: 20px;
          padding: 9px 16px; font-size: 14px; outline: none;
          transition: background 0.2s; max-height: 120px; resize: none;
          line-height: 1.4;
        }
        .chat-input-msn .msg-input-field:focus { background: #e4e6eb; }

        .send-btn-msn {
          width: 36px; height: 36px; border-radius: 50%; border: none;
          background: #1877f2; color: #fff; font-size: 18px;
          cursor: pointer; display: flex; align-items: center; justify-content: center;
          transition: all 0.2s; flex-shrink: 0;
        }
        .send-btn-msn:hover { background: #1565c0; transform: scale(1.08); }
        .send-btn-msn:disabled { background: #e4e6eb; color: #bcc0c4; cursor: not-allowed; transform: none; }

        /* ---- MODAL LLAMADA ---- */
        .call-modal-overlay {
          position: fixed; inset: 0; background: rgba(0,0,0,0.85);
          z-index: 99999; display: none; align-items: center; justify-content: center;
        }
        .call-modal-overlay.show { display: flex; }
        .call-modal {
          background: #1c1e21; border-radius: 20px; padding: 36px;
          text-align: center; min-width: 300px; max-width: 400px; width: 90%;
        }
        .call-modal-avatar {
          width: 90px; height: 90px; border-radius: 50%; object-fit: cover;
          border: 3px solid #1877f2; margin-bottom: 16px;
        }
        .call-modal h4 { color: #fff; font-size: 20px; font-weight: 700; margin: 0 0 6px; }
        .call-modal p { color: #b0b3b8; font-size: 14px; margin: 0 0 24px; }
        .call-btn-row { display: flex; gap: 16px; justify-content: center; }
        .call-btn {
          width: 60px; height: 60px; border-radius: 50%; border: none;
          font-size: 24px; cursor: pointer; display: flex; align-items: center;
          justify-content: center; transition: all 0.2s;
        }
        .call-btn.accept { background: #42b72a; color: #fff; }
        .call-btn.accept:hover { background: #36a420; transform: scale(1.1); }
        .call-btn.decline { background: #e53935; color: #fff; }
        .call-btn.decline:hover { background: #c62828; transform: scale(1.1); }

        /* Videollamada */
        .videocall-overlay {
          position: fixed; inset: 0; background: #1c1e21;
          z-index: 99998; display: none; flex-direction: column;
        }
        .videocall-overlay.show { display: flex; }
        .videocall-main { flex: 1; position: relative; }
        #remote-video {
          width: 100%; height: 100%; object-fit: cover; background: #000;
        }
        #local-video {
          position: absolute; bottom: 20px; right: 20px;
          width: 140px; height: 100px; border-radius: 10px; object-fit: cover;
          border: 2px solid #fff; background: #333; z-index: 2;
        }
        .videocall-controls {
          padding: 20px; display: flex; justify-content: center; gap: 16px;
          background: rgba(0,0,0,0.5);
        }
        .vcall-btn {
          width: 54px; height: 54px; border-radius: 50%; border: none;
          font-size: 22px; cursor: pointer; display: flex; align-items: center;
          justify-content: center; transition: all 0.2s;
        }
        .vcall-btn.hangup { background: #e53935; color: #fff; }
        .vcall-btn.hangup:hover { background: #c62828; }
        .vcall-btn.toggle { background: rgba(255,255,255,0.15); color: #fff; }
        .vcall-btn.toggle:hover { background: rgba(255,255,255,0.25); }

        /* Dark mode */
        body.dark-mode .messenger-sidebar,
        body.dark-mode .messenger-chat,
        body.dark-mode .chat-header-msn,
        body.dark-mode .chat-input-msn {
          background: #242526 !important; border-color: #3a3b3c !important;
        }
        body.dark-mode .messenger-wrapper { background: #18191a !important; }
        body.dark-mode .conv-item:hover { background: #3a3b3c !important; }
        body.dark-mode .conv-item.active { background: #263951 !important; }
        body.dark-mode .conv-name, body.dark-mode .chat-header-info h5 { color: #e4e6eb !important; }
        body.dark-mode .conv-preview { color: #b0b3b8 !important; }
        body.dark-mode .messenger-sidebar-header h2 { color: #e4e6eb !important; }
        body.dark-mode .messenger-search input,
        body.dark-mode .msg-input-field { background: #3a3b3c !important; color: #e4e6eb !important; }
        body.dark-mode .msg-row.theirs .msg-bubble { background: #3a3b3c !important; color: #e4e6eb !important; }
        body.dark-mode .chat-messages-msn { background: #1c1e21 !important; }
        body.dark-mode .messenger-empty i { color: #3a3b3c !important; }
        body.dark-mode .messenger-empty h3 { color: #e4e6eb !important; }

        /* Responsive y Ajustes de Layout */
        .messenger-wrapper {
          margin-left: 0 !important;
          width: 100% !important;
          transition: all 0.3s ease;
        }
        
        @media (max-width: 991px) {
          .messenger-wrapper {
            height: calc(100vh - 145px) !important;
          }
          .messenger-sidebar {
            width: 100% !important;
            min-width: 100% !important;
            display: flex !important;
          }
          .messenger-chat {
            display: none !important;
            width: 100% !important;
          }
          
          /* Cuando hay un chat activo en móvil/tablet */
          .messenger-wrapper.chat-active .messenger-sidebar {
            display: none !important;
          }
          .messenger-wrapper.chat-active .messenger-chat {
            display: flex !important;
          }
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

      <!-- Hidden user ID for JS -->
      <input type="hidden" id="mi-id-usuario" value="<?php echo $_SESSION['id_usuario']; ?>">

      <!-- Wrapper Start -->
      <div class="wrapper">
                  <?php include __DIR__ . '/premium_sidebar.php'; ?>
         <?php include __DIR__ . '/premium_topnav.php'; ?>

         <!-- Page Content -->
         <div id="content-page" class="content-page">
            <div class="container-fluid px-3">

              <!-- ============ MESSENGER LAYOUT ============ -->
              <div class="messenger-wrapper">

                <!-- SIDEBAR IZQUIERDO -->
                <div class="messenger-sidebar">
                  <div class="messenger-sidebar-header">
                    <h2>Chats</h2>
                    <div class="messenger-search">
                      <i class="ri-search-line"></i>
                      <input type="text" id="msn-search" placeholder="Buscar en Messenger">
                    </div>
                  </div>

                  <div class="messenger-tabs">
                    <div class="messenger-tab active" data-tab="privados">Mis Amigos</div>
                    <div class="messenger-tab" data-tab="solicitudes">Solicitudes</div>
                  </div>

                  <!-- Lista conversaciones -->
                  <div class="messenger-conv-list" id="conv-list">
                    <!-- Amigos cargados dinámicamente -->
                    <div id="amigos-list">
                      <div class="text-center py-4">
                        <div class="spinner-border text-primary spinner-border-sm"></div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- PANEL DERECHO -->
                <div class="messenger-chat" id="messenger-chat-panel">

                  <!-- Estado vacío -->
                  <div class="messenger-empty" id="chat-empty-state">
                    <i class="ri-chat-3-line"></i>
                    <h3>Tus mensajes</h3>
                    <p>Selecciona un chat para empezar a conversar</p>
                  </div>

                  <!-- Panel Chat General Removido -->

                  <!-- Panel Chat Privado -->
                  <div id="panel-privado" style="display:none; flex-direction:column; flex:1; height:100%;">
                    <div class="chat-header-msn">
                      <div class="chat-header-avatar-wrap">
                        <img id="priv-header-avatar" src="" class="chat-header-avatar" alt="">
                        <span id="priv-header-dot" class="chat-header-dot offline"></span>
                      </div>
                      <div class="chat-header-info">
                        <h5 id="priv-header-name">—</h5>
                        <small id="priv-header-status" class="offline-text">Desconectado</small>
                      </div>
                      <div class="chat-header-actions">
                        <button class="chat-action-btn" id="btn-llamada-voz" title="Llamada de voz">
                          <i class="ri-phone-line"></i>
                        </button>
                        <button class="chat-action-btn" id="btn-videollamada" title="Videollamada">
                          <i class="ri-vidicon-line"></i>
                        </button>
                        <button class="chat-action-btn danger" id="btn-cerrar-privado" title="Cerrar chat">
                          <i class="ri-close-line"></i>
                        </button>
                      </div>
                    </div>

                    <div class="chat-messages-msn" id="privado-messages">
                      <!-- mensajes se cargan dinámicamente -->
                    </div>
                    <!-- Typing Indicator -->
                    <div class="typing-indicator" id="priv-typing-indicator" style="display: none; padding: 10px 20px; background: #fff; align-items: center; gap: 8px; border-top: 1px solid rgba(0,0,0,0.03);">
                      <div class="typing-dots">
                        <span></span><span></span><span></span>
                      </div>
                      <span style="font-size: 13px; color: #65676b; margin-left: 8px;">está escribiendo...</span>
                    </div>

                    <div class="chat-input-msn">
                      <input type="file" id="chat-image-input" accept="image/*" style="display: none;">
                      <button class="input-btn" id="btn-chat-image" title="Adjuntar Imagen"><i class="ri-image-add-line"></i></button>
                      <form id="form-chat-privado" style="display:flex; flex:1; gap:8px;" autocomplete="off">
                        <textarea id="mensaje-privado-input" class="msg-input-field" placeholder="Escribe un mensaje..." rows="1"></textarea>
                        <button type="button" class="input-btn" id="btn-chat-mic" title="Grabar Audio" style="background: none; border: none; font-size: 20px; color: #65676b; cursor: pointer; outline: none;"><i class="ri-mic-line"></i></button>
                        <button type="submit" class="send-btn-msn" id="btn-chat-send" style="display: none;"><i class="ri-send-plane-fill"></i></button>
                      </form>
                    </div>
                  </div>

                </div><!-- /messenger-chat -->
              </div><!-- /messenger-wrapper -->

            </div>
         </div>
         <!-- Page Content END -->
      </div>
      <!-- Wrapper END -->

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

      <!-- MODAL LLAMADA DE VOZ -->
      <div class="call-modal-overlay" id="call-overlay">
        <div class="call-modal">
          <img id="call-avatar" src="" class="call-modal-avatar" alt="">
          <h4 id="call-name">—</h4>
          <p id="call-status">Llamando...</p>
          <div class="call-btn-row">
            <button class="call-btn decline" id="btn-hangup-call" title="Colgar">
              <i class="ri-phone-fill" style="transform: rotate(135deg);"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- OVERLAY VIDEOLLAMADA -->
      <div class="videocall-overlay" id="videocall-overlay">
        <div class="videocall-main">
          <video id="remote-video" autoplay playsinline></video>
          <video id="local-video" autoplay playsinline muted></video>
        </div>
        <div class="videocall-controls">
          <button class="vcall-btn toggle" id="btn-toggle-mic" title="Micrófono">
            <i class="ri-mic-line"></i>
          </button>
          <button class="vcall-btn toggle" id="btn-toggle-cam" title="Cámara">
            <i class="ri-camera-line"></i>
          </button>
          <button class="vcall-btn hangup" id="btn-hangup-video" title="Colgar">
            <i class="ri-phone-fill" style="transform: rotate(135deg);"></i>
          </button>
        </div>
      </div>

      <!-- Scripts -->
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
      <script src="../vista/js/jquery.timeago.js"></script>
      <script src="../vista/js/control_tiempo.js"></script>
      <script src="../vista/js/alerta_registromensajeschat.js"></script>
      <script src="../vista/js/alerta_retirarmensajeschat.js"></script>
      <script src="../vista/js/alerta-solicitudesaceptadas.js"></script>
      <script src="../vista/js/alerta-eliminarsolicitudamistad.js"></script>

      <!-- Dark Mode -->
      <script>
      (function(){
          try {
              var dm = localStorage.getItem('secret-dark-mode');
              if(dm === '1') { document.body.classList.add('dark-mode'); }
          } catch(e) {
              console.warn(e);
          }
      })();
      document.addEventListener('DOMContentLoaded', function(){
          var btn = document.getElementById('dark-mode-toggle');
          if(btn) btn.addEventListener('click', function(e){
              e.preventDefault();
              document.body.classList.toggle('dark-mode');
              var isDark = document.body.classList.contains('dark-mode');
              try {
                  localStorage.setItem('secret-dark-mode', isDark ? '1' : '0');
              } catch(e) {
                  console.warn(e);
              }
              var icon = btn.querySelector('i');
              if(icon) icon.className = isDark ? 'ri-sun-line' : 'ri-moon-line';
          });
      });
      </script>

      <!-- Messenger Logic -->
      <script>
      $(function() {
        var chatAmigoId = null;
        var chatAmigoNombre = '';
        var chatAmigoFoto = '';
        var pollInterval = null;

        // ---- CARGAR AMIGOS ----
        function cargarAmigos(filtro) {
          $.ajax({
            url: '../controlador/cChatPrivado.php?accion=cargar-amigos',
            type: 'GET',
            dataType: 'json',
            success: function(res) {
              var tabActivo = $('.messenger-tab.active').data('tab') || 'privados';
              var dataList = tabActivo === 'privados' ? res.amigos : res.solicitudes;
              var html = '';
              if(!dataList || dataList.length === 0) {
                html = '<div class="text-center text-muted py-4" style="font-size:13px;">No hay conversaciones en esta pestaña.</div>';
              } else {
                var busq = filtro ? filtro.toLowerCase() : '';
                dataList.forEach(function(a) {
                  var nombre = a.nombres + ' ' + a.apellidos;
                  if(busq && nombre.toLowerCase().indexOf(busq) < 0) return;
                  var online = (a.estado === 'online');
                  var preview = a.ultimo_mensaje ? a.ultimo_mensaje : 'Iniciar conversación';
                  html += '<div class="conv-item abrir-chat-priv" data-id="'+a.id+'" data-nombre="'+escapeAttr(nombre)+'" data-foto="'+escapeAttr(a.fotoperfil)+'">' +
                    '<div class="conv-avatar-wrap">' +
                      '<img src="../vista/images/fotosperfiles/'+a.fotoperfil+'" class="conv-avatar" alt="">' +
                      '<span class="conv-online-dot '+(online?'':'offline')+'"></span>' +
                    '</div>' +
                    '<div class="conv-info">' +
                      '<p class="conv-name">'+escapeHtml(nombre)+'</p>' +
                      '<p class="conv-preview">'+escapeHtml(preview.substring(0,40))+'</p>' +
                    '</div>' +
                    '<div class="conv-meta">' +
                      '<div class="conv-time">'+(online ? '<span style="color:#42b72a;font-size:11px;">● En línea</span>' : '')+'</div>' +
                    '</div>' +
                  '</div>';
                });
              }
              $('#amigos-list').html(html);
            }
          });
        }

        cargarAmigos();
        setInterval(function(){ cargarAmigos($('#msn-search').val()); }, 10000);

        $('#msn-search').on('input', function(){
          cargarAmigos($(this).val());
        });

        // ---- TABS ----
        $('.messenger-tab').on('click', function(){
          var tab = $(this).data('tab');
          $('.messenger-tab').removeClass('active');
          $(this).addClass('active');
          cargarAmigos($('#msn-search').val());
        });

        // ---- ABRIR CHAT PRIVADO ----
        $(document).on('click', '.abrir-chat-priv', function(){
          var id = $(this).data('id');
          var nombre = $(this).data('nombre');
          var foto = $(this).data('foto');
          abrirChatPrivado(id, nombre, foto);
        });

        function abrirChatPrivado(id, nombre, foto) {
          chatAmigoId = id;
          window.chatAmigoId = id; // Set global for WebRTC
          $('#panel-privado').data('amigo-id', id); // Set dataset for WebRTC
          chatAmigoNombre = nombre;
          chatAmigoFoto = foto;

          $('#chat-empty-state').hide();
          $('#panel-privado').css('display','flex');
          $('.messenger-wrapper').addClass('chat-active');

          $('#priv-header-avatar').attr('src', '../vista/images/fotosperfiles/'+foto);
          $('#priv-header-name').text(nombre);
          $('#call-avatar').attr('src', '../vista/images/fotosperfiles/'+foto);
          $('#call-name').text(nombre);

          $('.conv-item').removeClass('active');
          $('.abrir-chat-priv[data-id="'+id+'"]').addClass('active');

          cargarMensajesPrivados();
          verificarPresencia();

          clearInterval(pollInterval);
          pollInterval = setInterval(function(){
            cargarMensajesPrivados();
            verificarPresencia();
          }, 4000);
        }

        // ---- CERRAR PRIVADO ----
        $('#btn-cerrar-privado').on('click', function(){
          clearInterval(pollInterval);
          pollInterval = null;
          chatAmigoId = null;
          window.chatAmigoId = null;
          // Ocultar el panel privado completamente y mostrar estado vacío
          $('#panel-privado').css({ 'display': 'none', 'flex': '' });
          $('#chat-empty-state').css('display', 'flex');
          $('.messenger-wrapper').removeClass('chat-active');
          $('.conv-item').removeClass('active');
          $('#privado-messages').html('');

          // Clear ?abrirChat= from the URL so it doesn't open again on reload
          var url = new URL(window.location.href);
          url.searchParams.delete('abrirChat');
          window.history.replaceState({}, '', url.toString());
        });

        // ---- ABRIR CHAT DESDE URL PARAM (?abrirChat=ID) ----
        var urlParams = new URLSearchParams(window.location.search);
        var abrirChatId = urlParams.get('abrirChat');
        if(abrirChatId) {
          // Esperar a que carguen los amigos y luego abrir el chat
          setTimeout(function() {
            var targetItem = $('.abrir-chat-priv[data-id="' + abrirChatId + '"]');
            if(targetItem.length) {
              targetItem.trigger('click');
            } else {
              // Si no está en la lista, buscar sus datos via AJAX
              $.ajax({
                url: '../controlador/cChatPrivado.php?accion=datos-usuario&id=' + parseInt(abrirChatId),
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                  if(res && res.id) {
                    abrirChatPrivado(res.id, res.nombres + ' ' + res.apellidos, res.fotoperfil);
                  }
                }
              });
            }
          }, 1500);
        }

        // ---- CARGAR MENSAJES PRIVADOS ----
        function cargarMensajesPrivados() {
          if(!chatAmigoId) return;
          $.ajax({
            url: '../controlador/cChatPrivado.php?accion=cargar-mensajes&id_amigo='+chatAmigoId,
            type: 'GET',
            dataType: 'json',
            success: function(res) {
              if(!res || res.error) return;
              var mensajes = res.mensajes || [];
              var typing = res.typing || false;
              var miId = parseInt($('#mi-id-usuario').val() || 0);
              var html = '';
              var prevDate = '';
              mensajes.forEach(function(msg) {
                var esMio = parseInt(msg.id_remitente) === miId;
                var fecha = new Date(msg.fecha_envio);
                var hora = padZ(fecha.getHours())+':'+padZ(fecha.getMinutes());
                var dia = fecha.toLocaleDateString('es-SV', {day:'2-digit', month:'short'});
                if(dia !== prevDate) {
                  html += '<div class="msg-date-sep">'+dia+'</div>';
                  prevDate = dia;
                }
                html += '<div class="msg-row '+(esMio?'mine':'theirs')+'">';
                if(!esMio) {
                  html += '<img src="../vista/images/fotosperfiles/'+escapeAttr(msg.fotoperfil)+'" class="msg-avatar" alt="">';
                }
                html += '<div class="msg-bubble-wrap">';
                
                // Content Rendering
                var msgContent = '';
                if(msg.tipo === 'imagen' && msg.archivo) {
                  msgContent = '<img src="../vista/images/chat_imagenes/'+escapeAttr(msg.archivo)+'" style="max-width:200px; border-radius:8px;">';
                  if(msg.mensaje) msgContent += '<br>' + escapeHtml(msg.mensaje);
                } else if(msg.tipo === 'audio' && msg.archivo) {
                  msgContent = '<audio controls src="../vista/images/chat_audios/'+escapeAttr(msg.archivo)+'" style="max-width:220px; outline:none; height:40px;"></audio>';
                } else {
                  msgContent = escapeHtml(msg.mensaje);
                }

                html += '<div class="msg-bubble">'+msgContent+'</div>' +
                  '<span class="msg-time">'+hora+(esMio?' ✓✓':'')+'</span>' +
                '</div></div>';
              });
              var container = $('#privado-messages');
              container.html(html);
              container[0].scrollTop = container[0].scrollHeight;

              // Update typing indicator display
              if (typing) {
                $('#priv-typing-indicator').css('display', 'flex');
              } else {
                $('#priv-typing-indicator').css('display', 'none');
              }
            }
          });
        }

        // ---- ENVIAR MENSAJE PRIVADO ----
        $(document).on('submit', '#form-chat-privado', function(e){
          e.preventDefault();
          if(!chatAmigoId) return;
          var input = $('#mensaje-privado-input');
          var msg = input.val().trim();
          if(!msg) return;
          input.val('');
          toggleSendMicBtn(false); // Reset buttons
          $.ajax({
            url: '../controlador/cChatPrivado.php?accion=enviar-mensaje',
            type: 'POST',
            data: { id_receptor: chatAmigoId, mensaje: msg, tipo: 'text' },
            dataType: 'json',
            success: function(){
              cargarMensajesPrivados();
            }
          });
        });

        // Toggling Send / Mic button
        $('#mensaje-privado-input').on('input', function() {
            toggleSendMicBtn($(this).val().trim().length > 0);
        });

        function toggleSendMicBtn(hasText) {
            if(hasText) {
                $('#btn-chat-mic').hide();
                $('#btn-chat-send').show();
            } else {
                $('#btn-chat-mic').show();
                $('#btn-chat-send').hide();
            }
        }

        // ---- ADJUNTAR IMAGEN ----
        $('#btn-chat-image').on('click', function(e){
            e.preventDefault();
            $('#chat-image-input').click();
        });

        $('#chat-image-input').on('change', function(){
            var file = this.files[0];
            if(!file || !chatAmigoId) return;
            
            var formData = new FormData();
            formData.append('file', file);
            formData.append('tipo', 'imagen');

            // Optionally upload first, then send message
            $.ajax({
                url: '../controlador/cChatPrivado.php?accion=upload-media',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(res) {
                    if(res.status === 'OK') {
                        // Create message entry
                        $.post('../controlador/cChatPrivado.php?accion=enviar-mensaje', {
                            id_receptor: chatAmigoId,
                            mensaje: '',
                            tipo: 'imagen',
                            archivo: res.archivo
                        }, function() {
                            cargarMensajesPrivados();
                        });
                    } else {
                        SN.error('Error', 'No se pudo subir la imagen: ' + res.error);
                    }
                }
            });
            $(this).val('');
        });

        // ---- GRABAR AUDIO (Web Audio API) ----
        let mediaRecorder;
        let audioChunks = [];
        let isRecording = false;

        $('#btn-chat-mic').on('mousedown touchstart', async function(e) {
            e.preventDefault();
            if(!chatAmigoId || isRecording) return;
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                mediaRecorder = new MediaRecorder(stream);
                audioChunks = [];
                mediaRecorder.ondataavailable = e => audioChunks.push(e.data);
                mediaRecorder.onstop = uploadAudioRecord;
                mediaRecorder.start();
                isRecording = true;
                $(this).css('color', '#e53935'); // Turn red
                $('#mensaje-privado-input').attr('placeholder', 'Grabando audio... Suelta para enviar');
            } catch(err) {
                SN.error('Micrófono', 'No se pudo acceder al micrófono. Verifica los permisos.');
            }
        });

        $('#btn-chat-mic').on('mouseup mouseleave touchend', function(e) {
            e.preventDefault();
            if(isRecording && mediaRecorder && mediaRecorder.state !== 'inactive') {
                mediaRecorder.stop();
                mediaRecorder.stream.getTracks().forEach(t => t.stop());
                isRecording = false;
                $(this).css('color', '#65676b');
                $('#mensaje-privado-input').attr('placeholder', 'Escribe un mensaje...');
            }
        });

        function uploadAudioRecord() {
            const audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
            var formData = new FormData();
            formData.append('file', audioBlob, 'record.webm');
            formData.append('tipo', 'audio');

            $.ajax({
                url: '../controlador/cChatPrivado.php?accion=upload-media',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(res) {
                    if(res.status === 'OK') {
                        $.post('../controlador/cChatPrivado.php?accion=enviar-mensaje', {
                            id_receptor: chatAmigoId,
                            mensaje: '',
                            tipo: 'audio',
                            archivo: res.archivo
                        }, function() {
                            cargarMensajesPrivados();
                        });
                    }
                }
            });
        }

        // Enter para enviar (Shift+Enter = nueva línea)
        $('#mensaje-privado-input').on('keydown', function(e){
          if(e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            $('#form-chat-privado').submit();
          }
        });
        $('#mensajes_chat').on('keydown', function(e){
          if(e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            $('#registrochatgeneral').submit();
          }
        });

        // Escribiendo (Typing) listener
        var msnTypingTimeout = null;
        $('#mensaje-privado-input').on('input', function() {
          if(!chatAmigoId) return;
          if (!msnTypingTimeout) {
            $.post('../controlador/cChatPrivado.php?accion=set-typing', { id_amigo: chatAmigoId, status: 1 });
          }
          clearTimeout(msnTypingTimeout);
          msnTypingTimeout = setTimeout(function() {
            $.post('../controlador/cChatPrivado.php?accion=set-typing', { id_amigo: chatAmigoId, status: 0 });
            msnTypingTimeout = null;
          }, 3000);
        });

        // ---- VERIFICAR PRESENCIA ----
        function verificarPresencia() {
          if(!chatAmigoId) return;
          $.ajax({
            url: '../controlador/cChatPrivado.php?accion=presencia&id_amigo='+chatAmigoId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
              if(data && data.estado === 'online') {
                $('#priv-header-status').text('En línea').removeClass('offline-text').addClass('').css('color','#42b72a');
                $('#priv-header-dot').removeClass('offline');
              } else {
                $('#priv-header-status').text('Desconectado').addClass('offline-text').css('color','');
                $('#priv-header-dot').addClass('offline');
              }
            }
          });
        }

        // ---- LLAMADA DE VOZ ----
        $('#btn-llamada-voz').on('click', function(e){
          e.preventDefault();
          if(!chatAmigoId) return;
          $.post('../controlador/cChatPrivado.php?accion=initiate-call', { id_receptor: chatAmigoId, tipo: 'voz' }, function(res){
             let data = JSON.parse(res);
             if(data.status === 'OK') {
                window.location.href = '../vista/llamada_activa.php?id=' + data.id_llamada;
             } else {
                SN.error('Llamada', 'No se pudo iniciar la llamada: ' + data.error);
             }
          });
        });

        // ---- VIDEOLLAMADA ----
        $('#btn-videollamada').on('click', function(e){
          e.preventDefault();
          if(!chatAmigoId) return;
          $.post('../controlador/cChatPrivado.php?accion=initiate-call', { id_receptor: chatAmigoId, tipo: 'video' }, function(res){
             let data = JSON.parse(res);
             if(data.status === 'OK') {
                window.location.href = '../vista/llamada_activa.php?id=' + data.id_llamada;
             } else {
                SN.error('Videollamada', 'No se pudo iniciar la videollamada: ' + data.error);
             }
          });
        });

        // ---- HELPERS ----
        function escapeHtml(text) {
          return $('<div>').text(text || '').html();
        }
        function escapeAttr(text) {
          return (text || '').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
        }
        function padZ(n) { return n < 10 ? '0'+n : n; }

        // Ping de presencia
        $.get('../controlador/cChatPrivado.php?accion=ping');
        setInterval(function(){ $.get('../controlador/cChatPrivado.php?accion=ping'); }, 60000);

      });
      </script>

      <script src="../vista/js/webrtc_calls.js"></script>
      <script src="../vista/js/floating_chat.js?v=3"></script>
      <script src="../vista/js/notificaciones-premium.js"></script>
   </body>
</html>
<?php
}else{header('location:../Controlador/cRegistroNuevosUsuarios.php?nuevoregistro=completarperfil');}
?>
