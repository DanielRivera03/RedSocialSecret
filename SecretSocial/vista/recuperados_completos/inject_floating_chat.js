const fs   = require('fs');
const path = require('path');

// Archivos a parchear
const targets = [
    'vista/inicio.php',
    'vista/perfil.php',
    'vista/perfilesgeneral.php',
    'vista/marketplace.php',
    'vista/multimedia-videos.php',
    'vista/mensajeriausuarios.php',
    'vista/listadoamigosaceptados.php',
    'vista/listadosolicitudesamistad.php',
    'vista/listadonotificaciones.php',
    'vista/registrareventos.php',
    'vista/listadoeventosregistrados.php',
    'vista/resultadosbusqueda.php',
];

// Fragmento a insertar ANTES de </body>
const INSERT = `
<!-- ═══ FLOATING CHAT (Secret Messenger) ══════════════════════════ -->
<script>
window.SECRET_USER_ID = <?php echo isset($_SESSION['id_usuario']) ? (int)$_SESSION['id_usuario'] : 0; ?>;
</script>
<script src="../vista/js/floating_chat.js"></script>
<!-- ══════════════════════════════════════════════════════════════ -->
`;

let patched = 0;
let skipped = 0;

targets.forEach(rel => {
    const fp = path.join('c:/xampp/htdocs/SecretSocial', rel);
    if (!fs.existsSync(fp)) { console.log('NO EXISTE:', fp); skipped++; return; }

    let content = fs.readFileSync(fp, 'utf8');

    // No parchear si ya tiene floating_chat.js
    if (content.includes('floating_chat.js')) {
        console.log('YA TIENE:', rel);
        skipped++;
        return;
    }

    // Insertar antes de </body>
    if (!content.includes('</body>')) {
        console.log('SIN </body>:', rel);
        skipped++;
        return;
    }

    content = content.replace('</body>', INSERT + '</body>');
    fs.writeFileSync(fp, content, 'utf8');
    console.log('PARCHADO:', rel);
    patched++;
});

console.log(`
Listo: ${patched} parchados, ${skipped} omitidos.`);
