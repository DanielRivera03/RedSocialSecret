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
   if($_GET['nuevoregistro']!="explorar-amigos"){
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
      <title>Secret - Explorar Usuarios</title>
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
                     <li class="active">
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
         <div class="header-for-bg">
            <div class="background-header position-relative">
               <img src="../vista/images/bg_portadausuarios.jpg" class="img-fluid w-100 dimension_portada" alt="header-bg">
               <div class="title-on-header">
                  <div class="data-block">
                     <h2>Explorar Usuarios</h2>
                  </div>
               </div>
            </div>
         </div>
         <!-- Page Content  -->
         <div id="content-page" class="content-page">
            <div class="container">
               <div class="row">
                   <!-- INICIO LISTADO DE AMIGOS -->
                   <?php 
                    while($filas=mysqli_fetch_array($consulta)){
                       // NO MOSTRAR USUARIO QUE COINCIDA CON LA SESION INICIADA
                       // PERO SI TIENE LA LIBERTAD DE CONSULTARSE A SI MISMO EN OTRAS SECCIONES
                       if($filas['usuario']!=$_SESSION['usuario_unico']){
                        echo '
                        <div class="col-md-6">
                        <div class="iq-card">
                           <div class="iq-card-body profile-page p-0">
                              <div class="profile-header-image">
                                 <div class="cover-container">
                                    <img src="../vista/images/fotosportadas/'; echo $filas['foto_portada']; echo'" alt="profile-bg" class="rounded img-fluid w-100 dimension_portadaminiatura">
                                 </div>
                                 <div class="profile-info p-4">
                                    <div class="user-detail">
                                       <div class="d-flex flex-wrap justify-content-between align-items-start">
                                          <div class="profile-detail d-flex">
                                             <div class="profile-img-edit">
                                                <img src="../vista/images/fotosperfiles/'; echo $filas['fotoperfil']; echo'" alt="profile-img" class="profile-pic avatar-img avatar-110" />
                                             </div>
                                             <div class="user-data-block">
                                                <h4 class=""><i class="ri-vip-crown-2-line"> </i>'; echo $filas['nombres']; echo ' '; echo $filas['apellidos']; echo ' <i class="ri-vip-crown-2-line"></i></h4>
                                                <h6><a href="#">@'; echo $filas['usuario']; echo'</a></h6>
                                                <p>';echo '<i class="ri-vip-crown-line"></i> Residente de: '; echo $filas['pais']; echo ' '; 
                                                // VALIDACION DE BANDERAS
                                                /* SOLO ALGUNAS DE TODOS LOS PAISES */
                                                if($filas['pais']=="El Salvador"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/015-el-salvador.svg">';
                                                }else if($filas['pais']=="Afganistan"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/111-afghanistan.svg">';
                                                }else if($filas['pais']=="Arabia Saudita"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/133-saudi-arabia.svg">';
                                                }else if($filas['pais']=="Albania"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/099-albania.svg">';
                                                }else if($filas['pais']=="Alemania"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/162-germany.svg">';
                                                }else if($filas['pais']=="Andorra"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/045-andorra.svg">';
                                                }else if($filas['pais']=="Angola"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/117-angola.svg">';
                                                }else if($filas['pais']=="Antigua y Barbuda"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/075-antigua-and-barbuda.svg">';
                                                }else if($filas['pais']=="Argentina"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/198-argentina.svg">';
                                                }else if($filas['pais']=="Armenia"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/108-armenia.svg">';
                                                }else if($filas['pais']=="Australia"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/234-australia.svg">';
                                                }else if($filas['pais']=="Austria"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/003-austria.svg">';
                                                }else if($filas['pais']=="Azerbaiyan"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/141-azerbaijan.svg">';
                                                }else if($filas['pais']=="Bahamas"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/120-bahamas.svg">';
                                                }else if($filas['pais']=="Bahrein"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/138-bahrain.svg">';
                                                }else if($filas['pais']=="Bangladesh"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/147-bangladesh.svg">';
                                                }else if($filas['pais']=="Barbados"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/084-barbados.svg">';
                                                }else if($filas['pais']=="Belarus"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/135-belarus.svg">';
                                                }else if($filas['pais']=="Belice"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/078-belize.svg">';
                                                }else if($filas['pais']=="Benin"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/060-benin.svg">';
                                                }else if($filas['pais']=="Bhutan"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/040-bhutan.svg">';
                                                }else if($filas['pais']=="Bolivia"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/150-bolivia.svg">';
                                                }else if($filas['pais']=="Bosnia y Herzegovina"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/132-bosnia-and-herzegovina.svg">';
                                                }else if($filas['pais']=="Botswana"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/126-botswana.svg">';
                                                }else if($filas['pais']=="Brasil"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/255-brazil.svg">';
                                                }else if($filas['pais']=="Brunei Darussalam"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/119-brunei.svg">';
                                                }else if($filas['pais']=="Bulgaria"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/168-bulgaria.svg">';
                                                }else if($filas['pais']=="Burundi"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/057-burundi.svg">';
                                                }else if($filas['pais']=="Belgica"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/165-belgium.svg">';
                                                }else if($filas['pais']=="Cabo Verde"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/038-cape-verde.svg">';
                                                }else if($filas['pais']=="Camboya"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/159-cambodia.svg">';
                                                }else if($filas['pais']=="Camerun"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/105-cameroon.svg">';
                                                }else if($filas['pais']=="Canada"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/243-canada.svg">';
                                                }else if($filas['pais']=="Chad"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/066-chad.svg">';
                                                }else if($filas['pais']=="Chile"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/131-chile.svg">';
                                                }else if($filas['pais']=="China"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/034-china.svg">';
                                                }else if($filas['pais']=="Colombia"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/177-colombia.svg">';
                                                }else if($filas['pais']=="Comoras"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/029-comoros.svg">';
                                                }else if($filas['pais']=="Congo"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/157-republic-of-the-congo.svg">';
                                                }else if($filas['pais']=="Costa Rica"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/156-costa-rica.svg">';
                                                }else if($filas['pais']=="Croacia"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/164-croatia.svg">';
                                                }else if($filas['pais']=="Cuba"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/153-cuba.svg">';
                                                }else if($filas['pais']=="Dominica"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/186-dominica.svg">';
                                                }else if($filas['pais']=="Dinamarca"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/174-denmark.svg">';
                                                }else if($filas['pais']=="Ecuador"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/104-ecuador.svg">';
                                                }else if($filas['pais']=="Egipto"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/158-egypt.svg">';
                                                }else if($filas['pais']=="Emiratos Arabes Unidos"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/151-united-arab-emirates.svg">';
                                                }else if($filas['pais']=="Eritrea"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/065-eritrea.svg">';
                                                }else if($filas['pais']=="Eslovaquia"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/091-slovakia.svg">';
                                                }else if($filas['pais']=="Eslovenia"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/010-slovenia.svg">';
                                                }else if($filas['pais']=="España"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/128-spain.svg">';
                                                }else if($filas['pais']=="Estados Unidos de America"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/226-united-states.svg">';
                                                }else if($filas['pais']=="Estonia"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/008-estonia.svg">';
                                                }else if($filas['pais']=="Etiopia"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/005-ethiopia.svg">';
                                                }else if($filas['pais']=="Federacion de Rusia"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/248-russia.svg">';
                                                }else if($filas['pais']=="Fiji"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/137-fiji.svg">';
                                                }else if($filas['pais']=="Filipinas"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/192-philippines.svg">';
                                                }else if($filas['pais']=="Finlandia"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/125-finland.svg">';
                                                }else if($filas['pais']=="Francia"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/195-france.svg">';
                                                }else if($filas['pais']=="Gabon"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/059-gabon.svg">';
                                                }else if($filas['pais']=="Grecia"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/170-greece.svg">';
                                                }else if($filas['pais']=="Guatemala"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/098-guatemala.svg">';
                                                }else if($filas['pais']=="Guinea"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/110-guinea.svg">';
                                                }else if($filas['pais']=="Guinea" && $filas['pais']=="Guinea Ecuatorial" && $filas['pais']=="Guinea-Bissau"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/110-guinea.svg">';
                                                }else if($filas['pais']=="Guyana"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/207-guam.svg">';
                                                }else if($filas['pais']=="Mexico"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/252-mexico.svg">';
                                                }else if($filas['pais']=="Panama"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/106-panama.svg">';
                                                }else if($filas['pais']=="Venezuela"){echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/139-venezuela.svg">';
                                                }else{
                                                    echo '<img style="width: 15px; height: 15px;" src="../vista/images/banderas/incognito-1.svg">';
                                                }
                                                echo '</p>
                                             </div>
                                          </div>';
                                          if($filas['id']==$_SESSION['id_usuario']){}else{
                                          echo'
                                          <!-- ENVIO DE SOLICITUDES -->
                                          <a style="color: #fff;" id="enviosolicitud" data-id="'; echo $filas['id']; echo'" class="btn btn-primary"><i class="fa fa-user-plus"></i> Agregar</a>
                                          <!-- VISTA DE PERFILES -->
                                          <a href="../Perfiles/'; echo $filas['usuario']; echo'='; echo $filas['id']; echo'" class="btn btn-primary"><i class="fa fa-external-link"></i> Ver Perfil</a>'; } echo'
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                        ';
                       }
                    }// CIERRE while($filas=mysqli_fetch_array($consulta)){
                   ?>
                  <!-- FIN LISTADO DE AMIGOS -->
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
      <!-- Alerts -->
      <script src="../vista/js/alerta-enviosolicitudamistad.js"></script>
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