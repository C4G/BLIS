<?php
#
# Returns a list of test type for a perticular section with fields for columns widths
# Called via Ajax from worksheet_custom_new.php
#

include("../includes/db_lib.php");
include("../includes/page_elems.php");
LangUtil::setPageId("lab_config_home");
$page_elems = new PageElems();

$lab_config_id = $_REQUEST['lid'];
$lab_config = LabConfig::getById($lab_config_id);
$cat_code = $_REQUEST['cat'];

$test_type_list = get_test_types_by_site_category($lab_config_id, $cat_code);
if($test_type_list == null || count($test_type_list) == 0)
{
	echo "<div class='sidetip_nopos' >";
	echo LangUtil::$generalTerms['MSG_NOTFOUND'];
	echo "</div>";
	echo "<br><br>";
	return;
}
foreach($test_type_list as $test_type)
{
	$measure_list = $test_type->getMeasures();
	?>
	<div>
	<input type='checkbox' class='test_type_checkbox' name='ttype_<?php echo $test_type->testTypeId; ?>' id='ttype_<?php echo $test_type->testTypeId; ?>'>
	<?php echo $test_type->getName(); ?>
	</input>
	<br>
		<div id='ttype_<?php echo $test_type->testTypeId; ?>_mlist' style='position:relative; margin-left:15px;display:none;'>
		<table class='hor-minimalist-b'>
			<thead>
			<tr>
				<th style='width:200px;'><?php echo LangUtil::$generalTerms['MEASURES']; ?></th>
				<th><?php echo LangUtil::$pageTerms['COLUMN_WIDTH']; ?> (%)</th>
			</tr>
			<?php
			foreach($measure_list as $measure)
			{
				?>
				<tr>
					<td>
						<?php echo $measure->getName(); ?>
					</td>
					<td>
						<input type='text' size='2' name='width_<?php echo $test_type->testTypeId."_".$measure->measureId; ?>' value='<?php echo CustomWorksheet::$DEFAULT_WIDTH; ?>'>
						</input>
					</td>
				</tr>
				<?php
			}
			?>
			</thead>
			<tbody>
			</tbody>
		</table>
		</div>
	</div>
	<br>
<?php
}
?>