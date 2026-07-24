<?php
#
# Updates language locale strings in [lang].xml and overwrites [lang].php
# Called via Ajax from lang_edit.php
#

include_once("redirect.php");
require_once("lang/lang_xml2php.php");
require_once(__DIR__."/../config/lab_config_resolver.php");

$lang_id = $_REQUEST['lang_id'];
$page_id = $_REQUEST['page_id'];
$lab_config_id = LabConfigResolver::resolveId();

$LANGDATA_PATH = __DIR__."/../../local";
if ($lab_config_id != null) {
    $LANGDATA_PATH = "$LANGDATA_PATH/langdata_$lab_config_id/";
} else {
    $LANGDATA_PATH = "$LANGDATA_PATH/langdata_revamp/";
}

$xml_file_name = $LANGDATA_PATH.$lang_id.".xml";

$language = LangUtil::load_locale_file(__DIR__."/../Language/$lang_id.xml");
$descriptions = LangUtil::load_page_descriptions(__DIR__."/../Language/$lang_id.xml");
$overrides = LangUtil::load_locale_file($xml_file_name);
$merged = LangUtil::merge_locales($language, $overrides);

foreach($_POST as $key => $value) {
    $merged[$page_id][$key] = trim($value);
}

$new_overrides = LangUtil::find_overrides($language, $merged);

$new_xml = new DOMDocument('1.0', 'UTF-8');
$new_xml->formatOutput = true;

$pages_el = $new_xml->createElement("pages");
$pages_el->setAttribute("lang", $lang_id);
$new_xml->appendChild($pages_el);

foreach($new_overrides as $pagename => $page) {
    $page_el = $new_xml->createElement("page");
    $page_el->setAttribute("id", $pagename);
    $page_el->setAttribute("descr", $descriptions[$pagename]);

    $sorted_terms = array_keys($page);
    sort($sorted_terms, SORT_STRING | SORT_FLAG_CASE);

    foreach($sorted_terms as $key) {
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
$new_xml->save($LANGDATA_PATH.$lang_id.'.xml');
?>
