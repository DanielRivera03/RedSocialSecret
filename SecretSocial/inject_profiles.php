<?php
$files = [
    'C:\\xampp\\htdocs\\SecretSocial\\vista\\perfil.php',
    'C:\\xampp\\htdocs\\SecretSocial\\vista\\perfilesgeneral.php'
];

foreach ($files as $file) {
    if (!file_exists($file)) continue;
    
    $content = file_get_contents($file);
    
    // Replace iframe
    $pattern = '/<iframe class="coment-profile" src="\.\.\/CargarDatosPublicacion\/<\?php echo \$filas\[\'idpublicacion\'\]; \?>"><\/iframe>/';
    
    $replacement = '<!-- LIVE REACTIONS & COMMENTS CONTAINER -->
<div class="comentarios-envivo-container" data-post-id="<?php echo $filas[\'idpublicacion\']; ?>">
    <div class="text-center p-3">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Cargando comentarios...</span>
        </div>
    </div>
</div>
<!-- FORM FOR NEW COMMENTS -->
<form class="comment-text d-flex align-items-center mt-3 submit-comment-form" action="javascript:void(0);">
    <input type="text" class="form-control rounded" placeholder="Escribe un comentario..." name="comentario" required>
    <input type="hidden" name="idpublicacion" value="<?php echo $filas[\'idpublicacion\']; ?>">
    <button type="submit" class="btn btn-primary ml-2"><i class="ri-send-plane-fill"></i></button>
</form>';

    $content = preg_replace($pattern, $replacement, $content);
    
    if (strpos($content, 'feed_envivo.js') === false) {
        $content = str_replace('</body>', '    <script src="../vista/js/feed_envivo.js"></script>' . "\n" . '   </body>', $content);
    }
    
    file_put_contents($file, $content);
    echo "Processed $file\n";
}
?>
