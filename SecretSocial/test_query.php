<?php
require('C:/xampp/htdocs/SecretSocial/modelo/conexion.php');

$idUsuario = 1; // Assuming a user ID
$sqlSolicitudes = "SELECT u.id, u.nombres, u.apellidos, u.fotoperfil,
        (SELECT mensaje FROM chat_mensajes WHERE id_conversacion = c.id ORDER BY fecha DESC LIMIT 1) as ultimo_mensaje,
        (SELECT fecha FROM chat_mensajes WHERE id_conversacion = c.id ORDER BY fecha DESC LIMIT 1) as fecha_ultimo,
        CASE WHEN u.ultima_conexion >= NOW() - INTERVAL 5 MINUTE THEN 'online' ELSE 'offline' END as estado
        FROM usuarios u
        JOIN chat_conversaciones c ON (c.id_usuario_1 = '$idUsuario' AND c.id_usuario_2 = u.id) OR (c.id_usuario_2 = '$idUsuario' AND c.id_usuario_1 = u.id)
        WHERE u.id != '$idUsuario' AND u.id NOT IN (
            SELECT sa.id_usuario_recibe FROM solicitudamistad sa WHERE sa.id_usuario_envia = '$idUsuario' AND sa.estado = 1
            UNION
            SELECT sa.id_usuario_envia FROM solicitudamistad sa WHERE sa.id_usuario_recibe = '$idUsuario' AND sa.estado = 1
        ) ORDER BY fecha_ultimo DESC";

$res = mysqli_query($conectarsistema, $sqlSolicitudes);
if (!$res) {
    echo "Error: " . mysqli_error($conectarsistema);
} else {
    echo "Success!";
}
?>
