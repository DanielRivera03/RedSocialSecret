<!-- Facebook-style Media Viewer Modal -->
<div id="fb-viewer-modal" class="fb-viewer-overlay" style="display: none;">
    <div class="fb-viewer-container">
        <!-- Columna Izquierda: Imagen / Carrusel -->
        <div class="fb-viewer-media-col">
            <!-- Botón flotante para cerrar (pantalla completa / móvil) -->
            <button type="button" class="fb-viewer-close-btn fb-viewer-close-floating" aria-label="Cerrar visor">
                <i class="ri-close-line"></i>
            </button>
            
            <!-- Contador de diapositivas -->
            <div class="fb-viewer-counter" style="display: none;">1 de 1</div>
            
            <!-- Contenedor principal de la imagen -->
            <div class="fb-viewer-stage">
                <img id="fb-viewer-img" src="" alt="Publicación" class="img-fluid">
            </div>
            
            <!-- Botones de Navegación del Carrusel -->
            <button type="button" class="fb-viewer-nav fb-viewer-nav-left" aria-label="Anterior imagen">
                <i class="ri-arrow-left-s-line"></i>
            </button>
            <button type="button" class="fb-viewer-nav fb-viewer-nav-right" aria-label="Siguiente imagen">
                <i class="ri-arrow-right-s-line"></i>
            </button>
        </div>
        
        <!-- Columna Derecha: Información y Comentarios -->
        <div class="fb-viewer-info-col">
            <!-- Cabecera del Panel de Información -->
            <div class="fb-viewer-info-header">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="fb-viewer-avatar-container mr-3">
                            <img id="fb-viewer-author-avatar" src="" alt="Avatar" class="rounded-circle img-fluid">
                        </div>
                        <div>
                            <h6 class="mb-0" id="fb-viewer-author-name">Cargando...</h6>
                            <small class="text-muted"><i class="ri-time-line"></i> <span id="fb-viewer-date">Hace un momento</span></small>
                        </div>
                    </div>
                    <!-- Botón Cerrar Estándar para escritorio -->
                    <button type="button" class="fb-viewer-close-btn fb-viewer-close-inline" aria-label="Cerrar">
                        <i class="ri-close-line"></i>
                    </button>
                </div>
            </div>
            
            <!-- Cuerpo del Panel de Información -->
            <div class="fb-viewer-info-body">
                <!-- Descripción / Mensaje de la publicación -->
                <div class="fb-viewer-post-text mb-3">
                    <p id="fb-viewer-description"></p>
                </div>
                
                <hr class="my-3">
                
                <!-- Comentarios y Reacciones en Vivo -->
                <div id="fb-viewer-comments-target" class="feed-comentarios-container" data-id="">
                    <!-- Se cargará dinámicamente mediante AJAX -->
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Cargando comentarios...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
