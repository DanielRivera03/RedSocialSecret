<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // SI EL USUARIO YA TIENE SESIÓN ACTIVA, REDIRIGIR AL FEED
    if(isset($_SESSION['nombre_usuario'])){
        if(isset($_SESSION['comprobar_perfil']) && $_SESSION['comprobar_perfil'] == 0){
            header('location:../Feed/inicio');
            exit();
        } elseif(isset($_SESSION['comprobar_perfil']) && $_SESSION['comprobar_perfil'] == 1){
            header('location:../controlador/cRegistroNuevosUsuarios.php?nuevoregistro=completarperfil');
            exit();
        }
    }
    // NO PERMITIR INGRESO SIN ENVIO DE PARAMETRO
    if(!isset($_GET['validarsesion'])){
        header('location:../AccesoDenegado=restringido');
        exit();
    }
    // NO PERMITIR INGRESO SIN ENVIO DE PARAMETRO
    if($_GET['validarsesion']!="inicio"){
        header('location:../AccesoDenegado=restringido');
        exit();
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
      <title>Secret - Iniciar Sesión</title>
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
      <!-- Google Fonts -->
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
      <!-- Remix Icons -->
      <link href="https://cdn.jsdelivr.net/npm/remixicon@2.2.0/fonts/remixicon.css" rel="stylesheet">

      <style>
        /* ===================== RECUPERAR CONTRASEÑA MODAL ===================== */
        .recover-modal-overlay {
          position: fixed; inset: 0; background: rgba(0,0,0,0.6);
          z-index: 99999; display: none; align-items: center; justify-content: center;
          backdrop-filter: blur(6px);
        }
        .recover-modal-overlay.active { display: flex; }
        .recover-modal-box {
          background: #fff; border-radius: 20px; padding: 40px 36px;
          max-width: 440px; width: 92%; box-shadow: 0 24px 60px rgba(0,0,0,0.18);
          position: relative; font-family: 'Inter', sans-serif;
        }
        .recover-modal-close {
          position: absolute; top: 16px; right: 16px; background: #f5f5f5;
          border: none; border-radius: 50%; width: 36px; height: 36px;
          font-size: 18px; cursor: pointer; display: flex; align-items: center; justify-content: center;
          color: #555; transition: all 0.2s;
        }
        .recover-modal-close:hover { background: #fee2e2; color: #e53935; }
        .recover-step { display: none; }
        .recover-step.active { display: block; }
        .recover-icon { font-size: 48px; margin-bottom: 16px; text-align: center; }
        .recover-title { font-size: 22px; font-weight: 700; color: #1a1a2e; margin-bottom: 6px; text-align: center; }
        .recover-desc { font-size: 14px; color: #6b7280; margin-bottom: 24px; text-align: center; line-height: 1.5; }
        .recover-input {
          width: 100%; padding: 13px 16px; border: 1.5px solid #e5e7eb; border-radius: 12px;
          font-size: 15px; font-family: 'Inter', sans-serif; outline: none; transition: border-color 0.2s;
          margin-bottom: 14px; box-sizing: border-box;
        }
        .recover-input:focus { border-color: #e53935; box-shadow: 0 0 0 3px rgba(229,57,53,0.1); }
        .recover-btn {
          width: 100%; padding: 13px; background: linear-gradient(135deg, #b92025, #e53935);
          color: #fff; border: none; border-radius: 12px; font-size: 15px;
          font-weight: 600; cursor: pointer; transition: all 0.2s; font-family: 'Inter', sans-serif;
        }
        .recover-btn:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(185,32,37,0.3); }
        .recover-btn:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
        .recover-back { background: none; border: none; color: #6b7280; font-size: 13px;
          cursor: pointer; margin-top: 12px; width: 100%; text-align: center; font-family: 'Inter', sans-serif; }
        .recover-back:hover { color: #e53935; }
        /* Código de 6 dígitos */
        .code-inputs { display: flex; gap: 8px; justify-content: center; margin-bottom: 20px; }
        .code-digit {
          width: 48px; height: 58px; border: 2px solid #e5e7eb; border-radius: 12px;
          text-align: center; font-size: 22px; font-weight: 700; color: #1a1a2e;
          outline: none; transition: all 0.2s; font-family: 'Inter', sans-serif;
        }
        .code-digit:focus { border-color: #e53935; box-shadow: 0 0 0 3px rgba(229,57,53,0.1); }
        .code-digit.filled { border-color: #10b981; background: #f0fdf4; }
        .recover-timer { font-size: 13px; color: #6b7280; text-align: center; margin-bottom: 14px; }
        .recover-timer span { color: #e53935; font-weight: 600; }
        .recover-resend { background: none; border: none; color: #3b82f6; font-size: 13px;
          cursor: pointer; font-family: 'Inter', sans-serif; }
        .recover-resend:hover { text-decoration: underline; }
        /* Strength bar */
        .password-strength { margin-bottom: 14px; }
        .strength-bar { height: 4px; background: #e5e7eb; border-radius: 2px; overflow: hidden; }
        .strength-fill { height: 100%; border-radius: 2px; transition: all 0.3s; width: 0; }
        .strength-text { font-size: 12px; margin-top: 4px; color: #6b7280; }
        .recover-error { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626;
          padding: 10px 14px; border-radius: 10px; font-size: 13px; margin-bottom: 12px; display: none; }
        .recover-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d;
          padding: 10px 14px; border-radius: 10px; font-size: 13px; margin-bottom: 12px; display: none; }
        /* Steps indicator */
        .recover-steps-bar { display: flex; align-items: center; justify-content: center; gap: 6px; margin-bottom: 28px; }
        .recover-step-dot { width: 8px; height: 8px; border-radius: 50%; background: #e5e7eb; transition: all 0.3s; }
        .recover-step-dot.active { background: #e53935; width: 24px; border-radius: 4px; }
        .recover-step-dot.done { background: #10b981; }
        /* Olvidé contraseña link */
        .forgot-pass-link {
          display: block; text-align: right; margin-top: -8px; margin-bottom: 14px;
          font-size: 13px; color: #e53935; cursor: pointer; text-decoration: none;
          font-family: 'Inter', sans-serif;
        }
        .forgot-pass-link:hover { text-decoration: underline; color: #b92025; }

        /* ===================== TOAST NOTIFICATIONS ===================== */
        #secret-toasts {
          position: fixed; top: 20px; right: 20px; z-index: 999999;
          display: flex; flex-direction: column; gap: 10px; pointer-events: none;
        }
        .secret-toast {
          display: flex; align-items: flex-start; gap: 12px; background: #fff;
          border-radius: 14px; padding: 14px 18px; box-shadow: 0 8px 30px rgba(0,0,0,0.12);
          min-width: 300px; max-width: 380px; pointer-events: all;
          border-left: 4px solid #e53935; font-family: 'Inter', sans-serif;
          animation: toastIn 0.35s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
          position: relative; overflow: hidden;
        }
        .secret-toast.toast-success { border-left-color: #10b981; }
        .secret-toast.toast-error { border-left-color: #ef4444; }
        .secret-toast.toast-warning { border-left-color: #f59e0b; }
        .secret-toast.toast-info { border-left-color: #3b82f6; }
        .secret-toast.toast-out { animation: toastOut 0.3s ease forwards; }
        @keyframes toastIn {
          from { opacity: 0; transform: translateX(60px) scale(0.9); }
          to { opacity: 1; transform: translateX(0) scale(1); }
        }
        @keyframes toastOut {
          from { opacity: 1; transform: translateX(0) scale(1); max-height: 200px; margin-bottom: 0; }
          to { opacity: 0; transform: translateX(60px) scale(0.9); max-height: 0; margin-bottom: -10px; padding: 0; }
        }
        .toast-icon { font-size: 20px; flex-shrink: 0; margin-top: 1px; }
        .toast-body { flex: 1; min-width: 0; }
        .toast-title { font-size: 14px; font-weight: 600; color: #111827; margin-bottom: 2px; }
        .toast-message { font-size: 13px; color: #6b7280; line-height: 1.4; }
        .toast-close { background: none; border: none; color: #9ca3af; cursor: pointer; font-size: 16px; padding: 0; line-height: 1; }
        .toast-close:hover { color: #374151; }
        .toast-progress { position: absolute; bottom: 0; left: 0; height: 3px; background: currentColor; opacity: 0.3; border-radius: 0 0 0 14px; animation: toastProgress linear forwards; }
        @keyframes toastProgress { from { width: 100%; } to { width: 0%; } }
      </style>
   </head>
   <body>
      <!-- Toast container -->
      <div id="secret-toasts"></div>

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
                            <h1 class="mb-0">Iniciar Sesi&oacute;n &#127760;</h1>
                            <p>&#128233; Por favor ingresa tus credenciales para acceder</p>
                            <form class="mt-4 needs-validation" novalidate method="POST" action="../controlador/ControlInicioSesiones.php?validarsesion=validar" autocomplete="off">
                                <!-- CORREO -->
                                <div class="form-group">
                                    <label for="loginEmail">&#128237; Ingresa tu correo electr&oacute;nico</label>
                                    <div class="input-group">
                                       <input type="email" class="form-control mb-0" id="loginEmail" name="CorreoUsuario" placeholder="Ingrese correo aqu&iacute;" required value="<?php echo isset($_COOKIE['recordar_correo']) ? htmlspecialchars($_COOKIE['recordar_correo'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                                       <div class="invalid-tooltip">
                                          Correo es requerido, complete este campo
                                       </div>
                                       <div class="valid-tooltip">
                                          Campo completado con &eacute;xito
                                       </div>
                                    </div>    
                                </div>
                                <!-- CONTRASEÑA -->
                                <div class="form-group">
                                    <label for="loginPass">&#128273; Ingresa tu contrase&ntilde;a</label>
                                    <div class="input-group">
                                       <input type="password" class="form-control mb-0" id="loginPass" name="ClaveUsuario" placeholder="*****************" required>
                                       <div class="invalid-tooltip">
                                          Contrase&ntilde;a es requerida, complete este campo
                                       </div>
                                       <div class="valid-tooltip">
                                          Campo completado con &eacute;xito
                                       </div>
                                    </div>    
                                </div>
                                <!-- Olvidé contraseña -->
                                <a class="forgot-pass-link" id="open-recover-modal" href="javascript:void(0);">
                                    &#128274; ¿Olvidaste tu contrase&ntilde;a?
                                </a>
                                <div class="d-inline-block w-100">
                                    <div class="custom-control custom-checkbox d-inline-block mt-2 pt-1">
                                        <input type="checkbox" class="custom-control-input" id="recordarUsuario" name="recordarUsuario" <?php echo isset($_COOKIE['recordar_correo']) ? 'checked' : ''; ?>>
                                        <label class="custom-control-label" for="recordarUsuario">Recordar usuario</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary float-right">Iniciar Sesi&oacute;n</button>
                                </div>
                                <div class="sign-info">
                                    <span class="dark-color d-inline-block line-height-2">¿A&uacute;n no posees una cuenta? <a href="../Registrarme/altanuevousuario">¡Registrate aqu&iacute;!</a></span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Sign in END -->

      <!-- ============ MODAL RECUPERAR CONTRASEÑA ============ -->
      <div class="recover-modal-overlay" id="recover-overlay">
        <div class="recover-modal-box">
          <button class="recover-modal-close" id="close-recover-modal" title="Cerrar">
            <i class="ri-close-line"></i>
          </button>

          <!-- Steps indicator -->
          <div class="recover-steps-bar">
            <div class="recover-step-dot active" id="dot-1"></div>
            <div class="recover-step-dot" id="dot-2"></div>
            <div class="recover-step-dot" id="dot-3"></div>
          </div>

          <!-- PASO 1: Ingresar correo -->
          <div class="recover-step active" id="recover-step-1">
            <div class="recover-icon">🔐</div>
            <div class="recover-title">Recuperar Contraseña</div>
            <div class="recover-desc">Ingresa tu correo electrónico y te enviaremos un código de verificación de 6 dígitos.</div>
            <div class="recover-error" id="step1-error"></div>
            <input type="email" class="recover-input" id="recover-email" placeholder="tu@correo.com" autocomplete="email">
            <button class="recover-btn" id="btn-send-code">
              <i class="ri-send-plane-line mr-1"></i> Enviar Código
            </button>
          </div>

          <!-- PASO 2: Ingresar código -->
          <div class="recover-step" id="recover-step-2">
            <div class="recover-icon">📬</div>
            <div class="recover-title">Verifica tu Identidad</div>
            <div class="recover-desc" id="recover-code-desc">Ingresa el código de 6 dígitos enviado a tu correo.</div>
            <div class="recover-error" id="step2-error"></div>
            <div class="recover-success" id="step2-success"></div>
            <div class="code-inputs">
              <input type="text" class="code-digit" maxlength="1" data-index="0" id="digit-0">
              <input type="text" class="code-digit" maxlength="1" data-index="1" id="digit-1">
              <input type="text" class="code-digit" maxlength="1" data-index="2" id="digit-2">
              <input type="text" class="code-digit" maxlength="1" data-index="3" id="digit-3">
              <input type="text" class="code-digit" maxlength="1" data-index="4" id="digit-4">
              <input type="text" class="code-digit" maxlength="1" data-index="5" id="digit-5">
            </div>
            <div class="recover-timer">El código expira en <span id="countdown-timer">15:00</span></div>
            <button class="recover-btn" id="btn-verify-code">
              <i class="ri-check-line mr-1"></i> Verificar Código
            </button>
            <button class="recover-back" id="btn-back-step1">← Cambiar correo</button>
            <div style="text-align:center; margin-top:8px;">
              <button class="recover-resend" id="btn-resend-code" style="display:none;">Reenviar código</button>
            </div>
          </div>

          <!-- PASO 3: Nueva contraseña -->
          <div class="recover-step" id="recover-step-3">
            <div class="recover-icon">🔑</div>
            <div class="recover-title">Nueva Contraseña</div>
            <div class="recover-desc">Crea una contraseña segura para tu cuenta.</div>
            <div class="recover-error" id="step3-error"></div>
            <input type="password" class="recover-input" id="new-password" placeholder="Nueva contraseña" autocomplete="new-password">
            <div class="password-strength">
              <div class="strength-bar"><div class="strength-fill" id="strength-fill"></div></div>
              <div class="strength-text" id="strength-text">Ingresa una contraseña</div>
            </div>
            <input type="password" class="recover-input" id="confirm-password" placeholder="Confirmar contraseña" autocomplete="new-password">
            <button class="recover-btn" id="btn-change-password">
              <i class="ri-lock-line mr-1"></i> Cambiar Contraseña
            </button>
          </div>

        </div>
      </div>
      <!-- FIN MODAL RECUPERAR CONTRASEÑA -->

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
      <script src="../vista/js/lottie.js"></script>
      <script src="../vista/js/slick.min.js"></script>
      <script src="../vista/js/select2.min.js"></script>
      <script src="../vista/js/owl.carousel.min.js"></script>
      <script src="../vista/js/jquery.magnific-popup.min.js"></script>
      <script src="../vista/js/smooth-scrollbar.js"></script>
      <script src="../vista/js/chart-custom.js"></script>
      <script src="../vista/js/custom.js"></script>
      <script src="../vista/js/floating_chat.js"></script>

      <script>
      /* ============================================================
         TOAST NOTIFICATIONS — SISTEMA PREMIUM
      ============================================================ */
      function secretToast(type, title, message, duration) {
        duration = duration || 4500;
        var icons = { success: '✅', error: '❌', warning: '⚠️', info: 'ℹ️' };
        var colors = { success: '#10b981', error: '#ef4444', warning: '#f59e0b', info: '#3b82f6' };
        var icon = icons[type] || icons.info;
        var color = colors[type] || colors.info;
        var id = 'toast-' + Date.now();
        var toastHtml = '<div class="secret-toast toast-' + type + '" id="' + id + '" style="border-left-color:' + color + '">' +
          '<span class="toast-icon">' + icon + '</span>' +
          '<div class="toast-body"><div class="toast-title">' + title + '</div>' +
          '<div class="toast-message">' + message + '</div></div>' +
          '<button class="toast-close" onclick="dismissToast(\'' + id + '\')">×</button>' +
          '<div class="toast-progress" style="animation-duration:' + duration + 'ms; color:' + color + '"></div>' +
          '</div>';
        $('#secret-toasts').append(toastHtml);
        setTimeout(function() { dismissToast(id); }, duration);
      }
      function dismissToast(id) {
        var t = document.getElementById(id);
        if(t) { t.classList.add('toast-out'); setTimeout(function(){ if(t) t.remove(); }, 320); }
      }

      /* ============================================================
         RECUPERAR CONTRASEÑA — MODAL LÓGICA
      ============================================================ */
      $(document).ready(function() {
        var currentEmail = '';
        var currentToken = '';
        var timerInterval = null;
        var timerSeconds = 900; // 15 minutos
        var blockInterval = null;

        // Abrir modal
        $('#open-recover-modal').on('click', function() {
          $('#recover-overlay').addClass('active');
          showStep(1);
          verificarBloqueoInicial();
        });

        // Cerrar modal
        $('#close-recover-modal, #recover-overlay').on('click', function(e) {
          if(e.target === this) {
            closeModal();
          }
        });
        $('#recover-modal-box').on('click', function(e) { e.stopPropagation(); });

        function closeModal() {
          $('#recover-overlay').removeClass('active');
          clearInterval(timerInterval);
          clearInterval(blockInterval);
          resetAll();
        }

        function resetAll() {
          currentEmail = ''; currentToken = '';
          $('#recover-email').val('').prop('disabled', false);
          $('.code-digit').val('').removeClass('filled').prop('disabled', false);
          $('#new-password, #confirm-password').val('');
          $('.recover-error, .recover-success').hide().text('');
          $('#btn-send-code').prop('disabled', false);
          $('#btn-verify-code').prop('disabled', false);
          clearInterval(timerInterval);
          clearInterval(blockInterval);
          $('#btn-resend-code').hide();
          $('#countdown-timer').text('15:00');
          updateStrength('');
        }

        function showStep(n) {
          $('.recover-step').removeClass('active');
          $('#recover-step-' + n).addClass('active');
          // Dots
          $('.recover-step-dot').removeClass('active done');
          for(var i = 1; i < n; i++) { $('#dot-' + i).addClass('done'); }
          $('#dot-' + n).addClass('active');
          // Focus
          if(n === 1) setTimeout(function(){ $('#recover-email').focus(); }, 100);
          if(n === 2) setTimeout(function(){ $('#digit-0').focus(); }, 100);
          if(n === 3) setTimeout(function(){ $('#new-password').focus(); }, 100);
        }

        // Verificar si la IP ya está bloqueada por intentos fallidos
        function verificarBloqueoInicial() {
          $.ajax({
            url: '../controlador/cRecuperar.php',
            type: 'POST',
            data: { accion: 'verificar-bloqueo' },
            dataType: 'json',
            success: function(res) {
              if (res.status === 'BLOCKED') {
                handleBlock(res.seconds_left, 1);
              }
            }
          });
        }

        // Manejar el bloqueo de la interfaz y la cuenta regresiva del bloqueo
        function handleBlock(seconds, step) {
          clearInterval(blockInterval);
          var errorId = 'step' + step + '-error';
          var btnId = step === 1 ? '#btn-send-code' : '#btn-verify-code';
          var inputId = step === 1 ? '#recover-email' : '.code-digit';
          
          $(btnId).prop('disabled', true);
          $(inputId).prop('disabled', true);
          
          function updateBlockTimer() {
            var m = Math.floor(seconds / 60);
            var s = seconds % 60;
            var timeStr = (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s;
            
            showError(errorId, 'Demasiados intentos. Acceso bloqueado por seguridad. Inténtalo de nuevo en ' + timeStr);
            
            if(seconds <= 0) {
              clearInterval(blockInterval);
              $('#' + errorId).hide().text('');
              $(btnId).prop('disabled', false);
              $(inputId).prop('disabled', false);
            }
            seconds--;
          }
          updateBlockTimer();
          blockInterval = setInterval(updateBlockTimer, 1000);
        }

        // PASO 1 — Enviar código
        $('#btn-send-code').on('click', function() {
          var email = $('#recover-email').val().trim();
          if(!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            showError('step1-error', 'Por favor ingresa un correo válido.');
            return;
          }
          var btn = $(this);
          btn.prop('disabled', true).html('<i class="ri-loader-line"></i> Enviando...');
          $('#step1-error').hide();

          $.ajax({
            url: '../controlador/cRecuperar.php',
            type: 'POST',
            data: { accion: 'enviar', correo: email },
            dataType: 'json',
            success: function(res) {
              btn.prop('disabled', false).html('<i class="ri-send-plane-line mr-1"></i> Enviar Código');
              if(res.status === 'OK') {
                currentEmail = email;
                currentToken = res.token || '';
                $('#recover-code-desc').text('Ingresa el código de 6 dígitos enviado a ' + email);
                showStep(2);
                startTimer();
                secretToast('success', '¡Código enviado!', 'Revisa tu correo electrónico.');
              } else if(res.status === 'BLOCKED') {
                handleBlock(res.seconds_left, 1);
              } else {
                showError('step1-error', res.error || 'Error al enviar el código.');
              }
            },
            error: function() {
              btn.prop('disabled', false).html('<i class="ri-send-plane-line mr-1"></i> Enviar Código');
              showError('step1-error', 'Error de conexión. Intenta de nuevo.');
            }
          });
        });

        // Timer de 15 minutos para expiración del código
        function startTimer() {
          timerSeconds = 900;
          clearInterval(timerInterval);
          $('#btn-resend-code').hide();
          timerInterval = setInterval(function() {
            timerSeconds--;
            var m = Math.floor(timerSeconds / 60);
            var s = timerSeconds % 60;
            $('#countdown-timer').text((m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s);
            if(timerSeconds <= 0) {
              clearInterval(timerInterval);
              $('#countdown-timer').text('00:00');
              $('#btn-resend-code').show();
              showError('step2-error', 'El código ha expirado. Solicita uno nuevo.');
            }
          }, 1000);
        }

        // Código — navegación entre dígitos
        $(document).on('input', '.code-digit', function() {
          var val = $(this).val().replace(/[^0-9]/g, '');
          $(this).val(val);
          if(val) { $(this).addClass('filled'); var nextIdx = parseInt($(this).data('index')) + 1; if(nextIdx < 6) $('#digit-' + nextIdx).focus(); }
          else { $(this).removeClass('filled'); }
        });
        $(document).on('keydown', '.code-digit', function(e) {
          if(e.key === 'Backspace' && !$(this).val()) {
            var prevIdx = parseInt($(this).data('index')) - 1;
            if(prevIdx >= 0) { $('#digit-' + prevIdx).val('').removeClass('filled').focus(); }
          }
        });
        $(document).on('paste', '#digit-0', function(e) {
          var paste = (e.originalEvent.clipboardData || window.clipboardData).getData('text');
          var digits = paste.replace(/[^0-9]/g, '').slice(0, 6);
          if(digits.length === 6) {
            for(var i = 0; i < 6; i++) { $('#digit-' + i).val(digits[i]).addClass('filled'); }
            $('#digit-5').focus();
            e.preventDefault();
          }
        });

        // PASO 2 — Verificar código
        $('#btn-verify-code').on('click', function() {
          var code = '';
          for(var i = 0; i < 6; i++) { code += $('#digit-' + i).val(); }
          if(code.length < 6) { showError('step2-error', 'Ingresa los 6 dígitos del código.'); return; }
          var btn = $(this);
          btn.prop('disabled', true).html('<i class="ri-loader-line"></i> Verificando...');
          $('#step2-error').hide();

          $.ajax({
            url: '../controlador/cRecuperar.php',
            type: 'POST',
            data: { accion: 'verificar-codigo', correo: currentEmail, codigo: code },
            dataType: 'json',
            success: function(res) {
              btn.prop('disabled', false).html('<i class="ri-check-line mr-1"></i> Verificar Código');
              if(res.status === 'OK') {
                currentToken = res.token;
                clearInterval(timerInterval);
                showStep(3);
                secretToast('success', '¡Código verificado!', 'Ahora crea tu nueva contraseña.');
              } else if(res.status === 'BLOCKED') {
                handleBlock(res.seconds_left, 2);
              } else {
                showError('step2-error', res.error || 'Código incorrecto o expirado.');
              }
            },
            error: function() {
              btn.prop('disabled', false).html('<i class="ri-check-line mr-1"></i> Verificar Código');
              showError('step2-error', 'Error de conexión. Intenta de nuevo.');
            }
          });
        });

        // Volver al paso 1
        $('#btn-back-step1').on('click', function() { clearInterval(timerInterval); showStep(1); });

        // Reenviar código
        $('#btn-resend-code').on('click', function() {
          $('#step2-error').hide();
          $('.code-digit').val('').removeClass('filled');
          $.ajax({
            url: '../controlador/cRecuperar.php',
            type: 'POST',
            data: { accion: 'enviar', correo: currentEmail },
            dataType: 'json',
            success: function(res) {
              if(res.status === 'OK') {
                startTimer();
                $('#btn-resend-code').hide();
                secretToast('info', 'Código reenviado', 'Revisa tu correo nuevamente.');
              } else if(res.status === 'BLOCKED') {
                handleBlock(res.seconds_left, 2);
              }
            }
          });
        });

        // Password strength
        $('#new-password').on('input', function() { updateStrength($(this).val()); });
        function updateStrength(pass) {
          var score = 0;
          if(pass.length >= 8) score++;
          if(/[A-Z]/.test(pass)) score++;
          if(/[0-9]/.test(pass)) score++;
          if(/[^A-Za-z0-9]/.test(pass)) score++;
          var colors = ['#ef4444','#f59e0b','#3b82f6','#10b981'];
          var texts = ['Muy débil','Débil','Buena','Excelente'];
          var fill = $('#strength-fill');
          if(pass.length === 0) { fill.css({width:'0',background:''}); $('#strength-text').text('Ingresa una contraseña'); return; }
          fill.css({width: ((score/4)*100) + '%', background: colors[score-1] || '#ef4444'});
          $('#strength-text').text(texts[score-1] || 'Muy débil').css('color', colors[score-1] || '#ef4444');
        }

        // PASO 3 — Cambiar contraseña
        $('#btn-change-password').on('click', function() {
          var pass = $('#new-password').val();
          var confirm = $('#confirm-password').val();
          if(pass.length < 8) { showError('step3-error', 'La contraseña debe tener al menos 8 caracteres.'); return; }
          if(pass !== confirm) { showError('step3-error', 'Las contraseñas no coinciden.'); return; }
          var btn = $(this);
          btn.prop('disabled', true).html('<i class="ri-lock-line mr-1"></i> Cambiando...');
          $('#step3-error').hide();

          $.ajax({
            url: '../controlador/cRecuperar.php',
            type: 'POST',
            data: { accion: 'restablecer', token: currentToken, password: pass },
            dataType: 'json',
            success: function(res) {
              btn.prop('disabled', false).html('<i class="ri-lock-line mr-1"></i> Cambiar Contraseña');
              if(res.status === 'OK') {
                closeModal();
                secretToast('success', '¡Contraseña cambiada!', 'Ya puedes iniciar sesión con tu nueva contraseña.', 6000);
              } else {
                showError('step3-error', res.error || 'Error al cambiar contraseña.');
              }
            },
            error: function() {
              btn.prop('disabled', false).html('<i class="ri-lock-line mr-1"></i> Cambiar Contraseña');
              showError('step3-error', 'Error de conexión. Intenta de nuevo.');
            }
          });
        });

        function showError(id, msg) { $('#' + id).text(msg).show(); }

        // Mostrar toasts o abrir modal de recuperación según los parámetros y variables de sesión
        <?php if (isset($_GET['sesion_cerrada']) && $_GET['sesion_cerrada'] == 1): ?>
          secretToast('warning', 'Sesión Cerrada', 'Tu sesión previa ha sido finalizada debido a que se inició sesión en otro dispositivo o navegador.', 8000);
        <?php endif; ?>

        <?php if (isset($_SESSION['login_msg'])): ?>
          secretToast('success', 'Seguridad', '<?php echo htmlspecialchars($_SESSION['login_msg'], ENT_QUOTES, 'UTF-8'); ?>', 8000);
          <?php unset($_SESSION['login_msg']); ?>
        <?php endif; ?>

        <?php if (isset($_GET['recuperar']) && $_GET['recuperar'] == 1): ?>
          setTimeout(function() {
            $('#open-recover-modal').click();
          }, 300);
        <?php endif; ?>
      });
      </script>
   </body>
</html>
