<?php
session_start();
require('../modelo/conexion.php');

header('Content-Type: application/json; charset=utf-8');

if(!isset($_SESSION['id_usuario'])){
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

$accion = isset($_GET['accion']) ? $_GET['accion'] : '';
$myId = intval($_SESSION['id_usuario']);

switch($accion) {
    // INICIAR LLAMADA (Crear SDP Offer)
    case 'iniciar':
        $idReceptor = isset($_POST['id_receptor']) ? intval($_POST['id_receptor']) : 0;
        $tipo = isset($_POST['tipo']) ? mysqli_real_escape_string($conectarsistema, $_POST['tipo']) : 'audio';
        $sdpOffer = isset($_POST['sdp_offer']) ? mysqli_real_escape_string($conectarsistema, $_POST['sdp_offer']) : '';

        if($idReceptor === 0 || empty($sdpOffer)) {
            echo json_encode(['error' => 'Datos incompletos']);
            break;
        }

        // Cancelar llamadas previas no finalizadas para evitar bloqueos
        mysqli_query($conectarsistema, "UPDATE chat_llamadas SET estado = 'hungup' WHERE (id_remitente = '$myId' OR id_receptor = '$myId') AND estado IN ('calling', 'accepted')");

        $sql = "INSERT INTO chat_llamadas (id_remitente, id_receptor, tipo, sdp_offer, estado) 
                VALUES ('$myId', '$idReceptor', '$tipo', '$sdpOffer', 'calling')";
        if(mysqli_query($conectarsistema, $sql)) {
            echo json_encode(['status' => 'OK', 'call_id' => mysqli_insert_id($conectarsistema)]);
        } else {
            echo json_encode(['error' => 'No se pudo iniciar la llamada']);
        }
        break;

    // RESPONDER LLAMADA (Crear SDP Answer o Declinar)
    case 'responder':
        $callId = isset($_POST['call_id']) ? intval($_POST['call_id']) : 0;
        $estado = isset($_POST['estado']) ? mysqli_real_escape_string($conectarsistema, $_POST['estado']) : 'declined'; // accepted o declined
        $sdpAnswer = isset($_POST['sdp_answer']) ? mysqli_real_escape_string($conectarsistema, $_POST['sdp_answer']) : '';

        if($callId === 0) {
            echo json_encode(['error' => 'ID de llamada no especificado']);
            break;
        }

        if($estado === 'accepted') {
            $sql = "UPDATE chat_llamadas SET estado = 'accepted', sdp_answer = '$sdpAnswer' WHERE id = '$callId'";
        } else {
            $sql = "UPDATE chat_llamadas SET estado = 'declined' WHERE id = '$callId'";
        }

        if(mysqli_query($conectarsistema, $sql)) {
            echo json_encode(['status' => 'OK']);
        } else {
            echo json_encode(['error' => 'No se pudo responder la llamada']);
        }
        break;

    // COLGAR/FINALIZAR LLAMADA
    case 'colgar':
        $callId = isset($_POST['call_id']) ? intval($_POST['call_id']) : 0;
        if($callId === 0) {
            // Si no viene callId, colgar cualquier llamada activa del usuario actual
            $sql = "UPDATE chat_llamadas SET estado = 'hungup' WHERE (id_remitente = '$myId' OR id_receptor = '$myId') AND estado IN ('calling', 'accepted')";
        } else {
            $sql = "UPDATE chat_llamadas SET estado = 'hungup' WHERE id = '$callId'";
        }

        if(mysqli_query($conectarsistema, $sql)) {
            echo json_encode(['status' => 'OK']);
        } else {
            echo json_encode(['error' => 'No se pudo colgar']);
        }
        break;

    // AGREGAR ICE CANDIDATE
    case 'add-ice':
        $callId = isset($_POST['call_id']) ? intval($_POST['call_id']) : 0;
        $candidate = isset($_POST['candidate']) ? $_POST['candidate'] : ''; // JSON string del candidate
        $role = isset($_POST['role']) ? $_POST['role'] : 'remitente'; // remitente o receptor

        if($callId === 0 || empty($candidate)) {
            echo json_encode(['error' => 'Datos incompletos']);
            break;
        }

        // Obtener llamada
        $res = mysqli_query($conectarsistema, "SELECT ice_candidates_remitente, ice_candidates_receptor FROM chat_llamadas WHERE id = '$callId'");
        if($res && mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $field = ($role === 'remitente') ? 'ice_candidates_remitente' : 'ice_candidates_receptor';
            
            $existing = $row[$field] ? json_decode($row[$field], true) : [];
            $existing[] = json_decode($candidate, true);
            
            $updatedJson = mysqli_real_escape_string($conectarsistema, json_encode($existing));
            mysqli_query($conectarsistema, "UPDATE chat_llamadas SET $field = '$updatedJson' WHERE id = '$callId'");
            
            echo json_encode(['status' => 'OK']);
        } else {
            echo json_encode(['error' => 'Llamada no encontrada']);
        }
        break;

    // CHEQUEAR SI ME ESTÁN LLAMANDO
    case 'chequear':
        // Buscar llamada entrante en estado 'calling' de los últimos 20 segundos
        $sql = "SELECT cl.id, cl.id_remitente, cl.tipo, cl.sdp_offer, u.nombres, u.apellidos, u.fotoperfil 
                FROM chat_llamadas cl
                JOIN usuarios u ON cl.id_remitente = u.id
                WHERE cl.id_receptor = '$myId' AND cl.estado = 'calling' AND cl.fecha >= NOW() - INTERVAL 20 SECOND
                ORDER BY cl.id DESC LIMIT 1";
        $res = mysqli_query($conectarsistema, $sql);
        if($res && mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            echo json_encode(['llamada' => $row]);
        } else {
            echo json_encode(['llamada' => null]);
        }
        break;

    // POLLING DEL ESTADO DE LA LLAMADA (Para sincronización WebRTC)
    case 'poll-estado':
        $callId = isset($_GET['call_id']) ? intval($_GET['call_id']) : 0;
        if($callId === 0) {
            echo json_encode(['error' => 'ID de llamada inválido']);
            break;
        }

        $res = mysqli_query($conectarsistema, "SELECT * FROM chat_llamadas WHERE id = '$callId'");
        if($res && mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            echo json_encode(['call' => $row]);
        } else {
            echo json_encode(['error' => 'Llamada no encontrada']);
        }
        break;

    default:
        echo json_encode(['error' => 'Accion no reconocida']);
        break;
}

$conectarsistema->close();
?>
