<?php
$file = 'C:\\xampp\\htdocs\\SecretSocial\\vista\\inicio.php';
$content = file_get_contents($file);

// Find the position of "    <!-- Alert -->"
$pos = strpos($content, '    <!-- Alert -->');
if ($pos !== false) {
    $clean = substr($content, 0, $pos);
    $clean .= "    <!-- Alert -->\n";
    $clean .= "    <script src=\"../vista/js/alerta_publicaciones.js\"></script>\n";
    $clean .= "    <script src=\"../vista/js/alerta_eliminarhistorias.js\"></script>\n";
    $clean .= "    <script src=\"../vista/js/alerta-enviosolicitudamistad.js\"></script>\n";
    $clean .= "    <script src=\"../vista/js/alerta-solicitudesaceptadas.js\"></script>\n";
    $clean .= "    <script src=\"../vista/js/alerta-eliminarsolicitudamistad.js\"></script>\n";
    $clean .= "    <script src=\"../vista/js/alerta_buscador.js\"></script>\n";
    $clean .= "    <script src=\"../vista/js/conexion_envivo.js\"></script>\n";
    $clean .= "    <script src=\"../vista/js/feed_envivo.js\"></script>\n";
    $clean .= "    <script src=\"../vista/js/historias_envivo.js\"></script>\n";
    $clean .= "    <script src=\"../vista/js/floating_chat.js\"></script>\n";
    $clean .= "   </body>\n";
    $clean .= "</html>\n";
    $clean .= "<?php\n";
    $clean .= "}else{header('location:../Controlador/cRegistroNuevosUsuarios.php?nuevoregistro=completarperfil');}\n";
    $clean .= "?>\n";
    
    file_put_contents($file, $clean);
    echo "Fixed inicio.php";
} else {
    echo "Could not find Alert string";
}
?>
