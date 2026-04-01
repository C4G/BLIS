<?php
#
# Serves lab logo images from STORAGE_DIR/logos/.
# Accepts:
#   ?id=<lab_config_id>            → logo_<id>.<ext>
#   ?id=<lab_config_id>&type=billing → logo_billing_<id>.<ext>
#

require_once("includes/SessionCheck.php");
require_once("includes/db_lib.php");

$id   = (int)($_GET['id'] ?? 0);
$type = ($_GET['type'] ?? '') === 'billing' ? 'billing' : '';

if ($id <= 0) {
    http_response_code(404);
    exit;
}

$base    = $type ? "logo_{$type}_{$id}" : "logo_{$id}";
$baseDir = $STORAGE_DIR . "/logos/";

$mimeMap = [
    'jpg'  => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'png'  => 'image/png',
    'gif'  => 'image/gif',
    'webp' => 'image/webp',
    'svg'  => 'image/svg+xml',
];

$path = null;
$mime = null;
foreach ($mimeMap as $ext => $type_mime) {
    $candidate = $baseDir . $base . '.' . $ext;
    if (file_exists($candidate)) {
        $path = $candidate;
        $mime = $type_mime;
        break;
    }
}

if ($path === null) {
    http_response_code(404);
    exit;
}

header('Content-Type: ' . $mime);
header('Content-Length: ' . filesize($path));
readfile($path);
