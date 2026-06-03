/**
 * SECRET SOCIAL — FEED INFINITO CON SKELETON LOADING
 * Sistema de carga paginada (10 publicaciones) con Intersection Observer
 * Incluye skeleton cards animadas mientras carga
 */

(function() {
  'use strict';

  // ===================== SKELETON STYLES =====================
  var skeletonStyles = `
    #feed-loader-container {
      padding: 0;
    }

    .feed-skeleton-card {
      background: #fff;
      border-radius: 16px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    }
    body.dark-mode .feed-skeleton-card { background: #1f2937 !important; }

    .skel-row { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; }
    .skel-avatar {
      width: 50px; height: 50px; border-radius: 50%;
      background: linear-gradient(90deg, #f3f4f6 25%, #e5e7eb 50%, #f3f4f6 75%);
      background-size: 200% 100%;
      animation: skelShimmer 1.5s infinite;
      flex-shrink: 0;
    }
    .skel-lines { flex: 1; }
    .skel-line {
      height: 12px; border-radius: 6px; margin-bottom: 8px;
      background: linear-gradient(90deg, #f3f4f6 25%, #e5e7eb 50%, #f3f4f6 75%);
      background-size: 200% 100%;
      animation: skelShimmer 1.5s infinite;
    }
    .skel-line.short { width: 45%; }
    .skel-line.medium { width: 70%; }
    .skel-line.full { width: 100%; }
    .skel-image {
      width: 100%; height: 220px; border-radius: 12px; margin-top: 4px;
      background: linear-gradient(90deg, #f3f4f6 25%, #e5e7eb 50%, #f3f4f6 75%);
      background-size: 200% 100%;
      animation: skelShimmer 1.5s infinite;
    }
    .skel-actions { display: flex; gap: 10px; margin-top: 16px; }
    .skel-btn {
      height: 32px; border-radius: 8px; flex: 1;
      background: linear-gradient(90deg, #f3f4f6 25%, #e5e7eb 50%, #f3f4f6 75%);
      background-size: 200% 100%;
      animation: skelShimmer 1.5s infinite;
    }

    body.dark-mode .skel-avatar,
    body.dark-mode .skel-line,
    body.dark-mode .skel-image,
    body.dark-mode .skel-btn {
      background: linear-gradient(90deg, #374151 25%, #4b5563 50%, #374151 75%) !important;
      background-size: 200% 100% !important;
    }

    @keyframes skelShimmer {
      0%   { background-position: 200% 0; }
      100% { background-position: -200% 0; }
    }

    /* Sentinel (Intersection Observer trigger) */
    #feed-sentinel {
      height: 1px;
      margin-top: 10px;
    }

    /* End of feed message */
    #feed-end-msg {
      text-align: center;
      padding: 24px 0;
      color: #9ca3af;
      font-size: 13px;
      display: none;
      font-family: 'Inter', -apple-system, sans-serif;
    }
    #feed-end-msg i { display: block; font-size: 28px; margin-bottom: 6px; }

    /* Loading spinner at bottom */
    #feed-loading-more {
      text-align: center;
      padding: 20px;
      display: none;
    }
    .feed-spinner {
      display: inline-block; width: 32px; height: 32px;
      border: 3px solid #e5e7eb; border-top-color: var(--iq-primary, #b92025);
      border-radius: 50%; animation: spinFeed 0.7s linear infinite;
    }
    @keyframes spinFeed { to { transform: rotate(360deg); } }

    /* Feed items fade in */
    .feed-post-item {
      animation: feedItemIn 0.4s ease both;
    }
    @keyframes feedItemIn {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }
  `;

  function injectStyles() {
    if (document.getElementById('feed-infinito-styles')) return;
    var style = document.createElement('style');
    style.id = 'feed-infinito-styles';
    style.textContent = skeletonStyles;
    document.head.appendChild(style);
  }

  // ===================== SKELETON HTML =====================
  function createSkeletonCard() {
    return '<div class="feed-skeleton-card">' +
      '<div class="skel-row">' +
        '<div class="skel-avatar"></div>' +
        '<div class="skel-lines">' +
          '<div class="skel-line medium"></div>' +
          '<div class="skel-line short"></div>' +
        '</div>' +
      '</div>' +
      '<div class="skel-line full"></div>' +
      '<div class="skel-line medium" style="margin-top:4px;"></div>' +
      '<div class="skel-image"></div>' +
      '<div class="skel-actions">' +
        '<div class="skel-btn"></div>' +
        '<div class="skel-btn"></div>' +
        '<div class="skel-btn"></div>' +
      '</div>' +
    '</div>';
  }

  function showSkeletons(container, count) {
    var html = '';
    for (var i = 0; i < count; i++) html += createSkeletonCard();
    container.innerHTML = html;
  }

  // ===================== FEED INFINITO =====================
  window.FeedInfinito = {
    pagina: 1,
    cargando: false,
    hayMas: true,
    tipo: 'inicio',
    contenedor: null,
    sentinel: null,
    observer: null,

    init: function(opts) {
      injectStyles();
      this.tipo = opts.tipo || 'inicio';
      this.id_usuario = opts.id_usuario || null;
      this.contenedor = document.getElementById(opts.contenedor || 'feed-publications');
      if (!this.contenedor) return;

      // Mostrar skeletons iniciales
      showSkeletons(this.contenedor, 3);

      // Crear sentinel y elementos auxiliares
      this.sentinel = document.createElement('div');
      this.sentinel.id = 'feed-sentinel';
      this.contenedor.parentNode.insertBefore(this.sentinel, this.contenedor.nextSibling);

      var loadingMore = document.createElement('div');
      loadingMore.id = 'feed-loading-more';
      loadingMore.innerHTML = '<div class="feed-spinner"></div>';
      this.sentinel.parentNode.insertBefore(loadingMore, this.sentinel.nextSibling);

      var endMsg = document.createElement('div');
      endMsg.id = 'feed-end-msg';
      endMsg.innerHTML = '<i>🎉</i> Has visto todas las publicaciones';
      loadingMore.parentNode.insertBefore(endMsg, loadingMore.nextSibling);

      // Cargar primera página
      var self = this;
      this.cargar(function() {
        // Configurar Intersection Observer
        self.setupObserver();
      });
    },

    mostrarError: function(msg) {
      if (this.pagina === 1 && this.contenedor) {
        this.contenedor.innerHTML = '<div class="text-center py-5 text-danger"><i class="ri-error-warning-line" style="font-size:32px;display:block;margin-bottom:8px;"></i><p class="mt-2">' + msg + '</p></div>';
      }
    },

    cargar: function(callback) {
      if (this.cargando || !this.hayMas) return;
      this.cargando = true;

      if (this.pagina > 1) {
        var loadingMore = document.getElementById('feed-loading-more');
        if (loadingMore) loadingMore.style.display = 'block';
      }

      var self = this;
      var xhr = new XMLHttpRequest();
      var url = '../controlador/cFeedInfinito.php?pagina=' + this.pagina + '&tipo=' + this.tipo;
      if (this.id_usuario) {
        url += '&id_usuario=' + this.id_usuario;
      }
      url += '&t=' + Date.now();
      xhr.open('GET', url, true);
      xhr.onload = function() {
        var loadingMore = document.getElementById('feed-loading-more');
        if (loadingMore) loadingMore.style.display = 'none';

        if (xhr.status === 200) {
          try {
            var data = JSON.parse(xhr.responseText);
            if (data.error) {
              self.cargando = false;
              self.mostrarError(data.error);
              return;
            }
            if (self.pagina === 1) {
              self.contenedor.innerHTML = '';
            }
            if (data.html && data.html.trim() !== '') {
              self.contenedor.insertAdjacentHTML('beforeend', data.html);
              // Re-activar timeago si está disponible
              if (typeof jQuery !== 'undefined' && typeof jQuery.timeago !== 'undefined') {
                jQuery('time.timeago').timeago();
              }
              // Re-activar comentarios en vivo
              if (typeof initComentariosEnVivo === 'function') {
                initComentariosEnVivo();
              }
              // Actualizar poll de comentarios si existe
              if (typeof pollComentariosContainers === 'function') {
                pollComentariosContainers();
              }
            }
            self.hayMas = !!data.hasMore;
            self.pagina++;
            self.cargando = false;

            if (!self.hayMas) {
              var sentinel = document.getElementById('feed-sentinel');
              if (sentinel) sentinel.remove();
              var endMsg = document.getElementById('feed-end-msg');
              if (endMsg) endMsg.style.display = 'block';
              if (self.observer) self.observer.disconnect();
            }

            if (callback) callback();
          } catch(e) {
            console.error("FeedInfinito error parsing JSON:", e, xhr.responseText);
            self.cargando = false;
            self.mostrarError("Error al cargar las publicaciones.");
            if (callback) callback();
          }
        } else {
          console.error("FeedInfinito HTTP error:", xhr.status, xhr.statusText);
          self.cargando = false;
          self.mostrarError("Error de red o servidor (" + xhr.status + ").");
        }
      };
      xhr.onerror = function() {
        console.error("FeedInfinito network connection failed.");
        self.cargando = false;
        var loadingMore = document.getElementById('feed-loading-more');
        if (loadingMore) loadingMore.style.display = 'none';
        self.mostrarError("Error de conexión.");
      };
      xhr.send();
    },

    setupObserver: function() {
      if (!this.sentinel || !window.IntersectionObserver) {
        // Fallback: scroll event
        var self = this;
        window.addEventListener('scroll', function() {
          var scrollTop = window.scrollY || document.documentElement.scrollTop;
          var winHeight = window.innerHeight || document.documentElement.clientHeight;
          var docHeight = document.documentElement.scrollHeight;
          if (scrollTop + winHeight >= docHeight - 300) {
            self.cargar();
          }
        });
        return;
      }

      var self = this;
      this.observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
          if (entry.isIntersecting && self.hayMas && !self.cargando) {
            self.cargar();
          }
        });
      }, { rootMargin: '200px' });

      this.observer.observe(this.sentinel);
    },

    reset: function() {
      this.pagina = 1;
      this.hayMas = true;
      this.cargando = false;
      
      // Clear feed container
      if (this.contenedor) {
        this.contenedor.innerHTML = '';
        // Re-inject skeletons
        var skelHtml = '';
        for (var i = 0; i < 3; i++) {
          skelHtml += '<div class="feed-skeleton-card">' +
            '<div class="skel-row">' +
              '<div class="skel-avatar"></div>' +
              '<div class="skel-lines">' +
                '<div class="skel-line medium"></div>' +
                '<div class="skel-line short"></div>' +
              '</div>' +
            '</div>' +
            '<div class="skel-line full"></div>' +
            '<div class="skel-line medium" style="margin-top:4px;"></div>' +
            '<div class="skel-image"></div>' +
            '<div class="skel-actions">' +
              '<div class="skel-btn"></div>' +
              '<div class="skel-btn"></div>' +
              '<div class="skel-btn"></div>' +
            '</div>' +
          '</div>';
        }
        this.contenedor.innerHTML = skelHtml;
      }
      
      // Hide end message
      var endMsg = document.getElementById('feed-end-msg');
      if (endMsg) endMsg.style.display = 'none';
      
      // Re-create sentinel if it was removed
      var sentinel = document.getElementById('feed-sentinel');
      if (!sentinel && this.contenedor) {
        this.sentinel = document.createElement('div');
        this.sentinel.id = 'feed-sentinel';
        this.contenedor.parentNode.insertBefore(this.sentinel, this.contenedor.nextSibling);
      }
      
      // Re-setup observer if disconnected
      if (this.observer) {
        this.observer.disconnect();
      }
      this.setupObserver();
      
      // Load first page
      this.cargar();
    }
  };

  // ===================== INSTAGRAM CAROUSEL CONTROLS =====================
  window.slideCarousel = function(idPub, direction) {
    const container = document.getElementById('carousel-' + idPub);
    if (!container) return;
    const track = document.getElementById('track-' + idPub);
    if (!track) return;
    const slides = track.querySelectorAll('.instagram-carousel-slide');
    const totalSlides = slides.length;
    let currentSlide = parseInt(container.getAttribute('data-current-slide') || '0', 10);
    
    currentSlide += direction;
    if (currentSlide < 0) currentSlide = 0;
    if (currentSlide >= totalSlides) currentSlide = totalSlides - 1;
    
    container.setAttribute('data-current-slide', currentSlide);
    
    const targetSlide = slides[currentSlide];
    if (targetSlide) {
      track.scrollTo({
        left: targetSlide.offsetLeft,
        behavior: 'smooth'
      });
    }
    
    window.updateCarouselDots(idPub, currentSlide);
  };

  window.jumpToSlide = function(idPub, index) {
    const container = document.getElementById('carousel-' + idPub);
    if (!container) return;
    const track = document.getElementById('track-' + idPub);
    if (!track) return;
    const slides = track.querySelectorAll('.instagram-carousel-slide');
    
    if (index < 0 || index >= slides.length) return;
    
    container.setAttribute('data-current-slide', index);
    
    const targetSlide = slides[index];
    if (targetSlide) {
      track.scrollTo({
        left: targetSlide.offsetLeft,
        behavior: 'smooth'
      });
    }
    
    window.updateCarouselDots(idPub, index);
  };

  window.updateCarouselDots = function(idPub, currentIndex) {
    const container = document.getElementById('carousel-' + idPub);
    if (!container) return;
    const dots = container.querySelectorAll('.carousel-dot');
    dots.forEach((dot, index) => {
      if (index === currentIndex) {
        dot.classList.add('active');
      } else {
        dot.classList.remove('active');
      }
    });

    const leftArrow = container.querySelector('.carousel-arrow-left');
    const rightArrow = container.querySelector('.carousel-arrow-right');
    if (leftArrow) {
      if (currentIndex === 0) {
        leftArrow.style.opacity = '0.3';
        leftArrow.style.pointerEvents = 'none';
      } else {
        leftArrow.style.opacity = '1';
        leftArrow.style.pointerEvents = 'auto';
      }
    }
    if (rightArrow) {
      if (currentIndex === dots.length - 1) {
        rightArrow.style.opacity = '0.3';
        rightArrow.style.pointerEvents = 'none';
      } else {
        rightArrow.style.opacity = '1';
        rightArrow.style.pointerEvents = 'auto';
      }
    }
  };

  // Manual scroll/swipe listener to update dots on manual drag
  document.addEventListener('scroll', function(e) {
    if (e.target.classList && e.target.classList.contains('instagram-carousel-track')) {
      const track = e.target;
      const container = track.parentElement;
      if (!container) return;
      const idPub = container.id.replace('carousel-', '');
      const scrollLeft = track.scrollLeft;
      const width = track.clientWidth || track.offsetWidth;
      if (width === 0) return;
      
      const index = Math.round(scrollLeft / width);
      container.setAttribute('data-current-slide', index);
      
      window.updateCarouselDots(idPub, index);
    }
  }, true); // Capture phase

  // ===================== FACEBOOK-STYLE MEDIA VIEWER =====================
  function renderFBViewerImage() {
    var modal = $('#fb-viewer-modal');
    var images = modal.data('images') || [];
    var currentIndex = parseInt(modal.data('current-index') || '0', 10);
    
    if (images.length === 0) return;
    
    var f = images[currentIndex];
    $('#fb-viewer-img').attr('src', '../vista/images/fotospublicaciones/' + f);
    
    if (images.length > 1) {
      $('.fb-viewer-counter').text((currentIndex + 1) + ' de ' + images.length).show();
      $('.fb-viewer-nav').show();
      
      // Control de visibilidad/transparencia de flechas
      if (currentIndex === 0) {
        $('.fb-viewer-nav-left').css({'opacity': '0.25', 'pointer-events': 'none'});
      } else {
        $('.fb-viewer-nav-left').css({'opacity': '1', 'pointer-events': 'auto'});
      }
      
      if (currentIndex === images.length - 1) {
        $('.fb-viewer-nav-right').css({'opacity': '0.25', 'pointer-events': 'none'});
      } else {
        $('.fb-viewer-nav-right').css({'opacity': '1', 'pointer-events': 'auto'});
      }
    } else {
      $('.fb-viewer-counter').hide();
      $('.fb-viewer-nav').hide();
    }
  }

  function openFBViewer(postId, msg, authorName, authorAvatar, postDate, images, currentIndex) {
    var modal = $('#fb-viewer-modal');
    
    // Rellenar cabecera de autor y fecha
    $('#fb-viewer-author-name').text(authorName);
    $('#fb-viewer-author-avatar').attr('src', '../vista/images/fotosperfiles/' + authorAvatar);
    
    var dateSpan = $('#fb-viewer-date');
    dateSpan.attr('datetime', postDate).text(postDate);
    if (typeof jQuery !== 'undefined' && typeof jQuery.timeago === 'function') {
      dateSpan.timeago();
    }
    
    // Mensaje de la publicación
    var descContainer = $('#fb-viewer-description');
    if (msg && msg.trim() !== '') {
      descContainer.text(msg).parent().show();
    } else {
      descContainer.text('').parent().hide();
    }
    
    // Guardar estado del carrusel
    modal.data('images', images).data('current-index', currentIndex);
    renderFBViewerImage();
    
    // Activar comentarios en vivo
    var commentsTarget = $('#fb-viewer-comments-target');
    commentsTarget.data('id', postId).data('post-id', postId);
    commentsTarget.html('<div class="text-center py-4"><div class="spinner-border text-primary" role="status"><span class="sr-only">Cargando comentarios...</span></div></div>');
    
    // Mostrar modal con un fade
    modal.fadeIn(220);
    $('body').css('overflow', 'hidden'); // Evitar scroll de la página trasera
    
    if (typeof window.initComentariosEnVivo === 'function') {
      window.initComentariosEnVivo();
    }
  }

  function closeFBViewer() {
    var modal = $('#fb-viewer-modal');
    modal.fadeOut(200, function() {
      // Detener el polling limpiando el contenedor y los datos
      $('#fb-viewer-comments-target').data('id', '').data('post-id', '').html('');
      $('#fb-viewer-img').attr('src', '');
      $('body').css('overflow', ''); // Devolver scroll a la página
    });
  }

  // Click Trigger
  $(document).on('click', '.fb-viewer-trigger', function(e) {
    e.preventDefault();
    var trigger = $(this);
    var postId = trigger.attr('data-post-id') || trigger.data('post-id');
    var msg = trigger.attr('data-msg') || trigger.data('msg') || '';
    var authorName = trigger.attr('data-author-name') || trigger.data('author-name') || 'Secret User';
    var authorAvatar = trigger.attr('data-author-avatar') || trigger.data('author-avatar') || 'default.png';
    var postDate = trigger.attr('data-post-date') || trigger.data('post-date') || new Date().toISOString();
    var allImagesStr = trigger.attr('data-all-images') || trigger.data('all-images') || '';
    var currentIndex = parseInt(trigger.attr('data-current-index') || trigger.data('current-index') || '0', 10);
    
    var images = allImagesStr.split(',').map(function(img) { return img.trim(); }).filter(function(img) { return img !== '' && img !== '0' && img !== 'null'; });
    
    // Si la lista de todas las imágenes está vacía, pero el trigger tiene un href válido, úsalo como fallback
    if (images.length === 0) {
      var href = trigger.attr('href');
      if (href) {
        var parts = href.split('/');
        var filename = parts[parts.length - 1];
        if (filename) images = [filename];
      }
    }
    
    openFBViewer(postId, msg, authorName, authorAvatar, postDate, images, currentIndex);
  });

  // Botones de cerrar
  $(document).on('click', '.fb-viewer-close-btn', function(e) {
    e.preventDefault();
    closeFBViewer();
  });

  // Cerrar al hacer click fuera del panel lateral (en la zona oscura)
  $(document).on('click', '#fb-viewer-modal', function(e) {
    if ($(e.target).hasClass('fb-viewer-overlay') || $(e.target).hasClass('fb-viewer-media-col') || $(e.target).hasClass('fb-viewer-stage')) {
      closeFBViewer();
    }
  });

  // Navegación Izquierda
  $(document).on('click', '.fb-viewer-nav-left', function(e) {
    e.preventDefault();
    var modal = $('#fb-viewer-modal');
    var currentIndex = parseInt(modal.data('current-index') || '0', 10);
    if (currentIndex > 0) {
      modal.data('current-index', currentIndex - 1);
      renderFBViewerImage();
    }
  });

  // Navegación Derecha
  $(document).on('click', '.fb-viewer-nav-right', function(e) {
    e.preventDefault();
    var modal = $('#fb-viewer-modal');
    var images = modal.data('images') || [];
    var currentIndex = parseInt(modal.data('current-index') || '0', 10);
    if (currentIndex < images.length - 1) {
      modal.data('current-index', currentIndex + 1);
      renderFBViewerImage();
    }
  });

  // Teclado (Esc, Izquierda, Derecha)
  $(document).on('keydown', function(e) {
    if ($('#fb-viewer-modal').is(':visible')) {
      if (e.key === 'Escape') {
        closeFBViewer();
      } else if (e.key === 'ArrowLeft') {
        $('.fb-viewer-nav-left:visible').trigger('click');
      } else if (e.key === 'ArrowRight') {
        $('.fb-viewer-nav-right:visible').trigger('click');
      }
    }
  });

})();

