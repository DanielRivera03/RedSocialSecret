<?php
require('modelo/conexion.php');
echo "=== COLUMNS OF reacciones ===\n";
$res = mysqli_query($conectarsistema, "DESCRIBE reacciones");
if ($res) {
    while($row = mysqli_fetch_assoc($res)) {
        print_r($row);
    }
} else {
    echo "Error describing reacciones: " . mysqli_error($conectarsistema) . "\n";
}
?>
