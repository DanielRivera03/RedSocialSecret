"const fs = require('fs');
const path = require('path');

const filepath = 'c:\\xampp\\htdocs\\SecretSocial\\vista\\inicio.php';
let content = fs.readFileSync(filepath, 'utf8');

// Normalize line endings
content = content.replace(/\\
/g, '\
');

// Find the index of line 812: '<script>' right after 'alerta_buscador.js'
const scriptTargetStr = `<script>\
// Previsualizar múltiples imágenes seleccionadas`;
const targetIdx = content.indexOf(scriptTargetStr);

if (targetIdx === -1) {
    console.error("Could not find the target script block starting with: " + scriptTargetStr);
    process.exit(1);
}

// Split the file content at targetIdx. We will keep everything before targetIdx.
const beforeTarget = content.substring(0, targetIdx);

// Let's build the HTML modals to insert before the script block
const htmlModals = `
<!-- Modal para Crear Historia (Centrado) -->
<div class="modal fade" id="story-modal" tabindex="-1" role="dialog" aria-labelledby="story-modalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content" style="border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
         <div class="modal-header border-0 pb-0">
            <h5 class="modal-title font-weight-bold" id="story-modalLabel">Crear una Nueva Historia</h5>
            <button type="button" class="btn btn-secondary btn-sm rounded-circle" data-dismiss="modal"><i class="ri-close-fill font-size-18"></i></button>
         </div>
         <div class="modal-body p-4">
            <form id="story-form" action="javascript:void(0);" method="POST" enctype="multipart/form-data">
               <div class="form-group">
                  <label for="texto_historia" class="font-weight-600">Texto de la Historia (opcional si subes foto):</label>
                  <textarea name="texto_historia" id="texto_historia" class="form-control" style="border-radius:
<truncated 27560 bytes>