<?php
\ = [
    'C:\\xampp\\htdocs\\SecretSocial\\vista\\perfil.php',
    'C:\\xampp\\htdocs\\SecretSocial\\vista\\perfilesgeneral.php'
];

foreach(\ as \) {
    \ = file_get_contents(\);
    \ = preg_replace('/<iframe class="coment-profile" src="\.\.\/CargarDatosPublicacion\/\'; echo \\[\'idpublicacion\'\]; echo \'"><\/iframe>/s', '<div class="feed-comentarios-container" data-id="\'; echo \[\'idpublicacion\']; echo \'"></div>', \);
    file_put_contents(\, \);
    echo "Replaced in \\n";
}
?>
