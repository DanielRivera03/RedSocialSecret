<?php
/*
--------------------------------------------------------
║            SECRET - RED SOCIAL PHP NATIVO            ║
    CONTROLADOR: Feed Infinito con Paginación
    - Retorna publicaciones paginadas (10 por página)
    - Acepta parámetro: ?pagina=N&tipo=inicio|perfil
    - Devuelve JSON con HTML + hasMore flag
--------------------------------------------------------
*/
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(!isset($_SESSION['id_usuario'])){
    echo json_encode(['error' => 'No autorizado', 'hasMore' => false]);
    exit();
}

require('../modelo/conexion.php');
header('Content-Type: application/json; charset=utf-8');

$pagina = max(1, intval($_GET['pagina'] ?? 1));
$tipo   = isset($_GET['tipo']) ? $_GET['tipo'] : 'inicio';
$userId = intval($_SESSION['id_usuario']);
$targetUserId = isset($_GET['id_usuario']) ? intval($_GET['id_usuario']) : $userId;
$limit  = 10;
$offset = ($pagina - 1) * $limit;

// ===================== PUBLICACIONES DEL FEED (INICIO) =====================
if($tipo === 'inicio') {
    $sql = "SELECT v.idpublicacion, v.mensaje_publicacion, v.foto_publicacion, v.fecha_publicacion,
                   v.idsolicitudamigo AS id, v.nombres, v.apellidos, v.fotoperfil,
                   p.fondo_gradiente, p.sentimiento
            FROM vista_publicacionesinicio v
            LEFT JOIN publicaciones p ON v.idpublicacion = p.idpublicacion
            WHERE v.id = $userId
            ORDER BY v.fecha_publicacion DESC
            LIMIT $limit OFFSET $offset";
    $countSql = "SELECT COUNT(*) as total
            FROM vista_publicacionesinicio
            WHERE id = $userId";
} elseif($tipo === 'perfil') {
    $sql = "SELECT v.idpublicacion, v.mensaje_publicacion, v.foto_publicacion, v.fecha_publicacion,
                   v.id, v.nombres, v.apellidos, v.fotoperfil,
                   p.fondo_gradiente, p.sentimiento
            FROM vista_publicacionesperfilusuarios v
            LEFT JOIN publicaciones p ON v.idpublicacion = p.idpublicacion
            WHERE v.id = $targetUserId
            ORDER BY v.fecha_publicacion DESC
            LIMIT $limit OFFSET $offset";
    $countSql = "SELECT COUNT(*) as total
            FROM vista_publicacionesperfilusuarios
            WHERE id = $targetUserId";
} else {
    echo json_encode(['error' => 'Tipo inválido', 'hasMore' => false]);
    exit();
}

$result = $conectarsistema->query($sql);

if(!$result) {
    echo json_encode(['error' => 'Error en consulta: ' . $conectarsistema->error, 'hasMore' => false]);
    exit();
}

$publicaciones = [];
while($row = $result->fetch_assoc()) {
    $publicaciones[] = $row;
}

// ¿Hay más publicaciones?
$countResult = $conectarsistema->query($countSql);
$totalRows = 0;
if($countResult) {
    $countRow = $countResult->fetch_assoc();
    $totalRows = intval($countRow['total'] ?? 0);
}
$hasMore = ($offset + $limit) < $totalRows;

