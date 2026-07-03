#!/usr/bin/env php
<?php


/***
 * 1. Load en.xml from htdocs/Language
 * 2. Load en_catalog.xml from htdocs/Language
 * 3. Merge en.xml from local/langdata_127
 * 4. Merge en_catalog.xml from local/langdata_127
 *
 */


$locale = "en"; //$argv[1];
$lab_id = 12; //$argv[2];

$basepath = realpath(__DIR__ . "/../");
$baselocale = "$basepath/htdocs/Language";
$locallocale = "$basepath/local/langdata_$lab_id";

$basefile = "$baselocale/$locale.xml";

// $reference = load_locale_file($basefile);
// $base = load_locale_file($basefile);

// $default_base = load_locale_file("$baselocale/default.xml");
// $default_ov = load_locale_file("$locallocale/default.xml");
// $ov = load_locale_file("$locallocale/$locale.xml");

$reference = load_legacy_php_locale(__DIR__."/default_lang.php");
$base = load_legacy_php_locale(__DIR__."/default_lang.php");
$ov = load_legacy_php_locale(__DIR__."/en_lang.php");

if (!$base || !$ov) {
    fwrite(STDERR, "Failed to load locales.\n");
    exit(1);
}

// squash_locales($base, $default_base);
// squash_locales($base, $default_ov);
squash_locales($base, $ov);
$diff = find_overrides($reference, $base);

echo(json_encode($diff)."\n");
fwrite(STDOUT, json_encode($diff) . "\n");

function load_legacy_php_locale(string $filename): array | false {
    if(!file_exists($filename)) {
        fwrite(STDERR, "File $filename does not exist.\n");
        return false;
    }

    $GLOBALS['LANG_ARRAY'] = null;

    global $LANG_ARRAY;

    include "$filename";

    if (!$GLOBALS['LANG_ARRAY']) {
        fwrite(STDERR, "Failed to load LANG_ARRAY from $filename\n");
        return false;
    }

    return $GLOBALS['LANG_ARRAY'];
}

/**
 * Returns a multilevel array keyed by page, then term
 */
function load_locale_file(string $filename) {
    $file = simplexml_load_file($filename);

    $locale = array();
    foreach($file as $page)
    {
        $pagename = strval($page['id']);

        $pageterms = array();
        foreach($page->term as $term) {
            $k = strval($term->key[0]);
            $v = strval($term->value[0]);

            $pageterms[$k] = $v;
        }

        $locale[$pagename] = $pageterms;
    }

    return $locale;
}

function squash_locales(array & $target, array $source) {
    foreach($source as $pagename => $pageterms) {
        if(!array_key_exists($pagename, $target)) {
            $target[$pagename] = $pageterms;
        } else {
            foreach($pageterms as $term => $val) {
                $target[$pagename][$term] = $val;
            }
        }
    }
}

function find_overrides(array $base, array $overrides) {
    $o = array();

    foreach($overrides as $pagename => $pageterms) {
        if(!array_key_exists($pagename, $base)) {
            $o[$pagename] = $pageterms;
        }
    }

    foreach($base as $pagename => $pageterms) {
        if(!array_key_exists($pagename, $overrides)) {
            continue;
        }

        foreach($pageterms as $term => $value) {
            if(!array_key_exists($term, $overrides[$pagename])) {
                continue;
            }

            if ($overrides[$pagename][$term] != $value) {
                if (!array_key_exists($pagename, $o)) {
                    $o[$pagename] = array();
                }
                $o[$pagename][$term] = $overrides[$pagename][$term];
            }
        }
    }

    return $o;
}
