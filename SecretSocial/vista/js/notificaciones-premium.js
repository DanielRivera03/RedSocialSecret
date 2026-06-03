/**
 * SECRET SOCIAL — SISTEMA DE NOTIFICACIONES PREMIUM
 * Librería propia de toast notifications de alta calidad
 * Más profesional que SweetAlert2 para notificaciones rápidas
 * Para confirmaciones/diálogos complejos continúa usando SweetAlert2
 */

(function(window) {
  'use strict';

  // Crear contenedor
  var container = null;
  var toastQueue = [];

  function ensureContainer() {
    if (!container) {
      container = document.createElement('div');
      container.id = 'secret-notifications-container';
      container.setAttribute('aria-live', 'polite');
      container.setAttribute('aria-atomic', 'false');
      document.body.appendChild(container);
      injectStyles();
    }
  }

  function injectStyles() {
    if (document.getElementById('secret-notif-styles')) return;
    var style = document.createElement('style');
    style.id = 'secret-notif-styles';
    style.textContent = `
      #secret-notifications-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 999999;
        display: flex;
        flex-direction: column;
        gap: 10px;
        pointer-events: none;
        max-width: 400px;
        width: calc(100vw - 40px);
      }

      .sn-toast {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        background: #fff;
        border-radius: 16px;
        padding: 16px 18px;
        box-shadow: 0 8px 40px rgba(0,0,0,0.12), 0 2px 8px rgba(0,0,0,0.06);
        pointer-events: all;
        position: relative;
        overflow: hidden;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        border-left: 4px solid #e5e7eb;
        animation: snSlideIn 0.38s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
      }

      .sn-toast.sn-success  { border-left-color: #10b981; }
      .sn-toast.sn-error    { border-left-color: #ef4444; }
      .sn-toast.sn-warning  { border-left-color: #f59e0b; }
      .sn-toast.sn-info     { border-left-color: #3b82f6; }
      .sn-toast.sn-default  { border-left-color: #6366f1; }

      .sn-toast.sn-leaving {
        animation: snSlideOut 0.3s ease forwards;
      }

      @keyframes snSlideIn {
        from { opacity: 0; transform: translateX(70px) scale(0.88); }
        to   { opacity: 1; transform: translateX(0)   scale(1); }
      }
      @keyframes snSlideOut {
        from { opacity: 1; transform: translateX(0) scale(1); max-height: 200px; margin-bottom: 0; }
        to   { opacity: 0; transform: translateX(70px) scale(0.9); max-height: 0; padding-top: 0; padding-bottom: 0; margin-bottom: -10px; }
      }

      .sn-icon-wrap {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
      }
      .sn-success .sn-icon-wrap  { background: #ecfdf5; color: #10b981; }
      .sn-error   .sn-icon-wrap  { background: #fef2f2; color: #ef4444; }
      .sn-warning .sn-icon-wrap  { background: #fffbeb; color: #f59e0b; }
      .sn-info    .sn-icon-wrap  { background: #eff6ff; color: #3b82f6; }
      .sn-default .sn-icon-wrap  { background: #eef2ff; color: #6366f1; }

      .sn-body { flex: 1; min-width: 0; padding-top: 2px; }
      .sn-title {
        font-size: 14px;
        font-weight: 700;
        color: #111827;
        line-height: 1.3;
        margin-bottom: 3px;
      }
      .sn-message {
        font-size: 13px;
        color: #6b7280;
        line-height: 1.45;
        word-break: break-word;
      }
      .sn-action {
        margin-top: 8px;
        font-size: 13px;
        font-weight: 600;
        background: none;
        border: none;
        cursor: pointer;
        padding: 4px 0;
        font-family: inherit;
        text-decoration: underline;
      }
      .sn-success .sn-action  { color: #10b981; }
      .sn-error   .sn-action  { color: #ef4444; }
      .sn-warning .sn-action  { color: #f59e0b; }
      .sn-info    .sn-action  { color: #3b82f6; }

      .sn-close {
        background: none;
        border: none;
        color: #d1d5db;
        cursor: pointer;
        font-size: 18px;
        padding: 0;
        line-height: 1;
        flex-shrink: 0;
        margin-top: 2px;
        transition: color 0.15s;
        font-family: inherit;
      }
      .sn-close:hover { color: #374151; }

      .sn-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 3px;
        border-radius: 0 0 0 16px;
        animation: snProgress linear forwards;
      }
      .sn-success .sn-progress  { background: #10b981; }
      .sn-error   .sn-progress  { background: #ef4444; }
      .sn-warning .sn-progress  { background: #f59e0b; }
      .sn-info    .sn-progress  { background: #3b82f6; }
      .sn-default .sn-progress  { background: #6366f1; }

      @keyframes snProgress {
        from { width: 100%; }
        to   { width: 0%; }
      }

      /* Dark mode */
      body.dark-mode .sn-toast {
        background: #1f2937 !important;
        box-shadow: 0 8px 40px rgba(0,0,0,0.4) !important;
      }
      body.dark-mode .sn-title   { color: #f9fafb !important; }
      body.dark-mode .sn-message { color: #9ca3af !important; }
      body.dark-mode .sn-close   { color: #6b7280 !important; }
      body.dark-mode .sn-close:hover { color: #e5e7eb !important; }
      body.dark-mode .sn-success .sn-icon-wrap { background: #064e3b !important; }
      body.dark-mode .sn-error   .sn-icon-wrap { background: #7f1d1d !important; }
      body.dark-mode .sn-warning .sn-icon-wrap { background: #78350f !important; }
      body.dark-mode .sn-info    .sn-icon-wrap { background: #1e3a5f !important; }

      /* DIALOG / CONFIRM MODAL */
      .sn-dialog-overlay {
        position: fixed; inset: 0; background: rgba(0,0,0,0.55);
        z-index: 1000000; display: flex; align-items: center; justify-content: center;
        backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px);
        animation: snFadeIn 0.2s ease;
      }
      @keyframes snFadeIn { from { opacity:0; } to { opacity:1; } }
      .sn-dialog-box {
        background: #fff;
        border-radius: 20px;
        padding: 36px 32px;
        max-width: 420px;
        width: 92%;
        box-shadow: 0 24px 60px rgba(0,0,0,0.18), 0 4px 16px rgba(0,0,0,0.08);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        animation: snBounceIn 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        text-align: center;
      }
      @keyframes snBounceIn {
        from { opacity: 0; transform: scale(0.85); }
        to   { opacity: 1; transform: scale(1); }
      }
      .sn-dialog-icon { font-size: 52px; margin-bottom: 16px; display: block; }
      .sn-dialog-title { font-size: 20px; font-weight: 700; color: #111827; margin-bottom: 8px; }
      .sn-dialog-text  { font-size: 14px; color: #6b7280; line-height: 1.55; margin-bottom: 24px; }
      .sn-dialog-btns  { display: flex; gap: 10px; justify-content: center; }
      .sn-dialog-btn {
        padding: 11px 24px; border-radius: 12px; border: none; font-size: 14px;
        font-weight: 600; cursor: pointer; transition: all 0.2s;
        font-family: inherit; min-width: 100px;
      }
      .sn-dialog-btn-cancel {
        background: #f3f4f6; color: #374151;
      }
      .sn-dialog-btn-cancel:hover { background: #e5e7eb; }
      .sn-dialog-btn-confirm {
        background: linear-gradient(135deg, #b92025, #e53935);
        color: #fff;
      }
      .sn-dialog-btn-confirm:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(185,32,37,0.3); }
      .sn-dialog-btn-confirm.sn-btn-info    { background: linear-gradient(135deg, #2563eb, #3b82f6); }
      .sn-dialog-btn-confirm.sn-btn-success { background: linear-gradient(135deg, #059669, #10b981); }
      .sn-dialog-btn-confirm.sn-btn-warning { background: linear-gradient(135deg, #d97706, #f59e0b); color: #1f2937; }
      body.dark-mode .sn-dialog-box   { background: #1f2937 !important; }
      body.dark-mode .sn-dialog-title { color: #f9fafb !important; }
      body.dark-mode .sn-dialog-text  { color: #9ca3af !important; }
      body.dark-mode .sn-dialog-btn-cancel { background: #374151 !important; color: #e5e7eb !important; }
    `;
    document.head.appendChild(style);
  }

  var icons = {
    success: '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>',
    error:   '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>',
    warning: '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>',
    info:    '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>',
    default: '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/></svg>'
  };

  /**
   * Show a toast notification
   * @param {string} type - 'success'|'error'|'warning'|'info'|'default'
   * @param {string} title - Main title
   * @param {string} message - Body message
   * @param {object} [opts] - { duration, action: {label, fn}, persistent }
   */
  function show(type, title, message, opts) {
    ensureContainer();
    opts = opts || {};
    var duration = opts.duration || 4500;
    if(opts.persistent) duration = 99999999;
    var id = 'sn-' + Date.now() + '-' + Math.floor(Math.random() * 9999);

    var el = document.createElement('div');
    el.className = 'sn-toast sn-' + (type || 'default');
    el.id = id;
    el.setAttribute('role', 'alert');

    var iconSvg = icons[type] || icons.default;
    var actionHtml = '';
    if(opts.action && opts.action.label) {
      actionHtml = '<button class="sn-action" id="' + id + '-action">' + opts.action.label + '</button>';
    }

    el.innerHTML =
      '<div class="sn-icon-wrap">' + iconSvg + '</div>' +
      '<div class="sn-body">' +
        '<div class="sn-title">' + (title || '') + '</div>' +
        (message ? '<div class="sn-message">' + message + '</div>' : '') +
        actionHtml +
      '</div>' +
      '<button class="sn-close" aria-label="Cerrar">&#x2715;</button>' +
      '<div class="sn-progress" style="animation-duration:' + duration + 'ms"></div>';

    container.appendChild(el);

    // Close button
    el.querySelector('.sn-close').addEventListener('click', function() { dismiss(id); });
    // Action button
    if(opts.action && opts.action.fn) {
      var actionBtn = document.getElementById(id + '-action');
      if(actionBtn) actionBtn.addEventListener('click', function() { opts.action.fn(); dismiss(id); });
    }

    // Auto dismiss
    if(!opts.persistent) {
      setTimeout(function() { dismiss(id); }, duration);
    }

    return id;
  }

  function dismiss(id) {
    var el = document.getElementById(id);
    if(!el) return;
    el.classList.add('sn-leaving');
    setTimeout(function() { if(el && el.parentNode) el.parentNode.removeChild(el); }, 320);
  }

  function dismissAll() {
    var toasts = container ? container.querySelectorAll('.sn-toast') : [];
    toasts.forEach(function(t) { dismiss(t.id); });
  }

  /**
   * Show a confirmation dialog (promise-based)
   * @param {object} opts - { title, text, confirmText, cancelText, type, icon }
   * @returns {Promise<boolean>}
   */
  function confirm(opts) {
    opts = opts || {};
    return new Promise(function(resolve) {
      ensureContainer();
      var dialogIcons = { danger: '🗑️', success: '✅', warning: '⚠️', info: 'ℹ️', question: '❓' };
      var iconChar = opts.icon || dialogIcons[opts.type] || dialogIcons.question;
      var confirmClass = 'sn-btn-' + (opts.type || 'default');

      var overlay = document.createElement('div');
      overlay.className = 'sn-dialog-overlay';
      overlay.innerHTML =
        '<div class="sn-dialog-box">' +
          '<span class="sn-dialog-icon">' + iconChar + '</span>' +
          '<div class="sn-dialog-title">' + (opts.title || '¿Estás seguro?') + '</div>' +
          (opts.text ? '<div class="sn-dialog-text">' + opts.text + '</div>' : '') +
          '<div class="sn-dialog-btns">' +
            '<button class="sn-dialog-btn sn-dialog-btn-cancel" id="sn-cancel">' + (opts.cancelText || 'Cancelar') + '</button>' +
            '<button class="sn-dialog-btn sn-dialog-btn-confirm ' + confirmClass + '" id="sn-confirm">' + (opts.confirmText || 'Confirmar') + '</button>' +
          '</div>' +
        '</div>';

      document.body.appendChild(overlay);

      function cleanup(result) {
        overlay.style.animation = 'snFadeOut 0.2s ease forwards';
        setTimeout(function() { if(overlay.parentNode) overlay.parentNode.removeChild(overlay); }, 200);
        resolve(result);
      }

      overlay.querySelector('#sn-confirm').addEventListener('click', function() { cleanup(true); });
      overlay.querySelector('#sn-cancel').addEventListener('click',  function() { cleanup(false); });
      overlay.addEventListener('click', function(e) { if(e.target === overlay) cleanup(false); });

      // ESC key
      function onKey(e) { if(e.key === 'Escape') { document.removeEventListener('keydown', onKey); cleanup(false); } }
      document.addEventListener('keydown', onKey);
    });
  }

  // Public API — se puede usar en cualquier archivo JS
  window.SN = {
    success: function(title, msg, opts) { return show('success', title, msg, opts); },
    error:   function(title, msg, opts) { return show('error',   title, msg, opts); },
    warning: function(title, msg, opts) { return show('warning', title, msg, opts); },
    info:    function(title, msg, opts) { return show('info',    title, msg, opts); },
    show:    show,
    dismiss: dismiss,
    dismissAll: dismissAll,
    confirm: confirm
  };

  // Retrocompatibilidad: función AlertaUsuarioMostrar global (reemplaza SweetAlert2)
  window.AlertaUsuarioMostrar = function(titulo, descripcion, tipo) {
    var typeMap = { 'success': 'success', 'error': 'error', 'warning': 'warning', 'info': 'info' };
    show(typeMap[tipo] || 'info', titulo, descripcion);
  };

  // Compatibilidad con código que usa Swal.fire()
  if(!window.Swal) {
    window.Swal = {
      fire: function(opts, text, icon) {
        if(typeof opts === 'string') {
          // Swal.fire('titulo', 'texto', 'tipo')
          show(icon || 'info', opts, text);
          return Promise.resolve({ isConfirmed: true });
        } else if(opts && typeof opts === 'object') {
          if(opts.showCancelButton) {
            // Es un confirm
            return confirm({
              title: opts.title || opts.titleText,
              text: opts.text || opts.html,
              confirmText: opts.confirmButtonText || 'Confirmar',
              cancelText: opts.cancelButtonText || 'Cancelar',
              type: opts.icon === 'warning' ? 'danger' : (opts.icon || 'question'),
              icon: opts.icon === 'warning' ? '⚠️' : (opts.icon === 'error' ? '🗑️' : '❓')
            }).then(function(result) {
              return { isConfirmed: result, isDismissed: !result };
            });
          } else {
            show(opts.icon || 'info', opts.title || opts.titleText, opts.text || opts.html);
            return Promise.resolve({ isConfirmed: true });
          }
        }
        return Promise.resolve({ isConfirmed: true });
      }
    };
  }

})(window);
