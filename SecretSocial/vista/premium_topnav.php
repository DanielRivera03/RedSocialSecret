<?php
// Ensure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Make sure the connection exists (or is loadable)
if (!function_exists('crearNuevaConexion')) {
    require_once __DIR__ . '/../modelo/conexion.php';
}

$conectartopnav = crearNuevaConexion();

$id_usuario_session = $_SESSION['id_usuario'];

// 1. Get Friend Requests Count and List using the database view
$solicitudes_query = "SELECT * FROM vista_solicitudesamistad WHERE idsolicitudamigo = '$id_usuario_session' AND estado = 0";
$solicitudes_res = mysqli_query($conectartopnav, $solicitudes_query);

$solicitudes_count = 0;
$solicitudes_list = [];
if ($solicitudes_res) {
    $solicitudes_count = mysqli_num_rows($solicitudes_res);
    while ($row = mysqli_fetch_assoc($solicitudes_res)) {
        $solicitudes_list[] = $row;
    }
}

// 2. Get Notifications (Friendship Accepted) Count and List using the database view
$notif_query = "SELECT * FROM vista_notificacionesamigos WHERE id = '$id_usuario_session' ORDER BY fecha_notificacion DESC LIMIT 5";
$notif_res = mysqli_query($conectartopnav, $notif_query);

$notificaciones_list = [];
if ($notif_res) {
    while ($row = mysqli_fetch_assoc($notif_res)) {
        $notificaciones_list[] = $row;
    }
}

$notif_count_query = "SELECT COUNT(*) as total FROM vista_notificacionesamigos WHERE id = '$id_usuario_session'";
$notif_count_res = mysqli_query($conectartopnav, $notif_count_query);
$notif_count = 0;
if ($notif_count_res) {
    $row = mysqli_fetch_assoc($notif_count_res);
    $notif_count = $row['total'];
}

