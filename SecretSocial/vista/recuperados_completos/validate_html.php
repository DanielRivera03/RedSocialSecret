<?php
// Combine the files to check nested rendering tags
$inicio = file_get_contents('vista/inicio.php');
$feed = file_get_contents('vista/partials/publicacion_feed.php');
$comments = file_get_contents('vista/plantilla_comentarios.php');

// Simulate the replacement
// In inicio.php: require('../vista/partials/publicacion_feed.php');
// In publicacion_feed.php: require('../vista/plantilla_comentarios.php');

$combined = str_replace(
    "require('../vista/partials/publicacion_feed.php');", 
    $feed, 
    $inicio
);
$combined = str_replace(
    "require('../vista/plantilla_comentarios.php');", 
    $comments, 
    $combined
);

// Remove PHP blocks to avoid false matches
$clean = preg_replace('/<\?php.*?\?>/s', '', $combined);

// Trace div tags
$lines = explode("
", $clean);
$stack = [];

foreach ($lines as $line_num => $line) {
    preg_match_all('/(<\/?div\b[^>]*>)/', $line, $line_matches);
    foreach ($line_matches[1] as $tag) {
        $real_line = $line_num + 1;
        if (strpos($tag, '</') === 0) {
            if (empty($stack)) {
                echo "Extra closing tag on line $real_line: " . htmlspecialchars($tag) . "
";
            } else {
                array_pop($stack);
            }
        } else {
            $stack[] = ['tag' => $tag, 'line' => $real_line];
        }
    }
}

echo "Remaining open tags in stack:
";
foreach ($stack as $open) {
    echo "Line " . $open['line'] . ": " . htmlspecialchars($open['tag']) . "
";
}
