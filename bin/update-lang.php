#!/usr/bin/env php

<?php

require_once(__DIR__."/../htdocs/lang/lang_xml2php.php");

if ($argc < 2) {
    echo("You must supply the path to an XML file to generate the PHP language file for.\n");
    die(1);
}

if (!file_exists($argv[1])) {
    die("File does not exist: " . $argv[1] . "\n");
}

$xml_path = realpath($argv[1]);
$info = pathinfo($xml_path);
$locale = $info['filename'];
$dirname = $info['dirname'];

$php_path = "$dirname/$locale.php";

echo("Generating PHP file: $php_path\n");
echo("From XML file:       $xml_path\n");

echo("Calling: lang_xml2php(\"$locale\", \"$dirname/\")\n");
lang_xml2php($locale, "$dirname/");

echo("Calling: require_once(\"$php_path\") to ensure valid PHP syntax...\n");
require_once($php_path);
