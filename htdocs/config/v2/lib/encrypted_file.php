<?php

require_once(__DIR__."/../../../includes/composer.php");
require_once(__DIR__."/../../../includes/keymgmt.php");

class EncryptedFile {

    private $filename;
    private $decryption_pvt_key;
    private $decryption_envelope_key;

    private $cipher_algo;
    private $iv;

    function __construct($filename, $decryption_pvt_key, $decryption_envelope_key, $cipher_algo="AES256") {
        $this->filename = $filename;
        $this->decryption_pvt_key = $decryption_pvt_key;
        $this->decryption_envelope_key = $decryption_envelope_key;

        $this->cipher_algo = $cipher_algo;
        $oiv = openssl_cipher_iv_length($cipher_algo);
        if ($oiv != false) {
            $this->iv = $oiv;
        }
    }

    public function decrypt($destination_filename) {
        global $log;

        $keypath = KeyMgmt::pathToKey($this->decryption_pvt_key);
        $pvt_key = openssl_get_privatekey("file://$keypath");
        if ($pvt_key == false) {
            $log->error("Could not get private key $keypath: " . openssl_error_string());
            return false;
        }

        $encrypted_blob = file_get_contents($this->filename);
        $log->warn(base64_encode($encrypted_blob));
        $decrypted_blob = null;

        if (openssl_open($encrypted_blob, $decrypted_blob, $this->decryption_envelope_key, $pvt_key, $this->cipher_algo, $this->iv)) {
            $log->info("Decryption of ".$this->filename . " succeeded!");
            file_put_contents($destination_filename, $decrypted_blob);
        } else {
            $log->error("Could not decrypt " . $this->filename . ": " . openssl_error_string());
        }
    }
}
