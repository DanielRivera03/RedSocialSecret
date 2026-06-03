"<?php
session_start();
if(!isset($_SESSION['id_usuario'])){
    die(json_encode(['error' => 'No autorizado']));
}

$IdSolicitudAmigo = $_SESSION['id_usuario'];
$UsuarioUnico = $_SESSION['usuario_unico'];

require('../modelo/conexion.php');
require('../modelo/mModeloPublicaciones.php');

$last_id = isset($_GET['last_id']) ? (int)$_GET['last_id'] : 0;

$Publicaciones = new PublicacionesUsuarios();
$consulta = $Publicaciones->ConsultarPublicacionesInicio($conectarsistema, $IdSolicitudAmigo);

$nuevas = [];
$max_id = $last_id;

if($consulta) {
    while($filas=mysqli_fetch_array($consulta)){
        $idpub = (int)$filas['idpublicacion'];
        
        // Obtenemos max_id inicial si es que last_id viene en 0
        if ($last_id == 0 && $idpub > $max_id) {
            $max_id = $idpub;
        }

        if ($last_id > 0 && $idpub > $last_id) {
            ob_start();
            echo '<div class="iq-card" id="publicaciones_usuariosperfil">
            <div class="iq-card-body">
               <div class="post-item">
                  <div class="user-post-data p-3">
                     <div class="d-flex flex-wrap">
                        <div class="media-support-user-img mr-3">
                        <a target="_blank" href="../Perfiles/' . $filas['usuario'] . '=' . $filas['idsolicitudamigo'] . '"><img class="rounded-circle img-fluid profile-img-history" src="../vista/images/fotosperfiles/' . $filas['fotoperfil'] . '" alt=""></a>
                        </div>
                        <div class="media-support-info mt-2">
                           <h5 class="mb-0 d-inline-block"><a target="_blank" href="../Perfiles/' . $filas['usuario'] . '=' . $filas['idsolicitudamigo'] . '">' . $filas['nombres'] . " " . $filas['apellidos'] . '</a></h5>
                           <p class="ml-1 mb-0 d-inline-block">public&oacute; una nueva historia</p>
                           <p class="mb-0 text-primary"><i class="ri-timer-flash-line"></i> 
<truncated 2263 bytes>