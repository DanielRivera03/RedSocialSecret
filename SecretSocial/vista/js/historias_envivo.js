$(document).ready(function () {

    // ─────────────────────────────────────────────
    //  INJECT MODALS & STYLES
    // ─────────────────────────────────────────────
    $('head').append(`
    <style id="historias-style">
        /* ── Story Ring ── */
        .story-avatar-ring {
            background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
            padding: 2px;
            border-radius: 50%;
            display: inline-block;
        }
        .story-avatar-ring.visto {
            background: #ccc;
        }
        .story-avatar-ring img {
            border: 2px solid #fff;
            border-radius: 50%;
            display: block;
            object-fit: cover;
        }

        /* ── Viewer Overlay ── */
        #historia-overlay {
            position: fixed;
            inset: 0;
            background: #000;
            z-index: 100000;
            display: none;
            flex-direction: row;
            align-items: center;
            justify-content: center;
        }
        #historia-overlay.open { display: flex; }

        /* ── Story Card ── */
        #story-card {
            position: relative;
            width: 100%;
            max-width: 400px;
            height: 100vh;
            max-height: 700px;
            border-radius: 12px;
            overflow: hidden;
            background: #111;
            user-select: none;
        }
        #story-bg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        #story-gradient-top {
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 120px;
            background: linear-gradient(to bottom, rgba(0,0,0,0.6), transparent);
            z-index: 2;
        }
        #story-gradient-bottom {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 200px;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            z-index: 2;
        }

        /* ── Progress Bars ── */
        #story-bars {
            position: absolute;
            top: 10px; left: 8px; right: 8px;
            display: flex;
            gap: 3px;
            z-index: 10;
        }
        .story-bar-segment {
            flex: 1;
            height: 2.5px;
            background: rgba(255,255,255,0.35);
            border-radius: 2px;
            overflow: hidden;
        }
        .story-bar-fill {
            height: 100%;
            background: #fff;
            width: 0%;
            transition: none;
        }

        /* ── Header ── */
        #story-header {
            position: absolute;
            top: 22px; left: 12px; right: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 10;
        }
        #story-header .s-avatar { width: 38px; height: 38px; }
        #story-header-name { color: #fff; font-weight: 700; font-size: 14px; flex: 1; text-shadow: 0 1px 3px rgba(0,0,0,0.6); }
        #story-header-time { color: rgba(255,255,255,0.75); font-size: 11px; }
        #story-close-btn {
            color: #fff;
            font-size: 26px;
            cursor: pointer;
            line-height: 1;
            text-shadow: 0 1px 4px rgba(0,0,0,0.5);
        }

        /* ── Story text overlay ── */
        #story-text-overlay {
            position: absolute;
            bottom: 120px; left: 16px; right: 16px;
            z-index: 10;
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            text-align: center;
            text-shadow: 0 2px 8px rgba(0,0,0,0.8);
        }

        /* ── View counter ── */
        #story-views-btn {
            position: absolute;
            bottom: 24px; left: 50%; transform: translateX(-50%);
            z-index: 100;
            display: flex;
            align-items: center;
            gap: 6px;
            color: rgba(255,255,255,0.9);
            font-size: 13px;
            cursor: pointer;
            background: rgba(0,0,0,0.4);
            border: 1px solid rgba(255,255,255,0.15);
            backdrop-filter: blur(8px);
            border-radius: 30px;
            padding: 8px 18px;
            transition: background 0.2s;
        }
        #story-views-btn:hover {
            background: rgba(0,0,0,0.6);
        }

        /* ── Story Footer (Reply & Like) ── */
        #story-footer {
            position: absolute;
            bottom: 16px; left: 12px; right: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 100;
        }
        #story-reply-input {
            flex: 1;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            border-radius: 24px;
            padding: 10px 16px;
            color: #fff;
            font-size: 14px;
            outline: none;
            backdrop-filter: blur(8px);
            transition: all 0.2s;
        }
        #story-reply-input:focus {
            background: rgba(255,255,255,0.25);
            border-color: rgba(255,255,255,0.5);
        }
        #story-reply-input::placeholder {
            color: rgba(255,255,255,0.7);
        }
        #story-like-btn {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            width: 42px; height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 20px;
            cursor: pointer;
            backdrop-filter: blur(8px);
            transition: all 0.2s;
        }
        #story-like-btn:hover {
            background: rgba(255,255,255,0.3);
            transform: scale(1.1);
        }
        #story-like-btn.liked {
            color: #ff304f;
            background: rgba(255, 48, 79, 0.15);
            border-color: rgba(255, 48, 79, 0.4);
            animation: heartBeat 0.3s ease-in-out;
        }
        @keyframes heartBeat {
            0% { transform: scale(1); }
            50% { transform: scale(1.3); }
            100% { transform: scale(1); }
        }

        /* ── Nav areas ── */
        #story-prev-zone, #story-next-zone {
            position: absolute;
            top: 0; bottom: 80px; /* Don't cover reply area */
            width: 30%;
            z-index: 5;
            cursor: pointer;
        }
        #story-prev-zone { left: 0; }
        #story-next-zone { right: 0; }

        /* ── Side nav arrows (desktop) ── */
        .story-side-btn {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(4px);
            border: 1px solid rgba(255,255,255,0.3);
            color: #fff;
            font-size: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            margin: 0 12px;
            transition: background 0.2s;
        }
        .story-side-btn:hover { background: rgba(255,255,255,0.3); }

        /* ── Espectadores modal ── */
        #espectadores-modal {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.6);
            z-index: 100001;
            display: none;
            align-items: flex-end;
            justify-content: center;
        }
        #espectadores-modal.open { display: flex; }
        #espectadores-panel {
            background: #fff;
            width: 100%;
            max-width: 400px;
            border-radius: 16px 16px 0 0;
            padding: 20px;
            max-height: 60vh;
            overflow-y: auto;
        }
        body.dark-mode #espectadores-panel {
            background: #242526;
            color: #e4e6eb;
        }

        /* ── Story item in bar (Circular Bubbles) ── */
        .historia-item-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 70px;
            cursor: pointer;
            flex-shrink: 0;
        }
        .historia-item-wrapper p {
            margin-top: 6px;
            font-size: 11px;
            color: #333;
            max-width: 68px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            text-align: center;
        }
        body.dark-mode .historia-item-wrapper p {
            color: #b0b3b8;
        }

        /* ── Modal Crear Historia ── */
        #crear-historia-modal {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.85);
            z-index: 100005;
            display: none;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-family: 'Inter', sans-serif;
        }
        #crear-historia-modal.open { display: flex; }
        #crear-historia-card {
            background: #1e1e1e;
            width: 90%;
            max-width: 450px;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.5);
            border: 1px solid rgba(255,255,255,0.1);
        }
        #crear-historia-card h5 {
            color: #fff; font-weight: 700; margin-bottom: 20px;
        }
        .ch-input-group {
            margin-bottom: 16px;
        }
        .ch-input-group label {
            display: block; font-size: 13px; color: #aaa; margin-bottom: 6px;
        }
        .ch-input-group textarea {
            width: 100%; background: #2d2d2d; border: 1px solid #444; border-radius: 8px;
            color: #fff; padding: 10px; font-size: 14px; outline: none; resize: none;
        }
        .ch-input-group input[type="file"] {
            display: none;
        }
        .ch-file-btn {
            background: #2d2d2d; border: 1px dashed #555; border-radius: 8px;
            padding: 20px; text-align: center; cursor: pointer; color: #bbb;
            display: block;
            transition: all 0.2s;
        }
        .ch-file-btn:hover { background: #3d3d3d; color: #fff; }
        .ch-btn-primary {
            background: #1877f2; color: #fff; border: none; border-radius: 8px;
            padding: 12px; width: 100%; font-weight: 600; cursor: pointer;
            transition: background 0.2s;
        }
        .ch-btn-primary:hover { background: #1565c0; }
        .ch-btn-close {
            background: transparent; color: #aaa; border: none; float: right;
            font-size: 20px; cursor: pointer; padding: 0; line-height: 1;
        }
        .ch-btn-close:hover { color: #fff; }
    </style>
    `);

    // ── Overlay & Creator Modals HTML ──
    let overlayHtml = `
    <div id="historia-overlay">
        <div class="story-side-btn" id="story-prev-global"><i class="ri-arrow-left-s-line"></i></div>

        <div id="story-card">
            <div id="story-bars"></div>
            <div id="story-gradient-top"></div>
            <div id="story-gradient-bottom"></div>

            <img id="story-bg" src="" alt="">
            <div id="story-header">
                <div class="story-avatar-ring s-avatar" id="story-header-ring">
                    <img id="story-header-avatar" src="" width="34" height="34">
                </div>
                <span id="story-header-name"></span>
                <span id="story-header-time"></span>
                <span id="story-close-btn"><i class="ri-close-line"></i></span>
            </div>

            <div id="story-text-overlay"></div>
            
            <div id="story-views-btn" style="display:none;">
                <i class="ri-eye-line" style="font-size:14px;"></i>
                <span id="story-views-count">0</span> vistas
                <i class="ri-heart-fill" style="font-size:14px; margin-left:10px; color:#ff304f;"></i>
                <span id="story-likes-count">0</span>
            </div>

            <div id="story-footer" style="display:none;">
                <input type="text" id="story-reply-input" placeholder="Enviar mensaje..." autocomplete="off">
                <button id="story-like-btn" title="Me gusta"><i class="ri-heart-line"></i></button>
            </div>

            <div id="story-prev-zone"></div>
            <div id="story-next-zone"></div>
        </div>

        <div class="story-side-btn" id="story-next-global"><i class="ri-arrow-right-s-line"></i></div>
    </div>

    <div id="espectadores-modal">
        <div id="espectadores-panel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="m-0 font-weight-bold">Espectadores y Reacciones</h6>
                <i class="ri-close-line" id="close-espectadores" style="font-size:22px; cursor:pointer;"></i>
            </div>
            <div id="espectadores-list"></div>
        </div>
    </div>
    
    <div id="crear-historia-modal">
        <div id="crear-historia-card">
            <button class="ch-btn-close" id="close-crear-historia"><i class="ri-close-line"></i></button>
            <h5 class="mt-0">Crear Nueva Historia</h5>
            
            <form id="ch-form" enctype="multipart/form-data">
                <div class="ch-input-group">
                    <label>Escribe algo en tu historia (Opcional)</label>
                    <textarea id="ch-text" placeholder="¿Qué quieres compartir en tu historia?" rows="3" maxlength="150"></textarea>
                </div>
                
                <div class="ch-input-group">
                    <label>Imagen de la historia (Opcional si escribes texto)</label>
                    <label for="ch-file" class="ch-file-btn" id="ch-file-label">
                        <i class="ri-image-add-line" style="font-size: 32px; display: block; margin-bottom: 6px;"></i>
                        Seleccionar Foto
                    </label>
                    <input type="file" id="ch-file" name="foto" accept="image/*">
                    <div id="ch-preview-container" style="display:none; margin-top: 12px; position:relative; text-align:center;">
                        <img id="ch-preview-img" src="" style="max-height: 200px; border-radius: 8px; max-width:100%;">
                        <button type="button" id="ch-remove-photo" style="position:absolute; top: 8px; right: 8px; background: rgba(0,0,0,0.6); border:none; color:#fff; border-radius:50%; width:24px; height:24px; display:flex; align-items:center; justify-content:center; cursor:pointer;"><i class="ri-close-line"></i></button>
                    </div>
                </div>
                
                <button type="submit" class="ch-btn-primary" id="ch-submit-btn">Publicar Historia</button>
            </form>
        </div>
    </div>
    `;

    $('body').append(overlayHtml);

    // ─────────────────────────────────────────────
    //  STATE
    // ─────────────────────────────────────────────
    let allHistorias = [];       // flat list
    let userGroups = [];         // [{userId, nombre, fotoperfil, items:[…]}]
    let curGroupIdx = 0;
    let curStoryIdx = 0;
    let storyDuration = 5000;    // ms per story

    // New Pausable Tick Loop variables
    let isPaused = false;
    let elapsedTime = 0;
    let lastUpdateTime = 0;
    let animFrameId = null;

    let miIdUsuario = $('#mi-id-usuario').val() || '0';
    let miFotoPerfil = $('#mi-foto-perfil').val() || 'user-default.png';

    // ─────────────────────────────────────────────
    //  LOAD & RENDER BAR
    // ─────────────────────────────────────────────
    function loadHistorias() {
        $.get('../controlador/cHistorias.php?accion=listar', function (data) {
            allHistorias = data;

            // Group by user
            let map = {};
            let order = [];
            data.forEach(h => {
                if (!map[h.id_usuario]) {
                    map[h.id_usuario] = {
                        userId: h.id_usuario,
                        nombre: h.nombres,
                        apellidos: h.apellidos,
                        fotoperfil: h.fotoperfil,
                        items: [],
                        anyUnseen: false
                    };
                    order.push(h.id_usuario);
                }
                map[h.id_usuario].items.push(h);
                if (h.visto == '0') map[h.id_usuario].anyUnseen = true;
            });
            userGroups = order.map(uid => map[uid]);

            renderStoriesBar();
        });
    }

    function renderStoriesBar() {
        let target = $('#historias-envivo-container');
        if (!target.length) {
            // fallback
            if (!$('#historias-container').length) {
                let containerHtml = `
                <div class="iq-card">
                    <div class="iq-card-body p-3">
                        <div id="historias-container" class="d-flex align-items-center pb-2" style="overflow-x:auto; gap:12px; scrollbar-width:none; -ms-overflow-style:none;"></div>
                    </div>
                </div>`;
                if ($('#post-modal-data').length) {
                    $('#post-modal-data').before(containerHtml);
                }
            }
        } else {
            // Inject inside target
            if (!$('#historias-container').length) {
                target.html(`
                <div class="iq-card">
                    <div class="iq-card-body p-3">
                        <div id="historias-container" class="d-flex align-items-center pb-2" style="overflow-x:auto; gap:12px; scrollbar-width:none; -ms-overflow-style:none;"></div>
                    </div>
                </div>`);
            }
        }

        let hasMyStories = false;
        let myGroupIdx = -1;
        userGroups.forEach((g, idx) => {
            if (parseInt(g.userId) === parseInt(miIdUsuario)) {
                hasMyStories = true;
                myGroupIdx = idx;
            }
        });

        // Always show the circular "Tu historia" bubble first (unifying creation and viewing)
        let myStoryHtml = '';
        if (hasMyStories) {
            let myGroup = userGroups[myGroupIdx];
            let ringClass = myGroup.anyUnseen ? 'has-stories' : '';
            myStoryHtml = `
            <div class="story-bubble-wrapper story-group-item" data-group="${myGroupIdx}">
                <div class="story-bubble ${ringClass}">
                    <img src="../vista/images/fotosperfiles/${miFotoPerfil}" alt="Tú">
                    <div class="story-bubble-add-btn btn-crear-historia">+</div>
                </div>
                <div class="story-bubble-label">Tu historia</div>
            </div>`;
        } else {
            myStoryHtml = `
            <div class="story-bubble-wrapper btn-crear-historia-direct">
                <div class="story-bubble">
                    <img src="../vista/images/fotosperfiles/${miFotoPerfil}" alt="Tú">
                    <div class="story-bubble-add-btn">+</div>
                </div>
                <div class="story-bubble-label">Tu historia</div>
            </div>`;
        }

        let html = '';
        userGroups.forEach((g, idx) => {
            if (parseInt(g.userId) === parseInt(miIdUsuario)) {
                return; // Already handled
            }
            let ringClass = g.anyUnseen ? 'has-stories' : '';
            html += `
            <div class="story-bubble-wrapper story-group-item" data-group="${idx}">
                <div class="story-bubble ${ringClass}">
                    <img src="../vista/images/fotosperfiles/${g.fotoperfil}" alt="${g.nombre}">
                </div>
                <div class="story-bubble-label">${g.nombre} ${g.apellidos || ''}</div>
            </div>`;
        });

        $('#historias-container').html(myStoryHtml + html);
    }

    // ─────────────────────────────────────────────
    //  OPEN / NAVIGATE
    // ─────────────────────────────────────────────
    $(document).on('click', '.story-group-item', function (e) {
        // If they click the + button, open the creation modal instead of playing
        if ($(e.target).closest('.btn-crear-historia').length > 0) {
            e.preventDefault();
            e.stopPropagation();
            $('#crear-historia-modal').addClass('open');
            return;
        }
        curGroupIdx = parseInt($(this).data('group'));
        curStoryIdx = 0;
        openStory();
    });

    $(document).on('click', '.btn-crear-historia-direct', function (e) {
        e.preventDefault();
        $('#crear-historia-modal').addClass('open');
    });


    function openStory() {
        let group = userGroups[curGroupIdx];
        if (!group) return closeStory();

        let story = group.items[curStoryIdx];
        if (!story) {
            // try next group
            curGroupIdx++;
            curStoryIdx = 0;
            if (curGroupIdx >= userGroups.length) return closeStory();
            return openStory();
        }

        // Build progress bars for this group
        let barsHtml = group.items.map((_, i) => `<div class="story-bar-segment"><div class="story-bar-fill" id="bar-fill-${i}"></div></div>`).join('');
        $('#story-bars').html(barsHtml);

        // Fill past bars
        for (let i = 0; i < curStoryIdx; i++) {
            $(`#bar-fill-${i}`).css('width', '100%');
        }

        // Show overlay
        $('#historia-overlay').addClass('open');

        showStory(story, group);

        // Register view
        $.post('../controlador/cHistorias.php?accion=registrar_vista', { id_historia: story.id });
    }

    function showStory(story, group) {
        // Cancel any running animation frames
        cancelAnimationFrame(animFrameId);

        // Reset state for pausable tick
        isPaused = false;
        elapsedTime = 0;
        lastUpdateTime = Date.now();

        // Background image or color
        if (story.foto && story.foto.trim() !== '') {
            $('#story-bg').attr('src', '../vista/images/fotospublicaciones/' + story.foto).show();
        } else {
            $('#story-bg').attr('src', '').hide();
            $('#story-card').css('background', generateGradient(group.nombre));
        }

        // Header
        $('#story-header-avatar').attr('src', '../vista/images/fotosperfiles/' + group.fotoperfil);
        $('#story-header-name').text(group.nombre + ' ' + (group.apellidos || ''));
        let hrs = Math.max(0, Math.floor((story.tiempo_restante || 0) / 3600));
        let mins = Math.max(0, Math.floor(((story.tiempo_restante || 0) % 3600) / 60));
        $('#story-header-time').text(hrs > 0 ? hrs + 'h' : mins + 'm');

        // Text
        $('#story-text-overlay').text(story.texto || '');

        // Setup views vs reply based on ownership
        if (parseInt(story.id_usuario) === parseInt(miIdUsuario)) {
            // Owner: show views btn and like counts
            $('#story-views-btn').show().data('id', story.id);
            $('#story-views-count').text(story.total_vistas || 0);
            $('#story-likes-count').text(story.total_me_gusta || 0);
            $('#story-footer').hide();
        } else {
            // Viewer: show reply & like button
            $('#story-views-btn').hide();
            $('#story-footer').show().data('id', story.id);
            $('#story-reply-input').val('');
            
            // Setup like button state
            let likeBtn = $('#story-like-btn');
            likeBtn.data('id', story.id);
            if (parseInt(story.me_gusta) === 1) {
                likeBtn.addClass('liked').html('<i class="ri-heart-fill"></i>');
            } else {
                likeBtn.removeClass('liked').html('<i class="ri-heart-line"></i>');
            }
        }

        // Run progress bar loop
        startStoryTimer();
    }

    function startStoryTimer() {
        function tick() {
            if (!isPaused) {
                let now = Date.now();
                elapsedTime += (now - lastUpdateTime);
                lastUpdateTime = now;

                let pct = Math.min((elapsedTime / storyDuration) * 100, 100);
                $(`#bar-fill-${curStoryIdx}`).css('width', pct + '%');

                if (elapsedTime >= storyDuration) {
                    nextStory();
                    return;
                }
            } else {
                lastUpdateTime = Date.now();
            }
            animFrameId = requestAnimationFrame(tick);
        }
        animFrameId = requestAnimationFrame(tick);
    }

    function nextStory() {
        let group = userGroups[curGroupIdx];
        if (!group) return closeStory();

        curStoryIdx++;
        if (curStoryIdx >= group.items.length) {
            curGroupIdx++;
            curStoryIdx = 0;
            if (curGroupIdx >= userGroups.length) return closeStory();
        }
        openStory();
    }

    function prevStory() {
        curStoryIdx--;
        if (curStoryIdx < 0) {
            curGroupIdx--;
            if (curGroupIdx < 0) {
                curGroupIdx = 0;
                curStoryIdx = 0;
                return;
            }
            curStoryIdx = Math.max(0, userGroups[curGroupIdx].items.length - 1);
        }
        openStory();
    }

    function closeStory() {
        cancelAnimationFrame(animFrameId);
        $('#historia-overlay').removeClass('open');
        loadHistorias(); // refresh rings
    }

    function generateGradient(name) {
        const gradients = [
            'linear-gradient(135deg, #667eea, #764ba2)',
            'linear-gradient(135deg, #f093fb, #f5576c)',
            'linear-gradient(135deg, #4facfe, #00f2fe)',
            'linear-gradient(135deg, #43e97b, #38f9d7)',
            'linear-gradient(135deg, #fa709a, #fee140)',
            'linear-gradient(135deg, #a18cd1, #fbc2eb)',
        ];
        let idx = (name.charCodeAt(0) || 0) % gradients.length;
        return gradients[idx];
    }

    // ── Navigation clicks ──
    $('#story-next-zone, #story-next-global').click(function (e) { e.stopPropagation(); nextStory(); });
    $('#story-prev-zone, #story-prev-global').click(function (e) { e.stopPropagation(); prevStory(); });
    $('#story-close-btn').click(function () { closeStory(); });

    // ─────────────────────────────────────────────
    //  LIKE STORY
    // ─────────────────────────────────────────────
    $(document).on('click', '#story-like-btn', function (e) {
        e.stopPropagation();
        let id = $(this).data('id');
        let btn = $(this);
        
        $.post('../controlador/cHistorias.php?accion=dar_megusta', { id_historia: id }, function(res) {
            if(res.status === 'OK') {
                if(res.liked) {
                    btn.addClass('liked').html('<i class="ri-heart-fill"></i>');
                } else {
                    btn.removeClass('liked').html('<i class="ri-heart-line"></i>');
                }
                
                // Update internal data so if we click next/prev and return, it stays liked
                let story = userGroups[curGroupIdx].items[curStoryIdx];
                if(story && story.id == id) {
                    story.me_gusta = res.liked ? 1 : 0;
                    story.total_me_gusta = res.total;
                }
            }
        });
    });

    // ─────────────────────────────────────────────
    //  REPLY TO STORY (CHAT INTEGRATION)
    // ─────────────────────────────────────────────
    $(document).on('focus', '#story-reply-input', function() {
        isPaused = true;
    });

    $(document).on('blur', '#story-reply-input', function() {
        // Delay resume slightly in case they clicked Send button
        setTimeout(() => {
            if(!$('#espectadores-modal').hasClass('open') && $('#historia-overlay').hasClass('open') && isPaused && document.activeElement !== document.getElementById('story-reply-input')) {
                isPaused = false;
                lastUpdateTime = Date.now();
            }
        }, 300);
    });

    $(document).on('keypress', '#story-reply-input', function(e) {
        if(e.which === 13) { // Enter key
            let id = $('#story-footer').data('id');
            let txt = $(this).val().trim();
            if(!txt) return;
            
            let inputField = $(this);
            inputField.prop('disabled', true);
            
            $.post('../controlador/cHistorias.php?accion=responder_historia', { id_historia: id, mensaje: txt }, function(res) {
                inputField.prop('disabled', false);
                if(res.status === 'OK') {
                    inputField.val('');
                    inputField.blur();
                    
                    if(window.SN) {
                        window.SN.success("Respuesta enviada", "Tu respuesta ha sido enviada por mensaje privado.");
                    } else {
                        alert("Mensaje enviado por privado.");
                    }
                    
                    // Resume play
                    isPaused = false;
                    lastUpdateTime = Date.now();
                } else {
                    if(window.SN) {
                        window.SN.error("Error", res.error || "No se pudo enviar la respuesta.");
                    } else {
                        alert(res.error || "Error al enviar.");
                    }
                }
            });
        }
    });

    // ── Views / Spectators modal ──
    $(document).on('click', '#story-views-btn', function () {
        let id = $(this).data('id');
        isPaused = true;
        
        $.get('../controlador/cHistorias.php?accion=ver_espectadores&id_historia=' + id, function (data) {
            let html = data.length === 0
                ? '<p class="text-center text-muted py-3">Nadie ha visto esta historia aún.</p>'
                : data.map(v => `
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center">
                            <img src="../vista/images/fotosperfiles/${v.fotoperfil}" class="rounded-circle mr-3" width="38" height="38" style="object-fit:cover;">
                            <div>
                                <strong style="font-size:14px;">${v.nombres} ${v.apellidos}</strong>
                                <br><small class="text-muted">${v.fecha_vista || ''}</small>
                            </div>
                        </div>
                        <div>
                            ${v.liked == 1 ? '<i class="ri-heart-fill" style="color:#ff304f; font-size:18px;" title="Le gustó tu historia"></i>' : ''}
                        </div>
                    </div>`).join('');
            $('#espectadores-list').html(html);
            $('#espectadores-modal').addClass('open');
        });
    });

    $('#close-espectadores').click(function () {
        $('#espectadores-modal').removeClass('open');
        // resume story
        isPaused = false;
        lastUpdateTime = Date.now();
    });

    // ─────────────────────────────────────────────
    //  CREATING NEW STORIES
    // ─────────────────────────────────────────────
    $(document).on('click', '#btn-crear-historia, #btn-crear-historia-bubble', function (e) {
        e.preventDefault();
        $('#crear-historia-modal').addClass('open');
    });

    $('#close-crear-historia').click(function() {
        $('#crear-historia-modal').removeClass('open');
        resetCrearHistoriaForm();
    });

    // Preview photo selection
    $('#ch-file').change(function() {
        if (this.files && this.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#ch-preview-img').attr('src', e.target.result);
                $('#ch-preview-container').show();
                $('#ch-file-label').html('<i class="ri-image-edit-line" style="font-size: 24px;"></i> Cambiar Foto');
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    $('#ch-remove-photo').click(function(e) {
        e.preventDefault();
        $('#ch-file').val('');
        $('#ch-preview-container').hide();
        $('#ch-preview-img').attr('src', '');
        $('#ch-file-label').html('<i class="ri-image-add-line" style="font-size: 32px; display: block; margin-bottom: 6px;"></i> Seleccionar Foto');
    });

    function resetCrearHistoriaForm() {
        $('#ch-text').val('');
        $('#ch-file').val('');
        $('#ch-preview-container').hide();
        $('#ch-preview-img').attr('src', '');
        $('#ch-file-label').html('<i class="ri-image-add-line" style="font-size: 32px; display: block; margin-bottom: 6px;"></i> Seleccionar Foto');
    }

    // Submit new story
    $('#ch-form').submit(function(e) {
        e.preventDefault();
        
        let textVal = $('#ch-text').val().trim();
        let fileVal = $('#ch-file').val();
        
        if (!textVal && !fileVal) {
            if(window.SN) {
                window.SN.error("Campos vacíos", "Por favor ingresa un texto o selecciona una foto para tu historia.");
            } else {
                alert("Por favor ingresa un texto o selecciona una foto.");
            }
            return;
        }
        
        let formData = new FormData();
        formData.append('texto', textVal);
        if ($('#ch-file')[0].files[0]) {
            formData.append('foto', $('#ch-file')[0].files[0]);
        }
        
        $('#ch-submit-btn').prop('disabled', true).text('Publicando...');
        
        $.ajax({
            url: '../controlador/cHistorias.php?accion=crear',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                $('#ch-submit-btn').prop('disabled', false).text('Publicar Historia');
                if (res.status === 'OK') {
                    $('#crear-historia-modal').removeClass('open');
                    resetCrearHistoriaForm();
                    if(window.SN) {
                        window.SN.success("Historia publicada", "Tu historia se ha publicado correctamente.");
                    } else {
                        alert("Historia publicada con éxito.");
                    }
                    loadHistorias(); // Reload stories bar
                } else {
                    if(window.SN) {
                        window.SN.error("Error", res.error || "No se pudo publicar la historia.");
                    } else {
                        alert(res.error || "Error al publicar.");
                    }
                }
            },
            error: function() {
                $('#ch-submit-btn').prop('disabled', false).text('Publicar Historia');
                if(window.SN) {
                    window.SN.error("Error", "Error de conexión con el servidor.");
                } else {
                    alert("Error de conexión.");
                }
            }
        });
    });

    // ── Touch swipe support ──
    let touchStartX = 0;
    $('#story-card').on('touchstart', function (e) { touchStartX = e.originalEvent.touches[0].clientX; });
    $('#story-card').on('touchend', function (e) {
        let dx = e.originalEvent.changedTouches[0].clientX - touchStartX;
        if (Math.abs(dx) > 50) { dx < 0 ? nextStory() : prevStory(); }
    });

    // ─────────────────────────────────────────────
    //  INIT
    // ─────────────────────────────────────────────
    if ($('#post-modal-data').length > 0) {
        loadHistorias();
    }
});
