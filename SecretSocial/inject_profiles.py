import os

files = [
    r"c:\xampp\htdocs\SecretSocial\vista\perfil.php",
    r"c:\xampp\htdocs\SecretSocial\vista\perfilesgeneral.php"
]

for file in files:
    with open(file, 'r', encoding='utf-8', errors='ignore') as f:
        content = f.read()
    
    # Simple regex or string replace for the iframe
    import re
    # We want to replace <iframe class="coment-profile" src="../CargarDatosPublicacion/<?php echo ['idpublicacion']; ?>"></iframe>
    # or similar
    pattern = r'<iframe class="coment-profile" src="\.\./CargarDatosPublicacion/<\?php echo \\[\'idpublicacion\'\]; \?>"></iframe>'
    
    replacement = """<!-- LIVE REACTIONS & COMMENTS CONTAINER -->
<div class="comentarios-envivo-container" data-post-id="<?php echo ['idpublicacion']; ?>">
    <div class="text-center p-3">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Cargando comentarios...</span>
        </div>
    </div>
</div>
<!-- FORM FOR NEW COMMENTS -->
<form class="comment-text d-flex align-items-center mt-3 submit-comment-form" action="javascript:void(0);">
    <input type="text" class="form-control rounded" placeholder="Escribe un comentario..." name="comentario" required>
    <input type="hidden" name="idpublicacion" value="<?php echo ['idpublicacion']; ?>">
    <button type="submit" class="btn btn-primary ml-2"><i class="ri-send-plane-fill"></i></button>
</form>"""
    
    content = re.sub(pattern, replacement, content)
    
    if 'feed_envivo.js' not in content:
        content = content.replace('</body>', '    <script src="../vista/js/feed_envivo.js"></script>\n   </body>')
        
    with open(file, 'w', encoding='utf-8') as f:
        f.write(content)

print("Done replacing in profiles.")
