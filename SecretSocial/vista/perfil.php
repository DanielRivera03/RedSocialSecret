<?php
   $active_page = 'perfil';
   // NO PERMITIR INGRESO SIN ENVIO DE PARAMETRO
   if(!isset($_GET['publicaciones'])){
    header('location:../AccesoDenegado=restringido');
   }
   // NO PERMITIR INGRESO SIN INICIAR SESION
   if(!isset($_SESSION['nombre_usuario'])){
      header('location:../AccesoDenegado=restringido');
   }
   // NO PERMITIR INGRESO SI PARAMETRO NO ES IGUAL AL INDICADO
   if($_GET['publicaciones']!="perfil-usuario"){
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
      <title>Secret - Mi Perfil</title>
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
         <?php include __DIR__ . '/premium_sidebar.php'; ?>
         <?php include __DIR__ . '/premium_topnav.php'; ?>
         <!-- Page Content  -->
         <div id="content-page" class="content-page">
            <div class="container">
               <div class="row">
                  <div class="col-sm-12">
                     <div class="iq-card">
                        <div class="iq-card-body profile-page p-0">
                           <div class="profile-header">
                              <div class="cover-container">
                                 <a href="../vista/images/fotosportadas/<?php echo $_SESSION['fotos_portadas'];?>" class="expandir_imagen_simple"><img src="../vista/images/fotosportadas/<?php echo $_SESSION['fotos_portadas'];?>" alt="profile-bg" class="rounded img-fluid portadabg"></a>
                              </div>
                              <div class="user-detail text-center mb-3">
                                 <div class="profile-img">
                                 <a href="../vista/images/fotosperfiles/<?php echo $_SESSION['fotos_perfiles'];?>" class="expandir_imagen_simple"><img src="../vista/images/fotosperfiles/<?php echo $_SESSION['fotos_perfiles'];?>" alt="profile-img" class="avatar-130 img-fluid" /></a>
                                 </div>
                                 <div class="profile-detail">
                                    <h3 class=""><?php echo $_SESSION['nombre_usuario'];?> <?php echo $_SESSION['apellido_usuario'];?></h3>
                                 </div>
                              </div>
                              <div class="profile-info p-4 d-flex align-items-center justify-content-between position-relative">
                                 <div class="social-links">
                                 </div>
                                 <div class="social-info">
                                    <ul class="social-data-block d-flex align-items-center justify-content-between list-inline p-0 m-0">
                                       <li class="text-center pl-3">
                                          <h6>Publicaciones</h6>
                                          <p class="mb-0"><?php echo NumeroPublicacionesPerfilPropietario($conectarsistema2,$_SESSION['id_usuario']); ?></p>
                                       </li>
                                       <li class="text-center pl-3">
                                          <h6>Amigos</h6>
                                          <p class="mb-0"><?php echo NumeroAmigosPerfilPropietario($conectarsistema7,$_SESSION['id_usuario']); ?></p>
                                       </li>
                                    </ul>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="iq-card">
                        <div class="iq-card-body p-0">
                           <div class="user-tabing">
                              <ul class="nav nav-pills d-flex align-items-center justify-content-center profile-feed-items p-0 m-0">
                                 <li class="col-sm-3 p-0">
                                    <a class="nav-link active" data-toggle="pill" href="#timeline">Publicaciones</a>
                                 </li>
                                 <li class="col-sm-3 p-0">
                                    <a class="nav-link" data-toggle="pill" href="#about">Sobre M&iacute;</a>
                                 </li>
                                 <li class="col-sm-3 p-0">
                                    <a class="nav-link" data-toggle="pill" href="#friends">Amigos</a>
                                 </li>
                                 <li class="col-sm-3 p-0">
                                    <a class="nav-link" data-toggle="pill" href="#photos">Multimedia</a>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-12">
                     <div class="tab-content">
                        <div class="tab-pane fade active show" id="timeline" role="tabpanel">
                           <div class="iq-card-body p-0">
                              <div class="row">
                                 <div class="col-lg-4">
                                    <div class="iq-card">
                                       <div class="iq-card-header d-flex justify-content-between">
                                          <div class="iq-header-title">
                                             <h4 class="card-title">Fotos</h4>
                                          </div>
                                       </div>
                                       <div class="iq-card-body">
                                          <ul class="profile-img-gallary d-flex flex-wrap p-0 m-0">
                                          <?php 
                                             // FOTOS SUBIDAS POR USUARIOS -> MAXIMO 9 ELEMENTOS
                                             // MINIATURAS
                                             while($filas=mysqli_fetch_array($consulta2)){
                                                $fotos = explode(',', $filas['foto_publicacion']);
                                                foreach($fotos as $f) {
                                                   if(!empty($f) && $f !== '0' && $f !== 'null') {
                                                      echo '
                                                      <li class="col-md-4 col-6 pl-2 pr-0 pb-3"><a href="javascript:void();"><img style="width: 100%; height: 100%;" src="../vista/images/fotospublicaciones/'; echo $f; echo '" alt="gallary-image" class="img-fluid" /></a></li>
                                                      ';
                                                   }
                                                }
                                             }
                                          ?>
                                          </ul>
                                       </div>
                                    </div>
                                    <div class="iq-card">
                                       <div class="iq-card-header d-flex justify-content-between">
                                          <div class="iq-header-title">
                                             <h4 class="card-title">Amigos (<?php echo NumeroAmigosPerfilPropietario($conectarsistema8,$_SESSION['id_usuario']); ?>)</h4>
                                          </div>
                                          <div class="iq-card-header-toolbar d-flex align-items-center">
                                             <p class="m-0"><a href="javacsript:void();"></a></p>
                                          </div>
                                       </div>
                                       <!-- INICIO BANDERA AMIGOS CONFIRMADOS -->
                                       <div class="iq-card-body">
                                          <ul class="profile-img-gallary d-flex flex-wrap p-0 m-0">
                                          <?php 
                                             while($filas=mysqli_fetch_array($consulta4)){
                                                echo '
                                                <li class="col-md-4 col-6 pl-2 pr-0 pb-3">
                                                <div class="friend-container2">
                                                   <a href="javascript:void();">
                                                   <img src="../vista/images/fotosperfiles/'; echo $filas['fotoperfil']; echo'" alt="gallary-image" class="img-fluid" /></a>
                                                <h6 class="mt-2">'; echo $filas['nombres']; echo'</h6>
                                                </div>
                                             </li>
                                                ';
                                             }
                                          ?>
                                          <!-- FIN BANDERA AMIGOS CONFIRMADOS -->
                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-lg-8">
                                     <!-- CREAR PUBLICACIÓN -->
                                     <div id="post-modal-data" class="iq-card">
                                        <div class="iq-card-header d-flex justify-content-between">
                                           <div class="iq-header-title">
                                              <h4 class="card-title">Nueva Publicaci&oacute;n</h4>
                                           </div>
                                        </div>
                                        <div class="iq-card-body" data-toggle="modal" data-target="#post-modal">
                                           <div class="d-flex align-items-center">
                                              <div class="user-img">
                                                 <img src="../vista/images/fotosperfiles/<?php echo $_SESSION['fotos_perfiles'];?>" alt="userimg" class="avatar-60 rounded-circle">
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
                               </div>
                            </div>
                         </div>
                         <!-- FIN BANDERA -> PUBLICACIONES -->
                         <!--  SECCION SOBRE MI -->
                         <?php 
                            // SI USUARIO NO HA COMPLETADO SECCION SOBRE MI, SE EVALUAN SUS NOMBRES,
                            // AL NO EXISTIR REGISTROS ENTONCES MUESTRA ALERTA Y SE PROCEDE A BLOQUEAR
                            // LA VISTA DE SU PERFIL A TODOS LOS DEMAS USUARIOS HASTA QUE COMPLETE LO REQUERIDO
                            if($Publicaciones->getNombreUsuario()=="" && $Publicaciones->getApellidoUsuario()==""){
                         ?>
                        <div class="tab-pane fade" id="about" role="tabpanel">
                           <div class="iq-card">
                              <div class="iq-card-body">
                                 <div class="row">
                                    <div class="col-md-3">
                                       <ul class="nav nav-pills basic-info-items list-inline d-block p-0 m-0">
                                          <li>
                                             <a class="nav-link active" data-toggle="pill" href="#basicinfo">Informaci&oacute;n B&aacute;sica</a>
                                          </li>
                                       </ul>
                                    </div>
                                    <div class="col-md-9 pl-4">
                                       <div class="tab-content">
                                          <div class="tab-pane fade active show" id="basicinfo" role="tabpanel">
                                             <h4>Informaci&oacute;n B&aacute;sica</h4>
                                             <hr>
                                             <div class="alert bg-white alert-danger" role="alert">
                                                <div class="iq-alert-icon">
                                                   <i class="ri-information-line"></i>
                                                </div>
                                             <div class="iq-alert-text">Estimado(a) <?php echo $_SESSION['nombre_usuario']; echo" "; echo $_SESSION['apellido_usuario']; ?> usted no ha completado la secci&oacute;n <strong>Sobre M&iacute;</strong>. Si bien no es obligatorio hacerlo, lamentablemente le informamos que mientras no lo haga, <strong> todos sus detalles de usuarios no los podr&aacute; ver, adem&aacute;s que su perfil de usuario no podr&aacute; ser consultado por los dem&aacute;s usuarios.</strong> Le sugerimos completar dicha secci&oacute;n. Lo anterior no afecta a m&aacute;s funciones dentro de esta plataforma.</div>
                                             </div>
                                             </div>
                                          </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <?php
                           // PERFIL COMPLETADO CON EXITO
                           // PUEDE VISUALIZAR SUS DETALLES Y TODOS LOS USUARIOS PUEDEN VER SU PERFIL
                        }else{ ?>
                        <div class="tab-pane fade" id="about" role="tabpanel">
                           <div class="iq-card">
                              <div class="iq-card-body">
                                 <div class="row">
                                    <div class="col-md-3">
                                       <ul class="nav nav-pills basic-info-items list-inline d-block p-0 m-0">
                                          <li>
                                             <a class="nav-link active" data-toggle="pill" href="#basicinfo">Informaci&oacute;n B&aacute;sica</a>
                                          </li>
                                          <li>
                                             <a class="nav-link" data-toggle="pill" href="#details">Detalles Sobre M&iacute;</a>
                                          </li>
                                       </ul>
                                    </div>
                                    <div class="col-md-9 pl-4">
                                       <div class="tab-content">
                                          <div class="tab-pane fade active show" id="basicinfo" role="tabpanel">
                                             <h4>Informaci&oacute;n B&aacute;sica</h4>
                                             <hr>
                                             <div class="row">
                                             <div class="col-3">
                                                   <h6>Nombre y Apellido:</h6>
                                                </div>
                                                <div class="col-9">
                                                   <p class="mb-0"><?php echo $Publicaciones->getNombreUsuario(); ?> <?php echo $Publicaciones->getApellidoUsuario(); ?></p>
                                                </div>
                                                <div class="col-3">
                                                   <h6>Correo Electr&oacute;nico:</h6>
                                                </div>
                                                <div class="col-9">
                                                   <p class="mb-0"><a href="mailto:<?php echo $Publicaciones->getCorreoUsuario();?>"><?php echo $Publicaciones->getCorreoUsuario(); ?></a></p>
                                                </div>
                                                <div class="col-3">
                                                   <h6>Tel&eacute;fono:</h6>
                                                </div>
                                                <div class="col-9">
                                                <?php 
                                                   if($Publicaciones->getUsuarioUnico()==$_SESSION['usuario_unico']){
                                                      echo '<p class="mb-0">'; echo $Publicaciones->getTelefonoUsuario();  echo '</p>';
                                                   }else{
                                                      echo '<p class="mb-0">Lo sentimos, esta informaci&oacute;n solo la puede ver el due&ntilde;o de este perfil</p>';
                                                   }
                                                ?>
                                                </div>
                                                <div class="col-3">
                                                   <h6>Pa&iacute;s de Residencia:</h6>
                                                </div>
                                                <div class="col-9">
                                                   <p class="mb-0"><?php echo $Publicaciones->getPaisUsuario(); ?></p>
                                                </div>
                                                <div class="col-3">
                                                   <h6>Ciudad de Residencia:</h6>
                                                </div>
                                                <div class="col-9">
                                                   <p class="mb-0"><?php echo $Publicaciones->getCiudadUsuario(); ?></p>
                                                </div>
                                                <div class="col-3">
                                                   <h6>G&eacute;nero</h6>
                                                </div>
                                                <div class="col-9">
                                                   <p class="mb-0"><?php if($Publicaciones->getGeneroUsuario()=="m"){
                                                      echo "Hombre";
                                                   }else if($Publicaciones->getGeneroUsuario()=="f"){
                                                      echo "Mujer";
                                                   }else if($Publicaciones->getGeneroUsuario()=="i"){
                                                      echo "Prefiero no decirlo";
                                                   }
                                                   ?></p>
                                                </div>
                                             </div>
                                             <br>
                                             <h4>Datos de Cumplea&ntilde;os y Nacimiento</h4>
                                             <hr>
                                             <div class="row">
                                                <div class="col-3">
                                                   <h6>D&iacute;a y Mes:</h6>
                                                </div>
                                                <div class="col-9">
                                                   <p class="mb-0"><?php $Fecha = $Publicaciones->getFechaNacimientoUsuario(); $FechaCompleta = strtotime($Fecha); $ObtenerMes = date("m", $FechaCompleta); $ObtenerDia = date("d", $FechaCompleta); echo $ObtenerDia; echo " de ";
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
                                                   ?></p>
                                                </div>
                                                <div class="col-3">
                                                   <h6>A&ntilde;o:</h6>
                                                </div>
                                                <div class="col-9">
                                                   <p class="mb-0"><?php $Fecha = $Publicaciones->getFechaNacimientoUsuario(); $FechaCompleta = strtotime($Fecha); $ObtenerAnio = date("Y", $FechaCompleta); echo $ObtenerAnio; ?></p>
                                                </div>
                                                <div class="col-3">
                                                   <h6>¿Cu&aacute;ntos A&ntilde;os Tengo?</h6>
                                                </div>
                                                <div class="col-9">
                                                   <p class="mb-0"><?php 
                                                  // OBTENER FECHA COMPLETA REGISTRADA
                                                  $Fecha = $Publicaciones->getFechaNacimientoUsuario();
                                                  // CALCULAR EDAD ANTES DE CUMPLEAÑOS
                                                  $FechaCumpleanos = new DateTime($Fecha);
                                                  $Ahora = new DateTime();
                                                  // COMPRUEBA SEGUN AÑO -> MES -> DIA
                                                  $CalcularEdad = $Ahora->diff($FechaCumpleanos);
                                                  echo $CalcularEdad->y; echo " A&ntilde;os";
                                                  ?></p>
                                                </div>
                                                </div>
                                          </div>
                                          <div class="tab-pane fade" id="details" role="tabpanel">
                                          <h4 class="mb-3">Detalles Sobre M&iacute;</h4>
                                          <hr>
                                          <div class="row">
                                             <div class="col-3">
                                                   <h6>Religi&oacute;n:</h6>
                                                </div>
                                                <div class="col-9">
                                                   <p class="mb-0"><?php echo $Publicaciones->getReligionUsuario(); ?></p>
                                                </div>
                                                <div class="col-3">
                                                   <h6>Profesi&oacute;n:</h6>
                                                </div>
                                                <div class="col-9">
                                                   <p class="mb-0"><?php echo $Publicaciones->getEmpleoUsuario(); ?></p>
                                                </div>
                                                <div class="col-3">
                                                   <h6>Educaci&oacute;n Inicial</h6>
                                                </div>
                                                <div class="col-9">
                                                   <p class="mb-0"><?php echo $Publicaciones->getEscuelaUsuario(); ?></p>
                                                </div>
                                                <div class="col-3">
                                                   <h6>Educaci&oacute;n Superior</h6>
                                                </div>
                                                <div class="col-9">
                                                   <p class="mb-0"><?php echo $Publicaciones->getUniversidadUsuario(); ?></p>
                                                </div>
                                                <div class="col-3">
                                                   <h6>Deportes Favoritos:</h6>
                                                </div>
                                                <div class="col-9">
                                                   <p class="mb-0"><?php echo $Publicaciones->getDeportesUsuario(); ?></p>
                                                </div>
                                                <div class="col-3">
                                                   <h6>Inter&eacute;s Sentimental</h6>
                                                </div>
                                                <div class="col-9">
                                                   <p class="mb-0"><?php echo $Publicaciones->getInteresesUsuario(); ?></p>
                                                </div>
                                                <div class="col-3">
                                                   <h6>M&uacute;sica Favorita:</h6>
                                                </div>
                                                <div class="col-9">
                                                   <p class="mb-0"><?php echo $Publicaciones->getGenerosMusicalesUsuario(); ?></p>
                                                </div>
                                                <div class="col-3">
                                                   <h6>Situaci&oacute;n Sentimental</h6>
                                                </div>
                                                <div class="col-9">
                                                   <p class="mb-0"><?php echo $Publicaciones->getSituacionSentimentalUsuario(); ?></p>
                                                </div>
                                             </div>
                                             <hr>
                                             <h4 class="mb-3">Peque&ntilde;a Rese&ntilde;a Sobre M&iacute;</h4>
                                             <p><?php echo $Publicaciones->getSobreMiUsuario(); ?></p>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <?php } // CIERRE COMPROBACION PERFIL -> DETALLES USUARIOS / SOBRE MI?>
                        <div class="tab-pane fade" id="friends" role="tabpanel">
                           <div class="iq-card">
                              <div class="iq-card-body">
                                 <h2>Amigos</h2>
                                 <div class="friend-list-tab mt-2">
                                    <ul class="nav nav-pills d-flex align-items-center justify-content-left friend-list-items p-0 mb-2">
                                       <li>
                                          <a class="nav-link" data-toggle="pill" href="#all-friends">Todos los amigos (<?php echo NumeroAmigosPerfilPropietarioSecundarioPrincipal($conectarsistema10,$_SESSION['id_usuario']); ?>)</a>
                                       </li>
                                    </ul>
                                    <div class="tab-content">
                                       <div class="tab-pane fade active show" id="all-friends" role="tabpanel">
                                          <div class="iq-card-body p-0">
                                             <div class="row">
                                             <!-- INICIO BANDERA AMIGOS -> MENU SECUNDARIO PRINCIPAL -->
                                             <?php 
                                                   while($filas=mysqli_fetch_array($consulta5)){
                                                      echo '
                                                      <div class="col-md-6 col-lg-6 mb-3">
                                                      <div class="iq-friendlist-block">
                                                         <div class="d-flex align-items-center justify-content-between">
                                                            <div class="d-flex align-items-center">
                                                               <div class="friend-container1">
                                                               <a href="#">
                                                               <img src="../vista/images/fotosperfiles/';echo $filas['fotoperfil']; echo'" alt="profile-img" class="img-fluid friend-one">
                                                               </a>
                                                               </div>
                                                               <div class="friend-info ml-3">
                                                                  <a href="../controlador/cPublicacionesUsuarios.php?publicaciones=perfil-general&usuario='; echo $filas['usuario']; echo'&id='; echo $filas['idsolicitudamigo']; echo'"><h5>'; echo $filas['nombres']; echo' '; echo $filas['apellidos']; echo'</h5></a>
                                                               </div>
                                                            </div>
                                                            <div class="iq-card-header-toolbar d-flex align-items-center">
                                                               <div class="dropdown">
                                                                  <span class="dropdown-toggle btn btn-secondary mr-2" id="dropdownMenuButton01" data-toggle="dropdown" aria-expanded="true" role="button">
                                                                  <i class="ri-check-line mr-1 text-white font-size-16"></i> Amigos
                                                                  </span>
                                                                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton01">
                                                                  <!-- MAS OPCIONES Y MANTENIMIENTOS SON POSIBLES -->
                                                                  <a class="dropdown-item p-3" id="borraramigo" data-id="'.$filas['idamigo'].'">
                                                               <div class="d-flex align-items-top">
                                                                  <div class="icon font-size-15"><i class="ri-delete-bin-7-line"></i></div>
                                                                  <div class="data ml-2">
                                                                     <h6>Eliminar Amigo</h6>
                                                                  </div>
                                                               </div>
                                                            </a>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                      ';
                                                   }
                                             ?> 
                                                <!-- FIN BANDERA AMIGOS -> MENU SECUNDARIO PRINCIPAL -->
                                             </div>
                                          </div>
                                       </div>
   
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="tab-pane fade" id="photos" role="tabpanel">
                           <div class="iq-card">
                              <div class="iq-card-body">
                                 <h2>Multimedia</h2>
                                 <div class="friend-list-tab mt-2">
                                    <ul class="nav nav-pills d-flex align-items-center justify-content-left friend-list-items p-0 mb-2">
                                       <li>
                                          <a class="nav-link" data-toggle="pill" href="#photosofyou">Fotos Subidas</a>
                                       </li>
                                    </ul>
                                    <div class="tab-content">
                                       <div class="tab-pane fade active show" id="photosofyou" role="tabpanel">
                                          <div class="iq-card-body p-0">
                                             <div class="row">
                                             <?php 
                                                    $tempConn = crearNuevaConexion();
                                                    while($filas=mysqli_fetch_array($consulta3)){
                                                       $idPub = intval($filas['idpublicacion']);
                                                       $msgQuery = mysqli_query($tempConn, "SELECT mensaje_publicacion FROM publicaciones WHERE idpublicacion = $idPub LIMIT 1");
                                                       $msgRow = $msgQuery ? mysqli_fetch_assoc($msgQuery) : null;
                                                       $mensaje_pub = $msgRow['mensaje_publicacion'] ?? '';
                                                       
                                                       $msgEsc = htmlspecialchars($mensaje_pub, ENT_QUOTES, 'UTF-8');
                                                       
                                                       $nombreEsc = htmlspecialchars($filas['nombres'] . ' ' . $filas['apellidos'], ENT_QUOTES, 'UTF-8');
                                                       $avatarEsc = htmlspecialchars($filas['fotoperfil'], ENT_QUOTES, 'UTF-8');
                                                       $fechaEsc = htmlspecialchars($filas['fecha_publicacion'], ENT_QUOTES, 'UTF-8');
                                                       $fotoPubEsc = htmlspecialchars($filas['foto_publicacion'], ENT_QUOTES, 'UTF-8');
                                                       
                                                       $fotos = explode(',', $filas['foto_publicacion']);
                                                       $fotos = array_filter(array_map('trim', $fotos));
                                                       foreach($fotos as $idx => $f) {
                                                           if(!empty($f) && $f !== '0' && $f !== 'null') {
                                                               $fEsc = htmlspecialchars($f, ENT_QUOTES, 'UTF-8');
                                                               echo '
                                                               <div class="col-md-6 col-lg-3 mb-3">
                                                               <div class="user-images position-relative overflow-hidden">
                                                               <div class="photo-container">
                                                               <a class="expandir_imagen fb-viewer-trigger" href="../vista/images/fotospublicaciones/' . $fEsc . '" data-post-id="' . $idPub . '" data-msg="' . $msgEsc . '" data-author-name="' . $nombreEsc . '" data-author-avatar="' . $avatarEsc . '" data-post-date="' . $fechaEsc . '" data-all-images="' . $fotoPubEsc . '" data-current-index="' . $idx . '">
                                                                  <img style="width: 100%; height: 100%;" src="../vista/images/fotospublicaciones/' . $fEsc . '" class="img-fluid rounded" alt="Responsive image">
                                                                  </a>
                                                               </div>
                                                                 <div class="image-hover-data">
                                                                    <div class="product-elements-icon">
                                                                       <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                                          <li><a href="#" class="pr-3 text-white"> <time class="timeago" datetime="'.$filas['fecha_publicacion'].'"></time> <i class="ri-calendar-line"></i> </a></li>
                                                                       </ul>
                                                                    </div>
                                                                 </div>
                                                                 <a href="#" id="eliminarhistorias" data-id="'.$filas['idpublicacion'].'" class="image-edit-btn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Eliminar"><i class="ri-delete-bin-2-fill"></i></a>
                                                              </div>
                                                           </div>
                                                              ';
                                                          }
                                                      }
                                                   }
                                                   if ($tempConn) $tempConn->close();
                                             ?> 
                                                
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
      <script src="../vista/js/alerta-solicitudesaceptadas.js"></script>
      <script src="../vista/js/alerta-eliminarsolicitudamistad.js"></script>
      <script src="../vista/js/alerta-eliminaramigos.js"></script>
      <script src="../vista/js/conexion_envivo.js"></script>
      <script src="../vista/js/floating_chat.js"></script>
      <!-- Feed Envivo (reacciones + comentarios) -->
      <script src="../vista/js/feed_envivo.js"></script>
      <!-- Feed Infinito con Skeleton -->
      <script src="../vista/js/feed-infinito.js"></script>
      <script>
         $(document).ready(function() {
           FeedInfinito.init({
             tipo: 'perfil',
             contenedor: 'feed-publications',
             id_usuario: <?php echo intval($_SESSION['id_usuario']); ?>
           });
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

        // Initialize Magnific Popup for simple profile/cover images
        if ($.fn.magnificPopup) {
            $('.expandir_imagen_simple').magnificPopup({
                type: 'image',
                closeOnContentClick: true,
                mainClass: 'mfp-img-mobile',
                image: {
                    verticalFit: true
                }
            });
        }
    });
    </script>
     <?php include __DIR__ . '/fb_viewer_modal.php'; ?>
   </body>
</html>
<?php
/*SI UN USUARIO CON PERFIL INCOMPLETO INTENTA ACCEDER AL FEED DE LA APLICACION
SE LE BLOQUEA SU ACCESO Y DEBE OBLIGATORIAMENTE COMPLETAR SU PERFIL PARA PODER
ACCEDER A TODAS LAS FUNCIONES DE ESTA APLICACION*/
}else{header('location:../Controlador/cRegistroNuevosUsuarios.php?nuevoregistro=completarperfil');}
?>