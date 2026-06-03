<?php
require('conexion.php');
$sql = "CREATE TABLE IF NOT EXISTS asistencia_eventos (
    id_asistencia INT AUTO_INCREMENT PRIMARY KEY,
    idevento INT NOT NULL,
    id_usuario INT NOT NULL,
    estado VARCHAR(20) NOT NULL,
    UNIQUE KEY (idevento, id_usuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
if($conectarsistema->query($sql)) {
    echo "TABLE_CREATED_SUCCESSFULLY";
} else {
    echo "ERROR: " . $conectarsistema->error;
}
?>