// Close connection immediately to prevent "Commands out of sync" with pages using multiple query sets
$conectartopnav->close();
?>
<input type="hidden" id="session-usuario-id" value="<?php echo $_SESSION['id_usuario']; ?>">
<input type="hidden" id="session-usuario-unico" value="<?php echo $_SESSION['usuario_unico']; ?>">
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
                  <div class="iq-search-bar" style="position: relative;">
                     <?php if (isset($_SESSION['comprobar_perfil']) && $_SESSION['comprobar_perfil'] == 1): ?>
                        <form action="#" class="searchbox">
                           <input type="text" class="text search-input" placeholder="Buscar en Secret..." disabled>
                        </form>
                     <?php else: ?>
                        <form action="../Buscador/resultados-busqueda" id="form-buscador-header" class="searchbox needs-validation" novalidate method="POST" autocomplete="off">
                           <input type="text" class="text search-input" id="input-buscador-header" name="buscador" placeholder="Buscar en Secret..." required>
                           <a class="search-link" href="#" id="btn-buscador-header"><i class="ri-search-line"></i></a>
                        </form>
                        <!-- Dropdown para resultados dinámicos estilo Facebook -->
                        <div id="dropdown-buscador-header" class="search-results-dropdown" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.15); z-index: 10000; max-height: 420px; overflow-y: auto; margin-top: 8px; padding: 10px 0;">
                        </div>
                     <?php endif; ?>
                  </div>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"  aria-label="Toggle navigation">
                  <i class="ri-menu-3-line"></i>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                     <ul class="navbar-nav ml-auto navbar-list">
                        <li>
                           <a href="<?php echo (isset($_SESSION['comprobar_perfil']) && $_SESSION['comprobar_perfil'] == 1) ? '#' : '../Perfil/' . $_SESSION['usuario_unico']; ?>" class="iq-waves-effect d-flex align-items-center">
                              <img src="../vista/images/fotosperfiles/<?php echo $_SESSION['fotos_perfiles'];?>" class="img-fluid rounded-circle mr-3" alt="user">
                              <div class="caption">
                                 <h6 class="mb-0 line-height"><?php echo $_SESSION['nombre_usuario'];?></h6>
                              </div>
                           </a>
                        </li>
                        <?php if (!isset($_SESSION['comprobar_perfil']) || $_SESSION['comprobar_perfil'] != 1): ?>
                        <li>
                           <a href="../Feed/inicio" class="iq-waves-effect d-flex align-items-center">
                           <i class="ri-home-line"></i>
                           </a>
                        </li>
                        <li class="nav-item">
                           <a class="search-toggle iq-waves-effect" href="#"><i class="ri-group-line"></i>
                              <span class="bg-danger dots" id="friend-requests-dot" <?php if ($solicitudes_count <= 0) echo 'style="display:none;"'; ?>></span>
                           </a>
                           <div class="iq-sub-dropdown iq-sub-dropdown-large">
                              <div class="iq-card shadow-none m-0">
                                 <div class="iq-card-body p-0 ">
                                    <div class="bg-primary p-3">
                                       <h5 class="mb-0 text-white">Solicitudes de Amigos<small class="badge  badge-light float-right pt-1" id="friend-requests-count-badge" <?php if ($solicitudes_count <= 0) echo 'style="display:none;"'; ?>><?php echo $solicitudes_count; ?></small></h5>
                                    </div>
                                    <!-- INICIO BANDERA -> SOLICITUDES DE AMIGOS -->
                                    <div id="friend-requests-dropdown-list">
                                    <?php 
                                       if (count($solicitudes_list) > 0) {
                                          foreach ($solicitudes_list as $filas) {
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
                                       } else {
                                          echo '<div class="text-center p-4 text-muted"><p class="mb-0">No tienes solicitudes pendientes</p></div>';
                                       }
                                    ?>
                                    </div>
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
                              <div id="lottie-beil" style="display: inline-flex; align-items: center; justify-content: center; vertical-align: middle;"><i class="ri-notification-3-line" style="font-size: 22px; line-height: 1; color: var(--iq-primary);"></i></div>
                              <span class="bg-danger dots" id="notifications-dot" <?php if ($notif_count <= 0) echo 'style="display:none;"'; ?>></span>
                           </a>
                           <div class="iq-sub-dropdown">
                              <div class="iq-card shadow-none m-0">
                                 <div class="iq-card-body p-0 ">
                                    <div class="bg-primary p-3">
                                       <h5 class="mb-0 text-white">Notificaciones<small class="badge  badge-light float-right pt-1" id="notifications-count-badge" <?php if ($notif_count <= 0) echo 'style="display:none;"'; ?>><?php echo $notif_count; ?></small></h5>
                                    </div>
                                    <div id="notifications-dropdown-list">
                                    <?php 
                                     // CONSULTA DE SOLICITUDES DE AMISTAD APROBADAS
                                       if (count($notificaciones_list) > 0) {
                                          foreach ($notificaciones_list as $filas) {
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
                                       } else {
                                          echo '<div class="text-center p-4 text-muted"><p class="mb-0">No hay notificaciones</p></div>';
                                       }
                                    ?>
                                    </div>
                                    <div class="text-center">
                                       <a href="../Notificaciones/<?php echo $_SESSION['usuario_unico']; ?>" class="mr-3 btn text-primary"><i class="ri-notification-3-fill"></i> Ver todas las notificaciones</a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </li>
                        <?php endif; ?>
                     <ul class="navbar-list">
                         <li class="nav-item">
                            <a href="#" id="dark-mode-toggle" class="iq-waves-effect d-flex align-items-center" style="font-size: 20px; padding: 0 15px; color: var(--iq-primary);">
                               <i class="ri-moon-line"></i>
                            </a>
                         </li>
                         <?php if (!isset($_SESSION['comprobar_perfil']) || $_SESSION['comprobar_perfil'] != 1): ?>
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
                         <?php else: ?>
                         <li>
                            <a href="../Salir/cerrarsesion" class="iq-waves-effect d-flex align-items-center" style="font-size: 16px; padding: 0 15px; color: var(--iq-primary);" title="Cerrar Sesión">
                               <i class="ri-login-box-line"></i> <span class="d-none d-lg-inline ml-1">Cerrar Sesión</span>
                            </a>
                         </li>
                         <?php endif; ?>
                      </ul>
                   </div>
                </nav>
             </div>
          </div>

<style>
/* Estilos Premium para el buscador estilo Facebook */
.search-results-dropdown {
    animation: slideDownFade 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes slideDownFade {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
.search-section-header {
    padding: 6px 16px 4px 16px !important;
    font-size: 11px !important;
    text-transform: uppercase !important;
    font-weight: 700 !important;
    color: #94a3b8 !important;
    letter-spacing: 0.5px !important;
    border-bottom: 1px solid #f1f5f9 !important;
    margin-bottom: 4px !important;
    font-family: 'Inter', sans-serif !important;
}
.search-result-item {
    display: flex !important;
    align-items: center !important;
    padding: 8px 16px !important;
    transition: all 0.2s ease !important;
    cursor: pointer !important;
    text-decoration: none !important;
    min-height: 52px !important;
    height: auto !important;
}
.search-result-item:hover {
    background-color: #f8fafc !important;
    text-decoration: none !important;
}
.search-result-avatar {
    width: 36px !important;
    height: 36px !important;
    border-radius: 50% !important;
    object-fit: cover !important;
    margin-right: 12px !important;
    margin-top: 0 !important;
    margin-bottom: 0 !important;
    flex-shrink: 0 !important;
    border: 2px solid #ffffff !important;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08) !important;
}
.search-result-info {
    display: flex !important;
    flex-direction: column !important;
    justify-content: center !important;
    flex-grow: 1 !important;
    margin: 0 !important;
    padding: 0 !important;
    line-height: 1.2 !important;
}
.search-result-name {
    font-weight: 600 !important;
    font-size: 13.5px !important;
    color: #1e293b !important;
    font-family: 'Inter', sans-serif !important;
    margin: 0 !important;
    padding: 0 !important;
    line-height: 1.2 !important;
}
.search-result-username {
    font-size: 11.5px !important;
    color: #64748b !important;
    font-family: 'Inter', sans-serif !important;
    margin: 2px 0 0 0 !important;
    padding: 0 !important;
    line-height: 1.2 !important;
}
.search-result-snippet {
    font-size: 12px !important;
    color: #475569 !important;
    font-family: 'Inter', sans-serif !important;
    margin: 3px 0 0 0 !important;
    padding: 0 !important;
    line-height: 1.3 !important;
    word-break: break-all !important;
}
.search-result-pub-meta {
    font-size: 11px !important;
    color: #94a3b8 !important;
    margin: 0 !important;
    padding: 0 !important;
    line-height: 1.2 !important;
}
.search-more-results {
    display: block !important;
    text-align: center !important;
    padding: 8px 16px !important;
    font-weight: 600 !important;
    font-size: 12.5px !important;
    color: #b92025 !important;
    background-color: #fef2f2 !important;
    margin: 4px 12px 0 12px !important;
    border-radius: 8px !important;
    transition: background-color 0.2s !important;
    text-decoration: none !important;
}
.search-more-results:hover {
    background-color: #fee2e2 !important;
    text-decoration: none !important;
}
.search-no-results {
    padding: 20px 16px !important;
    text-align: center !important;
    color: #64748b !important;
    font-size: 13px !important;
    font-family: 'Inter', sans-serif !important;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const inputBuscador = document.getElementById("input-buscador-header");
    const dropdownBuscador = document.getElementById("dropdown-buscador-header");
    const formBuscador = document.getElementById("form-buscador-header");
    const btnBuscador = document.getElementById("btn-buscador-header");
    let typingTimer;
    const doneTypingInterval = 300; // 300ms de retraso después de escribir

    if (!inputBuscador || !dropdownBuscador) return;

    // Ocultar dropdown al hacer click fuera
    document.addEventListener("click", function(e) {
        if (!inputBuscador.contains(e.target) && !dropdownBuscador.contains(e.target)) {
            dropdownBuscador.style.display = "none";
        }
    });

    // Mostrar dropdown al enfocar si hay texto
    inputBuscador.addEventListener("focus", function() {
        if (inputBuscador.value.trim().length > 0) {
            dropdownBuscador.style.display = "block";
        }
    });

    // Capturar teclado
    inputBuscador.addEventListener("input", function() {
        clearTimeout(typingTimer);
        const query = inputBuscador.value.trim();
        if (query.length > 0) {
            typingTimer = setTimeout(() => realizarBusquedaAJAX(query), doneTypingInterval);
        } else {
            dropdownBuscador.style.display = "none";
            dropdownBuscador.innerHTML = "";
        }
    });

    // Envío del buscador desde el botón de la lupa
    if (btnBuscador) {
        btnBuscador.addEventListener("click", function(e) {
            e.preventDefault();
            if (inputBuscador.value.trim() !== "") {
                formBuscador.submit();
            }
        });
    }

    function realizarBusquedaAJAX(query) {
        // Ejecutar petición AJAX al controlador
        const url = `../controlador/cRegistroNuevosUsuarios.php?nuevoregistro=peticion-buscador-ajax&query=${encodeURIComponent(query)}`;
        
        fetch(url)
            .then(response => response.json())
            .then(data => {
                dropdownBuscador.innerHTML = "";
                dropdownBuscador.style.display = "block";

                const users = data.users || [];
                const posts = data.posts || [];

                if (users.length === 0 && posts.length === 0) {
                    dropdownBuscador.innerHTML = `<div class="search-no-results">🔍 No se encontraron coincidencias para "${query}"</div>`;
                    return;
                }

                // 1. Mostrar Sección de Personas (Usuarios)
                if (users.length > 0) {
                    const header = document.createElement("div");
                    header.className = "search-section-header";
                    header.innerText = "Personas";
                    dropdownBuscador.appendChild(header);

                    users.forEach(user => {
                        const item = document.createElement("a");
                        item.className = "search-result-item";
                        item.href = `../Perfil/${user.usuario}`;
                        
                        const fotoperfil = user.fotoperfil ? `../vista/images/fotosperfiles/${user.fotoperfil}` : `../vista/images/fotosperfiles/usuarioblanco.png`;
                        
                        item.innerHTML = `
                            <img src="${fotoperfil}" class="search-result-avatar" alt="${user.nombres}">
                            <div class="search-result-info">
                                <span class="search-result-name">${user.nombres} ${user.apellidos}</span>
                                <span class="search-result-username">@${user.usuario}</span>
                            </div>
                        `;
                        dropdownBuscador.appendChild(item);
                    });
                }

                // 2. Mostrar Sección de Publicaciones
                if (posts.length > 0) {
                    const header = document.createElement("div");
                    header.className = "search-section-header";
                    header.innerText = "Publicaciones";
                    dropdownBuscador.appendChild(header);

                    posts.forEach(post => {
                        const item = document.createElement("a");
                        item.className = "search-result-item";
                        // Al hacer click, redirige a ver los resultados completos del término buscado
                        item.href = `../Buscador/resultados-busqueda?buscador=${encodeURIComponent(query)}`;
                        
                        const fotoperfil = post.fotoperfil ? `../vista/images/fotosperfiles/${post.fotoperfil}` : `../vista/images/fotosperfiles/usuarioblanco.png`;
                        
                        item.innerHTML = `
                            <img src="${fotoperfil}" class="search-result-avatar" alt="${post.nombres}">
                            <div class="search-result-info">
                                <span class="search-result-pub-meta">Publicado por <strong>${post.nombres} ${post.apellidos}</strong></span>
                                <span class="search-result-snippet">"${post.mensaje}"</span>
                            </div>
                        `;
                        dropdownBuscador.appendChild(item);
                    });
                }

                // Botón al final para ver más resultados completos
                const moreBtn = document.createElement("a");
                moreBtn.className = "search-more-results";
                moreBtn.href = "#";
                moreBtn.innerText = `Ver todos los resultados para "${query}"`;
                moreBtn.addEventListener("click", function(e) {
                    e.preventDefault();
                    formBuscador.submit();
                });
                dropdownBuscador.appendChild(moreBtn);
            })
            .catch(err => {
                console.error("Error al buscar:", err);
            });
    }
});
</script>
<script src="../vista/js/notificaciones-premium.js" defer></script>
<script src="../vista/js/push_notifications.js" defer></script>
