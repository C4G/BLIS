<?php
#
# Converts [lang].xml file to corresponding [lang].php
# XML tags are mapped to a PHP associative list
#


require_once("../includes/db_lib.php");

#
# Functions for handling language translation
#

function lang_xml2php($lang_code, $langdata_path)
{
	$handle = fopen($langdata_path.$lang_code.".php", "w");
	$string_data = <<<EOF
<?php
\$LANG_ARRAY = array ( 
	
EOF;
	fwrite($handle, $string_data);

	$pages = simplexml_load_file($langdata_path.$lang_code.".xml");
	
	$page_count = 0;
	foreach($pages as $page)
	{
		$page_count++;
		$string_data = '"'.$page['id'].'" => array ( ';
		fwrite($handle, "\t".$string_data."\n");
		$terms = $page->term;
		$term_count = 0;
		foreach($terms as $term)
		{
			$term_count++;
			$string_data = "\"".$term->key."\" => \"".$term->value."\"";
			if($term_count != count($terms))
			{
				$string_data .= ", ";
			}
			fwrite($handle, "\t\t".$string_data."\n");
		}
		
		$string_data = ") ";
		fwrite($handle, "\t".$string_data);
		if($page_count < count($pages))
		{
			$string_data = ", ";
			fwrite($handle, $string_data."\n");
		}
	}
	$string_data = <<<EOF
);

include("../lang/lang_util.php");
?>
EOF;
	fwrite($handle, "\n".$string_data);
	fclose($handle);
}

#
# Functions for handling test catalog translation
#

function catalog_db2xml($lang_id="default")
{
	# Start catalog
	$string_data = <<<EOF
<?xml version="1.0"?>
<catalog lang="$lang_id" descr=''>
	<entity id="section" descr="Lab Section">
EOF;
	$handle = fopen("../../langdata/".$lang_id."_catalog.xml", "w");
	fwrite($handle, $string_data);
	$query_string = "SELECT * FROM test_category";
	$resultset = query_associative_all($query_string, $row_count);
	foreach($resultset as $record)
	{
		$key = $record['test_category_id'];
		$value = $record['name'];
		$string_data = <<<EOF
		
		<term>
			<key>$key</key>
			<value>$value</value>
		</term>
EOF;
		fwrite($handle, $string_data);
	}
	$string_data = <<<EOF
	
	</entity>
EOF;
	fwrite($handle, $string_data);	
	# Add test types
	$string_data = <<<EOF
	
	<entity id="test" descr="Test Type">
EOF;
	fwrite($handle, $string_data);
	$query_string = "SELECT * FROM test_type WHERE disabled=0";
	$resultset = query_associative_all($query_string, $row_count);
	foreach($resultset as $record)
	{
		$key = $record['test_type_id'];
		$value = $record['name'];
		$string_data = <<<EOF
		
		<term>
			<key>$key</key>
			<value>$value</value>
		</term>
EOF;
		fwrite($handle, $string_data);
	}
	$string_data = <<<EOF
	
	</entity>
EOF;
	fwrite($handle, $string_data);	
	# Add measures
	$string_data = <<<EOF
	
	<entity id="measure" descr="Measures">
EOF;
	fwrite($handle, $string_data);
	$query_string = "SELECT * FROM measure";
	$resultset = query_associative_all($query_string, $row_count);
	foreach($resultset as $record)
	{
		$key = $record['measure_id'];
		$value = $record['name'];
		$string_data = <<<EOF
		
		<term>
			<key>$key</key>
			<value>$value</value>
		</term>
EOF;
		fwrite($handle, $string_data);
	}
	$string_data = <<<EOF
	
	</entity>
EOF;
	fwrite($handle, $string_data);	
	# Add specimen types
	$string_data = <<<EOF
	
	<entity id="specimen" descr="Specimen Types">
EOF;
	fwrite($handle, $string_data);
	$query_string = "SELECT * FROM specimen_type WHERE disabled=0";
	$resultset = query_associative_all($query_string, $row_count);
	foreach($resultset as $record)
	{
		$key = $record['specimen_type_id'];
		$value = $record['name'];
		$string_data = <<<EOF
		
		<term>
			<key>$key</key>
			<value>$value</value>
		</term>
EOF;
		fwrite($handle, $string_data);
	}
	$string_data = <<<EOF
	
	</entity>
EOF;
	fwrite($handle, $string_data);	
	# End catalog
	$string_data = <<<EOF
	
</catalog>
EOF;
	fwrite($handle, $string_data);
	fclose($handle);
}

