<?php
include("../includes/db_lib.php");

$attrib_value = $_REQUEST['q'];
$attrib_type = $_REQUEST['a'];
$c = $_REQUEST['c'];

$lab_section = 0; // All lab section by default
if(isset($_REQUEST['labsec']))
	$lab_section = $_REQUEST['labsec']; // change the value based on the query

$query_by_labsec = "";
		
if($lab_section > 0){
	$query_by_labsec = "AND test_type_id IN (SELECT test_type_id FROM test_type WHERE test_category_id=$lab_section)";
}
$count = 0;
if($attrib_type == 5)
    {
            # Search by specimen aux ID
            $query_string = 
                    "SELECT count(s.specimen_id) as val FROM specimen s, test t, patient p ".
                    "WHERE p.patient_id=s.patient_id ".
                    "AND s.aux_id='$attrib_value'".
                    "AND s.specimen_id=t.specimen_id ".
                    "AND t.result = '' AND s.specimen_id NOT IN (select r_id from removal_record where category='specimen' AND status=1)  ". $query_by_labsec;
    }
    if($attrib_type == 0)
    {
            # Search by patient ID
            $query_string = 
                    "SELECT count(s.specimen_id) as val FROM specimen s, test t, patient p ".
                    "WHERE p.patient_id=s.patient_id ".
                    "AND p.surr_id='$attrib_value'".
                    "AND s.specimen_id=t.specimen_id ".
                    "AND t.result = '' AND s.specimen_id NOT IN (select r_id from removal_record where category='specimen' AND status=1)  ".$query_by_labsec;
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
                    "SELECT count(s.specimen_id) as val FROM specimen s, test t, patient p ".
                    "WHERE s.specimen_id=t.specimen_id ".
                    "AND t.result = '' ".
                    "AND s.patient_id=p.patient_id ".
                    "AND p.name LIKE '$attrib_value' AND s.specimen_id NOT IN (select r_id from removal_record where category='specimen' AND status=1)  ".$query_by_labsec;
    }
    else if($attrib_type == 3)
    {
            # Search by patient daily number
            /* $query_string = 
                    "SELECT count(specimen_id) as val FROM specimen ".
                    "WHERE daily_num LIKE '%-$attrib_value' ".
                    "AND ( status_code_id=".Specimen::$STATUS_PENDING." ".
                    "OR status_code_id=".Specimen::$STATUS_REFERRED." ) ".
                    "ORDER BY date_collected DESC";
             */
            
            if($lab_section == 0) {
            	$query_string =
            	"SELECT count(specimen_id) as val FROM specimen ".
            	"WHERE daily_num LIKE '%-$attrib_value' ".
            	"AND ( status_code_id=".Specimen::$STATUS_PENDING." ".
            	"OR status_code_id=".Specimen::$STATUS_REFERRED." ) AND specimen_id NOT IN (select r_id from removal_record where category='specimen' AND status=1)  ";
            } else {
            	$query_string =
            	"SELECT count(s.specimen_id) as val FROM specimen s, test t WHERE s.specimen_id = t.specimen_id AND ".
            	"daily_num LIKE '%-$attrib_value'".
            	"AND ( status_code_id=".Specimen::$STATUS_PENDING." ".
            	"OR status_code_id=".Specimen::$STATUS_REFERRED." ) AND t.test_type_id IN
            	(SELECT test_type_id FROM test_type WHERE test_category_id=$lab_section) AND s.specimen_id NOT IN (select r_id from removal_record where category='specimen' AND status=1) ";            
            }
    }
    else if($attrib_type == 9)
    {
        $decoded = decodeSpecimenBarcode($attrib_value);
            # Search by patient specimen id
    if($lab_section == 0) {

				$query_string = 
                    "SELECT count(specimen_id) as val FROM specimen ".
                    "WHERE specimen_id = $decoded[1] ".
                    "AND ( status_code_id=".Specimen::$STATUS_PENDING." ".
                    "OR status_code_id=".Specimen::$STATUS_REFERRED." ) AND specimen_id NOT IN (select r_id from removal_record where category='specimen' AND status=1) ".
                    "ORDER BY date_collected DESC LIMIT 0,$rcap";
            	} else {
					$query_string =
						"SELECT count(s.specimen_id) as val FROM specimen s, test t ".
						"WHERE s.specimen_id = $decoded[1] AND s.specimen_id = t.specimen_id ".
						"AND ( s.status_code_id=".Specimen::$STATUS_PENDING." ".
						"OR s.status_code_id=".Specimen::$STATUS_REFERRED." ) ".
						" AND t.test_type_id IN
					(SELECT test_type_id FROM test_type WHERE test_category_id=$lab_section)  ".
						"AND specimen_id NOT IN (select r_id from removal_record where category='specimen' AND status=1) ".
						"ORDER BY date_collected DESC LIMIT 0,$rcap";
				}
        
    }
    
    else if($attrib_type == 10)
    {
    # Search by patient specimen id
    	$decoded = decodePatientBarcode($attrib_value);
    	if($lab_section == 0) {
    
    	$query_string =
    		"SELECT count(s.specimen_id) as val FROM specimen s, test t, patient p ".
                    "WHERE p.patient_id=s.patient_id ".
                        "AND p.surr_id='$decoded[1]'".
                        "AND s.specimen_id=t.specimen_id ".
                        "AND s.specimen_id NOT IN (select r_id from removal_record where category='specimen') ";
    
            	} else {
                   		$query_string =
                        		"SELECT count(s.specimen_id) as val FROM specimen s, test t, patient p ".
								"WHERE p.patient_id=s.patient_id ".
								"AND p.surr_id='$attrib_value'".
    							"AND s.specimen_id=t.specimen_id ".
								"AND test_type_id IN
    							(SELECT test_type_id FROM test_type WHERE test_category_id=$lab_section) AND s.specimen_id NOT IN (select r_id from removal_record where category='specimen' AND status=1) LIMIT 0,$rcap ";
               }
    }
    
   //echo $query_string; 
$resultset = query_associative_one($query_string);
	$count = $resultset['val'];
	//echo $query_string;
echo $count;
?>
