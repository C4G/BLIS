<?php
include("../includes/db_lib.php");

$test_type_id = $_REQUEST['tid'];
$labs = explode('-', $_REQUEST['labs']);
if($labs[0] == 0)
{
    $config_list = get_lab_configs_imported();
    $labs = array();
  foreach($config_list as $lab_config)
  {
      $labs[] = $lab_config->id;
  }
}
$date_from = $_REQUEST['df'];
$date_to = $_REQUEST['dt'];
//$test_type_id = 6;
//$labs[0] = 128;
//$labs[1] = 129;
 //$date_from = "2011-06-01";
 //$date_to = "2012-01-01";
 $ip = 0;
 sort($labs);
 $tname = getGlobalTestName($test_type_id);
 $testTypeMapping = TestTypeMapping::getTestTypeById($test_type_id, $_SESSION['user_id']);
 $mapping_list = array();
  $mapping_list = get_test_mapping_list_by_string($testTypeMapping->labIdTestId);
$i = 0;
$theprevdata = array();
$thetatdata = array();
$labname = array();
$xc = array();
$yc = array();
 foreach($labs as $lab)
 {

 $theprevdata[$i] = get_prevalence_data_per_test_per_lab_dir($mapping_list[$lab], $lab, $date_from, $date_to);
 $thetatdata[$i] = get_tat_data_per_test_per_lab_dir_new($mapping_list[$lab], $lab, $date_from, $date_to, $ip);
 $tem = get_lab_config_by_id($lab);
 $labname[$i]  = $tem->name;
 $tem = get_coordinates($lab);
 $xc[$i] = $tem[0];
 $yc[$i] = $tem[1];
 $i++;
 }
 

 
 $i = 0;
 foreach($labs as $lb)
 {
 $ret[$i] = array(
     'lab'=>$lb,
     'labname'=>$labname[$i],
     'xc'=>$xc[$i],
     'yc'=>$yc[$i],
 'prev'=>$theprevdata[$i],
 'tat'=>$thetatdata[$i],
 'date_from'=>$newDate = date("d F Y", strtotime($date_from)),
  'date_to'=>$newDate = date("d F Y", strtotime($date_to)),
'testname'=>$tname
 );
 $i++;
 }
echo json_encode($ret);

?>
