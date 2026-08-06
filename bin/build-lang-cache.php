#!/usr/bin/env php
<?php

/***
 * Migration test script
 * This is a work in progress, POC script detailing how a migration of the "local/langdata_" folders
 * could be migrated to a minimal number of .xml files.
 */

$local_dir = $argv[1];

$basepath = realpath(__DIR__ . "/../");
$baselocale = "$basepath/htdocs/Language";
$locallocale = "$basepath/$local_dir";

require_once("$basepath/htdocs/lang/lang_util_v2.php");

// Step 1: English

$base_en = LangUtil::load_locale_file("$baselocale/en.xml");
$descriptions = LangUtil::load_page_descriptions("$baselocale/en.xml");

$local_en_1 = LangUtil::load_locale_file("$locallocale/en.xml");
$ovr_en_1 = LangUtil::find_overrides($base_en, $local_en_1);

$local_en_2 = LangUtil::load_legacy_php_locale("$locallocale/en.php");
$ovr_en_2 = LangUtil::find_overrides($base_en, $local_en_2);

$local_def_1 = LangUtil::load_locale_file("$locallocale/default.xml");
$ovr_def_1 = LangUtil::find_overrides($base_en, $local_def_1);

$local_def_2 = LangUtil::load_legacy_php_locale("$locallocale/default.php");
$ovr_def_2 = LangUtil::find_overrides($base_en, $local_def_2);

$merged = LangUtil::merge_locales($base_en, $ovr_en_1);
$merged = LangUtil::merge_locales($merged, $ovr_en_2);
$merged = LangUtil::merge_locales($merged, $ovr_def_1);
$merged = LangUtil::merge_locales($merged, $ovr_def_2);

$new_overrides = LangUtil::find_overrides($base_en, $merged);

write_xml($new_overrides, $descriptions, __DIR__."/en.xml");

// Step 2: French

$base_fr = LangUtil::load_locale_file("$baselocale/fr.xml");
$descriptions = LangUtil::load_page_descriptions("$baselocale/fr.xml");

$local_fr_1 = LangUtil::load_locale_file("$locallocale/fr.xml");
$ovr_fr_1 = LangUtil::find_overrides($base_fr, $local_fr_1);

$local_fr_2 = LangUtil::load_legacy_php_locale("$locallocale/fr.php");
$ovr_fr_2 = LangUtil::find_overrides($base_fr, $local_fr_2);

$merged = LangUtil::merge_locales($base_fr, $ovr_fr_1);
$merged = LangUtil::merge_locales($merged, $ovr_fr_2);

$new_overrides = LangUtil::find_overrides($base_fr, $merged);

write_xml($new_overrides, $descriptions, __DIR__."/fr.xml");

function write_xml(array $pages, array $descriptions, string $filename)
{
    $new_xml = new DOMDocument('1.0', 'UTF-8');
    $new_xml->formatOutput = true;

    $pages_el = $new_xml->createElement("pages");
    $pages_el->setAttribute("lang", "en");
    $new_xml->appendChild($pages_el);

    foreach ($pages as $pagename => $page) {
        $page_el = $new_xml->createElement("page");
        $page_el->setAttribute("id", $pagename);
        $page_el->setAttribute("descr", $descriptions[$pagename]);

        $sorted_terms = array_keys($page);
        sort($sorted_terms, SORT_STRING | SORT_FLAG_CASE);

        foreach ($sorted_terms as $key) {
            $value = $page[$key];

            $term_el = $new_xml->createElement("term");
            $key_el = $new_xml->createElement("key", $key);
            $val_el = $new_xml->createElement("value", $value);
            $term_el->appendChild($key_el);
            $term_el->appendChild($val_el);
            $page_el->appendChild($term_el);
        }
        $pages_el->appendChild($page_el);
    }

    # Store back updated XML into file (only the changed terms)
    $new_xml->save($filename);
}
