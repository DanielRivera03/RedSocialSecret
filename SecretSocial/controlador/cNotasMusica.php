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

function fetchUrl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; SecretSocial/1.0)');
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if($response === false || $httpCode < 200 || $httpCode >= 300) return null;
    return $response;
}

switch($accion){
    case 'buscar_itunes':
        if(empty($_GET['q'])) { echo json_encode(['results' => []]); break; }
        $query = urlencode(trim($_GET['q']));
        $url = "https://itunes.apple.com/search?term={$query}&limit=8&entity=song&country=us";
        $response = fetchUrl($url);
        if($response) { echo $response; } else { echo json_encode(['results' => []]); }
        break;

    case 'top_itunes':
        $url = "https://itunes.apple.com/us/rss/topsongs/limit=10/json";
        $response = fetchUrl($url);
        if($response) { echo $response; } else { echo json_encode(['feed' => ['entry' => []]]); }
        break;

    case 'publicar':
        $cancion = isset($_POST['cancion']) ? mysqli_real_escape_string($conectarsistema, $_POST['cancion']) : '';
        $artista = isset($_POST['artista']) ? mysqli_real_escape_string($conectarsistema, $_POST['artista']) : '';
        $nota = isset($_POST['nota']) ? mysqli_real_escape_string($conectarsistema, $_POST['nota']) : '';
        $audioUrl = isset($_POST['audio_url']) ? mysqli_real_escape_string($conectarsistema, $_POST['audio_url']) : '';
        $startTime = isset($_POST['start_time']) ? (int)$_POST['start_time'] : 0;
        $endTime = isset($_POST['end_time']) ? (int)$_POST['end_time'] : 30;
        
        $filename = '';
        if(isset($_FILES['audio_file']) && $_FILES['audio_file']['error'] == 0){
            $filename = uniqid('audio_') . '.webm';
            move_uploaded_file($_FILES['audio_file']['tmp_name'], '../vista/audio/' . $filename);
        } else if (!empty($audioUrl)) {
            $filename = $audioUrl; // Guardar URL de preview de itunes
        }

        $sql = "INSERT INTO notas_musica (id_usuario, cancion, artista, nota, fecha_creacion, audio_file, start_time, end_time) 
                VALUES ('$idUsuario', '$cancion', '$artista', '$nota', NOW(), '$filename', '$startTime', '$endTime')
                ON DUPLICATE KEY UPDATE 
                cancion=VALUES(cancion), artista=VALUES(artista), nota=VALUES(nota), fecha_creacion=NOW(), audio_file=VALUES(audio_file), start_time=VALUES(start_time), end_time=VALUES(end_time)";
        
        try {
            if(mysqli_query($conectarsistema, $sql)){
                echo json_encode(['status' => 'OK']);
            } else {
                echo json_encode(['error' => 'Error al guardar la nota: ' . mysqli_error($conectarsistema)]);
            }
        } catch (mysqli_sql_exception $e) {
            echo json_encode(['error' => 'Error de BD: ' . $e->getMessage()]);
        }
        break;

    case 'listar':
        // Notas de las ultimas 24h
        $sql = "SELECT n.*, u.nombres, u.fotoperfil 
                FROM notas_musica n
                JOIN usuarios u ON n.id_usuario = u.id
                WHERE n.fecha_creacion >= NOW() - INTERVAL 1 DAY
                ORDER BY n.fecha_creacion DESC";
        $result = mysqli_query($conectarsistema, $sql);
        $notas = [];
        if($result){
            while($row = mysqli_fetch_assoc($result)){
                $notas[] = $row;
            }
        }
        echo json_encode($notas);
        break;
}
$conectarsistema->close();
?>
