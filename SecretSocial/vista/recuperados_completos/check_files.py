import os

files = [
    r"c:\xampp\htdocs\SecretSocial\vista\iniciarsesion.php",
    r"c:\xampp\htdocs\SecretSocial\vista\inicio.php"
]

for f in files:
    if os.path.exists(f):
        with open(f, 'rb') as file:
            content = file.read(20)
            print(f"{f}: {content}")
    else:
        print(f"Not found: {f}")
