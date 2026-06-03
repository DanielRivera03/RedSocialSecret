"<?php
/*
--------------------------------------------------------
║            SECRET - RED SOCIAL PHP NATIVO            ║
--------------------------------------------------------           
    AUTOR: DANIEL RIVERA (danielrivera03)
    Github: https://github.com/DanielRivera03
    VERSIONES TESTEADAS: 7.3 a 8.0
    -> VERSIONES INFERIORES PROBABLEMENTE TENGAN
    ALGUN CONFLICTO. TOMAR EN CUENTA.
    COPYRIGHT © 2020 - 2021
--------------------------------------------------------
*/
session_start();
require('../modelo/conexion.php');

header('Content-Type: application/json; charset=utf-8');

if(!isset($_SESSION['id_usuario'])){
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

$accion = isset($_GET['accion']) ? $_GET['accion'] : '';

switch($accion){
    // CARGAR LISTA DE AMIGOS PARA CHAT PRIVADO
    case 'cargar-amigos':
        $idUsuario = $_SESSION['id_usuario'];
        $sql = "SELECT u.id, u.nombres, u.apellidos, u.fotoperfil, u.usuario,
                       CASE WHEN (UNIX_TIMESTAMP() - UNIX_TIMESTAMP(u.ultima_actividad)) < 300 THEN 'online' ELSE 'offline' END as estado
                FROM solicitudesamistad sa
                JOIN usuarios u ON (
                    (sa.id_usuario_envia = '$idUsuario' AND u.id = sa.id_usuario_recibe) OR
                    (sa.id_usuario_recibe = '$idUsuario' AND u.id = sa.id_usuario_envia)
                )
                WHERE sa.estado = 1
                ORDER BY u.nombres ASC";
        $result = mysqli_query($conectarsistema, $sql);
        $amigos = [];
        if($result){
            while($row = mysqli_fetch_assoc($result)){
                $amigos[] = $row;
            }
        }
        echo json_encode($amigos);
        break;

    // CARGAR MENSAJES DE CHAT PRIVADO ENTRE DOS USUARIOS
    case 'cargar-mensajes':
        $idUsuario = $_SESSION['id_usuario'];
        $idAmigo = isset($_GET['id_amigo']) ? intval($_GET['id_amigo']) : 0;
        if($idAmigo == 0){
            echo js
<truncated 4175 bytes>