<?php
    include($_SERVER['DOCUMENT_ROOT']."includes/db_lib.php");

	$lab_config = LabConfig::getById($_SESSION['lab_config_id']);

	$drivers = $lab_config->getInstrumentationDrivers();

	$return_value = "<table class='hor-minimalist-b'>
						<thead><tr>
							<th>#</th>
							<th>Driver Name</th>
							<th>Supported Tests</th>
							<th></th></tr>
						</thead>
						<tbody>";

	if(count($drivers) > 0){
		$cnt = 1;
		foreach ($drivers as $driver) {
			$mappings = $lab_config->getInstrumentationTestMappings($driver['id']);
			$map = "<table class='bordered-table'><thead><th><strong>Key</strong></th>";
			$map .= "<th><strong>Mapped to (Test type -> measure)</strong></th></thead><tbody>";

			if (count($mappings) > 0) {

				foreach ($mappings as $mapping) {
					$map .= "<tr><td>".$mapping['result_key']."</td><td>".$mapping['test_type']." -> ".$mapping['measure']."</td></tr>";
				}
			} else {
				$map .= "<tr><td colspan='2'>No mappings defined!</td></tr>";
			}
			$map .= "</tbody></table>";
			

			$return_value .= "<tr><td>".$cnt++."</td>";
			$return_value .= "<td>".$driver['alias']."</td>";
			$return_value .= "<td>".$driver['supported_tests']."</td>";
			$return_value .= "<td><a href='javascript:void(0)' class='btn instrument-view-details'>";
			$return_value .= LangUtil::$generalTerms['CMD_VIEW']."</a> ";
			$return_value .= "<a href='javascript:void(0)' class='btn instrument-delete' ";
			$return_value .= "data-url='/ajax/instrumentation_delete_driver.php' data-id='".$driver['id']."'>";
			$return_value .= LangUtil::$generalTerms['CMD_DELETE']."</a></td></tr>";
			$return_value .= "<tr class='hide'><td></td><td colspan='2'><br /><strong>Description</strong>: ";
			$return_value .= $driver['description']."<br /><br />$map</td><td></td></tr>";
		}
	}else{
		$return_value .= "<tr><td colspan='4'>No drivers found!</td></tr>";
	}

	echo $return_value."</tbody></table>";
?>
