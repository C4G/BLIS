<?php
    include($_SERVER['DOCUMENT_ROOT']."includes/db_lib.php");

	$lab_config = LabConfig::getById($_SESSION['lab_config_id']);

	$drivers = $lab_config->getInstrumentationDrivers();

	$return_value = "";

	if(count($drivers) > 0){
		$cnt = 1;
		foreach ($drivers as $driver) {
			$return_value .= "<tr><td>".$cnt++."</td>";
			$return_value .= "<td>".$driver['alias']."</td>";
			$return_value .= "<td>".$driver['description']."</td>";
			$return_value .= "<td>".$driver['supported_tests']."</td>";
			$return_value .= "<td>".$driver['provider']."</td>";
			$return_value .= "<td><a href='javascript:void(0)' class='btn instrument-delete' ";
			$return_value .= "data-url='/ajax/instrumentation_delete_driver.php' data-id='".$driver['id']."'>";
			$return_value .= LangUtil::$generalTerms['CMD_DELETE']."</a></td></tr>";
		}
	}else{
		$return_value = "<tr><td colspan='6'>No drivers found!</td></tr>";
	}

	echo $return_value;
?>
