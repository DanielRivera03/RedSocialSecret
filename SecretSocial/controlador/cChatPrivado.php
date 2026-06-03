<?php
session_start();
require('../modelo/conexion.php');

header('Content-Type: application/json; charset=utf-8');

if(!isset($_SESSION['id_usuario'])){
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

$accion = isset($_GET['accion']) ? $_GET['accion'] : '';

function getConversacionId($conectarsistema, $user1, $user2) {
    $u1 = min($user1, $user2);
    $u2 = max($user1, $user2);
    $sql = "SELECT id FROM chat_conversaciones WHERE id_usuario_1 = '$u1' AND id_usuario_2 = '$u2'";
    $res = mysqli_query($conectarsistema, $sql);
    if($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        return $row['id'];
    }
    // Create
    $sql = "INSERT INTO chat_conversaciones (id_usuario_1, id_usuario_2) VALUES ('$u1', '$u2')";
    if(mysqli_query($conectarsistema, $sql)) {
        return mysqli_insert_id($conectarsistema);
    }
    return 0;
}

switch($accion){
    // CARGAR LISTA DE AMIGOS PARA CHAT PRIVADO
    case 'cargar-amigos':
        $idUsuario = $_SESSION['id_usuario'];
        $sqlAmigos = "SELECT u.id, u.nombres, u.apellidos, u.fotoperfil,
                (SELECT mensaje FROM chat_mensajes WHERE id_conversacion = c.id ORDER BY fecha DESC LIMIT 1) as ultimo_mensaje,
                (SELECT fecha FROM chat_mensajes WHERE id_conversacion = c.id ORDER BY fecha DESC LIMIT 1) as fecha_ultimo,
                CASE WHEN u.ultima_conexion >= NOW() - INTERVAL 5 MINUTE THEN 'online' ELSE 'offline' END as estado
                FROM usuarios u
                LEFT JOIN chat_conversaciones c ON (c.id_usuario_1 = '$idUsuario' AND c.id_usuario_2 = u.id) OR (c.id_usuario_2 = '$idUsuario' AND c.id_usuario_1 = u.id)
                WHERE u.id != '$idUsuario' AND u.id IN (
                    SELECT sa.id FROM solicitudamistad sa WHERE sa.idsolicitudamigo = '$idUsuario' AND sa.estado = 1
                    UNION
                    SELECT sa.idsolicitudamigo FROM solicitudamistad sa WHERE sa.id = '$idUsuario' AND sa.estado = 1
                ) ORDER BY u.nombres ASC";
                
        $sqlSolicitudes = "SELECT u.id, u.nombres, u.apellidos, u.fotoperfil,
                (SELECT mensaje FROM chat_mensajes WHERE id_conversacion = c.id ORDER BY fecha DESC LIMIT 1) as ultimo_mensaje,
                (SELECT fecha FROM chat_mensajes WHERE id_conversacion = c.id ORDER BY fecha DESC LIMIT 1) as fecha_ultimo,
                CASE WHEN u.ultima_conexion >= NOW() - INTERVAL 5 MINUTE THEN 'online' ELSE 'offline' END as estado
                FROM usuarios u
                JOIN chat_conversaciones c ON (c.id_usuario_1 = '$idUsuario' AND c.id_usuario_2 = u.id) OR (c.id_usuario_2 = '$idUsuario' AND c.id_usuario_1 = u.id)
                WHERE u.id != '$idUsuario' AND u.id NOT IN (
                    SELECT sa.id FROM solicitudamistad sa WHERE sa.idsolicitudamigo = '$idUsuario' AND sa.estado = 1
                    UNION
                    SELECT sa.idsolicitudamigo FROM solicitudamistad sa WHERE sa.id = '$idUsuario' AND sa.estado = 1
                ) ORDER BY fecha_ultimo DESC";

        $resAmigos = mysqli_query($conectarsistema, $sqlAmigos);
        $resSolicitudes = mysqli_query($conectarsistema, $sqlSolicitudes);
        
        if (!$resAmigos || !$resSolicitudes) {
            echo json_encode(['error' => 'Query error: ' . mysqli_error($conectarsistema)]);
            break;
        }
        
        $amigos = [];
        $solicitudes = [];
        
        if($resAmigos){
            while($row = mysqli_fetch_assoc($resAmigos)){
                $amigos[] = $row;
            }
        }
        if($resSolicitudes){
            while($row = mysqli_fetch_assoc($resSolicitudes)){
                $solicitudes[] = $row;
            }
        }
        
        echo json_encode(['amigos' => $amigos, 'solicitudes' => $solicitudes]);
        break;

    // CARGAR MENSAJES DE CHAT PRIVADO ENTRE DOS USUARIOS
    case 'cargar-mensajes':
        $idUsuario = $_SESSION['id_usuario'];
        $idAmigo = isset($_GET['id_amigo']) ? intval($_GET['id_amigo']) : 0;
        if($idAmigo == 0){
            echo json_encode(['mensajes' => [], 'typing' => false]);
            break;
        }
        $convId = getConversacionId($conectarsistema, $idUsuario, $idAmigo);
        if($convId == 0) {
            echo json_encode(['mensajes' => [], 'typing' => false]);
            break;
        }
        
        $sql = "SELECT cm.id, cm.mensaje, cm.tipo, cm.archivo, cm.fecha as fecha_envio, cm.estado as leido, u.nombres, u.apellidos, u.fotoperfil, u.id as id_remitente
                FROM chat_mensajes cm
                JOIN usuarios u ON cm.id_remitente = u.id
                WHERE cm.id_conversacion = '$convId'
                ORDER BY cm.fecha ASC
                LIMIT 100";
        $result = mysqli_query($conectarsistema, $sql);
        $mensajes = [];
        if($result){
            while($row = mysqli_fetch_assoc($result)){
                $mensajes[] = $row;
            }
        }
        // Marcar mensajes como leidos
        $sqlRead = "UPDATE chat_mensajes SET estado = 1 WHERE id_conversacion = '$convId' AND id_remitente = '$idAmigo' AND estado = 0";
        mysqli_query($conectarsistema, $sqlRead);

        // Check if amigo is typing
        $is_typing = false;
        $check_typing = mysqli_query($conectarsistema, "SELECT id FROM usuarios WHERE id = '$idAmigo' AND typing_to = '$idUsuario' AND ultima_conexion >= NOW() - INTERVAL 8 SECOND LIMIT 1");
        if ($check_typing && mysqli_num_rows($check_typing) > 0) {
            $is_typing = true;
        }

        // Check if amigo is online
        $sqlPresencia = "SELECT CASE WHEN ultima_conexion >= NOW() - INTERVAL 5 MINUTE THEN 'online' ELSE 'offline' END as estado FROM usuarios WHERE id = '$idAmigo'";
        $resPresencia = mysqli_query($conectarsistema, $sqlPresencia);
        $amigoEstado = 'offline';
        if ($resPresencia && mysqli_num_rows($resPresencia) > 0) {
            $rowPresencia = mysqli_fetch_assoc($resPresencia);
            $amigoEstado = $rowPresencia['estado'];
        }

        echo json_encode(['mensajes' => $mensajes, 'typing' => $is_typing, 'estado' => $amigoEstado]);
        break;

    // ENVIAR MENSAJE PRIVADO
    case 'enviar-mensaje':
        $idUsuario = $_SESSION['id_usuario'];
        $idReceptor = isset($_POST['id_receptor']) ? intval($_POST['id_receptor']) : 0;
        $mensaje = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : '';
        $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : 'text';
        $archivo = isset($_POST['archivo']) ? $_POST['archivo'] : '';
        
        if($idReceptor == 0 || ($tipo == 'text' && empty($mensaje))){
            echo json_encode(['error' => 'Datos incompletos']);
            break;
        }
        $convId = getConversacionId($conectarsistema, $idUsuario, $idReceptor);
        $mensajeSeguro = mysqli_real_escape_string($conectarsistema, $mensaje);
        $archivoSeguro = mysqli_real_escape_string($conectarsistema, $archivo);
        $tipoSeguro = mysqli_real_escape_string($conectarsistema, $tipo);
        
        $sql = "INSERT INTO chat_mensajes (id_conversacion, id_remitente, mensaje, tipo, archivo, fecha, estado) 
                VALUES ('$convId', '$idUsuario', '$mensajeSeguro', '$tipoSeguro', '$archivoSeguro', NOW(), 0)";
        if(mysqli_query($conectarsistema, $sql)){
            // Update last action
            mysqli_query($conectarsistema, "UPDATE chat_conversaciones SET ultima_actualizacion = NOW() WHERE id = '$convId'");
            // Reset typing status on send
            mysqli_query($conectarsistema, "UPDATE usuarios SET typing_to = 0 WHERE id = '$idUsuario'");
            echo json_encode(['status' => 'OK', 'id' => mysqli_insert_id($conectarsistema)]);
        } else {
            echo json_encode(['error' => 'No se pudo enviar el mensaje']);
        }
        break;

    // SUBIR ARCHIVO MULTIMEDIA (Audio/Imagen)
    case 'upload-media':
        $idUsuario = $_SESSION['id_usuario'];
        $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';
        
        if (!isset($_FILES['file'])) {
            echo json_encode(['error' => 'No file provided']);
            break;
        }
        
        $file = $_FILES['file'];
        $fileName = time() . '_' . rand(1000, 9999);
        $extension = '';
        $targetDir = '';
        
        if ($tipo == 'audio') {
            $extension = '.webm'; // MediaRecorder genera weba/webm o ogg
            $targetDir = '../vista/images/chat_audios/';
        } else if ($tipo == 'imagen') {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $extension = '.' . strtolower($ext);
            $targetDir = '../vista/images/chat_imagenes/';
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (!in_array(ltrim($extension, '.'), $allowed)) {
                echo json_encode(['error' => 'Invalid image format']);
                break;
            }
        } else {
            echo json_encode(['error' => 'Invalid media type']);
            break;
        }
        
        $finalName = $fileName . $extension;
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        if (move_uploaded_file($file['tmp_name'], $targetDir . $finalName)) {
            echo json_encode(['status' => 'OK', 'archivo' => $finalName]);
        } else {
            echo json_encode(['error' => 'Error moving uploaded file']);
        }
        break;

    // MENSAJES NO LEIDOS (BADGE Y CHAT HEADS)
    case 'no-leidos':
        $idUsuario = $_SESSION['id_usuario'];
        $sql = "SELECT COUNT(cm.id) as total 
                FROM chat_mensajes cm 
                JOIN chat_conversaciones cc ON cm.id_conversacion = cc.id 
                WHERE (cc.id_usuario_1 = '$idUsuario' OR cc.id_usuario_2 = '$idUsuario') 
                AND cm.id_remitente != '$idUsuario' AND cm.estado = 0";
        $result = mysqli_query($conectarsistema, $sql);
        $total = 0;
        if($result) {
            $row = mysqli_fetch_assoc($result);
            $total = intval($row['total']);
        }
        
        $sqlDetalles = "SELECT cm.id_remitente as id_amigo, u.nombres, u.apellidos, u.fotoperfil, COUNT(cm.id) as count 
                        FROM chat_mensajes cm 
                        JOIN chat_conversaciones cc ON cm.id_conversacion = cc.id 
                        JOIN usuarios u ON cm.id_remitente = u.id
                        WHERE (cc.id_usuario_1 = '$idUsuario' OR cc.id_usuario_2 = '$idUsuario') 
                        AND cm.id_remitente != '$idUsuario' AND cm.estado = 0
                        GROUP BY cm.id_remitente";
        $resDetalles = mysqli_query($conectarsistema, $sqlDetalles);
        $detalles = [];
        if($resDetalles){
            while($r = mysqli_fetch_assoc($resDetalles)){
                $detalles[] = $r;
            }
        }
        echo json_encode(['total' => $total, 'detalles' => $detalles]);
        break;

    // PING DE CONEXION
    case 'ping':
        $uid = $_SESSION['id_usuario'];
        mysqli_query($conectarsistema, "UPDATE usuarios SET ultima_conexion = NOW() WHERE id = '$uid'");
        echo json_encode(['status' => 'OK']);
        break;

    // CONSULTAR PRESENCIA DE UN AMIGO
    case 'presencia':
        $idAmigo = isset($_GET['id_amigo']) ? intval($_GET['id_amigo']) : 0;
        $sql = "SELECT CASE WHEN ultima_conexion >= NOW() - INTERVAL 5 MINUTE THEN 'online' ELSE 'offline' END as estado FROM usuarios WHERE id = '$idAmigo'";
        $res = mysqli_query($conectarsistema, $sql);
        $estado = 'offline';
        if($res && mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $estado = $row['estado'];
        }
        echo json_encode(['estado' => $estado]);
        break;

    // ACTUALIZAR ESTADO DE "ESCRIBIENDO..."
    case 'set-typing':
        $uid = $_SESSION['id_usuario'];
        $idAmigo = isset($_POST['id_amigo']) ? intval($_POST['id_amigo']) : 0;
        $status = isset($_POST['status']) ? intval($_POST['status']) : 0;
        $typingTo = $status === 1 ? $idAmigo : 0;
        mysqli_query($conectarsistema, "UPDATE usuarios SET typing_to = '$typingTo', ultima_conexion = NOW() WHERE id = '$uid'");
        echo json_encode(['status' => 'OK']);
        break;

    // --- NUEVOS ENDPOINTS PARA LLAMADAS Y VIDEOLLAMADAS ---

    // INICIAR LLAMADA
    case 'initiate-call':
        $uid = $_SESSION['id_usuario'];
        $idReceptor = isset($_POST['id_receptor']) ? intval($_POST['id_receptor']) : 0;
        $tipo = isset($_POST['tipo']) ? mysqli_real_escape_string($conectarsistema, $_POST['tipo']) : 'video';
        
        mysqli_query($conectarsistema, "UPDATE chat_llamadas SET estado = 'ended' WHERE (id_remitente = '$uid' OR id_receptor = '$uid') AND estado != 'ended' AND estado != 'rejected'");
        
        $sql = "INSERT INTO chat_llamadas (id_remitente, id_receptor, tipo, estado) VALUES ('$uid', '$idReceptor', '$tipo', 'calling')";
        if (mysqli_query($conectarsistema, $sql)) {
            echo json_encode(['status' => 'OK', 'id_llamada' => mysqli_insert_id($conectarsistema)]);
        } else {
            echo json_encode(['error' => 'Error al iniciar llamada']);
        }
        break;

    // VERIFICAR LLAMADAS ENTRANTES
    case 'check-incoming-call':
        $uid = $_SESSION['id_usuario'];
        mysqli_query($conectarsistema, "UPDATE chat_llamadas SET estado = 'missed' WHERE estado = 'calling' AND fecha < NOW() - INTERVAL 30 SECOND");

        $sql = "SELECT cl.*, u.nombres, u.apellidos, u.fotoperfil FROM chat_llamadas cl JOIN usuarios u ON cl.id_remitente = u.id WHERE cl.id_receptor = '$uid' AND cl.estado = 'calling' ORDER BY cl.id DESC LIMIT 1";
        $res = mysqli_query($conectarsistema, $sql);
        if ($res && mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            echo json_encode(['incoming' => true, 'call' => $row]);
        } else {
            echo json_encode(['incoming' => false]);
        }
        break;

    // ACTUALIZAR ESTADO DE LLAMADA
    case 'update-call-status':
        $uid = $_SESSION['id_usuario'];
        $idLlamada = isset($_POST['id_llamada']) ? intval($_POST['id_llamada']) : 0;
        $estado = isset($_POST['estado']) ? mysqli_real_escape_string($conectarsistema, $_POST['estado']) : '';
        
        $sql = "UPDATE chat_llamadas SET estado = '$estado' WHERE id = '$idLlamada' AND (id_receptor = '$uid' OR id_remitente = '$uid')";
        if (mysqli_query($conectarsistema, $sql)) {
            echo json_encode(['status' => 'OK']);
        } else {
            echo json_encode(['error' => 'Error al actualizar']);
        }
        break;

    // POLL ESTADO DE LLAMADA (para el remitente)
    case 'poll-call-status':
        $idLlamada = isset($_GET['id_llamada']) ? intval($_GET['id_llamada']) : 0;
        $sql = "SELECT estado, sdp_offer, sdp_answer, ice_candidates_remitente, ice_candidates_receptor FROM chat_llamadas WHERE id = '$idLlamada'";
        $res = mysqli_query($conectarsistema, $sql);
        if ($res && mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            echo json_encode($row);
        } else {
            echo json_encode(['error' => 'Llamada no encontrada']);
        }
        break;

    // WEBRTC SIGNALING
    case 'webrtc-signaling':
        $idLlamada = isset($_POST['id_llamada']) ? intval($_POST['id_llamada']) : 0;
        $field = isset($_POST['field']) ? mysqli_real_escape_string($conectarsistema, $_POST['field']) : '';
        $data = isset($_POST['data']) ? mysqli_real_escape_string($conectarsistema, $_POST['data']) : '';
        
        if (in_array($field, ['sdp_offer', 'sdp_answer', 'ice_candidates_remitente', 'ice_candidates_receptor'])) {
            $sql = "UPDATE chat_llamadas SET $field = '$data' WHERE id = '$idLlamada'";
            if (mysqli_query($conectarsistema, $sql)) {
                echo json_encode(['status' => 'OK']);
            } else {
                echo json_encode(['error' => 'Error DB']);
            }
        } else {
            echo json_encode(['error' => 'Campo no valido']);
        }
        break;

    case 'datos-usuario':
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id == 0) {
            echo json_encode(['error' => 'ID no valido']);
            break;
        }
        $sql = "SELECT id, nombres, apellidos, fotoperfil FROM usuarios WHERE id = '$id'";
        $res = mysqli_query($conectarsistema, $sql);
        if ($res && mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            echo json_encode($row);
        } else {
            echo json_encode(['error' => 'Usuario no encontrado']);
        }
        break;

    default:
        echo json_encode(['error' => 'Accion no reconocida']);
        break;
}

$conectarsistema->close();
?>
