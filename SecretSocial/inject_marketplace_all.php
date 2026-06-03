<?php
$dir = 'C:\\xampp\\htdocs\\SecretSocial\\vista';
$files = glob("$dir/*.php");

$marketplace_li = "\n                     <li>\n                        <a href=\"../vista/marketplace.php\" class=\"iq-waves-effect\"><i class=\"las la-store\"></i><span>Marketplace</span></a>\n                     </li>";

// Anchor: Música Favorita link (last menu item before Marketplace should be)
// We insert after the Música/Videos li or before </ul> of iq-sidebar-toggle
$injected = [];
$already = [];

foreach ($files as $file) {
    $content = file_get_contents($file);
    
    // Only process files with a sidebar
    if (strpos($content, 'iq-sidebar-toggle') === false) continue;
    
    // Already has Marketplace
    if (strpos($content, 'Marketplace') !== false) {
        $already[] = basename($file);
        continue;
    }
    
    // Inject before closing </ul> of iq-sidebar-toggle
    // Look for the specific closing pattern
    $new_content = preg_replace(
        '/(<\/ul>\s*<\/nav>)/s',
        $marketplace_li . "\n                   $1",
        $content,
        1
    );
    
    if ($new_content !== $content) {
        file_put_contents($file, $new_content);
        $injected[] = basename($file);
    }
}

echo "INJECTED:\n" . implode("\n", $injected) . "\n\n";
echo "ALREADY HAD IT:\n" . implode("\n", $already) . "\n";
?>
