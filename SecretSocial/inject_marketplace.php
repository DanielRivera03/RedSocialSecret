<?php
$files = [
    'C:\\xampp\\htdocs\\SecretSocial\\vista\\inicio.php',
    'C:\\xampp\\htdocs\\SecretSocial\\vista\\perfil.php',
    'C:\\xampp\\htdocs\\SecretSocial\\vista\\perfilesgeneral.php'
];

foreach($files as $file) {
    if(file_exists($file)) {
        $content = file_get_contents($file);
        
        if(strpos($content, 'Marketplace') === false) {
            $search = '<li>
                        <a href="../Notificaciones/<?php echo $_SESSION[\'usuario_unico\']; ?>" class="iq-waves-effect"><i class="las la-bell"></i><span>Mis Notificaciones</span></a>
                     </li>';
            $replace = $search . '
                     <li>
                        <a href="../vista/marketplace.php" class="iq-waves-effect"><i class="las la-store"></i><span>Marketplace</span></a>
                     </li>';
            
            $content = str_replace($search, $replace, $content);
            file_put_contents($file, $content);
            echo "Injected Marketplace into $file\n";
        } else {
            echo "Marketplace already in $file\n";
        }
    }
}
?>
