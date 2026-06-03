<?php
$c = new mysqli('localhost', 'root', '', 'secretbd');
$res = $c->query('SHOW CREATE PROCEDURE RegistroSolicitudesAmistadUsuarios');
var_dump($res->fetch_assoc());
?>
