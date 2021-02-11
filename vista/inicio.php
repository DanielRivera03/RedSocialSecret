<?php
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
     <!-- Alerts -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
   </head>
   <body class="right-column-fixed">
      <!-- loader Start -->
      <div id="loading">
         <div id="loading-center">
         </div>
      </div>
      <!-- loader END -->
      <!-- Wrapper Start -->
      <div class="wrapper">
         <!-- Sidebar  -->
         <div class="iq-sidebar">
            <div id="sidebar-scrollbar">
               <nav class="iq-sidebar-menu">
                  <ul id="iq-sidebar-toggle" class="iq-menu">
                     <li class="active">
                        <a href="../Feed/inicio" class="iq-waves-effect"><i class="las la-newspaper"></i><span>Inicio</span></a>
                     </li>
                     <li>
                        <a href="../Perfil/<?php echo $_SESSION['usuario_unico'];?>" class="iq-waves-effect"><i class="las la-user"></i><span>Mi Perfil</span></a>
                     </li>
                     <li>
                        <a href="../MisAmigos/explorar-amigos-aceptados" class="iq-waves-effect"><i class="las la-user-friends"></i><span>Mis Amigos</span></a>
                     </li>
                     <li>
                        <a href="../Amigos/explorar-amigos" class="iq-waves-effect"><i class="las la-smile"></i><span>Explorar Amigos</span></a>
                     </li>
                     <li>
                        <a href="../Notificaciones/<?php echo $_SESSION['usuario_unico']; ?>" class="iq-waves-effect"><i class="las la-bell"></i><span>Mis Notificaciones</span></a>
                     </li>
                     <li>
                        <a href="../EventosSociales/registrareventos" class="iq-waves-effect"><i class="las la-film"></i><span>Registrar Eventos</span></a>
                     </li>
                     <li>
                        <a href="../Eventos/mostrareventos" class="iq-waves-effect"><i class="las la-bullhorn"></i><span>Ver Eventos</span></a>
                     </li>
                     <li>
                        <a href="../ChatGeneral/mensajeria-secret" class="iq-waves-effect"><i class="lab la-rocketchat"></i><span>Mensajes</span></a>
                     </li>
                     <li>
                        <a href="../Videos/multimedia-secretvideos" class="iq-waves-effect"><i class="ri-play-circle-line"></i><span>M&uacute;sica Favorita</span></a>
                     </li>
                  </ul>
               </nav>
               <div class="p-3"></div>
            </div>
         </div>
         <!-- TOP Nav Bar -->
         <div class="iq-top-navbar">
            <div class="iq-navbar-custom">
               <nav class="navbar navbar-expand-lg navbar-light p-0">
                  <div class="iq-navbar-logo d-flex justify-content-between">
                     <a href="#">
                     <img src="../vista/images/logo.png" class="img-fluid" alt="">
                     <span>Secret</span>
                     </a>
                     <div class="iq-menu-bt align-self-center">
                     <div class="wrapper-menu">
                        <div class="main-circle"><i class="ri-menu-line"></i></div>
                     </div>
                  </div>
                  </div>
                  <div class="iq-search-bar">
                     <form action="../Buscador/resultados-busqueda" class="searchbox needs-validation" novalidate method="POST" autocomplete="off">
                        <input type="text" class="text search-input" name="buscador" placeholder="Buscar en Secret..." required>
                        <a class="search-link" href="#"><i class="ri-search-line"></i></a>
                     </form>
                  </div>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"  aria-label="Toggle navigation">
                  <i class="ri-menu-3-line"></i>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                     <ul class="navbar-nav ml-auto navbar-list">
                        <li>
                           <a href="../Perfil/<?php echo $_SESSION['usuario_unico'];?>" class="iq-waves-effect d-flex align-items-center">
                              <img src="../vista/images/fotosperfiles/<?php echo $_SESSION['fotos_perfiles'];?>" class="img-fluid rounded-circle mr-3" alt="user">
                              <div class="caption">
                                 <h6 class="mb-0 line-height"><?php echo $_SESSION['nombre_usuario'];?></h6>
                              </div>
                           </a>
                        </li>
                        <li>
                           <a href="../Feed/inicio" class="iq-waves-effect d-flex align-items-center">
                           <i class="ri-home-line"></i>
                           </a>
                        </li>
                        <li class="nav-item">
                           <a class="search-toggle iq-waves-effect" href="#"><i class="ri-group-line"></i>
                              <span class="bg-danger dots"></span>
                           </a>
                           <div class="iq-sub-dropdown iq-sub-dropdown-large">
                              <div class="iq-card shadow-none m-0">
                                 <div class="iq-card-body p-0 ">
                                    <div class="bg-primary p-3">
                                       <h5 class="mb-0 text-white">Solicitudes de Amigos<small class="badge  badge-light float-right pt-1"><?php echo NumeroSolicitudesAmistadRecibidas($conectarsistema15,$_SESSION['id_usuario']); ?></small></h5>
                                    </div>
                                    <!-- INICIO BANDERA -> SOLICITUDES DE AMIGOS -->
                                    <?php 
                                       while($filas=mysqli_fetch_array($consulta1)){
                                          if($filas['estado']==0){
                                             echo '
                                             <div class="iq-friend-request">
                                             <div class="iq-sub-card iq-sub-card-big d-flex align-items-center justify-content-between" >
                                                <div class="d-flex align-items-center">
                                                   <div class="">
                                                      <img class="avatar-40 rounded" src="../vista/images/fotosperfiles/'; echo $filas['fotoperfil']; echo'" alt="">
                                                   </div>
                                                   <div class="media-body ml-3">
                                                      <h6 class="mb-0 ">'; echo $filas['nombres']; echo ' '; echo $filas['apellidos'];  echo'</h6>
                                                   </div>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                   <a style="color: var( --iq-white);" id="aceptar-solicitudes" data-id="'; echo $filas['id']; echo'" class="mr-3 btn btn-primary rounded">Confirmar</a>
                                                   <a style="color: var( --iq-white);" id="rechazar-solicitudes" data-id="'; echo $filas['idsolicitudamistad']; echo'" class="mr-3 btn btn-secondary rounded">Rechazar</a>
                                                </div>
                                             </div>
                                          </div>
                                          ';
                                          }
                                       }
                                    ?>
                                    <!-- FIN BANDERA -> SOLICITUDES DE AMIGOS -->
                                 </div>
                              </div>
                              <div class="text-center">
                                <a href="../SolicitudesAmistad/<?php echo $_SESSION['usuario_unico']; ?>" class="mr-3 btn text-primary"><i class="las la-hand-point-right"></i> Ver todas las solicitudes de amistad</a>
                            </div>
                           </div>
                        </li>
                        <li class="nav-item">
                           <a href="#" class="search-toggle iq-waves-effect">
                              <div id="lottie-beil"></div>
                              <span class="bg-danger dots"></span>
                           </a>
                           <div class="iq-sub-dropdown">
                              <div class="iq-card shadow-none m-0">
                                 <div class="iq-card-body p-0 ">
                                    <div class="bg-primary p-3">
                                       <h5 class="mb-0 text-white">Notificaciones<small class="badge  badge-light float-right pt-1"><?php echo NumeroSolicitudesAmistadAceptadas($conectarsistema17,$_SESSION['id_usuario']); ?></small></h5>
                                    </div>
                                    <?php 
                                    // CONSULTA DE SOLICITUDES DE AMISTAD APROBADAS
                                       while($filas=mysqli_fetch_array($consulta2)){
                                          echo'
                                          <a href="#" class="iq-sub-card" >
                                          <div class="media align-items-center">
                                             <div class="">
                                                <img class="avatar-40 rounded" src="../vista/images/fotosperfiles/'; echo$filas['fotoperfil'];  echo'" alt="">
                                             </div>
                                             <div class="media-body ml-3">
                                                <h6 class="mb-0 ">Eres amigo de '; echo $filas['nombres']; echo' '; echo $filas['apellidos']; echo'</h6>
                                                <small class="float-right font-size-12">
                                                ';
                                                // OBTENER -> DIA / MES / HORAS Y MINUTOS SOLAMENTE
                                                $FechaCompleta = strtotime($filas['fecha_notificacion']); $ObtenerDia = date("d", $FechaCompleta);
                                                $ObtenerMes = date("m", $FechaCompleta);
                                                $ObtenerHoras = date("H:i", $FechaCompleta);
                                                $ObtenerMinutos = date("m", $FechaCompleta);
                                                echo $ObtenerDia; echo'/';echo $ObtenerMes; echo' | ';echo $ObtenerHoras;
                                                echo'
                                                </small>
                                             </div>
                                          </div>
                                       </a>
                                          ';
                                       }
                                    ?>
                                    <div class="text-center">
                                       <a href="../Notificaciones/<?php echo $_SESSION['usuario_unico']; ?>" class="mr-3 btn text-primary"><i class="ri-notification-3-fill"></i> Ver todas las notificaciones</a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </li>
                     <ul class="navbar-list">
                        <li>
                           <a href="#" class="search-toggle iq-waves-effect d-flex align-items-center">
                           <i class="ri-arrow-down-s-fill"></i>
                           </a>
                           <div class="iq-sub-dropdown iq-user-dropdown">
                              <div class="iq-card shadow-none m-0">
                                 <div class="iq-card-body p-0 ">
                                    <div class="bg-primary p-3 line-height">
                                       <h5 class="mb-0 text-white line-height">Hola, <?php echo $_SESSION['nombre_usuario'];?> <?php echo $_SESSION['apellido_usuario'];?></h5>
                                       <span class="text-white font-size-12">Secret&reg;</span>
                                    </div>
                                    <a href="../Perfil/<?php echo $_SESSION['usuario_unico'];?>" class="iq-sub-card iq-bg-primary-hover">
                                       <div class="media align-items-center">
                                          <div class="rounded iq-card-icon iq-bg-primary">
                                             <i class="ri-file-user-line"></i>
                                          </div>
                                          <div class="media-body ml-3">
                                             <h6 class="mb-0 ">Mi perfil</h6>
                                             <p class="mb-0 font-size-12">Ver mi informaci&oacute;n personal</p>
                                          </div>
                                       </div>
                                    </a>
                                    <a href="../EditarPerfil/<?php echo $_SESSION['usuario_unico'];?>" class="iq-sub-card iq-bg-warning-hover">
                                       <div class="media align-items-center">
                                          <div class="rounded iq-card-icon iq-bg-warning">
                                             <i class="ri-profile-line"></i>
                                          </div>
                                          <div class="media-body ml-3">
                                             <h6 class="mb-0 ">Editar Perfil</h6>
                                             <p class="mb-0 font-size-12">Modificar foto y detalles de mi perfil</p>
                                          </div>
                                       </div>
                                    </a>
                                    <div class="d-inline-block w-100 text-center p-3">
                                       <a class="bg-primary iq-sign-btn" href="../Salir/cerrarsesion" role="button">Cerrar Sesi&oacute;n<i class="ri-login-box-line ml-2"></i></a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </li>
                     </ul>
                  </div>
               </nav>
            </div>
         </div>
         <!-- TOP Nav Bar END -->
         <!-- Page Content  -->
         <div id="content-page" class="content-page">
            <div class="container">
               <div class="row">
               <div class="col-lg-8">
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
                                       <hr>
                                 </li>
                              </ul>
                           </div>
                           <div class="modal fade" id="post-modal" tabindex="-1" role="dialog" aria-labelledby="post-modalLabel" aria-hidden="true" style="display: none;">
                              <div class="modal-dialog" role="document">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <h5 class="modal-title" id="post-modalLabel">Crear nueva publicaci&oacute;n</h5>
                                       <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ri-close-fill"></i></button>
                                    </div>
                                    <div class="modal-body">
                                       <div class="d-flex align-items-center">
                                          <div class="user-img">
                                          <img src="../vista/images/fotosperfiles/<?php echo  $_SESSION['fotos_perfiles'];?>" alt="userimg" class="avatar-70 rounded-circle" style="margin-top: -17em;">
                                          </div>
                                          <form id="form" class="post-text ml-3 w-100" action="javascript:void();" novalidate method="POST" autocomplete="off" enctype="multipart/form-data">
                                             <textarea name="historiausuario" id="publicaciones_usuarios" class="form-control rounded" placeholder="<?php echo $_SESSION['nombre_usuario'] ?> ¿En qu&eacute; est&aacute;s pensando?" maxlength="150" onpaste="ContadorCaracteresMaximoPublicaciones();" onkeyup="ContadorCaracteresMaximoPublicaciones();"></textarea>
                                             <div id="respuesta_contador"></div>
                                             <p id="contador"></p><br>
                                             <p>Adjuntar foto ac&aacute;:</p>
                                             <input type="file" name="fotospublicaciones" id="input-file-max-fs" class="dropify" data-max-file-size="2M" data-max-width="1921" data-max-height="1081" data-min-height="900" accept="image/x-png,image/jpeg,image/jpg" />
                                             <hr>
                                             <button type="submit" id="enviar" class="btn btn-primary d-block w-100 mt-3">Publicar Historia</button>
                                          </form>
                                          </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <!-- BANDERA -> PUBLICACIONES -->
                                    <?php 
                                       while($filas=mysqli_fetch_array($consulta)){
                                       /*
                                          -> MOSTRAR UNICAMENTE PUBLICACIONES DE USUARIOS QUE SEAN AMIGOS
                                          O SEGUIDORES ACEPTADOS DEL USUARIO LOGUEADO... CASO CONTRARIO NO SE MUESTRA NADA
                                       */
                                          echo '<div class="iq-card" id="publicaciones_usuariosperfil">
                                          <div class="iq-card-body">
                                             <div class="post-item">
                                                <div class="user-post-data p-3">
                                                   <div class="d-flex flex-wrap">
                                                      <div class="media-support-user-img mr-3">
                                                      <a target="_blank" href="../Perfiles/'; echo $filas['usuario']; echo'=';echo $filas['idsolicitudamigo']; echo'"><img class="rounded-circle img-fluid profile-img-history" src="../vista/images/fotosperfiles/'; echo $filas['fotoperfil']; echo '" alt=""></a>
                                                      </div>
                                                      <div class="media-support-info mt-2">
                                                         <h5 class="mb-0 d-inline-block"><a target="_blank" href="../Perfiles/'; echo $filas['usuario']; echo'=';echo $filas['idsolicitudamigo'];  echo'">'; echo $filas['nombres']; echo " "; echo $filas['apellidos']; echo '</a></h5>
                                                         <p class="ml-1 mb-0 d-inline-block">public&oacute; una nueva historia</p>
                                                         <p class="mb-0 text-primary"><i class="ri-timer-flash-line"></i> <time class="timeago" datetime="'; echo $filas['fecha_publicacion']; echo'"></time></p>
                                                      </div>
                                                      <div class="iq-card-post-toolbar">
                                                         <div class="dropdown">';
                                                         if($filas['usuario']==$_SESSION['usuario_unico']){
                                                            // SOLAMENTE EL DUEÑO DE ESTE PERFIL TIENE HABILITADO ESTE MANTENIMIENTO
                                                            echo '
                                                            <span class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                                            <i class="ri-more-fill"></i></span>
                                                            <div class="dropdown-menu m-0 p-0">
                                                            <!-- BORRAR HISTORIA -->
                                                         <a class="dropdown-item p-3" id="eliminarhistorias" data-id="'.$filas['idpublicacion'].'">
                                                            <div class="d-flex align-items-top">
                                                               <div class="icon font-size-20"><i class="ri-delete-bin-7-line"></i></div>
                                                               <div class="data ml-2">
                                                                  <h6>Eliminar Historia</h6>
                                                                  <p class="mb-0">¡Cuidado! Est&aacute; acci&oacute;n no es reversible</p>
                                                               </div>
                                                            </div>
                                                         </a>
                                                         <!-- MAS OPCIONES Y MANTENIMIENTOS SON POSIBLES -->
                                                         </div>
                                                            ';
                                                         }echo '
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="user-post">
                                             <p>'; echo $filas['mensaje_publicacion']; echo '</p>
                                                <a href="javascript:void();"><img src="../vista/images/fotospublicaciones/'; echo $filas['foto_publicacion']; echo '" alt="post-image" class="img-fluid w-100" /></a>
                                             </div>
                                       <iframe class="coment-profile" src="../CargarDatosPublicacion/'; echo $filas['idpublicacion']; echo '"></iframe>
                                       </div>
                                    </div>
                                 </div>';
                                 }
                              ?>
                              </div>
                  <!-- FIN BANDERA -> PUBLICACIONES -->
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
    <script src="../vista/js/alerta-solicitudesaceptadas.js"></script>
    <script src="../vista/js/alerta-eliminarsolicitudamistad.js"></script>
    <script src="../vista/js/alerta_buscador.js"></script>
   </body>
</html>
<?php
/*SI UN USUARIO CON PERFIL INCOMPLETO INTENTA ACCEDER AL FEED DE LA APLICACION
SE LE BLOQUEA SU ACCESO Y DEBE OBLIGATORIAMENTE COMPLETAR SU PERFIL PARA PODER
ACCEDER A TODAS LAS FUNCIONES DE ESTA APLICACION*/
}else{header('location:../Controlador/cRegistroNuevosUsuarios.php?nuevoregistro=completarperfil');}
?>