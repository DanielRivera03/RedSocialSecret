"/**
 * SECRET – Floating Chat Bubble (tipo Facebook Messenger)
 * Funciona en TODAS las páginas de la red social.
 * Pollea cada 4 segundos si hay mensajes no leídos y muestra
 * burbujas flotantes con mini-ventana de chat.
 */

(function() {
'use strict';

// ─── CONFIG ───────────────────────────────────────────────────────────────────
const CHAT_CTRL   = '../controlador/cChatPrivado.php';
const POLL_MS     = 4000;  // 4 segundos
const PICS_BASE   = '../vista/images/fotosperfiles/';
const MAX_WINDOWS = 3;     // máximo de ventanas abiertas simultáneas

// ─── ESTADO ───────────────────────────────────────────────────────────────────
const openWindows = {};   // { id_remitente: DOMElement }
let   notifSound  = null;
let   lastSeen    = {};   // { id_remitente: timestamp del último msg visto }
let   pollTimer   = null;

// ─── INICIALIZAR ──────────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', init);

function init() {
    injectStyles();
    notifSound = new Audio('data:audio/wav;base64,UklGRiQAAABXQVZFZm10IBAAAAABAAEARKwAAIhYAQACABAAZGF0YQAAAAA=');
    startPolling();
    pingPresence();
    setInterval(pingPresence, 60000); // ping cada 1 min
}

// ─── PING DE PRESENCIA ────────────────────────────────────────────────────────
function pingPresence() {
    fetch(CHAT_CTRL + '?accion=ping').catch(() => {});
}

// ─── POLLING ──────────────────────
<truncated 18702 bytes>