<?php
#
# Returns a list of similar patient names
# To aid/help during new patient registration
#

include("../includes/db_lib.php");
LangUtil::setPageId("new_patient");

$q = $_REQUEST['q'];
$query_string = 
	"SELECT * FROM inv_reagent ".
	"WHERE name LIKE '$q%' ";
$resultset = query_associative_all($query_string, $row_count);
if(count($resultset) == 0 || $resultset == null)
	return;
$reagent_list = array();
$ii = 0;
$jj = 0;
foreach($resultset as $record)
{
    $jj = 0;
    $reagent_list[$ii] = array();
    $reagent_list[$ii][$jj] = $record['name'];
    $jj++;
    $reagent_list[$ii][$jj] = $record['unit'];
    $jj++;
    if(isset($record['remarks']))
        $reagent_list[$ii][$jj] = $record['remarks'];
    else 
        $reagent_list[$ii][$jj] = '-';
    $jj++;
    $ii++;
}
?>
<table class='hor-minimalist-c' style='width:450px;'>
	<thead>
		<tr valign='top'>
			<th>
				<span style='background-color:#FFCC66'><?php echo "Similar Reagents"; ?></span>
			</th>
			
			<th><?php echo "Unit"; ?></th>
			<th style="width:70px;"><?php echo "Remarks" ?></th>
		</tr>
	</thead>
	<tbody>
	<?php
	foreach($reagent_list as $reagent)
	{
		?>
		<tr valign='top'>
			<td>
				<?php 
				echo $reagent[0]; 
				?>
			</td>
			
			<td>
				<?php
				echo $reagent[1];
				?>
			</td>
			<td>
				<?php
				echo $reagent[2];
				?>
			</td>
		</tr>
		<?php
	}
	?>
	</tbody>
</table>