<?php
session_start();
require('../modelo/conexion.php');

header('Content-Type: application/json; charset=utf-8');

if(!isset($_SESSION['id_usuario'])){
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

$accion = isset($_GET['accion']) ? $_GET['accion'] : '';
$idUsuario = $_SESSION['id_usuario'];

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
    case 'listar':
        // Obtener historias de las últimas 24 horas (mías y de mis amigos)
        $sql = "SELECT h.id, h.id_usuario, h.texto, h.foto, h.fecha_publicacion, u.nombres, u.apellidos, u.fotoperfil,
                (UNIX_TIMESTAMP(h.fecha_publicacion) + 86400 - UNIX_TIMESTAMP()) as tiempo_restante,
                (SELECT COUNT(*) FROM historia_vistas hv WHERE hv.id_historia = h.id AND hv.id_usuario = '$idUsuario') as visto,
                (SELECT COUNT(*) FROM historia_vistas hv2 WHERE hv2.id_historia = h.id) as total_vistas,
                (SELECT COUNT(*) FROM historia_megusta hm WHERE hm.id_historia = h.id AND hm.id_usuario = '$idUsuario') as me_gusta,
                (SELECT COUNT(*) FROM historia_megusta hm2 WHERE hm2.id_historia = h.id) as total_me_gusta
                FROM historias h
                JOIN usuarios u ON h.id_usuario = u.id
                WHERE h.fecha_publicacion >= NOW() - INTERVAL 1 DAY
                AND (h.id_usuario = '$idUsuario' OR h.id_usuario IN (
                    SELECT sa.id FROM solicitudamistad sa WHERE sa.idsolicitudamigo = '$idUsuario' AND sa.estado = 1
                    UNION
                    SELECT sa.idsolicitudamigo FROM solicitudamistad sa WHERE sa.id = '$idUsuario' AND sa.estado = 1
                ))
                ORDER BY h.fecha_publicacion DESC";
                
        $result = mysqli_query($conectarsistema, $sql);
        $historias = [];
        if($result){
            while($row = mysqli_fetch_assoc($result)){
                $historias[] = $row;
            }
        }
        echo json_encode($historias);
        break;

    case 'registrar_vista':
        $idHistoria = isset($_POST['id_historia']) ? intval($_POST['id_historia']) : 0;
        if($idHistoria > 0) {
            // Verificar si la historia no es mía y no la he visto
            $check = mysqli_query($conectarsistema, "SELECT 1 FROM historia_vistas WHERE id_historia = '$idHistoria' AND id_usuario = '$idUsuario'");
            if(mysqli_num_rows($check) == 0){
                // Verificar que no sea el autor
                $checkAutor = mysqli_query($conectarsistema, "SELECT id_usuario FROM historias WHERE id = '$idHistoria'");
                $rowAutor = mysqli_fetch_assoc($checkAutor);
                if($rowAutor && $rowAutor['id_usuario'] != $idUsuario) {
                    mysqli_query($conectarsistema, "INSERT INTO historia_vistas (id_historia, id_usuario) VALUES ('$idHistoria', '$idUsuario')");
                }
            }
            echo json_encode(['status' => 'OK']);
        }
        break;

    case 'ver_espectadores':
        $idHistoria = isset($_GET['id_historia']) ? intval($_GET['id_historia']) : 0;
        if($idHistoria > 0){
            $sql = "SELECT u.id, u.nombres, u.apellidos, u.fotoperfil, hv.fecha_vista,
                    (SELECT COUNT(*) FROM historia_megusta hm WHERE hm.id_historia = h.id AND hm.id_usuario = u.id) as liked
                    FROM historia_vistas hv
                    JOIN usuarios u ON hv.id_usuario = u.id
                    JOIN historias h ON hv.id_historia = h.id
                    WHERE hv.id_historia = '$idHistoria' AND h.id_usuario = '$idUsuario'
                    ORDER BY hv.fecha_vista DESC";
            $result = mysqli_query($conectarsistema, $sql);
            $espectadores = [];
            if($result){
                while($row = mysqli_fetch_assoc($result)){
                    $espectadores[] = $row;
                }
            }
            echo json_encode($espectadores);
        }
        break;

    case 'dar_megusta':
        $idHistoria = isset($_POST['id_historia']) ? intval($_POST['id_historia']) : 0;
        if($idHistoria > 0) {
            // Verificar si ya le dio me gusta
            $check = mysqli_query($conectarsistema, "SELECT id_megusta FROM historia_megusta WHERE id_historia = '$idHistoria' AND id_usuario = '$idUsuario'");
            if(mysqli_num_rows($check) > 0){
                // Quitar me gusta
                mysqli_query($conectarsistema, "DELETE FROM historia_megusta WHERE id_historia = '$idHistoria' AND id_usuario = '$idUsuario'");
                $liked = false;
            } else {
                // Agregar me gusta
                mysqli_query($conectarsistema, "INSERT INTO historia_megusta (id_historia, id_usuario) VALUES ('$idHistoria', '$idUsuario')");
                $liked = true;
            }
            
            // Obtener el total actualizado
            $totalRes = mysqli_query($conectarsistema, "SELECT COUNT(*) as total FROM historia_megusta WHERE id_historia = '$idHistoria'");
            $totalRow = mysqli_fetch_assoc($totalRes);
            $total = intval($totalRow['total']);
            
            echo json_encode(['status' => 'OK', 'liked' => $liked, 'total' => $total]);
        }
        break;

    case 'responder_historia':
        $idHistoria = isset($_POST['id_historia']) ? intval($_POST['id_historia']) : 0;
        $mensaje = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : '';
        
        if($idHistoria > 0 && !empty($mensaje)) {
            // Obtener autor de la historia y sus datos
            $sqlH = "SELECT id_usuario, texto, foto FROM historias WHERE id = '$idHistoria'";
            $resH = mysqli_query($conectarsistema, $sqlH);
            if($resH && mysqli_num_rows($resH) > 0) {
                $story = mysqli_fetch_assoc($resH);
                $idReceptor = $story['id_usuario'];
                
                if($idReceptor == $idUsuario) {
                    echo json_encode(['error' => 'No puedes responder a tu propia historia']);
                    break;
                }
                
                // Formatear mensaje estilo respuesta de historia
                $prefix = "";
                if (!empty($story['texto'])) {
                    $truncated = strlen($story['texto']) > 30 ? substr($story['texto'], 0, 30) . '...' : $story['texto'];
                    $prefix = "Respondió a tu historia \"$truncated\": ";
                } else if (!empty($story['foto'])) {
                    $prefix = "Respondió a tu historia (Foto): ";
                } else {
                    $prefix = "Respondió a tu historia: ";
                }
                
                $finalMessage = $prefix . $mensaje;
                
                // Guardar en la mensajería del chat
                $convId = getConversacionId($conectarsistema, $idUsuario, $idReceptor);
                $mensajeSeguro = mysqli_real_escape_string($conectarsistema, $finalMessage);
                
                $sqlMsg = "INSERT INTO chat_mensajes (id_conversacion, id_remitente, mensaje, tipo, archivo, fecha, estado) 
                           VALUES ('$convId', '$idUsuario', '$mensajeSeguro', 'text', '', NOW(), 0)";
                
                if(mysqli_query($conectarsistema, $sqlMsg)){
                    // Actualizar última actividad de conversación
                    mysqli_query($conectarsistema, "UPDATE chat_conversaciones SET ultima_actualizacion = NOW() WHERE id = '$convId'");
                    echo json_encode(['status' => 'OK']);
                } else {
                    echo json_encode(['error' => 'Error al guardar respuesta en chat: ' . mysqli_error($conectarsistema)]);
                }
            } else {
                echo json_encode(['error' => 'Historia no encontrada']);
            }
        } else {
            echo json_encode(['error' => 'Datos incompletos']);
        }
        break;

    case 'crear':
        $texto = isset($_POST['texto']) ? trim($_POST['texto']) : '';
        $fotoName = '';
        
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
            $foto = $_FILES['foto'];
            $ext = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            
            if (in_array($ext, $allowed)) {
                $fotoName = 'story_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
                $target = '../vista/images/fotospublicaciones/' . $fotoName;
                if (!move_uploaded_file($foto['tmp_name'], $target)) {
                    echo json_encode(['error' => 'No se pudo mover el archivo subido']);
                    exit;
                }
            } else {
                echo json_encode(['error' => 'Formato de imagen no permitido']);
                exit;
            }
        }
        
        if (empty($texto) && empty($fotoName)) {
            echo json_encode(['error' => 'La historia debe contener al menos texto o una foto']);
            exit;
        }
        
        $textoSeguro = mysqli_real_escape_string($conectarsistema, $texto);
        $fotoSeguro = mysqli_real_escape_string($conectarsistema, $fotoName);
        
        $sql = "INSERT INTO historias (id_usuario, texto, foto, fecha_publicacion) 
                VALUES ('$idUsuario', '$textoSeguro', '$fotoSeguro', NOW())";
                
        if (mysqli_query($conectarsistema, $sql)) {
            echo json_encode(['status' => 'OK']);
        } else {
            echo json_encode(['error' => 'Error al guardar historia: ' . mysqli_error($conectarsistema)]);
        }
        break;
}

$conectarsistema->close();
?>
