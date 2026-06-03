<?php
$log_path = 'C:\\Users\\elias.martinez\\.gemini\\antigravity-ide\\brain\\2802e83e-d502-46bc-9c47-4a1c13c0d8fc\\.system_generated\\logs\\transcript.jsonl';
$files = [];

$handle = fopen($log_path, 'r');
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $data = json_decode($line, true);
        if (!$data) continue;
        if (isset($data['type']) && $data['type'] == 'VIEW_FILE' && isset($data['content'])) {
            $content = $data['content'];
            if (preg_match('/File Path: `file:\/\/\/(.*?)`/', $content, $match)) {
                $file_path = strtolower(str_replace('/', '\\', $match[1]));
                if (strpos($file_path, 'secretsocial') === false) continue;
                
                if (preg_match('/Showing lines (\d+) to (\d+)/', $content, $lines_match)) {
                    if (!isset($files[$file_path])) {
                        $files[$file_path] = [];
                    }
                    
                    $parts = explode('The following code has been modified', $content);
                    if (count($parts) > 1) {
                        $lines_block = explode('The above content does NOT show', $parts[1])[0];
                        $lines_arr = explode("\n", $lines_block);
                        foreach ($lines_arr as $l) {
                            if (preg_match('/^(\d+):\s(.*)/', $l, $m)) {
                                $ln = (int)$m[1];
                                // Trim carriage returns that might be captured
                                $txt = rtrim($m[2], "\r");
                                $files[$file_path][$ln] = $txt;
                            }
                        }
                    }
                }
            }
        }
    }
    fclose($handle);
}

foreach ($files as $fp => $lines_dict) {
    if (strpos($fp, 'inicio.php') !== false || strpos($fp, 'perfil.php') !== false || strpos($fp, 'perfilesgeneral.php') !== false) {
        echo "Recovered " . count($lines_dict) . " lines for $fp\n";
        $name = basename($fp);
        $out_path = 'C:\\xampp\\htdocs\\SecretSocial\\vista\\' . $name . '.recovered';
        if (count($lines_dict) == 0) continue;
        $max_line = max(array_keys($lines_dict));
        $out_content = '';
        for ($i = 1; $i <= $max_line; $i++) {
            $out_content .= (isset($lines_dict[$i]) ? $lines_dict[$i] : '') . "\n";
        }
        file_put_contents($out_path, $out_content);
        echo "Saved to $out_path\n";
    }
}
?>
