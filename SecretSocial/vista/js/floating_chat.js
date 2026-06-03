$(document).ready(function() {
    // Cargar notificaciones premium dinámicamente si no están disponibles
    if (!window.SN) {
        var scriptNotif = document.createElement('script');
        scriptNotif.src = '../vista/js/notificaciones-premium.js';
        document.head.appendChild(scriptNotif);
    }

    // Inject Custom Styles for Premium Look & Animations
    $('head').append(`
        <style>
            #chat-flotante-container {
                position: fixed;
                bottom: 0;
                right: 20px;
                z-index: 9999;
                display: flex;
                align-items: flex-end;
                pointer-events: none;
                font-family: 'Inter', sans-serif;
            }
            #chat-heads-container {
                position: fixed;
                bottom: 20px;
                right: 20px;
                z-index: 9999;
                display: flex;
                flex-direction: column;
                gap: 12px;
                pointer-events: auto;
            }
            .chat-head-bubble {
                width: 60px;
                height: 60px;
                border-radius: 50%;
                background: #fff;
                box-shadow: 0 4px 15px rgba(0,0,0,0.2);
                cursor: pointer;
                position: relative;
                transition: transform 0.2s;
                animation: popIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            }
            .chat-head-bubble:hover {
                transform: scale(1.1);
            }
            .chat-head-bubble img {
                width: 100%;
                height: 100%;
                border-radius: 50%;
                object-fit: cover;
                border: 2px solid #fff;
            }
            .chat-head-badge {
                position: absolute;
                top: -5px;
                right: -5px;
                background: #e53935;
                color: #fff;
                font-size: 12px;
                font-weight: bold;
                border-radius: 50%;
                width: 24px;
                height: 24px;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            }
            .chat-head-action-badge {
                position: absolute;
                bottom: -3px;
                right: -3px;
                width: 22px;
                height: 22px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 11px;
                border: 2px solid #fff;
                box-shadow: 0 2px 5px rgba(0,0,0,0.2);
                z-index: 5;
            }
            .badge-type-mensaje {
                background: linear-gradient(135deg, #8b5cf6, #6d28d9);
            }
            .badge-type-comentario {
                background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            }
            .badge-type-reaccion {
                background: linear-gradient(135deg, #ec4899, #db2777);
            }
            .badge-type-amigo {
                background: linear-gradient(135deg, #10b981, #059669);
            }
            @keyframes popIn {
                0% { transform: scale(0); opacity: 0; }
                100% { transform: scale(1); opacity: 1; }
            }
            
            /* Window Styles */
            .chat-ventana {
                width: 290px;
                background: #fff;
                border: 1px solid rgba(0,0,0,0.08);
                border-radius: 12px 12px 0 0;
                box-shadow: 0 -5px 25px rgba(0,0,0,0.12);
                display: flex;
                flex-direction: column;
                overflow: hidden;
                animation: slideUpChat 0.25s cubic-bezier(0.1, 0.8, 0.25, 1);
            }
            @keyframes slideUpChat {
                from { transform: translateY(100%); opacity: 0; }
                to { transform: translateY(0); opacity: 1; }
            }
            .chat-messages {
                height: 240px;
                overflow-y: auto;
                padding: 12px;
                background: #f8f9fa;
                font-size: 13px;
                display: flex;
                flex-direction: column;
                scrollbar-width: thin;
            }
            .chat-messages::-webkit-scrollbar {
                width: 4px;
            }
            .chat-messages::-webkit-scrollbar-thumb {
                background: #ccc;
                border-radius: 4px;
            }
            
            /* Typing dots animation */
            @keyframes typing-bounce {
                0%, 100% { transform: translateY(0); opacity: 0.4; }
                50% { transform: translateY(-4px); opacity: 1; }
            }
            .typing-dots span {
                display: inline-block;
                width: 6px;
                height: 6px;
                background: #888;
                border-radius: 50%;
                margin: 0 1px;
                animation: typing-bounce 1s infinite;
            }
            .typing-dots span:nth-child(2) { animation-delay: 0.2s; }
            .typing-dots span:nth-child(3) { animation-delay: 0.4s; }

            /* Incoming Call Modal Styles */
            #incoming-call-modal {
                position: fixed;
                top: 20px;
                right: 20px;
                width: 320px;
                background: #fff;
                border-radius: 16px;
                box-shadow: 0 10px 40px rgba(0,0,0,0.2);
                z-index: 10000;
                display: none;
                overflow: hidden;
                font-family: 'Inter', sans-serif;
                animation: slideInRight 0.3s cubic-bezier(0.1, 0.8, 0.25, 1);
            }
            @keyframes slideInRight {
                from { transform: translateX(120%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes pulse-ring {
                0% { transform: scale(0.8); opacity: 0.5; }
                100% { transform: scale(1.5); opacity: 0; }
            }
            .caller-avatar-wrapper {
                position: relative;
                width: 80px;
                height: 80px;
                margin: 20px auto 10px;
            }
            .caller-avatar-wrapper::before, .caller-avatar-wrapper::after {
                content: '';
                position: absolute;
                top: 0; left: 0; right: 0; bottom: 0;
                border-radius: 50%;
                border: 2px solid #b92025;
                animation: pulse-ring 2s infinite cubic-bezier(0.215, 0.61, 0.355, 1);
            }
            .caller-avatar-wrapper::after {
                animation-delay: 1s;
            }
            .caller-avatar {
                width: 100%;
                height: 100%;
                border-radius: 50%;
                object-fit: cover;
                position: relative;
                z-index: 2;
                box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            }
        </style>
    `);

    // Inyectar contenedor del chat en el body
    $('body').append(`
        <div id="chat-flotante-container">
            <div id="chat-ventanas-container" style="display: flex; gap: 12px; pointer-events: auto; margin-right: 80px;"></div>
        </div>
        <div id="chat-heads-container"></div>
        <audio id="chat-alert-sound" src="https://actions.google.com/sounds/v1/alarms/beep_short.ogg" preload="auto"></audio>

        <!-- Incoming Call Modal -->
        <div id="incoming-call-modal">
            <div style="background: linear-gradient(135deg, #b92025, #e53935); padding: 40px 20px 20px; text-align: center; color: white;">
                <h5 style="margin: 0; font-weight: 600; font-size: 16px;">Llamada Entrante</h5>
                <p id="incoming-call-type" style="margin: 5px 0 0; font-size: 13px; opacity: 0.9;">Videollamada de...</p>
                
                <div class="caller-avatar-wrapper">
                    <img id="incoming-call-avatar" src="" class="caller-avatar">
                </div>
                
                <h4 id="incoming-call-name" style="margin: 10px 0 0; font-weight: 700; font-size: 20px;">Nombre Apellido</h4>
            </div>
            <div style="display: flex; padding: 15px; background: #f8f9fa; gap: 10px;">
                <button id="btn-reject-call" class="btn btn-danger" style="flex: 1; border-radius: 30px; font-weight: 600; padding: 10px;">
                    <i class="ri-phone-fill" style="transform: rotate(135deg); display: inline-block;"></i> Rechazar
                </button>
                <button id="btn-accept-call" class="btn btn-success" style="flex: 1; border-radius: 30px; font-weight: 600; padding: 10px; background: #28a745; border-color: #28a745; color: white;">
                    <i class="ri-phone-fill"></i> Contestar
                </button>
            </div>
            <!-- Empty audio, just as placeholder if there's no actual file -->
            <audio id="incoming-call-audio" loop></audio>
        </div>
    `);

    // El header de amigos ya no existe

    // Lógica de Llamadas
    window.incomingCallActive = false;
    let currentCallId = null;

    function mostrarLlamadaEntrante(call) {
        if(window.incomingCallActive) return;
        window.incomingCallActive = true;
        currentCallId = call.id;
        
        $('#incoming-call-name').text(call.nombres + ' ' + call.apellidos);
        $('#incoming-call-avatar').attr('src', '../vista/images/fotosperfiles/' + call.fotoperfil);
        $('#incoming-call-type').text(call.tipo === 'video' ? 'Videollamada entrante...' : 'Llamada de voz entrante...');
        
        $('#incoming-call-modal').show();
        
        let audio = document.getElementById('incoming-call-audio');
        if(audio) {
            let playPromise = audio.play();
            if (playPromise !== undefined) {
                playPromise.catch(error => { console.log("Autoplay prevented"); });
            }
        }
    }

    function ocultarLlamadaEntrante() {
        if(!window.incomingCallActive) return;
        window.incomingCallActive = false;
        currentCallId = null;
        $('#incoming-call-modal').hide();
        let audio = document.getElementById('incoming-call-audio');
        if(audio) { audio.pause(); audio.currentTime = 0; }
    }

    $(document).on('click', '#btn-reject-call', function() {
        if(currentCallId) {
            $.post('../controlador/cChatPrivado.php?accion=update-call-status', { id_llamada: currentCallId, estado: 'rejected' }, function() {
                ocultarLlamadaEntrante();
            });
        }
    });

    $(document).on('click', '#btn-accept-call', function() {
        if(currentCallId) {
            $.post('../controlador/cChatPrivado.php?accion=update-call-status', { id_llamada: currentCallId, estado: 'accepted' }, function() {
                window.location.href = '../vista/llamada_activa.php?id=' + currentCallId;
            });
        }
    });

    let activeChats = {};
    let typingTimeouts = {};

    function cargarAmigos() {
        $.ajax({
            url: '../controlador/cChatPrivado.php?accion=cargar-amigos',
            type: 'GET',
            success: function(res) {
                let amigosList = res.amigos ? res.amigos : res;
                let html = '';
                if(!amigosList || amigosList.length === 0) {
                    html = '<p class="text-center mt-4 text-muted" style="font-size:12px;">No tienes amigos con los que chatear</p>';
                } else {
                    amigosList.forEach(a => {
                        let statusColor = a.estado === 'online' ? '#28a745' : '#adb5bd';
                        let lastMsgText = a.ultimo_mensaje ? a.ultimo_mensaje : 'Iniciar conversación';
                        
                        html += `
                            <div class="chat-amigo-item d-flex align-items-center p-2" data-id="${a.id}" data-nombre="${a.nombres} ${a.apellidos}" data-foto="${a.fotoperfil}" data-estado="${a.estado}" style="cursor:pointer; border-bottom:1px solid #f1f1f1;">
                                <div style="position:relative; flex-shrink:0;">
                                    <img src="../vista/images/fotosperfiles/${a.fotoperfil}" class="rounded-circle" width="38" height="38" style="object-fit:cover;">
                                    <span style="position:absolute; bottom:1px; right:1px; width:10px; height:10px; background:${statusColor}; border-radius:50%; border:2px solid #fff;"></span>
                                </div>
                                <div class="ml-2" style="flex:1; min-width:0;">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <h6 class="mb-0 text-truncate font-size-14 font-weight-bold" style="color:#222;">${a.nombres} ${a.apellidos}</h6>
                                    </div>
                                    <p class="mb-0 text-truncate text-muted font-size-12" style="max-width: 170px;">${lastMsgText}</p>
                                </div>
                            </div>
                        `;
                    });
                }
                $('#chat-amigos-body').html(html);
            }
        });
    }

    $(document).on('click', '.chat-amigo-item', function() {
        let id = $(this).data('id');
        let nombre = $(this).data('nombre');
        let foto = $(this).data('foto');
        let estado = $(this).data('estado');
        abrirChat(id, nombre, foto, estado);
    });

    function abrirChat(id, nombre, foto, estado) {
        if($('#chat-ventana-' + id).length > 0) return; // ya esta abierta

        // Limitar a máximo 2 chats flotantes abiertos al mismo tiempo para que quepa en pantalla
        let openChats = $('.chat-ventana');
        if(openChats.length >= 2) {
            $(openChats[0]).remove();
        }

        let statusColor = estado === 'online' ? '#28a745' : '#adb5bd';
        let statusText = estado === 'online' ? 'Activo ahora' : 'Desconectado';

        let html = `
            <div id="chat-ventana-${id}" class="chat-ventana" data-id="${id}">
                <div class="chat-header" style="background: linear-gradient(135deg, #b92025, #e53935); color: #fff; padding: 10px 12px; border-radius: 12px 12px 0 0; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                    <div style="display:flex; align-items:center; min-width:0;">
                        <div style="position:relative; display:inline-block;" class="mr-2 flex-shrink-0">
                            <img src="../vista/images/fotosperfiles/${foto}" class="rounded-circle" width="28" height="28" style="object-fit:cover;">
                            <span id="chat-header-status-dot-${id}" style="position:absolute; bottom:0; right:0; width:8px; height:8px; background:${statusColor}; border-radius:50%; border:1.5px solid #fff;"></span>
                        </div>
                        <div style="display:flex; flex-direction:column; line-height: 1.2; min-width:0;">
                            <span style="font-size:13px; font-weight:700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 140px;" title="${nombre}">${nombre}</span>
                            <span id="chat-header-status-text-${id}" style="font-size:9px; opacity:0.85; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${statusText}</span>
                        </div>
                    </div>
                    <i class="ri-close-line close-chat" data-id="${id}" style="cursor:pointer; font-size:18px; opacity:0.85; transition:opacity 0.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.85"></i>
                </div>
                <div class="chat-messages" id="chat-messages-${id}"></div>
                
                <!-- typing indicator bar -->
                <div class="typing-indicator-wrapper" id="typing-indicator-${id}" style="display: none; padding: 5px 12px; background: #f8f9fa; font-size: 11px; color: #666; border-top: 1px solid rgba(0,0,0,0.03); align-items: center; gap: 6px;">
                    <div class="typing-dots d-inline-flex">
                        <span></span><span></span><span></span>
                    </div>
                    <span>está escribiendo...</span>
                </div>
                
                <div class="chat-input" style="padding: 8px 10px; border-top: 1px solid #eee; background:#fff;">
                    <form class="chat-form d-flex align-items-center" data-id="${id}">
                        <input type="text" class="form-control form-control-sm msg-input" placeholder="Escribe un mensaje..." required style="border-radius:20px; border:1px solid #e0e0e0; padding:8px 14px; font-size:12.5px; height:32px;">
                        <button type="submit" class="btn btn-sm p-0 ml-2" style="background:none; border:none; color:#b92025; transition:transform 0.1s;" onmousedown="this.style.transform='scale(0.9)'" onmouseup="this.style.transform='scale(1)'"><i class="ri-send-plane-2-fill" style="font-size:19px;"></i></button>
                    </form>
                </div>
            </div>
        `;
        $('#chat-ventanas-container').append(html);
        cargarMensajes(id);
    }

    $(document).on('click', '.close-chat', function() {
        let id = $(this).data('id');
        // If typing, stop it
        if(typingTimeouts[id]) {
            clearTimeout(typingTimeouts[id]);
            $.post('../controlador/cChatPrivado.php?accion=set-typing', { id_amigo: id, status: 0 });
            delete typingTimeouts[id];
        }
        $('#chat-ventana-' + id).remove();
    });

    // Detect writing typing activity
    $(document).on('input', '.msg-input', function() {
        let idAmigo = $(this).closest('form').data('id');
        if (!typingTimeouts[idAmigo]) {
            $.post('../controlador/cChatPrivado.php?accion=set-typing', { id_amigo: idAmigo, status: 1 });
        }
        
        clearTimeout(typingTimeouts[idAmigo]);
        typingTimeouts[idAmigo] = setTimeout(function() {
            $.post('../controlador/cChatPrivado.php?accion=set-typing', { id_amigo: idAmigo, status: 0 });
            delete typingTimeouts[idAmigo];
        }, 3000);
    });

    $(document).on('submit', '.chat-form', function(e) {
        e.preventDefault();
        let idAmigo = $(this).data('id');
        let input = $(this).find('.msg-input');
        let msg = input.val().trim();
        if(msg === '') return;

        // Clear typing status instantly
        if(typingTimeouts[idAmigo]) {
            clearTimeout(typingTimeouts[idAmigo]);
            delete typingTimeouts[idAmigo];
        }

        $.ajax({
            url: '../controlador/cChatPrivado.php?accion=enviar-mensaje',
            type: 'POST',
            data: { id_receptor: idAmigo, mensaje: msg },
            success: function(res) {
                input.val('');
                cargarMensajes(idAmigo);
            }
        });
    });

    function cargarMensajes(idAmigo) {
        $.ajax({
            url: '../controlador/cChatPrivado.php?accion=cargar-mensajes&id_amigo=' + idAmigo,
            type: 'GET',
            success: function(res) {
                if(!res || res.error) return;
                
                let mensajes = res.mensajes || [];
                let typing = res.typing || false;
                let estado = res.estado || 'offline';

                let html = '';
                mensajes.forEach(m => {
                    let isMe = m.id_remitente != idAmigo;
                    if(isMe) {
                        html += `
                            <div style="text-align:right; margin-bottom:8px; align-self: flex-end; width:100%;">
                                <div style="display:inline-block; background:linear-gradient(135deg,#b92025,#e53935); color:#fff; padding:6px 12px; border-radius:16px 16px 0 16px; max-width:80%; text-align:left; box-shadow:0 1px 2px rgba(0,0,0,0.08);">${m.mensaje}</div>
                            </div>
                        `;
                    } else {
                        html += `
                            <div style="text-align:left; margin-bottom:8px; display:flex; align-items:flex-end; gap:6px; align-self: flex-start; width:100%;">
                                <img src="../vista/images/fotosperfiles/${m.fotoperfil}" class="rounded-circle" width="22" height="22" style="object-fit:cover; flex-shrink:0;">
                                <div style="display:inline-block; background:#e4e6eb; color:#050505; padding:6px 12px; border-radius:16px 16px 16px 0; max-width:80%; box-shadow:0 1px 2px rgba(0,0,0,0.04);">${m.mensaje}</div>
                            </div>
                        `;
                    }
                });

                let box = $('#chat-messages-' + idAmigo);
                box.html(html);
                box.scrollTop(box[0].scrollHeight);

                // Show/hide typing indicator with flex alignment
                let typingIndicator = $('#typing-indicator-' + idAmigo);
                if (typing) {
                    typingIndicator.css('display', 'flex');
                } else {
                    typingIndicator.css('display', 'none');
                }

                // Update online status in header
                let dot = $('#chat-header-status-dot-' + idAmigo);
                let text = $('#chat-header-status-text-' + idAmigo);
                if(estado === 'online') {
                    dot.css('background-color', '#28a745');
                    text.text('Activo ahora');
                } else {
                    dot.css('background-color', '#adb5bd');
                    text.text('Desconectado');
                }
            }
        });
    }

    // Guardar IDs de notificaciones procesadas para no repetir sonido/toasts
    let processedNotifs = [];
    let isFirstSessionLoad = false;
    try {
        let stored = localStorage.getItem('secret_processed_notifs');
        if (stored) {
            processedNotifs = JSON.parse(stored);
        } else {
            isFirstSessionLoad = true;
        }
    } catch(e) {
        processedNotifs = [];
        isFirstSessionLoad = true;
    }

    // Función para mostrar la alerta premium cuando la sesión es cerrada por concurrencia
    function showSessionKickedAlert() {
        if ($('#session-kicked-overlay').length > 0) return;
        var audio = document.getElementById('chat-alert-sound');
        if (audio) {
            audio.play().catch(function(e) { console.log('Audio autoplay prevented'); });
        }
        $('head').append(`
            <style id="session-kicked-styles">
                #session-kicked-overlay {
                    position: fixed;
                    top: 0; left: 0; right: 0; bottom: 0;
                    background: rgba(15, 23, 42, 0.95);
                    backdrop-filter: blur(12px);
                    z-index: 1000000;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-family: 'Inter', sans-serif;
                }
                .kicked-card {
                    background: rgba(30, 41, 59, 0.7);
                    border: 1px solid rgba(239, 68, 68, 0.2);
                    border-radius: 24px;
                    padding: 40px;
                    max-width: 460px;
                    width: 90%;
                    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
                    text-align: center;
                    color: #fff;
                    animation: scaleUpKicked 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
                }
                @keyframes scaleUpKicked {
                    from { opacity: 0; transform: scale(0.9); }
                    to { opacity: 1; transform: scale(1); }
                }
                .kicked-icon {
                    font-size: 54px;
                    color: #ef4444;
                    margin-bottom: 20px;
                    display: inline-block;
                    animation: pulseAlert 2s infinite;
                }
                @keyframes pulseAlert {
                    0% { transform: scale(1); }
                    50% { transform: scale(1.08); }
                    100% { transform: scale(1); }
                }
                .kicked-title {
                    font-size: 22px;
                    font-weight: 700;
                    margin-bottom: 12px;
                }
                .kicked-desc {
                    font-size: 14.5px;
                    color: #94a3b8;
                    margin-bottom: 24px;
                    line-height: 1.6;
                }
                .kicked-timer-box {
                    font-size: 14px;
                    color: #cbd5e1;
                    background: rgba(15, 23, 42, 0.5);
                    padding: 12px 20px;
                    border-radius: 12px;
                    display: inline-block;
                    font-weight: 600;
                    border: 1px solid rgba(255, 255, 255, 0.05);
                }
                .kicked-timer-box span {
                    color: #ef4444;
                    font-size: 16px;
                }
            </style>
        `);
        $('body').append(`
            <div id="session-kicked-overlay">
                <div class="kicked-card">
                    <div class="kicked-icon">
                        <i class="ri-error-warning-line"></i>
                    </div>
                    <div class="kicked-title">Sesión Cerrada</div>
                    <div class="kicked-desc">
                        Se ha iniciado una sesión activa con esta cuenta en otro navegador o dispositivo. Por seguridad, tu sesión local ha finalizado de forma remota.
                    </div>
                    <div class="kicked-timer-box">
                        Serás redirigido al inicio en <span id="kicked-countdown">5</span> segundos...
                    </div>
                </div>
            </div>
        `);
        var count = 5;
        var interval = setInterval(function() {
            count--;
            $('#kicked-countdown').text(count);
            if (count <= 0) {
                clearInterval(interval);
                window.location.href = '../controlador/ControlInicioSesiones.php?validarsesion=cerrarsesion&sesion_cerrada=1';
            }
        }, 1000);
    }

    // Polling global
    setInterval(function() {
        // Verificar validez de la sesión
        $.ajax({
            url: '../controlador/ControlInicioSesiones.php?validarsesion=check_session',
            type: 'GET',
            dataType: 'json',
            success: function(sessionRes) {
                if (sessionRes && sessionRes.status === 'KICKED') {
                    showSessionKickedAlert();
                    return;
                }
            }
        });

        $.ajax({
            url: '../controlador/cPublicacionesUsuarios.php?publicaciones=live-notifications',
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                if (res && res.status === 'OK' && res.notifications) {
                    // Si es la primera vez que se carga en esta sesión (sin localStorage previo),
                    // inicializamos con las existentes para evitar un aluvión de alertas viejas.
                    if (isFirstSessionLoad) {
                        res.notifications.forEach(n => {
                            if (processedNotifs.indexOf(n.id_notif) === -1) {
                                processedNotifs.push(n.id_notif);
                            }
                        });
                        try {
                            localStorage.setItem('secret_processed_notifs', JSON.stringify(processedNotifs));
                        } catch(e) {}
                        isFirstSessionLoad = false;
                        return; // Salimos sin alertar
                    }

                    res.notifications.forEach(n => {
                        let idNotif = n.id_notif;
                        let tipo = n.tipo;
                        let actorId = n.actor_id;
                        let nombres = n.nombres;
                        let apellidos = n.apellidos;
                        let fotoperfil = n.fotoperfil;
                        let msgText = n.mensaje;

                        // Solo procesamos si es una notificación del tipo solicitado (comentario, reaccion, mensaje) y no se ha notificado previamente
                        if ((tipo === 'comentario' || tipo === 'reaccion' || tipo === 'mensaje') && processedNotifs.indexOf(idNotif) === -1) {
                            processedNotifs.push(idNotif);
                            if (processedNotifs.length > 200) {
                                processedNotifs.shift(); // Limitar tamaño de localStorage
                            }
                            try {
                                localStorage.setItem('secret_processed_notifs', JSON.stringify(processedNotifs));
                            } catch(e) {}

                            // Determinar si debemos omitir porque el chat con este usuario ya está activo
                            let isCurrentChatActive = false;
                            
                            // 1. Si estamos en la página de mensajería y chateando con él
                            if (typeof chatAmigoId !== 'undefined' && chatAmigoId == actorId) {
                                isCurrentChatActive = true;
                            }
                            // 2. Si la ventana de chat flotante con él está abierta
                            if ($('#chat-ventana-' + actorId).length > 0) {
                                isCurrentChatActive = true;
                            }

                            // Si no está el chat activo actual, reproducir alerta y mostrar burbuja/toast
                            if (!isCurrentChatActive) {
                                // Play alert sound
                                let audio = document.getElementById('chat-alert-sound');
                                if (audio) {
                                    audio.play().catch(e => console.log('Audio autoplay prevented'));
                                }

                                // Mostrar toast premium en vivo si SN está disponible
                                if (window.SN) {
                                    let toastType = 'default';
                                    if (tipo === 'reaccion') toastType = 'success';
                                    else if (tipo === 'comentario') toastType = 'info';
                                    
                                    window.SN.show(toastType, nombres + ' ' + apellidos, msgText, {
                                        duration: 5000,
                                        action: {
                                            label: 'Ver Chat',
                                            fn: function() {
                                                if (window.location.href.indexOf('mensajeria-secret') !== -1) {
                                                    let targetItem = $('.abrir-chat-priv[data-id="' + actorId + '"]');
                                                    if (targetItem.length) {
                                                        targetItem.trigger('click');
                                                        return;
                                                    }
                                                }
                                                window.location.href = '../ChatGeneral/mensajeria-secret?abrirChat=' + actorId;
                                            }
                                        }
                                    });
                                }

                                // Crear o actualizar la burbuja flotante del actor
                                if ($('#chat-head-' + actorId).length === 0) {
                                    let badgeIcon = '💬';
                                    if (tipo === 'reaccion') badgeIcon = '❤️';
                                    else if (tipo === 'mensaje') badgeIcon = '<i class="ri-chat-4-fill"></i>';

                                    let bubble = `
                                        <div class="chat-head-bubble" id="chat-head-${actorId}" data-id="${actorId}" data-nombre="${nombres} ${apellidos}" data-foto="${fotoperfil}">
                                            <img src="../vista/images/fotosperfiles/${fotoperfil}" alt="Avatar">
                                            <div class="chat-head-action-badge badge-type-${tipo}">
                                                ${badgeIcon}
                                            </div>
                                        </div>
                                    `;
                                    $('#chat-heads-container').append(bubble);
                                } else {
                                    // Actualizar el badge de la burbuja existente
                                    let badgeIcon = '💬';
                                    if (tipo === 'reaccion') badgeIcon = '❤️';
                                    else if (tipo === 'mensaje') badgeIcon = '<i class="ri-chat-4-fill"></i>';

                                    let badgeHtml = `<div class="chat-head-action-badge badge-type-${tipo}">${badgeIcon}</div>`;
                                    let head = $('#chat-head-' + actorId);
                                    head.find('.chat-head-action-badge').remove();
                                    head.append(badgeHtml);
                                }
                            }
                        }
                    });
                }
            }
        });

        // Refrescar mensajes de ventanas abiertas
        $('.chat-ventana').each(function() {
            let idAmigo = $(this).data('id');
            cargarMensajes(idAmigo);
        });

        // Polling para llamadas entrantes
        if(!window.incomingCallActive) {
            $.ajax({
                url: '../controlador/cChatPrivado.php?accion=check-incoming-call',
                type: 'GET',
                success: function(res) {
                    if(res && res.incoming) {
                        mostrarLlamadaEntrante(res.call);
                    } else {
                        ocultarLlamadaEntrante();
                    }
                }
            });
        }
    }, 3000);

    // Evento al clickear una Burbuja (Chat Head)
    $(document).on('click', '.chat-head-bubble', function() {
        let actorId = $(this).data('id');
        $(this).remove(); // Remove the bubble
        
        // Si estamos en la página de mensajería, cargamos el chat directamente sin refrescar
        if (window.location.href.indexOf('mensajeria-secret') !== -1) {
            let targetItem = $('.abrir-chat-priv[data-id="' + actorId + '"]');
            if (targetItem.length) {
                targetItem.trigger('click');
                return;
            }
        }
        
        // Si estamos en otra página, redirigimos a messenger
        window.location.href = '../ChatGeneral/mensajeria-secret?abrirChat=' + actorId;
    });
});
