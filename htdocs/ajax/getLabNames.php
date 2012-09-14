<?php
	for($i=0; $i < count($lab_config_id_array); $i++) {
					
		$labIdTestTypeIdSeparated = explode(":",$lab_config_id_array[$i]);
		$lab_config_id = $labIdTestTypeIdSeparated[0];
				
		$lab_config = LabConfig::getById($lab_config_id);
		$labName = $lab_config->name;
		$labNamesArray[] = $labName;
	}
?>