<?php
require_once("../includes/keymgmt.php");
require_once("../includes/composer.php");
require_once("../includes/platform_lib.php");

session_start();

$basedir = dirname(__FILE__)."/../../files";

if ($_GET["role"]==="dir") {
    $f_pvt="$basedir/LAB_dir.blis";
    $f_pub="$basedir/LAB_dir_pubkey.blis";
} else {
    $f_pvt="$basedir/LAB_".$_SESSION['lab_config_id'].".blis";
    $f_pub="$basedir/LAB_".$_SESSION['lab_config_id']."_pubkey.blis";
}


if (!file_exists($f_pvt) || !file_exists($f_pub)) {
    // generate key
    KeyMgmt::generateKeyPair($f_pvt, $f_pub);
    $log->info("Keypair generated successfully.");
}

header('Content-Type: application/force-download');
header("Content-Disposition: attachment; filename=\"" . basename($f_pub) . "\";");
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($f_pub));
ob_clean();
flush();
readfile($f_pub);
exit;
