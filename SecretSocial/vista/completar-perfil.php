<?php
   session_start();
   // NO PERMITIR INGRESO SIN ENVIO DE PARAMETRO
   if(!isset($_GET['nuevoregistro'])){
      header('location:../AccesoDenegado=restringido');
   }
   // NO PERMITIR INGRESO SIN INICIAR SESION
   if(!isset($_SESSION['nombre_usuario'])){
      header('location:../AccesoDenegado=restringido');
   }
   // NO PERMITIR INGRESO SI EL PARAMETRO NO ES IGUAL
   if($_GET['nuevoregistro']!="completarperfil"){
      header('location:../AccesoDenegado=restringido');
   }
?>
<?php
// SOLO PERMITIR LA VISTA DE ESTA PAGINA A USUARIOS NUEVOS REGISTRADOS
// SI EL USUARIO DECIDE NO COMPLETAR ESTA SECCION, NO TENDRA ACCESO A NINGUNA
// PAGINA DEL RESTO DE ESTA RED SOCIAL HASTA COMPLETAR ESTA PAGINA.
if($_SESSION['comprobar_perfil']==1){
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
      <title>Secret - Completar Perfil</title>
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
      <!-- Google Fonts -->
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
      <!-- Alerts -->
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
      <style>
         body {
             font-family: 'Inter', sans-serif !important;
         }
         .nav-pills .nav-link {
             color: #64748b !important;
             transition: all 0.3s ease !important;
         }
         .nav-pills .nav-link.active {
             background: linear-gradient(135deg, #e53935, #b92025) !important;
             color: #ffffff !important;
             box-shadow: 0 4px 15px rgba(185, 32, 37, 0.2) !important;
         }
         .form-control:focus {
             border-color: #e53935 !important;
             box-shadow: 0 0 0 0.2rem rgba(229, 57, 53, 0.15) !important;
         }
      </style>
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
         <?php include __DIR__ . '/premium_topnav.php'; ?>
         <!-- Page Content  -->
         <div id="content-page" class="content-page">
            <div class="container">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="iq-card" style="border-radius: 12px !important; box-shadow: 0 8px 20px rgba(0,0,0,0.04) !important; border: 1px solid #eef2f6 !important; overflow: hidden !important; margin-bottom: 25px !important;">
                        <div class="iq-card-body p-0">
                           <div class="iq-edit-list">
                              <ul class="iq-edit-profile d-flex nav nav-pills" style="margin-bottom: 0 !important;">
                                 <li class="col-md-4 p-0">
                                    <a class="nav-link active" data-toggle="pill" id="informacionpersonal" href="#personal-information" style="border-radius: 0 !important; font-weight: 600 !important; padding: 18px !important; text-align: center !important;">
                                    Informaci&oacute;n Personal
                                    </a>
                                 </li>
                                 <li class="col-md-4 p-0">
                                    <a class="nav-link" data-toggle="pill" id="importante" href="#chang-pwd" style="border-radius: 0 !important; font-weight: 600 !important; padding: 18px !important; text-align: center !important;">
                                    📢 Importante 
                                    </a>
                                 </li>
                                 <li class="col-md-4 p-0">
                                    <a class="nav-link" data-toggle="pill" id="registrocancelar" href="#emailandsms" style="border-radius: 0 !important; font-weight: 600 !important; padding: 18px !important; text-align: center !important;">
                                    Cancelar Registro 
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
                           <div class="tab-pane fade active show" id="personal-information" role="tabpanel">
                              <div class="iq-card" style="border-radius: 16px !important; box-shadow: 0 10px 30px rgba(0,0,0,0.05) !important; border: 1px solid #eef2f6 !important; overflow: hidden !important;">
                                 <div class="iq-card-header d-flex justify-content-between">
                                    <div class="iq-header-title">
                                       <h4 class="card-title">Informaci&oacute;n Personal</h4>
                                    </div>
                                 </div>
                                 <div class="iq-card-body">
                                 <!-- ADVERTENCIA CUSTOM Y PROFESIONAL -->
                                 <div style="background: #fffbeb !important; border-left: 5px solid #d97706 !important; border-radius: 8px !important; padding: 20px !important; margin-bottom: 30px !important; box-shadow: 0 4px 12px rgba(217, 119, 6, 0.05) !important; display: flex !important; align-items: flex-start !important; text-align: left !important;">
                                    <div style="color: #d97706 !important; font-size: 24px !important; margin-right: 15px !important; line-height: 1 !important; margin-top: 2px !important;">
                                       <i class="ri-alert-line"></i>
                                    </div>
                                    <div style="flex: 1 !important;">
                                       <h5 style="color: #b45309 !important; font-weight: 700 !important; margin: 0 0 6px 0 !important; font-size: 16px !important;">Paso Requerido: Completa tu Información</h5>
                                       <p style="color: #451a03 !important; margin: 0 !important; font-size: 14px !important; line-height: 1.6 !important;">
                                          Estimado(a) <strong><?php echo htmlspecialchars($_SESSION['nombre_usuario'], ENT_QUOTES, 'UTF-8');?></strong>, le recordamos completar todos los campos del formulario. Es indispensable <strong>ingresar un nombre de usuario único disponible</strong> para poder habilitar su cuenta. De lo contrario, sus datos no podrán procesarse y deberá rellenar el formulario nuevamente.
                                       </p>
                                    </div>
                                 </div>
                                    <form id="form" class="mt-4 needs-validation" novalidate method="POST" autocomplete="off" enctype="multipart/form-data">
                                       <div class="form-group row align-items-center">
                                          <div class="col-md-12">
                                             <div class="profile-img-edit">
                                                <img class="profile-pic" src="../vista/images/fotosperfiles/<?php echo $_SESSION['fotos_perfiles'];?>" alt="Foto de perfil" data-toggle="tooltip" data-placement="right" title="Resoluci&oacute;n sugerida: 640x640 &Uacute;nicamente: .png / .jpg">
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
                                             <input type="text" class="form-control" id="nombre" name="nombre_usuario" value="<?php echo $_SESSION['nombre_usuario'];?>" required>
                                             <div class="invalid-tooltip">
                                                Nombre es requerido, complete este campo
                                             </div>
                                             <div class="valid-tooltip">
                                                Campo completado con &eacute;xito
                                             </div>
                                          </div>
                                          <div class="form-group col-sm-6">
                                             <label for="apellido">Apellido:</label>
                                             <input type="text" class="form-control mb-0" id="apellido" name="apellido_usuario" value="<?php echo $_SESSION['apellido_usuario'];?>" required>
                                             <div class="invalid-tooltip">
                                                Apellido es requerido, complete este campo
                                             </div>
                                             <div class="valid-tooltip">
                                                Campo completado con &eacute;xito
                                             </div>
                                          </div>
                                          <div class="form-group col-sm-6">
                                             <label for="usuariounico">Nombre de Usuario &Uacute;nico:</label>
                                             <input type="text" class="form-control" id="usuariounico" name="nombre_usuariounico" placeholder="Ingrese nombre de usuario &uacute;nico..." onBlur="comprobarUsuario()" data-toggle="tooltip" data-placement="bottom" title="Por favor, atienda la disponibilidad de su usuario" required>
                                             <span id="estadousuario"></span> 
                                             <p><img src="../vista/images/Spinner.svg" id="loaderIcon" style="display:none" /></p>
                                             <div class="invalid-tooltip">
                                                Nombre de usuario es requerido, complete este campo
                                             </div>
                                             <div class="valid-tooltip">
                                                Campo completado con &eacute;xito
                                             </div>
                                          </div>
                                          <div class="form-group col-sm-6">
                                             <label for="correo">Correo:</label>
                                             <input type="text" class="form-control" id="correo" name="correo_usuario" value="<?php echo $_SESSION['correo_usuario']; ?>" readonly required>
                                             <div class="invalid-tooltip">
                                                Correo es requerido, complete este campo
                                             </div>
                                             <div class="valid-tooltip">
                                                Campo completado con &eacute;xito
                                             </div>
                                          </div>
                                          <div class="form-group col-sm-6">
                                             <label class="d-block">G&eacute;nero:</label>
                                             <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="customRadio6" name="genero_usuarios" class="custom-control-input" checked="" value="m">
                                                <label class="custom-control-label" for="customRadio6"> Hombre </label>
                                             </div>
                                             <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="customRadio7" name="genero_usuarios" class="custom-control-input" value="f">
                                                <label class="custom-control-label" for="customRadio7"> Mujer </label>
                                             </div>
                                             <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="customRadio8" name="genero_usuarios" class="custom-control-input" value="i">
                                                <label class="custom-control-label" for="customRadio8"> Prefiero no decirlo </label>
                                             </div>
                                          </div>
                                          <div class="form-group col-sm-6">
                                             <label>Pa&iacute;s:</label>
                                             <select class="form-control" id="pais" name="pais_residenciausuario" required>
                                                <option value="">Seleccione un pa&iacute;s...</option>
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
                                             <input type="text" class="form-control" id="ciudad" name="ciudad_residenciausuario" placeholder="Ingrese el nombre de su ciudad..." required>
                                             <div class="invalid-tooltip">
                                                Ciudad es requerido, complete este campo
                                             </div>
                                             <div class="valid-tooltip">
                                                Campo completado con &eacute;xito
                                             </div>
                                          </div>
                                          <div class="form-group col-sm-6">
                                             <label for="telefono">Tel&eacute;fono:</label>
                                             <input type="tel" class="form-control" id="telefono" name="telefono_usuario" placeholder="Ingrese su n&uacute;mero de tel&eacute;fono.." required>
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
                                                <option value="">Seleccione una opci&oacute;n...</option>
                                                <option value="0">Perfil p&uacute;blico</option>
                                                <option value="1">Perfil privado</option>
                                             </select>
                                             <div class="invalid-tooltip">
                                                Privacidad de perfil es requerido, complete este campo
                                             </div>
                                             <div class="valid-tooltip">
                                                Campo completado con &eacute;xito
                                             </div>
                                          </div>
                                          <div class="form-group col-sm-6">
                                             <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                                             <div class="custom-control custom-checkbox d-inline-block mt-2 pt-1" style="width: 100%; padding-left: 0;">
                                                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" min="1940-01-01" max="<?php $CalculoEdad = date('Y') - 18; echo $CalculoEdad; ?>-12-31" onkeydown="return false" required>
                                                <div class="invalid-tooltip">
                                                   Fecha de Nacimiento requerido, complete este campo 
                                                </div>
                                                <div class="valid-tooltip">
                                                   Campo completado con &eacute;xito
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <button type="submit" id="enviar_registro" class="btn btn-primary mr-2" style="background: linear-gradient(135deg, #e53935, #b92025) !important; border: none !important; font-weight: 600 !important; padding: 10px 24px !important; border-radius: 30px !important; box-shadow: 0 4px 12px rgba(185, 32, 37, 0.15) !important;">Enviar Datos</button>
                                    </form>
                                 </div>
                              </div>
                           </div>
                           <div class="tab-pane fade" id="chang-pwd" role="tabpanel">
                              <div class="iq-card" style="border-radius: 16px !important; box-shadow: 0 10px 30px rgba(0,0,0,0.05) !important; border: 1px solid #eef2f6 !important; overflow: hidden !important;">
                                 <div class="iq-card-header d-flex justify-content-between">
                                    <div class="iq-header-title">
                                       <h4 class="card-title">Aspectos a tomar en cuenta:</h4>
                                    </div>
                                 </div>
                                 <div class="iq-card-body">
                                    <form>
                                       <p>Estimado(a) <?php echo $_SESSION['nombre_usuario'];?>, nosotros como Secret nos tomamos muy en serio la seguridad de nuestros
                                       usuarios, por lo cual le invitamos a que complete su perfil de usuario, as&iacute; nos aseguramos de que usted es una persona real
                                       y que har&aacute; un buen uso de nuestra plataforma. Si por alguna raz&oacute;n o circunstancia usted decide no completar esta secci&oacute;n, lamentablemente le informamos que usted <span style="color: #F00;">no podr&aacute; hacer uso de nuestra plataforma hasta que complete su perfil de usuario.</span> Si usted desea cancelar el registro, por favor haga clic en el bot&oacute;n <strong>"Cancelar Registro"</strong> para ser redirigido a un formulario especial en donde usted expondr&aacute; los motivos del por qu&eacute; no concluy&oacute; su registro y posteriormente liberar su usuario de nuestro sistema, asegurando su eliminaci&oacute;n de nuestra base de datos.</p>
                                       <img style="display: block; margin: auto;" src="../vista/images/logo.png" class="img-fluid" alt="">
                                       <h4 style="text-align: center;">Atte: El equipo de Secret&reg;</h4>
                                    </form>
                                 </div>
                              </div>
                           </div>
                           <div class="tab-pane fade" id="emailandsms" role="tabpanel">
                              <div class="iq-card" style="border-radius: 16px !important; box-shadow: 0 10px 30px rgba(0,0,0,0.05) !important; border: 1px solid #eef2f6 !important; overflow: hidden !important;">
                                 <div class="iq-card-header d-flex justify-content-between">
                                    <div class="iq-header-title">
                                       <h4 class="card-title">Cancelaci&oacute;n de Registro</h4>
                                    </div>
                                 </div>
                                 <div class="iq-card-body">
                                    <form id="cancelar_registro" class="mt-4 needs-validation" novalidate method="POST" autocomplete="off">
                                       <div class="form-group row align-items-center">
                                          <div class="col-md-12">
                                             <!-- ADVERTENCIA DE CANCELACION CUSTOM Y PROFESIONAL -->
                                             <div style="background: #fef2f2 !important; border-left: 5px solid #dc2626 !important; border-radius: 8px !important; padding: 20px !important; margin-bottom: 30px !important; box-shadow: 0 4px 12px rgba(220, 38, 38, 0.05) !important; display: flex !important; align-items: flex-start !important; text-align: left !important;">
                                                <div style="color: #dc2626 !important; font-size: 24px !important; margin-right: 15px !important; line-height: 1 !important; margin-top: 2px !important;">
                                                   <i class="ri-information-line"></i>
                                                </div>
                                                <div style="flex: 1 !important;">
                                                   <h5 style="color: #991b1b !important; font-weight: 700 !important; margin: 0 0 6px 0 !important; font-size: 16px !important;">Atención: Cancelación de Registro</h5>
                                                   <p style="color: #7f1d1d !important; margin: 0 !important; font-size: 14px !important; line-height: 1.6 !important;">
                                                      Estimado(a) <strong><?php echo htmlspecialchars($_SESSION['nombre_usuario'], ENT_QUOTES, 'UTF-8');?></strong>, tenga en cuenta que al procesar este formulario, <strong>perderá el acceso a nuestra plataforma de forma inmediata y definitiva</strong>. Recibirá un correo de confirmación de baja en unos instantes. Mientras el proceso de eliminación concluye, no podrá registrarse nuevamente con este mismo correo. Si tiene alguna duda, puede contactarnos en <a href="mailto:soporte@secret.com" style="color: #dc2626 !important; text-decoration: underline !important; font-weight: bold !important;">soporte@secret.com</a>.
                                                   </p>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class=" row align-items-center">
                                          <div class="form-group col-sm-6">
                                             <label for="nombre">Nombre:</label>
                                             <input type="text" class="form-control" id="nombre" name="nombre_usuario" value="<?php echo $_SESSION['nombre_usuario'];?>" readonly required>
                                             <div class="invalid-tooltip">
                                                Nombre es requerido, complete este campo
                                             </div>
                                             <div class="valid-tooltip">
                                                Campo completado con &eacute;xito
                                             </div>
                                          </div>
                                          <div class="form-group col-sm-6">
                                             <label for="apellido">Apellido:</label>
                                             <input type="text" class="form-control mb-0" id="apellido" name="apellido_usuario" value="<?php echo $_SESSION['apellido_usuario'];?>" readonly required>
                                             <div class="invalid-tooltip">
                                                Apellido es requerido, complete este campo
                                             </div>
                                             <div class="valid-tooltip">
                                                Campo completado con &eacute;xito
                                             </div>
                                          </div>
                                          <div class="form-group col-sm-6">
                                             <label for="correo">Correo:</label>
                                             <input type="text" class="form-control" id="correo" name="correo_usuario" value="<?php echo $_SESSION['correo_usuario']; ?>" readonly required>
                                             <div class="invalid-tooltip">
                                                Correo es requerido, complete este campo
                                             </div>
                                             <div class="valid-tooltip">
                                                Campo completado con &eacute;xito
                                             </div>
                                          </div>
                                          <div class="form-group col-sm-6">
                                             <label for="motivo_cancelacion">Motivo Cancelaci&oacute;n:</label>
                                             <select class="form-control" id="motivo_cancelacion" name="motivo_cancelar" required>
                                                <option value="">Seleccione una opci&oacute;n...</option>
                                                <option value="No me siento seguro">No me siento seguro</option>
                                                <option value="No me gusta la plataforma">No me gusta la plataforma</option>
                                                <option value="No me parece &uacute;til Secret">No me parece &uacute;til Secret</option>
                                                <option value="Estoy perdiendo mi tiempo">Estoy perdiendo mi tiempo</option>
                                                <option value="Siento que no cumple mis espectativas">Siento que no cumple mis espectativas</option>
                                                <option value="Otra causa">Otra causa</option>
                                             </select>   
                                             <div class="invalid-tooltip">
                                                Motivo de cancelaci&oacute;n es requerido, complete este campo
                                             </div>
                                             <div class="valid-tooltip">
                                                Campo completado con &eacute;xito
                                             </div>
                                          </div>
                                          <div class="form-group col-sm-12">
                                             <label for="detalle_cancelacion">¿Cu&eacute;ntanos a detalle el motivo de tu selecci&oacute;n?:</label>
                                             <textarea class="form-control" id="detalle_cancelacion" name="detalle_cancelar" rows="5" placeholder="Puedes exponer tu caso completo aqu&iacute;... Si t&uacute; selecci&oacute;n fue 'Otra Causa' ¡Cu&eacute;ntanos! T&uacute; opini&oacute;n nos interesa mucho." maxlength="150" onpaste="ContadorCaracteresMaximo();" onkeyup="ContadorCaracteresMaximo();" required></textarea>
                                             <div id="respuesta_contador"></div>
                                             <p id="contador"></p>
                                             <div class="invalid-tooltip">
                                                Este campo es requerido, por favor complet&eacute;lo
                                             </div>
                                             <div class="valid-tooltip">
                                                Campo completado con &eacute;xito
                                             </div>
                                          </div>
                                       </div>
                                       <button type="submit" id="enviar_cancelacion" class="btn btn-primary mr-2" style="background: linear-gradient(135deg, #e53935, #b92025) !important; border: none !important; font-weight: 600 !important; padding: 10px 24px !important; border-radius: 30px !important; box-shadow: 0 4px 12px rgba(185, 32, 37, 0.15) !important;">Enviar Datos</button>
                                    </form>
                                 </div>
                              </div>
                           </div>
                           <div class="tab-pane fade" id="manage-contact" role="tabpanel">
                              <div class="iq-card">
                                 <div class="iq-card-header d-flex justify-content-between">
                                    <div class="iq-header-title">
                                       <h4 class="card-title"></h4>
                                    </div>
                                 </div>
                                 <div class="iq-card-body">
                                    <form>
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
                  </ul>
               </div>
               <div class="col-lg-6 text-right">
                  &copy; Copyright <?php echo date('Y'); ?> Secret&reg;
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
      <!-- Custom JavaScript -->
      <script src="../vista/js/custom.js"></script>
      <!-- Alerts -->
      <script src="../vista/js/jquery-2.1.4.min.js"></script>
      <script src="../vista/js/alerta_controlador.js"></script>
      <script src="../vista/js/duplicado.js"></script>
      <script src="../vista/js/contador_caracteres.js"></script>
      <script src="../vista/js/alerta_cancelacion.js"></script>
      <script src="../vista/js/tomar-fotos.js"></script>
      <script src="../vista/js/floating_chat.js"></script>
   </body>
</html>
<?php 
/*SI UN USUARIO CON PERFIL YA COMPLETO DESEA ACCEDER A ESTA SECCION
SE LE BLOQUEARA EL ACCESO Y TENDRA QUE HACERLO DE LA MANERA TRADICIONAL*/
}else{header('location:../Feed/inicio');}
?>