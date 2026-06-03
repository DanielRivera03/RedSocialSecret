"$(document).ready(function() {
    function pollComentarios() {
        $('.comentarios-wrapper').each(function() {
            let container = $(this);
            let idpublicacion = container.data('id');
            
            if(idpublicacion) {
                $.ajax({
                    url: '../controlador/cComentariosEnVivo.php',
                    type: 'GET',
                    data: { idpublicacion: idpublicacion },
                    dataType: 'html',
                    success: function(response) {
                        if(response.trim() !== '') {
                            let currentHtml = container.html();
                            if(response !== currentHtml) {
                                container.html(response);
                                if (jQuery().timeago) {
                                    $("time.timeago").timeago();
                                }
                            }
                        }
                    }
                });
            }
        });
        setTimeout(pollComentarios, 5000); // Polling every 5 seconds
    }

    setTimeout(pollComentarios, 5000);

    // Manejar envío de comentarios por AJAX
    $(document).on('submit', '.form-comentario', function(e) {
        e.preventDefault();
        let form = $(this);
        let idpublicacion = form.data('id');
        let comentario = form.find('input[name="caja_comentarios"]').val();
        
        if(comentario.trim() === '') return;

        $.ajax({
            url: '../controlador/cPublicacionesUsuarios.php?publicaciones=registrarcomentariosperfiles&idpublicacion=' + idpublicacion,
            type: 'POST',
            data: { caja_comentarios: comentario },
            success: function(res) {
                form.find('input[name="caja_comentarios"]').val('');
                // Refrescar comentarios inmediatamente
                $.ajax({
                    url: '../controlador/cComentariosEnVivo.php',
             
<truncated 1571 bytes>