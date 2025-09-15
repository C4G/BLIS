<?php

require_once(__DIR__."/../includes/composer.php");

class Encryption
{
    /**
     * Asymmetrically encrypt a file with a given public key.
     * @param $inputFile: String path to the file to encrypt.
     * @param $outputFile: String path to write the encrypted file.
     * @param $keyfile: Path to the public key file.
     */
    public static function encryptFile($inputFile, $outputFile, $keyfile)
    {
        global $log;

        $keycontents = file_get_contents($keyfile);
        $pubkey = base64_decode($keycontents);
        sodium_memzero($keycontents);

        $data = file_get_contents($inputFile);

        try {
            $res = sodium_crypto_box_seal($data, $pubkey);
            file_put_contents($outputFile, $res);
            sodium_memzero($res);
        } catch (Exception $ex) {
            $log->error($ex);
        }

        sodium_memzero($pubkey);
    }

    /**
     * Asymmetrically decrypt a file with a given keypair (private key).
     * @param $inputFile: String path to the file to decrypt.
     * @param $outputFile: String path to write the decrypted file.
     * @param $keyfile: Path to the private key file.
     */
    public static function decryptFile($inputFile, $outputFile, $keyfile)
    {
        global $log;

        $keycontents = file_get_contents($keyfile);
        $keypair = base64_decode($keycontents);
        sodium_memzero($keycontents);

        $data = file_get_contents($inputFile);

        try {
            $res = sodium_crypto_box_seal_open($data, $keypair);
            file_put_contents($outputFile, $res);
            sodium_memzero($res);
        } catch (Exception $ex) {
            $log->error($ex);
        }

        sodium_memzero($keypair);
    }
}
