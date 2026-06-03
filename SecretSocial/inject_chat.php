<?php
$dir = new RecursiveDirectoryIterator('C:\\xampp\\htdocs\\SecretSocial\\vista');
$ite = new RecursiveIteratorIterator($dir);

foreach ($ite as $file) {
    if ($file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        if (strpos($content, 'floating_chat.js') === false && strpos($content, '</body>') !== false) {
            $content = str_replace('</body>', '    <script src="../vista/js/floating_chat.js"></script>' . "\n" . '   </body>', $content);
            file_put_contents($file->getPathname(), $content);
            echo "Injected in: " . $file->getPathname() . "\n";
        }
    }
}
?>
