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
putUILog('retrieve_specimens', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');
//$specimen_del= array();
//$specimen_del = explode(",",$_REQUEST['specimen_array']);
$specimen_list = get_specimens_by_patient_id($pid);
$rem_recs = get_removed_specimens($_SESSION['lab_config_id'],"specimen");
$rem_specs = array();
                $rem_remarks = array();
foreach($rem_recs as $rem_rec)
{
    $rem_specs[] = $rem_rec['r_id'];
    $rem_remarks[] = $rem_rec['remarks'];
}



?>

<a href='select_test_profile.php?pid=<?php echo $pid; ?>'>&laquo; <?php echo LangUtil::$generalTerms['CMD_BACK']; ?></a> &nbsp;|&nbsp;<b> <?php echo "Retrieve Specimens"; ?></b>
		<br><br>
                &nbsp;Select specimens for retrieval and confirm action.
		<script type='text/javascript'>
		$(document).ready(function(){
			//$('#test_history_table').tablesorter();
		});
		
		
		</script>
                <form name="del" id="del" action='reports/ret_tests.php'  method='post'>
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
					<th>Retrieve</th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach($specimen_list as $specimen)
			{
                            if(!in_array($specimen->specimenId, $rem_specs))
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
                                    <input type='checkbox' name="specs[]" value='<?php echo $specimen->specimenId; ?>'
                                    <?php $cn++; ?>
                                </td>
                                <?php
                                $sid=$specimen->specimenId;
                                
                                ?>
                                <input type="hidden" name="sp[]" value="<?php echo $sid ?>" />
                        </tr>
                        
			<?php
                        }
			?>
			</tbody>
		</table>
                    <?php $url_post = "select_test_profile.php?pid=".$pid ?>
                    <input type="hidden" name="url" value="<?php echo $url_post ?>" />
                    <input type="Submit" value="Retrive" />
                </form>

<?php
?>
