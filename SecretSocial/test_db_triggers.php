<?php
$sql = file_get_contents('C:\xampp\htdocs\SecretSocial\secretdb.sql');

// Find triggers
preg_match_all('/CREATE TRIGGER.*?(?=DELIMITER|\$\$|--)/is', $sql, $matches);
echo "Found " . count($matches[0]) . " triggers:\n";
foreach(slice($matches[0], 0, 10) as $t) {
    echo "--- TRIGGER ---\n" . trim(substr($t, 0, 300)) . "\n";
}

// Find notificacioncomentarios lines
$lines = explode("\n", $sql);
$found = [];
foreach($lines as $line) {
    if(stripos($line, 'notificacioncomentarios') !== false) {
        $found[] = $line;
    }
}
echo "\nFound " . count($found) . " lines with notificacioncomentarios:\n";
foreach(array_slice($found, 0, 10) as $line) {
    echo trim($line) . "\n";
}

function slice($arr, $start, $len) {
    return array_slice($arr, $start, $len);
}
