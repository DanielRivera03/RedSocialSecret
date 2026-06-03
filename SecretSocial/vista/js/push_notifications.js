/**
 * SECRET SOCIAL — PUSH TOAST NOTIFICATIONS
 * Polls the live-notifications endpoint, displays dynamic glassmorphism popup alerts,
 * and rebuilds top navigation notification dropdowns in real-time.
 */

$(document).ready(function() {
    let displayedNotifs = new Set();
    
    // Initialize with existing notifications to avoid alerting old ones on load
    function initNotifications() {
        $.ajax({
            url: getControladorPath() + '?publicaciones=live-notifications',
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                if (res && res.status === 'OK' && Array.isArray(res.notifications)) {
                    res.notifications.forEach(n => {
                        displayedNotifs.add(n.id_notif);
                    });
                    updateDropdowns(res.notifications);
                }
            }
        });
    }

    // Check for new notifications
    function checkNotifications() {
        $.ajax({
            url: getControladorPath() + '?publicaciones=live-notifications',
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                if (res && res.status === 'OK' && Array.isArray(res.notifications)) {
                    let hasNew = false;
                    res.notifications.forEach(n => {
                        if (!displayedNotifs.has(n.id_notif)) {
                            displayedNotifs.add(n.id_notif);
                            showPushToast(n);
                            hasNew = true;
                        }
                    });
                    // Rebuild the dropdown HTML dynamically
                    updateDropdowns(res.notifications);
                }
            }
        });
    }

    // Rebuild HTML of both dropdowns dynamically
    function updateDropdowns(notifications) {
        if (!Array.isArray(notifications)) return;
        
        // 1. Rebuild Friend Requests Dropdown (type = solicitud_amistad)
        let friendRequests = notifications.filter(n => n.tipo === 'solicitud_amistad');
        let frDropdown = $('#friend-requests-dropdown-list');
        if (frDropdown.length) {
            if (friendRequests.length > 0) {
                let frHtml = '';
                friendRequests.forEach(req => {
                    frHtml += `
                    <div class="iq-friend-request">
                        <div class="iq-sub-card iq-sub-card-big d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="">
                                    <img class="avatar-40 rounded" src="../vista/images/fotosperfiles/${req.fotoperfil || 'usuarioblanco.png'}" alt="">
                                </div>
                                <div class="media-body ml-3">
                                    <h6 class="mb-0 ">${req.nombres} ${req.apellidos}</h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <a style="color: var(--iq-white);" id="aceptar-solicitudes" data-id="${req.actor_id}" class="mr-3 btn btn-primary rounded">Confirmar</a>
                                <a style="color: var(--iq-white);" id="rechazar-solicitudes" data-id="${req.id_notif.split('_')[1]}" class="mr-3 btn btn-secondary rounded">Rechazar</a>
                            </div>
                        </div>
                    </div>`;
                });
                frDropdown.html(frHtml);
            } else {
                frDropdown.html('<div class="text-center p-4 text-muted"><p class="mb-0">No tienes solicitudes pendientes</p></div>');
            }
        }
        
        // Update Friend Requests count badge & dot
        let frBadge = $('#friend-requests-count-badge');
        let frDot = $('#friend-requests-dot');
        if (frBadge.length) {
            if (friendRequests.length > 0) {
                frBadge.text(friendRequests.length).show();
                frDot.show();
            } else {
                frBadge.hide();
                frDot.hide();
            }
        }
        
        // 2. Rebuild All Notifications Dropdown (capped at last 15)
        let notifDropdown = $('#notifications-dropdown-list');
        if (notifDropdown.length) {
            // Re-order to make sure everything is sorted desc
            let activeNotifs = notifications.slice(0, 15);
            if (activeNotifs.length > 0) {
                let notifHtml = '';
                activeNotifs.forEach(notif => {
                    let dateFormatted = formatNotifDate(notif.fecha);
                    let href = '#';
                    if (notif.tipo === 'mensaje') {
                        href = '../ChatGeneral/mensajeria-secret';
                    } else if (notif.tipo === 'amigo' || notif.tipo === 'solicitud_amistad') {
                        href = '../Perfiles/' + notif.usuario + '=' + notif.actor_id;
                    } else if (notif.tipo === 'comentario' || notif.tipo === 'reaccion') {
                        href = '../Perfil/' + getLoggedUsername();
                    } else if (notif.tipo === 'reaccion_historia') {
                        href = '../Perfil/' + getLoggedUsername();
                    }
                    
                    notifHtml += `
                    <a href="${href}" class="iq-sub-card">
                        <div class="media align-items-center">
                            <div class="">
                                <img class="avatar-40 rounded" src="../vista/images/fotosperfiles/${notif.fotoperfil || 'usuarioblanco.png'}" alt="">
                            </div>
                            <div class="media-body ml-3">
                                <h6 class="mb-0 ">${notif.mensaje}</h6>
                                <small class="float-right font-size-12">${dateFormatted}</small>
                            </div>
                        </div>
                    </a>`;
                });
                notifDropdown.html(notifHtml);
            } else {
                notifDropdown.html('<div class="text-center p-4 text-muted"><p class="mb-0">No hay notificaciones</p></div>');
            }
        }
        
        // Update Notifications count badge & dot (exclude solicitudes de amistad to avoid double counts)
        let bellNotifications = notifications.filter(n => n.tipo !== 'solicitud_amistad');
        let notifBadge = $('#notifications-count-badge');
        let notifDot = $('#notifications-dot');
        if (notifBadge.length) {
            if (bellNotifications.length > 0) {
                notifBadge.text(bellNotifications.length).show();
                notifDot.show();
            } else {
                notifBadge.hide();
                notifDot.hide();
            }
        }
    }

    // Parse notification date
    function formatNotifDate(dateStr) {
        if (!dateStr) return '';
        try {
            let parts = dateStr.split(' ');
            let dateParts = parts[0].split('-');
            let timeParts = parts[1].split(':');
            
            let day = dateParts[2];
            let month = dateParts[1];
            let hours = timeParts[0];
            let minutes = timeParts[1];
            
            return day + '/' + month + ' | ' + hours + ':' + minutes;
        } catch(e) {
            return dateStr;
        }
    }

    // Helper to get correct relative path to controller
    function getControladorPath() {
        let loc = window.location.pathname;
        if (loc.includes('/vista/')) {
            return '../controlador/cPublicacionesUsuarios.php';
        } else {
            return '../controlador/cPublicacionesUsuarios.php';
        }
    }

    // Display a beautiful floating card toast
    function showPushToast(notif) {
        let title = notif.nombres + ' ' + notif.apellidos;
        let body = notif.mensaje;
        
        let typeMap = {
            'amigo': 'success',
            'comentario': 'info',
            'reaccion': 'warning',
            'mensaje': 'default',
            'solicitud_amistad': 'info',
            'reaccion_historia': 'warning'
        };
        
        let toastType = typeMap[notif.tipo] || 'default';
        
        // Show using SN library from notificaciones-premium.js
        if (window.SN) {
            window.SN.show(toastType, title, body, {
                duration: 5000,
                action: {
                    label: 'Ver',
                    fn: function() {
                        if (notif.tipo === 'mensaje') {
                            window.location.href = '../ChatGeneral/mensajeria-secret';
                        } else if (notif.tipo === 'amigo' || notif.tipo === 'solicitud_amistad') {
                            window.location.href = '../Perfiles/' + notif.usuario + '=' + notif.actor_id;
                        } else {
                            window.location.href = '../Notificaciones/' + getLoggedUsername();
                        }
                    }
                }
            });
        }
    }

    function getLoggedUsername() {
        return $('#session-usuario-unico').val() || $('#mi-id-usuario').val() || '';
    }

    // Run
    initNotifications();
    
    // Check every 10 seconds
    setInterval(checkNotifications, 10000);
});
