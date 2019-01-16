<?php
include("../includes/db_lib.php");
$attrib_value = $_REQUEST['q'];
$attrib_type = $_REQUEST['a'];
$c = $_REQUEST['c'];
$dynamic = 1;
$lab_section = 0; // All lab section by default
if(isset($_REQUEST['labsec']))
	$lab_section = $_REQUEST['labsec']; // change the value based on the query
$lab_config = LabConfig::getById($_SESSION['lab_config_id']);
$query_string = "";
if($dynamic == 0)
{
    if($attrib_type == 5)
    {
            # Search by specimen aux ID
            $query_string = 
                    "SELECT distinct s.specimen_id FROM specimen s, test t, patient p ".
                    "WHERE p.patient_id=s.patient_id ".
                    "AND s.aux_id='$attrib_value'".
                    "AND s.specimen_id=t.specimen_id ".
                    "AND t.result = '' ";
    }
    if($attrib_type == 0)
    {
            # Search by patient ID
            $query_string = 
                    "SELECT distinct s.specimen_id FROM specimen s, test t, patient p ".
                    "WHERE p.patient_id=s.patient_id ".
                    "AND p.surr_id='$attrib_value'".
                    "AND s.specimen_id=t.specimen_id ".
                    "AND t.result = '' ";
    }
    else if($attrib_type == 1)
    {
            # Search by patient name
			if(empty($c))
				$attrib_value.='%';
			else	
				$attrib_value=str_replace('[pq]',$attrib_value,$c);
				
            $query_string = 
                    "SELECT COUNT(*) AS val FROM patient WHERE name LIKE '$attrib_value'";
            $record = query_associative_one($query_string);
            if($record['val'] == 0)
            {
                    # No patients found with matching name
                    ?>
                    <div class='sidetip_nopos'>
                    <b>'<?php echo $attrib_value; ?>'</b> - <?php echo LangUtil::$generalTerms['MSG_SIMILARNOTFOUND']; ?>
                    <?php
                    return;
            }
            $query_string = 
                    "SELECT distinct s.specimen_id FROM specimen s, test t, patient p ".
                    "WHERE s.specimen_id=t.specimen_id ".
                    "AND t.result = '' ".
                    "AND s.patient_id=p.patient_id ".
                    "AND p.name LIKE '$attrib_value'";
    }
    else if($attrib_type == 3)
    {
            # Search by patient daily number
            $query_string = 
                    "SELECT distinct specimen_id FROM specimen ".
                    "WHERE daily_num LIKE '%-$attrib_value' ".
                    "AND ( status_code_id=".Specimen::$STATUS_PENDING." ".
                    "OR status_code_id=".Specimen::$STATUS_REFERRED." ) ".
                    "ORDER BY date_collected DESC";
    }
}
else
{
    if($attrib_type == 5)
    {
    	
            # Search by specimen aux ID
    	if($lab_section == 0) {
    		$query_string = 
                    "SELECT distinct s.specimen_id FROM specimen s, test t, patient p ".
                    "WHERE p.patient_id=s.patient_id ".
                    "AND s.aux_id='$attrib_value'".
                    "AND s.specimen_id=t.specimen_id ";
    	} else {
			$query_string =
					"SELECT distinct s.specimen_id FROM specimen s, test t, patient p ".
					"WHERE p.patient_id=s.patient_id ".
					"AND s.aux_id='$attrib_value'".
					"AND s.specimen_id=t.specimen_id ".
					"AND t.result = '' AND test_type_id IN
					(SELECT test_type_id FROM test_type WHERE test_category_id=$lab_section)";
		}
    }
    if($attrib_type == 0)
    {
            # Search by patient ID
    	if($lab_section == 0) {
    		$query_string = 
                    "SELECT distinct s.specimen_id FROM specimen s, test t, patient p ".
                    "WHERE p.patient_id=s.patient_id ".
                    "AND p.surr_id='$attrib_value'".
                    "AND s.specimen_id=t.specimen_id ";
    	} else {
    		$query_string =
					"SELECT distinct s.specimen_id FROM specimen s, test t, patient p ".
					"WHERE p.patient_id=s.patient_id ".
					"AND p.surr_id='$attrib_value'".
					"AND s.specimen_id=t.specimen_id ".
					"AND t.result = '' AND test_type_id IN
					(SELECT test_type_id FROM test_type WHERE test_category_id=$lab_section)";
    	}
    }
    else if($attrib_type == 1)
    {
            # Search by patient name
			if(empty($c))
				$attrib_value.='%';
			else	
				$attrib_value=str_replace('[pq]',$attrib_value,$c);
				
            $query_string = 
                    "SELECT COUNT(*) AS val FROM patient WHERE name LIKE '$attrib_value'";
            $record = query_associative_one($query_string);
            if($record['val'] == 0)
            {
                    # No patients found with matching name
                    ?>
                    <div class='sidetip_nopos'>
                    <b>'<?php echo $attrib_value; ?>'</b> - <?php echo LangUtil::$generalTerms['MSG_SIMILARNOTFOUND']; ?>
                    <?php
                    return;
            }
            
            if($lab_section == 0) {
            $query_string = 
                    "SELECT distinct s.specimen_id FROM specimen s, test t, patient p ".
                    "WHERE s.specimen_id=t.specimen_id ".
                    "AND t.result = '' ".
                    "AND s.patient_id=p.patient_id ".
                    "AND p.name LIKE '$attrib_value'"; }
            else {
			$query_string =
					"SELECT distinct s.specimen_id FROM specimen s, test t, patient p ".
					"WHERE s.specimen_id=t.specimen_id ".
					"AND t.result = '' ".
					"AND s.patient_id=p.patient_id ".
					"AND p.name LIKE '$attrib_value' AND test_type_id IN
					(SELECT test_type_id FROM test_type WHERE test_category_id=$lab_section)";
			}
    }
    else if($attrib_type == 3)
    {
            # Search by patient daily number
    	if($lab_section == 0) {
    		$query_string = 
                    "SELECT distinct specimen_id FROM specimen ".
                    "WHERE daily_num LIKE '%-$attrib_value' ".
                    "AND ( status_code_id=".Specimen::$STATUS_PENDING." ".
                    "OR status_code_id=".Specimen::$STATUS_REFERRED." ) ".
                    "ORDER BY date_collected DESC";
    	} else {
			$query_string =
					"SELECT distinct s.specimen_id FROM specimen s, test t WHERE s.specimen_id = t.specimen_id AND ".
					"daily_num LIKE '%-$attrib_value'".
					"AND ( status_code_id=".Specimen::$STATUS_PENDING." ".
					"OR status_code_id=".Specimen::$STATUS_REFERRED." ) AND t.test_type_id IN
					(SELECT test_type_id FROM test_type WHERE test_category_id=$lab_section)".
					"ORDER BY date_collected DESC";
    		
    	}
    } 
    else if($attrib_type == 9)
    {
            # Search by patient specimen id
                $decoded = decodeSpecimenBarcode($attrib_value);
                if($lab_section == 0) {

				$query_string = 
                    "SELECT distinct specimen_id FROM specimen ".
                    "WHERE specimen_id = $decoded[1] ".
                    "AND ( status_code_id=".Specimen::$STATUS_PENDING." ".
                    "OR status_code_id=".Specimen::$STATUS_REFERRED." ) ".
                    "ORDER BY date_collected DESC";
            	} else {
					$query_string =
						"SELECT distinct specimen_id FROM specimen ".
						"WHERE specimen_id = $decoded[1] ".
						"AND ( status_code_id=".Specimen::$STATUS_PENDING." ".
						"OR status_code_id=".Specimen::$STATUS_REFERRED." ) ".
						"ORDER BY date_collected DESC";
				}
    } 
	}
$resultset = query_associative_all($query_string, $row_count);
$specimen_id_list = array();
foreach($resultset as $record)
{
	$specimen_id_list[] = $record['specimen_id'];
}
# Remove duplicates that might come due to multiple pending tests
$specimen_id_list = array_values(array_unique($specimen_id_list));
	$count = count($specimen_id_list);
echo $count;
?>
