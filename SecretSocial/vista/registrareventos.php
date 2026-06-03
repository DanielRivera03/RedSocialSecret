<?php
   $active_page = 'registrareventos';
 
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
      <!-- Google Fonts -->
      <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
      <!-- Remix Icons -->
      <link href="https://cdn.jsdelivr.net/npm/remixicon@2.2.0/fonts/remixicon.css" rel="stylesheet">
      <!-- Alerts -->
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

      <style>
          body, input, textarea, button, select, label {
              font-family: 'Montserrat', sans-serif !important;
          }
          h1, h2, h3, h4, h5, h6, .card-title {
              font-family: 'Poppins', sans-serif !important;
          }
         /* Stepper/Wizard Custom Styling */
         .stepwizard {
             background: transparent;
             padding: 0;
             margin-bottom: 30px;
             border-bottom: 1px solid var(--iq-border-light);
         }
         body.dark-theme .stepwizard {
             border-color: #3a3b3c;
         }
         .stepwizard-row {
             display: flex;
             justify-content: space-between;
             position: relative;
             padding: 10px 0;
         }
         .wizard-step {
             flex: 1;
             text-align: center;
             position: relative;
         }
         .wizard-step a.btn {
             display: inline-flex;
             flex-direction: column;
             align-items: center;
             gap: 8px;
             background: transparent !important;
             border: none;
             color: var(--iq-body-text) !important;
             padding: 10px 15px;
             font-weight: 600;
             font-size: 14px;
             transition: all 0.3s ease;
             border-bottom: 3px solid transparent;
             border-radius: 0;
             width: 100%;
             box-shadow: none !important;
         }
         body.dark-theme .wizard-step a.btn {
             color: #b0b3b8 !important;
         }
         .wizard-step a.btn i {
             font-size: 22px;
             transition: all 0.3s ease;
         }
         .wizard-step.active a.btn, 
         .wizard-step a.btn.active {
             color: var(--iq-primary) !important;
             border-bottom: 3px solid var(--iq-primary) !important;
         }
         .wizard-step.active a.btn i {
             transform: scale(1.1);
             color: var(--iq-primary) !important;
         }

         /* Two-Column Grid Setup */
         .event-form-container {
             display: flex;
             flex-wrap: wrap;
             gap: 30px;
             width: 100%;
         }
         .form-side {
             flex: 1;
             min-width: 320px;
         }
         .preview-side {
             width: 380px;
             flex-shrink: 0;
         }
         @media (max-width: 991px) {
             .preview-side {
                 width: 100%;
             }
         }

         /* Sticky Preview Panel */
         .sticky-preview {
             position: sticky;
             top: 95px;
             padding-top: 15px;
         }
         .preview-badge-floating {
             position: absolute;
             top: 5px;
             left: 20px;
             background: linear-gradient(135deg, var(--iq-primary), #ff7675);
             color: white;
             padding: 4px 12px;
             font-size: 11px;
             font-weight: 700;
             border-radius: 20px;
             box-shadow: 0 4px 12px rgba(191, 23, 23, 0.25);
             z-index: 10;
             text-transform: uppercase;
             letter-spacing: 1px;
         }

         /* Mimic Design from event list card */
         .event-card {
             border-radius: 20px !important;
             overflow: hidden;
             border: 1px solid var(--iq-border-light) !important;
             transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1) !important;
             background: var(--iq-white);
             box-shadow: 0 10px 25px rgba(0, 0, 0, 0.03) !important;
             display: flex;
             flex-direction: column;
             height: 100%;
         }
         body.dark-theme .event-card {
             background: #242526 !important;
             border-color: #3a3b3c !important;
             box-shadow: 0 10px 35px rgba(0, 0, 0, 0.4) !important;
         }
         .event-img-container {
             position: relative;
             overflow: hidden;
             height: 220px;
             background: #e9ecef;
         }
         body.dark-theme .event-img-container {
             background: #2a2b2c;
         }
         .event-img-container img {
             width: 100%;
             height: 100%;
             object-fit: cover;
             transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
         }
         .event-card-overlay {
             position: absolute;
             bottom: 0;
             left: 0;
             right: 0;
             height: 60%;
             background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);
             pointer-events: none;
         }
         
         .badge-location {
             position: absolute;
             top: 15px;
             right: 15px;
             padding: 6px 12px;
             font-size: 11px;
             border-radius: 20px;
             font-weight: 600;
             background: rgba(0, 0, 0, 0.6);
             backdrop-filter: blur(8px);
             -webkit-backdrop-filter: blur(8px);
             color: #fff;
             border: 1px solid rgba(255, 255, 255, 0.1);
             z-index: 2;
         }
         .badge-category {
             position: absolute;
             top: 15px;
             left: 15px;
             padding: 6px 12px;
             font-size: 11px;
             border-radius: 20px;
             font-weight: 600;
             color: #fff;
             border: 1px solid rgba(255, 255, 255, 0.1);
             z-index: 2;
         }
         .event-card-body {
             padding: 24px !important;
             display: flex;
             flex-direction: column;
             flex-grow: 1;
         }
         .event-title {
             font-size: 19px;
             font-weight: 700;
             line-height: 1.3;
             color: var(--iq-title-text);
             margin-bottom: 8px;
         }
         body.dark-theme .event-title {
             color: #ffffff;
         }
         .event-desc {
             font-size: 13.5px;
             color: var(--iq-body-text);
             line-height: 1.5;
             margin-bottom: 20px;
             display: -webkit-box;
             -webkit-line-clamp: 2;
             -webkit-box-orient: vertical;
             overflow: hidden;
             text-overflow: ellipsis;
         }
         body.dark-theme .event-desc {
             color: #b0b3b8;
         }
         
         .event-details-box {
             background: var(--iq-light-secondary);
             border-radius: 12px;
             padding: 15px;
             margin-bottom: 20px;
             font-size: 13px;
             border: 1px solid var(--iq-border-light);
         }
         body.dark-theme .event-details-box {
             background: rgba(255, 255, 255, 0.02) !important;
             border-color: #3a3b3c !important;
         }
         .detail-item {
             display: flex;
             align-items: flex-start;
             margin-bottom: 10px;
             color: var(--iq-body-text);
         }
         body.dark-theme .detail-item {
             color: #b0b3b8;
         }
         .detail-item:last-child {
             margin-bottom: 0;
         }
         .detail-item i {
             font-size: 16px;
             margin-right: 12px;
             color: var(--iq-primary);
             flex-shrink: 0;
             margin-top: 2px;
         }
         .detail-item strong {
             color: var(--iq-title-text);
             margin-right: 5px;
         }
         body.dark-theme .detail-item strong {
             color: #fff;
         }
         .event-organizer {
             display: flex;
             align-items: center;
             border-top: 1px solid var(--iq-border-light);
             padding-top: 15px;
             margin-top: auto;
         }
         body.dark-theme .event-organizer {
             border-color: #3a3b3c;
         }
         .organizer-avatar {
             width: 32px;
             height: 32px;
             border-radius: 50%;
             object-fit: cover;
             margin-right: 10px;
             border: 2px solid var(--iq-primary);
         }
         .organizer-text {
             font-size: 12.5px;
             color: var(--iq-body-text);
         }
         body.dark-theme .organizer-text {
             color: #a1a1aa;
         }
         .organizer-text strong {
             color: var(--iq-title-text);
         }
         body.dark-theme .organizer-text strong {
             color: #fff;
         }
      </style>
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
   </head>
   <body class="right-column-fixed">
       <!-- loader Start -->
       <div id="loading">
          <div id="loading-center">
          </div>
       </div>
       <script>
           (function(){
               var loader = document.getElementById('loading');
               if (loader) {
                   window.addEventListener('load', function() {
                       setTimeout(function() {
                           loader.style.transition = 'opacity 0.5s ease';
                           loader.style.opacity = '0';
                           setTimeout(function() { loader.style.display = 'none'; }, 500);
                       }, 100);
                   });
                   setTimeout(function() {
                       if (loader.style.display !== 'none') {
                           loader.style.transition = 'opacity 0.5s ease';
                           loader.style.opacity = '0';
                           setTimeout(function() { loader.style.display = 'none'; }, 500);
                       }
                   }, 2500);
               }
           })();
       </script>
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
                            <div class="event-form-container">
                               <!-- Form Side -->
                               <div class="form-side">
                                  <div class="stepwizard mt-2">
                                     <div class="stepwizard-row setup-panel">
                                        <div id="user" class="wizard-step active">
                                           <a href="#user-detail" class="active btn">
                                              <i class="ri-folder-add-line text-primary"></i><span>Evento</span>
                                           </a>
                                        </div>
                                        <div id="document" class="wizard-step">
                                           <a href="#document-detail" class="btn btn-default" disabled="disabled">
                                              <i class="ri-calendar-event-line text-danger"></i><span>Horario</span>
                                           </a>
                                        </div>
                                        <div id="bank" class="wizard-step">
                                           <a href="#bank-detail" class="btn btn-default" disabled="disabled">
                                              <i class="ri-camera-fill text-success"></i><span>Foto</span>
                                           </a>
                                        </div>
                                        <div id="confirm" class="wizard-step">
                                           <a href="#cpnfirm-data" class="btn btn-default" disabled="disabled">
                                              <i class="ri-check-fill text-warning"></i><span>Finalizar Registro</span>
                                           </a>
                                        </div>
                                     </div>
                                  </div>
                                  
                                  <form id="form" class="form mt-4 needs-validation" novalidate method="POST" autocomplete="off" enctype="multipart/form-data">
                                     <!-- STEP 1: General Info -->
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
                                                    <textarea id="direccion_evento" name="direccion_evento" class="form-control" rows="3" maxlength="255" placeholder="Por favor ingrese la direcci&oacute;n exacta y detallada en d&oacute;nde se realizar&aacute; el evento." required="required"></textarea>
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
                                     
                                     <!-- STEP 2: Dates -->
                                     <div class="row setup-content" id="document-detail">
                                        <div class="col-sm-12">
                                           <div class="col-md-12 p-0">
                                              <h3 class="mb-4">Informaci&oacute;n Horaria:</h3>
                                              <div class="row">
                                                 <div class="col-md-6 form-group">
                                                    <label for="diainicio_evento" class="control-label">D&iacute;a / Hora de Inicio: *</label>
                                                    <input type="datetime-local" min="<?php echo substr(date('c'), 0, 19); ?>" max="<?php echo date('Y') ?>-12-31" id="diainicio_evento" name="diainicio_evento" onkeydown="return false"  class="form-control" required="required">
                                                    <div class="invalid-tooltip">
                                                       Fecha de inicio del evento requerido, complete este campo 
                                                    </div>
                                                    <div class="valid-tooltip">
                                                       Campo completado con &eacute;xito
                                                    </div>
                                                 </div>
                                                 <div class="col-md-6 form-group">
                                                    <label for="diafin_evento" class="control-label">D&iacute;a / Hora de Finalizaci&oacute;n: *</label>
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
                                     
                                     <!-- STEP 3: Image cover upload -->
                                     <div class="row setup-content" id="bank-detail">
                                        <div class="col-sm-12">
                                           <div class="col-md-12 p-0">
                                              <h3 class="mb-4">Fotograf&iacute;a del Evento:</h3>
                                              <div class="row">
                                                 <div class="col-md-12 form-group">
                                                    <label for="foto_evento" class="control-label">Adjunte una fotograf&iacute;a representativa al evento: *</label>
                                                    <input type="file" id="foto_evento" name="foto_evento" class="dropify" data-max-file-size="2M" data-max-width="1921" data-max-height="1081" data-min-height="301" accept="image/x-png,image/jpeg,image/jpg" required="required"  />
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
                                     
                                     <!-- STEP 4: Confirm and submit -->
                                     <div class="row setup-content" id="cpnfirm-data">
                                        <div class="col-sm-12">
                                           <div class="col-md-12 p-0">
                                              <div class="row justify-content-center text-center">
                                                 <div class="col-3 mb-3"> 
                                                    <img style="margin: 0 auto;" src="../vista/images/page-img/img-success.png" class="fit-image" alt="img-success">
                                                 </div>
                                                 <h5 class="mb-4 text-left w-100">¿<?php echo $_SESSION['nombre_usuario']; ?>, est&aacute;s seguro de registrar este evento? S&iacute; todo esta en orden y has completado todos los campos, haz clic en el bot&oacute;n para hacer efectiva tu petici&oacute;n y registrar el evento.</h5>
                                                 <button type="submit" id="enviar" class="btn btn-primary nextBtn btn-lg pull-right">Registrar Nuevo Evento</button>
                                              </div>
                                           </div>
                                        </div>
                                     </div>
                                  </form>
                               </div>
                               
                               <!-- Live Preview Side -->
                               <div class="preview-side">
                                  <div class="sticky-preview">
                                     <div class="preview-badge-floating"><i class="ri-eye-line"></i> Vista Previa en Vivo</div>
                                     
                                     <div class="event-card">
                                        <div class="event-img-container">
                                           <img id="preview-image" src="../vista/images/logo.png" alt="event-cover">
                                           <div class="event-card-overlay"></div>
                                           <span class="badge-category" id="preview-category" style="background: linear-gradient(135deg, #ec4899, #8b5cf6);">
                                               <i class="ri-sparkling-line" id="preview-category-icon"></i> <span id="preview-category-name">General</span>
                                           </span>
                                           <span class="badge-location">
                                               <i class="ri-map-pin-2-line"></i> <span id="preview-country"><?php echo $_SESSION['pais_usuarios']; ?></span>
                                           </span>
                                        </div>
                                        
                                        <div class="event-card-body">
                                           <h4 class="event-title text-truncate" id="preview-title">Nombre del Evento</h4>
                                           <p class="event-desc" id="preview-desc">Esta es una descripción corta de tu evento para que la comunidad se interese en asistir.</p>
                                           
                                           <div class="event-details-box">
                                              <div class="detail-item">
                                                 <i class="ri-map-pin-line"></i>
                                                 <span><strong>Lugar:</strong> <span id="preview-location">Dirección del evento</span></span>
                                              </div>
                                              <div class="detail-item">
                                                 <i class="ri-calendar-event-line"></i>
                                                 <span><strong>Inicio:</strong> <span id="preview-start">Fecha y hora de inicio</span></span>
                                              </div>
                                              <div class="detail-item">
                                                 <i class="ri-time-line"></i>
                                                 <span><strong>Fin:</strong> <span id="preview-end">Fecha y hora de finalización</span></span>
                                              </div>
                                           </div>
                                           
                                           <div class="event-organizer">
                                              <img src="../vista/images/fotosperfiles/<?php echo $_SESSION['fotos_perfiles'];?>" class="organizer-avatar" alt="organizer">
                                              <div class="organizer-text">
                                                 Organizado por <strong>@<?php echo $_SESSION['usuario_unico']; ?></strong>
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

       <script>
       // Loader Failsafe
       $(window).on('load', function() {
           $('#loading').fadeOut('slow');
       });
       $(document).ready(function() {
          function updatePreview() {
              // Title
              let title = $('#nombre_evento').val().trim();
              $('#preview-title').text(title ? title : 'Nombre del Evento');

              // Description
              let desc = $('#descripcion_evento').val().trim();
              $('#preview-desc').text(desc ? desc : 'Esta es una descripción corta de tu evento para que la comunidad se interese en asistir.');

              // Location
              let loc = $('#direccion_evento').val().trim();
              $('#preview-location').text(loc ? loc : 'Dirección del evento');

              // Date formatting helper
              function formatEventDate(val) {
                  if (!val) return null;
                  let date = new Date(val);
                  if (isNaN(date.getTime())) return null;
                  let day = String(date.getDate()).padStart(2, '0');
                  let meses = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
                  let mes = meses[date.getMonth()];
                  let hr = String(date.getHours()).padStart(2, '0');
                  let min = String(date.getMinutes()).padStart(2, '0');
                  return `${day} ${mes} | ${hr}:${min}`;
              }

              // Start Date
              let startVal = $('#diainicio_evento').val();
              let startText = formatEventDate(startVal);
              $('#preview-start').text(startText ? startText : 'Fecha y hora de inicio');

              // End Date
              let endVal = $('#diafin_evento').val();
              let endText = formatEventDate(endVal);
              $('#preview-end').text(endText ? endText : 'Fecha y hora de finalización');

              // Dynamic Category detection based on Title/Description
              let textForCategory = (title + ' ' + desc).toLowerCase();
              let category = {
                  name: 'General',
                  icon: 'ri-sparkling-line',
                  gradient: 'linear-gradient(135deg, #6b7280, #4b5563)'
              };

              if (/(concierto|musica|música|banda|recital|festival|show|canto|karaoke|dj|tocada)/i.test(textForCategory)) {
                  category = {
                      name: 'Música',
                      icon: 'ri-music-2-line',
                      gradient: 'linear-gradient(135deg, #ec4899, #8b5cf6)'
                  };
              } else if (/(fiesta|party|rumba|discoteca|cumpleaños|cumple|boda|celebracion|celebración|brindis|social)/i.test(textForCategory)) {
                  category = {
                      name: 'Fiesta',
                      icon: 'ri-cake-3-line',
                      gradient: 'linear-gradient(135deg, #f59e0b, #ef4444)'
                  };
              } else if (/(charla|conferencia|taller|curso|seminario|clase|webinar|educacion|educación|aprender|confe)/i.test(textForCategory)) {
                  category = {
                      name: 'Educación',
                      icon: 'ri-book-open-line',
                      gradient: 'linear-gradient(135deg, #3b82f6, #06b6d4)'
                  };
              } else if (/(deporte|partido|torneo|futbol|fútbol|basquet|básquet|maraton|maratón|carrera|gym|entrenamiento|running)/i.test(textForCategory)) {
                  category = {
                      name: 'Deporte',
                      icon: 'ri-football-line',
                      gradient: 'linear-gradient(135deg, #10b981, #3b82f6)'
                  };
              } else if (/(exposicion|exposición|museo|arte|teatro|obra|cine|pelicula|película|cultura|cultural)/i.test(textForCategory)) {
                  category = {
                      name: 'Cultura',
                      icon: 'ri-palette-line',
                      gradient: 'linear-gradient(135deg, #8b5cf6, #ec4899)'
                  };
              } else if (/(comida|cena|almuerzo|desayuno|gastronomia|gastronomía|restaurante|cafe|café|bebida|tragos|degustacion)/i.test(textForCategory)) {
                  category = {
                      name: 'Comida',
                      icon: 'ri-restaurant-line',
                      gradient: 'linear-gradient(135deg, #f97316, #eab308)'
                  };
              }

              // Apply Category UI changes
              $('#preview-category').css('background', category.gradient);
              $('#preview-category-icon').attr('class', category.icon);
              $('#preview-category-name').text(category.name);
          }

          // Input event listeners
          $('#nombre_evento, #descripcion_evento, #direccion_evento').on('input', updatePreview);
          $('#diainicio_evento, #diafin_evento').on('change', updatePreview);

          // Cover Image reader using FileReader
          $(document).on('change', '#foto_evento', function() {
              let input = this;
              if (input.files && input.files[0]) {
                  let reader = new FileReader();
                  reader.onload = function(e) {
                      $('#preview-image').attr('src', e.target.result);
                  }
                  reader.readAsDataURL(input.files[0]);
              }
          });

          // Dropify afterClear listener to reset image
          setTimeout(function() {
              let drEvent = $('#foto_evento').dropify();
              drEvent.on('dropify.afterClear', function(event, element) {
                  $('#preview-image').attr('src', '../vista/images/logo.png');
              });
          }, 500);

          // Run initially to format any values already filled
          updatePreview();
      });
      </script>
   </body>
</html>
<?php
/*SI UN USUARIO CON PERFIL INCOMPLETO INTENTA ACCEDER AL FEED DE LA APLICACION
SE LE BLOQUEA SU ACCESO Y DEBE OBLIGATORIAMENTE COMPLETAR SU PERFIL PARA PODER
ACCEDER A TODAS LAS FUNCIONES DE ESTA APLICACION*/
}else{header('location:../Controlador/cRegistroNuevosUsuarios.php?nuevoregistro=completarperfil');}
?>