<?php 
/*
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
*/
   // NO PERMITIR INGRESO SIN ENVIO DE PARAMETRO
   if(!isset($_GET['eventos_sociales'])){
      header('location:../AccesoDenegado=restringido');
     }
     // NO PERMITIR INGRESO SIN INICIAR SESION
     if(!isset($_SESSION['nombre_usuario'])){
        header('location:../AccesoDenegado=restringido');
     }
     // NO PERMITIR INGRESO SI PARAMETRO NO ES IGUAL AL INDICADO
     if($_GET['eventos_sociales']!="registrareventos"){
        header('location:../AccesoDenegado=restringido');
     }
    // INCLUIR ARCHIVO CONTADOR DE PUBLICACIONES 
    require('../modelo/mConteoPublicacionesPerfilPropietario.php');
?>
<?php
   // SOLAMENTE LOS USUARIOS CON PERFIL COMPLETO PODRAN CONSULTAR TODAS LAS PAGINAS
   // DE ESTA PLATAFORMA
   if($_SESSION['comprobar_perfil']==0){
?>
<!doctype html>
<html lang="ES-SV">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Secret - Registrar Eventos</title>
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
   <body class="sidebar-main-active right-column-fixed">
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
                  <li>
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
                     <li class="active">
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
                                       while($filas=mysqli_fetch_array($consulta)){
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
                                 <div class="text-center">
                                    <a href="../SolicitudesAmistad/<?php echo $_SESSION['usuario_unico']; ?>" class="mr-3 btn text-primary"><i class="las la-hand-point-right"></i> Ver todas las solicitudes de amistad</a>
                                 </div>
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
                                       while($filas=mysqli_fetch_array($consulta1)){
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
                                 </div>
                              </div>
                              <div class="text-center">
                                 <a href="../Notificaciones/<?php echo $_SESSION['usuario_unico']; ?>" class="mr-3 btn text-primary"><i class="ri-notification-3-fill"></i> Ver todas las notificaciones</a>
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
                  <div class="col-sm-12">
                     <div class="iq-card position-relative inner-page-bg bg-primary" style="height: 150px;">
                        <div class="inner-page-title">
                           <h3 class="text-white"><i class="ri-home-heart-line"></i> Secret - Eventos Sociales</h3>
                           <p class="text-white">Est&aacute;s a punto de registrar un evento social disponible para tu pa&iacute;s: <strong><?php echo $_SESSION['pais_usuarios']; ?></strong></p>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-12 col-lg-12">
                     <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title">Todos los campos son obligatorios</h4>
                           </div>
                        </div>
                        <div class="iq-card-body">
                           <div class="stepwizard mt-4">
                              <div class="stepwizard-row setup-panel">
                                 <div id="user" class="wizard-step active">
                                    <a href="#user-detail" class="active btn">
                                    <i class="ri-folder-add-line text-primary"></i><span>Evento</span>
                                    </a>
                                 </div>
                                 <div id="document" class="wizard-step">
                                    <a href="#document-detail" class="btn btn-default" >
                                    <i class="ri-calendar-event-line text-danger"></i><span>Horario</span>
                                    </a>
                                 </div>
                                 <div id="bank" class="wizard-step">
                                    <a href="#bank-detail" class="btn btn-default">
                                    <i class="ri-camera-fill text-success"></i><span>Foto</span>
                                    </a>
                                 </div>
                                 <div id="confirm" class="wizard-step">
                                    <a href="#cpnfirm-data" class="btn btn-default">
                                    <i class="ri-check-fill text-warning"></i><span>Finalizar Registro</span>
                                    </a>
                                 </div>
                              </div>
                           </div>
                           <form id="form" class="form mt-4 needs-validation" novalidate method="POST" autocomplete="off" enctype="multipart/form-data">
                              <div class="row setup-content" id="user-detail">
                                 <div class="col-sm-12">
                                    <div class="col-md-12 p-0">
                                       <h3 class="mb-4">Informaci&oacute;n General:</h3>
                                       <div class="row">
                                          <div class="form-group col-md-6">
                                             <label class="control-label">Nombre del Evento: *</label>
                                             <input id="nombre_evento" name="nombre_evento" maxlength="255" type="text" required="required" class="form-control" placeholder="Ingrese el nombre del evento..."  />
                                             <div class="invalid-tooltip">
                                                Nombre del evento requerido, complete este campo 
                                            </div>
                                            <div class="valid-tooltip">
                                                Campo completado con &eacute;xito
                                            </div>
                                          </div>
                                          <div class="form-group col-md-6">
                                             <label class="control-label">Peque&ntilde;a Descripci&oacute;n: *</label>
                                             <input maxlength="255" type="text" id="descripcion_evento" name="descripcion_evento"  class="form-control" required="required" placeholder="Ingrese una descripci&oacute;n del evento..." />
                                             <div class="invalid-tooltip">
                                                Descripci&oacute;n del evento requerido, complete este campo 
                                            </div>
                                            <div class="valid-tooltip">
                                                Campo completado con &eacute;xito
                                            </div>
                                          </div>
                                          <div class="col-md-6 form-group">
                                             <label for="uname" class="control-label">Usuario que registra evento: *</label>
                                             <input type="text" class="form-control" id="uname" readonly value="<?php echo $_SESSION['usuario_unico']; ?>">
                                          </div>
                                          <div class="col-md-6 form-group">
                                             <label for="emailid" class="control-label">Pa&iacute;s de Residencia: *</label>
                                             <input type="text" class="form-control" id="emailid" readonly value="<?php echo $_SESSION['pais_usuarios']; ?>">
                                          </div>
                                          <div class="col-md-12 mb-3 form-group">
                                             <label for="address" class="control-label">Direcci&oacute;n completa d&oacute;nde se realizar&aacute;: *</label>
                                             <textarea id="direccion_evento" name="direccion_evento" class="form-control" rows="2" maxlength="255" placeholder="Por favor ingrese la direcci&oacute;n exacta y detallada en d&oacute;nde se realizar&aacute; el evento." required="required"></textarea>
                                             <div class="invalid-tooltip">
                                                Direcci&oacute;n del evento requerido, complete este campo 
                                            </div>
                                            <div class="valid-tooltip">
                                                Campo completado con &eacute;xito
                                            </div>
                                          </div>
                                       </div>
                                       <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Siguiente</button>
                                    </div>
                                 </div>
                              </div>
                              <div class="row setup-content" id="document-detail">
                                 <div class="col-sm-12">
                                    <div class="col-md-12 p-0">
                                       <h3 class="mb-4">Informaci&oacute;n Horaria:</h3>
                                       <div class="row">
                                          <div class="col-md-6 form-group">
                                             <label for="fname" class="control-label">D&iacute;a / Hora de Inicio: *</label>
                                             <input type="datetime-local" min="<?php echo substr(date('c'), 0, 19); ?>" max="<?php echo date('Y') ?>-12-31" id="diainicio_evento" name="diainicio_evento" onkeydown="return false"  class="form-control" required="required">
                                             <div class="invalid-tooltip">
                                                Fecha de inicio del evento requerido, complete este campo 
                                            </div>
                                            <div class="valid-tooltip">
                                                Campo completado con &eacute;xito
                                            </div>
                                          </div>
                                          <div class="col-md-6 form-group">
                                             <label for="horafinal" class="control-label">D&iacute;a / Hora de Finalizaci&oacute;n: *</label>
                                             <input type="datetime-local" min="<?php echo substr(date('c'), 0, 19); ?>" max="<?php echo date('Y') ?>-12-31" id="diafin_evento" name="diafin_evento" class="form-control" onkeydown="return false"  required="required">
                                             <div class="invalid-tooltip">
                                                Fecha de finalizaci&oacute;n del evento requerido, complete este campo 
                                            </div>
                                            <div class="valid-tooltip">
                                                Campo completado con &eacute;xito
                                            </div>
                                          </div>
                                       </div>
                                       <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Siguiente</button>
                                    </div>
                                 </div>
                              </div>
                              <div class="row setup-content" id="bank-detail">
                                 <div class="col-sm-12">
                                    <div class="col-md-12 p-0">
                                       <h3 class="mb-4">Fotograf&iacute;a del Evento:</h3>
                                       <div class="row">
                                          <div class="col-md-12 form-group">
                                             <label for="panno" class="control-label">Adjunte una fotograf&iacute;a representativa al evento: *</label>
                                             <input type="file" id="foto_evento" name="foto_evento" id="input-file-max-fs" class="dropify" data-max-file-size="2M" data-max-width="1921" data-max-height="1081" data-min-height="301" accept="image/x-png,image/jpeg,image/jpg" required="required"  />
                                             <div class="invalid-tooltip">
                                                Fotograf&iacute;a del evento requerido, complete este campo 
                                            </div>
                                            <div class="valid-tooltip">
                                                Campo completado con &eacute;xito
                                            </div>
                                          </div>
                                       </div>
                                       <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Siguiente</button>
                                    </div>
                                 </div>
                              </div>
                              <div class="row setup-content" id="cpnfirm-data">
                                 <div class="col-sm-12">
                                    <div class="col-md-12 p-0">
                                    <div class="row justify-content-center">
                                        <div class="col-3"> 
                                          <img style="margin: 0 0 1rem 0;" src="../vista/images/page-img/img-success.png" class="fit-image" alt="img-success">
                                          </div>
                                            <h5 class="mb-4 text-left">¿<?php echo $_SESSION['nombre_usuario']; ?>, est&aacute;s seguro de registrar este evento? S&iacute; todo esta en orden y has completado todos los campos, haz clic en el bot&oacute;n para hacer efectiva tu petici&oacute;n y registrar el evento.</h5>
                                            <button type="submit" id="enviar" class="btn btn-primary nextBtn btn-lg pull-right">Registrar Nuevo Evento</button>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </form>
                        </div>
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
      <!-- Chart Custom JavaScript -->
      <script src="../vista/js/chart-custom.js"></script>
      <!-- Dropzone JavaScript -->
      <script src="../vista/dropzone/dist/dropzone.js"></script>
      <!-- Dropify JavaScript -->
      <script src="../vista/dropify/dist/js/dropify.min.js"></script>
      <!-- Form Flie Upload Data JavaScript -->
      <script src="../vista/js/form-file-upload-data.js"></script>
      <!-- Custom JavaScript -->
      <script src="../vista/js/custom.js"></script>
      <!-- Alerts -->
      <script src="../vista/js/alerta_registroeventos.js"></script>
      <script src="../vista/js/alerta-solicitudesaceptadas.js"></script>
      <script src="../vista/js/alerta-eliminarsolicitudamistad.js"></script>
   </body>
</html>
<?php
/*SI UN USUARIO CON PERFIL INCOMPLETO INTENTA ACCEDER AL FEED DE LA APLICACION
SE LE BLOQUEA SU ACCESO Y DEBE OBLIGATORIAMENTE COMPLETAR SU PERFIL PARA PODER
ACCEDER A TODAS LAS FUNCIONES DE ESTA APLICACION*/
}else{header('location:../Controlador/cRegistroNuevosUsuarios.php?nuevoregistro=completarperfil');}
?>