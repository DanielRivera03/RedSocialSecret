<!-- MODAL VISOR DE HISTORIAS EPÍMERAS (STORIES) -->
<div id="stories-viewer-modal" class="stories-viewer-modal" style="display: none;">
    <div class="stories-viewer-backdrop" onclick="StoriesViewer.close()"></div>
    
    <div class="stories-viewer-container">
        <!-- Barra de Progreso Secuencial -->
        <div id="stories-progress-bars" class="stories-progress-bars"></div>
        
        <!-- Cabecera: Info del Autor y Botón Cerrar -->
        <div class="stories-viewer-header">
            <div class="stories-author-info">
                <img id="stories-viewer-avatar" src="" alt="avatar" class="rounded-circle mr-2" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #fff;">
                <div>
                    <h6 id="stories-viewer-name" class="text-white mb-0 font-weight-bold" style="text-shadow: 0 1px 3px rgba(0,0,0,0.8);"></h6>
                    <span id="stories-viewer-time" class="text-white-50 font-size-12" style="text-shadow: 0 1px 2px rgba(0,0,0,0.8);"></span>
                </div>
            </div>
            <button class="stories-close-btn" onclick="StoriesViewer.close()"><i class="ri-close-line"></i></button>
        </div>

        <!-- Área de Contenido Multimedia -->
        <div class="stories-viewer-content" id="stories-viewer-content-area" onmousedown="StoriesViewer.pause()" onmouseup="StoriesViewer.resume()" ontouchstart="StoriesViewer.pause()" ontouchend="StoriesViewer.resume()">
            <img id="stories-img-display" src="" alt="Story Image" style="display: none;">
            <video id="stories-vid-display" src="" playsinline style="display: none;"></video>
            
            <!-- Flechas de Navegación Flotantes -->
            <button class="stories-nav-btn stories-nav-left" onclick="StoriesViewer.prevSlide()"><i class="ri-arrow-left-s-line"></i></button>
            <button class="stories-nav-btn stories-nav-right" onclick="StoriesViewer.nextSlide()"><i class="ri-arrow-right-s-line"></i></button>
        </div>

        <!-- Respuesta Rápida (Estilo Instagram) -->
        <div class="stories-viewer-footer">
            <input type="text" id="stories-reply-input" class="stories-reply-input" placeholder="Envía una respuesta rápida...">
            <button class="stories-send-reply-btn" onclick="StoriesViewer.sendReply()"><i class="ri-send-plane-fill"></i></button>
        </div>
    </div>
</div>

