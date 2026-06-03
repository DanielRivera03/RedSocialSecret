<?php
require('C:/xampp/htdocs/SecretSocial/modelo/conexion.php');

$sqls = [
    "ALTER TABLE chat_mensajes ADD tipo varchar(20) DEFAULT 'text'",
    "ALTER TABLE chat_mensajes ADD archivo varchar(255) DEFAULT NULL"
];

foreach ($sqls as $sql) {
    if (mysqli_query($conectarsistema, $sql)) {
        echo "Exito: $sql\n";
    } else {
        echo "Error: " . mysqli_error($conectarsistema) . "\n";
    }
}
?>
