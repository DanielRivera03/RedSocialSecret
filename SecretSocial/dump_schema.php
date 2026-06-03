<?php
include 'modelo/conexion.php';

function dump_table($conn, $table) {
    echo "=== TABLE: $table ===\n";
    $res = mysqli_query($conn, "DESCRIBE `$table`");
    if (!$res) {
        echo "Error or table does not exist: " . mysqli_error($conn) . "\n";
        return;
    }
    while ($row = mysqli_fetch_assoc($res)) {
        echo "  - " . $row['Field'] . " (" . $row['Type'] . ")\n";
    }
    echo "\n";
}

dump_table($conectarsistema, 'usuarios');
dump_table($conectarsistema, 'chat_conversaciones');
dump_table($conectarsistema, 'chat_mensajes');
?>
