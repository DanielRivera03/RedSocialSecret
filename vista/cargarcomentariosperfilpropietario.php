<?php 
   if(!isset($_GET['publicaciones'])){
      header('location:../AccesoDenegado=restringido');
     }
     // NO PERMITIR INGRESO SIN INICIAR SESION
     if(!isset($_SESSION['nombre_usuario'])){
        header('location:../AccesoDenegado=restringido');
     }
      // NO PERMITIR INGRESO SI PARAMETRO NO ES IGUAL AL INDICADO
   if($_GET['publicaciones']!="comentariosperfilusuario"){
      header('location:../AccesoDenegado=restringido');
   }
   require('../modelo/mConteoPublicacionesPerfilPropietario.php');
?>
<!-- 
--------------------------------------------------------
║            SECRET - RED SOCIAL PHP NATIVO            ║
--------------------------------------------------------           
    AUTOR: DANIEL RIVERA (danielrivera03)
    Github: https://github.com/DanielRivera03
    VERSIONES TESTEADAS: 7.3 a 8.0
    -> VERSIONES INFERIORES PROBABLEMENTE TENGAN
    ALGUN CONFLICTO. TOMAR EN CUENTA.
    COPYRIGHT © 2020 - 2021
--------------------------------------------------------
-->
<?php
   // SOLAMENTE LOS USUARIOS CON PERFIL COMPLETO PODRAN CONSULTAR TODAS LAS PAGINAS
   // DE ESTA PLATAFORMA
   if($_SESSION['comprobar_perfil']==0){
?>
   <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="../vista/css/bootstrap.min.css">
      <!-- Typography CSS -->
      <link rel="stylesheet" href="../vista/css/typography.css">
      <!-- Style CSS -->
      <link rel="stylesheet" href="../vista/css/style.css">
      <!-- Responsive CSS -->
      <link rel="stylesheet" href="../vista/css/responsive.css">
      <script src="../vista/js/jquery.min.js"></script>
      <script src="../vista/js/popper.min.js"></script>
      <script src="../vista/js/bootstrap.min.js"></script>
      <script src="../vista/js/eliminar-comentarios.js"></script>
      <!-- CONTROLADOR ENVIO / REGISTRO DE REACCIONES -->     
      <script src="../vista/js/alerta-inserccionreacciones.js"></script> 
      <!-- CONTROLADOR ENVIO / REGISTRO DE COMENTARIOS -->                                       
      <script src="../vista/js/alerta-comentarios.js"></script>   
      <!-- Alerts -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
      <!-- Time ago -->
      <script src="../vista/js/jquery.timeago.js"></script>
      <script src="../vista/js/control_tiempo.js"></script>
      <!-- Emoji Jquery -->
      <link href="../vista/emoji/lib/css/emoji.css" rel="stylesheet">
      <!-- Begin emoji-picker JavaScript -->
      <script src="../vista/emoji/lib/js/config.js"></script>
      <script src="../vista/emoji/lib/js/util.js"></script>
      <script src="../vista/emoji/lib/js/jquery.emojiarea.js"></script>
      <script src="../vista/emoji/lib/js/emoji-picker.js"></script>
      <script>
         $(function() {
            // Initializes and creates emoji set from sprite sheet
            window.emojiPicker = new EmojiPicker({
            emojiable_selector: '[data-emojiable=true]',
            assetsPath: '../vista/emoji/lib/img/',
            popupButtonClasses: 'fa fa-smile-o',
         });
        window.emojiPicker.discover();
      });
    </script>
      <body style="background-color:transparent;">
      <div class="comment-area mt-3">
         <div class="d-flex justify-content-between align-items-center">
            <div class="like-block position-relative d-flex align-items-center">
               <div class="d-flex align-items-center">
                  <div class="like-data">
                     <div class="dropdown">
                        <span class="dropdown-toggle" aria-haspopup="true" aria-expanded="false" role="button">
                           <img id="megusta" data-id="<?php echo $_GET['idpublicacion'] ?>" data-id="<?php echo $_SESSION['id_usuario']; ?>" src="../vista/images/icon/01.png" class="img-fluid" alt="megusta">
                        </span>
                     </div>
                  </div>
                  <div class="total-like-block ml-2 mr-3">
                     <div class="dropdown">
                        <span class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                        <?php echo ContadorMeGustaPublicaciones($conectarsistema3,$_GET['idpublicacion']); ?> Me Gusta
                        </span>
                     </div>
                  </div>
               </div>
               <div class="total-comment-block">
                  <div class="dropdown">
                     <span class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                           <?php echo NumeroComentariosPublicaciones($conectarsistema12,$_GET['idpublicacion']); ?> Comentarios
                     </span>
                     <div class="dropdown-menu">
                     <?php
                        // SI CONSULTA ES VACIA, ENTONCES....
                        if(empty($consulta)){
                           echo' <a class="dropdown-item" href="#">No hay comentarios...</a>';
                           }else{
                              // CASO CONTRARIO, IMPRIME NOMBRES DE USUARIOS
                              while($filas=mysqli_fetch_array($consulta1)){
                                 echo '
                                    <a class="dropdown-item" href="#">'; echo $filas['nombres']; echo' '; echo $filas['apellidos']; echo'</a>
                                 ';
                           }
                        }// CIERRE if(empty($consulta)){
                     ?>
                     </div>
                  </div>
               </div>
            </div>
            <div class="share-block d-flex align-items-center feather-icon mr-3">
            <!--
               <a-- href="javascript:void();"><i class="ri-share-line"></i>
               <span class="ml-1">99 Share</span></a-->
            </div>
         </div>
      <hr>
<?php
   // MENSAJE PERSONALIZADO -> CERO COMENTARIOS
      if(empty($consulta)){
         // AVISO A USUARIOS QUE NO EXISTEN COMENTARIOS REGISTRADOS
         echo '
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
      }else{ // MUESTRA LOS COMENTARIOS REGISTRADOS EN X PUBLICACIONES QUE COINCIDA EL ID
         while($filas=mysqli_fetch_array($consulta)){
            // SI CONSULTA EXISTEN REGISTROS, ENTONCES SE MUESTRAN EN PANTALLA LOS DIFERENTES
            // COMENTARIOS REGISTRADOS POR LOS USUARIOS SEGUN ID UNICO DE PUBLICACION EN CUESTION
            echo '
               <ul class="post-comments p-0 m-0">
                  <li class="mb-3">
                     <div class="d-flex flex-wrap">
                        <div class="user-img">
                           <img src="../vista/images/fotosperfiles/'.$filas['fotoperfil'].'" alt="userimg" class="avatar-35 rounded-circle img-fluid">
                        </div>
                        <div class="comment-data-block ml-3">';
                           if($filas['id']==$_SESSION['id_usuario']){
                              // NO PERMITIR VISTA DE PERFIL GENERAL A USUARIO LOGUEADO
                              echo'
                                 <h6>'; echo $filas['nombres']; echo " "; echo $filas['apellidos']; echo' </h6>
                              ';
                           }else{
                              // CONSULTA DE PERFIL GENERAL -> OTROS USUARIOS
                              echo '
                              <h6><a target="_blank" href="../Perfiles/'; echo $filas['usuario']; echo'=';echo $filas['id'];  echo'">'; echo $filas['nombres']; echo " "; echo $filas['apellidos']; echo' </a></h6>
                              ';
                           }
                           echo'
                           <p class="mb-0">'.$filas['comentario'].'</p>
                           <div class="d-flex flex-wrap align-items-center comment-activity">
                           ';
                              if($filas['id']==$_SESSION['id_usuario']){
                                 // ACCION DE BORRAR SI ID USUARIO COINCIDE CON EL ID COMENTARIO REGISTRADO
                                 echo ' <a style="cursor: pointer;" id="eliminarcomentarios" data-id="'.$filas['idcomenterio'].'" ><i class="ri-chat-delete-line"></i> Eliminar</a>';
                              }
                              // INFORMACION HORARIA DE COMENTARIO -> TIEMPO ANTIGUEDAD
                              echo'
                              <span style="color: var(--iq-primary)"><i class="ri-timer-flash-line"></i> <time class="timeago" datetime="'.$filas['fechacomentario'].'"></time> </span>
                           </div>
                        </div>
                     </div>
                  </li>
               </ul>'; }}
?>
      <!-- INGRESO DE COMENTARIOS -> TODA LA PLATAFORMA -> TODAS LAS PUBLICACIONES -->
      <form style="padding: 1rem 0 0 0;" id="form" data-id="<?php echo $_GET['idpublicacion'] ?>" class="comment-text d-flex align-items-center mt-3 needs-validation" novalidate method="POST" autocomplete="off" onSubmit="return ValidarEnvios();">
         <input style="height: 36px; overflow-x: hidden;" data-emojiable="true" data-emoji-input="unicode" type="text" name="caja_comentarios" id="comentarios" class="form-control rounded" placeholder="Ingresa tu comentario aqu&iacute;..." maxlength="255"  required>
            <div class="comment-attagement d-flex">
               <button type="submit" id="enviar" class="btn btn-primary mr-2"><i class="fa fa-send"></i></button>
      </form>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!-- Custom JavaScript -->
<script src="../vista/js/custom.js"></script>                            
</body>
<?php
/*SI UN USUARIO CON PERFIL INCOMPLETO INTENTA ACCEDER AL FEED DE LA APLICACION
SE LE BLOQUEA SU ACCESO Y DEBE OBLIGATORIAMENTE COMPLETAR SU PERFIL PARA PODER
ACCEDER A TODAS LAS FUNCIONES DE ESTA APLICACION*/
}else{header('location:../Controlador/cRegistroNuevosUsuarios.php?nuevoregistro=completarperfil');}
?>