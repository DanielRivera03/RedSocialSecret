/**
 * SECRET SOCIAL NETWORK - WEBRTC CALLS SYSTEM
 * Voice and Video Calls over P2P using WebRTC with polling-based signaling.
 */
$(document).ready(function() {
    let localStream = null;
    let peerConnection = null;
    let currentCallId = null;
    let callPollingInterval = null;
    let checkIncomingInterval = null;
    let isCaller = false;
    let candidateCount = { remitente: 0, receptor: 0 };
    
    // Free Google STUN Servers
    const rtcConfig = {
        iceServers: [
            { urls: 'stun:stun.l.google.com:19302' },
            { urls: 'stun:stun1.l.google.com:19302' },
            { urls: 'stun:stun2.l.google.com:19302' }
        ]
    };

    // Ensure remote audio element exists for voice calls
    if ($('#webrtc-remote-audio').length === 0) {
        $('body').append('<audio id="webrtc-remote-audio" autoplay style="display:none;"></audio>');
    }

    // ===================================
    // 1. CHECK FOR INCOMING CALLS
    // ===================================
    function checkIncomingCalls() {
        // If we are currently in an active or outgoing call, skip checking
        if (currentCallId !== null) return;

        $.ajax({
            url: '../controlador/cCalls.php?accion=chequear',
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                if (res && res.llamada) {
                    let call = res.llamada;
                    currentCallId = call.id;
                    isCaller = false;

                    // Show Incoming Call Modal
                    $('#call-avatar').attr('src', '../vista/images/fotosperfiles/' + call.fotoperfil);
                    $('#call-name').text(call.nombres + ' ' + call.apellidos);
                    $('#call-status').html(`Llamada de <strong>${call.tipo === 'video' ? 'Video' : 'Voz'}</strong> entrante...`);
                    
                    // Show accept/decline buttons instead of hangup
                    $('#btn-hangup-call').hide();
                    $('#call-overlay .call-btn-row').html(`
                        <button class="call-btn accept mr-3" id="btn-accept-call" title="Aceptar">
                            <i class="ri-phone-fill"></i>
                        </button>
                        <button class="call-btn decline" id="btn-decline-call" title="Rechazar">
                            <i class="ri-phone-fill" style="transform: rotate(135deg);"></i>
                        </button>
                    `);
                    $('#call-overlay').addClass('show');

                    // Bind dynamic actions
                    $('#btn-accept-call').off('click').on('click', function() {
                        aceptarLlamada(call);
                    });
                    $('#btn-decline-call').off('click').on('click', function() {
                        rechazarLlamada(call.id);
                    });
                }
            }
        });
    }

    // Check incoming calls every 3.5 seconds
    checkIncomingInterval = setInterval(checkIncomingCalls, 3500);

    // ===================================
    // 2. INITIATE A CALL (OUTGOING)
    // ===================================
    function iniciarLlamada(tipo) {
        let chatAmigoId = window.chatAmigoId || $('#panel-privado').data('amigo-id');
        if (!chatAmigoId) {
            alert('Por favor selecciona un chat para realizar la llamada.');
            return;
        }

        isCaller = true;
        candidateCount.remitente = 0;
        candidateCount.receptor = 0;

        // Show Dialing Screen
        $('#call-avatar').attr('src', $('#priv-header-avatar').attr('src'));
        $('#call-name').text($('#priv-header-name').text());
        $('#call-status').text('Llamando...');
        
        // Show only hangup button
        $('#call-overlay .call-btn-row').html(`
            <button class="call-btn decline" id="btn-hangup-call" title="Colgar">
                <i class="ri-phone-fill" style="transform: rotate(135deg);"></i>
            </button>
        `);
        $('#btn-hangup-call').off('click').on('click', colgarLlamada);
        $('#call-overlay').addClass('show');

        // Request local media
        navigator.mediaDevices.getUserMedia({ 
            audio: true, 
            video: (tipo === 'video') 
        }).then(function(stream) {
            localStream = stream;
            
            // If video call, show preview & overlay
            if (tipo === 'video') {
                $('#videocall-overlay').addClass('show');
                document.getElementById('local-video').srcObject = stream;
            }

            // Create Peer Connection
            setupPeerConnection(tipo);

            // Add local stream tracks to RTCPeerConnection
            stream.getTracks().forEach(track => {
                peerConnection.addTrack(track, stream);
            });

            // Create WebRTC Offer
            peerConnection.createOffer().then(offer => {
                return peerConnection.setLocalDescription(offer);
            }).then(() => {
                // Send Offer to server
                $.ajax({
                    url: '../controlador/cCalls.php?accion=iniciar',
                    type: 'POST',
                    data: {
                        id_receptor: chatAmigoId,
                        tipo: tipo,
                        sdp_offer: peerConnection.localDescription.sdp
                    },
                    dataType: 'json',
                    success: function(res) {
                        if (res && res.status === 'OK') {
                            currentCallId = res.call_id;
                            // Start polling for call state
                            startCallerPolling();
                        } else {
                            alert('No se pudo establecer la llamada: ' + res.error);
                            limpiarLlamada();
                        }
                    }
                });
            });

        }).catch(function(err) {
            alert('No se pudo acceder a los dispositivos de audio/video: ' + err.message);
            limpiarLlamada();
        });
    }

    $('#btn-llamada-voz').off('click').on('click', function(e) {
        e.preventDefault();
        iniciarLlamada('audio');
    });

    $('#btn-videollamada').off('click').on('click', function(e) {
        e.preventDefault();
        iniciarLlamada('video');
    });

    // ===================================
    // 3. ANSWER AN INCOMING CALL
    // ===================================
    function aceptarLlamada(call) {
        $('#call-status').text('Conectando...');
        candidateCount.remitente = 0;
        candidateCount.receptor = 0;

        navigator.mediaDevices.getUserMedia({
            audio: true,
            video: (call.tipo === 'video')
        }).then(function(stream) {
            localStream = stream;

            if (call.tipo === 'video') {
                $('#call-overlay').removeClass('show');
                $('#videocall-overlay').addClass('show');
                document.getElementById('local-video').srcObject = stream;
            } else {
                // Change voice call layout to "Connected" state
                $('#call-status').text('En llamada de Voz');
                $('#call-overlay .call-btn-row').html(`
                    <button class="call-btn decline" id="btn-hangup-call" title="Colgar">
                        <i class="ri-phone-fill" style="transform: rotate(135deg);"></i>
                    </button>
                `);
                $('#btn-hangup-call').off('click').on('click', colgarLlamada);
            }

            setupPeerConnection(call.tipo);

            stream.getTracks().forEach(track => {
                peerConnection.addTrack(track, stream);
            });

            // Set Remote SDP Offer
            peerConnection.setRemoteDescription(new RTCSessionDescription({
                type: 'offer',
                sdp: call.sdp_offer
            })).then(() => {
                // Create SDP Answer
                return peerConnection.createAnswer();
            }).then(answer => {
                return peerConnection.setLocalDescription(answer);
            }).then(() => {
                // Send SDP Answer to server
                $.ajax({
                    url: '../controlador/cCalls.php?accion=responder',
                    type: 'POST',
                    data: {
                        call_id: call.id,
                        estado: 'accepted',
                        sdp_answer: peerConnection.localDescription.sdp
                    },
                    success: function() {
                        // Start polling candidates & call state
                        startCalleePolling();
                    }
                });
            });

        }).catch(function(err) {
            alert('No se pudo acceder a tus dispositivos multimedia.');
            rechazarLlamada(call.id);
        });
    }

    function rechazarLlamada(callId) {
        $.ajax({
            url: '../controlador/cCalls.php?accion=responder',
            type: 'POST',
            data: { call_id: callId, estado: 'declined' },
            success: function() {
                limpiarLlamada();
            }
        });
    }

    // ===================================
    // 4. SETUP PEER CONNECTION (WebRTC)
    // ===================================
    function setupPeerConnection(tipo) {
        peerConnection = new RTCPeerConnection(rtcConfig);

        // When ICE candidate is generated, upload it to the server
        peerConnection.onicecandidate = function(event) {
            if (event.candidate && currentCallId) {
                let role = isCaller ? 'remitente' : 'receptor';
                $.ajax({
                    url: '../controlador/cCalls.php?accion=add-ice',
                    type: 'POST',
                    data: {
                        call_id: currentCallId,
                        role: role,
                        candidate: JSON.stringify(event.candidate)
                    }
                });
            }
        };

        // When remote stream arrives, play it
        peerConnection.ontrack = function(event) {
            let remoteStream = event.streams[0];
            if (tipo === 'video') {
                document.getElementById('remote-video').srcObject = remoteStream;
            } else {
                document.getElementById('webrtc-remote-audio').srcObject = remoteStream;
            }
        };

        // Monitor connection status
        peerConnection.onconnectionstatechange = function() {
            if (peerConnection.connectionState === 'disconnected' || peerConnection.connectionState === 'failed') {
                colgarLlamada();
            }
        };
    }

    // ===================================
    // 5. CALLER POLLING (Wait for Answer)
    // ===================================
    function startCallerPolling() {
        if(callPollingInterval) clearInterval(callPollingInterval);
        
        callPollingInterval = setInterval(function() {
            if (!currentCallId) return;

            $.ajax({
                url: '../controlador/cCalls.php?accion=poll-estado&call_id=' + currentCallId,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    if (res && res.call) {
                        let call = res.call;
                        
                        if (call.estado === 'declined') {
                            alert('El usuario rechazó la llamada.');
                            limpiarLlamada();
                        } else if (call.estado === 'hungup') {
                            limpiarLlamada();
                        } else if (call.estado === 'accepted') {
                            $('#call-status').text(call.tipo === 'video' ? 'Conectado · Videollamada' : 'Conectado · Voz');
                            
                            // If remote description not set, set it from the answer SDP
                            if (peerConnection && peerConnection.signalingState === 'have-local-offer') {
                                peerConnection.setRemoteDescription(new RTCSessionDescription({
                                    type: 'answer',
                                    sdp: call.sdp_answer
                                }));
                            }

                            // Fetch callee's ICE candidates
                            fetchIceCandidates(call.ice_candidates_receptor, 'receptor');
                        }
                    }
                }
            });
        }, 2000);
    }

    // ===================================
    // 6. CALLEE POLLING (Wait for Hangup)
    // ===================================
    function startCalleePolling() {
        if(callPollingInterval) clearInterval(callPollingInterval);

        callPollingInterval = setInterval(function() {
            if (!currentCallId) return;

            $.ajax({
                url: '../controlador/cCalls.php?accion=poll-estado&call_id=' + currentCallId,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    if (res && res.call) {
                        let call = res.call;
                        if (call.estado === 'hungup') {
                            limpiarLlamada();
                        } else {
                            // Fetch caller's ICE candidates
                            fetchIceCandidates(call.ice_candidates_remitente, 'remitente');
                        }
                    }
                }
            });
        }, 2000);
    }

    // Helper to feed fetched candidates into peer connection
    function fetchIceCandidates(candidatesJson, senderRole) {
        if (!candidatesJson || !peerConnection) return;
        try {
            let candidates = typeof candidatesJson === 'string' ? JSON.parse(candidatesJson) : candidatesJson;
            if (Array.isArray(candidates)) {
                let processed = candidateCount[senderRole];
                for (let i = processed; i < candidates.length; i++) {
                    peerConnection.addIceCandidate(new RTCIceCandidate(candidates[i]));
                }
                candidateCount[senderRole] = candidates.length;
            }
        } catch (e) {
            console.error('Error adding ICE candidate', e);
        }
    }

    // ===================================
    // 7. HANG UP & CLEANUP
    // ===================================
    function colgarLlamada() {
        if (currentCallId) {
            $.ajax({
                url: '../controlador/cCalls.php?accion=colgar',
                type: 'POST',
                data: { call_id: currentCallId },
                complete: function() {
                    limpiarLlamada();
                }
            });
        } else {
            limpiarLlamada();
        }
    }

    function limpiarLlamada() {
        if (callPollingInterval) clearInterval(callPollingInterval);
        callPollingInterval = null;

        // Stop media streams
        if (localStream) {
            localStream.getTracks().forEach(track => track.stop());
            localStream = null;
        }

        // Close WebRTC connection
        if (peerConnection) {
            peerConnection.close();
            peerConnection = null;
        }

        currentCallId = null;

        // Reset inputs and streams
        document.getElementById('local-video').srcObject = null;
        document.getElementById('remote-video').srcObject = null;
        document.getElementById('webrtc-remote-audio').srcObject = null;

        // Close UI overlays
        $('#call-overlay').removeClass('show');
        $('#videocall-overlay').removeClass('show');
    }

    // Handle Mic / Cam Toggle Controls in Video Overlay
    let micEnabled = true;
    let camEnabled = true;

    $('#btn-toggle-mic').off('click').on('click', function() {
        micEnabled = !micEnabled;
        if (localStream) {
            localStream.getAudioTracks().forEach(track => {
                track.enabled = micEnabled;
            });
        }
        $(this).find('i').toggleClass('ri-mic-line ri-mic-off-line');
    });

    $('#btn-toggle-cam').off('click').on('click', function() {
        camEnabled = !camEnabled;
        if (localStream) {
            localStream.getVideoTracks().forEach(track => {
                track.enabled = camEnabled;
            });
        }
        $(this).find('i').toggleClass('ri-camera-line ri-camera-off-line');
    });

    $('#btn-hangup-video').off('click').on('click', colgarLlamada);
});
