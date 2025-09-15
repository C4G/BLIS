#!/usr/bin/env php
<?php

require_once(__DIR__."/../htdocs/encryption/encryption.php");

if ($argc < 2) {
    echo("You must specify at least \"encrypt\" or \"decrypt\".\n");
    die(1);
}

$mode = strtolower($argv[1]);

if ($mode == "encrypt") {
    $input = $argv[2];
    $output = $argv[3];
    $keyfile = $argv[4];

    $result = Encryption::encryptFile($input, $output, $keyfile);

    if ($result) {
        $log->info("Encryption succeeded.");
    }
}

if ($mode == "decrypt") {
    $input = $argv[2];
    $output = $argv[3];
    $keyfile = $argv[4];

    $result = Encryption::decryptFile($input, $output, $keyfile);

    if ($result) {
        $log->info("Decryption succeeded.");
    }
}

if ($mode == "gen") {
    $filename = $argv[2];

    $key = sodium_crypto_box_keypair();
    file_put_contents($filename, base64_encode($key));

    $pubkey = sodium_crypto_box_publickey($key);
    file_put_contents($filename . ".pub", base64_encode($pubkey));
}
