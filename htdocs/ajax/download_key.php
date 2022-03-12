<?php
require_once("../includes/platform_lib.php");

session_start();

if ($_GET["role"]==="dir") {
    $f_pvt="LAB_dir.blis";
    $f_pub="LAB_dir_pubkey.blis";
} else {
    $f_pvt="LAB_".$_SESSION['lab_config_id'].".blis";
    $f_pub="LAB_".$_SESSION['lab_config_id']."_pubkey.blis";
}
if (!(file_exists($f_pvt)&&file_exists($f_pub))) {

  // Configuration for 4096 RSA key Pair with Digest Algo 512
    $config = array(
      "digest_alg" => "sha512",
      "private_key_bits" => 1024,
      "private_key_type" => OPENSSL_KEYTYPE_RSA,
    );

    if (PlatformLib::runningOnWindows()) {
        $openssl_conf_location = dirname(__FILE__).'/../../server/php/extras/openssl/openssl.cnf';
        $config["config"] = $openssl_conf_location;
    }

    // Create the keypair
    $res=openssl_pkey_new($config);
    // Get private key
    openssl_pkey_export($res, $privkey, null, $config);
    //$privkey=openssl_pkey_export($res, $privkey,);

    // Get public key
    $pubkey=openssl_pkey_get_details($res);
    $pubkey=$pubkey["key"];

    $fp=fopen($f_pub, "w");
    fwrite($fp, $pubkey);
    fclose($fp);
    $fp=fopen($f_pvt, "w");
    fwrite($fp, $privkey);
    fclose($fp);
}

header('Content-Type: application/force-download');
header("Content-Disposition: attachment; filename=\"" . basename($f_pub) . "\";");
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize(
    $f_pub
));
ob_clean();
flush();
readfile($f_pub);
exit;
