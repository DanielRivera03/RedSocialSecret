"/**
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
    function car
<truncated 4403 bytes>