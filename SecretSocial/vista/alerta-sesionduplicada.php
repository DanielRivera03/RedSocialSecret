<?php
/*
--------------------------------------------------------
║            SECRET - RED SOCIAL PHP NATIVO            ║
--------------------------------------------------------           
    VISTA: Alerta de Sesión Duplicada
    - Muestra detalles técnicos de la sesión activa
    - Ofrece forzar login o cambiar contraseña
--------------------------------------------------------
*/
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirigir si no hay datos de sesión duplicada
if (!isset($_SESSION['temp_login_user']) || !isset($_SESSION['duplicate_session_details'])) {
    header('location:../IniciarSesion/inicio');
    exit();
}

$login = $_SESSION['temp_login_user'];
$details = $_SESSION['duplicate_session_details'];
?>
<!doctype html>
<html lang="es">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Secret - Alerta de Seguridad</title>
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
         body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: #f8fafc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
         }
         .alert-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 40px;
            max-width: 580px;
            width: 100%;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            text-align: center;
            animation: fadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
         }
         @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
         }
         .alert-icon {
            font-size: 64px;
            color: #ef4444;
            margin-bottom: 24px;
            display: inline-block;
            animation: pulse 2s infinite;
         }
         @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
         }
         .alert-title {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 12px;
            color: #ffffff;
            letter-spacing: -0.5px;
         }
         .alert-subtitle {
            font-size: 15px;
            color: #94a3b8;
            margin-bottom: 32px;
            line-height: 1.6;
         }
         .details-box {
            background: rgba(15, 23, 42, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 24px;
            text-align: left;
            margin-bottom: 32px;
         }
         .details-title {
            font-size: 13px;
            font-weight: 600;
            color: #ef4444;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
         }
         .details-grid {
            display: grid;
            grid-template-columns: 140px 1fr;
            row-gap: 12px;
            font-size: 14px;
            color: #cbd5e1;
         }
         .details-label {
            font-weight: 500;
            color: #64748b;
         }
         .details-val {
            font-weight: 600;
         }
         .btn-action-primary {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: #ffffff;
            border: none;
            border-radius: 14px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 20px rgba(239, 68, 68, 0.2);
            text-decoration: none !important;
            margin-bottom: 12px;
         }
         .btn-action-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 24px rgba(239, 68, 68, 0.35);
            color: #ffffff;
         }
         .btn-action-secondary {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 14px;
            background: rgba(255, 255, 255, 0.05);
            color: #cbd5e1;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 14px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none !important;
         }
         .btn-action-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
         }
         .security-tips {
            margin-top: 32px;
            font-size: 12px;
            color: #64748b;
            text-align: left;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            padding-top: 24px;
            line-height: 1.5;
         }
      </style>
   </head>
   <body>
      <div class="alert-card">
         <div class="alert-icon">
            <i class="ri-shield-user-line"></i>
         </div>
         <h1 class="alert-title">Sesión Activa Detectada</h1>
         <p class="alert-subtitle">
            Hola <strong><?php echo htmlspecialchars($login['nombres'], ENT_QUOTES, 'UTF-8'); ?></strong>, 
            hemos detectado que tu cuenta ya tiene una sesión abierta en otro dispositivo o navegador.
         </p>

         <!-- Detalles técnicos de la sesión activa -->
         <div class="details-box">
            <div class="details-title">
               <i class="ri-radar-line"></i> Detalles de la sesión activa
            </div>
            <div class="details-grid">
               <div class="details-label">Dirección IP:</div>
               <div class="details-val"><?php echo htmlspecialchars($details['ip'], ENT_QUOTES, 'UTF-8'); ?></div>
               
               <div class="details-label">Sist. Operativo:</div>
               <div class="details-val"><?php echo htmlspecialchars($details['os'], ENT_QUOTES, 'UTF-8'); ?></div>
               
               <div class="details-label">Navegador:</div>
               <div class="details-val"><?php echo htmlspecialchars($details['browser'], ENT_QUOTES, 'UTF-8'); ?></div>
               
               <div class="details-label">Último acceso:</div>
               <div class="details-val"><?php echo htmlspecialchars($details['fecha'], ENT_QUOTES, 'UTF-8'); ?></div>
            </div>
         </div>

         <!-- Acciones -->
         <a href="../controlador/ControlInicioSesiones.php?validarsesion=forzar_login" class="btn-action-primary">
            <i class="ri-login-box-line"></i> Cerrar otras sesiones y continuar
         </a>
         
         <a href="../IniciarSesion/inicio?recuperar=1" class="btn-action-secondary">
            <i class="ri-lock-password-line"></i> Cerrar y cambiar contraseña por seguridad
         </a>

         <!-- Recomendaciones de seguridad -->
         <div class="security-tips">
            <strong>¿No reconoces esta actividad?</strong><br>
            Si crees que alguien ha accedido a tu cuenta sin tu consentimiento, te recomendamos pulsar <strong>Cerrar y cambiar contraseña</strong> de inmediato para proteger tu perfil y tus datos personales en Secret Social.
         </div>
      </div>

      <!-- Optional JavaScript -->
      <script src="../vista/js/jquery.min.js"></script>
      <script src="../vista/js/popper.min.js"></script>
      <script src="../vista/js/bootstrap.min.js"></script>
   </body>
</html>
