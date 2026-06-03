<?php
session_start();
require('../modelo/conexion.php');

header('Content-Type: application/json; charset=utf-8');

if(!isset($_SESSION['id_usuario'])){
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

$accion = isset($_GET['accion']) ? $_GET['accion'] : '';
$idUsuario = $_SESSION['id_usuario'];

switch($accion){
    case 'listar':
        $sql = "SELECT m.*, u.nombres, u.apellidos, u.fotoperfil, u.usuario 
                FROM marketplace_productos m
                JOIN usuarios u ON m.id_vendedor = u.id
                WHERE m.estado = 1
                ORDER BY m.fecha_publicacion DESC";
        $result = mysqli_query($conectarsistema, $sql);
        $productos = [];
        if($result){
            while($row = mysqli_fetch_assoc($result)){
                $productos[] = $row;
            }
        }
        echo json_encode($productos);
        break;

    case 'publicar':
        $titulo = mysqli_real_escape_string($conectarsistema, $_POST['titulo']);
        $descripcion = mysqli_real_escape_string($conectarsistema, $_POST['descripcion']);
        $precio = floatval($_POST['precio']);
        $ciudad = mysqli_real_escape_string($conectarsistema, $_POST['ciudad']);
        $latitud = floatval($_POST['latitud']);
        $longitud = floatval($_POST['longitud']);
        
        $imagen = "default.png";
        if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0){
            $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            $imagen = uniqid('prod_') . '.' . $ext;
            move_uploaded_file($_FILES['imagen']['tmp_name'], '../vista/images/marketplace/' . $imagen);
        }

        $sql = "INSERT INTO marketplace_productos (id_vendedor, titulo, descripcion, precio, imagen, ciudad, latitud, longitud, estado, fecha_publicacion) 
                VALUES ('$idUsuario', '$titulo', '$descripcion', '$precio', '$imagen', '$ciudad', '$latitud', '$longitud', 1, NOW())";
                
        if(mysqli_query($conectarsistema, $sql)){
            echo json_encode(['status' => 'OK']);
        } else {
            echo json_encode(['error' => 'Error al guardar el producto']);
        }
        break;
}

$conectarsistema->close();
?>
