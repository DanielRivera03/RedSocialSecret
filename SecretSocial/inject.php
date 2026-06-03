<?php
$files = [
    'C:\\xampp\\htdocs\\SecretSocial\\vista\\perfil.php',
    'C:\\xampp\\htdocs\\SecretSocial\\vista\\perfilesgeneral.php'
];

foreach ($files as $file) {
    $content = file_get_contents($file);
    if (strpos($content, 'conexion_envivo.js') === false) {
        $content = str_replace('</body>', '    <script src="../vista/js/conexion_envivo.js"></script>' . "\n" . '   </body>', $content);
        file_put_contents($file, $content);
    }
}
?>
