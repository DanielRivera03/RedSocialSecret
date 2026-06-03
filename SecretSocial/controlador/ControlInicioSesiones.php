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

    if (session_status() === PHP_SESSION_NONE) {
        session_set_cookie_params(0, '/');
        session_start();
    }
    // IMPORTANDO ARCHIVO DE CONEXION
    require('../modelo/conexion.php');
    require('../modelo/mRegistroNuevosUsuarios.php');
    require('mail_helper.php');

    function parseUserAgent($userAgent) {
        $browser = "Navegador Desconocido";
        $os = "Sistema Operativo Desconocido";
        
        // Detect OS
        if (preg_match('/windows/i', $userAgent)) {
            $os = 'Windows';
        } elseif (preg_match('/macintosh|mac os x/i', $userAgent)) {
            $os = 'macOS';
        } elseif (preg_match('/linux/i', $userAgent)) {
            $os = 'Linux';
        } elseif (preg_match('/iphone|ipad/i', $userAgent)) {
            $os = 'iOS';
        } elseif (preg_match('/android/i', $userAgent)) {
            $os = 'Android';
        }
        
        // Detect Browser
        if (preg_match('/chrome|crios/i', $userAgent) && !preg_match('/edge|edg/i', $userAgent)) {
            $browser = 'Google Chrome';
        } elseif (preg_match('/safari/i', $userAgent) && !preg_match('/chrome|crios/i', $userAgent)) {
            $browser = 'Safari';
        } elseif (preg_match('/firefox|iceweasel/i', $userAgent)) {
            $browser = 'Mozilla Firefox';
        } elseif (preg_match('/edge|edg/i', $userAgent)) {
            $browser = 'Microsoft Edge';
        } elseif (preg_match('/msie|trident/i', $userAgent)) {
            $browser = 'Internet Explorer';
        }
        
        return ['os' => $os, 'browser' => $browser];
    }

    // SI PETICION DE USUARIO NO HA SIDO PROCESADA ENTONCES...
    if(isset($_GET['validarsesion']))
    {
        $peticion_url=$_GET['validarsesion'];  // ENVIO GET DE VALOR ACCION {URL}
    }
    // ASIGNA VALOR POR DEFECTO...
    else
    {
        $peticion_url="inicio";  // CASO CONTRARIO, VALOR POR DEFECTO
    } 
    switch($peticion_url){
        // INICIO DEL SISTEMA {INDEX}
        case "inicio":
            require("../vista/iniciarsesion.php");
        break;
        // VALIDAR USUARIOS -> INICIO DE SESION
        case "validar":
            $cifrado = sha1($_POST['ClaveUsuario']); // RECIBIR CLAVE INGRESADA Y CIFRARLA
            $ClaveUsuarios=crypt($conectarsistema->real_escape_string($_POST['ClaveUsuario']),$cifrado); // COMPARAR CLAVE INGRESADA
            $conectando = conexion::getInstancia();
            $usuario=$conectando->login($conectarsistema,$conectarsistema->real_escape_string($_POST['CorreoUsuario']),$ClaveUsuarios);
            $login=mysqli_fetch_array($usuario);
            if ($usuario) {
                mysqli_free_result($usuario);
            }
            while ($conectarsistema->next_result()) { }
            if($login){
                // RECORDAR USUARIO (1 MES = 30 DÍAS)
                if(isset($_POST['recordarUsuario'])){
                    setcookie('recordar_correo', $_POST['CorreoUsuario'], time() + (30 * 24 * 60 * 60), "/");
                } else {
                    setcookie('recordar_correo', '', time() - 3600, "/");
                }

                $userId = (int)$login['id'];
                $currentSessionId = session_id();
                $clientIP = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
                $clientUA = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';

                // Comprobar sesión duplicada activa en los últimos 15 minutos
                $otherSessionCheck = $conectarsistema->query("SELECT * FROM sesiones_activas 
                    WHERE usuario_id = $userId AND session_id != '$currentSessionId' 
                    AND ultimo_acceso >= NOW() - INTERVAL 15 MINUTE LIMIT 1");

                if ($otherSessionCheck && $otherSessionCheck->num_rows > 0) {
                    // Detección de duplicado
                    $other = $otherSessionCheck->fetch_assoc();
                    $userAgentDetails = parseUserAgent($other['user_agent']);
                    
                    // Almacenar datos temporales en sesión
                    $_SESSION['temp_login_user'] = $login;
                    $_SESSION['duplicate_session_details'] = [
                        'ip' => $other['ip_address'],
                        'os' => $userAgentDetails['os'],
                        'browser' => $userAgentDetails['browser'],
                        'fecha' => $other['ultimo_acceso']
                    ];

                    // Generar token seguro de cierre
                    $tokenCierre = bin2hex(random_bytes(32));
                    $conectarsistema->query("UPDATE usuarios SET 
                        token_cierre_sesion = '$tokenCierre', 
                        fecha_token_cierre = NOW() 
                        WHERE id = $userId");

                    // Construir base URL dinámica
                    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                    $domainName = $_SERVER['HTTP_HOST'];
                    $scriptName = $_SERVER['SCRIPT_NAME'];
                    $subDir = substr($scriptName, 0, strpos($scriptName, '/controlador/'));
                    $baseURL = $protocol . $domainName . $subDir;

                    $linkCerrar = $baseURL . '/controlador/ControlInicioSesiones.php?validarsesion=cerrar_sesiones_token&token=' . $tokenCierre;
                    $linkCambiar = $baseURL . '/IniciarSesion/inicio?recuperar=1';

                    // Enviar correo de alerta
                    $nombreCompleto = htmlspecialchars($login['nombres'] . ' ' . $login['apellidos'], ENT_QUOTES, 'UTF-8');
                    $asunto = '⚠️ Alerta de Seguridad: Inicio de sesión duplicado detectado';
                    $anio = date('Y');
                    $logoPath = __DIR__ . '/../vista/images/logo-full.png';

                    $currentDetails = parseUserAgent($clientUA);

                    $htmlCuerpo = '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alerta de Sesión Duplicada</title>
</head>
<body style="margin: 0; padding: 0; font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; background-color: #f4f6f8;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
        <tr>
            <td align="center" style="padding: 40px 0 20px 0; background-color: #f4f6f8;">
                <table border="0" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); overflow: hidden;">
                    <!-- HEADER -->
                    <tr>
                        <td align="center" style="padding: 30px 40px; background: linear-gradient(135deg, #b92025, #e53935); text-align: center;">
                            <img src="cid:logo_img" alt="Secret Social Logo" style="max-height: 50px; display: block; margin: 0 auto;">
                        </td>
                    </tr>
                    <!-- BODY -->
                    <tr>
                        <td style="padding: 40px 40px 30px 40px; color: #333333; line-height: 1.6;">
                            <h2 style="margin-top: 0; color: #b92025; font-size: 22px; font-weight: 700; text-align: center;">⚠️ Inicio de Sesión Duplicado Detectado</h2>
                            <p style="font-size: 15px; margin-bottom: 20px;">Estimado(a) <strong>' . $nombreCompleto . '</strong>,</p>
                            <p style="font-size: 15px; margin-bottom: 25px;">Hemos detectado un intento de inicio de sesión en tu cuenta de <strong>Secret Social</strong> mientras había otra sesión activa. Por razones de seguridad, hemos bloqueado temporalmente el acceso hasta que decidas qué acción tomar.</p>
                            
                            <!-- TECHNICAL DETAILS -->
                            <h3 style="color: #1a1a2e; font-size: 15px; font-weight: bold; margin-bottom: 12px; border-bottom: 1px solid #eee; padding-bottom: 6px;">Detalles técnicos del nuevo intento:</h3>
                            <table border="0" cellpadding="5" cellspacing="0" width="100%" style="font-size: 14px; margin-bottom: 30px; background-color: #fafafa; border-radius: 8px; padding: 10px;">
                                <tr><td width="35%"><strong>Dirección IP:</strong></td><td>' . $clientIP . '</td></tr>
                                <tr><td><strong>Sistema Operativo:</strong></td><td>' . $currentDetails['os'] . '</td></tr>
                                <tr><td><strong>Navegador:</strong></td><td>' . $currentDetails['browser'] . '</td></tr>
                                <tr><td><strong>Fecha y Hora:</strong></td><td>' . date('Y-m-d H:i:s') . '</td></tr>
                            </table>

                            <!-- BUTTONS -->
                            <div style="text-align: center; margin: 30px 0;">
                                <a href="' . $linkCerrar . '" style="background-color: #b92025; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 14px; display: inline-block; margin-right: 10px; box-shadow: 0 4px 6px rgba(185,32,37,0.2); text-align: center;">Cerrar todas las sesiones</a>
                                <a href="' . $linkCambiar . '" style="background-color: #4b5563; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 14px; display: inline-block; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center;">Cambiar contraseña</a>
                            </div>

                            <hr style="border: 0; border-top: 1px solid #eeeeee; margin: 25px 0;">
                            
                            <!-- SECURITY RECOMMENDATIONS -->
                            <h3 style="color: #1a1a2e; font-size: 15px; font-weight: bold; margin-bottom: 12px;">🛡️ Recomendaciones de seguridad importantes:</h3>
                            <ul style="padding-left: 20px; margin-bottom: 0; font-size: 13.5px; color: #555555; line-height: 1.7;">
                                <li style="margin-bottom: 8px;">Si fuiste tú intentando iniciar sesión desde otro navegador o dispositivo, puedes usar el botón de arriba para cerrar la sesión previa y continuar.</li>
                                <li style="margin-bottom: 8px;">Si no has intentado iniciar sesión recientemente, es muy probable que alguien más conozca tu contraseña. Te aconsejamos pulsar <strong>Cambiar contraseña</strong> inmediatamente.</li>
                            </ul>
                        </td>
                    </tr>
                    <!-- FOOTER -->
                    <tr>
                        <td align="center" style="padding: 20px 40px; background-color: #fcfcfc; border-top: 1px solid #eeeeee; color: #888888; font-size: 12px; text-align: center;">
                            <p style="margin: 0 0 10px 0;">© ' . $anio . ' Secret Social. Todos los derechos reservados.</p>
                            <p style="margin: 0;">Este es un mensaje automático de seguridad. Por favor, no respondas a este correo.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';

                    $cuerpoTexto = "Hola {$nombreCompleto},\n\nHemos detectado un inicio de sesión duplicado en tu cuenta de Secret Social.\n\nDetalles del intento:\nIP: {$clientIP}\nSistema Operativo: {$currentDetails['os']}\nNavegador: {$currentDetails['browser']}\nFecha: " . date('Y-m-d H:i:s') . "\n\nPara cerrar todas las sesiones activas entra aquí: {$linkCerrar}\nPara cambiar tu contraseña entra aquí: {$linkCambiar}\n\nSi no fuiste tú, por favor cambia tu contraseña de forma urgente.\n\n— Secret Social";

                    enviarCorreo($login['correo'], $asunto, $htmlCuerpo, $cuerpoTexto, ['logo_img' => $logoPath]);

                    header('location:../SesionDuplicada/alerta');
                    exit();
                }

                // Registrar la nueva sesión activa (después de borrar las anteriores de este usuario)
                $conectarsistema->query("DELETE FROM sesiones_activas WHERE usuario_id = $userId");
                $conectarsistema->query("INSERT INTO sesiones_activas (usuario_id, session_id, ip_address, user_agent) 
                    VALUES ($userId, '$currentSessionId', '$clientIP', '$clientUA')");

                // GUARDADO DE DATOS DE USUARIO {SESIONES}
                $_SESSION['id_usuario']=$login['id']; // ID UNICO IDENTIFICADOR DE USUARIO
                $_SESSION['nombre_usuario']=$login['nombres']; // PRIMER NOMBRE DE USUARIOS
                $_SESSION['apellido_usuario']=$login['apellidos']; // PRIMER APELLIDO DE USUARIOS
                $_SESSION['usuario_unico']=$login['usuario']; // NOMBRE DE USUARIO UNICO USUARIOS
                $_SESSION['correo_usuario']=$login['correo']; // CORREO DE USUARIO
                $_SESSION['fotos_perfiles']=$login['fotoperfil']; // FOTO DE PERFIL USUARIOS
                $_SESSION['fotos_portadas']=$login['foto_portada']; // FOTO DE PORTADA GRANDE USUARIOS
                $_SESSION['pais_usuarios']=$login['pais']; // PAIS DE RESIDENDIE DE USUARIOS
                $_SESSION['comprobar_perfil']=$login['completarperfil']; // COMPROBACION DE PERFIL
                
                if($login['completarperfil']==1){
                    header('location:cRegistroNuevosUsuarios.php?nuevoregistro=completarperfil');
                }else if($login['completarperfil']==0){
                    header('location:../Feed/inicio');
                }else{
                    require("../vista/iniciarsesion.php");
                }
            }else{
                header('location:../CredencialesIncorrectas/error');
            }
            exit();
        break;

        // FORZAR INICIO DE SESIÓN CERRANDO LAS DEMÁS
        case "forzar_login":
            if (isset($_SESSION['temp_login_user'])) {
                $login = $_SESSION['temp_login_user'];
                $userId = (int)$login['id'];
                $currentSessionId = session_id();
                $clientIP = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
                $clientUA = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';

                // Cerrar las otras sesiones activas
                $conectarsistema->query("DELETE FROM sesiones_activas WHERE usuario_id = $userId");
                
                // Registrar la sesión actual
                $conectarsistema->query("INSERT INTO sesiones_activas (usuario_id, session_id, ip_address, user_agent) 
                    VALUES ($userId, '$currentSessionId', '$clientIP', '$clientUA')");

                // Iniciar la sesión de PHP
                $_SESSION['id_usuario']=$login['id'];
                $_SESSION['nombre_usuario']=$login['nombres'];
                $_SESSION['apellido_usuario']=$login['apellidos'];
                $_SESSION['usuario_unico']=$login['usuario'];
                $_SESSION['correo_usuario']=$login['correo'];
                $_SESSION['fotos_perfiles']=$login['fotoperfil'];
                $_SESSION['fotos_portadas']=$login['foto_portada'];
                $_SESSION['pais_usuarios']=$login['pais'];
                $_SESSION['comprobar_perfil']=$login['completarperfil'];

                // Limpiar variables temporales
                unset($_SESSION['temp_login_user']);
                unset($_SESSION['duplicate_session_details']);

                if($login['completarperfil']==1){
                    header('location:cRegistroNuevosUsuarios.php?nuevoregistro=completarperfil');
                }else if($login['completarperfil']==0){
                    header('location:../Feed/inicio');
                }
            } else {
                header('location:../IniciarSesion/inicio');
            }
            exit();
        break;

        // CERRAR SESIONES POR TOKEN DE CORREO ELECTRÓNICO
        case "cerrar_sesiones_token":
            $token = isset($_GET['token']) ? htmlspecialchars(trim($_GET['token']), ENT_QUOTES, 'UTF-8') : '';
            if (!empty($token)) {
                $tokenEsc = $conectarsistema->real_escape_string($token);
                // Buscar el usuario con este token de cierre (vigente por 2 horas)
                $checkToken = $conectarsistema->query("SELECT id FROM usuarios 
                    WHERE token_cierre_sesion = '$tokenEsc' 
                    AND fecha_token_cierre >= NOW() - INTERVAL 2 HOUR LIMIT 1");
                
                if ($checkToken && $checkToken->num_rows > 0) {
                    $user = $checkToken->fetch_assoc();
                    $userId = (int)$user['id'];

                    // Eliminar todas las sesiones de este usuario
                    $conectarsistema->query("DELETE FROM sesiones_activas WHERE usuario_id = $userId");
                    
                    // Limpiar el token de cierre
                    $conectarsistema->query("UPDATE usuarios SET 
                        token_cierre_sesion = NULL, 
                        fecha_token_cierre = NULL 
                        WHERE id = $userId");

                    // Configurar el mensaje para la vista
                    $_SESSION['login_msg'] = 'Se han cerrado todas las sesiones activas correctamente. Ya puedes iniciar sesión de forma segura.';
                }
            }
            header('location:../IniciarSesion/inicio');
            exit();
        break;

        // CERRAR SESION
        case "cerrarsesion":
            if (isset($_SESSION['id_usuario'])) {
                $userId = (int)$_SESSION['id_usuario'];
                $currentSessionId = session_id();
                $conectarsistema->query("DELETE FROM sesiones_activas WHERE usuario_id = $userId AND session_id = '$currentSessionId'");
            }
            session_unset();
            session_destroy();
            if (isset($_GET['sesion_cerrada']) && $_GET['sesion_cerrada'] == 1) {
                header('location:../IniciarSesion/inicio?sesion_cerrada=1');
            } else {
                header('location:../index.php');
            }
            $conectarsistema->close(); // CERRANDO CONEXION
        break;

        // VERIFICACIÓN DE SESIÓN ACTIVA (AJAX POLLING)
        case "check_session":
            header('Content-Type: application/json; charset=utf-8');
            if (session_status() === PHP_SESSION_ACTIVE && isset($_SESSION['id_usuario'])) {
                $userId = (int)$_SESSION['id_usuario'];
                $sessId = $conectarsistema->real_escape_string(session_id());
                $check = $conectarsistema->query("SELECT id FROM sesiones_activas WHERE usuario_id = $userId AND session_id = '$sessId'");
                if (!$check || $check->num_rows == 0) {
                    echo json_encode(['status' => 'KICKED']);
                } else {
                    echo json_encode(['status' => 'OK']);
                }
            } else {
                echo json_encode(['status' => 'GUEST']);
            }
            $conectarsistema->close();
            exit();
        break;
        // REDIRECCION LUEGO DE COMPLETAR PERFIL DE USUARIO
        case "perfilcompletado":
            session_unset();
            session_destroy();
            header('location:../index.php');
            $conectarsistema->close(); // CERRANDO CONEXION
        break;
        // BLOQUEAR ACCIONES NO EXISTENTES
        default:
            $peticion_url=$_GET['noautorizado'];
            header('location:../AccesoDenegado=restringido');
            $conectarsistema->close(); // CERRANDO CONEXION
        break; 
    }
?>