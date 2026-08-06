<?php

# This class should NOT be required/included from ANYWHERE except
# lang_util.php. This is a hack to preserve backwards compatibility
# with the decisions to include() these files from the local/ .php files.

require_once(__DIR__ . "/../includes/composer.php");

class GeneralTermsShim implements ArrayAccess
{
    public function offsetSet($offset, $value): void
    {
        LangUtil::$pageTerms->offsetSet($offset, $value);
    }

    public function offsetUnset($offset): void
    {
        LangUtil::$pageTerms->offsetUnset($offset);
    }

    public function offsetExists($offset): bool
    {
        return LangUtil::$pageTerms->termExists("general", $offset);
    }

    public function offsetGet($offset)
    {
        return LangUtil::$pageTerms->getTerm("general", $offset);
    }
}

class Terms implements ArrayAccess
{
    private ?string $currentLocale = null;
    private ?string $currentPageId = null;

    private ?array $languageCache = null;

    private static string $baseLanguagePath = __DIR__."/../Language/";
    private static string $localDir = __DIR__."/../../local/";
    private static string $cachePath = __DIR__."/../../local/cache/";

    public function offsetSet($offset, $value): void
    {
        throw new Exception("Language terms may not be modified at runtime.");
    }

    public function offsetUnset($offset): void
    {
        throw new Exception("Language terms may not be modified at runtime.");
    }

    public function offsetExists($offset): bool
    {
        return $this->termExists($this->currentPageId, $offset);
    }

    public function termExists(string $pageName, string $term): bool
    {
        $this->EnsureCache();

        return $this->languageCache != null &&
            key_exists($pageName, $this->languageCache) &&
            key_exists($term, $this->languageCache[$pageName]);
    }

    public function offsetGet($offset)
    {
        $page = $this->currentPageId;
        if ($this->currentPageId == null) {
            $page = "general";
        }

        return $this->getTerm($page, $offset);
    }

    public function getTerm(string $pageName, string $term): string
    {
        $this->EnsureCache();

        $locale = $this->currentLocale;

        if (!key_exists($pageName, $this->languageCache)) {
            return "[MISSING PAGE: $locale:$pageName]";
        }

        $page = $this->languageCache[$pageName];

        if (!key_exists($term, $page)) {
            return "[MISSING TERM: $locale:$pageName:$term]";
        }

        return $page[$term];
    }

    public function SetPageId(string $pageId)
    {
        global $log;

        if ($this->currentLocale != null && $this->currentLocale != "") {
            if (!array_key_exists($pageId, $this->languageCache)) {
                $log->error("Language page does not exist in memory: $pageId (" . $this->currentLocale . ")");
            }
        }

        $this->currentPageId = $pageId;
    }

    private function TryLocaleValue(?string $value): bool
    {
        if ($value == null || $value == "") {
            return false;
        }

        if ($value == "default") {
            return false;
        }

        if (!file_exists(__DIR__ . "/../Language/$value.php")) {
            return false;
        }

        return true;
    }

    private function ResolveLocale(): string
    {
        if ($this->currentLocale != null) {
            return $this->currentLocale;
        }

        if ($this->TryLocaleValue($_SESSION['locale'])) {
            $this->currentLocale = $_SESSION['locale'];
            return $this->currentLocale;
        }

        if (array_key_exists("BLIS_DEFAULT_LOCALE", $_ENV) && $this->TryLocaleValue($_ENV['BLIS_DEFAULT_LOCALE'])) {
            $this->currentLocale = $_ENV['BLIS_DEFAULT_LOCALE'];
            return $this->currentLocale;
        }

        $this->currentLocale = "en";
        return $this->currentLocale;
    }

    function squash_locales(array &$target, array $source)
    {
        foreach ($source as $pagename => $pageterms) {
            if (!array_key_exists($pagename, $target)) {
                $target[$pagename] = $pageterms;
            } else {
                foreach ($pageterms as $term => $val) {
                    $target[$pagename][$term] = $val;
                }
            }
        }
    }

