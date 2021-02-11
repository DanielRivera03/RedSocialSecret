<?php
   // NO PERMITIR INGRESO SIN ENVIO DE PARAMETRO
   if(!isset($_GET['nuevoregistro'])){
    header('location:../AccesoDenegado=restringido');
   }
   // NO PERMITIR INGRESO SIN INICIAR SESION
   if(!isset($_SESSION['nombre_usuario'])){
      header('location:../AccesoDenegado=restringido');
   }
   // NO PERMITIR INGRESO SI PARAMETRO NO ES IGUAL AL INDICADO
   if($_GET['nuevoregistro']!="editar-perfil"){
      header('location:../AccesoDenegado=restringido');
   }
   // NO PERMITIR EL INGRESO DE OTROS USUARIOS -> INFORMACION SENSIBLE
   if($_GET['usuario']!=$_SESSION['usuario_unico']){
      header('location:../AccesoDenegado=restringido');
   }
    // INCLUIR ARCHIVO CONTADOR DE PUBLICACIONES -> EXCLUSIVO PERFILES PROPIETARIOS
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
<!doctype html>
<html lang="ES-SV">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Secret - Editar Perfil</title>
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
                  <li>
                        <a href="../Feed/inicio" class="iq-waves-effect"><i class="las la-newspaper"></i><span>Inicio</span></a>
                     </li>
                     <li class="active">
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
                              <img src="../vista/images/fotosperfiles/<?php echo $_SESSION['fotos_perfiles'];?>" class="img-fluid rounded-circle mr-3 avatar-img" alt="user">
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
                  <div class="col-lg-12">
                     <div class="iq-card">
                        <div class="iq-card-body p-0">
                           <div class="iq-edit-list">
                              <ul class="iq-edit-profile d-flex nav nav-pills">
                                 <li class="col-md-6 p-0">
                                    <a class="nav-link active" data-toggle="pill" href="#informacion-personal">
                                    Informaci&oacute;n Personal
                                    </a>
                                 </li>
                                 <li class="col-md-6 p-0">
                                    <a class="nav-link" data-toggle="pill" href="#informaciondetalles-usuarios">
                                    Sobre M&iacute;
                                    </a>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-12">
                     <div class="iq-edit-list-data">
                        <div class="tab-content">
                           <div class="tab-pane fade active show" id="informacion-personal" role="tabpanel">
                              <div class="iq-card">
                                 <div class="iq-card-header d-flex justify-content-between">
                                    <div class="iq-header-title">
                                       <h4 class="card-title">Informaci&oacute;n Personal</h4>
                                    </div>
                                 </div>
                                 <div class="iq-card-body">
                                 <form id="form" class="mt-4 needs-validation" novalidate method="POST" autocomplete="off" enctype="multipart/form-data">
                                 <div class="alert text-white bg-danger" role="alert">
                                    <div class="iq-alert-icon">
                                       <i class="ri-information-line"></i>
                                    </div>
                                    <div class="iq-alert-text">Por favor tome nota: Estimado(a) <?php echo $_SESSION['nombre_usuario'] ?>, por motivos de seguridad, deber&aacute; cambiar obligatoriamente su contrase&ntilde;a luego de actualizar datos personales de su perfil. <strong>Sus detalles de usuario (sobre m&iacute;) no aplica para este aviso.</strong></div>
                                    </div><br>
                                       <div class="form-group row align-items-center">
                                          <div class="col-md-12">
                                             <div class="profile-img-edit avatar">
                                                <img class="profile-pic avatar-img" src="../vista/images/fotosperfiles/<?php echo $Usuarios->getFotoPerfilUsuario();?>" alt="Foto de perfil" data-toggle="tooltip" data-placement="right" title="Resoluci&oacute;n sugerida: 640x640 &Uacute;nicamente: .png / .jpg">
                                                <div class="p-image" data-toggle="tooltip" data-placement="bottom" title="Campo No Requerido">
                                                   <i class="ri-pencil-line upload-button"></i>
                                                   <input class="file-upload" type="file" name="fotoperfil" accept="image/x-png,image/jpeg"/>
                                                </div>
                                             </div>
                                             <!-- CAPTURAR FOTO WEBCAM -->
                                             <button style="width: 4.5%;" type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-camera"></i></button>
                                             <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                   <div class="modal-content">
                                                      <div class="modal-header">
                                                         <h5 class="modal-title" id="exampleModalCenterTitle">Tomar Foto</h5>
                                                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                         <span aria-hidden="true">&times;</span>
                                                         </button>
                                                      </div>
                                                      <div class="modal-body">
                                                      <select name="listaDeDispositivos" id="listaDeDispositivos" class="form-control"></select>
                                                      <a style="color: #fff; width:100%;" id="boton" class="btn btn-primary"><i class="fa fa-camera"></i> Tomar Foto</a>
                                                      <p id="estado"></p>
                                                      <video style="width: 100%; max-width: 100%; height: 100%; max-height: 255px;" muted="muted" id="video"></video>
	                                                   <canvas id="canvas" style="display: none;"></canvas>
                                                      </div>
                                                      <div class="modal-footer">
                                                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class=" row align-items-center">
                                          <div class="form-group col-sm-6">
                                             <label for="nombre">Nombre:</label>
                                             <input type="text" class="form-control" id="nombre" name="nombre_usuario" value="<?php echo $Usuarios->getNombreUsuario(); ?>" required>
                                             <div class="invalid-tooltip">
                                                Nombre es requerido, complete este campo
                                             </div>
                                             <div class="valid-tooltip">
                                                Campo completado con &eacute;xito
                                             </div>
                                          </div>
                                          <div class="form-group col-sm-6">
                                             <label for="apellido">Apellido:</label>
                                             <input type="text" class="form-control mb-0" id="apellido" name="apellido_usuario" value="<?php echo $Usuarios->getApellidoUsuario(); ?>" required>
                                             <div class="invalid-tooltip">
                                                Apellido es requerido, complete este campo
                                             </div>
                                             <div class="valid-tooltip">
                                                Campo completado con &eacute;xito
                                             </div>
                                          </div>
                                          <div class="form-group col-sm-6">
                                             <label for="nombre">Nueva Contrase&ntilde;a:</label>
                                             <input type="password" class="form-control" id="clavenueva" name="clave_usuario" placeholder="************" required>
                                             <div class="invalid-tooltip">
                                                Nueva Contrase&ntilde;a es requerida, complete este campo
                                             </div>
                                             <div class="valid-tooltip">
                                                Campo completado con &eacute;xito
                                             </div>
                                          </div>
                                          <div class="form-group col-sm-6">
                                             <label for="nombre">Repetir Contrase&ntilde;a:</label>
                                             <input type="password" class="form-control" id="claverepetida" placeholder="************" required>
                                             <div class="invalid-tooltip">
                                                Debe repetir su nueva contrase&ntilde;a
                                             </div>
                                             <div class="valid-tooltip">
                                                Campo completado con &eacute;xito
                                             </div>
                                          </div>
                                          <div class="form-group col-sm-6">
                                             <label for="usuariounico">Nombre de Usuario &Uacute;nico:</label>
                                             <input type="text" class="form-control" id="usuariounico" name="nombre_usuariounico" placeholder="<?php echo $Usuarios->getUsuarioUnico(); ?>" data-toggle="tooltip" data-placement="bottom" title="No puede cambiar su nombre de usuario" readonly required>
                                             <div class="invalid-tooltip">
                                                Nombre de usuario es requerido, complete este campo
                                             </div>
                                             <div class="valid-tooltip">
                                                Campo completado con &eacute;xito
                                             </div>
                                          </div>
                                          <div class="form-group col-sm-6">
                                             <label for="correo">Correo:</label>
                                             <input type="text" class="form-control" id="correo" name="correo_usuario" value="<?php echo $Usuarios->getCorreoUsuario(); ?>" data-toggle="tooltip" data-placement="bottom" title="No puede cambiar su correo electr&oacute;nico" readonly required>
                                             <div class="invalid-tooltip">
                                                Correo es requerido, complete este campo
                                             </div>
                                             <div class="valid-tooltip">
                                                Campo completado con &eacute;xito
                                             </div>
                                          </div>
                                          <div class="form-group col-sm-6">
                                             <label class="d-block">G&eacute;nero:</label>
                                                 <?php
                                                    if($Usuarios->getGeneroUsuario()=="m"){
                                                        echo '
                                                        <!-- HOMBRE -->
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" id="customRadio6" name="genero_usuarios" class="custom-control-input" checked="" value="m">
                                                        <label class="custom-control-label" for="customRadio6"> Hombre </label>
                                                    </div>
                                                    <!-- MUJER -->
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                                <input type="radio" id="customRadio7" name="genero_usuarios" class="custom-control-input" value="f">
                                                                <label class="custom-control-label" for="customRadio7"> Mujer </label>
                                                            </div>
                                                    <!-- INDEFINIDO -->
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="customRadio8" name="genero_usuarios" class="custom-control-input" value="i">
                                                        <label class="custom-control-label" for="customRadio8"> Prefiero no decirlo </label>
                                                    </div>
                                                        ';   
                                                    }else if($Usuarios->getGeneroUsuario()=="f"){
                                                        echo '
                                                        <!-- HOMBRE -->
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" id="customRadio6" name="genero_usuarios" class="custom-control-input" value="m">
                                                        <label class="custom-control-label" for="customRadio6"> Hombre </label>
                                                    </div>
                                                    <!-- MUJER -->
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                                <input type="radio" id="customRadio7" name="genero_usuarios" class="custom-control-input" checked="" value="f">
                                                                <label class="custom-control-label" for="customRadio7"> Mujer </label>
                                                            </div>
                                                    <!-- INDEFINIDO -->
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="customRadio8" name="genero_usuarios" class="custom-control-input" value="i">
                                                        <label class="custom-control-label" for="customRadio8"> Prefiero no decirlo </label>
                                                    </div>
                                                        ';
                                                    }else if($Usuarios->getGeneroUsuario()=="i"){
                                                        echo '
                                                        <!-- HOMBRE -->
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" id="customRadio6" name="genero_usuarios" class="custom-control-input" value="m">
                                                        <label class="custom-control-label" for="customRadio6"> Hombre </label>
                                                    </div>
                                                    <!-- MUJER -->
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                                <input type="radio" id="customRadio7" name="genero_usuarios" class="custom-control-input" value="f">
                                                                <label class="custom-control-label" for="customRadio7"> Mujer </label>
                                                            </div>
                                                    <!-- INDEFINIDO -->
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="customRadio8" name="genero_usuarios" class="custom-control-input" checked="" value="i">
                                                        <label class="custom-control-label" for="customRadio8"> Prefiero no decirlo </label>
                                                    </div>
                                                        ';
                                                    }
                                                 ?>
                                          </div>
                                          <div class="form-group col-sm-6">
                                             <label>Pa&iacute;s:</label>
                                             <select class="form-control" id="pais" name="pais_residenciausuario" required>
                                                <option value="<?php echo $Usuarios->getPaisUsuario();?>" selected><?php echo $Usuarios->getPaisUsuario(); ?></option>
                                                <option value="Afganistan">Afganist&aacute;n</option>
                                                <option value="Albania">Albania</option>
                                                <option value="Alemania">Alemania</option>
                                                <option value="Andorra">Andorra</option>
                                                <option value="Angola">Angola</option>
                                                <option value="Antigua y Barbuda">Antigua y Barbuda</option>
                                                <option value="Arabia Saudita">Arabia Saudita</option>
                                                <option value="Argelia">Argelia</option>
                                                <option value="Argentina">Argentina</option>
                                                <option value="Armenia">Armenia</option>
                                                <option value="Australia">Australia</option>
                                                <option value="Austria">Austria</option>
                                                <option value="Azerbaiyan">Azerbaiy&aacute;n</option>
                                                <option value="Bahamas">Bahamas</option>
                                                <option value="Bahrein">Bahrein</option>
                                                <option value="Bangladesh">Bangladesh</option>
                                                <option value="Barbados">Barbados</option>
                                                <option value="Belarus">Belar&uacute;s</option>
                                                <option value="Belice">Belice</option>
                                                <option value="Benin">Benin</option>
                                                <option value="Bhutan">Bhut&aacute;n</option>
                                                <option value="Bolivia">Bolivia</option>
                                                <option value="Bosnia y Herzegovina">Bosnia y Herzegovina</option>
                                                <option value="Botswana">Botswana</option>
                                                <option value="Brasil">Brasil</option>
                                                <option value="Brunei Darussalam">Brunei Darussalam</option>
                                                <option value="Bulgaria">Bulgaria</option>
                                                <option value="Burkina Faso">Burkina Faso</option>
                                                <option value="Burundi">Burundi</option>
                                                <option value="Belgica">B&eacute;lgica</option>
                                                <option value="Cabo Verde">Cabo Verde</option>
                                                <option value="Camboya">Camboya</option>
                                                <option value="Camerun">Camer&uacute;n</option>
                                                <option value="Canada">Canad&aacute;</option>
                                                <option value="Chad">Chad</option>
                                                <option value="Chequia">Chequia</option>
                                                <option value="Chile">Chile</option>
                                                <option value="China">China</option>
                                                <option value="Chipre">Chipre</option>
                                                <option value="Colombia">Colombia</option>
                                                <option value="Comoras">Comoras</option>
                                                <option value="Congo">Congo</option>
                                                <option value="Costa Rica">Costa Rica</option>
                                                <option value="Croacia">Croacia</option>
                                                <option value="Cuba">Cuba</option>
                                                <option value="Côte d'Ivoire">Côte d'Ivoire</option>
                                                <option value="Dinamarca">Dinamarca</option>
                                                <option value="Djibouti">Djibouti</option>
                                                <option value="Dominica">Dominica</option>
                                                <option value="Ecuador">Ecuador</option>
                                                <option value="Egipto">Egipto</option>
                                                <option value="El Salvador">El Salvador</option>
                                                <option value="Emiratos Arabes Unidos">Emiratos &Aacute;rabes Unidos</option>
                                                <option value="Eritrea">Eritrea</option>
                                                <option value="Eslovaquia">Eslovaquia</option>
                                                <option value="Eslovenia">Eslovenia</option>
                                                <option value="Espa&ntilde;a">Espa&ntilde;a</option>
                                                <option value="Estados Unidos de America">Estados Unidos de Am&eacute;rica</option>
                                                <option value="Estonia">Estonia</option>
                                                <option value="Eswatini">Eswatini</option>
                                                <option value="Etiopia">Etiop&iacute;a</option>
                                                <option value="Federacion de Rusia">Federaci&oacute;n de Rusia</option>
                                                <option value="Fiji">Fiji</option>
                                                <option value="Filipinas">Filipinas</option>
                                                <option value="Finlandia">Finlandia</option>
                                                <option value="Francia">Francia</option>
                                                <option value="Gabon">Gab&oacute;n</option>
                                                <option value="Gambia">Gambia</option>
                                                <option value="Georgia">Georgia</option>
                                                <option value="Ghana">Ghana</option>
                                                <option value="Granada">Granada</option>
                                                <option value="Grecia">Grecia</option>
                                                <option value="Guatemala">Guatemala</option>
                                                <option value="Guinea">Guinea</option>
                                                <option value="Guinea Ecuatorial">Guinea Ecuatorial</option>
                                                <option value="Guinea-Bissau">Guinea-Bissau</option>
                                                <option value="Guyana">Guyana</option>
                                                <option value="Haiti">Hait&iacute;</option>
                                                <option value="Honduras">Honduras</option>
                                                <option value="Hungria">Hungr&iacute;a</option>
                                                <option value="India">India</option>
                                                <option value="Indonesia">Indonesia</option>
                                                <option value="Iraq">Iraq</option>
                                                <option value="Irlanda">Irlanda</option>
                                                <option value="Iran">Ir&aacute;n</option>
                                                <option value="Islandia">Islandia</option>
                                                <option value="Islas Cook">Islas Cook</option>
                                                <option value="Islas Feroe">Islas Feroe</option>
                                                <option value="Islas Marshall">Islas Marshall</option>
                                                <option value="Islas Salomon">Islas Salom&oacute;n</option>
                                                <option value="Israel">Israel</option>
                                                <option value="Italia">Italia</option>
                                                <option value="Jamaica">Jamaica</option>
                                                <option value="Japon">Jap&oacute;n</option>
                                                <option value="Jordania">Jordania</option>
                                                <option value="Kazajstan">Kazajst&aacute;n</option>
                                                <option value="Kenya">Kenya</option>
                                                <option value="Kirguistan">Kirguist&aacute;n</option>
                                                <option value="Kiribati">Kiribati</option>
                                                <option value="Kuwait">Kuwait</option>
                                                <option value="Lesotho">Lesotho</option>
                                                <option value="Letonia">Letonia</option>
                                                <option value="Liberia">Liberia</option>
                                                <option value="Libia">Libia</option>
                                                <option value="Lituania">Lituania</option>
                                                <option value="Luxemburgo">Luxemburgo</option>
                                                <option value="Líbano">L&iacute;bano</option>
                                                <option value="Macedonia del Norte">Macedonia del Norte</option>
                                                <option value="Madagascar">Madagascar</option>
                                                <option value="Malasia">Malasia</option>
                                                <option value="Malawi">Malawi</option>
                                                <option value="Maldivas">Maldivas</option>
                                                <option value="Malta">Malta</option>
                                                <option value="Malí">Mal&iacute;</option>
                                                <option value="Marruecos">Marruecos</option>
                                                <option value="Mauricio">Mauricio</option>
                                                <option value="Mauritania">Mauritania</option>
                                                <option value="Micronesia">Micronesia</option>
                                                <option value="Mongolia">Mongolia</option>
                                                <option value="Montenegro">Montenegro</option>
                                                <option value="Mozambique">Mozambique</option>
                                                <option value="Myanmar">Myanmar</option>
                                                <option value="Mexico">M&eacute;xico</option>
                                                <option value="Mónaco">M&oacute;naco</option>
                                                <option value="Namibia">Namibia</option>
                                                <option value="Nauru">Nauru</option>
                                                <option value="Nepal">Nepal</option>
                                                <option value="Nicaragua">Nicaragua</option>
                                                <option value="Nigeria">Nigeria</option>
                                                <option value="Niue">Niue</option>
                                                <option value="Noruega">Noruega</option>
                                                <option value="Nueva Zelandia">Nueva Zelandia</option>
                                                <option value="Níger">N&iacute;ger</option>
                                                <option value="Omán">Om&aacute;n</option>
                                                <option value="Pakistán">Pakist&aacute;n</option>
                                                <option value="Palau">Palau</option>
                                                <option value="Panamá">Panam&aacute;</option>
                                                <option value="Papua Nueva Guinea">Papua Nueva Guinea</option>
                                                <option value="Paraguay">Paraguay</option>
                                                <option value="Países Bajos">Pa&iacute;ses Bajos</option>
                                                <option value="Perú">Per&uacute;</option>
                                                <option value="Polonia">Polonia</option>
                                                <option value="Portugal">Portugal</option>
                                                <option value="Qatar">Qatar</option>
                                                <option value="Reino Unido">Reino Unido</option>
                                                <option value="República Centroafricana">Rep&uacute;blica Centroafricana</option>
                                                <option value="República Democrática Popular Lao">Rep&uacute;blica Democr&aacute;tica Popular Lao</option>
                                                <option value="Rep&uacute;blica Democr&aacute;tica del Congo">República Democrática del Congo</option>
                                                <option value="República Unida de Tanzanía">Rep&uacute;blica Unida de Tanzan&iacute;a</option>
                                                <option value="Singapur">Singapur</option>
                                                <option value="Sudáfrica">Sud&aacute;frica</option>
                                                <option value="Suecia">Suecia</option>
                                                <option value="Trinidad y Tabago">Trinidad y Tabago</option>
                                                <option value="Uruguay">Uruguay</option>
                                                <option value="Venezuela">Venezuela</option>
                                             </select>
                                             <div class="invalid-tooltip">
                                                Pa&iacute;s es requerido, complete este campo
                                             </div>
                                             <div class="valid-tooltip">
                                                Campo completado con &eacute;xito
                                             </div>
                                          </div>
                                          <div class="form-group col-sm-6">
                                             <label for="ciudad">Ciudad:</label>
                                             <input type="text" class="form-control" id="ciudad" name="ciudad_residenciausuario" value="<?php echo $Usuarios->getCiudadUsuario();?>" required>
                                             <div class="invalid-tooltip">
                                                Ciudad es requerido, complete este campo
                                             </div>
                                             <div class="valid-tooltip">
                                                Campo completado con &eacute;xito
                                             </div>
                                          </div>
                                          <div class="form-group col-sm-6">
                                             <label for="telefono">Tel&eacute;fono:</label>
                                             <input type="tel" class="form-control" id="telefono" name="telefono_usuario" value="<?php echo $Usuarios->getTelefonoUsuario();?>" required>
                                             <div class="invalid-tooltip">
                                                Tel&eacute;fono es requerido, complete este campo
                                             </div>
                                             <div class="valid-tooltip">
                                                Campo completado con &eacute;xito
                                             </div>
                                          </div>
                                          <div class="form-group col-sm-6">
                                             <label class="d-block">Privacidad de perfil:</label>
                                             <select class="form-control" id="privacidad" name="privacidad_perfilusuario" required>
                                                 <?php 
                                                    if($Usuarios->getPrivacidadUsuario()=="1"){
                                                        echo '
                                                        <option value="0">Perfil p&uacute;blico</option>
                                                        <option value="1" selected>Perfil privado</option>
                                                        ';
                                                    }else if($Usuarios->getPrivacidadUsuario()=="0"){
                                                        echo '
                                                        <option value="0" selected>Perfil p&uacute;blico</option>
                                                        <option value="1">Perfil privado</option>
                                                        ';
                                                    }
                                                 ?>
                                             </select>
                                             <div class="invalid-tooltip">
                                                Privacidad de perfil es requerido, complete este campo
                                             </div>
                                             <div class="valid-tooltip">
                                                Campo completado con &eacute;xito
                                             </div>
                                          </div>
                                          <div class="form-group col-sm-6">
                                          <label for="telefono">Fecha de Nacimiento:</label>
                                          <div class="custom-control custom-checkbox d-inline-block mt-2 pt-1">
                                          <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" min="1940-01-01" max="<?php $CalculoEdad = date('Y') - 18; echo $CalculoEdad; ?>-12-31" onkeydown="return false" value="<?php echo $Usuarios->getFechaNacimientoUsuario(); ?>" required>
                                        <div class="invalid-tooltip">
                                            Fecha de Nacimiento requerido, complete este campo 
                                       </div>
                                       <div class="valid-tooltip">
                                          Campo completado con &eacute;xito
                                       </div>
                                    </div>
                                    </div>
                                     <div class="form-group col-sm-12">
                                             <label class="d-block">Cambiar Foto de Portada:</label>
                                             <input type="file" name="fotosportadas" id="input-file-max-fs" class="dropify" data-max-file-size="2M" data-max-width="1921" data-min-width="1900" data-max-height="1081" data-min-height="301" accept="image/x-png,image/jpeg,image/jpg" data-toggle="tooltip" data-placement="bottom" title="Resoluci&oacute;n sugerida: 1920x1080 (Este Campo No Es Requerido)" />
                                          </div>
                                       </div>
                                       <button type="submit" id="enviar" class="btn btn-primary mr-2">Enviar Datos</button>
                                    </form>
                                    <br><hr>
                                    <!-- ALERTA ELIMINAR PERFIL DE USUARIO -->
                                    <div class="iq-header-title">
                                       <h4 class="card-title">&Aacute;rea de Peligro (Eliminar Cuenta Definitivamente)</h4>
                                    </div>
                                    <div class="alert bg-white alert-danger" role="alert">
                                       <div class="iq-alert-icon">
                                          <i class="ri-alert-line"></i>
                                    </div>
                                    <div class="iq-alert-text">Estimado(a) <?php echo $_SESSION['nombre_usuario']; echo" "; echo $_SESSION['apellido_usuario'];?>, estas por iniciar el proceso de eliminaci&oacute;n de cuentas definitivo, por favor tome en cuenta los siguientes aspectos:
                                    <ul style="list-style: none !important;">
                                       <li><strong>1.</strong> Al momento de finalizar el proceso, usted perder&aacute; para siempre el acceso a nuestra plataforma. (ver literal 4)</li>
                                       <li><strong>2.</strong> Le garantizamos la disponibilidad total de su usuario &uacute;nico siempre y cuando se encuentre disponible, ya que el proceso es autom&aacute;tico y puede volver a registrarse cuando usted quiera y volver a utilizar su usuario &uacute;nico <strong>seg&uacute;n la disponibilidad del mismo.</strong></li>
                                       <li><strong>3.</strong> Nos reservamos el derecho de reservar su usuario &uacute;nico. Al momento de darse de baja el mismo queda disponible, con la posibilidad que otro usuario haga uso del mismo.</li>
                                       <li><strong>4.</strong> Si bien, usted pierde para siempre su acceso mientras no realice una nueva acci&oacute;n de registro, usted est&aacute; en toda su libertad de crear una nueva cuenta. Tomando en cuenta el literal 2 y 3.</li>
                                       <li><strong>5.</strong> Usted acepta plenamente el resguardo de su informaci&oacute;n personal en nuestra base de datos. Punto que usted acepto con total concentimiento al registrarse en esta plataforma.</li>
                                       <li><strong>6.</strong> Al momento de darse de baja, toda su informaci&oacute;n ya no podr&aacute; ser vista por los dem&aacute;s usuarios de esta plataforma.</li>
                                       <li><strong>7.</strong> No contamos con un mec&aacute;nismo de copia de seguridad de su informaci&oacute;n luego de darse de baja. Por lo cual nos reservamos el derecho de la recuperaci&oacute;n de su informaci&oacute;n y usted es consciente que al momento de finalizar el proceso. Toda su informaci&oacute;n (Publicaciones, Fotos) se elimina para siempre. <strong>Exceptuando la informaci&oacute;n que se detalla en nuestros "T&eacute;rminos y Condiciones de Uso"</strong>.</li>
                                    </ul>
                                    </div>
                                 </div>
                                 <button style="width:100%;" type="submit" id="eliminarcuentausuarios" data-id="<?php echo $_SESSION['usuario_unico'] ?>" class="btn btn-primary mr-2"><i class="fa fa-frown-o"></i> Eliminar Cuenta Definitivamente</i></button>
                                 </div>
                              </div>
                           </div>
                           <div class="tab-pane fade" id="informaciondetalles-usuarios" role="tabpanel">
                              <div class="iq-card">
                                 <div class="iq-card-header d-flex justify-content-between">
                                    <div class="iq-header-title">
                                       <h4 class="card-title">Detalles Sobre M&iacute;</h4>
                                    </div>
                                 </div>
                                 <div class="iq-card-body">
                                    <?php if($Usuarios->getComprobacionPerfil()=="0"){ // USUARIOS ANTIGUOS ?>
                                          <form id="detallesusuarios_modificar" class="mt-4 needs-validation" novalidate method="POST" autocomplete="off" enctype="multipart/form-data">
                                             <div class="alert bg-white alert-info" role="alert">
                                                <div class="iq-alert-icon">
                                                <i class="ri-information-line"></i>
                                             </div>
                                             <div class="iq-alert-text">Estimado(a) <?php echo $_SESSION['nombre_usuario']; ?> le recordamos que esta secci&oacute;n es opcional, usted decide si completarla o no. <strong>Le sugerimos que en los campos donde usted ingrese m&aacute;s de un detalle, lo separe por comas " , "</strong> esto con el fin de mostrar su informaci&oacute;n en su perfil de usuario de la manera m&aacute;s ordenada posible.</div>
                                          </div>       
                                          <div class="alert alert-success" role="alert">
                                             <div class="iq-alert-text">
                                                <h5 class="alert-heading">¡Enhorabuena! &#128521;</h5>
                                                <p><strong>Estado de visualizaci&oacute;n de su perfil: Ha completado con &eacute;xito con lo requerido. Todos los usuarios pueden ver su perfil.</strong>
                                                </p>
                                             </div>
                                       </div><br><br>
                                                <div class=" row align-items-center">
                                                   <div class="form-group col-sm-6">
                                                      <label for="religion">Religi&oacute;n (religiones) que usted pr&aacute;ctica:</label>
                                                      <input type="text" class="form-control" id="religion" name="religion_detalleusuario" maxlength="255" placeholder="Ingrese su religi&oacute;n..." value="<?php echo $Usuarios->getReligionUsuario(); ?>">
                                                      <div class="valid-tooltip">
                                                         Campo completado con &eacute;xito
                                                      </div>
                                                   </div>
                                                   <div class="form-group col-sm-6">
                                                      <label for="profesion">Profesi&oacute;n:</label>
                                                      <input type="text" class="form-control" id="profesion" name="profesion_detalleusuario" placeholder="Ingrese su profesi&oacute;n"  maxlength="255" value="<?php echo $Usuarios->getEmpleoUsuario(); ?>">
                                                      <div class="valid-tooltip">
                                                         Campo completado con &eacute;xito
                                                      </div>
                                                      </div>
                                                      <div class="form-group col-sm-6">
                                                      <label for="educacioninicial">Educaci&oacute;n Inicial (Primaria, Secundaria):</label>
                                                      <input type="text" class="form-control" id="educacioninicial" name="escuela_detalleusuario" maxlength="255" placeholder="Ingrese su educaci&oacute;n inicial..." value="<?php echo $Usuarios->getEscuelaUsuario(); ?>">
                                                      <div class="valid-tooltip">
                                                         Campo completado con &eacute;xito
                                                      </div>
                                                      </div>
                                                      <div class="form-group col-sm-6">
                                                      <label for="educacionsuperior">Educaci&oacute;n Superior (Universidad):</label>
                                                      <input type="text" class="form-control" id="educacionsuperior" name="universidad_detalleusuario" maxlength="255" placeholder="Ingrese su educaci&oacute;n superior..." value="<?php echo $Usuarios->getUniversidadUsuario(); ?>">
                                                      <div class="valid-tooltip">
                                                         Campo completado con &eacute;xito
                                                      </div>
                                                      </div>
                                                      <div class="form-group col-sm-6">
                                                      <label for="deportes">Deportes:</label>
                                                      <input type="text" class="form-control" id="deportes" name="deportes_detalleusuario" maxlength="255" placeholder="Ingrese sus deportes..." value="<?php echo $Usuarios->getDeportesUsuario(); ?>">
                                                      <div class="valid-tooltip">
                                                         Campo completado con &eacute;xito
                                                      </div>
                                                      </div>
                                                      <div class="form-group col-sm-6">
                                                      <label for="intereses">Intereses Sentimentales:</label>
                                                      <input type="text" class="form-control" id="intereses" name="intereses_detalleusuario" maxlength="255" placeholder="Ingrese sus intereses sentimentales..." value="<?php echo $Usuarios->getInteresesUsuario(); ?>">
                                                      <div class="valid-tooltip">
                                                         Campo completado con &eacute;xito
                                                      </div>
                                                      </div>
                                                      <div class="form-group col-sm-6">
                                                      <label for="generosmusicales">G&eacute;neros Musicales:</label>
                                                      <input type="text" class="form-control" id="generosmusicales" name="generosmusicales_detalleusuario" maxlength="255" placeholder="Ingrese sus g&eacute;neros m&uacute;sicales..." value="<?php echo $Usuarios->getGenerosMusicalesUsuario(); ?>">
                                                      <div class="valid-tooltip">
                                                         Campo completado con &eacute;xito
                                                      </div>
                                                      </div>
                                                      <div class="form-group col-sm-6">
                                                      <label for="situacionsentimental">Situaci&oacute;n Sentimental Actual:</label>
                                                      <input type="text" class="form-control" id="situacionsentimental" name="situacionsentimental_detalleusuario" maxlength="255" placeholder="Ingrese su situaci&oacute;n sentimental actual..."  value="<?php echo $Usuarios->getSituacionSentimentalUsuario(); ?>">
                                                      <div class="valid-tooltip">
                                                         Campo completado con &eacute;xito
                                                      </div>
                                                      </div>
                                                      <div class="form-group col-sm-12">
                                                      <label for="sobremi">Descripci&oacute;n Corta Sobre M&iacute;: <span style="color: #F00;">(*)</span></label>
                                                      <textarea id="sobremi" row="3" class="form-control" name="sobremi_detalleusuario" maxlength="100" data-toggle="tooltip" data-placement="bottom" title="Este campo es requerido" placeholder="Ingrese una descripci&oacute;n corta sobre usted..." required><?php echo $Usuarios->getSobreMiUsuario(); ?></textarea>
                                                      <div class="invalid-tooltip">
                                                         Campo requerido,  por favor compl&eacute;telo
                                                      </div>
                                                      <div class="valid-tooltip">
                                                         Campo completado con &eacute;xito
                                                      </div>
                                                      </div>
                                                   </div>
                                                <button type="submit" id="enviardetalles" class="btn btn-primary mr-2">Enviar Datos</button>
                                       <?php }else{ // USUARIOS NUEVOS ?>
                                       <form id="detallesusuarios" class="mt-4 needs-validation" novalidate method="POST" autocomplete="off" enctype="multipart/form-data">
                                          <div class="alert bg-white alert-info" role="alert">
                                             <div class="iq-alert-icon">
                                             <i class="ri-information-line"></i>
                                          </div>
                                          <div class="iq-alert-text">Estimado(a) <?php echo $_SESSION['nombre_usuario'];?> le recordamos que esta secci&oacute;n es opcional, usted decide si completarla o no. S&iacute; decide completarla, el &uacute;nico campo requerido es sobre una peque&ntilde;a descripci&oacute;n corta subre usted. <strong>Le sugerimos que en los campos donde usted ingrese m&aacute;s de un detalle, lo separe por comas " , "</strong> esto con el fin de mostrar su informaci&oacute;n en su perfil de usuario de la manera m&aacute;s ordenada posible. <strong>Hemos detectado que usted es un usuario nuevo; al completar los campos que usted considere necesarios, por su seguridad deber&aacute; iniciar sesi&oacute;n nuevamente. Lo anterior aplica &uacute;nicamente a los usuario nuevos.</strong></div>
                                       </div>
                                       <div class="alert bg-white alert-danger" role="alert">
                                             <div class="iq-alert-icon">
                                             <i class="ri-information-line"></i>
                                          </div>
                                          <div class="iq-alert-text"><strong>Estado Visualizaci&oacute;n Perfil: Ning&uacute;n usuario puede visualizar su perfil</strong>. Si por alguna raz&oacute;n usted decide no completar esta secci&oacute;n. Le informamos que lamentablemente ning&uacute;n usuario podr&aacute; visualizar su perfil hasta que usted ingrese por lo menos una peque&ntilde;a descripci&oacute;n sobre usted.</div>
                                       </div><br><br>
                                             <div class=" row align-items-center">
                                                <div class="form-group col-sm-6">
                                                   <label for="religion">Religi&oacute;n (religiones) que usted pr&aacute;ctica:</label>
                                                   <input type="text" class="form-control" id="religion" name="religion_detalleusuario" maxlength="255" placeholder="Ingrese su religi&oacute;n..." value="">
                                                   <div class="valid-tooltip">
                                                      Campo completado con &eacute;xito
                                                   </div>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                   <label for="profesion">Profesi&oacute;n:</label>
                                                   <input type="text" class="form-control" id="profesion" name="profesion_detalleusuario" maxlength="255" placeholder="Ingrese su profesi&oacute;n..." value="">
                                                   <div class="valid-tooltip">
                                                      Campo completado con &eacute;xito
                                                   </div>
                                                   </div>
                                                   <div class="form-group col-sm-6">
                                                   <label for="educacioninicial">Educaci&oacute;n Inicial (Primaria, Secundaria):</label>
                                                   <input type="text" class="form-control" id="educacioninicial" name="escuela_detalleusuario" maxlength="255" placeholder="Ingrese su educaci&oacute;n inicial..." value="">
                                                   <div class="valid-tooltip">
                                                      Campo completado con &eacute;xito
                                                   </div>
                                                   </div>
                                                   <div class="form-group col-sm-6">
                                                   <label for="educacionsuperior">Educaci&oacute;n Superior (Universidad):</label>
                                                   <input type="text" class="form-control" id="educacionsuperior" name="universidad_detalleusuario" maxlength="255" placeholder="Ingrese su educaci&oacute;n superior..." value="">
                                                   <div class="valid-tooltip">
                                                      Campo completado con &eacute;xito
                                                   </div>
                                                   </div>
                                                   <div class="form-group col-sm-6">
                                                   <label for="deportes">Deportes:</label>
                                                   <input type="text" class="form-control" id="deportes" name="deportes_detalleusuario" maxlength="255" placeholder="Ingrese sus deportes..." value="">
                                                   <div class="valid-tooltip">
                                                      Campo completado con &eacute;xito
                                                   </div>
                                                   </div>
                                                   <div class="form-group col-sm-6">
                                                   <label for="intereses">Intereses Sentimentales:</label>
                                                   <input type="text" class="form-control" id="intereses" name="intereses_detalleusuario" maxlength="255" placeholder="Ingrese sus intereses sentimentales..." value="">
                                                   <div class="valid-tooltip">
                                                      Campo completado con &eacute;xito
                                                   </div>
                                                   </div>
                                                   <div class="form-group col-sm-6">
                                                   <label for="generosmusicales">G&eacute;neros Musicales:</label>
                                                   <input type="text" class="form-control" id="generosmusicales" name="generosmusicales_detalleusuario" maxlength="255" placeholder="Ingrese sus g&eacute;neros m&uacute;sicales..." value="">
                                                   <div class="valid-tooltip">
                                                      Campo completado con &eacute;xito
                                                   </div>
                                                   </div>
                                                   <div class="form-group col-sm-6">
                                                   <label for="situacionsentimental">Situaci&oacute;n Sentimental Actual:</label>
                                                   <input type="text" class="form-control" id="situacionsentimental" name="situacionsentimental_detalleusuario" maxlength="255" placeholder="Ingrese su situaci&oacute;n sentimental actual..."  value="">
                                                   <div class="valid-tooltip">
                                                      Campo completado con &eacute;xito
                                                   </div>
                                                   </div>
                                                   <div class="form-group col-sm-12">
                                                   <label for="sobremi">Descripci&oacute;n Corta Sobre M&iacute;: <span style="color: #F00;">(*)</span></label>
                                                   <textarea id="sobremi" row="3" class="form-control" name="sobremi_detalleusuario" maxlength="100" data-toggle="tooltip" data-placement="bottom" title="Este campo es requerido" value="" required></textarea>
                                                   <div class="invalid-tooltip">
                                                      Campo requerido,  por favor compl&eacute;telo
                                                   </div>
                                                   <div class="valid-tooltip">
                                                      Campo completado con &eacute;xito
                                                   </div>
                                                   </div>
                                                </div>
                                             <button type="submit" id="enviardetalles" class="btn btn-primary mr-2">Enviar Datos</button>
                                          <?php } ?>
                                    </form>
                                 </div>
                              </div>
                           </div>
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
    <script src="../vista/js/tomar-fotos.js"></script>
    <!-- Alerts -->
    <script src="../vista/js/alerta-editarperfil.js"></script>
    <script src="../vista/js/alerta-detallesusuarios.js"></script>
    <script src="../vista/js/alerta-detallesusuariosmodificar.js"></script>
    <script src="../vista/js/alerta-eliminarusuariosregistrados.js"></script>
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