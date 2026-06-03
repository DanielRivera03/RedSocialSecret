"const fs = require('fs');

const filepath = 'c:\\xampp\\htdocs\\SecretSocial\\vista\\inicio.php';
let content = fs.readFileSync(filepath, 'utf8');

// 1. Normalize line endings
content = content.replace(/\\
/g, '\
');

// 2. Fix the padding of the notes container to prevent note bubbles clipping at the top
const notesPaddingTarget = `style="overflow-x: auto; gap: 16px; padding: 10px 5px; scrollbar-width: none; -ms-overflow-style: none;"`;
const notesPaddingReplacement = `style="overflow-x: auto; gap: 16px; padding: 35px 5px 10px 5px; scrollbar-width: none; -ms-overflow-style: none;"`;

if (content.includes(notesPaddingTarget)) {
    content = content.replace(notesPaddingTarget, notesPaddingReplacement);
    console.log("SUCCESS: Fixed notes padding");
} else {
    console.log("WARNING: Notes padding target not found");
}

// 3. Inject Search Input inside music-note-modal Music Tab
const musicTabTarget = `<div class="tab-pane fade show active" id="music-tab-content" role="tabpanel">
                     <div class="form-group mb-2">
                        <label class="font-weight-600 font-size-12">Selecciona una canción (estilo Instagram):</label>
                        <div id="music-library-container" style="max-height: 200px; overflow-y: auto; border: 1px solid #eef0f2; border-radius: 10px; background: #fafafa;">`;

const musicTabReplacement = `<div class="tab-pane fade show active" id="music-tab-content" role="tabpanel">
                     <div class="form-group mb-2">
                        <label class="font-weight-600 font-size-12">Buscar o seleccionar una canción (estilo Instagram):</label>
                        <div class="input-group mb-2">
                           <input type="text" id="music-search-input" class="form-control font-size-12" placeholder="Buscar canción, artista o género..." style="border-radius: 8px 0 0 8px;">
                           <div class="input-group-append">
               
<truncated 9877 bytes>