    private function RefreshCache()
    {
        global $log;

        if (!is_dir(Terms::$cachePath)) {
            mkdir(Terms::$cachePath);
        }

        // Reset current cache
        $this->languageCache = array();
        $locale = $this->ResolveLocale();

        // TODO: Fix this to resolve better...
        $lab_id = $_SESSION['lab_config_id'];
        if (!isset($lab_id) || $lab_id == "") {
            $lab_id = "revamp";
        }

        // $log->info("Locale resolved to $locale, lab ID: $lab_id");

        $baseLocale = Terms::$baseLanguagePath . "/$locale.xml";
        $cachedLocale = Terms::$cachePath . "/terms.$lab_id.$locale.php";
        $overrides = Terms::$localDir . "/langdata_$lab_id/$locale.xml";

        $regenerate = false;
        if (file_exists($cachedLocale)) {
            $base_ctime = filectime($baseLocale);
            $ovrrd_ctime = filectime($overrides);
            $cache_ctime = filectime($cachedLocale);

            // If the cache exists, but the base files have been modified since it was generated,
            // then regenerate it.
            if ($base_ctime > $cache_ctime || $ovrrd_ctime > $cache_ctime) {
                $regenerate = true;
            }
        } else {
            $regenerate = true;
        }

        if ($regenerate) {
            $log->info("Regenerating $cachedLocale...");

            $base_language = LangUtil::load_locale_file($baseLocale);
            $lab_language = LangUtil::load_locale_file($overrides);
            $this->squash_locales($base_language, $lab_language);

            LangUtil::lang2php($base_language, $cachedLocale);
        }

        // $log->info("Loading terms from: " . realpath($cachedLocale));
        $this->languageCache = require($cachedLocale);
    }

    private function EnsureCache()
    {
        $resolvedLocale = $this->ResolveLocale();
        if ($this->languageCache == null || count($this->languageCache) == 0 || $resolvedLocale != $this->currentLocale) {
            $this->RefreshCache();
        }
    }
}

class LangUtil
{
    public static string $pageId;

    public static Terms $pageTerms;
    public static GeneralTermsShim $generalTerms;

    public static function init()
    {
        self::$pageTerms = new Terms();
        self::$generalTerms = new GeneralTermsShim();
    }

    public static function setPageId(string $page_id)
    {
        self::$pageTerms->SetPageId($page_id);
    }

    public static function getGeneralTerm(string $key)
    {
        # Returns general term string
        return self::$generalTerms[$key];
    }

    public static function getPageTitle(string $page_id)
    {
        return self::$pageTerms->getTerm($page_id, "TITLE");
    }

    public static function getTitle()
    {
        $retval = self::$pageTerms["TITLE"];
        if ($retval == null) {
            $retval = "[ERROR]";
        }
        return $retval;
    }

    public static function getPageTerm($key)
    {
        return self::$pageTerms[$key];
    }

    public static function getTerm(string $pageName, string $term)
    {
        return self::$pageTerms->getTerm($pageName, $term);
    }

    # Fetching test catalog related terms
    public static function getTestName($test_type_id)
    {
        global $CATALOG_ARRAY;
        if (isset($CATALOG_ARRAY["test"][$test_type_id])) {
            return $CATALOG_ARRAY["test"][$test_type_id];
        }
        return "[ERROR]";
    }

    public static function getLabSectionName($test_category_id)
    {
        global $CATALOG_ARRAY;
        if (isset($CATALOG_ARRAY["section"][$test_category_id])) {
            return $CATALOG_ARRAY["section"][$test_category_id];
        }
        return "[ERROR]";
    }

    public static function getMeasureName($measure_id)
    {
        global $CATALOG_ARRAY;
        if (isset($CATALOG_ARRAY["measure"][$measure_id])) {
            return $CATALOG_ARRAY["measure"][$measure_id];
        }
        return "[ERROR]";
    }

    public static function getSpecimenName($specimen_type_id)
    {
        global $CATALOG_ARRAY;
        if (isset($CATALOG_ARRAY["specimen"][$specimen_type_id])) {
            return $CATALOG_ARRAY["specimen"][$specimen_type_id];
        }
        return "[ERROR]";
    }

