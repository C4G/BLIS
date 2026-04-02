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

$path = null;
$mime = null;
foreach (glob($baseDir . $base . '.*') ?: [] as $candidate) {
    $detected = mime_content_type($candidate);
    if (str_starts_with($detected, 'image/')) {
        $path = $candidate;
        $mime = $detected;
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
