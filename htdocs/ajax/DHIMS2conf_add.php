<?php
//file_put_contents("dhims2.txt",$_REQUEST['blis2dataelement_text']);
include("../includes/db_lib.php");
$dhims2 = new DHIMS2();
$dhims2->blisGender = $_REQUEST['blisgender'];
$dhims2->blisAgegroup = $_REQUEST['bliscat'];
$dhims2->blisTestID = $_REQUEST['blis2dataelement_text'];
//dhims2 values
$dhims2->username = $_REQUEST['dhims2username'];
$dhims2->password = $_REQUEST['dhims2password'];
$dhims2->entryPeriod = $_REQUEST['entryperiod'];
$dhims2->orgUnit = $_REQUEST['dhims2orgunit'] .'^'.$_REQUEST['dhims2orgunit_text'];
$dhims2->dataSet = $_REQUEST['dhims2dataset'] .'^'.$_REQUEST['dhims2dataset_text'];
$dhims2->dataElement = $_REQUEST['dhims2dataelement'] .'^'.$_REQUEST['dhims2dataelement_text'];
$dhims2->categoryCombo = $_REQUEST['dhims2catCombo'] .'^'.$_REQUEST['dhims2catCombo_text'];
$lab_config_id = $_REQUEST['lid'];
$dhims2->Save($lab_config_id );
?>