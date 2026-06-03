<?php
$file = 'C:\\xampp\\htdocs\\SecretSocial\\vista\\inicio.php';
$content = file_get_contents($file);

if (strpos($content, 'notas_musica.js') === false) {
    $search = '<script src="../vista/js/historias_envivo.js"></script>';
    $replace = $search . "\n    <script src=\"../vista/js/notas_musica.js\"></script>";
    
    $content = str_replace($search, $replace, $content);
    file_put_contents($file, $content);
    echo "Injected notas_musica.js";
} else {
    echo "Already injected";
}
?>
