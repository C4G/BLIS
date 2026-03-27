<?php
#
# Serves lab logo images from STORAGE_DIR/logos/.
# Accepts:
#   ?id=<lab_config_id>            → logo_<id>.jpg
#   ?id=<lab_config_id>&type=billing → logo_billing_<id>.jpg
#

include("includes/SessionCheck.php");
include("includes/db_lib.php");

$id   = (int)($_GET['id'] ?? 0);
$type = ($_GET['type'] ?? '') === 'billing' ? 'billing' : '';

if ($id <= 0) {
    http_response_code(404);
    exit;
}

$filename = $type ? "logo_{$type}_{$id}.jpg" : "logo_{$id}.jpg";
$path     = $STORAGE_DIR . "/logos/" . $filename;

if (!file_exists($path)) {
    http_response_code(404);
    exit;
}

header('Content-Type: image/jpeg');
header('Content-Length: ' . filesize($path));
readfile($path);
