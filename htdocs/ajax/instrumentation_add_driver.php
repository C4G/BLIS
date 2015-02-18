<?php

    include($_SERVER['DOCUMENT_ROOT']."includes/db_lib.php");

    $target_dir = $_SERVER['DOCUMENT_ROOT']."classes/plugins/";
    $target_file = $target_dir . basename($_FILES["import-driver-file"]["name"]);
    $uploadOk = 1;
    $fileType = pathinfo($target_file,PATHINFO_EXTENSION);

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "The driver file already exists.<br>";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["import-driver-file"]["size"] > 500000) {
        echo "Your file is too large.<br>";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($fileType != "php") {
        echo "Invalid script file!<br>";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["import-driver-file"]["tmp_name"], $target_file)) {
            $className = basename($_FILES["import-driver-file"]["name"], ".php");
            echo "The file $className has been uploaded.";

            include($_SERVER['DOCUMENT_ROOT'].'/autoloader.php');

            try {
                $pluginInfo = (new $className('127.0.0.1'))->getEquipmentInfo();

                $saved_db = DbUtil::switchToGlobal();

                $queryString = "INSERT INTO machine_drivers (driver_name, alias, description, provider, supported_tests)".
                                " VALUES ('%s', '%s', '%s', '%s', '%s')";
                $queryString = sprintf($queryString,
                                mysql_real_escape_string($className),
                                mysql_real_escape_string($pluginInfo['name']),
                                mysql_real_escape_string($pluginInfo['description']),
                                mysql_real_escape_string($pluginInfo['code']),
                                mysql_real_escape_string(implode(",", $pluginInfo['testTypes'])));

                query_insert_one($queryString);
                DbUtil::switchRestore($saved_db);

            } catch (Exception $e) {
                echo $e->getMessage()."\n";                
            }

        } else {
            echo "Sorry, there was an error uploading the driver.";
        }
    }
?> 