<?php
   $active_page = 'inicio';
   // NO PERMITIR INGRESO SIN ENVIO DE PARAMETRO
   if(!isset($_GET['publicaciones'])){
    header('location:../AccesoDenegado=restringido');
   }
   // NO PERMITIR INGRESO SIN INICIAR SESION
   if(!isset($_SESSION['nombre_usuario'])){
      header('location:../AccesoDenegado=restringido');
   }
   // NO PERMITIR INGRESO SI PARAMETRO NO ES IGUAL AL INDICADO
   if($_GET['publicaciones']!="inicio"){
      header('location:../AccesoDenegado=restringido');
   }
   // INCLUIR ARCHIVO CONTADOR DE PUBLICACIONES -> EXCLUSIVO PERFILES PROPIETARIOS
   require('../modelo/mConteoPublicacionesPerfilPropietario.php');
?>
<?php
   // SOLAMENTE LOS USUARIOS CON PERFIL COMPLETO PODRAN CONSULTAR TODAS LAS PAGINAS
   // DE ESTA PLATAFORMA
   if($_SESSION['comprobar_perfil']==0){
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
<!doctype html>
<html lang="ES-SV">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Secret - Inicio</title>
      <!-- Favicon -->
      <link rel="apple-touch-icon" sizes="180x180" href="../vista/favicon/apple-touch-icon.png">
      <link rel="icon" type="image/png" sizes="32x32" href="../vista/favicon/favicon-32x32.png">
      <link rel="icon" type="image/png" sizes="16x16" href="../vista/favicon/favicon-16x16.png">
      <link rel="manifest" href="../vista/favicon/site.webmanifest">
      <link rel="mask-icon" href="../vista/favicon/safari-pinned-tab.svg" color="#5bbad5">
      <meta name="msapplication-TileColor" content="#da532c">
      <meta name="theme-color" content="#ffffff">
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="../vista/css/bootstrap.min.css">
      <!-- Typography CSS -->
      <link rel="stylesheet" href="../vista/css/typography.css">
      <!-- Style CSS -->
      <link rel="stylesheet" href="../vista/css/style.css">
      <!-- Responsive CSS -->
      <link rel="stylesheet" href="../vista/css/responsive.css">
      <!-- Bootstrap Dropzone CSS -->
      <link href="../vista/dropzone/dist/dropzone.css" rel="stylesheet" type="text/css"/>
      <!-- Bootstrap Dropzone CSS -->
      <link href="../vista/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css"/>
     <!-- Notifications Premium -->
     <script src="../vista/js/notificaciones-premium.js"></script>
   </head>
   <body class="right-column-fixed">
   <!-- 
--------------------------------------------------------
║            SECRET - RED SOCIAL PHP NATIVO            ║
    AUTOR: DANIEL RIVERA (danielrivera03)
    Github: https://github.com/DanielRivera03
    VERSIONES TESTEADAS: 7.3 a 8.0
    -> VERSIONES INFERIORES PROBABLEMENTE TENGAN
    ALGUN CONFLICTO. TOMAR EN CUENTA.
    COPYRIGHT © 2020 - 2021
--------------------------------------------------------
-->
<!doctype html>
<html lang="ES-SV">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Secret - Inicio</title>
      <!-- Favicon -->
      <link rel="apple-touch-icon" sizes="180x180" href="../vista/favicon/apple-touch-icon.png">
      <link rel="icon" type="image/png" sizes="32x32" href="../vista/favicon/favicon-32x32.png">
      <link rel="icon" type="image/png" sizes="16x16" href="../vista/favicon/favicon-16x16.png">
      <link rel="manifest" href="../vista/favicon/site.webmanifest">
      <link rel="mask-icon" href="../vista/favicon/safari-pinned-tab.svg" color="#5bbad5">
      <meta name="msapplication-TileColor" content="#da532c">
      <meta name="theme-color" content="#ffffff">
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="../vista/css/bootstrap.min.css">
      <!-- Typography CSS -->
      <link rel="stylesheet" href="../vista/css/typography.css">
      <!-- Style CSS -->
      <link rel="stylesheet" href="../vista/css/style.css">
      <!-- Responsive CSS -->
      <link rel="stylesheet" href="../vista/css/responsive.css">
      <!-- Bootstrap Dropzone CSS -->
      <link href="../vista/dropzone/dist/dropzone.css" rel="stylesheet" type="text/css"/>
      <!-- Bootstrap Dropzone CSS -->
      <link href="../vista/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css"/>
     <!-- Notifications Premium -->
     <script src="../vista/js/notificaciones-premium.js"></script>
   </head>
   <body class="right-column-fixed">
      <!-- Hidden user ID and photo for JS -->
      <input type="hidden" id="mi-id-usuario" value="<?php echo $_SESSION['id_usuario']; ?>">
      <input type="hidden" id="mi-foto-perfil" value="<?php echo $_SESSION['fotos_perfiles']; ?>">
      <!-- loader Start -->
      <div id="loading">
         <div id="loading-center">
         </div>
      </div>
      <!-- loader END -->
      <!-- Wrapper Start -->
      <div class="wrapper">
         <?php include __DIR__ . '/premium_sidebar.php'; ?>
         <?php include __DIR__ . '/premium_topnav.php'; ?>
         <!-- Page Content  -->
         <div id="content-page" class="content-page">
            <div class="container">
               <div class="row">
                <div class="col-lg-8">
                                    <!-- NOTAS DE MUSICA -->
                                    <div id="notas-musica-container"></div>

                                    <!-- HISTORIAS (STORIES BAR) -->
                                    <div id="historias-envivo-container"></div>

                                    <div id="post-modal-data" class="iq-card">
                                       <div class="iq-card-header d-flex justify-content-between">
                                          <div class="iq-header-title">
                                             <h4 class="card-title">Nueva Publicaci&oacute;n</h4>
                                          </div>
                                       </div>
                                       <div class="iq-card-body" data-toggle="modal" data-target="#post-modal">
                                          <div class="d-flex align-items-center">
                                             <div class="user-img">
                                                <img src="../vista/images/fotosperfiles/<?php echo  $_SESSION['fotos_perfiles'];?>" alt="userimg" class="avatar-60 rounded-circle">
                                             </div>
                                             <form class="post-text ml-3 w-100" action="javascript:void();">
                                                <input type="text" class="form-control rounded" placeholder="<?php echo $_SESSION['nombre_usuario'] ?> ¿En qu&eacute; est&aacute;s pensando?" style="border:none;">
                                             </form>
                                          </div>
                                       </div>
                                    </div>
                                    <!-- FEED INFINITO CON SKELETON LOADING -->
                                     <div id="feed-publications"></div>
                                     <!-- FIN FEED INFINITO -->
                                  </div>
                  <div class="col-lg-4">
                     <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title">Eventos Sociales</h4>
                           </div>
                           <div class="iq-card-header-toolbar d-flex align-items-center">
                           </div>
                        </div>
                        <div class="iq-card-body">
                           <ul class="media-story m-0 p-0">
                           <!-- INICIO BANDERA -> EVENTOS SOCIALES -->
                           <?php 
                              while($filas=mysqli_fetch_array($consulta4)){
                                 echo '
                                 <li class="d-flex mb-4 align-items-center ">
                                 <img src="../vista/images/fotoseventos/'; echo $filas['fotoevento']; echo'" alt="story-img" class="rounded-circle img-fluid">
                                 <div class="stories-data ml-3">
                                    <h5>'; echo $filas['nombre']; echo'</h5>
                                    <p class="mb-0">'; 
                                    $FechaInicio = $filas['fechainicio']; $FechaCompleta = strtotime($FechaInicio); $ObtenerMes = date("m", $FechaCompleta); $ObtenerDia = date("d", $FechaCompleta); echo $ObtenerDia; echo " de ";
                                    // VALIDACIONES SEGUN MES OBTENIDO
                                    if($ObtenerMes==1){
                                       echo "Enero";
                                    }else if($ObtenerMes==2){
                                       echo "Febrero";
                                    }else if($ObtenerMes==3){
                                       echo "Marzo";
                                    }else if($ObtenerMes==4){
                                       echo "Abril";
                                    }else if($ObtenerMes==5){
                                       echo "Mayo";
                                    }else if($ObtenerMes==6){
                                       echo "Junio";
                                    }else if($ObtenerMes==7){
                                       echo "Julio";
                                    }else if($ObtenerMes==8){
                                       echo "Agosto";
                                    }else if($ObtenerMes==9){
                                       echo "Septiembre";
                                    }else if($ObtenerMes==10){
                                       echo "Octubre";
                                    }else if($ObtenerMes==11){
                                       echo "Noviembre";
                                    }else if($ObtenerMes==12){
                                       echo "Diciembre";
                                    }
                                    echo'</p>
                                 </div>
                              </li>
                                 ';
                              }
                           ?>
                           </ul>
                        </div>
                     </div>
                     <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title">Cumplea&ntilde;eros</h4>
                           </div>
                        </div>
                        <div class="iq-card-body">
                           <ul class="media-story m-0 p-0">
                           <!-- INICIO BANDERA CUMPLEAÑEROS DE ESTE DIA -->
                           <?php  
                              while($filas=mysqli_fetch_array($consulta3)){
                                 echo'
                                 <li class="d-flex mb-4 align-items-center">
                                 <img src="../vista/images/fotosperfiles/'; echo $filas['fotoperfil']; echo'" alt="story-img" class="rounded-circle img-fluid">
                                 <div class="stories-data ml-3">
                                    <h5>'; echo $filas['nombres']; echo ' '; echo $filas['apellidos']; echo'</h5>
                                    <p class="mb-0">&#127880; Cumple a&ntilde;os hoy &#127882;</p>
                                 </div>
                              </li>
                                 ';
                              }
                           ?>
                           <!-- FIN BANDERA CUMPLEAÑEROS DE ESTE DIA -->
                           </ul>
                        </div>
                     </div>
                     
                  </div>
                  <div class="col-sm-12 text-center">
                     <!--img src="images/page-img/page-load-loader.gif" alt="loader" style="height: 100px;"-->
                  </div>
               </div>
            </div>
         </div>
      <!-- MODAL PUBLICAR -->
      <div class="modal fade" id="post-modal" tabindex="-1" role="dialog" aria-labelledby="post-modalLabel" aria-hidden="true" style="display:none;">
         <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="post-modalLabel">Crear nueva publicaci&oacute;n</h5>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ri-close-fill"></i></button>
               </div>
               <div class="modal-body">
                  <div class="d-flex align-items-start">
                     <div class="user-img mr-2 mt-1">
                        <img src="../vista/images/fotosperfiles/<?php echo $_SESSION['fotos_perfiles'];?>" alt="userimg" class="avatar-70 rounded-circle">
                     </div>
                     <form id="form" class="post-text ml-2 w-100" action="javascript:void();" novalidate method="POST" autocomplete="off" enctype="multipart/form-data">
                        <textarea name="historiausuario" id="publicaciones_usuarios" class="form-control rounded" placeholder="<?php echo $_SESSION['nombre_usuario'] ?> ¿En qu&eacute; est&aacute;s pensando?" maxlength="150" onpaste="ContadorCaracteresMaximoPublicaciones();" onkeyup="ContadorCaracteresMaximoPublicaciones();"></textarea>
                        
                        <!-- Gradient selector -->
                        <div class="form-group mt-2">
                             <label class="d-block font-weight-600 text-muted mb-2" style="font-size: 13px;">Fondo degradado (Opcional):</label>
                             <div class="d-flex align-items-center" style="gap: 8px;">
                                 <button type="button" class="btn btn-outline-secondary rounded-circle btn-gradient-select active" data-gradient="" style="width: 32px; height: 32px; padding: 0;" title="Sin Fondo"><i class="ri-close-line"></i></button>
                                 <button type="button" class="btn rounded-circle btn-gradient-select" data-gradient="post-gradient-sunset" style="width: 32px; height: 32px; padding: 0; background: linear-gradient(135deg, #ff7e5f, #feb47b);" title="Atardecer"></button>
                                 <button type="button" class="btn rounded-circle btn-gradient-select" data-gradient="post-gradient-ocean" style="width: 32px; height: 32px; padding: 0; background: linear-gradient(135deg, #2b5876, #4e4376);" title="Océano"></button>
                                 <button type="button" class="btn rounded-circle btn-gradient-select" data-gradient="post-gradient-fire" style="width: 32px; height: 32px; padding: 0; background: linear-gradient(135deg, #f12711, #f5af19);" title="Fuego"></button>
                                 <button type="button" class="btn rounded-circle btn-gradient-select" data-gradient="post-gradient-neon" style="width: 32px; height: 32px; padding: 0; background: linear-gradient(135deg, #0575e6, #00f260);" title="Neon"></button>
                                 <button type="button" class="btn rounded-circle btn-gradient-select" data-gradient="post-gradient-glass" style="width: 32px; height: 32px; padding: 0; background: linear-gradient(135deg, #8a2be2, #4a00e0);" title="Mágico"></button>
                             </div>
                             <input type="hidden" name="fondo_gradiente" id="fondo_gradiente_input" value="">
                         </div>

                         <!-- Sentiments selector -->
                         <div class="form-group mt-2">
                             <label class="font-weight-600 text-muted mb-1" style="font-size: 13px;">¿Cómo te sientes? (Opcional):</label>
                             <select name="sentimiento" class="form-control rounded" style="font-size: 13px;">
                                 <option value="">Ninguno</option>
                                 <option value="😊 entusiasmado(a)">😊 entusiasmado(a)</option>
                                 <option value="😎 feliz">😎 feliz</option>
                                 <option value="😴 cansado(a)">😴 cansado(a)</option>
                                 <option value="🤔 pensativo(a)">🤔 pensativo(a)</option>
                                 <option value="😍 enamorado(a)">😍 enamorado(a)</option>
                                 <option value="😢 triste">😢 triste</option>
                                 <option value="😡 enojado(a)">😡 enojado(a)</option>
                                 <option value="🤪 divertido(a)">🤪 divertido(a)</option>
                                 <option value="🎶 escuchando música">🎶 escuchando música</option>
                             </select>
                         </div>
                        
                        <div id="respuesta_contador"></div>
                        <p id="contador"></p><br>
                        <p>Adjuntar fotos (máximo 5):</p>
                         <div class="custom-file-upload-container">
                             <div class="drag-drop-area" id="drag-drop-area" onclick="document.getElementById('input-file-max-fs').click();">
                                 <i class="ri-gallery-upload-line" style="font-size: 32px; color: var(--iq-primary);"></i>
                                 <p class="mt-2 mb-0" style="font-weight: 600;">Selecciona hasta 5 fotos (JPG, PNG)</p>
                                 <span class="text-muted" style="font-size: 12px;">o arrastra y suelta tus imágenes aquí</span>
                             </div>
                             <input type="file" name="fotospublicaciones[]" id="input-file-max-fs" multiple accept="image/x-png,image/jpeg,image/jpg" style="display: none;" onchange="previewImages(this);" />
                             <div id="image-collage-preview" class="image-collage-preview mt-3"></div>
                         </div>
                         <hr>
                        <button type="submit" id="enviar" class="btn btn-primary d-block w-100 mt-3">Publicar Historia</button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      </div>
      <!-- Wrapper END -->
      <!-- Footer -->
      <footer class="bg-white iq-footer">
         <div class="container-fluid">
            <div class="row">
               <div class="col-lg-6">
                  <ul class="list-inline mb-0">
                     <li class="list-inline-item"><a href="../Secret/privacidad-condiciones">T&eacute;rminos y Condiciones de Uso</a></li>
                  </ul>
               </div>
               <div class="col-lg-6 text-right">
               &copy; Copyright <?php echo date('Y'); ?> Secret&reg;<br>Derechos Reservados
               </div>
            </div>
         </div>
      </footer>
      <!-- Footer END -->
      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="../vista/js/jquery.min.js"></script>
      <script src="../vista/js/popper.min.js"></script>
      <script src="../vista/js/bootstrap.min.js"></script>
      <!-- Appear JavaScript -->
      <script src="../vista/js/jquery.appear.js"></script>
      <!-- Countdown JavaScript -->
      <script src="../vista/js/countdown.min.js"></script>
      <!-- Counterup JavaScript -->
      <script src="../vista/js/waypoints.min.js"></script>
      <script src="../vista/js/jquery.counterup.min.js"></script>
      <!-- Wow JavaScript -->
      <script src="../vista/js/wow.min.js"></script>
      <!-- Apexcharts JavaScript -->
      <script src="../vista/js/apexcharts.js"></script>
      <!-- Slick JavaScript -->
      <script src="../vista/js/slick.min.js"></script>
      <!-- Select2 JavaScript -->
      <script src="../vista/js/select2.min.js"></script>
      <!-- Owl Carousel JavaScript -->
      <script src="../vista/js/owl.carousel.min.js"></script>
      <!-- Magnific Popup JavaScript -->
      <script src="../vista/js/jquery.magnific-popup.min.js"></script>
      <!-- Smooth Scrollbar JavaScript -->
      <script src="../vista/js/smooth-scrollbar.js"></script>
      <!-- lottie JavaScript -->
      <script src="../vista/js/lottie.js"></script>
      <!-- am core JavaScript -->
      <script src="../vista/js/core.js"></script>
      <!-- am charts JavaScript -->
      <script src="../vista/js/charts.js"></script>
      <!-- am animated JavaScript -->
      <script src="../vista/js/animated.js"></script>
      <!-- am kelly JavaScript -->
      <script src="../vista/js/kelly.js"></script>
      <!-- am maps JavaScript -->
      <script src="../vista/js/maps.js"></script>
      <!-- am worldLow JavaScript -->
      <script src="../vista/js/worldLow.js"></script>
      <!-- Chart Custom JavaScript -->
      <script src="../vista/js/chart-custom.js"></script>
      <!-- Custom JavaScript -->
      <script src="../vista/js/custom.js"></script>
      <!-- Dropzone JavaScript -->
      <script src="../vista/dropzone/dist/dropzone.js"></script>
      <!-- Dropify JavaScript -->
    <script src="../vista/dropify/dist/js/dropify.min.js"></script>
    <!-- Form Flie Upload Data JavaScript -->
    <script src="../vista/js/form-file-upload-data.js"></script>
    <script src="../vista/js/contador_caracteres.js"></script>
    <!-- Time ago -->
    <script src="../vista/js/jquery.timeago.js"></script>
    <script src="../vista/js/control_tiempo.js"></script>
    <!-- Alert -->
    <script src="../vista/js/alerta_publicaciones.js"></script>
    <script src="../vista/js/alerta_eliminarhistorias.js"></script>
    <script src="../vista/js/alerta-enviosolicitudamistad.js"></script>
    <script src="../vista/js/alerta-solicitudesaceptadas.js"></script>
    <script src="../vista/js/alerta-eliminarsolicitudamistad.js"></script>
    <script src="../vista/js/alerta_buscador.js"></script>
    <script src="../vista/js/conexion_envivo.js"></script>
    <script src="../vista/js/feed_envivo.js"></script>
    <script src="../vista/js/historias_envivo.js"></script>
    <script src="../vista/js/notas_musica.js"></script>
    <script src="../vista/js/floating_chat.js?v=3"></script>
    <!-- Feed Infinito -->
    <script src="../vista/js/feed-infinito.js"></script>
    <script>
      $(document).ready(function() {
        FeedInfinito.init({ tipo: 'inicio', contenedor: 'feed-publications' });
      });
    </script>
    <script>
    function previewImages(input) {
        const previewContainer = document.getElementById('image-collage-preview');
        if (!previewContainer) return;
        previewContainer.innerHTML = '';
        
        let files = Array.from(input.files);
        if (files.length > 5) {
            Swal.fire({
                title: 'Límite de imágenes',
                text: 'Solo se pueden subir un máximo de 5 fotos. Las primeras 5 fotos han sido seleccionadas.',
                icon: 'warning'
            });
            files = files.slice(0, 5);
            
            const dataTransfer = new DataTransfer();
            files.forEach(file => dataTransfer.items.add(file));
            input.files = dataTransfer.files;
        }
        
        if (files.length === 0) return;
        
        previewContainer.className = `image-collage-preview grid-${files.length}`;
        
        files.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const item = document.createElement('div');
                item.className = 'preview-item';
                item.style.backgroundImage = `url('${e.target.result}')`;
                
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'remove-preview-btn';
                removeBtn.innerHTML = '<i class="ri-close-line"></i>';
                removeBtn.onclick = function(event) {
                    event.stopPropagation();
                    removeFile(index, input);
                };
                
                item.appendChild(removeBtn);
                previewContainer.appendChild(item);
            };
            reader.readAsDataURL(file);
        });
    }

    function removeFile(indexToRemove, input) {
        const dataTransfer = new DataTransfer();
        const files = Array.from(input.files);
        
        files.forEach((file, index) => {
            if (index !== indexToRemove) {
                dataTransfer.items.add(file);
            }
        });
        
        input.files = dataTransfer.files;
        previewImages(input);
    }

    $(document).ready(function() {

        $('.btn-gradient-select').on('click', function() {
            $('.btn-gradient-select').removeClass('active border-primary').addClass('border-secondary');
            $(this).addClass('active border-primary').removeClass('border-secondary');
            let gradient = $(this).data('gradient');
            $('#fondo_gradiente_input').val(gradient);
            
            let textarea = $('#publicaciones_usuarios');
            textarea.removeClass('post-gradient-sunset post-gradient-ocean post-gradient-fire post-gradient-neon post-gradient-glass');
            if (gradient) {
                textarea.addClass(gradient);
                textarea.css({
                    'text-align': 'center',
                    'font-weight': 'bold',
                    'font-size': '18px',
                    'padding': '30px 10px',
                    'color': '#ffffff'
                });
            } else {
                textarea.css({
                    'text-align': '',
                    'font-weight': '',
                    'font-size': '',
                    'padding': '',
                    'color': ''
                });
            }
        });

        const dragArea = document.getElementById('drag-drop-area');
        const fileInput = document.getElementById('input-file-max-fs');
        if (dragArea && fileInput) {
            ['dragenter', 'dragover'].forEach(eventName => {
                dragArea.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    dragArea.classList.add('dragover');
                }, false);
            });
            ['dragleave', 'drop'].forEach(eventName => {
                dragArea.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    dragArea.classList.remove('dragover');
                }, false);
            });
            dragArea.addEventListener('drop', (e) => {
                const dt = e.dataTransfer;
                const files = dt.files;
                fileInput.files = files;
                previewImages(fileInput);
            }, false);
        }
    });
    </script>
     <?php include __DIR__ . '/fb_viewer_modal.php'; ?>
     <?php include __DIR__ . '/stories_viewer.php'; ?>
   </body>
</html>
<?php
}else{header('location:../Controlador/cRegistroNuevosUsuarios.php?nuevoregistro=completarperfil');}
?>
