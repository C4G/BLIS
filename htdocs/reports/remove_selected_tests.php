<?php

include("redirect.php");
include("includes/db_lib.php");
include("includes/script_elems.php");
include("includes/page_elems.php");
include("includes/header.php");

LangUtil::setPageId("reports");


$script_elems->enableFlotBasic();
$script_elems->enableFlipV();
$script_elems->enableTableSorter();


$lab_config_id = $_SESSION['lab_config_id'];
$pid = $_REQUEST['pid'];
$cn = 1;
$remarks_var = "remarks";
$specimen_del= array();
$specimen_del = explode(",",$_REQUEST['specimen_array']);
$specimen_list = get_specimens_by_patient_id($pid);
putUILog('remove_selected_tests', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

?>

<a href='select_test_profile.php?pid=<?php echo $pid; ?>'>&laquo; <?php echo LangUtil::$generalTerms['CMD_BACK']; ?></a> &nbsp;|&nbsp;<b> <?php echo "Remove Specimens"; ?></b>
		<br><br>
                &nbsp;Enter Reasons for removal and confirm action.
		<script type='text/javascript'>
		$(document).ready(function(){
			//$('#test_history_table').tablesorter();
		});
		
		
		</script>
                <form name="del" id="del" action='reports/rem_tests.php'  method='post'>
		<input type='hidden' name='category' value='specimen' />
		<table class='tablesorter' id='test_history_table'>
			<thead>
				<tr valign='top'>
					<?php
					if($_SESSION['s_addl'] != 0)
					{
					?>
					<th><?php echo LangUtil::$generalTerms['SPECIMEN_ID']; ?></th>
					<?php
					}
					?>
					<th><?php echo LangUtil::$generalTerms['TYPE']; ?></th>
					<th><?php echo LangUtil::$generalTerms['R_DATE']; ?></th>
                                        <th><?php echo LangUtil::$generalTerms['SP_STATUS']; ?></th>
					<th>Remarks</th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach($specimen_list as $specimen)
			{
                            if(!in_array($specimen->specimenId, $specimen_del))
                                    continue;
                            ?>
		
                        <tr valign='top'>
                                <?php
                                if($_SESSION['s_addl'] != 0)
                                {
                                ?>
                                        <td>
                                                <?php echo $specimen->getAuxId(); ?>
                                        </td>
                                <?php
                                }
                                ?>
                                <td>
                                        <?php echo get_specimen_name_by_id($specimen->specimenTypeId); ?>
                                </td>
                                <td>
                                        <?php echo DateLib::mysqlToString($specimen->dateRecvd); ?>
                                </td>
                                <td>
                                        <?php echo $specimen->getStatus(); ?>
                                </td>
                                <td>
                                    <?php 
                                    $sid=$specimen->specimenId;
                                    $ch = check_removal_record($lid, $sid, "specimen");
                                        if($ch == 1)
                                        {
                                            echo "Already Removed";
                                        }
                                        else
                                        {
                                            ?>
                                    
                                    <textarea name="remarks[]" id="remarks" rows="3" cols="22"></textarea>
                                    <?php }
                                    $cn++; ?>
                                </td>
                                <?php 
                                    $sid=$specimen->specimenId;
                                    $ch = check_removal_record($lid, $sid);
                                        if($ch == 1)
                                        {
                                        }
                                        else
                                        {
                                            ?>
                                    
                                <input type="hidden" name="sp[]" value="<?php echo $sid ?>" />
                                    <?php }
                                     ?>
                        </tr>
                        
			<?php
                        }
			?>
			</tbody>
		</table>
                    <?php $url_post = "select_test_profile.php?pid=".$pid ?>
                    <input type="hidden" name="url" value="<?php echo $url_post ?>" />
                    <input type="Submit" value="Remove" />
                </form>

<?php
?>
