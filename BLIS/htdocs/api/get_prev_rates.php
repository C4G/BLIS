<?php

include "../includes/db_lib.php";
include "../includes/stats_lib.php";
include "../includes/user_lib.php";

DbUtil::switchToLabConfig($lab_config_id);
if(!isset($_REQUEST['yf']) || !isset($_REQUEST['mf']) || !isset($_REQUEST['df']) || !isset($_REQUEST['yt']) || !isset($_REQUEST['dt']) || !isset($_REQUEST['mt']) )
{
    echo -2;
    return;
}
// returns total , nrgative and prev threshold
//$test_type_id = $_REQUEST['test_type_id'];
$date_from = $_REQUEST['yf']."-".$_REQUEST['mf']."-".$_REQUEST['df'];
$date_to = $_REQUEST['yt']."-".$_REQUEST['mt']."-".$_REQUEST['dt'];
//$result = API::get_prev_rates($test_type_id, $date_from, $date_to);
if($_SESSION['level'] < 2 || $_SESSION['level'] > 4)
        {
            $user = get_user_by_id($_SESSION['user_id']);
            $lab_config_id = $user->labConfigId;
        }

            if($lab_config_id == null)
            {
                $lab_config_id = get_lab_config_id_admin($_SESSION['user_id']);
            }
            $lab_config_idd = array($lab_config_id);
        $stat_list = StatsLib::getDiscreteInfectionStatsAggregate($lab_config_idd, $date_from, $date_to, 0);
        $result = $stat_list;
if($result < 1)
    echo $result;
else
    echo json_encode($result); 
?>
