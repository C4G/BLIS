<?php
require_once("../includes/keymgmt.php");
require_once("../includes/composer.php");
require_once("../includes/platform_lib.php");

session_start();

$basedir = __DIR__."/../../files";

if ($_GET["role"]==="dir") {
    $f_pvt="$basedir/LAB_dir.blis";
    $f_pub="$basedir/LAB_dir_pubkey.blis";
} else {
    $lab_id = $_REQUEST["id"];
    if (strlen($lab_id) == 0) {
        $lab_id = $_SESSION['lab_config_id'];
    }

    $f_pvt="$basedir/LAB_".$lab_id.".blis";
    $f_pub="$basedir/LAB_".$lab_id."_pubkey.blis";
}


if (!file_exists($f_pvt) || !file_exists($f_pub)) {
    // generate key
    KeyMgmt::generateKeyPair($f_pvt, $f_pub);
    $log->info("Keypair generated successfully.");
}

header('Content-Type: application/force-download');
header("Content-Disposition: attachment; filename=\"" .basename($f_pub) . "\";");
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($f_pub));
ob_clean();
flush();
readfile($f_pub);
exit;