function catalog_xml2php($lang_code)
{
	$handle = fopen("../../langdata/".$lang_code."_catalog.php", "w");
	$string_data = <<<EOF
<?php
\$CATALOG_ARRAY = array ( 
	
EOF;
	fwrite($handle, $string_data);

	$catalog = simplexml_load_file("../../langdata/".$lang_code."_catalog.xml");
	
	$catalog_count = 0;
	foreach($catalog as $entity)
	{
		$catalog_count++;
		$string_data = '"'.$entity['id'].'" => array ( ';
		fwrite($handle, "\t".$string_data."\n");
		$terms = $entity->term;
		$term_count = 0;
		foreach($terms as $term)
		{
			$term_count++;
			$string_data = "\"".$term->key."\" => \"".$term->value."\"";
			if($term_count != count($terms))
			{
				$string_data .= ", ";
			}
			fwrite($handle, "\t\t".$string_data."\n");
		}
		
		$string_data = ") ";
		fwrite($handle, "\t".$string_data);
		if($catalog_count < count($catalog))
		{
			$string_data = ", ";
			fwrite($handle, $string_data."\n");
		}
	}
	$string_data = <<<EOF
);

?>
EOF;
	fwrite($handle, "\n".$string_data);
	fclose($handle);
	/*
	include($lang_code."_catalog.php");
	foreach($CATALOG_ARRAY as $key=>$value)
	{
		echo $key;
		echo " => ";
		echo print_r($value);
		echo "<br>";
	
	}
	*/
}

function update_testtype_xml($test_type_id, $test_name)
{
	catalog_db2xml();
	catalog_xml2php("default");
	# TODO: Extend to other languages
}

function update_specimentype_xml($specimen_type_id, $specimen_name)
{
	catalog_db2xml();
	catalog_xml2php("default");
	# TODO: Extend to other languages
}

function update_measure_xml($measure_id, $measure_name)
{
	catalog_db2xml();
	catalog_xml2php("default");
	# TODO: Extend to other languages
}


#
# Functions for handling result interpretation (technician remarks)
#

function remarks_xml2php($langdata_path)
{
	# Converts updated XML file to corresponding PHP list
	# TODO:
	$handle = fopen($langdata_path."remarks.php", "w");
	$string_data = <<<EOF
<?php
\$REMARKS_ARRAY = array ( 
	
EOF;
	fwrite($handle, $string_data);

	$measures = simplexml_load_file($langdata_path."remarks.xml");
	
	$measure_count = 0;
	foreach($measures as $measure)
	{
		$measure_count++;
		$string_data = '"'.$measure['id'].'" => array ( ';
		fwrite($handle, "\t".$string_data."\n");
		$ranges = $measure->range;
		$range_count = 0;
		foreach($ranges as $range)
		{
			$range_count++;
			$string_data = "\"".$range->key."\" => \"".$range->value."\"";
			if($range_count != count($ranges))
			{
				$string_data .= ", ";
			}
			fwrite($handle, "\t\t".$string_data."\n");
		}
		
		$string_data = ") ";
		fwrite($handle, "\t".$string_data);
		if($measure_count < count($measures))
		{
			$string_data = ", ";
			fwrite($handle, $string_data."\n");
		}
	}
	$string_data = <<<EOF
);

require_once("../lang/lang_util.php");
?>
EOF;
	fwrite($handle, "\n".$string_data);
	fclose($handle);
}

