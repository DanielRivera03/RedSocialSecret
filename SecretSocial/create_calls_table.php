<?php
include 'modelo/conexion.php';

$sql = "CREATE TABLE IF NOT EXISTS `chat_llamadas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_remitente` int(11) NOT NULL,
  `id_receptor` int(11) NOT NULL,
  `tipo` varchar(20) NOT NULL COMMENT 'audio, video',
  `estado` varchar(20) NOT NULL DEFAULT 'calling' COMMENT 'calling, accepted, declined, hungup',
  `sdp_offer` text DEFAULT NULL,
  `sdp_answer` text DEFAULT NULL,
  `ice_candidates_remitente` text DEFAULT NULL,
  `ice_candidates_receptor` text DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

if (mysqli_query($conectarsistema, $sql)) {
    echo "Table chat_llamadas created/verified successfully.\n";
} else {
    echo "Error creating table: " . mysqli_error($conectarsistema) . "\n";
}
?>
