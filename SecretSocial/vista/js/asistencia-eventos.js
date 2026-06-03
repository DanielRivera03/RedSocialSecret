$(document).ready(function() {
    $(document).on('click', '.btn-attendance', function(e) {
        e.preventDefault();
        let btn = $(this);
        let container = btn.closest('.attendance-buttons');
        let idevento = container.data('event-id');
        let status = btn.data('status');

        $.ajax({
            url: '../controlador/cEventosSecretSocial.php?eventos_sociales=registrar-asistencia',
            type: 'POST',
            data: {
                idevento: idevento,
                estado: status
            },
            dataType: 'json',
            success: function(response) {
                if (response === 'OK') {
                    // Update active class immediately
                    container.find('.btn-attendance').removeClass('active');
                    btn.addClass('active');
                    
                    // Refresh counts and screen state
                    setTimeout(function() {
                        location.reload();
                    }, 250);
                } else {
                    Swal.fire("Error", "No se pudo registrar tu respuesta.", "error");
                }
            },
            error: function() {
                Swal.fire("Error", "Hubo un problema al procesar la solicitud.", "error");
            }
        });
    });
});
