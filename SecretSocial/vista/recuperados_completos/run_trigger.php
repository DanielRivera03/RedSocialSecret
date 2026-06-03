<?php
require('conexion.php');
$sql = "DROP TRIGGER IF EXISTS ActualizacionReaccionMeGustaDelete";
$conectarsistema->query($sql);

$sql = "CREATE TRIGGER ActualizacionReaccionMeGustaDelete AFTER DELETE ON reacciones FOR EACH ROW UPDATE publicaciones SET megusta = GREATEST(0, megusta - 1) WHERE idpublicacion=old.idpublicacion";
if($conectarsistema->query($sql)) {
    echo "TRIGGER_CREATED_SUCCESSFULLY";
} else {
    echo "ERROR: " . $conectarsistema->error;
}
?>
