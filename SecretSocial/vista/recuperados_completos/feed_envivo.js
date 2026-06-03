"$(document).ready(function() {
    let last_id = 0;

    function pollFeed() {
        $.ajax({
            url: '../controlador/cFeedEnVivo.php',
            type: 'GET',
            data: { last_id: last_id },
            dataType: 'json',
            success: function(response) {
                if(response.error) {
                    console.log(response.error);
                    return;
                }
                
                if (response.max_id > last_id) {
                    last_id = response.max_id;
                }

                if (response.posts && response.posts.length > 0) {
                    // Si es la primera carga (last_id era 0), no queremos insertar de golpe
                    // porque ya se imprimieron por PHP. Pero como controlamos esto en el PHP 
                    // devolviendo vacío si last_id = 0, los nuevos posts solo llegarán si realmente son nuevos.
                    
                    response.posts.forEach(function(post) {
                        // Verifica si el post ya existe en el DOM por si acaso
                        if ($('#publicaciones_usuariosperfil_' + post.id).length === 0) {
                            // Cambia un poco el ID devuelto en el HTML o en el DOM para evitar duplicados si los IDs chocan
                            // Convertir el HTML a un nodo jQuery
                            var $newPost = $(post.html);
                            // Lo ocultamos primero para hacerle fade in
                            $newPost.hide();
                            // Agregamos al inicio del contenedor del feed
                            $('#feed-container').prepend($newPost);
                            // Mostramos con animación
                            $newPost.fadeIn('slow');
                        }
                    });
                }
            },
            complete: function() {
                // Llama de nuevo a la función después de 3 segundos para mantener la ilusión de t
<truncated 148 bytes>