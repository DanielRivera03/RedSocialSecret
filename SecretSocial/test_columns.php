<?php
require('C:/xampp/htdocs/SecretSocial/modelo/conexion.php');
$res = mysqli_query($conectarsistema, "SHOW CREATE TABLE chat_mensajes");
while($row = mysqli_fetch_array($res)) {
    print_r($row);
}
?>
