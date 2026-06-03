"<?php
/*
--------------------------------------------------------
|            SECRET - RED SOCIAL PHP NATIVO            |
--------------------------------------------------------
    Controlador - Música Favorita (sin archivos)
    Guarda metadatos de canciones/videos seleccionados
    desde la API de iTunes y YouTube.
--------------------------------------------------------
*/
session_start();
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['id_usuario'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

$db = new mysqli("localhost", "root", "", "secretbd");
$db->set_charset("utf8mb4");
if ($db->connect_errno) {
    echo json_encode(['error' => 'Error de conexión']);
    exit;
}

$action = $_GET['action'] ?? '';

switch ($action) {

    // ── GUARDAR NUEVA ENTRADA ──────────────────────────────
    case 'guardar':
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) $data = $_POST;

        $tipo        = in_array($data['tipo'] ?? '', ['audio','video']) ? $data['tipo'] : 'audio';
        $titulo      = $db->real_escape_string(trim($data['titulo'] ?? ''));
        $artista     = $db->real_escape_string(trim($data['artista'] ?? ''));
        $album       = $db->real_escape_string(trim($data['album'] ?? ''));
        $portada_url = $db->real_escape_string(trim($data['portada_url'] ?? ''));
        $preview_url = $db->real_escape_string(trim($data['preview_url'] ?? ''));
        $youtube_id  = $db->real_escape_string(trim($data['youtube_id'] ?? ''));
        $duracion_ms = intval($data['duracion_ms'] ?? 0);
        $id_usuario  = intval($_SESSION['id_usuario']);

        if (!$titulo || !$artista) {
            echo json_encode(['error' => 'Título y artista son requeridos']);
            exit;
        }

        $sql = "INSERT INTO musica_favorita
                  (id_usuari
<truncated 3888 bytes>