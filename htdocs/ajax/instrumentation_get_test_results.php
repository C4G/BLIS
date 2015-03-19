<?php

    include($_SERVER['DOCUMENT_ROOT']."includes/db_lib.php");

    $driverID = $_REQUEST['driver_id'];
    $testTypeID = $_REQUEST['test_type_id'];

    $saved_db = DbUtil::switchToGlobal();
    $query = sprintf("SELECT driver_name FROM machine_drivers WHERE id = %s", mysql_real_escape_string($driverID));
    $record = query_associative_one($query);

    $driver = $record['driver_name'];

    DbUtil::switchToLabConfig($_SESSION['lab_config_id']);

    $query = sprintf("SELECT ip_address, hostname FROM test_machines WHERE machine_driver_id = %s LIMIT 1", mysql_real_escape_string($driverID));
    $result = query_associative_one($query);

    $ipAddress = $result['ip_address'];
    $hostName = $result['hostname'];

    include($_SERVER['DOCUMENT_ROOT'].'/autoloader.php');
    $instrument = new $driver($ipAddress, $hostName);
    
    $results = swapKeysForMeasureIDs($instrument->getResult());
    echo json_encode($results);

    function swapKeysForMeasureIDs($array) {
        global $con, $driverID, $testTypeID;
        $saved_db = DbUtil::switchToLabConfig($_SESSION['lab_config_id']);
        $results = array();

        foreach ($array as $key => $value) {
            $query = "SELECT measure_id FROM test_type_instruments WHERE machine_driver_id = %s AND test_type_id = %s AND result_key = '%s' LIMIT 1";
            $query = sprintf($query, mysql_real_escape_string($driverID), mysql_real_escape_string($testTypeID), mysql_real_escape_string($key));
            $record = query_associative_one($query);

            if (isset($record['measure_id'])) {
                $results["mid-".$record['measure_id']] = $value;
            }
        }
        DbUtil::switchRestore($saved_db);
        return $results;
    }
?> 