<?php
session_start();
if(!isset($_SESSION['id_usuario'])){
    die("No autorizado");
}
require('../modelo/conexion.php');
require('../modelo/mConteoPublicacionesPerfilPropietario.php');
$idpublicacion = isset($_GET['idpublicacion']) ? intval($_GET['idpublicacion']) : 0;

$usuario_ya_reacciono = false;
$user_reaction_type = 1;
$check_reaccion = mysqli_query($conectarsistema1, "SELECT tipo_reaccion FROM reacciones WHERE id='".$_SESSION['id_usuario']."' AND idpublicacion='$idpublicacion' LIMIT 1");
if ($check_reaccion && mysqli_num_rows($check_reaccion) > 0) {
    $usuario_ya_reacciono = true;
    $row_reaccion = mysqli_fetch_assoc($check_reaccion);
    $user_reaction_type = $row_reaccion['tipo_reaccion'] ? $row_reaccion['tipo_reaccion'] : 1;
}

$consulta = mysqli_query($conectarsistema, "SELECT c.idcomenterio, c.comentario, c.fechacomentario, u.id, u.nombres, u.apellidos, u.usuario, u.fotoperfil FROM comentarios c INNER JOIN usuarios u ON c.id = u.id WHERE c.idpublicacion = '$idpublicacion' ORDER BY c.idcomenterio ASC");
?>
<div class="comment-area mt-3">
   <div class="d-flex justify-content-between align-items-center">
      <div class="like-block position-relative d-flex align-items-center">
         <div class="d-flex align-items-center">
            <div class="like-data" style="position:relative;">
                <div class="dropdown fb-reaction-container">
                      <?php 
                      $icons = [
                          1 => 'https://em-content.zobj.net/source/animated-noto-color-emoji/356/thumbs-up_1f44d.gif',
                          2 => 'https://em-content.zobj.net/source/animated-noto-color-emoji/356/red-heart_2764-fe0f.gif',
                          3 => 'https://em-content.zobj.net/source/animated-noto-color-emoji/356/face-with-tears-of-joy_1f602.gif',
                          4 => 'https://em-content.zobj.net/source/animated-noto-color-emoji/356/astonished-face_1f632.gif',
                          5 => 'https://em-content.zobj.net/source/animated-noto-color-emoji/356/crying-face_1f622.gif',
                          6 => 'https://em-content.zobj.net/source/animated-noto-color-emoji/356/pouting-face_1f621.gif'
                      ];
                      $mainIcon = $usuario_ya_reacciono ? $icons[$user_reaction_type] : $icons[1];
                      $shadowColores = [
                          1 => 'rgba(24, 119, 242, 0.6)',
                          2 => 'rgba(229, 57, 53, 0.6)',
                          3 => 'rgba(245, 158, 11, 0.6)',
                          4 => 'rgba(139, 92, 246, 0.6)',
                          5 => 'rgba(59, 130, 246, 0.6)',
                          6 => 'rgba(229, 57, 53, 0.6)',
                      ];
                      $currentShadow = $usuario_ya_reacciono ? $shadowColores[$user_reaction_type] : 'rgba(24, 119, 242, 0.6)';
                      ?>
                       <span class="btn-main-reaccion" data-id="<?php echo $idpublicacion; ?>" style="cursor:pointer; display:inline-flex; align-items:center; gap:6px;">
                           <img src="<?php echo $mainIcon; ?>" class="img-fluid <?php echo $usuario_ya_reacciono ? 'reaccion-activa' : ''; ?>" alt="megusta" style="width: 28px; <?php echo $usuario_ya_reacciono ? 'filter: drop-shadow(0px 0px 6px ' . $currentShadow . ') brightness(1.15); transform: scale(1.1);' : ''; ?> transition: all 0.2s;">
                           <?php if($usuario_ya_reacciono): 
                               $reaccionLabels = [1=>'Me Gusta',2=>'Me Encanta',3=>'Me Divierte',4=>'Me Asombra',5=>'Me Entristece',6=>'Me Enoja'];
                               $reaccionColores = [1=>'#1877f2',2=>'#e53935',3=>'#f59e0b',4=>'#8b5cf6',5=>'#3b82f6',6=>'#e53935'];
                           ?>
                           <small style="font-size:12px; font-weight:700; color:<?php echo $reaccionColores[$user_reaction_type] ?? '#1877f2'; ?>">
                             <?php echo $reaccionLabels[$user_reaction_type] ?? 'Me Gusta'; ?>
                           </small>
                           <?php else: ?>
                           <small style="font-size:12px; font-weight:600; color: var(--iq-body-text);">
                             Me Gusta
                           </small>
                           <?php endif; ?>
                       </span>
                    
                   <div class="fb-reactions-box shadow" style="display:none; position:absolute; bottom:40px; left:-10px; background:#fff; border-radius:50px; padding:10px 14px; box-shadow:0 8px 25px rgba(0,0,0,0.18); z-index:9999; width:max-content;">
                      <div style="display:flex; align-items:center; gap:10px;">
                          <?php 
                          $reactionData = [
                            1 => ['gif'=>'https://em-content.zobj.net/source/animated-noto-color-emoji/356/thumbs-up_1f44d.gif','label'=>'Me Gusta','color'=>'#1877f2'],
                            2 => ['gif'=>'https://em-content.zobj.net/source/animated-noto-color-emoji/356/red-heart_2764-fe0f.gif','label'=>'Me Encanta','color'=>'#e53935'],
                            3 => ['gif'=>'https://em-content.zobj.net/source/animated-noto-color-emoji/356/face-with-tears-of-joy_1f602.gif','label'=>'Me Divierte','color'=>'#f59e0b'],
                            4 => ['gif'=>'https://em-content.zobj.net/source/animated-noto-color-emoji/356/astonished-face_1f632.gif','label'=>'Me Asombra','color'=>'#8b5cf6'],
                            5 => ['gif'=>'https://em-content.zobj.net/source/animated-noto-color-emoji/356/crying-face_1f622.gif','label'=>'Me Entristece','color'=>'#3b82f6'],
                            6 => ['gif'=>'https://em-content.zobj.net/source/animated-noto-color-emoji/356/pouting-face_1f621.gif','label'=>'Me Enoja','color'=>'#e53935'],
                          ];
                          foreach($reactionData as $tipo => $rd):
                            $isActive = $usuario_ya_reacciono && $user_reaction_type == $tipo;
                            $activeStyle = $isActive 
                              ? "outline: 3px solid {$rd['color']}; border-radius:50%; transform:scale(1.25) translateY(-3px); background:rgba(0,0,0,0.05);" 
                              : "";
                          ?>
                          <div style="display:flex;flex-direction:column;align-items:center;gap:3px;">
                            <img src="<?php echo $rd['gif']; ?>" 
                              class="btn-fb-reaction" 
                              data-tipo="<?php echo $tipo; ?>" 
                              data-id="<?php echo $idpublicacion; ?>" 
                              style="width:42px; height:42px; cursor:pointer; transition:transform 0.2s; <?php echo $activeStyle; ?> padding:2px;" 
                              onmouseover="if(!this.classList.contains('reaction-hover')){this.style.transform='scale(1.35) translateY(-6px)'; this.style.filter='drop-shadow(0 4px 8px rgba(0,0,0,0.2))';}" 
                              onmouseout="this.style.transform='<?php echo $isActive ? 'scale(1.25) translateY(-3px)' : 'scale(1) translateY(0)'; ?>'; this.style.filter='';" 
                              title="<?php echo $rd['label']; ?>">
                            <?php if($isActive): ?>
                            <small style="font-size:9px;font-weight:700;color:<?php echo $rd['color']; ?>;white-space:nowrap;"> ✓ </small>
                            <?php endif; ?>
                          </div>
                          <?php endforeach; ?>
                      </div>
                   </div>
                </div>
            </div>
            <div class="total-like-block ml-2 mr-3">
               <div class="dropdown">
                  <span class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                  <?php echo ContadorMeGustaPublicaciones($conectarsistema3, $idpublicacion); ?> Reacciones
                  </span>
               </div>
            </div>
         </div>
         <div class="total-comment-block">
            <div class="dropdown">
               <span class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                     <?php echo NumeroComentariosPublicaciones($conectarsistema12, $idpublicacion); ?> Comentarios
               </span>
            </div>
         </div>
      </div>
   </div>
   <hr>