<script>
window.StoriesViewer = {
    activeUserStories: null,
    currentUserIndex: 0,
    currentSlideIndex: 0,
    slideDuration: 5000, // 5 segundos
    timer: null,
    progressInterval: null,
    elapsedTime: 0,
    isPaused: false,
    usersList: [],

    open: function(usersList, startUserId) {
        this.usersList = usersList;
        this.currentUserIndex = this.usersList.findIndex(u => u.usuario_id == startUserId);
        if (this.currentUserIndex === -1) this.currentUserIndex = 0;
        
        this.currentSlideIndex = 0;
        
        $('#stories-viewer-modal').fadeIn(200);
        $('body').css('overflow', 'hidden');
        
        this.loadUserStories();
    },

    close: function() {
        this.clearTimers();
        const video = document.getElementById('stories-vid-display');
        if (video) {
            video.pause();
            video.src = '';
        }
        $('#stories-viewer-modal').fadeOut(200);
        $('body').css('overflow', '');
    },

    loadUserStories: function() {
        this.clearTimers();
        this.activeUser = this.usersList[this.currentUserIndex];
        if (!this.activeUser) {
            this.close();
            return;
        }

        // Rellenar cabecera
        $('#stories-viewer-avatar').attr('src', '../vista/images/fotosperfiles/' + this.activeUser.fotoperfil);
        $('#stories-viewer-name').text(this.activeUser.nombres + ' ' + this.activeUser.apellidos);

        // Crear barras de progreso
        const progressContainer = document.getElementById('stories-progress-bars');
        progressContainer.innerHTML = '';
        const slidesCount = this.activeUser.items.length;
        
        for (let i = 0; i < slidesCount; i++) {
            const bar = document.createElement('div');
            bar.className = 'stories-progress-bar-wrapper';
            bar.innerHTML = '<div class="stories-progress-fill" style="width: 0%;"></div>';
            progressContainer.appendChild(bar);
        }

        this.loadSlide();
    },

    loadSlide: function() {
        this.clearTimers();
        const slides = this.activeUser.items;
        const slide = slides[this.currentSlideIndex];
        if (!slide) {
            this.nextUser();
            return;
        }

        // Actualizar hora
        const dateStr = slide.fecha_creacion;
        $('#stories-viewer-time').text('hace ' + this.formatTimeAgo(dateStr));

        // Actualizar barras de progreso anteriores
        const fills = document.querySelectorAll('.stories-progress-fill');
        fills.forEach((fill, index) => {
            if (index < this.currentSlideIndex) {
                fill.style.width = '100%';
            } else if (index > this.currentSlideIndex) {
                fill.style.width = '0%';
            }
        });

        // Mostrar multimedia
        const img = document.getElementById('stories-img-display');
        const video = document.getElementById('stories-vid-display');
        
        img.style.display = 'none';
        video.style.display = 'none';
        video.pause();
        video.src = '';

        this.elapsedTime = 0;
        this.isPaused = false;

        const mediaUrl = '../vista/images/stories/' + slide.multimedia;

        if (slide.tipo === 'image') {
            img.src = mediaUrl;
            img.style.display = 'block';
            
            // Iniciar progreso de imagen
            this.startProgress(this.slideDuration);
        } else {
            video.src = mediaUrl;
            video.style.display = 'block';
            video.load();
            
            const self = this;
            video.onloadedmetadata = function() {
                // Si el video dura más de 15s, lo recortamos a 15s en progreso
                const duration = Math.min(video.duration * 1000, 15000) || self.slideDuration;
                video.play().then(() => {
                    self.startProgress(duration);
                }).catch(e => {
                    console.error("Video play error:", e);
                    self.startProgress(self.slideDuration);
                });
            };
            
            video.onerror = function() {
                self.startProgress(self.slideDuration);
            };
        }
    },

    startProgress: function(duration) {
        const fill = document.querySelectorAll('.stories-progress-fill')[this.currentSlideIndex];
        if (!fill) return;

        const step = 50; // ms
        const self = this;
        
        this.progressInterval = setInterval(() => {
            if (!self.isPaused) {
                self.elapsedTime += step;
                const percentage = Math.min((self.elapsedTime / duration) * 100, 100);
                fill.style.width = percentage + '%';

                if (self.elapsedTime >= duration) {
                    self.nextSlide();
                }
            }
        }, step);
    },

    pause: function() {
        this.isPaused = true;
        const video = document.getElementById('stories-vid-display');
        if (video && !video.paused) {
            video.pause();
        }
    },

    resume: function() {
        this.isPaused = false;
        const video = document.getElementById('stories-vid-display');
        if (video && video.paused && video.src !== '') {
            video.play().catch(e => {});
        }
    },

    nextSlide: function() {
        if (this.currentSlideIndex < this.activeUser.items.length - 1) {
            this.currentSlideIndex++;
            this.loadSlide();
        } else {
            this.nextUser();
        }
    },

    prevSlide: function() {
        if (this.currentSlideIndex > 0) {
            this.currentSlideIndex--;
            this.loadSlide();
        } else {
            this.prevUser();
        }
    },

    nextUser: function() {
        if (this.currentUserIndex < this.usersList.length - 1) {
            this.currentUserIndex++;
            this.currentSlideIndex = 0;
            this.loadUserStories();
        } else {
            // Fin de todas las historias
            this.close();
        }
    },

    prevUser: function() {
        if (this.currentUserIndex > 0) {
            this.currentUserIndex--;
            // Ir al último slide del usuario anterior
            this.currentSlideIndex = this.usersList[this.currentUserIndex].items.length - 1;
            this.loadUserStories();
        } else {
            // Primer usuario, primer slide: reiniciar slide actual
            this.currentSlideIndex = 0;
            this.loadSlide();
        }
    },

    clearTimers: function() {
        if (this.progressInterval) {
            clearInterval(this.progressInterval);
            this.progressInterval = null;
        }
    },

    sendReply: function() {
        const input = document.getElementById('stories-reply-input');
        const text = input.value.trim();
        if (text === '') return;

        const recipientId = this.activeUser.usuario_id;
        
        // Enviar respuesta rápida como un mensaje de chat privado
        const self = this;
        $.ajax({
            url: '../controlador/cChatPrivado.php?accion=enviar-mensaje',
            type: 'POST',
            data: {
                id_receptor: recipientId,
                mensaje: "Respondió a tu historia: \"" + text + "\""
            },
            success: function(res) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Respuesta enviada',
                    showConfirmButton: false,
                    timer: 2000
                });
                input.value = '';
                self.resume();
            },
            error: function() {
                self.resume();
            }
        });

        this.pause();
    },

    formatTimeAgo: function(dateStr) {
        const date = new Date(dateStr.replace(/-/g, "/"));
        const seconds = Math.floor((new Date() - date) / 1000);
        
        let interval = seconds / 3600;
        if (interval > 1) {
            return Math.floor(interval) + " h";
        }
        interval = seconds / 60;
        if (interval > 1) {
            return Math.floor(interval) + " m";
        }
        return Math.floor(seconds) + " s";
    }
};
</script>
