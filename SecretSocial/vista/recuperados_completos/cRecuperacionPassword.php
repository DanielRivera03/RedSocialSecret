"<?php
require('../modelo/conexion.php');

$accion = isset($_GET['accion']) ? $_GET['accion'] : '';

if($accion == 'olvide_password'){
    header('location:../vista/recuperar_password.php');
    exit;
}

if($accion == 'enviar_correo'){
    $correo = trim($_POST['correo_recuperacion']);
    
    // Verificar si el correo existe
    $stmt = $conectarsistema->prepare("SELECT id FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if($resultado->num_rows > 0){
        // Generar token
        $token = bin2hex(random_bytes(50));
        
        // Actualizar tabla con el token
        $stmt_update = $conectarsistema->prepare("UPDATE usuarios SET token_recuperacion = ?, fecha_token = NOW() WHERE correo = ?");
        $stmt_update->bind_param("ss", $token, $correo);
        $stmt_update->execute();
        
        // URL de restablecimiento
        $url_base = "http://" . $_SERVER['HTTP_HOST'] . str_replace("controlador/cRecuperacionPassword.php?accion=enviar_correo", "", $_SERVER['REQUEST_URI']);
        $url_reset = $url_base . "vista/restablecer_password.php?token=" . $token;
        
        // Enviar correo
        $asunto = "Secret - Recuperacion de Contrasena";
        $mensaje = "Has solicitado restablecer tu contrasena.\
\
Haz clic en el siguiente enlace o copialo en tu navegador:\
\
" . $url_reset;
        $cabeceras = 'From: noreply@secretsocial.local' . "\\
" .
                     'Reply-To: noreply@secretsocial.local' . "\\
" .
                     'X-Mailer: PHP/' . phpversion();
                     
        $correo_enviado = @mail($correo, $asunto, $mensaje, $cabeceras);
        
        // Para entornos XAMPP locales donde el correo no funciona, mostramos el link de prueba
        if(!$correo_enviado){
            header("location:../vista/recuperar_password.php?msg=test_mode&link=" . urlencode($url_reset));
            exit;
        }
<truncated 2695 bytes>