/**
 * SECRET - CHAT PRIVADO EN VIVO
 * Sistema de mensajería privada entre usuarios con presencia en tiempo real
 */
$(document).ready(function() {
    var chatAmigoId = null;
    var pingInterval = null;
    var presenciaInterval = null;
    var lastMessageId = 0;

    // ============================
    // PING DE PRESENCIA (cada 60s)
    // ============================
    function pingPresencia() {
        $.get('../controlador/cChatPrivado.php?accion=ping');
    }
    pingPresencia();
    pingInterval = setInterval(pingPresencia, 60000);

    // ============================
    // ABRIR CHAT CON AMIGO
    // ============================
    $(document).on('click', '.abrir-chat-privado', function(e) {
        e.preventDefault();
        var idAmigo = $(this).data('id');
        var nombre = $(this).data('nombre');
        var foto = $(this).data('foto');
        abrirChatPrivado(idAmigo, nombre, foto);
    });

    function abrirChatPrivado(idAmigo, nombre, foto) {
        chatAmigoId = idAmigo;
        lastMessageId = 0;

        // Actualizar header del chat
        $('#chat-privado-header-foto').attr('src', '../vista/images/fotosperfiles/' + foto);
        $('#chat-privado-header-nombre').text(nombre);
        $('#chat-privado-header-estado').text('Cargando...').removeClass('text-success text-muted').addClass('text-muted');

        // Mostrar panel de chat privado
        $('#default-block').removeClass('active show');
        $('#chat-privado-panel').addClass('active show');

        // Cargar mensajes
        cargarMensajesPrivados();

        // Verificar presencia
        verificarPresencia();

        // Iniciar polling
        if(presenciaInterval) clearInterval(presenciaInterval);
        presenciaInterval = setInterval(function(){
            cargarMensajesPrivados();
            verificarPresencia();
        }, 5000);
    }

    // ============================
    // CARGAR MENSAJES
    // ============================
    function cargarMensajesPrivados() {
        if(!chatAmigoId) return;
        $.ajax({
            url: '../controlador/cChatPrivado.php?accion=cargar-mensajes&id_amigo=' + chatAmigoId,
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                if(!res || res.error) return;
                var mensajes = res.mensajes || [];
                var container = $('#chat-privado-mensajes');
                container.empty();
                
                var idUsuario = parseInt($('#mi-id-usuario').val() || 0);
                
                mensajes.forEach(function(msg) {
                    var esMio = parseInt(msg.id_remitente) === idUsuario;
                    var fecha = new Date(msg.fecha_envio);
                    var hora = fecha.getHours().toString().padStart(2,'0') + ':' + fecha.getMinutes().toString().padStart(2,'0');
                    
                    var htmlMsg = '<div class="chat ' + (esMio ? 'chat-right' : 'chat-left') + '">' +
                        '<div class="chat-user">' +
                        '<a class="avatar m-0"><img src="../vista/images/fotosperfiles/' + msg.fotoperfil + '" alt="avatar" class="avatar-35"></a>' +
                        '<span class="chat-time mt-1">' + hora + '</span>' +
                        '</div>' +
                        '<div class="chat-detail">' +
                        '<div class="chat-message"><p>' + escapeHtml(msg.mensaje) + '</p></div>' +
                        '</div></div>';
                    container.append(htmlMsg);
                });
                
                // Scroll al final
                container.scrollTop(container[0].scrollHeight);
            }
        });
    }

    // ============================
    // ENVIAR MENSAJE PRIVADO
    // ============================
    $(document).on('submit', '#form-chat-privado', function(e) {
        e.preventDefault();
        if(!chatAmigoId) return;
        var input = $(this).find('#mensaje-privado-input');
        var mensaje = input.val().trim();
        if(!mensaje) return;

        $.ajax({
            url: '../controlador/cChatPrivado.php?accion=enviar-mensaje',
            type: 'POST',
            data: { id_receptor: chatAmigoId, mensaje: mensaje },
            dataType: 'json',
            success: function(res) {
                if(res && res.status === 'OK') {
                    input.val('');
                    cargarMensajesPrivados();
                }
            }
        });
    });

    // ============================
    // VERIFICAR PRESENCIA
    // ============================
    function verificarPresencia() {
        if(!chatAmigoId) return;
        $.ajax({
            url: '../controlador/cChatPrivado.php?accion=presencia&id_amigo=' + chatAmigoId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var estadoEl = $('#chat-privado-header-estado');
                if(data && data.estado === 'online') {
                    estadoEl.text('En línea').removeClass('text-muted').addClass('text-success');
                    $('#chat-privado-presence-dot').css('background-color', '#28a745');
                } else {
                    estadoEl.text('Desconectado').removeClass('text-success').addClass('text-muted');
                    $('#chat-privado-presence-dot').css('background-color', '#adb5bd');
                }
            }
        });
    }

    // ============================
    // HELPER - ESCAPE HTML
    // ============================
    function escapeHtml(text) {
        return $('<div>').text(text).html();
    }

    // ============================
    // BADGE MENSAJES NO LEIDOS
    // ============================
    function actualizarBadgeNoLeidos() {
        $.ajax({
            url: '../controlador/cChatPrivado.php?accion=no-leidos',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                if(data && data.total > 0) {
                    $('#badge-mensajes-privados').text(data.total).show();
                } else {
                    $('#badge-mensajes-privados').hide();
                }
            }
        });
    }
    
    actualizarBadgeNoLeidos();
    setInterval(actualizarBadgeNoLeidos, 30000);
});
