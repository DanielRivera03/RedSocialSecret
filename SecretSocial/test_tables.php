<?php
require('C:/xampp/htdocs/SecretSocial/modelo/conexion.php');
$res = mysqli_query($conectarsistema, "SHOW COLUMNS FROM chat_llamadas");
while($row = mysqli_fetch_array($res)) {
    print_r($row);
}
?>
