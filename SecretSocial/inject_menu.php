<?php
$dir = 'C:\\xampp\\htdocs\\SecretSocial\\vista';
$files = glob("$dir/*.php");

foreach($files as $file) {
    $content = file_get_contents($file);
    if(strpos($content, '<span>Mis Notificaciones</span></a>') !== false) {
        if(strpos($content, 'Marketplace') === false) {
            $pattern = '/(<span>Mis Notificaciones<\/span><\/a>.*?<\/li>)/is';
            $replacement = '$1' . "\n                     <li>\n                        <a href=\"../vista/marketplace.php\" class=\"iq-waves-effect\"><i class=\"las la-store\"></i><span>Marketplace</span></a>\n                     </li>";
            $new_content = preg_replace($pattern, $replacement, $content);
            file_put_contents($file, $new_content);
            echo "Injected in " . basename($file) . "\n";
        } else {
            echo "Already in " . basename($file) . "\n";
        }
    }
}
?>