    public static function getSearchCondition($condition)
    {
        global $LANG_ARRAY;
        $retval = $LANG_ARRAY["search_condition"][$condition];
        if ($retval == null) {
            $retval = "[ERROR]";
        }
        return $retval;
    }

    /**
     * Returns a multilevel locale array.
     */
    public static function load_legacy_php_locale(string $filename): ?array
    {
        global $log;

        if (!file_exists($filename)) {
            $log->error("File $filename does not exist.");
            return null;
        }

        $GLOBALS['LANG_ARRAY'] = null;
        global $LANG_ARRAY;

        /**
         * Inherently unsafe code: if the language file has been modified to include dangerous code,
         * it will be executed here.
         * This should be replaced with a new format for language loading...
         */
        include "$filename";

        if (!$GLOBALS['LANG_ARRAY']) {
            $log->error("Failed to load LANG_ARRAY from $filename\n");
            return null;
        }

        return $GLOBALS['LANG_ARRAY'];
    }

    /**
     * Returns a multilevel array keyed by page, then term
     */
    public static function load_locale_file(string $filename)
    {
        if (!file_exists($filename)) {
            return array();
        }

        $file = simplexml_load_file($filename);

        $locale = array();
        foreach ($file as $page) {
            $pagename = strval($page['id']);

            $pageterms = array();
            foreach ($page->term as $term) {
                $k = strval($term->key[0]);
                $v = strval($term->value[0]);

                $pageterms[$k] = $v;
            }

            $locale[$pagename] = $pageterms;
        }

        return $locale;
    }

    public static function load_page_descriptions(string $filename)
    {
        $file = simplexml_load_file($filename);

        $descriptions = array();
        foreach ($file as $page) {
            $pagename = strval($page['id']);
            $descr = strval($page['descr']);
            $descriptions[$pagename] = $descr;
        }

        return $descriptions;
    }

    public static function merge_locales(array $base, array $source): array
    {
        foreach ($source as $pagename => $pageterms) {
            if (!array_key_exists($pagename, $base)) {
                $base[$pagename] = $pageterms;
            } else {
                foreach ($pageterms as $term => $val) {
                    $base[$pagename][$term] = $val;
                }
            }
        }

        return $base;
    }

    public static function find_overrides(array $base, array $overrides)
    {
        $o = array();

        foreach ($overrides as $pagename => $pageterms) {
            if (!array_key_exists($pagename, $base)) {
                $o[$pagename] = $pageterms;
            }
        }

        foreach ($base as $pagename => $pageterms) {
            if (!array_key_exists($pagename, $overrides)) {
                continue;
            }

            foreach ($pageterms as $term => $value) {
                if (!array_key_exists($term, $overrides[$pagename])) {
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

    /**
     * Save an in-memory language array to PHP
     */
    public static function lang2php(array $pages, string $target_file)
    {
        global $log;

        $log->info("Saving updated language to $target_file");

        $handle = fopen($target_file, "w");
        $string_data = <<<EOF
    <?php
    \$LANG_ARRAY = array (

    EOF;
        fwrite($handle, $string_data);

        $page_count = 0;
        foreach ($pages as $pagename => $page) {
            $page_count++;
            $string_data = '"' . $pagename . '" => array ( ';
            fwrite($handle, "\t" . $string_data . "\n");

            $sorted_terms = array_keys($page);
            sort($sorted_terms, SORT_STRING | SORT_FLAG_CASE);

            $term_count = 0;
            foreach ($sorted_terms as $key) {
                $value = $page[$key];
                $term_count++;
                $string_data = "\"$key\" => \"$value\"";
                if ($term_count != count($page)) {
                    $string_data .= ", ";
                }
                fwrite($handle, "\t\t" . $string_data . "\n");
            }

            $string_data = ") ";
            fwrite($handle, "\t" . $string_data);
            if ($page_count < count($pages)) {
                $string_data = ", ";
                fwrite($handle, $string_data . "\n");
            }
        }

        $string_data = <<<EOF
    );

    return \$LANG_ARRAY;
    EOF;
        fwrite($handle, "\n" . $string_data);
        fclose($handle);
    }
}
