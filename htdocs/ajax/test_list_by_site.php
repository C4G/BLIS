<?php
#
# Returns HTML check boxes containing compatible test types
# Called via Ajax from new_specimen.php
#

include("../includes/db_lib.php");

LangUtil::setPageId("test_list_by_site");
?>
<style type="text/css">
.hor-minimalist-compact
{
	font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
	font-size: 12px;
	background: #fff;
	width: 480px;
	border-collapse: collapse;
	text-align: left;
        padding: 6px 4px;
}

.hor-minimalist-compact th
{
	font-size: 14px;
	font-weight: normal;
	color: #039;
	 padding: 6px 4px;
	border-bottom: 2px solid #6678b1;
}
.hor-minimalist-compact td
{
	color: #669;
	padding: 2px 6px 0px 6px;
}

.hor-minimalist-compact tbody tr:hover td
{
	/*color: #009;*/
}
</style>
<?
$site_id = $_REQUEST['site_id'];
$test_type_list = get_test_types_by_site($site_id);
/*if($site_id <= 0)
{
    echo 'Select Facility to display its Test Catalog here';
    return;
}
*/
if(count($test_type_list) == 0)
{
	# No compatible tests exist in the configuration
	?>
        <br>
	<span class='clean-error uniform_width'>
		<?php echo 'Test Catalog is empty for this site'; ?>
	</span>
	<?php
	return;
}
?>
<table style='width:auto;' class='hor-minimalist-compact'>
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
                    <?php
                        echo "<input type='checkbox' name='itest[".$site_id."][".$test_type->testTypeId."]' id='$elem_id' value='Yes'>";
			echo $test_type->getName();
                        echo "</input>";
                        ?>
		</td>
	</tr>
	</table>
	</td>
	<?php
	$count++;
	if($count % 3 == 0)
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