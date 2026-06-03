<?php
session_start();
require('../modelo/conexion.php');
if(isset($_SESSION['id_usuario'])){
    $uid = intval($_SESSION['id_usuario']);
    mysqli_query($conectarsistema, "UPDATE usuarios SET ultima_conexion = NOW() WHERE id = '$uid'");
    echo json_encode(['status' => 'ok', 'message' => 'Status updated']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
}
?>