function remarks_db2xml($langdata_path, $lab_config_id)
{
	# Creates XML file from existing test measures (indicators) in catalog
	global $VERSION;
	$new_version = $VERSION;
	$handle = fopen($langdata_path."remarks.xml", "w");
	$string_data = <<<EOF
<?xml version="1.0"?>
<measures version="$new_version">

EOF;
	fwrite($handle, $string_data);
	$saved_db = DbUtil::switchToLabConfigRevamp($lab_config_id);
	$query_string = "SELECT * FROM measure";
	$resultset = query_associative_all($query_string, $row_count);
	foreach($resultset as $record)
	{
		$curr_measure = Measure::getObject($record);
		$id = $curr_measure->measureId;
		$descr = $curr_measure->name;
		$string_data = <<<EOF
	<measure id="$id" descr="$descr">

EOF;
		fwrite($handle, $string_data);
		$range_type = $curr_measure->getRangeType();
		$range_values = $curr_measure->getRangeValues();
		if($range_type == Measure::$RANGE_NUMERIC)
		{
			$lower_bound = htmlspecialchars($range_values[0]);
			$upper_bound = htmlspecialchars($range_values[1]);
			$string_data = <<<EOF
		<range>
			<key>$range_values[0]:$range_values[1]</key>
			<value></value>
		</range>

EOF;
			fwrite($handle, $string_data);
		}
		else if($range_type == Measure::$RANGE_OPTIONS)
		{
			foreach($range_values as $range_value)
			{
				$range_value_xml = htmlspecialchars($range_value);
				$string_data = <<<EOF
		<range>
			<key>$range_value_xml</key>
			<value></value>
		</range>

EOF;
				fwrite($handle, $string_data);
			}
		}
			$string_data = <<<EOF
	</measure>

EOF;
		fwrite($handle, $string_data);
	}
	$string_data = <<<EOF
</measures>

EOF;
	fwrite($handle, $string_data);	
	fclose($handle);
	DbUtil::switchRestore($saved_db);
}

function update_remarks_xml($langdata_path, $updated_remarks)
{
	# Updates the XML file after changes made to a test measure (indicator)
	# updated_remarks[measure_id] = {[range]=>[interpretation]}
	global $VERSION;
	$new_version = $VERSION;
	$file_name = $langdata_path."remarks.xml";
	$dest_file_name = $langdata_path."remarks.xml";
	$xml_doc = new DOMDocument();
	$xml_doc->load($file_name);
	$xpath = new DOMXpath($xml_doc);
	$root_node = $xml_doc->getElementsByTagName("measures");
	$root_node->item(0)->setAttribute("version", $new_version);
	foreach($updated_remarks as $key=>$value)
	{
		$measure_id = $key;
		$remarks_map = $value;
		$measure = Measure::getById($measure_id);
		# Remove old measure node
		$old_measure_node = $xpath->query("//measures/measure[@id='".$measure_id."']");
		$old_measure_node = $root_node->item(0)->removeChild($old_measure_node->item(0));
		# Create new measure node based on supplied values
		$new_measure_node = $xml_doc->createElement("measure");
		$new_measure_node->setAttribute("id", $measure_id);
		$new_measure_node->setAttribute("descr", $measure->name);
		foreach($remarks_map as $key2=>$value2)
		{
			$range = $key2;
			$remark = $value2;
			$new_range_node = $xml_doc->createElement("range");
			$new_key_node = $xml_doc->createElement("key", $range);
			$new_value_node = $xml_doc->createElement("value", $remark);
			$new_range_node->appendChild($new_key_node);
			$new_range_node->appendChild($new_value_node);
			$new_measure_node->appendChild($new_range_node);
		}
		# Append updated measure node to XML root node
		$root_node->item(0)->appendChild($new_measure_node);
	}
	# Save changes back into XML file
	$xml_doc->formatOutput = true;
	$xml_doc->preserveWhiteSpace = true;
	$xml_doc->save($dest_file_name);
}


//lang_xml2php("default", "../../local/langdata_revamp/");
//lang_xml2php("en", "../../local/langdata_revamp/");
//lang_xml2php("fr", "../../local/langdata_revamp/");

//remarks_db2xml("../../local/langdata_127/", 127;
//remarks_xml2php("../../local/langdata_127");

//catalog_db2xml("fr");
//catalog_xml2php("fr");

?>