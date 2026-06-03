<?php
/*
--------------------------------------------------------
║            SECRET - RED SOCIAL PHP NATIVO            ║
--------------------------------------------------------
    CONTROLADOR: Recuperación de contraseña (Refactorizado)
    - Bloqueo por IP/Correo tras intentos fallidos (15 min)
    - Envío de código de 6 dígitos mediante Gmail SMTP
    - Plantillas HTML de correo profesionales y seguras
    - Recordatorio de mejores prácticas de seguridad
--------------------------------------------------------
*/
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require('../modelo/conexion.php');
require('mail_helper.php');

header('Content-Type: application/json; charset=utf-8');

// Sanitizar inputs de forma segura
function sanitizeInput($str) {
    return htmlspecialchars(strip_tags(trim($str)), ENT_QUOTES, 'UTF-8');
}

// Obtener tiempo restante de bloqueo en segundos (15 minutos = 900 segundos)
function getBlockTimeRemaining($conectar, $ip, $correo = '') {
    $ipEsc = $conectar->real_escape_string($ip);
    $correoEsc = $conectar->real_escape_string($correo);
    
    // Crear tabla de intentos si no existe
    $conectar->query("CREATE TABLE IF NOT EXISTS intentos_recuperacion (
        id INT AUTO_INCREMENT PRIMARY KEY,
        ip_address VARCHAR(45) NOT NULL,
        correo VARCHAR(255) NULL,
        tipo VARCHAR(50) NOT NULL,
        fecha_intento TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_ip (ip_address),
        INDEX idx_correo (correo)
    )");
    
    $where = "ip_address = '$ipEsc'";
    if (!empty($correo)) {
        $where .= " OR (correo = '$correoEsc' AND correo IS NOT NULL)";
    }
    
    $query = "SELECT COUNT(*) as total, TIMESTAMPDIFF(SECOND, MAX(fecha_intento), NOW()) as segundos_transcurridos 
              FROM intentos_recuperacion 
              WHERE ($where) AND fecha_intento >= NOW() - INTERVAL 15 MINUTE";
              
    $res = $conectar->query($query);
    if ($res) {
        $row = $res->fetch_assoc();
        if ($row['total'] >= 3) {
            $segTranscurridos = (int)$row['segundos_transcurridos'];
            $segundosRestantes = 900 - $segTranscurridos;
            return $segundosRestantes > 0 ? $segundosRestantes : 0;
        }
    }
    return 0;
}

