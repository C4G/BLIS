#!/usr/bin/env php

<?php

if ($argc < 2) {
    echo("You must supply the locale name you want to perform an XML-from-PHP update on.\n");
    die(1);
}

$locale = $argv[1];
$xml_path = realpath($locale.".xml");
$info = pathinfo($xml_path);
$dirname = $info['dirname'];
$php_path = "$locale.php";

if (!file_exists($xml_path)) {
    die("File does not exist: " . $xml_path . "\n");
}

if (!file_exists($php_path)) {
    die("File does not exist: " . $php_path . "\n");
}

echo("XML File: $xml_path\n");
echo("PHP File: $php_path\n");
echo("require_once(\"$php_path\");\n");
require_once($php_path);
echo("\n");

$pages = simplexml_load_file($xml_path);

$langdata_pages = array_keys($LANG_ARRAY);
foreach($langdata_pages as $page) {
    $xml_page = $pages->xpath("page[@id='$page']");
    if (!$xml_page) {
        echo("Page $page not found in XML file.\n");
        $new_page = $pages->addChild('page');
        $new_page->addAttribute('id', $page);
    }
}

foreach($pages as $page)
{
    $page_id = $page['id']->__toString();
    echo("Processing page: $page_id\n");
    $langdata_page = $LANG_ARRAY[$page_id];

    $page_terms = $page->term;
    $xmlterms = array();
    foreach($page_terms as $term)
    {
        $str_key = $term->key->__toString();
        $xmlterms[$str_key] = $term->value;
    }

    foreach($langdata_page as $php_term_key => $php_term_value) {
        if (!array_key_exists($php_term_key, $xmlterms)) {
            echo("Adding term: $php_term_key to $locale.xml\n");
            $term = $page->addChild('term');
            $key = $term->addChild('key');
            $key[0] = $php_term_key;
            $val = $term->addChild('value');
            $val[0] = $php_term_value;
        }
    }
}

echo ("\nWriting $xml_path\n");
file_put_contents($xml_path, $pages->asXML());
