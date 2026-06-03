<?php
$log_dir = 'C:\\Users\\elias.martinez\\.gemini\\antigravity-ide\\brain';
$sessions = ['3a1d6832-0aca-46dc-b2f5-63a1a5eb8e89', '2802e83e-d502-46bc-9c47-4a1c13c0d8fc'];

foreach ($sessions as $session) {
    $file = $log_dir . '\\' . $session . '\\.system_generated\\logs\\transcript.jsonl';
    $handle = fopen($file, 'r');
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            $data = json_decode($line, true);
            if (!$data) continue;
            
            if ((isset($data['type']) && $data['type'] == 'CODE_ACTION') || (isset($data['type']) && $data['type'] == 'PLANNER_RESPONSE')) {
                if (isset($data['tool_calls'])) {
                    foreach ($data['tool_calls'] as $tc) {
                        if ($tc['name'] == 'write_to_file' && isset($tc['args']['TargetFile'])) {
                            $tf = str_replace('"', '', $tc['args']['TargetFile']);
                            if (strpos($tf, 'xampp') !== false) {
                                $code = $tc['args']['CodeContent'];
                                
                                // Clean up literal escapes if present (if the string starts with a quote and ends with one)
                                if (substr($code, 0, 1) === '"' && substr($code, -1) === '"') {
                                    $code = json_decode($code); 
                                }
                                // Sometimes it's just literally escaped
                                $code = str_replace(['\n', '\r', '\"', '\\\\'], ["\n", "\r", '"', '\\'], $code);
                                // Also remove outer quotes if they exist
                                if (substr($code, 0, 1) === '"' && substr($code, -1) === '"') {
                                    $code = substr($code, 1, -1);
                                }

                                $out_path = 'C:\\xampp\\htdocs\\SecretSocial\\vista\\recuperados_completos\\' . basename($tf);
                                file_put_contents($out_path, $code);
                            }
                        }
                    }
                }
            }
        }
        fclose($handle);
    }
}
?>
