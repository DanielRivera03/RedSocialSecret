$(document).ready(function() {
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
                    type: 'GET',
                    data: { idpublicacion: idpublicacion },
                    dataType: 'html',
                    success: function(response) {
                        $('#comentarios-container-' + idpublicacion).html(response);
                    }
                });
            }
        });
    });

    // Manejar eliminación de comentarios
    $(document).on('click', '.eliminarcomentarios', function() {
        let idcomentario = $(this).data('id');
        let btn = $(this);
        if(confirm("¿Estás seguro de eliminar este comentario?")) {
            $.ajax({
                url: '../controlador/cPublicacionesUsuarios.php?publicaciones=eliminar-comentarios&idcomentariopublicacion=' + idcomentario,
                type: 'GET',
                success: function(res) {
                    btn.closest('ul.post-comments').fadeOut();
                }
            });
        }
    });

    // Manejar "Me gusta" (Reacciones Básicas por ahora)
    $(document).on('click', '.megusta', function() {
        let idpublicacion = $(this).data('id');
        let icon = $(this);
        $.ajax({
            url: '../controlador/cPublicacionesUsuarios.php?publicaciones=registro-reacciones',
            type: 'POST',
            data: { idpublicacion: idpublicacion, id_reaccion: 1 }, // 1 = Like por defecto
            success: function(res) {
                // Alternar icono o simplemente recargar contador
                // Por ahora asumiremos que se recarga
            }
        });
    });
});
