$(document).ready(function() {
    let myAvatar = $('.caption').prev('img').attr('src') || '../vista/images/user/1.jpg';

    // Inject Music Notes Bar at the very top
    let barHtml = `
    <div class="iq-card">
        <div class="iq-card-body p-3">
            <h6 class="mb-3" style="color:#b92025;"><i class="ri-music-2-line"></i> Notas de Música</h6>
            <div id="notas-container" class="d-flex align-items-end pb-3" style="overflow-x:auto; gap:25px; scrollbar-width:none; padding-top:40px;">
                
                <!-- Boton Crear Nota -->
                <div class="text-center" style="cursor:pointer; position:relative;" data-toggle="modal" data-target="#nota-modal">
                    <div style="position:relative; width:60px; height:60px; border-radius:50%; border:2px solid #ddd; padding:2px; margin:0 auto;">
                        <img src="${myAvatar}" class="rounded-circle w-100 h-100" style="object-fit:cover;">
                        <div style="position:absolute; bottom:-5px; right:-5px; background:#b92025; color:#fff; border-radius:50%; width:22px; height:22px; font-size:14px; display:flex; align-items:center; justify-content:center; border:2px solid #fff;">
                            <i class="ri-add-line"></i>
                        </div>
                    </div>
                    <p class="mb-0 mt-2 text-muted" style="font-size:12px;">Tu Nota</p>
                </div>
                
            </div>
        </div>
    </div>
    
    <!-- Modal Rediseñado y Limpio -->
    <div class="modal fade" id="nota-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 640px;">
            <div class="modal-content" style="border-radius:15px; border:none; box-shadow:0 10px 30px rgba(0,0,0,0.2);">
                <div class="modal-body p-0 bg-white" style="border-radius:15px; overflow:hidden;">
                    
                    <ul class="nav nav-pills d-flex justify-content-between" id="pills-tab" role="tablist" style="border-bottom:1px solid #eee;">
                        <li class="nav-item flex-fill text-center">
                            <a class="nav-link active text-danger" id="pills-texto-tab" data-toggle="pill" href="#pills-texto" style="background:transparent; padding:15px 10px; font-weight:500; border-radius:0;">Solo Texto</a>
                        </li>
                        <li class="nav-item flex-fill text-center">
                            <a class="nav-link text-muted" id="pills-itunes-tab" data-toggle="pill" href="#pills-itunes" role="tab" style="background:transparent; padding:15px 10px; font-weight:500; border-radius:0;">Música</a>
                        </li>
                        <li class="nav-item flex-fill text-center">
                            <a class="nav-link text-muted" id="pills-record-tab" data-toggle="pill" href="#pills-record" style="background:transparent; padding:15px 10px; font-weight:500; border-radius:0;">Grabar (Max 30s)</a>
                        </li>
                    </ul>
                    
                    <div class="tab-content p-4" id="pills-tabContent">
                        
                        <!-- Solo Texto Tab -->
                        <div class="tab-pane fade show active" id="pills-texto">
                            <textarea id="nota-texto-only" class="form-control mb-4" rows="4" placeholder="Escribe lo que estás pensando..." style="border-radius:10px; border:1px solid #ddd; padding:15px; resize:none;"></textarea>
                            <button class="btn w-100 shadow-sm" id="btn-publicar-texto" style="background:#b92025; color:#fff; border-radius:8px; padding:12px; font-weight:bold;">Publicar Nota</button>
                        </div>

                        <!-- Música Tab - Premium Redesign -->
                        <div class="tab-pane fade" id="pills-itunes" role="tabpanel">
                            <style>
                                #music-search-wrap {
                                    position: relative;
                                }
                                #music-search-wrap .search-icon {
                                    position: absolute;
                                    left: 14px; top: 50%;
                                    transform: translateY(-50%);
                                    color: #aaa;
                                    font-size: 18px;
                                    pointer-events: none;
                                }
                                #itunes-search {
                                    border-radius: 50px;
                                    border: 1.5px solid #e8e8e8;
                                    padding: 11px 16px 11px 42px;
                                    font-size: 14px;
                                    background: #f9f9f9;
                                    transition: border 0.2s, box-shadow 0.2s;
                                    width: 100%;
                                }
                                #itunes-search:focus {
                                    border-color: #b92025;
                                    box-shadow: 0 0 0 3px rgba(185,32,37,0.08);
                                    outline: none;
                                    background: #fff;
                                }
                                #itunes-results {
                                    max-height: 230px;
                                    overflow-y: auto;
                                    scrollbar-width: thin;
                                }
                                #itunes-results::-webkit-scrollbar { width: 4px; }
                                #itunes-results::-webkit-scrollbar-thumb { background: #ddd; border-radius: 4px; }

                                .select-itunes {
                                    display: flex;
                                    align-items: center;
                                    gap: 12px;
                                    padding: 8px 6px;
                                    border-radius: 10px;
                                    cursor: pointer;
                                    transition: background 0.15s;
                                    border: none;
                                    background: transparent;
                                }
                                .select-itunes:hover { background: #f5f5f5; }
                                .select-itunes .art-wrap {
                                    position: relative;
                                    width: 48px; height: 48px;
                                    flex-shrink: 0;
                                }
                                .select-itunes .art-wrap img {
                                    width: 100%; height: 100%;
                                    border-radius: 8px;
                                    object-fit: cover;
                                }
                                .select-itunes .art-wrap .play-hover {
                                    position: absolute; inset: 0;
                                    background: rgba(0,0,0,0.3);
                                    border-radius: 8px;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    opacity: 0;
                                    transition: opacity 0.15s;
                                }
                                .select-itunes:hover .play-hover { opacity: 1; }

                                /* ── Premium Player Card ── */
                                #premium-player-card {
                                    background: linear-gradient(145deg, #1a1a2e 0%, #16213e 60%, #0f3460 100%);
                                    border-radius: 20px;
                                    padding: 20px;
                                    color: #fff;
                                    position: relative;
                                    overflow: hidden;
                                }
                                #premium-player-card::before {
                                    content: '';
                                    position: absolute;
                                    top: -40px; right: -40px;
                                    width: 130px; height: 130px;
                                    border-radius: 50%;
                                    background: rgba(185,32,37,0.15);
                                    filter: blur(20px);
                                }
                                #player-album-art {
                                    width: 72px; height: 72px;
                                    border-radius: 12px;
                                    object-fit: cover;
                                    box-shadow: 0 8px 24px rgba(0,0,0,0.5);
                                    flex-shrink: 0;
                                }
                                #player-song-name {
                                    font-size: 15px;
                                    font-weight: 700;
                                    letter-spacing: 0.3px;
                                    white-space: nowrap;
                                    overflow: hidden;
                                    text-overflow: ellipsis;
                                }
                                #player-artist-name {
                                    font-size: 12px;
                                    color: rgba(255,255,255,0.55);
                                    white-space: nowrap;
                                    overflow: hidden;
                                    text-overflow: ellipsis;
                                    text-transform: uppercase;
                                    letter-spacing: 0.8px;
                                }
                                /* Equalizer bars */
                                .eq-bar {
                                    width: 3px;
                                    border-radius: 3px;
                                    background: #b92025;
                                    transform-origin: bottom;
                                }
                                #eq-bars.playing .eq-bar { animation: eq-bounce 0.7s ease-in-out infinite alternate; }
                                #eq-bars.playing .eq-bar:nth-child(2) { animation-delay: 0.12s; }
                                #eq-bars.playing .eq-bar:nth-child(3) { animation-delay: 0.24s; }
                                #eq-bars.playing .eq-bar:nth-child(4) { animation-delay: 0.36s; }
                                #eq-bars.playing .eq-bar:nth-child(5) { animation-delay: 0.18s; }
                                @keyframes eq-bounce {
                                    from { transform: scaleY(0.3); }
                                    to   { transform: scaleY(1.0); }
                                }
                                /* Scrubber track */
                                #scrubber-track {
                                    position: relative;
                                    height: 4px;
                                    background: rgba(255,255,255,0.15);
                                    border-radius: 4px;
                                    cursor: pointer;
                                }
                                #scrubber-filled {
                                    position: absolute;
                                    left: 0; top: 0;
                                    height: 100%;
                                    background: linear-gradient(90deg, #b92025, #e53935);
                                    border-radius: 4px;
                                    width: 0%;
                                }
                                #scrubber-thumb {
                                    position: absolute;
                                    top: 50%;
                                    transform: translate(-50%, -50%);
                                    width: 14px; height: 14px;
                                    background: #fff;
                                    border-radius: 50%;
                                    box-shadow: 0 2px 8px rgba(0,0,0,0.4);
                                    left: 0%;
                                    cursor: grab;
                                }
                                /* Clip window highlight */
                                #clip-highlight {
                                    position: absolute;
                                    top: -3px;
                                    height: 10px;
                                    background: rgba(255,255,255,0.25);
                                    border-radius: 4px;
                                    pointer-events: none;
                                }
                                /* Big play button */
                                #player-play-btn {
                                    width: 44px; height: 44px;
                                    border-radius: 50%;
                                    border: none;
                                    background: #b92025;
                                    color: #fff;
                                    font-size: 18px;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    cursor: pointer;
                                    box-shadow: 0 4px 14px rgba(185,32,37,0.5);
                                    transition: transform 0.1s, box-shadow 0.1s;
                                    flex-shrink: 0;
                                }
                                #player-play-btn:hover { transform: scale(1.08); box-shadow: 0 6px 18px rgba(185,32,37,0.65); }
                                #change-song-btn {
                                    font-size: 11px;
                                    color: rgba(255,255,255,0.5);
                                    background: rgba(255,255,255,0.08);
                                    border: 1px solid rgba(255,255,255,0.15);
                                    border-radius: 20px;
                                    padding: 3px 12px;
                                    cursor: pointer;
                                    transition: all 0.2s;
                                    white-space: nowrap;
                                }
                                #change-song-btn:hover {
                                    background: rgba(255,255,255,0.15);
                                    color: #fff;
                                }
                            </style>

                            <!-- Search bar (always visible) -->
                            <div id="music-search-wrap" class="mb-3">
                                <i class="ri-search-line search-icon"></i>
                                <input type="text" id="itunes-search" placeholder="Busca artista o canción...">
                            </div>

                            <!-- Search Results -->
                            <div id="itunes-results" class="mb-3"></div>

                            <!-- Premium Player (hidden until song selected) -->
                            <div id="itunes-trimmer-container" class="d-none mb-3">
                                <div id="premium-player-card">
                                    <!-- Row 1: Art + Info + EQ + Change -->
                                    <div class="d-flex align-items-center mb-3" style="gap:14px;">
                                        <img id="player-album-art" src="" alt="">
                                        <div style="flex:1; min-width:0;">
                                            <div id="player-song-name">---</div>
                                            <div id="player-artist-name">---</div>
                                            <div class="mt-1" style="font-size:10px; color:rgba(255,255,255,0.35); letter-spacing:0.5px;">SELECCIÓN DE 15s</div>
                                        </div>
                                        <!-- EQ bars -->
                                        <div id="eq-bars" class="d-flex align-items-end" style="gap:2px; height:20px; margin-right:4px;">
                                            <div class="eq-bar" style="height:6px;"></div>
                                            <div class="eq-bar" style="height:14px;"></div>
                                            <div class="eq-bar" style="height:10px;"></div>
                                            <div class="eq-bar" style="height:18px;"></div>
                                            <div class="eq-bar" style="height:8px;"></div>
                                        </div>
                                        <button id="change-song-btn"><i class="ri-refresh-line"></i> Cambiar</button>
                                    </div>

                                    <!-- Row 2: Scrubber -->
                                    <div class="mb-3">
                                        <div id="scrubber-track">
                                            <div id="clip-highlight"></div>
                                            <div id="scrubber-filled"></div>
                                            <div id="scrubber-thumb"></div>
                                            <input type="range" id="audio-trimmer" min="0" max="15" value="0"
                                                style="position:absolute; inset:0; width:100%; height:100%; opacity:0; cursor:pointer; margin:0; z-index:5;">
                                        </div>
                                        <div class="d-flex justify-content-between mt-1">
                                            <span id="trimmer-time-display" style="font-size:10px; color:rgba(255,255,255,0.5);">0:00</span>
                                            <span style="font-size:10px; color:rgba(255,255,255,0.5);">0:30</span>
                                        </div>
                                    </div>

                                    <!-- Row 3: Play controls + clip label -->
                                    <div class="d-flex align-items-center" style="gap:12px;">
                                        <button id="player-play-btn" id="trimmer-play-btn">
                                            <i class="ri-play-fill" style="margin-left:2px;"></i>
                                        </button>
                                        <div style="flex:1;">
                                            <div style="font-size:11px; color:rgba(255,255,255,0.6); margin-bottom:2px;">FRAGMENTO SELECCIONADO</div>
                                            <div id="clip-range-label" style="font-size:13px; font-weight:700; letter-spacing:0.5px;">0:00 &rarr; 0:15</div>
                                        </div>
                                        <div style="text-align:right;">
                                            <div style="font-size:10px; color:rgba(255,255,255,0.4);">DURACIÓN</div>
                                            <div style="font-size:13px; font-weight:700;">15s</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <textarea id="nota-texto-itunes" class="form-control mb-3" rows="2" placeholder="Escribe algo sobre esta canción..." style="border-radius:10px; border:1px solid #ddd; padding:12px 15px; resize:none;"></textarea>
                            <button class="btn w-100 shadow-sm" id="btn-publicar-itunes" style="border-radius:10px; font-weight:bold; padding:13px; background:linear-gradient(135deg,#b92025,#e53935); color:white; border:none; letter-spacing:0.5px;">Publicar con Música</button>
                        </div>
                        
                        <!-- Record Tab - Professional IG Style -->
                        <div class="tab-pane fade" id="pills-record">
                            <style>
                                @keyframes pulse-ring {
                                    0%   { transform: scale(1);   opacity: 0.8; }
                                    50%  { transform: scale(1.12); opacity: 0.4; }
                                    100% { transform: scale(1);   opacity: 0.8; }
                                }
                                @keyframes wave-bounce {
                                    0%, 100% { transform: scaleY(0.3); }
                                    50%       { transform: scaleY(1); }
                                }
                                #waveform-bars .bar {
                                    width: 3px;
                                    height: 30px;
                                    background: #b92025;
                                    border-radius: 3px;
                                    transform: scaleY(0.3);
                                    transform-origin: center;
                                }
                                #waveform-bars.recording .bar {
                                    animation: wave-bounce 0.6s ease-in-out infinite;
                                }
                                #waveform-bars .bar:nth-child(2n)   { animation-delay: 0.1s; }
                                #waveform-bars .bar:nth-child(3n)   { animation-delay: 0.2s; }
                                #waveform-bars .bar:nth-child(4n)   { animation-delay: 0.3s; }
                                #waveform-bars .bar:nth-child(5n)   { animation-delay: 0.15s; }
                                #waveform-bars .bar:nth-child(7n)   { animation-delay: 0.25s; }
                            </style>

                            <!-- Waveform display -->
                            <div class="d-flex align-items-center justify-content-center mb-3" style="height:50px;">
                                <div id="waveform-bars" class="d-flex align-items-center justify-content-center" style="gap:3px; width:200px; height:50px;">
                                    <div class="bar"></div><div class="bar"></div><div class="bar"></div>
                                    <div class="bar"></div><div class="bar"></div><div class="bar"></div>
                                    <div class="bar"></div><div class="bar"></div><div class="bar"></div>
                                    <div class="bar"></div><div class="bar"></div><div class="bar"></div>
                                    <div class="bar"></div><div class="bar"></div><div class="bar"></div>
                                    <div class="bar"></div><div class="bar"></div><div class="bar"></div>
                                    <div class="bar"></div><div class="bar"></div>
                                </div>
                            </div>

                            <!-- Timer -->
                            <div class="text-center mb-2">
                                <span id="record-timer" style="font-size:28px; font-weight:700; letter-spacing:2px; color:#222;">0:00</span>
                                <p id="record-status" class="text-muted mt-1" style="font-size:12px;">Toca el micrófono para grabar (max 30s)</p>
                            </div>

                            <!-- Big mic button -->
                            <div class="d-flex justify-content-center mb-3" style="position:relative;">
                                <div id="record-pulse" style="position:absolute; width:80px; height:80px; border-radius:50%; background:rgba(185,32,37,0.15); display:none;"></div>
                                <button id="btn-record" style="width:72px; height:72px; border-radius:50%; border:none; background:linear-gradient(135deg,#b92025,#e53935); color:#fff; box-shadow:0 6px 20px rgba(185,32,37,0.45); cursor:pointer; position:relative; z-index:1; transition:transform 0.1s;">
                                    <i class="ri-mic-line" style="font-size:30px;"></i>
                                </button>
                            </div>

                            <!-- Playback preview -->
                            <div id="record-playback" class="d-none mb-3" style="background:#f8f8f8; border-radius:14px; padding:10px 14px; display:flex; align-items:center; gap:10px;">
                                <button id="btn-play-recorded" style="width:36px; height:36px; border-radius:50%; border:none; background:#222; color:#fff; flex-shrink:0; cursor:pointer;">
                                    <i class="ri-play-fill"></i>
                                </button>
                                <div style="flex:1; height:4px; background:#e0e0e0; border-radius:2px; overflow:hidden;">
                                    <div id="playback-progress" style="height:100%; background:#b92025; width:0%; transition:width 0.1s;"></div>
                                </div>
                                <span id="playback-time" style="font-size:11px; color:#888; min-width:30px;">0:00</span>
                            </div>

                            <textarea id="nota-texto-record" class="form-control mb-4" rows="2" placeholder="Escribe algo sobre tu nota de voz..." style="border-radius:10px; border:1px solid #ddd; padding:12px 15px; resize:none;"></textarea>
                            <button class="btn w-100 shadow-sm" id="btn-publicar-record" disabled style="background:#b92025; color:#fff; border-radius:8px; padding:12px; font-weight:bold;">Publicar Nota de Voz</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sleek Floating Audio Player -->
    <div id="floating-audio-player" class="d-none shadow-lg" style="position:fixed; top:80px; left:50%; transform:translateX(-50%); background:#1a1a1a; color:#fff; padding:6px 20px 6px 6px; border-radius:50px; display:flex; align-items:center; gap:12px; z-index:9999; max-width:90vw; border:1px solid #333; cursor:pointer;">
        <div style="position:relative; width:38px; height:38px;">
            <img id="floating-player-img" src="" class="rounded-circle w-100 h-100" style="object-fit:cover; border:2px solid #007bff; box-shadow:0 0 10px rgba(0,123,255,0.5);">
            <div id="floating-player-play-icon" style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); width:0; height:0; border-top:5px solid transparent; border-bottom:5px solid transparent; border-left:8px solid #fff; opacity:0; transition:opacity 0.2s;"></div>
        </div>
        <div style="flex:1; overflow:hidden; min-width:120px;">
            <h6 id="floating-player-title" class="mb-0 text-white" style="font-size:13px; font-weight:bold; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; letter-spacing:0.5px;">Title</h6>
            <p id="floating-player-artist" class="mb-0" style="font-size:11px; color:#aaa; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; text-transform:uppercase; letter-spacing:0.5px;">Artist</p>
        </div>
        <button id="floating-player-close" class="btn btn-link text-white p-0 m-0 ml-2" style="opacity:0.6;"><i class="ri-close-line" style="font-size:20px;"></i></button>
        <audio id="global-audio-player" class="d-none"></audio>
        <audio id="trimmer-preview-audio" class="d-none"></audio>
    </div>
    `;

    // Tab active styling logic
    $(document).on('shown.bs.tab', 'a[data-toggle="pill"]', function (e) {
        $('.nav-pills .nav-link').removeClass('text-danger').addClass('text-muted');
        $(e.target).removeClass('text-muted').addClass('text-danger');
        
        if($(e.target).attr('href') === '#pills-itunes') {
            // Load Top 10 if empty and no song is selected
            if($('#itunes-results').html().trim() === '' && $('#itunes-trimmer-container').hasClass('d-none')) {
                $('#itunes-results').html('<div class="text-center p-3 text-muted"><i class="ri-loader-4-line ri-spin"></i> Cargando Top 10 de Hoy...</div>');
                $.get('../controlador/cNotasMusica.php?accion=top_itunes', function(data) {
                    let res = typeof data === 'string' ? JSON.parse(data) : data;
                    let html = '';
                    let tracks = res && res.feed && res.feed.entry ? res.feed.entry : [];
                    if(tracks.length > 0) {
                        tracks.forEach(track => {
                            let title = track['im:name'].label;
                            let artist = track['im:artist'].label;
                            let img = track['im:image'] && track['im:image'][2] ? track['im:image'][2].label : '';
                            // Find the preview link (type audio-x-m4a or similar)
                            let preview = '';
                            if(track.link) {
                                let links = Array.isArray(track.link) ? track.link : [track.link];
                                let previewLink = links.find(l => l.attributes && l.attributes.type && l.attributes.type.includes('audio'));
                                if(previewLink) preview = previewLink.attributes.href;
                                // Fallback: link[1] if exists
                                if(!preview && links[1] && links[1].attributes) preview = links[1].attributes.href;
                            }
                            
                            html += `
                                    <div class="list-group-item list-group-item-action select-itunes" 
                                       data-url="${preview}" data-title="${title}" data-artist="${artist}" data-img="${img}"
                                       style="border:none; border-radius:12px; margin-bottom:8px; cursor:pointer; transition:all 0.2s; background:#fff; box-shadow:0 2px 5px rgba(0,0,0,0.02);">
                                        <div class="d-flex align-items-center">
                                            <div style="position:relative; width:45px; height:45px; flex-shrink:0;" class="mr-3">
                                                <img src="${img}" class="w-100 h-100 shadow-sm" style="border-radius:8px; object-fit:cover;">
                                                <div style="position:absolute; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.2); border-radius:8px; display:flex; align-items:center; justify-content:center;">
                                                    <i class="ri-play-fill text-white" style="font-size:20px;"></i>
                                                </div>
                                            </div>
                                            <div style="flex-grow:1; min-width:0;">
                                                <h6 class="mb-0 text-truncate" style="font-size:14px; font-weight:700; color:#222; letter-spacing:0.3px;">${title}</h6>
                                                <small class="text-truncate d-block" style="font-size:12px; color:#777; font-weight:500;">${artist}</small>
                                            </div>
                                            <div style="width:24px; height:24px; border-radius:50%; border:1px solid #ddd; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                                <i class="ri-add-line" style="color:#aaa; font-size:14px;"></i>
                                            </div>
                                        </div>
                                    </div>
                                    `;
                        });
                        $('#itunes-results').html(html);
                    } else {
                        $('#itunes-results').html('<div class="text-center p-3 text-muted">No se pudo cargar el Top 10</div>');
                    }
                }).fail(function() {
                    $('#itunes-results').html('<div class="text-center p-3 text-danger">Error al cargar Top 10</div>');
                });
            }
        }
    });

    let notesTarget = $('#notas-musica-container');
    if (notesTarget.length > 0) {
        notesTarget.html(barHtml);
    } else if ($('#post-modal-data').length > 0) {
        $('#post-modal-data').before(barHtml);
    }

    let globalAudio = document.getElementById('global-audio-player');
    let currentEndTime = 30;

    globalAudio.addEventListener('timeupdate', function() {
        if (globalAudio.currentTime >= currentEndTime) {
            globalAudio.pause();
            globalAudio.currentTime = 0; // stop
            $('#floating-audio-player').addClass('d-none');
        }
    });

    $('#floating-player-close').click(function() {
        globalAudio.pause();
        $('#floating-audio-player').addClass('d-none');
    });

    function loadNotas() {
        $.get('../controlador/cNotasMusica.php?accion=listar', function(notas) {
            let html = '';
            notas.forEach(n => {
                let hasAudio = n.audio_file && n.audio_file.trim() !== '';
                let audioUrl = hasAudio ? (n.audio_file.startsWith('http') ? n.audio_file : '../vista/audio/' + n.audio_file) : '';
                
                let cancionText = hasAudio ? n.cancion : 'Nota';
                let artistText = n.artista || '';
                let notaText = n.nota ? n.nota : cancionText;
                let imgUrl = `../vista/images/fotosperfiles/${n.fotoperfil}`;

                // The bubble HTML
                let bubbleHtml = `
                    <div class="note-bubble shadow-sm" style="position:absolute; bottom:70px; left:50%; transform:translateX(-50%); background:#fff; border:1px solid #eee; border-radius:15px; padding:8px 12px; min-width:110px; max-width:140px; text-align:center; z-index:10; cursor:pointer;" data-audio="${audioUrl}" data-title="${cancionText}" data-artist="${artistText}" data-img="${imgUrl}" data-start="${n.start_time || 0}" data-end="${n.end_time || 30}">
                        ${hasAudio ? `<div style="font-size:11px; font-weight:bold; color:#b92025; margin-bottom:2px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"><i class="ri-music-fill"></i> ${cancionText}</div>` : ''}
                        <div style="font-size:12px; color:#333; font-weight:500;">${notaText}</div>
                        <div style="position:absolute; bottom:-6px; left:50%; transform:translateX(-50%); border-left:6px solid transparent; border-right:6px solid transparent; border-top:6px solid #fff;"></div>
                    </div>
                `;

                let isMe = n.fotoperfil === myAvatar.split('/').pop();
                let ringColor = isMe ? '#ccc' : '#ff3b30';

                html += `
                <div class="nota-item" style="text-align:center; position:relative;">
                    ${bubbleHtml}
                    <div style="width:60px; height:60px; border-radius:50%; border:2px solid ${ringColor}; padding:2px; margin:0 auto; background:#fff;">
                        <img src="${imgUrl}" class="rounded-circle w-100 h-100" style="object-fit:cover;">
                    </div>
                    <p class="mb-0 mt-2" style="font-size:12px; color:#555; font-weight:500;">${n.nombres.split(' ')[0]}</p>
                </div>
                `;
            });
            $('#notas-container .nota-item').remove();
            $('#notas-container').append(html);

            // Floating Player logic
            $('.note-bubble').click(function(e) {
                let audio = $(this).data('audio');
                if(!audio) return; // No audio just text
                
                let title = $(this).data('title');
                let artist = $(this).data('artist');
                let img = $(this).data('img');
                let st = $(this).data('start');
                let et = $(this).data('end');

                $('#floating-player-title').text(title);
                $('#floating-player-artist').text(artist);
                $('#floating-player-img').attr('src', img);
                $('#floating-audio-player').removeClass('d-none').hide().fadeIn();

                if(globalAudio.src.includes(audio) && !globalAudio.paused) {
                    globalAudio.pause();
                    $('#floating-player-img').css('animation', 'none');
                    $('#floating-player-play-icon').css('opacity', '1');
                    $('#floating-player-img').css('opacity', '0.5');
                    return;
                }

                globalAudio.src = audio;
                globalAudio.currentTime = st;
                currentEndTime = et;
                globalAudio.play();
                
                $('#floating-player-img').css('animation', 'spin 3s linear infinite');
                $('#floating-player-play-icon').css('opacity', '0');
                $('#floating-player-img').css('opacity', '1');
                
                $(globalAudio).off('timeupdate ended');
                $(globalAudio).on('timeupdate', function() {
                    if(this.currentTime >= currentEndTime) {
                        this.pause();
                        $('#floating-audio-player').fadeOut();
                        $('#floating-player-img').css('animation', 'none');
                    }
                });
                $(globalAudio).on('ended', function() {
                    $('#floating-audio-player').fadeOut();
                    $('#floating-player-img').css('animation', 'none');
                });
            });
            
            // Add keyframes if not exists
            if($('#spin-style').length === 0) {
                $('head').append('<style id="spin-style">@keyframes spin { 100% { transform: rotate(360deg); } }</style>');
            }
            
            $('#floating-audio-player').click(function(e) {
                if($(e.target).closest('#floating-player-close').length > 0) return;
                if(globalAudio.paused) {
                    globalAudio.play();
                    $('#floating-player-img').css('animation', 'spin 3s linear infinite');
                    $('#floating-player-play-icon').css('opacity', '0');
                    $('#floating-player-img').css('opacity', '1');
                } else {
                    globalAudio.pause();
                    $('#floating-player-img').css('animation', 'none');
                    $('#floating-player-play-icon').css('opacity', '1');
                    $('#floating-player-img').css('opacity', '0.5');
                }
            });
        });
    }

    loadNotas();

    // ---------------- ITUNES TRIMMER ----------------
    let selectedItunesUrl = '';
    let selectedItunesTitle = '';
    let selectedItunesArtist = '';
    
    let trimmerAudio = document.getElementById('trimmer-preview-audio');

    let searchTimer = null;
    $('#itunes-search').on('keyup', function() {
        let q = $(this).val().trim();
        clearTimeout(searchTimer);
        if(q.length > 2) {
            $('#itunes-results').html('<div class="text-center p-2 text-muted"><i class="ri-loader-4-line ri-spin"></i> Buscando...</div>');
            searchTimer = setTimeout(function() {
                // Use PHP proxy to avoid CORS issues
                $.get('../controlador/cNotasMusica.php?accion=buscar_itunes&q=' + encodeURIComponent(q), function(data) {
                    let res = typeof data === 'string' ? JSON.parse(data) : data;
                    if(!res.results || res.results.length === 0) {
                        $('#itunes-results').html('<div class="text-center p-2 text-muted">No se encontraron resultados</div>');
                        return;
                    }
                    let html = '';
                    res.results.forEach(track => {
                        let imgSrc = track.artworkUrl100 || track.artworkUrl60 || track.artworkUrl30 || '';
                        let previewUrl = track.previewUrl || '';
                        html += `
                            <div class="list-group-item list-group-item-action select-itunes" 
                               data-url="${previewUrl}" data-title="${track.trackName}" data-artist="${track.artistName}" data-img="${imgSrc}"
                               style="border:none; border-radius:12px; margin-bottom:8px; cursor:pointer; transition:all 0.2s; background:#fff; box-shadow:0 2px 5px rgba(0,0,0,0.02);">
                                <div class="d-flex align-items-center">
                                    <div style="position:relative; width:45px; height:45px; flex-shrink:0;" class="mr-3">
                                        <img src="${imgSrc}" class="w-100 h-100 shadow-sm" style="border-radius:8px; object-fit:cover;">
                                        <div style="position:absolute; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.2); border-radius:8px; display:flex; align-items:center; justify-content:center;">
                                            <i class="ri-play-fill text-white" style="font-size:20px;"></i>
                                        </div>
                                    </div>
                                    <div style="flex-grow:1; min-width:0;">
                                        <h6 class="mb-0 text-truncate" style="font-size:14px; font-weight:700; color:#222; letter-spacing:0.3px;">${track.trackName}</h6>
                                        <small class="text-truncate d-block" style="font-size:12px; color:#777; font-weight:500;">${track.artistName}</small>
                                    </div>
                                    <div style="width:24px; height:24px; border-radius:50%; border:1px solid #ddd; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                        <i class="ri-add-line" style="color:#aaa; font-size:14px;"></i>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    $('#itunes-results').html(html);
                }).fail(function() {
                    $('#itunes-results').html('<div class="text-center p-2 text-danger">Error al buscar. Intenta de nuevo.</div>');
                });
            }, 500);
        } else if(q.length === 0) {
            $('#itunes-results').html('');
        }
    });

    $(document).on('click', '.select-itunes', function(e) {
        e.preventDefault();
        selectedItunesUrl = $(this).data('url');
        selectedItunesTitle = $(this).data('title');
        selectedItunesArtist = $(this).data('artist');
        let selectedItunesImg = $(this).data('img');

        if(!selectedItunesUrl) {
            alert('Esta canción no tiene vista previa disponible.');
            return;
        }
        
        $('#itunes-results').html('');
        $('#itunes-search').val('');
        
        // Update the premium player card with the selected song info
        $('#player-song-name').text(selectedItunesTitle);
        $('#player-artist-name').text(selectedItunesArtist);
        $('#player-album-art').attr('src', selectedItunesImg);
        
        $('#itunes-trimmer-container').removeClass('d-none').hide().fadeIn();
        
        trimmerAudio.src = selectedItunesUrl;
        // iTunes preview = 30s; slider allows picking 15s start window (0–15)
        $('#audio-trimmer').attr('max', 15).val(0);
        $('#clip-range-label').html('0:00 &rarr; 0:15');
        $('#trimmer-time-display').text('0:00');
        // Scrubber: el fill % = startTime / 30 * 100 (dentro del track de 30s)
        $('#scrubber-filled').css('width', '0%');
        $('#scrubber-thumb').css('left', '0%');
        // Highlight muestra el clip de 15s dentro del track de 30s
        $('#clip-highlight').css({ left: '0%', width: '50%' });
        
        // Pause any ongoing preview
        if(trimmerPlaying) {
            trimmerAudio.pause();
            trimmerPlaying = false;
            $('#player-play-btn').find('i').removeClass('ri-pause-fill').addClass('ri-play-fill').css('margin-left', '2px');
            $('#eq-bars').removeClass('playing');
        }
    });

    function resetTrimmerProgress(st) {
        let fillPct = (st / 30) * 100;
        $('#scrubber-filled').css('width', fillPct + '%');
        $('#scrubber-thumb').css('left', fillPct + '%');
        let stFmt = Math.floor(st/60) + ':' + (st%60 < 10 ? '0'+(st%60) : st%60);
        $('#trimmer-time-display').text(stFmt);
    }

    $('#audio-trimmer').on('input', function() {
        let st = parseInt($(this).val());
        let et = st + 15;
        
        let stFmt = Math.floor(st/60) + ':' + (st%60 < 10 ? '0'+(st%60) : st%60);
        let etFmt = Math.floor(et/60) + ':' + (et%60 < 10 ? '0'+(et%60) : et%60);
        $('#trimmer-time-display').text(stFmt);
        $('#clip-range-label').html(stFmt + ' &rarr; ' + etFmt);
        
        let fillPct = (st / 30) * 100;
        $('#scrubber-filled').css('width', fillPct + '%');
        $('#scrubber-thumb').css('left', fillPct + '%');
        $('#clip-highlight').css({ left: fillPct + '%', width: '50%' });
        
        if(trimmerPlaying) {
            trimmerAudio.currentTime = st;
        }
    });

    trimmerAudio.addEventListener('timeupdate', function() {
        if (trimmerPlaying) {
            let curTime = trimmerAudio.currentTime;
            let currentPct = (curTime / 30) * 100;
            $('#scrubber-filled').css('width', currentPct + '%');
            $('#scrubber-thumb').css('left', currentPct + '%');
            
            let curFmt = Math.floor(curTime/60) + ':' + (Math.floor(curTime)%60 < 10 ? '0'+(Math.floor(curTime)%60) : Math.floor(curTime)%60);
            $('#trimmer-time-display').text(curFmt);
        }
    });

    let trimmerPlaying = false;
    $(document).on('click', '#player-play-btn', function() {
        let $icon = $(this).find('i');
        let st = parseInt($('#audio-trimmer').val());
        
        if(trimmerPlaying) {
            trimmerAudio.pause();
            $icon.removeClass('ri-pause-fill').addClass('ri-play-fill').css('margin-left', '2px');
            $('#eq-bars').removeClass('playing');
            trimmerPlaying = false;
            resetTrimmerProgress(st);
        } else {
            trimmerAudio.currentTime = st;
            trimmerAudio.play().then(function() {
                $icon.removeClass('ri-play-fill').addClass('ri-pause-fill').css('margin-left', '0');
                $('#eq-bars').addClass('playing');
                trimmerPlaying = true;
                
                // Auto-pause after 15s clip
                let checkTime = setInterval(function() {
                    if(!trimmerPlaying) { clearInterval(checkTime); return; }
                    if(trimmerAudio.currentTime >= st + 15 || trimmerAudio.ended) {
                        trimmerAudio.pause();
                        $icon.removeClass('ri-pause-fill').addClass('ri-play-fill').css('margin-left', '2px');
                        $('#eq-bars').removeClass('playing');
                        trimmerPlaying = false;
                        clearInterval(checkTime);
                        resetTrimmerProgress(st);
                    }
                }, 200);
            }).catch(function() {
                alert('No se pudo reproducir la vista previa. La URL puede haber expirado.');
            });
        }
    });

    // Reset player when changing song
    $(document).on('click', '#change-song-btn', function() {
        if(trimmerPlaying) {
            trimmerAudio.pause();
            trimmerPlaying = false;
            $('#eq-bars').removeClass('playing');
            $('#player-play-btn').find('i').removeClass('ri-pause-fill').addClass('ri-play-fill').css('margin-left', '2px');
        }
        $('#itunes-trimmer-container').addClass('d-none');
        $('#player-song-name').text('---');
        $('#player-artist-name').text('---');
        $('#player-album-art').attr('src', '');
        selectedItunesUrl = '';
        selectedItunesTitle = '';
        selectedItunesArtist = '';
    });

    $('#btn-publicar-itunes').click(function() {
        if(!selectedItunesUrl) return alert('Busca y selecciona una canción primero.');
        let text = $('#nota-texto-itunes').val();
        let st = parseInt($('#audio-trimmer').val());
        let et = st + 15;

        let btn = $(this);
        btn.prop('disabled', true).text('Publicando...');

        $.post('../controlador/cNotasMusica.php?accion=publicar', {
            cancion: selectedItunesTitle,
            artista: selectedItunesArtist,
            audio_url: selectedItunesUrl,
            nota: text,
            start_time: st,
            end_time: et
        }, function(res) {
            if(res.error) {
                alert(res.error);
                btn.prop('disabled', false).text('Publicar con Música');
                return;
            }
            $('#nota-modal').modal('hide');
            $('#itunes-trimmer-container').addClass('d-none');
            $('#nota-texto-itunes').val('');
            selectedItunesUrl = '';
            selectedItunesTitle = '';
            selectedItunesArtist = '';
            btn.prop('disabled', false).text('Publicar con Música');
            loadNotas();
        }).fail(function() {
            alert('Error al publicar.');
            btn.prop('disabled', false).text('Publicar Nota con Canción');
        });
    });

    // ---------------- TEXTO ONLY ----------------
    $('#btn-publicar-texto').click(function() {
        let text = $('#nota-texto-only').val();
        if(!text) return alert('Escribe algo primero');
        
        let btn = $(this);
        btn.prop('disabled', true).text('Publicando...');

        $.post('../controlador/cNotasMusica.php?accion=publicar', {
            cancion: 'Pensamiento',
            artista: '',
            nota: text
        }, function(res) {
            if(res.error) {
                alert(res.error);
                btn.prop('disabled', false).text('Publicar Nota');
                return;
            }
            $('#nota-modal').modal('hide');
            $('#nota-texto-only').val('');
            btn.prop('disabled', false).text('Publicar Nota');
            loadNotas();
        }).fail(function() {
            alert('Error al publicar.');
            btn.prop('disabled', false).text('Publicar Nota');
        });
    });

    // ---------------- RECORD AUDIO ----------------
    let mediaRecorder;
    let audioChunks = [];
    let isRecording = false;
    let recTimeout;
    let recTimerInterval;
    let recordedBlob = null;
    let playbackAudio = null;

    $('#btn-record').click(function() {
        if(!isRecording) {
            navigator.mediaDevices.getUserMedia({ audio: true }).then(stream => {
                mediaRecorder = new MediaRecorder(stream);
                mediaRecorder.start();
                isRecording = true;
                audioChunks = [];

                // UI: mic becomes stop icon with pulse
                $(this).html('<i class="ri-stop-fill" style="font-size:30px;"></i>');
                $('#record-status').text('Grabando... toca para detener');
                $('#waveform-bars').addClass('recording');
                $('#record-pulse').show().css('animation', 'pulse-ring 1s ease-in-out infinite');
                $('#record-playback').addClass('d-none');
                $('#btn-publicar-record').prop('disabled', true);
                recordedBlob = null;

                // Timer
                let secs = 0;
                $('#record-timer').text('0:00');
                recTimerInterval = setInterval(() => {
                    secs++;
                    let m = Math.floor(secs / 60);
                    let s = secs % 60;
                    $('#record-timer').text(m + ':' + (s < 10 ? '0' + s : s));
                    if(secs >= 30) stopRecording();
                }, 1000);

                mediaRecorder.addEventListener('dataavailable', event => { audioChunks.push(event.data); });
                mediaRecorder.addEventListener('stop', () => {
                    recordedBlob = new Blob(audioChunks, { type: 'audio/webm' });
                    let blobUrl = URL.createObjectURL(recordedBlob);
                    
                    // Setup playback
                    if(playbackAudio) playbackAudio.pause();
                    playbackAudio = new Audio(blobUrl);
                    playbackAudio.addEventListener('timeupdate', function() {
                        if(this.duration) {
                            let pct = (this.currentTime / this.duration) * 100;
                            $('#playback-progress').css('width', pct + '%');
                            let s = Math.floor(this.currentTime);
                            let m = Math.floor(s / 60); s = s % 60;
                            $('#playback-time').text(m + ':' + (s < 10 ? '0' + s : s));
                        }
                    });
                    playbackAudio.addEventListener('ended', function() {
                        $('#btn-play-recorded').html('<i class="ri-play-fill"></i>');
                        $('#playback-progress').css('width', '0%');
                        $('#playback-time').text('0:00');
                    });

                    $('#record-playback').removeClass('d-none');
                    $('#btn-publicar-record').prop('disabled', false);
                });

                recTimeout = setTimeout(() => { if(isRecording) stopRecording(); }, 30000);
            }).catch(() => {
                alert('Debes permitir el uso del micrófono.');
            });
        } else {
            stopRecording();
        }
    });

    $('#btn-play-recorded').click(function() {
        if(!playbackAudio) return;
        if(playbackAudio.paused) {
            playbackAudio.play();
            $(this).html('<i class="ri-pause-fill"></i>');
        } else {
            playbackAudio.pause();
            $(this).html('<i class="ri-play-fill"></i>');
        }
    });

    function stopRecording() {
        if(!mediaRecorder) return;
        mediaRecorder.stop();
        mediaRecorder.stream.getTracks().forEach(t => t.stop());
        isRecording = false;
        clearTimeout(recTimeout);
        clearInterval(recTimerInterval);
        $('#btn-record').html('<i class="ri-mic-line" style="font-size:30px;"></i>');
        $('#record-status').text('Grabación lista. Toca para volver a grabar.');
        $('#waveform-bars').removeClass('recording');
        $('#record-pulse').hide().css('animation', 'none');
    }

    $('#btn-publicar-record').click(function() {
        let text = $('#nota-texto-record').val();
        let audioBlob = recordedBlob;
        let fd = new FormData();
        fd.append('audio_file', audioBlob, 'nota.webm');
        fd.append('cancion', 'Nota de Voz');
        fd.append('nota', text);
        fd.append('start_time', 0);
        fd.append('end_time', 30);

        let btn = $(this);
        btn.prop('disabled', true).text('Publicando...');

        $.ajax({
            url: '../controlador/cNotasMusica.php?accion=publicar',
            type: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            success: function(res) {
                if(res.error) {
                    alert(res.error);
                    btn.prop('disabled', false).text('Publicar Audio');
                    return;
                }
                $('#nota-modal').modal('hide');
                $('#nota-texto-record').val('');
                $('#audio-preview').addClass('d-none').attr('src', '');
                btn.prop('disabled', false).text('Publicar Audio');
                loadNotas();
            },
            error: function() {
                alert('Error al publicar.');
                btn.prop('disabled', false).text('Publicar Audio');
            }
        });
    });
});
