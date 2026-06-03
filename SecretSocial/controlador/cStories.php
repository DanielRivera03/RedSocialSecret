<?php
/*
--------------------------------------------------------
║            SECRET - RED SOCIAL PHP NATIVO            ║
║     CONTROLADOR: Historias Epímeras (Stories)        ║
║     - Carga de imágenes/videos cortos                ║
║     - Expiración a las 24 horas                      ║
--------------------------------------------------------
*/
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(!isset($_SESSION['id_usuario'])){
    echo json_encode(['error' => 'No autorizado']);
    exit();
}

require('../modelo/conexion.php');
header('Content-Type: application/json; charset=utf-8');

$accion = isset($_GET['accion']) ? $_GET['accion'] : '';
$userId = intval($_SESSION['id_usuario']);

switch($accion) {
    case 'upload':
        if (!isset($_FILES['story_media'])) {
            echo json_encode(['error' => 'No se cargó ningún archivo']);
            break;
        }

        $file = $_FILES['story_media'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowedImg = ['jpg', 'jpeg', 'png', 'gif'];
        $allowedVid = ['mp4', 'webm', 'mov'];

        $tipo = '';
        if (in_array($ext, $allowedImg)) {
            $tipo = 'image';
        } elseif (in_array($ext, $allowedVid)) {
            $tipo = 'video';
        } else {
            echo json_encode(['error' => 'Formato no permitido (Solo JPG, PNG, GIF, MP4, WEBM, MOV)']);
            break;
        }

        // Crear directorio si no existe
        $uploadDir = '../vista/images/stories/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = uniqid('story_') . '.' . $ext;
        $destPath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $destPath)) {
            // Guardar en la base de datos
            $stmt = $conectarsistema->prepare("INSERT INTO historias_epimeras (usuario_id, multimedia, tipo) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $userId, $fileName, $tipo);
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'fileName' => $fileName, 'tipo' => $tipo]);
            } else {
                echo json_encode(['error' => 'Error al guardar en la base de datos']);
            }
            $stmt->close();
        } else {
            echo json_encode(['error' => 'Error al subir el archivo al servidor']);
        }
        break;

    case 'list':
        // Obtener historias de las últimas 24 horas del usuario y de sus amigos
        $sql = "SELECT he.id, he.usuario_id, he.multimedia, he.tipo, he.fecha_creacion,
                       u.nombres, u.apellidos, u.fotoperfil, u.usuario
                FROM historias_epimeras he
                JOIN usuarios u ON he.usuario_id = u.id
                WHERE he.fecha_creacion >= NOW() - INTERVAL 1 DAY
                  AND (he.usuario_id = $userId OR he.usuario_id IN (
                      SELECT sa.id FROM solicitudamistad sa WHERE sa.idsolicitudamigo = $userId AND sa.estado = 1
                      UNION
                      SELECT sa.idsolicitudamigo FROM solicitudamistad sa WHERE sa.id = $userId AND sa.estado = 1
                  ))
                ORDER BY he.fecha_creacion ASC";

        $res = $conectarsistema->query($sql);
        if (!$res) {
            echo json_encode(['error' => 'Error en consulta: ' . $conectarsistema->error]);
            break;
        }

        $storiesGrouped = [];
        while ($row = $res->fetch_assoc()) {
            $uId = intval($row['usuario_id']);
            if (!isset($storiesGrouped[$uId])) {
                $storiesGrouped[$uId] = [
                    'usuario_id' => $uId,
                    'nombres' => $row['nombres'],
                    'apellidos' => $row['apellidos'],
                    'fotoperfil' => $row['fotoperfil'],
                    'usuario' => $row['usuario'],
                    'items' => []
                ];
            }
            $storiesGrouped[$uId]['items'][] = [
                'id' => intval($row['id']),
                'multimedia' => $row['multimedia'],
                'tipo' => $row['tipo'],
                'fecha_creacion' => $row['fecha_creacion']
            ];
        }

        // Colocar la historia del usuario activo al inicio de la lista si existe
        $finalList = [];
        if (isset($storiesGrouped[$userId])) {
            $finalList[] = $storiesGrouped[$userId];
            unset($storiesGrouped[$userId]);
        }
        foreach ($storiesGrouped as $g) {
            $finalList[] = $g;
        }

        echo json_encode(['stories' => $finalList]);
        break;

    default:
        echo json_encode(['error' => 'Acción no válida']);
        break;
}
$conectarsistema->close();
?>