// Registrar un intento de recuperación o validación
function registrarIntento($conectar, $ip, $correo = '', $tipo = 'envio_codigo') {
    $ipEsc = $conectar->real_escape_string($ip);
    $correoEsc = !empty($correo) ? "'" . $conectar->real_escape_string($correo) . "'" : "NULL";
    $tipoEsc = $conectar->real_escape_string($tipo);
    
    $conectar->query("INSERT INTO intentos_recuperacion (ip_address, correo, tipo) 
                      VALUES ('$ipEsc', $correoEsc, '$tipoEsc')");
                      
    // Limpieza de intentos antiguos (> 1 día)
    $conectar->query("DELETE FROM intentos_recuperacion WHERE fecha_intento < NOW() - INTERVAL 1 DAY");
}

$accion = isset($_POST['accion']) ? sanitizeInput($_POST['accion']) : '';
$clientIP = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

// Asegurarse de que la tabla 'intentos_recuperacion' tenga la estructura correcta (recrear si es necesario)
$checkCol = $conectarsistema->query("SHOW COLUMNS FROM intentos_recuperacion LIKE 'correo'");
if ($checkCol && $checkCol->num_rows == 0) {
    $conectarsistema->query("DROP TABLE IF EXISTS intentos_recuperacion");
}

// Asegurarse de que la tabla 'usuarios' tenga las columnas necesarias
$conectarsistema->query("ALTER TABLE usuarios 
    ADD COLUMN IF NOT EXISTS codigo_recuperacion VARCHAR(255) NULL,
    ADD COLUMN IF NOT EXISTS fecha_codigo DATETIME NULL,
    ADD COLUMN IF NOT EXISTS token_recuperacion VARCHAR(64) NULL,
    ADD COLUMN IF NOT EXISTS fecha_token DATETIME NULL
");

// ===================== ACCIÓN: VERIFICAR BLOQUEO INICIAL =====================
if ($accion === 'verificar-bloqueo') {
    $correo = sanitizeInput($_POST['correo'] ?? '');
    $blockSeconds = getBlockTimeRemaining($conectarsistema, $clientIP, $correo);
    if ($blockSeconds > 0) {
        echo json_encode(['status' => 'BLOCKED', 'seconds_left' => $blockSeconds]);
    } else {
        echo json_encode(['status' => 'OK']);
    }
    exit();
}

// ===================== ACCIÓN: ENVIAR CÓDIGO =====================
if($accion === 'enviar') {
    $correo = sanitizeInput($_POST['correo'] ?? '');
    
    if(!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['error' => 'Correo electrónico inválido.']);
        exit();
    }

    // Verificar si está bloqueado antes de procesar
    $blockSeconds = getBlockTimeRemaining($conectarsistema, $clientIP, $correo);
    if($blockSeconds > 0) {
        echo json_encode([
            'status' => 'BLOCKED',
            'error' => 'Demasiados intentos. Acceso bloqueado por 15 minutos.',
            'seconds_left' => $blockSeconds
        ]);
        exit();
    }

    // Registrar intento
    registrarIntento($conectarsistema, $clientIP, $correo, 'envio_codigo');
    
    // Verificar si con este intento recién se activó el bloqueo (llegó a 3)
    $blockSeconds = getBlockTimeRemaining($conectarsistema, $clientIP, $correo);
    if($blockSeconds > 0) {
        echo json_encode([
            'status' => 'BLOCKED',
            'error' => 'Demasiados intentos. Acceso bloqueado por 15 minutos.',
            'seconds_left' => $blockSeconds
        ]);
        exit();
    }

    $correoEsc = $conectarsistema->real_escape_string($correo);
    $check = $conectarsistema->query("SELECT id, nombres FROM usuarios WHERE correo = '$correoEsc' LIMIT 1");
    
    if($check && $check->num_rows > 0) {
        $user = $check->fetch_assoc();
        
        // Generar código de 6 dígitos
        $codigo = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $codigoHash = password_hash($codigo, PASSWORD_DEFAULT);
        
        $conectarsistema->query("UPDATE usuarios SET 
            codigo_recuperacion = '$codigoHash', 
            fecha_codigo = NOW()
            WHERE correo = '$correoEsc'");
        
        // Cargar plantilla HTML profesional
        $nombre = htmlspecialchars($user['nombres'], ENT_QUOTES, 'UTF-8');
        $asunto = 'Código de verificación de contraseña — Secret';
        $anio = date('Y');
        $logoPath = __DIR__ . '/../vista/images/logo-full.png';
        
        $cuerpoHTML = '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recupera tu contraseña</title>
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
                            <h2 style="margin-top: 0; color: #1a1a2e; font-size: 22px; font-weight: 700;">Restablece tu contraseña</h2>
                            <p style="font-size: 15px; margin-bottom: 20px;">Hola <strong>' . $nombre . '</strong>,</p>
                            <p style="font-size: 15px; margin-bottom: 25px;">Hemos recibido una solicitud para restablecer la contraseña de tu cuenta en Secret Social. Utiliza el siguiente código de verificación de 6 dígitos para continuar con el proceso:</p>
                            
                            <!-- CODE BLOCK -->
                            <div style="text-align: center; margin: 25px 0; padding: 18px; background-color: #fdf2f2; border: 1px solid #fee2e2; border-radius: 12px;">
                                <span style="font-family: \'Courier New\', Courier, monospace; font-size: 34px; font-weight: bold; letter-spacing: 6px; color: #e53935; text-align: center; display: inline-block;">' . $codigo . '</span>
                            </div>
                            
                            <p style="font-size: 13px; color: #666666; margin-bottom: 25px; text-align: center;">Este código es de un solo uso y expirará en <strong>15 minutos</strong> por razones de seguridad.</p>
                            
                            <hr style="border: 0; border-top: 1px solid #eeeeee; margin: 25px 0;">
                            
                            <!-- SECURITY RECOMMENDATIONS -->
                            <h3 style="color: #1a1a2e; font-size: 15px; font-weight: bold; margin-bottom: 12px;">🛡️ Recomendaciones de seguridad importantes:</h3>
                            <ul style="padding-left: 20px; margin-bottom: 0; font-size: 13.5px; color: #555555; line-height: 1.7;">
                                <li style="margin-bottom: 8px;"><strong>No compartas este código:</strong> Ningún miembro del equipo de Secret te solicitará códigos de verificación bajo ningún concepto.</li>
                                <li style="margin-bottom: 8px;"><strong>Contraseñas seguras:</strong> Te sugerimos crear una contraseña robusta con letras mayúsculas, minúsculas, números y símbolos especiales.</li>
                                <li style="margin-bottom: 8px;"><strong>Evita la reutilización:</strong> No uses la misma contraseña que tengas registrada en otras plataformas.</li>
                                <li style="margin-bottom: 8px;"><strong>¿No solicitaste este cambio?</strong> Si no has iniciado este proceso, no te preocupes; tu cuenta sigue segura y puedes ignorar este mensaje.</li>
                            </ul>
                        </td>
                    </tr>
                    <!-- FOOTER -->
                    <tr>
                        <td align="center" style="padding: 20px 40px; background-color: #fcfcfc; border-top: 1px solid #eeeeee; color: #888888; font-size: 12px; text-align: center;">
                            <p style="margin: 0 0 10px 0;">© ' . $anio . ' Secret Social. Todos los derechos reservados.</p>
                            <p style="margin: 0;">Este correo es una notificación automática del sistema. Por favor, no respondas a este mensaje.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';

        $cuerpoTexto = "Hola {$nombre},\n\nHemos recibido una solicitud para restablecer tu contraseña en Secret Social. Tu código de verificación de 6 dígitos es:\n\n► {$codigo} ◄\n\nEste código expira en 15 minutos.\n\nSi no lo solicitaste, puedes ignorar este mensaje.\n\n— Secret Social";

        enviarCorreo($correo, $asunto, $cuerpoHTML, $cuerpoTexto, ['logo_img' => $logoPath]);
        
        echo json_encode([
            'status' => 'OK',
            'message' => 'Código enviado correctamente.'
        ]);
    } else {
        // Respuesta ambigua para evitar enumeración de cuentas
        echo json_encode(['status' => 'OK', 'message' => 'Si el correo existe, recibirás un código.']);
    }
    exit();
}

// ===================== ACCIÓN: VERIFICAR CÓDIGO =====================
if($accion === 'verificar-codigo') {
    $correo = sanitizeInput($_POST['correo'] ?? '');
    $codigoIngresado = sanitizeInput($_POST['codigo'] ?? '');
    
    if(!filter_var($correo, FILTER_VALIDATE_EMAIL) || strlen($codigoIngresado) !== 6 || !ctype_digit($codigoIngresado)) {
        echo json_encode(['error' => 'Datos inválidos.']);
        exit();
    }

    // Verificar si está bloqueado
    $blockSeconds = getBlockTimeRemaining($conectarsistema, $clientIP, $correo);
    if($blockSeconds > 0) {
        echo json_encode([
            'status' => 'BLOCKED',
            'error' => 'Demasiados intentos. Acceso bloqueado por 15 minutos.',
            'seconds_left' => $blockSeconds
        ]);
        exit();
    }

    $correoEsc = $conectarsistema->real_escape_string($correo);
    
    // Verificar código válido (dentro de 15 minutos)
    $check = $conectarsistema->query("SELECT id, codigo_recuperacion FROM usuarios 
        WHERE correo = '$correoEsc' 
        AND fecha_codigo >= NOW() - INTERVAL 15 MINUTE
        AND codigo_recuperacion IS NOT NULL
        LIMIT 1");

    if($check && $check->num_rows > 0) {
        $user = $check->fetch_assoc();
        
        if(password_verify($codigoIngresado, $user['codigo_recuperacion'])) {
            // Código correcto: Generar token de un solo uso para cambio
            $token = bin2hex(random_bytes(32));
            $userId = (int)$user['id'];
            $conectarsistema->query("UPDATE usuarios SET 
                token_recuperacion = '$token',
                fecha_token = NOW(),
                codigo_recuperacion = NULL,
                fecha_codigo = NULL
                WHERE id = $userId");
            
            // Limpiar intentos de bloqueo tras verificación exitosa
            $conectarsistema->query("DELETE FROM intentos_recuperacion WHERE correo = '$correoEsc' OR ip_address = '$clientIP'");
            
            echo json_encode(['status' => 'OK', 'token' => $token]);
        } else {
            // Código incorrecto
            registrarIntento($conectarsistema, $clientIP, $correo, 'error_codigo');
            
            $blockSeconds = getBlockTimeRemaining($conectarsistema, $clientIP, $correo);
            if($blockSeconds > 0) {
                echo json_encode([
                    'status' => 'BLOCKED',
                    'error' => 'Código incorrecto. Has superado el límite y has sido bloqueado por 15 minutos.',
                    'seconds_left' => $blockSeconds
                ]);
            } else {
                echo json_encode(['error' => 'Código incorrecto. Verifica e intenta de nuevo.']);
            }
        }
    } else {
        // Código inexistente o expirado
        registrarIntento($conectarsistema, $clientIP, $correo, 'error_codigo');
        
        $blockSeconds = getBlockTimeRemaining($conectarsistema, $clientIP, $correo);
        if($blockSeconds > 0) {
            echo json_encode([
                'status' => 'BLOCKED',
                'error' => 'Código incorrecto o expirado. Has sido bloqueado por 15 minutos.',
                'seconds_left' => $blockSeconds
            ]);
        } else {
            echo json_encode(['error' => 'El código ha expirado o es inválido. Solicita uno nuevo.']);
        }
    }
    exit();
}

// ===================== ACCIÓN: RESTABLECER CONTRASEÑA =====================
if($accion === 'restablecer') {
    $token = sanitizeInput($_POST['token'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if(strlen($token) !== 64 || strlen($password) < 8) {
        echo json_encode(['error' => 'Datos inválidos. La contraseña debe tener al menos 8 caracteres.']);
        exit();
    }

    $tokenEsc = $conectarsistema->real_escape_string($token);
    
    // Verificar token válido (dentro de 30 minutos)
    $check = $conectarsistema->query("SELECT id, nombres, correo FROM usuarios 
        WHERE token_recuperacion = '$tokenEsc' 
        AND fecha_token >= NOW() - INTERVAL 30 MINUTE
        LIMIT 1");

    if($check && $check->num_rows > 0) {
        $user = $check->fetch_assoc();
        $userId = (int)$user['id'];
        $nombres = $user['nombres'];
        $correo = $user['correo'];
        
        // Encriptar la contraseña (formato legacy compatible con el sistema: crypt + sha1)
        $cifrado = sha1($password);
        $oldHash = crypt($conectarsistema->real_escape_string($password), $cifrado);
        $oldHashEsc = $conectarsistema->real_escape_string($oldHash);
        
        $conectarsistema->query("UPDATE usuarios SET 
            contrasenia = '$oldHashEsc',
            token_recuperacion = NULL,
            fecha_token = NULL
            WHERE id = $userId");
        
        // Enviar correo de confirmación profesional con sugerencias de seguridad adicionales
        $asuntoConf = 'Tu contraseña ha sido restablecida con éxito — Secret';
        $anio = date('Y');
        $logoPath = __DIR__ . '/../vista/images/logo-full.png';
        
        $htmlCuerpoConf = '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contraseña Restablecida</title>
</head>
<body style="margin: 0; padding: 0; font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; background-color: #f4f6f8;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
        <tr>
            <td align="center" style="padding: 40px 0 20px 0; background-color: #f4f6f8;">
                <table border="0" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); overflow: hidden;">
                    <!-- HEADER -->
                    <tr>
                        <td align="center" style="padding: 30px 40px; background: linear-gradient(135deg, #10b981, #059669); text-align: center;">
                            <img src="cid:logo_img" alt="Secret Social Logo" style="max-height: 50px; display: block; margin: 0 auto;">
                        </td>
                    </tr>
                    <!-- BODY -->
                    <tr>
                        <td style="padding: 40px 40px 30px 40px; color: #333333; line-height: 1.6;">
                            <h2 style="margin-top: 0; color: #1a1a2e; font-size: 22px; font-weight: 700;">¡Tu contraseña ha sido actualizada!</h2>
                            <p style="font-size: 15px; margin-bottom: 20px;">Hola <strong>' . htmlspecialchars($nombres, ENT_QUOTES, 'UTF-8') . '</strong>,</p>
                            <p style="font-size: 15px; margin-bottom: 25px;">Te confirmamos que la contraseña de tu cuenta en <strong>Secret Social</strong> ha sido restablecida exitosamente. Ya puedes iniciar sesión con tu nueva contraseña.</p>
                            
                            <div style="text-align: center; margin: 25px 0; padding: 15px; background-color: #ecfdf5; border: 1px solid #d1fae5; border-radius: 12px;">
                                <span style="font-size: 15px; font-weight: bold; color: #065f46;">🔒 Tu cuenta se encuentra protegida con éxito.</span>
                            </div>
                            
                            <hr style="border: 0; border-top: 1px solid #eeeeee; margin: 25px 0;">
                            
                            <!-- SECURITY RECOMMENDATIONS -->
                            <h3 style="color: #1a1a2e; font-size: 15px; font-weight: bold; margin-bottom: 12px;">🛡️ Consejos adicionales para proteger tu cuenta:</h3>
                            <ul style="padding-left: 20px; margin-bottom: 0; font-size: 13.5px; color: #555555; line-height: 1.7;">
                                <li style="margin-bottom: 8px;"><strong>Monitorea tus sesiones activas:</strong> Comprueba periódicamente los dispositivos conectados en tu perfil de usuario.</li>
                                <li style="margin-bottom: 8px;"><strong>Actualiza tu información de respaldo:</strong> Verifica que tu correo de contacto sea el correcto para futuras recuperaciones.</li>
                                <li style="margin-bottom: 8px;"><strong>Evita acceder desde redes públicas:</strong> Cuando uses wifi público, asegúrate de utilizar una VPN o evitar transacciones con datos confidenciales.</li>
                                <li style="margin-bottom: 8px;"><strong>¿No has realizado este cambio?</strong> Si no modificaste tu contraseña, por favor ponte en contacto de forma urgente con nuestro equipo para asegurar y bloquear tu perfil inmediatamente.</li>
                            </ul>
                        </td>
                    </tr>
                    <!-- FOOTER -->
                    <tr>
                        <td align="center" style="padding: 20px 40px; background-color: #fcfcfc; border-top: 1px solid #eeeeee; color: #888888; font-size: 12px; text-align: center;">
                            <p style="margin: 0 0 10px 0;">© ' . $anio . ' Secret Social. Todos los derechos reservados.</p>
                            <p style="margin: 0;">Este correo es una notificación automática del sistema. Por favor, no respondas a este mensaje.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';
        
        $cuerpoTextoConf = "Hola {$nombres},\n\nTe confirmamos que la contraseña de tu cuenta en Secret Social ha sido restablecida exitosamente.\n\nSi no realizaste este cambio, por favor ponte en contacto inmediato con nuestro equipo de soporte.\n\n— Secret Social";

        enviarCorreo($correo, $asuntoConf, $htmlCuerpoConf, $cuerpoTextoConf, ['logo_img' => $logoPath]);

        echo json_encode(['status' => 'OK', 'message' => 'Contraseña cambiada exitosamente.']);
    } else {
        echo json_encode(['error' => 'El token es inválido o ha expirado. Vuelve a iniciar el proceso.']);
    }
    exit();
}

// Acción no reconocida
echo json_encode(['error' => 'Acción no válida.']);
?>
