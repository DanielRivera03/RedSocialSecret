<?php
session_start();
$_SESSION['nombre_usuario'] = 'Daniel';
$_SESSION['usuario_unico'] = 'Daniel';
$_SESSION['id_usuario'] = 1;
$_SESSION['fotos_perfiles'] = 'default.png';

include 'vista/marketplace.php';
?>
