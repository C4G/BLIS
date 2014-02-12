<?php
#
# Returns HTML check boxes containing compatible test types
# Called via Ajax from new_specimen.php
#

include("../includes/db_lib.php");

LangUtil::setPageId("new_specimen");

$specimen_type_id = $_REQUEST['stype'];
$lab_config_id = $_SESSION['lab_config_id'];
$test_type_list = get_compatible_test_types($lab_config_id, $specimen_type_id);

if(count($test_type_list) == 0)
{
	# No compatible tests exist in the configuration
	?>
	<span class='clean-error uniform_width'>
		<?php echo LangUtil::$pageTerms['MSG_NOTESTMATCH']; ?>
	</span>
	<?php
	return;
}
?>
<table style='width:auto;' class='no_spacing'>
<tbody>
<tr valign='top'>
<?php
$count = 0;
foreach($test_type_list as $test_type)
{
?>
	<td>
	<table>
	<tr valign='top'>
		<td>
			<input type='checkbox' name='t_type_list[]' class='t_type_list' 
			 id='t_type_list_<?php echo $count; ?>' 
			 value='<?php echo $test_type->testTypeId; ?>'
			 <?php
			 # If only one checkbox, select it
			 if(count($test_type_list) == 1)
				echo " checked ";
			 ?>
			>
			</input>
		</td>
		<td>
			<?php echo $test_type->getName(); ?>
		</td>
	</tr>
	</table>
	</td>
	<?php
	$count++;
	if($count % 2 == 0)
	{
	?>
		</tr>
		<tr>
	<?php
	}
}
?>
</tbody>
</table>