<?php
if(empty($consulta) || mysqli_num_rows($consulta) == 0){
   echo '<ul class="post-comments p-0 m-0">
            <li class="mb-3">
               <div class="d-flex flex-wrap">
                  <div class="comment-data-block ml-3">
                     <i class="no-coment-icon fa fa-lock"></i>
                     <h6 class="no-coment-text">&#128530; Parece que nadie ha comentado esta historia... <br>¡Sé el primero en reaccionar!</h6>
                  </div>
               </div>
            </li>
         </ul>';
} else {
   while($filas = mysqli_fetch_array($consulta)){
      echo '<ul class="post-comments p-0 m-0">
            <li class="mb-3">
               <div class="d-flex flex-wrap">
                  <div class="user-img">
                     <img src="../vista/images/fotosperfiles/'.$filas['fotoperfil'].'" alt="userimg" class="avatar-35 rounded-circle img-fluid">
                  </div>
                  <div class="comment-data-block ml-3">';
                     if($filas['id'] == $_SESSION['id_usuario']){
                        echo '<h6>' . $filas['nombres'] . ' ' . $filas['apellidos'] . '</h6>';
                     }else{
                        echo '<h6><a target="_blank" href="../Perfiles/' . $filas['usuario'] . '=' . $filas['id'] . '">' . $filas['nombres'] . ' ' . $filas['apellidos'] . '</a></h6>';
                     }
                     echo '<p class="mb-0">'.$filas['comentario'].'</p>
                     <div class="d-flex flex-wrap align-items-center comment-activity">';
                        if($filas['id'] == $_SESSION['id_usuario']){
                           echo '<a style="cursor: pointer; color:red;" class="eliminarcomentarios" data-id="'.$filas['idcomenterio'].'"><i class="ri-chat-delete-line"></i> Eliminar</a>';
                        }
                        echo '<span style="color: var(--iq-primary); margin-left: 10px;"><i class="ri-timer-flash-line"></i> <time class="timeago" datetime="'.$filas['fechacomentario'].'"></time></span>
                     </div>
                  </div>
               </div>
            </li>
         </ul>';
   }
}
?>
<!-- Formulario para comentar -->
<form class="comment-text d-flex align-items-center mt-3 submit-comment-form" action="javascript:void(0);" style="padding: 0 0 .5rem 0;">
   <img src="../vista/images/fotosperfiles/<?php echo $_SESSION['fotos_perfiles']; ?>" class="avatar-35 rounded-circle img-fluid mr-2" alt="yo" style="flex-shrink:0;">
   <input type="text" class="form-control rounded" placeholder="Escribe un comentario..." name="comentario" autocomplete="off" required>
   <input type="hidden" name="idpublicacion" value="<?php echo $idpublicacion; ?>">
   <button type="submit" class="btn btn-primary ml-2" style="flex-shrink:0;"><i class="ri-send-plane-fill"></i></button>
</form>
</div>
<script>
    if (typeof jQuery !== "undefined" && typeof jQuery.timeago === "function") {
        jQuery("time.timeago").timeago();
    }
</script>
