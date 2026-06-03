<?php
$log_dir = 'C:\\Users\\elias.martinez\\.gemini\\antigravity-ide\\brain';
$files = glob($log_dir . '/*/.system_generated/logs/transcript.jsonl');
foreach ($files as $file) {
    $handle = fopen($file, 'r');
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            if (strpos($line, 'cMarketplace.php') !== false || strpos($line, 'recuperar_password.php') !== false) {
                echo "Found in " . basename(dirname(dirname(dirname($file)))) . "\n";
                break;
            }
        }
        fclose($handle);
    }
}
?>
