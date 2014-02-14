<?php
#
# Updates language locale strings in [lang].xml and overwrites [lang].php
# Called via Ajax from lang_edit.php
#

include("redirect.php");
include("lang/lang_xml2php.php");

$lang_id = $_REQUEST['lang_id'];
$page_id = $_REQUEST['page_id'];
$lab_config_id = $_REQUEST['lab_config_id'];

$LANGDATA_PATH = $LOCAL_PATH."langdata_revamp/";;
if($SERVER == $ON_PORTABLE)
{
	$LANGDATA_PATH = $LOCAL_PATH."langdata_".$lab_config_id."/";;
}

$xml_file_name = $LANGDATA_PATH.$lang_id.".xml";
# Load XML document
$pages = new DOMDocument();
$pages->validateOnParse = true;
$pages->load($xml_file_name);
$xpath = new DOMXPath($pages);

# Get appropriate <page> element
# For each <term>, match by 'key' attrib and update the 'value' attribs
$keys = $xpath->query("page[@id='".$page_id."']/term/key");
$values = $xpath->query("page[@id='".$page_id."']/term/value");
$term_count = 0;
foreach($keys as $key)
{
	if(isset($_REQUEST[$key->nodeValue]))
	{
		$new_value = trim($_REQUEST[$key->nodeValue]);
		$old_value = $values->item($term_count)->nodeValue;
		echo $key->nodeValue.": ".$old_value." ".$new_value."<br>";
		if($new_value != $old_value && $new_value != "")
		{
			# If new value is not empty and not equal to existing value: Update
			$values->item($term_count)->nodeValue = htmlspecialchars($new_value);
		}
	}
	$term_count++;
}

# Store back updated XML into file
$pages->save($LANGDATA_PATH.$lang_id.'.xml');

# Convert updated XML to updated PHP file
lang_xml2php($lang_id, $LANGDATA_PATH);
?>