<?php
#
# Updates test catalog locale strings in [lang]_catalog.xml and overwrites [lang]_catalog.php
# Called via Ajax from lang_edit.php
#

include("redirect.php");
include("includes/db_constants.php");
include("lang/lang_xml2php.php");

$lang_id = $_REQUEST['lang_id'];
$page_id = $_REQUEST['page_id'];

# Refresh entries from DB into xml
catalog_db2xml($lang_id);

$LANGDATA_PATH = "../../langdata/";
if($SERVER == $ON_ARC)
{
	$LANGDATA_PATH = "../langdata/";
}
$xml_file_name = $LANGDATA_PATH.$lang_id."_catalog.xml";

# Load XML document
$pages = new DOMDocument();
$pages->validateOnParse = true;
$pages->load($xml_file_name);
$xpath = new DOMXPath($pages);

# Get appropriate <entity> element
# For each <term>, match by 'key' attrib and update the 'value' attribs
$keys = $xpath->query("entity[@id='".$page_id."']/term/key");
$values = $xpath->query("entity[@id='".$page_id."']/term/value");
$term_count = 0;
foreach($keys as $key)
{
	if(isset($_REQUEST[$key->nodeValue]))
	{
		$new_value = trim($_REQUEST[$key->nodeValue]);
		$old_value = $values->item($term_count)->nodeValue;
		//if($new_value != $old_value && $new_value != "")
		if($new_value != "")
		{
			# If new value is not empty and not equal to existing value: Update
			$values->item($term_count)->nodeValue = $new_value;
		}
	}
	$term_count++;
}

# Store back updated XML into file
$pages->save($LANGDATA_PATH.$lang_id.'_catalog.xml');

# Convert updated XML to updated PHP file
catalog_xml2php($lang_id);
?>