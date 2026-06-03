<?php
include 'modelo/conexion.php';

$res = mysqli_query($conectarsistema, "SHOW COLUMNS FROM usuarios LIKE 'typing_to'");
if (mysqli_num_rows($res) == 0) {
    $alter = mysqli_query($conectarsistema, "ALTER TABLE usuarios ADD COLUMN typing_to INT(11) DEFAULT 0");
    if ($alter) {
        echo "Column typing_to added successfully.\n";
    } else {
        echo "Error adding column: " . mysqli_error($conectarsistema) . "\n";
    }
} else {
    echo "Column typing_to already exists.\n";
}
?>
