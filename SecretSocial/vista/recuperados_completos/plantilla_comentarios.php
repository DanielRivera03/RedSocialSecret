"<?php
// Plantilla para cargar comentarios sin iframe
$IdPublicacion = $IdPublicacionActual;

// Realizar consultas localmente
$PublicacionesPlantilla = new ModeloPublicaciones();
$consulta = $PublicacionesPlantilla->ConsultarComentariosPerfilPropietario($conectarsistema, $IdPublicacion);
$consulta1 = $PublicacionesPlantilla->ConsultarNombresUsuariosComentarios($conectarsistema, $IdPublicacion);
?>
<div class="comment-area mt-3">
    <div class="d-flex justify-content-between align-items-center">
        <div class="like-block position-relative d-flex align-items-center">
            <div class="d-flex align-items-center">
                <div class="like-data">
                    <div class="dropdown">
                        <span class="dropdown-toggle" aria-haspopup="true" aria-expanded="false" role="button">
                            <img class="megusta" data-id="<?php echo $IdPublicacion; ?>" data-id-usuario="<?php echo $_SESSION['id_usuario']; ?>" src="../vista/images/icon/01.png" class="img-fluid" alt="megusta" style="cursor:pointer; width:35px;">
                        </span>
                    </div>
                </div>
                <div class="total-like-block ml-2 mr-3">
                    <div class="dropdown">
                        <span class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                            <?php echo ContadorMeGustaPublicaciones($conectarsistema, $IdPublicacion); ?> Reacciones
                        </span>
                    </div>
                </div>
            </div>
            <div class="total-comment-block">
                <div class="dropdown">
                    <span class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                        <?php echo NumeroComentariosPublicaciones($conectarsistema, $IdPublicacion); ?> Comentarios
           
<truncated 4192 bytes>