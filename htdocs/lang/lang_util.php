<?php
#
# LangUtil class which fetches locale string from appropriate file
#

class LangUtil
{
	public static $generalPageId = "general";
	public static $pageId;
	public static $generalTerms;
	public static $pageTerms;
	
	public static function init()
	{
		global $LANG_ARRAY;
		self::$generalTerms = $LANG_ARRAY[self::$generalPageId];
	}
	
	public static function setPageId($page_id)
	{
		global $LANG_ARRAY;
		self::$pageId = $page_id;
		self::$pageTerms = $LANG_ARRAY[self::$pageId];
	}
	
	public static function getGeneralTerm($key)
	{
		# Returns general term string
		$retval = self::$generalTerms[$key];
		if($retval == null)
		{
			$retval = "[ERROR]";
		}
		return $retval;
	}
	
	public static function getPageTitle($page_id)
	{
		global $LANG_ARRAY;
		$retval = $LANG_ARRAY[$page_id]["TITLE"];
		if($retval == null)
		{
			$retval = "[ERROR]";
		}
		return $retval;
	}
	public static function getStockTerm($key)
	{
		global $LANG_ARRAY;
		$retval = $LANG_ARRAY['stocks'][$key];
		if($retval == null)
		{
			$retval = "[ERROR]";
		}
	return $retval;
		}
	
	public static function getTitle()
	{
		$retval = self::$pageTerms["TITLE"];
		if($retval == null)
		{
			$retval = "[ERROR]";
		}
		return $retval;
	}
	
	public static function getPageTerm($key)
	{
		# Returns page specific term string			
		$retval = self::$pageTerms[$key];
		if($retval == null)
		{
			$retval = "[ERROR]";
		}
		return $retval;
	}
	
	
	# Fetching test catalog related terms
	public static function getTestName($test_type_id)
	{
		global $CATALOG_ARRAY;
		if(isset($CATALOG_ARRAY["test"][$test_type_id]))
		{
			return $CATALOG_ARRAY["test"][$test_type_id];
		}
		return "[ERROR]";
	}
	
	public static function getLabSectionName($test_category_id)
	{
		global $CATALOG_ARRAY;
		if(isset($CATALOG_ARRAY["section"][$test_category_id]))
		{
			return $CATALOG_ARRAY["section"][$test_category_id];
		}
		return "[ERROR]";
	}
	
	public static function getMeasureName($measure_id)
	{
		global $CATALOG_ARRAY;
		if(isset($CATALOG_ARRAY["measure"][$measure_id]))
		{
			return $CATALOG_ARRAY["measure"][$measure_id];
		}
		return "[ERROR]";
	}
	
	public static function getSpecimenName($specimen_type_id)
	{
		global $CATALOG_ARRAY;
		if(isset($CATALOG_ARRAY["specimen"][$specimen_type_id]))
		{
			return $CATALOG_ARRAY["specimen"][$specimen_type_id];
		}
		return "[ERROR]";
	}
	
	public static function getMeasureRemarks($lab_config_id, $measure_id)
	{
		# Fetches existing result interpretation (remarks) strings
		global $REMARKS_ARRAY;
		$retval = null;
		if(isset($REMARKS_ARRAY[$measure_id]))
			$retval = $REMARKS_ARRAY[$measure_id];
		return $retval;
	}
	public static function getSearchCondition($condition)
	{
		global $LANG_ARRAY;
		$retval = $LANG_ARRAY["search_condition"][$condition];		
		if($retval == null)
		{
			$retval = "[ERROR]";
		}
		return $retval;
	}
}

LangUtil::init();
?>