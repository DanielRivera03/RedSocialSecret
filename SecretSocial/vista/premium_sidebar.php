<?php
// Determine the active item based on the active page variable
if (!isset($active_page)) {
    $active_page = '';
}
$usuario_unico_side = htmlspecialchars($_SESSION['usuario_unico'] ?? '', ENT_QUOTES, 'UTF-8');
?>
<!-- Sidebar  -->
<div class="iq-sidebar">
   <div id="sidebar-scrollbar">
      <nav class="iq-sidebar-menu">
         <ul id="iq-sidebar-toggle" class="iq-menu">
            <li class="<?php echo ($active_page === 'inicio') ? 'active' : ''; ?>">
               <a href="../Feed/inicio" class="iq-waves-effect"><i class="las la-newspaper"></i><span>Inicio</span></a>
            </li>
            <li class="<?php echo ($active_page === 'perfil') ? 'active' : ''; ?>">
               <a href="../Perfil/<?php echo $usuario_unico_side;?>" class="iq-waves-effect"><i class="las la-user"></i><span>Mi Perfil</span></a>
            </li>
            <li class="<?php echo ($active_page === 'amigos') ? 'active' : ''; ?>">
               <a href="../MisAmigos/explorar-amigos-aceptados" class="iq-waves-effect"><i class="las la-user-friends"></i><span>Mis Amigos</span></a>
            </li>
            <li class="<?php echo ($active_page === 'explorar-amigos') ? 'active' : ''; ?>">
               <a href="../Amigos/explorar-amigos" class="iq-waves-effect"><i class="las la-smile"></i><span>Explorar Amigos</span></a>
            </li>
            <li class="<?php echo ($active_page === 'notificaciones') ? 'active' : ''; ?>">
               <a href="../Notificaciones/<?php echo $usuario_unico_side; ?>" class="iq-waves-effect"><i class="las la-bell"></i><span>Mis Notificaciones</span></a>
            </li>
            <li class="<?php echo ($active_page === 'registrareventos') ? 'active' : ''; ?>">
               <a href="../EventosSociales/registrareventos" class="iq-waves-effect"><i class="las la-film"></i><span>Registrar Eventos</span></a>
            </li>
            <li class="<?php echo ($active_page === 'mostrareventos') ? 'active' : ''; ?>">
               <a href="../Eventos/mostrareventos" class="iq-waves-effect"><i class="las la-bullhorn"></i><span>Ver Eventos</span></a>
            </li>
            <li class="<?php echo ($active_page === 'mensajes') ? 'active' : ''; ?>">
               <a href="../ChatGeneral/mensajeria-secret" class="iq-waves-effect"><i class="lab la-rocketchat"></i><span>Mensajes</span></a>
            </li>
            <li class="<?php echo ($active_page === 'musica') ? 'active' : ''; ?>">
               <a href="../Videos/multimedia-secretvideos" class="iq-waves-effect"><i class="ri-play-circle-line"></i><span>M&uacute;sica Favorita</span></a>
            </li>
            <li class="<?php echo ($active_page === 'reels') ? 'active' : ''; ?>">
               <a href="../vista/reels.php" class="iq-waves-effect"><i class="las la-video"></i><span>Reels</span></a>
            </li>
            <li class="<?php echo ($active_page === 'marketplace') ? 'active' : ''; ?>">
               <a href="../vista/marketplace.php" class="iq-waves-effect"><i class="las la-store"></i><span>Marketplace</span></a>
            </li>
         </ul>
      </nav>
      <div class="p-3"></div>
   </div>
</div>
