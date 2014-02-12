<?php
#
# Shows tests performed report for a site/location and date interval
#
include("redirect.php");
include("includes/header.php");
include("includes/stats_lib.php");
LangUtil::setPageId("reports");

$script_elems->enableFlotBasic();
$script_elems->enableFlipV();
$script_elems->enableTableSorter();
$script_elems->enableLatencyRecord();
?>
<script type='text/javascript'>
$(window).load(function(){
	$('#stat_graph').hide();
});
function toggle_stat_table()
{
	$('#stat_graph').toggle();
	var linktext = $('#showtablelink').text();
	if(linktext.indexOf("<?php echo LangUtil::$pageTerms['MSG_SHOWGRAPH']; ?>") != -1)
		$('#showtablelink').text("<?php echo LangUtil::$pageTerms['MSG_HIDEGRAPH']; ?>");
	else
		$('#showtablelink').text("<?php echo LangUtil::$pageTerms['MSG_SHOWGRAPH']; ?>");
}
</script>
<style type='text/css'>
.flipv_up {
	font-size: 12px;
	font-family: Tahoma;
}
.flipv {
	font-size: 12px;
	font-family: Tahoma;
}
</style>
<br>
<b><?php echo "Collective User Stats"; ?></b> 
<?php /*| <a href="javascript:toggle_stat_table();" id='showtablelink'> # echo LangUtil::$pageTerms['MSG_SHOWGRAPH']; </a> */ ?>
 | <a href='reports.php?show_ust'>&laquo; <?php echo LangUtil::$pageTerms['MSG_BACKTOREPORTS']; ?></a>
<br><br>
<?php
$lab_config_id = $_REQUEST['location'];
$date_from = $_REQUEST['yyyy_from']."-".$_REQUEST['mm_from']."-".$_REQUEST['dd_from'];
$date_to = $_REQUEST['yyyy_to']."-".$_REQUEST['mm_to']."-".$_REQUEST['dd_to'];
$ust = new UserStats();
$pr_c = $_POST['count_type_pr'];
$sr_c = $_POST['count_type_sr'];
$tr_c = $_POST['count_type_tr'];
$re_c = $_POST['count_type_re'];
$uiinfo = "from=".$date_from."&to=".$date_to."&pr=".$pr_c."&sr=".$sr_c."&tr=".$tr_c."&re=".$re_c;
putUILog('reports_user_stats_all', $uiinfo, basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');
//echo $pr_c."-".$sr_c."-".$tr_c."-".$re_c;
/*if($pr_c == 'Yes')
    echo "+++++++++++++++++++++++++";
else
    echo "-------------------------";*/
//echo "Hey:";
//print_r($ust->getTestStats(116, $lab_config_id,$date_from, $date_to));
DbUtil::switchToLabConfig($lab_config_id);
$lab_config = get_lab_config_by_id($lab_config_id);
if($lab_config == null)
{
	?>
	<div class='sidetip_nopos'>
		<?php echo LangUtil::$generalTerms['MSG_NOTFOUND']; ?> <a href='javascript:history.go(-1);'>&laquo; <?php echo LangUtil::$generalTerms['CMD_BACK']; ?></a>
	</div>
	<?php
	return;
}
 $site_list = get_site_list($_SESSION['user_id']);
			if(count($site_list) != 1)
			{ echo LangUtil::$generalTerms['FACILITY'] ?>: <?php echo $lab_config->getSiteName(); ?> | 
<?php
}

if($date_from == $date_to)
{
	echo LangUtil::$generalTerms['DATE'].": ".DateLib::mysqlToString($date_from);
}
else
{	
	echo LangUtil::$generalTerms['FROM_DATE'].": ".DateLib::mysqlToString($date_from);
	echo " | ";
	echo LangUtil::$generalTerms['TO_DATE'].": ".DateLib::mysqlToString($date_to);
}
?>
<br><br>

<?php //$stat_list = StatsLib::getTestsDoneStats($lab_config, $date_from, $date_to); 
//print_r($stat_list);

?>

<div id='stat_table'>
	<?php //$page_elems->getTestsDoneStatsTable($stat_list); 
        ?>
    <script type='text/javascript'>
		$(document).ready(function(){
			$('#testsdone_table').tablesorter();
		});
		</script>
		<table class='tablesorter' id='testsdone_table' style='width:700px'>
		<thead>
			<tr>
				<th>Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                
                                <th>User Name &nbsp;&nbsp;&nbsp;</th>
                                
                                <th>Designation&nbsp;&nbsp;</th>
                                
                                <?php if($pr_c == 'Yes') { ?>
				<th>Patients Registered</th>
                                <?php } ?>
                                
                                <?php if($sr_c == 'Yes') { ?>
				<th>Specimens Registered</th>
                                <?php } ?>
                                
                                <?php if($tr_c == 'Yes') { ?>
				<th>Tests Registered</th>
                                <?php } ?>
                                
                                <?php if($re_c == 'Yes') { ?>
				<th>Results Entered</th>
				<?php } ?>
                                
			</tr>
		</thead>
		<tbodys>
		<?php
                $user_ids = array();
                array_push($user_ids, $ust->getAdminUser($lab_config_id));
                $user_ids_others =  $ust->getAllUsers($lab_config_id);
                foreach($user_ids_others as $uids)
                      array_push($user_ids, $uids);
                
		foreach($user_ids as $uid)
		{
                     $user_obj = get_user_by_id($uid);
			?>
			<tr>
			
                        <td><?php echo $user_obj->actualName; ?></td>
			
                        <td><?php echo $user_obj->username; ?></td>
			
                        <td><?php 
                        if ($user_obj->level == 0 || $user_obj->level == 1 || $user_obj->level == 13)
                            echo "Technician";
                        else if ($user_obj->level == 2)
                            echo "Administrator";
                        else if ($user_obj->level == 5)
                            echo "Clerk";
                        ?></td>
                        
                        <?php if($pr_c == 'Yes') { ?>
                        <td><?php echo $ust->getPatientsStats($uid, $lab_config_id,$date_from, $date_to); ?></td>
                        <?php } ?>
                        
                        <?php if($sr_c == 'Yes') { ?>
                        <td><?php echo $ust->getSpecimenStats($uid, $lab_config_id,$date_from, $date_to); ?></td>
                        <?php } ?>
                        
                        <?php if($tr_c == 'Yes') { ?>
                        <td><?php echo $ust->getTestStats($uid, $lab_config_id,$date_from, $date_to); ?></td>
                        <?php } ?>
                        
                        <?php if($re_c == 'Yes') { ?>
                        <td><?php echo $ust->getResultStats($uid, $lab_config_id,$date_from, $date_to); ?></td>
			<?php } ?>
                        
                        </tr>
			<?php
		}
		?>
		</tbody>
		</table>
</div>
<?php include("includes/footer.php"); ?>