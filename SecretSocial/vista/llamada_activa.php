<?php
require('../modelo/conexion.php');
session_start();

if(!isset($_SESSION['nombre_usuario'])){
    header('location:../AccesoDenegado=restringido');
    exit;
}

$idLlamada = isset($_GET['id']) ? intval($_GET['id']) : 0;
$uid = $_SESSION['id_usuario'];

$sql = "SELECT cl.*, 
        u1.nombres as remitente_nombres, u1.apellidos as remitente_apellidos, u1.fotoperfil as remitente_foto,
        u2.nombres as receptor_nombres, u2.apellidos as receptor_apellidos, u2.fotoperfil as receptor_foto
        FROM chat_llamadas cl 
        JOIN usuarios u1 ON cl.id_remitente = u1.id
        JOIN usuarios u2 ON cl.id_receptor = u2.id
        WHERE cl.id = '$idLlamada' AND (cl.id_remitente = '$uid' OR cl.id_receptor = '$uid')";
$res = mysqli_query($conectarsistema, $sql);

if(!$res || mysqli_num_rows($res) == 0) {
    die("Llamada no encontrada o no tienes permiso.");
}

$llamada = mysqli_fetch_assoc($res);
$isCaller = ($llamada['id_remitente'] == $uid);
$otroNombre = $isCaller ? ($llamada['receptor_nombres'] . ' ' . $llamada['receptor_apellidos']) : ($llamada['remitente_nombres'] . ' ' . $llamada['remitente_apellidos']);
$otroFoto = $isCaller ? $llamada['receptor_foto'] : $llamada['remitente_foto'];

