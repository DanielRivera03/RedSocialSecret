<?php
require('modelo/conexion.php');
echo "=== CLEANING LOCAL VIDEO RECORDS ===\n";
$query = "DELETE FROM videos WHERE video NOT LIKE 'http%' AND video NOT LIKE 'www.%' AND video NOT LIKE '%spotify%' AND video NOT LIKE '%youtube%' AND video NOT LIKE '%apple%'";
$res = mysqli_query($conectarsistema, $query);
if ($res) {
    echo "Deleted local video records successfully. Rows affected: " . mysqli_affected_rows($conectarsistema) . "\n";
} else {
    echo "Error: " . mysqli_error($conectarsistema) . "\n";
}
?>
