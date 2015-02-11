<?php
    include($_SERVER['DOCUMENT_ROOT']."includes/db_lib.php");

	$lab_config = LabConfig::getById($_SESSION['lab_config_id']);
	$instruments = $lab_config->getInstrumentationMachines();

	$return_value = "";

	if(count($instruments) > 0){
		$cnt = 1;
		foreach ($instruments as $instrument) {
			$return_value = "<tr><td>".$cnt++."</td>";
			$return_value .= "<td>".$instrument['name']."</td>";
			$return_value .= "<td>".$instrument['ip_address']."</td>";
			$return_value .= "<td>".$instrument['hostname']."</td>";
			$return_value .= "<td><a href='javascript:void(0)' class='btn instrument-delete' ";
			$return_value .= "data-url='/ajax/instrumentation_delete_device.php' data-id='".$instrument['id']."'>";
			$return_value .= LangUtil::$generalTerms['CMD_DELETE']."</a></td></tr>";
		}
	}else{
		$return_value = "<tr><td colspan='5'>No device found!</td></tr>";
	}

	echo $return_value;
?>
