<?php

require_once(__DIR__."/../../../includes/composer.php");
require_once(__DIR__."/../../../includes/keymgmt.php");

class EncryptedFile {

    private $filename;
    private $cipher_algo;

    function __construct($filename, $cipher_algo="RC4") {
        $this->filename = $filename;
        $this->cipher_algo = $cipher_algo;
    }

    public function decrypt($decryption_pvt_key, $b64_decryption_envelope_key, $destination_filename) {
        global $log;

        $decryption_envelope_key = base64_decode($b64_decryption_envelope_key);

        $keypath = KeyMgmt::pathToKey($decryption_pvt_key);
        $pvt_key = openssl_get_privatekey("file://$keypath");
        if ($pvt_key == false) {
            $log->error("Could not get private key $keypath: " . openssl_error_string());
            return false;
        }

        $encrypted_blob = file_get_contents($this->filename);
        $decrypted_blob = null;

        if (openssl_open($encrypted_blob, $decrypted_blob, $decryption_envelope_key, $pvt_key, $this->cipher_algo)) {
            $log->info("Decryption of ".$destination_filename . " succeeded!");
            file_put_contents($destination_filename, $decrypted_blob);
            return true;
        } else {
            $log->error("Could not decrypt " . $this->filename . ": " . openssl_error_string());
            return false;
        }
    }
}
