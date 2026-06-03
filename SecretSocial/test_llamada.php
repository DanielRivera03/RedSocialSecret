<?php
require('C:/xampp/htdocs/SecretSocial/modelo/conexion.php');
$idLlamada = 1;
$uid = 1;

$sql = "SELECT cl.*, 
        u1.nombres as remitente_nombres, u1.apellidos as remitente_apellidos, u1.fotoperfil as remitente_foto,
        u2.nombres as receptor_nombres, u2.apellidos as receptor_apellidos, u2.fotoperfil as receptor_foto
        FROM chat_llamadas cl 
        JOIN usuarios u1 ON cl.id_remitente = u1.id
        JOIN usuarios u2 ON cl.id_receptor = u2.id
        WHERE cl.id = '$idLlamada' AND (cl.id_remitente = '$uid' OR cl.id_receptor = '$uid')";
$res = mysqli_query($conectarsistema, $sql);

if(!$res) {
    echo "ERROR: " . mysqli_error($conectarsistema);
} else {
    echo "SUCCESS: " . mysqli_num_rows($res) . " rows";
}
?>
