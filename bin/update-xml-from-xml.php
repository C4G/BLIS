#!/usr/bin/env php

<?php

if ($argc < 3) {
    echo("You must supply the locale name you want to perform a 2-way update on.\n");
    die(1);
}

$xml_to_update = $argv[1];
$source_xml = $argv[2];

if (!file_exists($xml_to_update)) {
    die("File does not exist: " . $xml_to_update . "\n");
}

if (!file_exists($source_xml)) {
    die("File does not exist: " . $source_xml . "\n");
}

echo("XML file to update: $xml_to_update\n");
echo("    XML for source: $source_xml\n");

echo("Press Ctrl-C to stop, or press Enter to continue...\n");

$stdin = fopen('php://stdin', 'r');
fgets($stdin, 2);
fclose($stdin);

$h_xml_update = simplexml_load_file($xml_to_update);
$h_xml_source = simplexml_load_file($source_xml);

foreach($h_xml_source as $page)
{
    $page_id = $page['id']->__toString();

    $h_update_page = $h_xml_update->xpath("page[@id='$page_id']");
    if (!$h_update_page) {
        echo("Adding page: $page_id\n");
        $h_update_page = $h_xml_update->addChild('page');
        $h_update_page->addAttribute('id', $page_id);
    } else {
        $h_update_page = $h_update_page[0];
    }

    foreach($page->term as $term) {
        $source_term_key = $term->key;
        $source_term_val = $term->value;
        $update_term_key = $h_update_page->xpath("term/key[text()=\"$source_term_key\"]");
        if (!$update_term_key) {
            echo("Adding term: $page_id/$source_term_key\n");
            $term = $h_update_page[0]->addChild('term');
            $key = $term->addChild('key');
            $key[0] = $source_term_key;
            $val = $term->addChild('value');
            $val[0] = $source_term_val;
        } else {
            $update_term_key = $update_term_key[0];
            $update_term_val = $update_term_key->xpath("parent::term/value")[0];
            if ($update_term_val->__toString() != $source_term_val->__toString()) {
                echo("Updating term: $page_id/$update_term_key\n");
                $update_term_val[0] = $source_term_val->__toString();
            } else {
                // echo("No update: $page_id/$source_term_key\n");
            }
        }
    }
}

echo("Writing updated XML file: $xml_to_update\n");
file_put_contents($xml_to_update, $h_xml_update->asXML());
