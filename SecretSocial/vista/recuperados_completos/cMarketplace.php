"<?php
session_start();
if(!isset($_SESSION['id_usuario'])){
    die(json_encode(['error' => 'No autorizado']));
}

require('../modelo/conexion.php');
$id_usuario = $_SESSION['id_usuario'];
$accion = isset($_GET['accion']) ? $_GET['accion'] : (isset($_POST['accion']) ? $_POST['accion'] : '');

// Crear conexión
$servidor = "localhost";
$usuario = "root";
$clave = "";
$base = "secretbd";
$conn = new mysqli($servidor, $usuario, $clave, $base);
$conn->set_charset("utf8mb4");

if($accion == 'listar_productos'){
    // Listar todos los productos activos
    $query = "SELECT p.*, u.nombres, u.apellidos, u.fotoperfil, u.usuario 
              FROM marketplace_productos p 
              JOIN usuarios u ON p.id_vendedor = u.id 
              WHERE p.estado = 1 
              ORDER BY p.fecha_publicacion DESC";
    $result = $conn->query($query);
    $productos = [];
    while($row = $result->fetch_assoc()){
        $productos[] = $row;
    }
    echo json_encode($productos);
}
elseif($accion == 'publicar_producto'){
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $ciudad = $_POST['ciudad'];
    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];
    
    // Procesar imagen
    $imagen = '';
    if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0){
        $nombre_img = time() . '_' . $_FILES['imagen']['name'];
        $ruta = '../vista/images/marketplace/' . $nombre_img;
        // Crear carpeta si no existe
        if(!is_dir('../vista/images/marketplace/')){
            mkdir('../vista/images/marketplace/', 0777, true);
        }
        if(move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta)){
            $imagen = $nombre_img;
        }
    }
    
    if($titulo && $precio && $imagen){
        $query = "INSERT INTO marketplace_productos (id_vendedor, titulo, descripcion, precio, imagen, ciudad, latitud, longitud) 
                  VALUES (?, ?, ?, ?, ?, ?, ?,
<truncated 346 bytes>