?>
<!doctype html>
<html lang="ES-SV">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Llamada con <?php echo $otroNombre; ?> - Secret</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Remix Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.2.0/fonts/remixicon.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../vista/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #111;
            color: #fff;
            font-family: 'Inter', sans-serif;
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .call-header {
            padding: 20px;
            text-align: center;
            z-index: 10;
        }
        .call-videos {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }
        video {
            background: #000;
            border-radius: 12px;
            object-fit: cover;
        }
        #remoteVideo {
            width: 100%;
            height: 100%;
            max-width: 1000px;
            max-height: 80vh;
        }
        #localVideo {
            position: absolute;
            bottom: 20px;
            right: 20px;
            width: 150px;
            height: 200px;
            border: 2px solid #fff;
            border-radius: 12px;
            z-index: 20;
            transform: scaleX(-1); /* Mirror */
        }
        .call-controls {
            padding: 20px;
            display: flex;
            justify-content: center;
            gap: 20px;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            z-index: 10;
        }
        .control-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            cursor: pointer;
            transition: transform 0.2s;
            color: #fff;
        }
        .control-btn:hover { transform: scale(1.1); }
        .btn-end { background: #e53935; }
        .btn-mute { background: rgba(255,255,255,0.2); }
        .btn-video { background: rgba(255,255,255,0.2); }
        
        .caller-info {
            text-align: center;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 5;
        }
        .caller-info img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #333;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

    <div class="call-header">
        <h3 style="margin:0; font-weight: 600;"><?php echo $otroNombre; ?></h3>
        <p id="call-status" style="margin:5px 0 0; opacity: 0.7;">Conectando...</p>
    </div>

    <div class="call-videos">
        <div class="caller-info" id="caller-info">
            <img src="../vista/images/fotosperfiles/<?php echo $otroFoto; ?>">
            <h4 style="margin:0;"><?php echo $otroNombre; ?></h4>
            <p style="opacity: 0.6; font-size:14px; margin-top:5px;" id="info-status">Esperando conexión...</p>
        </div>
        
        <video id="remoteVideo" autoplay playsinline></video>
        <video id="localVideo" autoplay playsinline muted></video>
    </div>

    <div class="call-controls">
        <button class="control-btn btn-mute" id="btn-mute" title="Silenciar Micrófono"><i class="ri-mic-fill"></i></button>
        <button class="control-btn btn-video" id="btn-video" title="Desactivar Cámara"><i class="ri-camera-fill"></i></button>
        <button class="control-btn btn-end" id="btn-end" title="Colgar Llamada"><i class="ri-phone-fill" style="transform: rotate(135deg);"></i></button>
    </div>

<script>
    const idLlamada = <?php echo $idLlamada; ?>;
    const isCaller = <?php echo $isCaller ? 'true' : 'false'; ?>;
    const isVideoCall = <?php echo ($llamada['tipo'] == 'video') ? 'true' : 'false'; ?>;

    let localStream;
    let remoteStream;
    let peerConnection;
    
    // Configuración STUN libre de Google
    const rtcConfig = {
        iceServers: [{ urls: 'stun:stun.l.google.com:19302' }]
    };

    const localVideo = document.getElementById('localVideo');
    const remoteVideo = document.getElementById('remoteVideo');
    const statusText = document.getElementById('call-status');
    const infoStatus = document.getElementById('info-status');
    const callerInfo = document.getElementById('caller-info');

    async function startCall() {
        try {
            // Pedir permisos de media
            localStream = await navigator.mediaDevices.getUserMedia({
                video: isVideoCall,
                audio: true
            });
            localVideo.srcObject = localStream;
            
            if(!isVideoCall) {
                localVideo.style.display = 'none';
            }

            peerConnection = new RTCPeerConnection(rtcConfig);

            // Agregar tracks al peer connection
            localStream.getTracks().forEach(track => {
                peerConnection.addTrack(track, localStream);
            });

            // Recibir tracks remotos
            peerConnection.ontrack = (event) => {
                callerInfo.style.display = 'none'; // Ocultar foto al recibir video
                if (!remoteStream) {
                    remoteStream = new MediaStream();
                    remoteVideo.srcObject = remoteStream;
                }
                remoteStream.addTrack(event.track);
                statusText.innerText = 'Llamada conectada';
            };

            // Recolectar ICE candidates
            peerConnection.onicecandidate = (event) => {
                if (event.candidate) {
                    let field = isCaller ? 'ice_candidates_remitente' : 'ice_candidates_receptor';
                    // We just append to DB or send via signaling
                    // Since it's polling DB, we'll store the last candidate array
                    saveIceCandidate(field, event.candidate);
                }
            };

            if (isCaller) {
                // El remitente crea la oferta
                const offer = await peerConnection.createOffer();
                await peerConnection.setLocalDescription(offer);
                await updateSignaling('sdp_offer', JSON.stringify(offer));
                statusText.innerText = 'Llamando...';
                infoStatus.innerText = 'Llamando...';
            } else {
                statusText.innerText = 'Conectando...';
            }

            // Iniciar Polling de señalizacion
            startSignalingPolling();

        } catch(err) {
            console.error("Error media devices", err);
            statusText.innerText = 'Error: ' + err.message;
            infoStatus.innerText = 'Permiso de cámara/micrófono denegado.';
        }
    }

    let iceCandidates = [];
    function saveIceCandidate(field, candidate) {
        iceCandidates.push(candidate);
        updateSignaling(field, JSON.stringify(iceCandidates));
    }

    let pollingInterval;
    function startSignalingPolling() {
        pollingInterval = setInterval(() => {
            $.get('../controlador/cChatPrivado.php?accion=poll-call-status&id_llamada=' + idLlamada, async function(res) {
                try {
                    let data = JSON.parse(res);
                    
                    if (data.estado === 'ended' || data.estado === 'rejected') {
                        clearInterval(pollingInterval);
                        alert("Llamada terminada.");
                        window.close(); // Intenta cerrar la pestaña
                        window.location.href = '../Feed/inicio';
                        return;
                    }

                    // Manejar Oferta/Respuesta
                    if (!isCaller && data.sdp_offer && peerConnection.signalingState === 'stable') {
                        let offer = JSON.parse(data.sdp_offer);
                        await peerConnection.setRemoteDescription(new RTCSessionDescription(offer));
                        const answer = await peerConnection.createAnswer();
                        await peerConnection.setLocalDescription(answer);
                        await updateSignaling('sdp_answer', JSON.stringify(answer));
                    }

                    if (isCaller && data.sdp_answer && peerConnection.signalingState === 'have-local-offer') {
                        let answer = JSON.parse(data.sdp_answer);
                        await peerConnection.setRemoteDescription(new RTCSessionDescription(answer));
                    }

                    // Manejar ICE Candidates
                    let remoteIceField = isCaller ? data.ice_candidates_receptor : data.ice_candidates_remitente;
                    if (remoteIceField && peerConnection.remoteDescription) {
                        let candidates = JSON.parse(remoteIceField);
                        candidates.forEach(async (c) => {
                            try {
                                await peerConnection.addIceCandidate(new RTCIceCandidate(c));
                            } catch (e) {
                                // Ignore duplicate candidates
                            }
                        });
                    }

                } catch(e) {}
            });
        }, 2000);
    }

    function updateSignaling(field, data) {
        return $.post('../controlador/cChatPrivado.php?accion=webrtc-signaling', {
            id_llamada: idLlamada,
            field: field,
            data: data
        });
    }

    // Controles
    $('#btn-end').click(function() {
        $.post('../controlador/cChatPrivado.php?accion=update-call-status', { id_llamada: idLlamada, estado: 'ended' }, function() {
            window.close();
            window.location.href = '../Feed/inicio';
        });
    });

    let isAudioMuted = false;
    $('#btn-mute').click(function() {
        isAudioMuted = !isAudioMuted;
        localStream.getAudioTracks()[0].enabled = !isAudioMuted;
        if(isAudioMuted) {
            $(this).css('background', '#e53935');
            $(this).find('i').removeClass('ri-mic-fill').addClass('ri-mic-off-fill');
        } else {
            $(this).css('background', 'rgba(255,255,255,0.2)');
            $(this).find('i').removeClass('ri-mic-off-fill').addClass('ri-mic-fill');
        }
    });

    let isVideoMuted = false;
    $('#btn-video').click(function() {
        if(!isVideoCall) return; // Si es llamada de voz, no hace nada
        isVideoMuted = !isVideoMuted;
        localStream.getVideoTracks()[0].enabled = !isVideoMuted;
        if(isVideoMuted) {
            $(this).css('background', '#e53935');
            $(this).find('i').removeClass('ri-camera-fill').addClass('ri-camera-off-fill');
        } else {
            $(this).css('background', 'rgba(255,255,255,0.2)');
            $(this).find('i').removeClass('ri-camera-off-fill').addClass('ri-camera-fill');
        }
    });

    // Iniciar llamada al cargar la pagina
    $(document).ready(function() {
        startCall();
    });

</script>
</body>
</html>
