<?php
/*
--------------------------------------------------------
║            SECRET - RED SOCIAL PHP NATIVO            ║
--------------------------------------------------------           
    UTILIDAD: Envío de correos por SMTP (Gmail)
    - Auto-descarga de PHPMailer v6.8.1 si no existe
    - Soporte para adjuntos incrustados (CID)
    - Fallback a mail() de PHP en caso de fallo crítico
--------------------------------------------------------
*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

function descargarPHPMailer() {
    $dir = __DIR__ . '/PHPMailer';
    if (!is_dir($dir)) {
        if (!@mkdir($dir, 0755, true)) {
            // Si falla la creación, no podemos continuar con la descarga
            return;
        }
    }
    
    $archivos = [
        'Exception.php' => 'https://raw.githubusercontent.com/PHPMailer/PHPMailer/v6.8.1/src/Exception.php',
        'PHPMailer.php' => 'https://raw.githubusercontent.com/PHPMailer/PHPMailer/v6.8.1/src/PHPMailer.php',
        'SMTP.php' => 'https://raw.githubusercontent.com/PHPMailer/PHPMailer/v6.8.1/src/SMTP.php'
    ];
    
    foreach ($archivos as $nombre => $url) {
        $rutaDestino = $dir . '/' . $nombre;
        if (!file_exists($rutaDestino)) {
            $contenido = @file_get_contents($url);
            if ($contenido === false) {
                // Si file_get_contents falla, intentamos curl
                if (function_exists('curl_init')) {
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
                    $contenido = curl_exec($ch);
                    curl_close($ch);
                }
            }
            if ($contenido !== false && strlen($contenido) > 1000) { // Validar tamaño mínimo razonable de archivo PHP
                @file_put_contents($rutaDestino, $contenido);
            }
        }
    }
}

function enviarCorreo($destinatario, $asunto, $htmlContent, $textContent = '', $adjuntosCid = []) {
    // Asegurar que PHPMailer esté disponible
    try {
        descargarPHPMailer();
    } catch (\Exception $e) {
        // Ignorar excepciones de descarga y permitir fallback
    }
    
    $phpmailerPath = __DIR__ . '/PHPMailer/PHPMailer.php';
    $smtpPath = __DIR__ . '/PHPMailer/SMTP.php';
    $exceptionPath = __DIR__ . '/PHPMailer/Exception.php';
    
    if (file_exists($phpmailerPath) && file_exists($smtpPath) && file_exists($exceptionPath)) {
        require_once $exceptionPath;
        require_once $phpmailerPath;
        require_once $smtpPath;
        
        $mail = new PHPMailer(true);
        
        try {
            // Configuración de SMTP para Gmail con cuenta de aplicación
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'proyectosedmr@gmail.com';
            $mail->Password   = 'mdgs wdmn tqwf hdef';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->CharSet    = 'UTF-8';
            
            // Destinatarios
            $mail->setFrom('proyectosedmr@gmail.com', 'Secret Social');
            $mail->addAddress($destinatario);
            
            // Adjuntos en línea (CID)
            if (!empty($adjuntosCid)) {
                foreach ($adjuntosCid as $cid => $ruta) {
                    if (file_exists($ruta)) {
                        $mail->addEmbeddedImage($ruta, $cid);
                    }
                }
            }
            
            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = $asunto;
            $mail->Body    = $htmlContent;
            $mail->AltBody = $textContent;
            
            $mail->send();
            return true;
        } catch (\Exception $e) {
            error_log("Error al enviar correo con PHPMailer: " . $mail->ErrorInfo);
        }
    }
    
    // Fallback: Si PHPMailer no está disponible o falla, usar mail() de PHP nativo
    $headers = 'From: proyectosedmr@gmail.com' . "\r\n" .
               'Reply-To: proyectosedmr@gmail.com' . "\r\n" .
               'MIME-Version: 1.0' . "\r\n" .
               'Content-Type: text/html; charset=UTF-8' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();
               
    return @mail($destinatario, $asunto, $htmlContent, $headers);
}
?>