// Generar HTML para cada publicación
$html = '';
foreach($publicaciones as $p) {
    $timeDiff = time() - strtotime($p['fecha_publicacion']);
    $hoursPassed = $timeDiff / 3600;
    $percentage = ($hoursPassed < 24) ? round(((24 - $hoursPassed) / 24) * 100) : 0;
    
    $msgEsc     = htmlspecialchars($p['mensaje_publicacion'], ENT_QUOTES, 'UTF-8');
    $nombreEsc  = htmlspecialchars($p['nombres'], ENT_QUOTES, 'UTF-8');
    $apellEsc   = htmlspecialchars($p['apellidos'], ENT_QUOTES, 'UTF-8');
    $fotoPerf   = htmlspecialchars($p['fotoperfil'], ENT_QUOTES, 'UTF-8');
    $fotoPub    = htmlspecialchars($p['foto_publicacion'], ENT_QUOTES, 'UTF-8');
    $fechaPub   = htmlspecialchars($p['fecha_publicacion'], ENT_QUOTES, 'UTF-8');
    $idPub      = intval($p['idpublicacion']);
    $idUser     = intval($p['id']);
    
    $fondoGradiente = htmlspecialchars($p['fondo_gradiente'] ?? '', ENT_QUOTES, 'UTF-8');
    $sentimientoEsc = htmlspecialchars($p['sentimiento'] ?? '', ENT_QUOTES, 'UTF-8');
    
    $esPropietario = ($idUser === $userId);
    
    $deleteBtn = '';
    if($esPropietario) {
        $deleteBtn = '<a class="dropdown-item p-3" id="eliminarhistorias" data-id="' . $idPub . '">
            <div class="d-flex align-items-top">
                <div class="icon font-size-20"><i class="ri-delete-bin-7-line"></i></div>
                <div class="data ml-2">
                    <h6>Eliminar Historia</h6>
                    <p class="mb-0">¡Cuidado! Esta acción no es reversible</p>
                </div>
            </div>
        </a>';
    }
    
    $imagenHtml = '';
    if(!empty($fotoPub) && $fotoPub !== '0' && $fotoPub !== 'null') {
        $fotos = explode(',', $fotoPub);
        $fotos = array_filter(array_map('trim', $fotos));
        if(count($fotos) === 1) {
            $singleFoto = htmlspecialchars($fotos[0], ENT_QUOTES, 'UTF-8');
            $imagenHtml = '<a title="' . $msgEsc . '" class="expandir_imagen fb-viewer-trigger" href="../vista/images/fotospublicaciones/' . $singleFoto . '" data-post-id="' . $idPub . '" data-msg="' . $msgEsc . '" data-author-name="' . $nombreEsc . ' ' . $apellEsc . '" data-author-avatar="' . $fotoPerf . '" data-post-date="' . $fechaPub . '" data-all-images="' . $fotoPub . '" data-current-index="0">
                <img src="../vista/images/fotospublicaciones/' . $singleFoto . '" alt="post-image" class="img-fluid w-100 rounded" style="max-height:500px;object-fit:cover;" />
            </a>';
        } elseif(count($fotos) > 1) {
            $imagenHtml = '<div class="instagram-carousel-container" id="carousel-' . $idPub . '" data-current-slide="0">';
            $imagenHtml .= '<div class="instagram-carousel-track" id="track-' . $idPub . '">';
            foreach($fotos as $idx => $f) {
                $fEsc = htmlspecialchars($f, ENT_QUOTES, 'UTF-8');
                $imagenHtml .= '<div class="instagram-carousel-slide" data-slide-index="' . $idx . '">
                    <a title="' . $msgEsc . '" class="expandir_imagen fb-viewer-trigger" href="../vista/images/fotospublicaciones/' . $fEsc . '" data-post-id="' . $idPub . '" data-msg="' . $msgEsc . '" data-author-name="' . $nombreEsc . ' ' . $apellEsc . '" data-author-avatar="' . $fotoPerf . '" data-post-date="' . $fechaPub . '" data-all-images="' . $fotoPub . '" data-current-index="' . $idx . '">
                        <img src="../vista/images/fotospublicaciones/' . $fEsc . '" alt="post-image" class="img-fluid w-100 rounded" style="max-height:500px;object-fit:cover;" />
                    </a>
                </div>';
            }
            $imagenHtml .= '</div>';
            
            // Arrows
            $imagenHtml .= '<button type="button" class="carousel-arrow carousel-arrow-left" onclick="slideCarousel(' . $idPub . ', -1)"><i class="ri-arrow-left-s-line"></i></button>';
            $imagenHtml .= '<button type="button" class="carousel-arrow carousel-arrow-right" onclick="slideCarousel(' . $idPub . ', 1)"><i class="ri-arrow-right-s-line"></i></button>';
            
            // Dots
            $imagenHtml .= '<div class="carousel-dots">';
            foreach($fotos as $idx => $f) {
                $activeClass = ($idx === 0) ? 'active' : '';
                $imagenHtml .= '<span class="carousel-dot ' . $activeClass . '" data-index="' . $idx . '" onclick="jumpToSlide(' . $idPub . ', ' . $idx . ')"></span>';
            }
            $imagenHtml .= '</div>';
            $imagenHtml .= '</div>';
        }
    }
    
    $html .= '<div class="iq-card feed-post-item" id="post-' . $idPub . '" data-id="' . $idPub . '">
        <div class="iq-card-body">
            <div class="post-item">
                <div class="user-post-data p-3">
                    <div class="d-flex flex-wrap">
                        <div class="media-support-user-img mr-3">
                            <img class="rounded-circle img-fluid profile-img-history" style="--ring-percentage:' . $percentage . ';width:50px;height:50px;object-fit:cover;" src="../vista/images/fotosperfiles/' . $fotoPerf . '" alt="">
                        </div>
                        <div class="media-support-info mt-2">
                            <h5 class="mb-0 d-inline-block"><a href="#" class="">' . $nombreEsc . ' ' . $apellEsc . '</a>' . (!empty($sentimientoEsc) ? ' <span class="text-muted font-size-12 font-weight-normal"> — se siente ' . $sentimientoEsc . '</span>' : '') . '</h5>
                            <p class="ml-1 mb-0 d-inline-block">publicó una nueva historia</p>
                            <p class="mb-0 text-primary"><i class="ri-timer-flash-line"></i> <time class="timeago" datetime="' . $fechaPub . '"></time></p>
                        </div>
                        <div class="iq-card-post-toolbar">
                            <div class="dropdown">
                                <span class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                    <i class="ri-more-fill"></i>
                                </span>
                                <div class="dropdown-menu m-0 p-0">
                                    ' . $deleteBtn . '
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="user-post">
                    ' . (!empty($fondoGradiente) ? '<div class="post-gradient-container ' . $fondoGradiente . '"><span>' . $msgEsc . '</span></div>' : '<p>' . $msgEsc . '</p>' . $imagenHtml) . '
                </div>
                <div class="feed-comentarios-container" data-id="' . $idPub . '"></div>
            </div>
        </div>
    </div>';
}

echo json_encode([
    'html'    => $html,
    'hasMore' => $hasMore,
    'pagina'  => $pagina,
    'total'   => $totalRows,
    'count'   => count($publicaciones)
]);
?>
