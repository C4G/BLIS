<?php

    include($_SERVER['DOCUMENT_ROOT']."includes/db_lib.php");

    # Get corresponding driver class file
    $saved_db = DbUtil::switchToGlobal();
    $query = "SELECT id, driver_name FROM machine_drivers ORDER BY id DESC LIMIT 1";
    $record = query_associative_one($query);

    if($record != null){

        $className =  $record['driver_name'];
        include($_SERVER['DOCUMENT_ROOT'].'/autoloader.php');

        if (class_exists($className)) {
            $instrument = new $className('127.0.0.1');
            if(method_exists($instrument, 'getEquipmentInfo')){

                $pluginInfo = $instrument->getEquipmentInfo();

                echo "<input type='hidden' name='machine_driver_id' value='".$record['id']."' />";

                $labConfig = LabConfig::getById($_SESSION['lab_config_id']);

                $testTypes = $labConfig->getTestTypes();
                $testTypeOptions = "";

                foreach ($testTypes as $testType) {
                    $testTypeOptions .= "<option value='".$testType->testTypeId."'>".$testType->name."</option>";
                }

                foreach ($pluginInfo['measures'] as $resultKey) {
                    echo "<div class='panel-row'>";
                    echo "<label>$resultKey</label>";
                    echo "<select name='test_type' class='instrument-test-types'>";
                    echo "<option value='0'>-- Select a test type --</option>$testTypeOptions</select>";
                    echo "<select name='measure' class='instrument-measures'>";
                    echo "<option value='0'>-- Select a measure --</option></select>";
                    echo "</div>";
                }
            } else {
                echo "<div>Invalid driver file: Not Result Keys Defined.</div>";
            }
        } else {
            echo "<div>Invalid driver file: Not Result Keys Defined.</div>";
        }
    }
?> 