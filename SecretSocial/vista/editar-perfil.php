<?php
   $active_page = 'perfil';

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
     
     <!-- Estilos Premium para Editar Perfil (Facebook/Instagram Settings look) -->
     <style>
     :root {
        --primary-color: #b92025;
        --primary-gradient: linear-gradient(135deg, #b92025, #e53935);
        --bg-light: #f8fafc;
        --border-color: #e2e8f0;
        --text-dark: #1e293b;
        --text-muted: #64748b;
     }

     /* Sidebar y Diseño de dos columnas */
     .iq-edit-list {
        background: #ffffff !important;
        border: 1px solid var(--border-color) !important;
        border-radius: 16px !important;
        padding: 12px !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02) !important;
     }

     .iq-edit-profile {
        flex-direction: column !important;
     }

     .iq-edit-profile li {
        width: 100% !important;
        max-width: 100% !important;
        margin-bottom: 6px !important;
     }

     .iq-edit-profile a.nav-link {
        background: transparent !important;
        color: var(--text-muted) !important;
        font-weight: 550 !important;
        font-family: 'Inter', sans-serif !important;
        font-size: 14.5px !important;
        border-radius: 10px !important;
        padding: 12px 16px !important;
        transition: all 0.2s ease !important;
        display: flex !important;
        align-items: center !important;
        gap: 10px !important;
        text-align: left !important;
        border: 1px solid transparent !important;
     }

     .iq-edit-profile a.nav-link.active {
        background: #fef2f2 !important;
        color: var(--primary-color) !important;
        font-weight: 600 !important;
        border: 1px solid rgba(185, 32, 37, 0.1) !important;
     }

     .iq-edit-profile a.nav-link:hover:not(.active) {
        background: #f1f5f9 !important;
        color: var(--text-dark) !important;
     }

     /* Tarjeta Principal */
     .iq-edit-list-data .iq-card {
        border: 1px solid var(--border-color) !important;
        border-radius: 16px !important;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02) !important;
        background: #ffffff !important;
        overflow: hidden;
     }

     .iq-card-header {
        border-bottom: 1px solid var(--border-color) !important;
        padding: 20px 24px !important;
        background: #ffffff !important;
     }

     .iq-card-header .card-title {
        font-size: 18px !important;
        font-weight: 700 !important;
        color: var(--text-dark) !important;
        font-family: 'Inter', sans-serif !important;
        margin: 0 !important;
     }

     .iq-card-body {
        padding: 24px !important;
     }

     /* Campos de Formulario e Inputs */
     .form-group label {
        font-weight: 600 !important;
        font-size: 13px !important;
        color: #475569 !important;
        margin-bottom: 6px !important;
        font-family: 'Inter', sans-serif !important;
     }

     .form-control {
        border: 1.5px solid var(--border-color) !important;
        border-radius: 10px !important;
        padding: 10px 14px !important;
        font-size: 14px !important;
        color: var(--text-dark) !important;
        background-color: #ffffff !important;
        transition: all 0.2s ease !important;
        height: auto !important;
     }

     .form-control:focus {
        border-color: var(--primary-color) !important;
        box-shadow: 0 0 0 3px rgba(185, 32, 37, 0.12) !important;
        outline: none !important;
     }

     .form-control[readonly], .form-control:disabled {
        background-color: #f8fafc !important;
        border-color: #e2e8f0 !important;
        color: #94a3b8 !important;
        cursor: not-allowed !important;
     }

     /* Genero - Controles */
     .custom-radio {
        background: #f8fafc;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 10px 14px 10px 30px !important;
        transition: all 0.2s ease;
        cursor: pointer;
        margin-right: 8px !important;
        margin-bottom: 8px !important;
        display: inline-block !important;
     }

     .custom-radio:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
     }

     .custom-control-input:checked ~ .custom-control-label::before {
        background-color: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
     }

     /* Botones Premium */
     .btn-primary {
        background: var(--primary-gradient) !important;
        border: none !important;
        border-radius: 10px !important;
        padding: 10px 24px !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        box-shadow: 0 4px 12px rgba(185, 32, 37, 0.15) !important;
        transition: all 0.2s ease !important;
     }

     .btn-primary:hover {
        transform: translateY(-1px) !important;
        box-shadow: 0 6px 16px rgba(185, 32, 37, 0.25) !important;
     }

     /* Contenedor del Avatar Circular */
     .profile-avatar-container {
        position: relative !important;
        width: 140px !important;
        height: 140px !important;
        margin: 0 auto 24px !important;
     }

     .profile-img-edit.avatar {
        width: 140px !important;
        height: 140px !important;
        margin: 0 !important;
        border-radius: 50% !important;
        border: 4px solid #ffffff !important;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06) !important;
        position: relative !important;
        overflow: hidden !important;
        background: #f1f5f9 !important;
        transition: all 0.3s ease !important;
     }

     .profile-img-edit.avatar:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.1) !important;
     }

     .profile-img-edit.avatar .profile-pic {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
        border-radius: 50% !important;
     }

     .profile-img-edit.avatar .p-image {
        position: absolute !important;
        bottom: 0 !important;
        left: 0 !important;
        right: 0 !important;
        height: 40px !important;
        background: rgba(15, 23, 42, 0.75) !important;
        backdrop-filter: blur(2px) !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        opacity: 0 !important;
        transition: opacity 0.2s ease !important;
        color: #ffffff !important;
        cursor: pointer !important;
     }

     .profile-img-edit.avatar:hover .p-image {
        opacity: 1 !important;
     }

     .profile-img-edit.avatar .p-image i {
        font-size: 16px !important;
        color: #ffffff !important;
     }

     .btn-webcam-trigger {
        position: absolute !important;
        bottom: 4px !important;
        right: 4px !important;
        width: 38px !important;
        height: 38px !important;
        border-radius: 50% !important;
        background: #ffffff !important;
        border: 1px solid var(--border-color) !important;
        color: var(--text-dark) !important;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.12) !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: all 0.2s ease !important;
        cursor: pointer !important;
        padding: 0 !important;
        z-index: 5 !important;
     }

     .btn-webcam-trigger:hover {
        background: var(--primary-color) !important;
        color: #ffffff !important;
        border-color: var(--primary-color) !important;
        transform: scale(1.08);
     }

     /* Alertas de Información Modernas */
     .alert {
        border-radius: 12px !important;
        padding: 16px 20px !important;
        border: 1px solid transparent !important;
        display: flex !important;
        align-items: flex-start !important;
        gap: 12px !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.01) !important;
        font-family: 'Inter', sans-serif !important;
        font-size: 13.5px !important;
        line-height: 1.5 !important;
     }

     .alert.bg-danger, .alert-danger {
        background-color: #fef2f2 !important;
        border-color: #fee2e2 !important;
        color: #991b1b !important;
     }

     .alert.bg-danger .iq-alert-icon, .alert-danger .iq-alert-icon {
        color: #ef4444 !important;
        font-size: 18px !important;
        display: flex;
        align-items: center;
     }

     .alert.bg-danger strong, .alert-danger strong {
        color: #7f1d1d !important;
     }

     .alert-info, .alert.bg-info {
        background-color: #f0f9ff !important;
        border-color: #e0f2fe !important;
        color: #0369a1 !important;
     }

     .alert-info .iq-alert-icon, .alert.bg-info .iq-alert-icon {
        color: #0284c7 !important;
        font-size: 18px !important;
        display: flex;
        align-items: center;
     }

     .alert-success {
        background-color: #f0fdf4 !important;
        border-color: #dcfce7 !important;
        color: #166534 !important;
     }

     .alert-success .iq-alert-icon {
        color: #16a34a !important;
        font-size: 18px !important;
        display: flex;
        align-items: center;
     }

     /* Área de Peligro */
     .danger-zone-title {
        color: #dc2626 !important;
        font-weight: 700 !important;
        font-size: 16px !important;
        margin-bottom: 12px !important;
        display: flex;
        align-items: center;
        gap: 6px;
        font-family: 'Inter', sans-serif !important;
     }

     #eliminarcuentausuarios {
        background: #fef2f2 !important;
        border: 1px solid #fca5a5 !important;
        color: #b91c1c !important;
        border-radius: 10px !important;
        padding: 12px !important;
        font-weight: 600 !important;
        font-size: 14px !important;
        transition: all 0.2s ease !important;
        box-shadow: none !important;
        width: 100% !important;
     }

     #eliminarcuentausuarios:hover {
        background: #fee2e2 !important;
        border-color: #ef4444 !important;
        color: #991b1c !important;
     }

     /* Dropify Premium */
     .dropify-wrapper {
        border: 2px dashed #cbd5e1 !important;
        border-radius: 12px !important;
        background-color: #f8fafc !important;
        transition: all 0.2s ease !important;
     }

     .dropify-wrapper:hover {
        border-color: var(--primary-color) !important;
        background-color: #ffffff !important;
     }

     .dropify-wrapper .dropify-message p {
        font-family: 'Inter', sans-serif !important;
        font-size: 13.5px !important;
        color: var(--text-muted) !important;
        font-weight: 550 !important;
     }
     </style>
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
                  <?php include __DIR__ . '/premium_sidebar.php'; ?>
         <?php include __DIR__ . '/premium_topnav.php'; ?>
         <!-- Page Content  -->
         <div id="content-page" class="content-page">
            <div class="container">
               <div class="row">
                  <!-- Sidebar Settings Menu -->
                  <div class="col-lg-3 col-md-4 col-sm-12 mb-4">
                     <div class="iq-card settings-sidebar-card">
                        <div class="iq-card-body p-0">
                           <div class="iq-edit-list">
                              <ul class="iq-edit-profile d-flex nav nav-pills flex-column">
                                 <li class="p-0">
                                    <a class="nav-link active" data-toggle="pill" href="#informacion-personal">
                                       <i class="las la-user-cog mr-2"></i>Informaci&oacute;n Personal
                                    </a>
                                 </li>
                                 <li class="p-0 mt-2">
                                    <a class="nav-link" data-toggle="pill" href="#informaciondetalles-usuarios">
                                       <i class="las la-info-circle mr-2"></i>Sobre M&iacute;
                                    </a>
                                 </li>
                                 <li class="p-0 mt-2">
                                    <a class="nav-link" data-toggle="pill" href="#seguridad-perfil">
                                       <i class="las la-shield-alt mr-2"></i>Seguridad y Contrase&ntilde;a
                                    </a>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
                  
                  <!-- Main Settings Panel -->
                  <div class="col-lg-9 col-md-8 col-sm-12">
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
                                 <div class="alert alert-info" role="alert">
                                    <div class="iq-alert-icon">
                                       <i class="ri-information-line"></i>
                                    </div>
                                    <div class="iq-alert-text">Estimado(a) <strong><?php echo $_SESSION['nombre_usuario'] ?></strong>, desde aqu&iacute; puedes actualizar tu informaci&oacute;n personal b&aacute;sica. Tus datos est&aacute;n protegidos. Para cambiar tu contrase&ntilde;a de acceso, ve a la pesta&ntilde;a <strong>Seguridad y Contrase&ntilde;a</strong>.</div>
                                    </div><br>
                                       <div class="form-group row align-items-center">
                                          <div class="col-md-12">
                                             <div class="profile-avatar-container">
                                                <div class="profile-img-edit avatar">
                                                   <img class="profile-pic avatar-img" src="../vista/images/fotosperfiles/<?php echo $Usuarios->getFotoPerfilUsuario();?>" alt="Foto de perfil" data-toggle="tooltip" data-placement="right" title="Resoluci&oacute;n sugerida: 640x640 &Uacute;nicamente: .png / .jpg">
                                                   <div class="p-image" data-toggle="tooltip" data-placement="bottom" title="Campo No Requerido">
                                                      <i class="ri-pencil-line upload-button"></i>
                                                      <input class="file-upload" type="file" name="fotoperfil" accept="image/x-png,image/jpeg"/>
                                                   </div>
                                                </div>
                                                <!-- CAPTURAR FOTO WEBCAM -->
                                                <button type="button" class="btn-webcam-trigger" data-toggle="modal" data-target="#exampleModalCenter" data-toggle="tooltip" data-placement="bottom" title="Tomar Foto con WebCam">
                                                   <i class="fa fa-camera"></i>
                                                </button>
                                             </div>
                                             
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
                                    <div class="alert alert-danger" role="alert">
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
                                             <div class="alert alert-info" role="alert">
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
                                          <div class="alert alert-info" role="alert">
                                             <div class="iq-alert-icon">
                                             <i class="ri-information-line"></i>
                                          </div>
                                          <div class="iq-alert-text">Estimado(a) <?php echo $_SESSION['nombre_usuario'];?> le recordamos que esta secci&oacute;n es opcional, usted decide si completarla o no. S&iacute; decide completarla, el &uacute;nico campo requerido es sobre una peque&ntilde;a descripci&oacute;n corta subre usted. <strong>Le sugerimos que en los campos donde usted ingrese m&aacute;s de un detalle, lo separe por comas " , "</strong> esto con el fin de mostrar su informaci&oacute;n en su perfil de usuario de la manera m&aacute;s ordenada posible. <strong>Hemos detectado que usted es un usuario nuevo; al completar los campos que usted considere necesarios, por su seguridad deber&aacute; iniciar sesi&oacute;n nuevamente. Lo anterior aplica &uacute;nicamente a los usuario nuevos.</strong></div>
                                       </div>
                                       <div class="alert alert-danger" role="alert">
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
                           <!-- NUEVA PESTAÑA: SEGURIDAD Y CONTRASEÑA -->
                           <div class="tab-pane fade" id="seguridad-perfil" role="tabpanel">
                              <div class="iq-card">
                                 <div class="iq-card-header d-flex justify-content-between">
                                    <div class="iq-header-title">
                                       <h4 class="card-title"><i class="las la-shield-alt mr-2" style="color: var(--primary-color);"></i>Seguridad y Contrase&ntilde;a</h4>
                                    </div>
                                 </div>
                                 <div class="iq-card-body">
                                    <div class="row">
                                       <!-- Columna del Formulario de Cambio de Clave -->
                                       <div class="col-lg-6 col-md-12 mb-4">
                                          <h5 class="mb-3 font-weight-bold" style="color: var(--text-dark); font-family: 'Inter', sans-serif;">Actualizar Contrase&ntilde;a</h5>
                                          <form id="form_cambiar_clave" class="needs-validation" novalidate method="POST" autocomplete="off">
                                             <div class="form-group">
                                                <label for="clave_actual">Contrase&ntilde;a Actual:</label>
                                                <input type="password" class="form-control" id="clave_actual" name="clave_actual" placeholder="Ingresa tu contrase&ntilde;a actual" required>
                                                <div class="invalid-tooltip">Por favor ingresa tu contrase&ntilde;a actual.</div>
                                             </div>
                                             <div class="form-group">
                                                <label for="clave_nueva">Nueva Contrase&ntilde;a:</label>
                                                <input type="password" class="form-control" id="clave_nueva" name="clave_nueva" placeholder="M&iacute;nimo 8 caracteres" required>
                                                <div class="invalid-tooltip">Por favor ingresa tu nueva contrase&ntilde;a.</div>
                                             </div>
                                             <div class="form-group">
                                                <label for="clave_nueva_repetida">Confirmar Nueva Contrase&ntilde;a:</label>
                                                <input type="password" class="form-control" id="clave_nueva_repetida" placeholder="Repite tu nueva contrase&ntilde;a" required>
                                                <div class="invalid-tooltip">Por favor confirma tu nueva contrase&ntilde;a.</div>
                                             </div>
                                             <button type="submit" id="btn_cambiar_clave" class="btn btn-primary mt-3 w-100">Guardar Cambios</button>
                                          </form>
                                       </div>
                                       
                                       <!-- Columna de Consejos de Seguridad Estilo Facebook -->
                                       <div class="col-lg-6 col-md-12">
                                          <div class="p-3 border rounded-lg bg-light" style="border-radius: 12px; border: 1.5px solid var(--border-color) !important; background-color: var(--bg-light) !important;">
                                             <h5 class="mb-3 font-weight-bold d-flex align-items-center gap-2" style="color: var(--text-dark); font-family: 'Inter', sans-serif;">
                                                <i class="las la-user-shield text-success font-size-24 mr-2"></i>Comprobaci&oacute;n de Seguridad
                                             </h5>
                                             <p class="text-muted font-size-13 mb-4">Te ayudamos a proteger tu cuenta en Secret&reg;. Sigue estos consejos pr&aacute;cticos inspirados en est&aacute;ndares profesionales de seguridad.</p>
                                             
                                             <ul class="list-unstyled mb-0" style="padding-left: 0;">
                                                <li class="media mb-3 align-items-start">
                                                   <i class="las la-key text-primary font-size-20 mr-3 mt-1"></i>
                                                   <div class="media-body">
                                                      <h6 class="mt-0 mb-1 font-weight-bold font-size-14" style="color: var(--text-dark);">Contrase&ntilde;as Fuertes</h6>
                                                      <p class="text-muted font-size-12 mb-0">Combina letras may&uacute;sculas, min&uacute;sculas, n&uacute;meros y s&iacute;mbolos. Evita usar datos obvios como fechas o nombres.</p>
                                                   </div>
                                                </li>
                                                <li class="media mb-3 align-items-start">
                                                   <i class="las la-envelope-open-text text-warning font-size-20 mr-3 mt-1"></i>
                                                   <div class="media-body">
                                                      <h6 class="mt-0 mb-1 font-weight-bold font-size-14" style="color: var(--text-dark);">Alertas por Correo Electr&oacute;nico</h6>
                                                      <p class="text-muted font-size-12 mb-0">Cada vez que realices cambios en tu perfil o se detecte un inicio de sesi&oacute;n duplicado, te enviaremos una alerta de seguridad.</p>
                                                   </div>
                                                </li>
                                                <li class="media mb-3 align-items-start">
                                                   <i class="las la-lock-open text-danger font-size-20 mr-3 mt-1"></i>
                                                   <div class="media-body">
                                                      <h6 class="mt-0 mb-1 font-weight-bold font-size-14" style="color: var(--text-dark);">No compartas tus datos</h6>
                                                      <p class="text-muted font-size-12 mb-0">Secret&reg; nunca te pedir&aacute; tu clave por correo, SMS ni chat privado. Mant&eacute;n tus credenciales seguras.</p>
                                                   </div>
                                                </li>
                                                <li class="media align-items-start">
                                                   <i class="las la-history text-info font-size-20 mr-3 mt-1"></i>
                                                   <div class="media-body">
                                                      <h6 class="mt-0 mb-1 font-weight-bold font-size-14" style="color: var(--text-dark);">Control de Inicios de Sesi&oacute;n</h6>
                                                      <p class="text-muted font-size-12 mb-0">Monitoreamos sesiones concurrentes. Si inicias sesi&oacute;n en otro navegador, te notificaremos inmediatamente por seguridad.</p>
                                                   </div>
                                                </li>
                                             </ul>
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