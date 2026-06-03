import json
import re

log_path = r'C:\Users\elias.martinez\.gemini\antigravity-ide\brain\2802e83e-d502-46bc-9c47-4a1c13c0d8fc\.system_generated\logs\transcript.jsonl'
files = {}

with open(log_path, 'r', encoding='utf-8') as f:
    for line in f:
        try:
            data = json.loads(line)
        except:
            continue
        if data.get('type') == 'VIEW_FILE' and 'content' in data:
            content = data['content']
            match = re.search(r'File Path: ile:///(.*?)', content)
            if not match: continue
            file_path = match.group(1).replace('/', '\\').lower()
            if 'secretsocial' not in file_path: continue
            
            # extract lines
            lines_match = re.search(r'Showing lines (\d+) to (\d+)', content)
            if not lines_match: continue
            start = int(lines_match.group(1))
            end = int(lines_match.group(2))
            
            if file_path not in files:
                files[file_path] = {}
            
            # parse the lines
            lines_block = content.split('The following code has been modified')[1]
            lines_block = lines_block.split('The above content does NOT show')[0]
            
            for l in lines_block.split('\n'):
                m = re.match(r'^(\d+): (.*)', l)
                if m:
                    ln = int(m.group(1))
                    txt = m.group(2)
                    files[file_path][ln] = txt

for fp, lines_dict in files.items():
    if 'inicio.php' in fp or 'perfil.php' in fp or 'perfilesgeneral.php' in fp:
        print(f"Recovered {len(lines_dict)} lines for {fp}")
        out_path = 'C:\\xampp\\htdocs\\SecretSocial\\vista\\' + fp.split('\\\\')[-1].split('\\')[-1] + '.recovered'
        with open(out_path, 'w', encoding='utf-8') as out:
            for i in range(1, max(lines_dict.keys()) + 1):
                out.write(lines_dict.get(i, '') + '\n')
        print(f"Saved to {out_path}")
