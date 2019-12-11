<?php
session_start();
$f_pvt="LAB_".$_SESSION['lab_config_id'].".blis";
$f_pub="LAB_".$_SESSION['lab_config_id']."_pubkey.blis";
if(!(file_exists($f_pvt)&&file_exists($f_pub)))
{
// Configuration for 4096 RSA key Pair with Digest Algo 512   
$config = array(  
"config" => str_replace("htdocs\\ajax","",getcwd())."server\php\extras\openssl\openssl.cnf",
  "digest_alg" => "sha512",  
  "private_key_bits" => 1024,  
  "private_key_type" => OPENSSL_KEYTYPE_RSA,  
);  
 
// Create the keypair  
$res=openssl_pkey_new($config);  
// Get private key  
openssl_pkey_export($res, $privkey,NULL,$config);  
//$privkey=openssl_pkey_export($res, $privkey,);  

// Get public key  
$pubkey=openssl_pkey_get_details($res);  
$pubkey=$pubkey["key"];  

$fp=fopen($f_pub,"w");
fwrite($fp,$pubkey);
fclose($fp);
$fp=fopen($f_pvt,"w");
fwrite($fp,$privkey);
fclose($fp);
}
    header('Content-Type: application/force-download');
    header("Content-Disposition: attachment; filename=\"" . basename("LAB_".$_SESSION['lab_config_id']."_pubkey.blis") . "\";");
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
   header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize("LAB_".$_SESSION['lab_config_id']."_pubkey.blis"));
   ob_clean();
    flush();
    readfile("LAB_".$_SESSION['lab_config_id']."_pubkey.blis");
    exit;
?>