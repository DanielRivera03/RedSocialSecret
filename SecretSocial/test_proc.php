<?php
require('modelo/conexion.php');
echo "=== VIEW vista_videosmusicalessubidos ===\n";
$res = mysqli_query($conectarsistema, "SHOW CREATE VIEW vista_videosmusicalessubidos");
if ($res) {
    $row = mysqli_fetch_assoc($res);
    echo $row['Create View'] . "\n\n";
} else {
    echo "Error: " . mysqli_error($conectarsistema) . "\n\n";
}
?>
