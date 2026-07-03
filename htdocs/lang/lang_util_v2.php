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
        if($this->currentPageId == null) {
            $page = "general";
        }

        return $this->getTerm($page, $offset);
    }

    public function getTerm(string $pageName, string $term): string {
        $this->EnsureCache();

        global $log;
        $log->info("getTerm: $pageName, $term");

        $locale = $this->currentLocale;

        if(!key_exists($pageName, $this->languageCache)) {
            return "[MISSING PAGE: $locale:$pageName]";
        }

        $page = $this->languageCache[$pageName];

        if(!key_exists($term, $page)) {
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

        $log->info("Set page ID to: " . $this->currentPageId);
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

    private function load_legacy_php_locale(string $filename): ?array
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

        // Reset current cache
        $this->languageCache = array();
        $locale = $this->ResolveLocale();
        $log->info("Locale resolved to $locale");

        $base_language = $this->load_legacy_php_locale(__DIR__ . "/../Language/$locale.php");
        if (!$base_language) {
            $log->error("Failed to load base language files from htdocs/Language/$locale.php");
            return;
        }
        $log->info("Loaded base file: $locale.php");

        // TODO: Fix this to resolve better...
        $lab_id = $_SESSION['lab_config_id'];
        if ($lab_id) {
            $lab_language = $this->load_legacy_php_locale(__DIR__ . "/../../local/langdata_$lab_id/$locale.php");
            if (!$lab_language) {
                $log->warn("Failed to load language files from local/langdata_$lab_id/$locale.php");
            } else {
                $log->info("Loaded lab file: local/langdata_$lab_id/$locale.php");
                $this->squash_locales($base_language, $lab_language);
            }
        }

        $this->languageCache = $base_language;
    }

    private function EnsureCache()
    {
        if ($this->languageCache == null || count($this->languageCache) == 0) {
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

    public static function getTerm(string $pageName, string $term) {
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
}
