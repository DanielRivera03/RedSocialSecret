<?php
   $active_page = 'explorar-amigos';

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
      
      <!-- Rediseño Premium de Tarjetas de Amigos (Facebook Style) -->
      <style>
         .explore-user-card {
             background: #ffffff;
             border-radius: 16px;
             overflow: hidden;
             box-shadow: 0 8px 24px rgba(0, 0, 0, 0.04);
             transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
             position: relative;
             border: 1px solid rgba(0, 0, 0, 0.05);
             display: flex;
             flex-direction: column;
             height: 100%;
         }
         .explore-user-card:hover {
             transform: translateY(-6px);
             box-shadow: 0 16px 36px rgba(0, 0, 0, 0.1);
             border-color: rgba(234, 32, 39, 0.15);
         }
         .explore-cover-wrapper {
             position: relative;
             height: 120px;
             overflow: hidden;
             background: #e9ecef;
         }
         .explore-cover-img {
             width: 100%;
             height: 100%;
             object-fit: cover;
             transition: transform 0.5s ease;
         }
         .explore-user-card:hover .explore-cover-img {
             transform: scale(1.06);
         }
         .explore-cover-overlay {
             position: absolute;
             top: 0;
             left: 0;
             right: 0;
             bottom: 0;
             background: linear-gradient(180deg, rgba(0,0,0,0) 40%, rgba(0,0,0,0.3) 100%);
         }
         .explore-profile-content {
             padding: 20px;
             padding-top: 0;
             display: flex;
             flex-direction: column;
             align-items: center;
             flex-grow: 1;
             position: relative;
             background: inherit;
         }
         .explore-avatar-container {
             width: 90px;
             height: 90px;
             border-radius: 50%;
             border: 4px solid #ffffff;
             box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
             overflow: hidden;
             margin-top: -45px;
             z-index: 5;
             background: #ffffff;
             transition: transform 0.3s ease;
         }
         .explore-user-card:hover .explore-avatar-container {
             transform: scale(1.05);
         }
         .explore-avatar-img {
             width: 100%;
             height: 100%;
             object-fit: cover;
         }
         .explore-user-info {
             text-align: center;
             margin-top: 12px;
             width: 100%;
         }
         .explore-user-name {
             font-size: 1.05rem;
             font-weight: 700;
             color: #2d3748;
             margin-bottom: 2px;
             display: flex;
             align-items: center;
             justify-content: center;
             gap: 5px;
         }
         .explore-crown-icon {
             color: #ffd700;
             font-size: 0.95rem;
         }
         .explore-username {
             font-size: 0.88rem;
             color: #718096;
             font-weight: 500;
             margin-bottom: 8px;
         }
         .explore-location-badge {
             background: rgba(234, 32, 39, 0.05);
             padding: 5px 12px;
             border-radius: 20px;
             display: inline-flex;
             align-items: center;
             gap: 6px;
             margin-bottom: 15px;
             font-size: 0.8rem;
             color: #e53e3e;
             font-weight: 600;
             border: 1px solid rgba(234, 32, 39, 0.08);
         }
         .explore-location-badge img {
             border-radius: 2px;
             box-shadow: 0 1px 3px rgba(0,0,0,0.1);
         }
         .explore-actions {
             width: 100%;
             margin-top: auto;
             display: flex;
             flex-direction: column;
             gap: 10px;
         }
         .explore-status-badge {
             font-size: 0.8rem;
             font-weight: 700;
             padding: 7px 12px;
             border-radius: 8px;
             display: flex;
             align-items: center;
             justify-content: center;
             gap: 6px;
             text-transform: uppercase;
             letter-spacing: 0.5px;
         }
         .friend-status {
             background: rgba(40, 167, 69, 0.08);
             color: #28a745;
             border: 1px solid rgba(40, 167, 69, 0.15);
         }
         .pending-sent-status {
             background: rgba(255, 159, 67, 0.08);
             color: #ff9f43;
             border: 1px solid rgba(255, 159, 67, 0.15);
         }
         .pending-received-status {
             background: rgba(139, 92, 246, 0.08);
             color: #8b5cf6;
             border: 1px solid rgba(139, 92, 246, 0.15);
         }
         .explore-buttons-row {
             display: flex;
             gap: 8px;
             width: 100%;
         }
         .explore-buttons-row button, .explore-buttons-row a {
             flex: 1;
         }
         .btn-premium {
             padding: 8px 12px;
             border-radius: 10px;
             font-size: 0.85rem;
             font-weight: 600;
             border: none;
             cursor: pointer;
             transition: all 0.2s ease;
             display: inline-flex;
             align-items: center;
             justify-content: center;
             gap: 6px;
             text-decoration: none !important;
         }
         .btn-premium:active {
             transform: scale(0.96);
         }
         .btn-add {
             background: linear-gradient(135deg, #1877f2, #1565c0);
             color: #ffffff !important;
             box-shadow: 0 4px 10px rgba(24, 119, 242, 0.2);
         }
         .btn-add:hover {
             background: linear-gradient(135deg, #1565c0, #0d47a1);
             box-shadow: 0 6px 15px rgba(24, 119, 242, 0.3);
         }
         .btn-chat {
             background: linear-gradient(135deg, #28a745, #218838);
             color: #ffffff !important;
             box-shadow: 0 4px 10px rgba(40, 167, 69, 0.2);
         }
         .btn-chat:hover {
             background: linear-gradient(135deg, #218838, #1e7e34);
             box-shadow: 0 6px 15px rgba(40, 167, 69, 0.3);
         }
         .btn-profile {
             background: rgba(0, 0, 0, 0.05);
             color: #2d3748 !important;
         }
         .btn-profile:hover {
             background: rgba(0, 0, 0, 0.09);
         }
         .btn-cancel {
             background: linear-gradient(135deg, #ea2027, #c0392b);
             color: #ffffff !important;
             box-shadow: 0 4px 10px rgba(234, 32, 39, 0.2);
         }
         .btn-cancel:hover {
             background: linear-gradient(135deg, #c0392b, #a62c2b);
             box-shadow: 0 6px 15px rgba(234, 32, 39, 0.3);
         }
         .btn-confirm {
             background: linear-gradient(135deg, #1877f2, #1565c0);
             color: #ffffff !important;
             box-shadow: 0 4px 10px rgba(24, 119, 242, 0.2);
         }
         .btn-confirm:hover {
             background: linear-gradient(135deg, #1565c0, #0d47a1);
         }
         .btn-decline {
             background: rgba(0, 0, 0, 0.05);
             color: #2d3748 !important;
         }
         .btn-decline:hover {
             background: rgba(234, 32, 39, 0.08);
             color: #ea2027 !important;
         }

         /* Soporte Dark Mode */
         body.dark-mode .explore-user-card {
             background: #1f2a45 !important;
             border-color: rgba(255, 255, 255, 0.06);
             box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
         }
         body.dark-mode .explore-user-card:hover {
             border-color: rgba(234, 32, 39, 0.3);
             box-shadow: 0 16px 36px rgba(0, 0, 0, 0.35);
         }
         body.dark-mode .explore-avatar-container {
             border-color: #1f2a45;
             background: #1f2a45;
         }
         body.dark-mode .explore-user-name {
             color: #ffffff;
         }
         body.dark-mode .explore-username {
             color: #9ca3af;
         }
         body.dark-mode .btn-profile {
             background: rgba(255, 255, 255, 0.08);
             color: #e5e7eb !important;
         }
         body.dark-mode .btn-profile:hover {
             background: rgba(255, 255, 255, 0.15);
         }
         body.dark-mode .btn-decline {
             background: rgba(255, 255, 255, 0.08);
             color: #e5e7eb !important;
         }
         body.dark-mode .btn-decline:hover {
             background: rgba(234, 32, 39, 0.15);
             color: #fca5a5 !important;
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
                  <?php include __DIR__ . '/premium_sidebar.php'; ?>
         <?php include __DIR__ . '/premium_topnav.php'; ?>
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
                    $conn_check = crearNuevaConexion();
                    $id_sesion = $_SESSION['id_usuario'];

                    while($filas=mysqli_fetch_array($consulta)){
                       // NO MOSTRAR USUARIO QUE COINCIDA CON LA SESION INICIADA
                       if($filas['usuario']!=$_SESSION['usuario_unico']){
                           $id_otro = $filas['id'];

                           // 1. Check if already friends
                           $query_amigos = mysqli_query($conn_check, "SELECT 1 FROM amigos WHERE (id = $id_sesion AND idsolicitudamigo = $id_otro) OR (id = $id_otro AND idsolicitudamigo = $id_sesion) LIMIT 1");
                           $es_amigo = mysqli_num_rows($query_amigos) > 0;

                           // 2. Check if request sent from me is pending
                           $query_sol_enviada = mysqli_query($conn_check, "SELECT idsolicitudamistad FROM solicitudamistad WHERE id = $id_sesion AND idsolicitudamigo = $id_otro AND estado = 0 LIMIT 1");
                           $sol_enviada_row = mysqli_fetch_assoc($query_sol_enviada);
                           $sol_enviada = ($sol_enviada_row !== null);
                           $id_solicitud_enviada = $sol_enviada ? $sol_enviada_row['idsolicitudamistad'] : null;

                           // 3. Check if request received from them is pending
                           $query_sol_recibida = mysqli_query($conn_check, "SELECT idsolicitudamistad FROM solicitudamistad WHERE id = $id_otro AND idsolicitudamigo = $id_sesion AND estado = 0 LIMIT 1");
                           $sol_recibida_row = mysqli_fetch_assoc($query_sol_recibida);
                           $sol_recibida = ($sol_recibida_row !== null);
                           $id_solicitud_recibida = $sol_recibida ? $sol_recibida_row['idsolicitudamistad'] : null;
                   ?>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-4">
                            <div class="explore-user-card">
                                <!-- Cover Photo -->
                                <div class="explore-cover-wrapper">
                                    <img src="../vista/images/fotosportadas/<?php echo $filas['foto_portada']; ?>" alt="Cover" class="explore-cover-img">
                                    <div class="explore-cover-overlay"></div>
                                </div>
                                
                                <!-- Profile Content -->
                                <div class="explore-profile-content">
                                    <!-- Avatar overlapping cover -->
                                    <div class="explore-avatar-container">
                                        <img src="../vista/images/fotosperfiles/<?php echo $filas['fotoperfil']; ?>" alt="Avatar" class="explore-avatar-img">
                                    </div>
                                    
                                    <!-- User Info Details -->
                                    <div class="explore-user-info">
                                        <h4 class="explore-user-name">
                                            <i class="ri-vip-crown-2-line explore-crown-icon"></i>
                                            <?php echo $filas['nombres'] . ' ' . $filas['apellidos']; ?>
                                            <i class="ri-vip-crown-2-line explore-crown-icon"></i>
                                        </h4>
                                        <p class="explore-username">@<?php echo $filas['usuario']; ?></p>
                                        
                                        <!-- Resident Badge with Flag -->
                                        <div class="explore-location-badge">
                                            <span>
                                                <i class="ri-vip-crown-line"></i> Residente de: <?php echo $filas['pais']; ?>
                                            </span>
                                            <?php 
                                            // VALIDACION DE BANDERAS
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
                                            ?>
                                        </div>
                                    </div>
                                    
                                    <!-- Dynamic Action buttons based on Friendship status -->
                                    <div class="explore-actions">
                                        <?php if ($es_amigo): ?>
                                            <!-- Friends State -->
                                            <div class="explore-status-badge friend-status">
                                                <i class="las la-check-circle"></i> Ya son amigos
                                            </div>
                                            <div class="explore-buttons-row">
                                                <a href="../ChatGeneral/mensajeria-secret?abrirChat=<?php echo $filas['id']; ?>" class="btn-premium btn-chat">
                                                    <i class="lab la-rocketchat"></i> Enviar Mensaje
                                                </a>
                                                <a href="../Perfiles/<?php echo $filas['usuario']; ?>=<?php echo $filas['id']; ?>" class="btn-premium btn-profile">
                                                    <i class="las la-external-link-alt"></i> Perfil
                                                </a>
                                            </div>
                                        <?php elseif ($sol_enviada): ?>
                                            <!-- Request Sent State -->
                                            <div class="explore-status-badge pending-sent-status">
                                                <i class="las la-clock"></i> Solicitud pendiente
                                            </div>
                                            <div class="explore-buttons-row">
                                                <button class="btn-premium btn-cancel btn-cancelar-peticion" data-id="<?php echo $id_solicitud_enviada; ?>">
                                                    <i class="las la-user-times"></i> Cancelar
                                                </button>
                                                <a href="../Perfiles/<?php echo $filas['usuario']; ?>=<?php echo $filas['id']; ?>" class="btn-premium btn-profile">
                                                    <i class="las la-external-link-alt"></i> Perfil
                                                </a>
                                            </div>
                                        <?php elseif ($sol_recibida): ?>
                                            <!-- Request Received State -->
                                            <div class="explore-status-badge pending-received-status">
                                                <i class="las la-user-friends"></i> Te envió solicitud
                                            </div>
                                            <div class="explore-buttons-row">
                                                <button class="btn-premium btn-confirm btn-confirmar-peticion" data-id="<?php echo $filas['id']; ?>">
                                                    <i class="las la-user-check"></i> Aceptar
                                                </button>
                                                <button class="btn-premium btn-decline btn-rechazar-peticion" data-id="<?php echo $id_solicitud_recibida; ?>">
                                                    <i class="las la-user-minus"></i> Rechazar
                                                </button>
                                            </div>
                                            <div class="explore-buttons-row mt-1">
                                                <a href="../Perfiles/<?php echo $filas['usuario']; ?>=<?php echo $filas['id']; ?>" class="btn-premium btn-profile w-100 text-center">
                                                    <i class="las la-external-link-alt"></i> Ver Perfil
                                                </a>
                                            </div>
                                        <?php else: ?>
                                            <!-- No Relation State -->
                                            <div class="explore-buttons-row">
                                                <button class="btn-premium btn-add btn-agregar-amigo" data-id="<?php echo $filas['id']; ?>">
                                                    <i class="las la-user-plus"></i> Agregar
                                                </button>
                                                <a href="../Perfiles/<?php echo $filas['usuario']; ?>=<?php echo $filas['id']; ?>" class="btn-premium btn-profile">
                                                    <i class="las la-external-link-alt"></i> Perfil
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                   <?php
                       }
                    }// CIERRE while
                    $conn_check->close();
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
      <script src="../vista/js/floating_chat.js"></script>

      <!-- Manejo Interactivo de Acciones de Amistad (AJAX Local Premium) -->
      <script>
      $(document).ready(function() {
          // 1. Agregar amigo
          $(document).on('click', '.btn-agregar-amigo', function(e) {
              e.preventDefault();
              var idOtro = $(this).data('id');
              
              Swal.fire({
                  title: '¿Desea enviar solicitud de amistad?',
                  text: "El usuario recibirá tu solicitud de amistad.",
                  icon: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#1877f2',
                  cancelButtonColor: '#718096',
                  confirmButtonText: 'Confirmar',
                  cancelButtonText: 'Cancelar',
                  preConfirm: function() {
                      return new Promise(function(resolve, reject) {
                          $.ajax({
                              url: '../controlador/cRegistroNuevosUsuarios.php?nuevoregistro=registro-solicitud-amistad&idsolicitudamigo=' + idOtro,
                              type: 'POST',
                              dataType: 'json'
                          })
                          .done(function(respuesta) {
                              if (respuesta == "OK") {
                                  resolve("OK");
                              } else {
                                  resolve("ALREADY_SENT");
                              }
                          })
                          .fail(function() {
                              reject();
                          });
                      });
                  }
              }).then((result) => {
                  if (result.isConfirmed) {
                      if (result.value === "OK") {
                          Swal.fire({
                              title: 'Solicitud Enviada',
                              text: 'Tu solicitud de amistad ha sido enviada con éxito.',
                              icon: 'success',
                              timer: 1200,
                              showConfirmButton: false
                          });
                          setTimeout(function() {
                              location.reload();
                          }, 1200);
                      } else {
                          Swal.fire('Atención', 'Ya has enviado previamente una solicitud de amistad a este usuario.', 'warning');
                      }
                  }
              }).catch(() => {
                  Swal.fire('Error', 'No pudimos procesar tu solicitud en este momento. Intenta más tarde.', 'error');
              });
          });

          // 2. Cancelar petición / Rechazar solicitud
          $(document).on('click', '.btn-cancelar-peticion, .btn-rechazar-peticion', function(e) {
              e.preventDefault();
              var idSolicitud = $(this).data('id');
              var isDecline = $(this).hasClass('btn-rechazar-peticion');
              var title = isDecline ? '¿Desea rechazar esta solicitud?' : '¿Desea cancelar esta petición?';
              var text = isDecline ? 'Al hacerlo, rechazarás la solicitud de este usuario.' : 'Se cancelará el envío de la solicitud de amistad.';
              
              Swal.fire({
                  title: title,
                  text: text,
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#ea2027',
                  cancelButtonColor: '#718096',
                  confirmButtonText: 'Confirmar',
                  cancelButtonText: 'Cancelar',
                  preConfirm: function() {
                      return new Promise(function(resolve, reject) {
                          $.ajax({
                              url: '../controlador/cRegistroNuevosUsuarios.php?nuevoregistro=eliminar-solicitud-amistad&idsolicitudamigo=' + idSolicitud,
                              type: 'POST',
                              dataType: 'json'
                          })
                          .done(function(respuesta) {
                              resolve(respuesta);
                          })
                          .fail(function() {
                              reject();
                          });
                      });
                  }
              }).then((result) => {
                  if (result.isConfirmed && result.value === "OK") {
                      Swal.fire({
                          title: isDecline ? 'Solicitud Rechazada' : 'Petición Cancelada',
                          text: isDecline ? 'Has rechazado la solicitud con éxito.' : 'Has cancelado la petición de amistad.',
                          icon: 'success',
                          timer: 1200,
                          showConfirmButton: false
                      });
                      setTimeout(function() {
                          location.reload();
                      }, 1200);
                  }
              }).catch(() => {
                  Swal.fire('Error', 'No pudimos procesar tu solicitud en este momento. Intenta más tarde.', 'error');
              });
          });

          // 3. Confirmar solicitud recibida
          $(document).on('click', '.btn-confirmar-peticion', function(e) {
              e.preventDefault();
              var idOtro = $(this).data('id');
              
              Swal.fire({
                  title: '¿Desea aceptar la solicitud de amistad?',
                  text: 'Al confirmar, el usuario formará parte de tus amigos.',
                  icon: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#1877f2',
                  cancelButtonColor: '#718096',
                  confirmButtonText: 'Confirmar',
                  cancelButtonText: 'Cancelar',
                  preConfirm: function() {
                      return new Promise(function(resolve, reject) {
                          $.ajax({
                              url: '../controlador/cRegistroNuevosUsuarios.php?nuevoregistro=aceptar-solicitud-amistad&idsolicitudamigo=' + idOtro,
                              type: 'POST',
                              dataType: 'json'
                          })
                          .done(function(respuesta) {
                              resolve(respuesta);
                          })
                          .fail(function() {
                              reject();
                          });
                      });
                  }
              }).then((result) => {
                  if (result.isConfirmed && result.value === "OK") {
                      Swal.fire({
                          title: '¡Solicitud Aceptada!',
                          text: 'Ahora son amigos en Secret.',
                          icon: 'success',
                          timer: 1200,
                          showConfirmButton: false
                      });
                      setTimeout(function() {
                          location.reload();
                      }, 1200);
                  }
              }).catch(() => {
                  Swal.fire('Error', 'No pudimos procesar tu solicitud en este momento. Intenta más tarde.', 'error');
              });
          });
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