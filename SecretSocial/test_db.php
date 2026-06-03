<?php
require('modelo/conexion.php');
echo "=== TRIGGERS ===\n";
$res = mysqli_query($conectarsistema, "SHOW TRIGGERS");
if ($res) {
    while($row = mysqli_fetch_assoc($res)) {
        echo "Trigger: " . $row['Trigger'] . "\n";
        echo "Event: " . $row['Event'] . "\n";
        echo "Table: " . $row['Table'] . "\n";
        echo "Statement: " . $row['Statement'] . "\n";
        echo "Timing: " . $row['Timing'] . "\n";
        echo "--------------------------\n";
    }
} else {
    echo "Error: " . mysqli_error($conectarsistema) . "\n";
}
?>

