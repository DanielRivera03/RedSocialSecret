import os

files = [
    r"c:\xampp\htdocs\SecretSocial\vista\perfil.php",
    r"c:\xampp\htdocs\SecretSocial\vista\perfilesgeneral.php"
]

for file in files:
    with open(file, 'r', encoding='utf-8', errors='ignore') as f:
        content = f.read()
    if 'conexion_envivo.js' not in content:
        content = content.replace('</body>', '    <script src="../vista/js/conexion_envivo.js"></script>\n   </body>')
        with open(file, 'w', encoding='utf-8') as f:
            f.write(content)
