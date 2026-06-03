"<?php
session_start();
if(!isset($_SESSION['id_usuario'])){
    die(json_encode(['error' => 'No autorizado']));
}

require('../modelo/conexion.php');
require('../modelo/mModeloPublicaciones.php');

$Publicaciones = new ModeloPublicaciones();
$IdPublicaciones = isset($_GET['idpublicacion']) ? $_GET['idpublicacion'] : '';

if(empty($IdPublicaciones)) {
    die('');
}

$consulta = $Publicaciones->ConsultarComentariosPerfilPropietario($conectarsistema, $IdPublicaciones);

$html = '';

if(empty($consulta) || mysqli_num_rows($consulta) == 0){
    $html .= '
    <ul class="post-comments p-0 m-0">
        <li class="mb-3">
            <div class="d-flex flex-wrap">
            <div class="comment-data-block ml-3">
                <i class="no-coment-icon fa fa-lock"></i>
                <h4 class="no-coment-text">&#128530; Parece que nadie ha comentado esta historia... &#128532;<br>¡Vamos s&eacute; el primero en reaccionar!</h4>
            </div>
            </div>
        </li>
    </ul>';
} else {
    while($filas = mysqli_fetch_array($consulta)){
        $html .= '<ul class="post-comments p-0 m-0"><li class="mb-3"><div class="d-flex flex-wrap">';
        $html .= '<div class="user-img">';
        $html .= '<img src="../vista/images/fotosperfiles/'.$filas['fotoperfil'].'" alt="userimg" class="avatar-35 rounded-circle img-fluid">';
        $html .= '</div>';
        $html .= '<div class="comment-data-block ml-3">';
        
        if($filas['id'] == $_SESSION['id_usuario']){
            $html .= '<h6>' . $filas['nombres'] . ' ' . $filas['apellidos'] . '</h6>';
        } else {
            $html .= '<h6><a target="_blank" href="../Perfiles/' . $filas['usuario'] . '=' . $filas['id'] . '">' . $filas['nombres'] . ' ' . $filas['apellidos'] . '</a></h6>';
        }
        
        $html .= '<p class="mb-0">' . $filas['comentario'] . '</p>';
        $html .= '<div class="d-flex flex-wrap align-items-center comment-activity">';
        
  
<truncated 507 bytes>