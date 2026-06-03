$(document).ready(function() {
    function refreshComments() {
        $('.comentarios-envivo-container, .feed-comentarios-container').each(function() {
            var container = $(this);
            // Evitar actualizar si el usuario está interactuando con las reacciones
            if (container.find('.fb-reaction-container:hover').length > 0 || container.find('.fb-reactions-box:visible').length > 0) {
                return;
            }
            var postId = container.data('post-id') || container.data('id');
            $.ajax({
                url: '../controlador/cComentariosEnVivo.php',
                type: 'GET',
                data: { idpublicacion: postId },
                success: function(response) {
                    container.html(response);
                }
            });
        });
    }
    window.initComentariosEnVivo = refreshComments;

    // Actualizar cada 5 segundos
    setInterval(refreshComments, 5000);
    // Y cargar inmediatamente
    refreshComments();

    // Enviar nuevo comentario sin recargar
    $(document).on('submit', '.submit-comment-form', function(e) {
        e.preventDefault();
        var form = $(this);
        var input = form.find('input[name="comentario"]');
        var idpub = form.find('input[name="idpublicacion"]').val();
        var comentario = input.val();

        if (comentario.trim() === '') return;

        $.ajax({
            url: '../controlador/cPublicacionesUsuarios.php?publicaciones=registrarcomentariosperfiles&idpublicacion=' + idpub,
            type: 'POST',
            data: { caja_comentarios: comentario },
            success: function(response) {
                input.val(''); // Limpiar input
                refreshComments(); // Refrescar los comentarios
            }
        });
    });

    // Mostrar/Ocultar menu de reacciones con stop para evitar acumulación de animaciones
    $(document).on('mouseenter', '.fb-reaction-container', function() {
        $(this).find('.fb-reactions-box').stop(true, true).fadeIn(150);
    }).on('mouseleave', '.fb-reaction-container', function() {
        $(this).find('.fb-reactions-box').stop(true, true).fadeOut(150);
    });

    // Registrar reacciones (click directo al Me Gusta = reaccion tipo 1 o toggle off)
    $(document).on('click', '.btn-main-reaccion', function(e) {
        e.preventDefault();
        var postId = $(this).data('id');
        $.ajax({
            url: '../controlador/cPublicacionesUsuarios.php?publicaciones=registro-reacciones&idpublicacion=' + postId,
            type: 'POST',
            data: { tipo_reaccion: 1 }, // Default to Like (1) when clicking the main button
            success: function(response) {
                refreshComments();
            }
        });
    });

    // Click en una de las 6 reacciones
    $(document).on('click', '.btn-fb-reaction', function(e) {
        e.preventDefault();
        e.stopPropagation(); // Evitar click en contenedor padre
        var postId = $(this).data('id');
        var tipo = $(this).data('tipo');
        $.ajax({
            url: '../controlador/cPublicacionesUsuarios.php?publicaciones=registro-reacciones&idpublicacion=' + postId,
            type: 'POST',
            data: { tipo_reaccion: tipo },
            success: function(response) {
                $('.fb-reactions-box').hide();
                refreshComments();
            }
        });
    });
});
