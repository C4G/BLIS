<?php

    include($_SERVER['DOCUMENT_ROOT']."includes/db_lib.php");

    $testTypeID = $_REQUEST['test_type_id'];

    if ($testTypeID == 0) {
        echo "<option value='0'>-- Select a measure --</option>";
    } else {

        $testType = TestType::getById($testTypeID);
        $measures = $testType->getMeasures();

        if (count($measures) > 0) {
            
            foreach ($measures as $measure) {
                echo "<option value='".$measure->measureId."'>".$measure->name."</option>";
            }
        } else {
            echo "<option value='0'>-- Select a measure --</option>";
        }
    }
    
?> 