<?php
   $active_page = 'marketplace';
 
session_start();
// NO PERMITIR INGRESO SIN INICIAR SESION
if(!isset($_SESSION['nombre_usuario'])){
    header('location:../AccesoDenegado=restringido');
}
require('../modelo/conexion.php');
// INCLUIR ARCHIVOS REQUERIDOS PARA LA BARRA DE NAVEGACION
require('../modelo/mConteoPublicacionesPerfilPropietario.php');
require('../modelo/mModeloPublicaciones.php');

$Publicaciones = new PublicacionesUsuarios();
$IdUsuarios = $_SESSION['id_usuario'];
$IdSolicitudAmigo = $_SESSION['id_usuario'];

// CONSULTAR SOLICITUDES DE AMISTAD RECIBIDAS
$consulta = $Publicaciones->ConsultarSolicitudesAmistad($conectarsistema14, $IdSolicitudAmigo);
// CONSULTAR NOTIFICACIONES AMIGOS ACEPTADOS -> TODOS LOS USUARIOS
$consulta1 = $Publicaciones->ConsultarNotificacionesAmigos($conectarsistema16, $IdUsuarios);
?>
<!doctype html>
<html lang="es">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Secret - Marketplace</title>
      <!-- Favicon -->
      <link rel="apple-touch-icon" sizes="180x180" href="../vista/favicon/apple-touch-icon.png">
      <link rel="icon" type="image/png" sizes="32x32" href="../vista/favicon/favicon-32x32.png">
      <link rel="icon" type="image/png" sizes="16x16" href="../vista/favicon/favicon-16x16.png">
      <link rel="manifest" href="../vista/favicon/site.webmanifest">
      <link rel="mask-icon" href="../vista/favicon/safari-pinned-tab.svg" color="#5bbad5">
      <meta name="msapplication-TileColor" content="#da532c">
      <meta name="theme-color" content="#ffffff">
      <!-- Google Fonts -->
      <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="../vista/css/bootstrap.min.css">
      <!-- Typography CSS -->
      <link rel="stylesheet" href="../vista/css/typography.css">
      <!-- Style CSS -->
      <link rel="stylesheet" href="../vista/css/style.css">
      <!-- Responsive CSS -->
      <link rel="stylesheet" href="../vista/css/responsive.css">
      <!-- Remix Icons -->
      <link href="https://cdn.jsdelivr.net/npm/remixicon@2.2.0/fonts/remixicon.css" rel="stylesheet">
      <!-- Leaflet CSS -->
      <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
      <!-- Alerts -->
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
      <style>
          body, input, textarea, button, select, label {
              font-family: 'Montserrat', sans-serif !important;
          }
          h1, h2, h3, h4, h5, h6, .card-title {
              font-family: 'Poppins', sans-serif !important;
          }
         /* Two-Column Grid Setup */
         .marketplace-layout {
             display: flex;
             flex-wrap: wrap;
             gap: 30px;
             width: 100%;
         }
         .sidebar-panel {
             width: 360px;
             flex-shrink: 0;
         }
         .main-panel {
             flex: 1;
             min-width: 320px;
         }
         @media (max-width: 991px) {
             .sidebar-panel {
                 width: 100%;
             }
         }

         /* Premium Cards Styling */
         .premium-card {
             border-radius: 20px !important;
             border: 1px solid var(--iq-border-light) !important;
             background: var(--iq-white) !important;
             box-shadow: 0 10px 25px rgba(0, 0, 0, 0.03) !important;
             transition: all 0.3s ease;
             overflow: hidden;
         }
         body.dark-theme .premium-card {
             border-color: #3a3b3c !important;
             background: #242526 !important;
             box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3) !important;
         }

         /* Form Styles */
         .form-group label {
             font-weight: 600;
             color: var(--iq-title-text);
             margin-bottom: 8px;
             font-size: 13.5px;
         }
         body.dark-theme .form-group label {
             color: #e4e6eb;
         }
         .form-control {
             border-radius: 12px !important;
             height: 46px;
             border: 1px solid var(--iq-border-light) !important;
             padding: 10px 16px !important;
             font-size: 14px;
             transition: all 0.3s ease;
         }
         body.dark-theme .form-control {
             background-color: #3a3b3c !important;
             border-color: #4e4f50 !important;
             color: #e4e6eb !important;
         }
         .form-control:focus {
             box-shadow: 0 0 0 3px rgba(191, 23, 23, 0.15) !important;
             border-color: var(--iq-primary) !important;
         }

         /* Leaflet Map Styling */
         #map-picker, #main-map {
             border: 1px solid var(--iq-border-light);
             box-shadow: 0 4px 15px rgba(0,0,0,0.02);
             overflow: hidden;
         }
         body.dark-theme #map-picker,
         body.dark-theme #main-map {
             border-color: #3a3b3c;
             filter: invert(90%) hue-rotate(180deg) brightness(95%) contrast(90%);
         }

         /* Custom File Input */
         .custom-file-btn {
             display: block;
             width: 100%;
             padding: 12px;
             border: 2px dashed var(--iq-border-light);
             border-radius: 12px;
             text-align: center;
             cursor: pointer;
             transition: all 0.3s ease;
             background: rgba(0,0,0,0.01);
         }
         body.dark-theme .custom-file-btn {
             border-color: #3a3b3c;
             background: rgba(255,255,255,0.01);
         }
         .custom-file-btn:hover {
             border-color: var(--iq-primary);
             background: rgba(191, 23, 23, 0.05);
         }
         .custom-file-btn i {
             font-size: 24px;
             color: var(--iq-primary);
             display: block;
             margin-bottom: 5px;
         }
         .custom-file-btn span {
             font-size: 13px;
             font-weight: 500;
             color: var(--iq-body-text);
         }

         /* Product Grid Cards */
         .product-grid-card {
             border-radius: 18px !important;
             overflow: hidden;
             border: 1px solid var(--iq-border-light) !important;
             background: var(--iq-white);
             box-shadow: 0 8px 20px rgba(0, 0, 0, 0.02) !important;
             transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1) !important;
             height: 100%;
             cursor: pointer;
             display: flex;
             flex-direction: column;
         }
         body.dark-theme .product-grid-card {
             background: #242526 !important;
             border-color: #3a3b3c !important;
             box-shadow: 0 8px 25px rgba(0, 0, 0, 0.35) !important;
         }
         .product-grid-card:hover {
             transform: translateY(-6px);
             box-shadow: 0 16px 30px rgba(0,0,0,0.06) !important;
             border-color: rgba(191, 23, 23, 0.15) !important;
         }
         body.dark-theme .product-grid-card:hover {
             box-shadow: 0 16px 35px rgba(0,0,0,0.45) !important;
             border-color: rgba(255, 118, 117, 0.25) !important;
         }

         .product-img-wrapper {
             position: relative;
             height: 180px;
             overflow: hidden;
             background: #f1f2f1;
         }
         body.dark-theme .product-img-wrapper {
             background: #1e1f20;
         }
         .product-img-wrapper img {
             width: 100%;
             height: 100%;
             object-fit: cover;
             transition: transform 0.5s ease;
         }
         .product-grid-card:hover .product-img-wrapper img {
             transform: scale(1.05);
         }

         .product-price-badge {
             position: absolute;
             bottom: 12px;
             left: 12px;
             background: var(--iq-primary);
             color: white;
             padding: 5px 14px;
             font-size: 13.5px;
             font-weight: 700;
             border-radius: 30px;
             box-shadow: 0 4px 10px rgba(191, 23, 23, 0.3);
             z-index: 2;
         }

         .product-info {
             padding: 16px !important;
             display: flex;
             flex-direction: column;
             flex-grow: 1;
         }
         .product-title {
             font-size: 15.5px;
             font-weight: 700;
             color: var(--iq-title-text);
             margin-bottom: 6px;
             line-height: 1.3;
         }
         body.dark-theme .product-title {
             color: #e4e6eb;
         }
         .product-location {
             font-size: 12.5px;
             color: var(--iq-body-text);
             display: flex;
             align-items: center;
             gap: 6px;
             margin-top: auto;
         }
         body.dark-theme .product-location {
             color: #a1a1aa;
         }

         /* Premium Modal Styling */
         .premium-modal .modal-content {
             border-radius: 24px;
             border: none;
             overflow: hidden;
             background: var(--iq-white);
             box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
         }
         body.dark-theme .premium-modal .modal-content {
             background: #242526;
         }
         .premium-modal .modal-header {
             border-bottom: 1px solid var(--iq-border-light);
             padding: 20px 24px;
         }
         body.dark-theme .premium-modal .modal-header {
             border-color: #3a3b3c;
         }
         .premium-modal .modal-body {
             padding: 24px;
         }
         .modal-product-img {
             border-radius: 16px;
             width: 100%;
             height: 320px;
             object-fit: cover;
             border: 1px solid var(--iq-border-light);
         }
         body.dark-theme .modal-product-img {
             border-color: #3a3b3c;
         }
         .seller-card {
             background: var(--iq-light-secondary);
             border-radius: 16px;
             padding: 16px;
             display: flex;
             align-items: center;
             border: 1px solid var(--iq-border-light);
         }
         body.dark-theme .seller-card {
             background: rgba(255,255,255,0.02);
             border-color: #3a3b3c;
         }
         .seller-avatar {
             width: 44px;
             height: 44px;
             border-radius: 50%;
             object-fit: cover;
             border: 2px solid var(--iq-primary);
         }
      </style>
   </head>
   <body class="sidebar-main-active right-column-fixed">
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
               <div class="marketplace-layout">
                  
                  <!-- Form Side: Vender un artículo -->
                  <div class="sidebar-panel">
                     <div class="iq-card premium-card">
                        <div class="iq-card-header d-flex justify-content-between align-items-center">
                           <div class="iq-header-title">
                              <h4 class="card-title"><i class="ri-price-tag-3-line text-primary mr-1"></i> Vender un artículo</h4>
                           </div>
                        </div>
                        <div class="iq-card-body">
                           <form id="form-publicar-producto" action="javascript:void(0);" enctype="multipart/form-data">
                              <div class="form-group">
                                 <label>Título del artículo *</label>
                                 <input type="text" name="titulo" class="form-control" placeholder="¿Qué estás vendiendo?" required>
                              </div>
                              <div class="form-group">
                                 <label>Precio ($ USD) *</label>
                                 <input type="number" step="0.01" name="precio" class="form-control" placeholder="0.00" required>
                              </div>
                              <div class="form-group">
                                 <label>Ubicación (Ciudad) *</label>
                                 <input type="text" name="ciudad" id="ciudad-input" class="form-control" placeholder="Ej. San Salvador" required>
                              </div>
                              <div class="form-group">
                                  <label>Elige la ubicación exacta en el mapa <small class="text-muted font-weight-normal">(haz clic para mover el pin)</small></label>
                                  <div id="map-picker" style="height: 320px; width: 100%; border-radius:14px; margin-bottom: 8px; cursor: crosshair;"></div>
                                  <small class="text-muted d-block mb-1"><i class="ri-information-line"></i> Haz clic en cualquier punto del mapa para seleccionar la ubicación exacta</small>
                                  <input type="hidden" name="latitud" id="lat-input" value="13.6929">
                                  <input type="hidden" name="longitud" id="lng-input" value="-89.2182">
                               </div>
                              <div class="form-group">
                                 <label>Descripción detallada *</label>
                                 <textarea name="descripcion" class="form-control" rows="3" placeholder="Estado del producto, detalles de entrega..." required></textarea>
                              </div>
                              <div class="form-group">
                                 <label>Imagen del artículo *</label>
                                 <label class="custom-file-btn">
                                    <i class="ri-image-add-line"></i>
                                    <span id="file-label">Haz clic para subir una imagen</span>
                                    <input type="file" name="imagen" id="img-input" class="d-none" accept="image/*" required>
                                 </label>
                              </div>
                              <button type="submit" class="btn btn-primary w-100 btn-lg rounded-pill"><i class="ri-checkbox-circle-line"></i> Publicar Artículo</button>
                           </form>
                        </div>
                     </div>
                  </div>
                  
                  <!-- Main Panel: Grid & Map -->
                  <div class="main-panel">
                     <div class="iq-card premium-card">
                        <div class="iq-card-header d-flex justify-content-between align-items-center">
                           <div class="iq-header-title">
                              <h4 class="card-title"><i class="ri-map-pin-2-line text-primary mr-1"></i> Artículos Cerca de Ti</h4>
                           </div>
                        </div>
                        <div class="iq-card-body">
                           <div id="main-map" style="height: 450px; width: 100%; border-radius:16px; margin-bottom: 24px;"></div>
                           
                           <div class="row" id="productos-list">
                              <!-- Productos cargados por AJAX -->
                           </div>
                        </div>
                     </div>
                  </div>

               </div>
            </div>
         </div>
      </div>
      <!-- Wrapper END -->
      
      <!-- Modal Producto Rediseñado -->
      <div class="modal fade premium-modal" id="producto-modal" tabindex="-1" role="dialog">
         <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="producto-title" style="font-weight:700; font-size:18px;"></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-6 mb-4 mb-md-0">
                        <img id="producto-img" src="" class="modal-product-img">
                     </div>
                     <div class="col-md-6 d-flex flex-column">
                        <h2 class="text-primary font-weight-800 mb-2" id="producto-precio" style="font-size:28px;"></h2>
                        <p class="text-muted d-flex align-items-center gap-1 mb-3" style="font-size:13.5px;">
                           <i class="ri-map-pin-line text-primary"></i> <span id="producto-ciudad"></span>
                        </p>
                        <p id="producto-desc" style="font-size:14px; line-height:1.6; flex-grow:1;"></p>
                        
                        <div class="seller-card mt-4 mb-3">
                           <img id="producto-vendedor-foto" src="" class="seller-avatar mr-3">
                           <div>
                              <h6 class="m-0 font-weight-700" id="producto-vendedor"></h6>
                              <small class="text-muted">Vendedor en Secret</small>
                           </div>
                        </div>
                        <button class="btn btn-primary btn-lg w-100 rounded-pill send-msg-vendedor" data-id=""><i class="ri-message-3-line"></i> Enviar Mensaje Privado</button>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <script src="../vista/js/jquery.min.js"></script>
      <script src="../vista/js/popper.min.js"></script>
      <script src="../vista/js/bootstrap.min.js"></script>
      <!-- Custom JavaScript -->
      <script src="../vista/js/custom.js"></script>
      <!-- Leaflet JS -->
      <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
      <!-- Floating chat and alerts -->
      <script src="../vista/js/floating_chat.js"></script>
      <script src="../vista/js/alerta-solicitudesaceptadas.js"></script>
      <script src="../vista/js/alerta-eliminarsolicitudamistad.js"></script>
      
      <script>
      // Loader Failsafe
      $(window).on('load', function() {
          $('#loading').fadeOut('slow');
      });
      $(document).ready(function() {
          // File input preview label helper
          $('#img-input').on('change', function() {
              let fileName = $(this).val().split('\\').pop();
              if (fileName) {
                  $('#file-label').text('Imagen seleccionada: ' + fileName).css('color', 'var(--iq-primary)');
              } else {
                  $('#file-label').text('Haz clic para subir una imagen').css('color', 'var(--iq-body-text)');
              }
          });

          // Inicializar Mapa Picker
          var mapPicker = L.map('map-picker').setView([13.6929, -89.2182], 13);
          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
              attribution: '&copy; OpenStreetMap contributors'
          }).addTo(mapPicker);
          var marker = L.marker([13.6929, -89.2182], {draggable: true}).addTo(mapPicker);
          marker.bindPopup('<b>📍 Tu ubicación</b><br><small>Arrastra o haz clic en el mapa</small>').openPopup();

          // Actualizar coords al arrastrar
          marker.on('dragend', function () {
              var ll = marker.getLatLng();
              $('#lat-input').val(ll.lat.toFixed(6));
              $('#lng-input').val(ll.lng.toFixed(6));
              marker.setPopupContent('<b>📍 Tu ubicación</b><br><small>' + ll.lat.toFixed(5) + ', ' + ll.lng.toFixed(5) + '</small>').openPopup();
          });

          // Clic en el mapa picker para colocar el pin
          mapPicker.on('click', function(e) {
              var lat = e.latlng.lat;
              var lng = e.latlng.lng;
              marker.setLatLng([lat, lng]);
              $('#lat-input').val(lat.toFixed(6));
              $('#lng-input').val(lng.toFixed(6));
              marker.setPopupContent('<b>📍 Tu ubicación</b><br><small>' + lat.toFixed(5) + ', ' + lng.toFixed(5) + '</small>').openPopup();
          });
          
          // Inicializar Mapa Principal
          var mainMap = L.map('main-map').setView([13.6929, -89.2182], 9);
          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(mainMap);
          
          function cargarProductos() {
              $.ajax({
                  url: '../controlador/cMarketplace.php?accion=listar',
                  type: 'GET',
                  success: function(productos) {
                      let html = '';
                      // Limpiar marcadores anteriores
                      mainMap.eachLayer((layer) => {
                          if (layer instanceof L.Marker) {
                              layer.remove();
                          }
                      });
                      
                      productos.forEach(p => {
                          // Agregar marcador
                          let m = L.marker([p.latitud, p.longitud]).addTo(mainMap);
                          m.bindPopup('<b>'+p.titulo+'</b><br>$'+p.precio);
                          
                          // Agregar card
                          html += `
                          <div class="col-md-6 col-lg-4 mb-4">
                              <div class="product-grid-card" onclick="verProducto(${p.id})">
                                  <div class="product-img-wrapper">
                                      <img src="../vista/images/marketplace/${p.imagen}" alt="${p.titulo}">
                                      <span class="product-price-badge">$${p.precio}</span>
                                  </div>
                                  <div class="product-info">
                                      <h5 class="product-title text-truncate m-0">${p.titulo}</h5>
                                      <div class="product-location">
                                          <i class="ri-map-pin-line text-primary"></i> ${p.ciudad}
                                      </div>
                                  </div>
                              </div>
                          </div>
                          `;
                          
                          // Guardar data en global para el modal
                          window['prod_' + p.id] = p;
                      });
                      
                      if (productos.length === 0) {
                          html = `
                          <div class="col-12 text-center py-5">
                              <i class="ri-store-2-line" style="font-size:45px; opacity:0.3;"></i>
                              <h6 class="text-muted mt-2">No hay artículos publicados actualmente.</h6>
                          </div>`;
                      }
                      
                      $('#productos-list').html(html);
                  }
              });
          }
          
          window.verProducto = function(id) {
              let p = window['prod_' + id];
              $('#producto-title').text(p.titulo);
              $('#producto-precio').text('$' + p.precio);
              $('#producto-ciudad').text(p.ciudad);
              $('#producto-desc').text(p.descripcion);
              $('#producto-img').attr('src', '../vista/images/marketplace/' + p.imagen);
              $('#producto-vendedor').text(p.nombres + ' ' + p.apellidos);
              $('#producto-vendedor-foto').attr('src', '../vista/images/fotosperfiles/' + p.fotoperfil);
              $('.send-msg-vendedor').data('id', p.id_vendedor);
              $('#producto-modal').modal('show');
          };
          
          $('.send-msg-vendedor').click(function() {
              let id = $(this).data('id');
              $('#producto-modal').modal('hide');
              let nombre = $('#producto-vendedor').text();
              let foto = $('#producto-vendedor-foto').attr('src').split('/').pop();
              if(typeof abrirChat === 'function') {
                  abrirChat(id, nombre, foto);
              } else {
                  Swal.fire('Error', 'El chat privado flotante no está disponible en esta página.', 'error');
              }
          });
          
          $('#form-publicar-producto').submit(function(e) {
              let formData = new FormData(this);
              $.ajax({
                  url: '../controlador/cMarketplace.php?accion=publicar',
                  type: 'POST',
                  data: formData,
                  processData: false,
                  contentType: false,
                  success: function(res) {
                      if(res.status == 'OK') {
                          Swal.fire('Éxito', '¡Producto publicado correctamente en el Marketplace!', 'success');
                          $('#form-publicar-producto')[0].reset();
                          $('#file-label').text('Haz clic para subir una imagen').css('color', 'var(--iq-body-text)');
                          cargarProductos();
                      } else {
                          Swal.fire('Error', res.error || 'Error al publicar el producto.', 'error');
                      }
                  },
                  error: function() {
                      Swal.fire('Error', 'Error de conexión con el servidor.', 'error');
                  }
              });
          });
          
          cargarProductos();
      });
      </script>
   </body>
</html>
<?php 
// CIERRA CONEXIONES PARA LIBERAR MEMORIA
$conectarsistema->close();
$conectarsistema14->close();
$conectarsistema15->close();
$conectarsistema16->close();
$conectarsistema17->close();
?>
