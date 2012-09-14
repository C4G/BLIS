<?php
#
# Main page for modifying an existing test type
#
include("redirect.php");
include("includes/header.php");
include("includes/ajax_lib.php");
LangUtil::setPageId("catalog");

$script_elems->enableJQueryForm();
$script_elems->enableTokenInput();

# Helper function
function specimen_list_to_json($specimen_list)
{
	$json_params = array('id', 'name');
	$assoc_list = array();
	foreach($specimen_list as $specimen_id)
	{
		$specimen = get_specimen_type_by_id($specimen_id);
		$specimen_type_id = $specimen->specimenTypeId;
		$specimen_name = $specimen->getName();
		$assoc_list[$specimen_type_id] = $specimen_name;
	}
	return list_to_json($assoc_list, $json_params);
}
?>

<br>
<?php
//$tips_string=LangUtil::$pageTerms['TIPS_MEASURES'];
//$tips_string = LangUtil::$pageTerms['TIPS_CATALOG'];
$tips_string="Numeric ranges can be specified as 'lower:upper'.\nFor e.g., if the valid range lies between 0 and 1000, please enter '0:1000'. Alphanumeric values can be specified as 'value1/value2/value3'. 
For e.g., if test results can be either one from 'P','N' or 'D', please enter 'P/N/D'.";
$page_elems->getSideTip("Tips", $tips_string);
?>
<b><?php echo LangUtil::$pageTerms['EDIT_TEST_TYPE']; ?></b>
| <a href="catalog.php?show_t=1"><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a>
<br><br>

<?php
$test_type = get_test_type_by_id($_REQUEST['tid']);
if($test_type == null)
{
?>
	<div class='sidetip_nopos'>
	<?php echo LangUtil::$generalTerms['MSG_NOTFOUND']; ?>
	</div>
<?php
	include("includes/footer.php");
	return;
}
# Fetch all measures currently on this test type
$measure_list = $test_type->getMeasureIds();
# Display test type info table
$page_elems->getTestTypeInfo($test_type->name, true);
?>
<script type='text/javascript'>
var num_measures = 0;

var num_ranges = new Array();
for(var k = 0; k < 100; k++)
{
	num_ranges[k] = 0;
}

$(document).ready(function(){
	$('#new_category').hide();
	$('#cat_code').attr("value", "<?php echo $test_type->testCategoryId; ?>");
	<?php
	$specimen_list = get_compatible_specimens($test_type->testTypeId);
	foreach($specimen_list as $specimen_type_id)
	{
		# Mark existing compatible specimens as checked
		?>
		$('#s_type_<?php echo $specimen_type_id; ?>').attr("checked", "checked");
		<?php
	}
	?>
	$('.range_select').change( function() {
		toggle_range_type(this);
	});
	$('.new_range_select').change( function() {
		toggle_new_range_type(this);
	});
});

function toggle_range_type(select_elem)
{
	var elem_id = select_elem.id;
	$('.values_section_'+elem_id).hide();
	if(select_elem.value == <?php echo Measure::$RANGE_OPTIONS; ?>)
		$('#alpha_'+elem_id).show();	
	else if(select_elem.value == <?php echo Measure::$RANGE_NUMERIC; ?>)
		$('#val_'+elem_id).show();
	else if(select_elem.value == <?php echo Measure::$RANGE_AUTOCOMPLETE; ?>)
		$('#autocomplete_'+elem_id).show();	
}


function toggle_new_range_type(select_elem)
{
	var elem_id = select_elem.id;
	$('.new_values_section_'+elem_id).hide();
	if(select_elem.value == <?php echo Measure::$RANGE_OPTIONS; ?>)
		$('#new_alpha_'+elem_id).show();	
	else if(select_elem.value == <?php echo Measure::$RANGE_NUMERIC; ?>)
		$('#new_val_'+elem_id).show();
	else if(select_elem.value == <?php echo Measure::$RANGE_AUTOCOMPLETE; ?>)
		$('#new_autocomplete_'+elem_id).show();	
}

function add_option_field(mrow_num)
{
	var html_code = " / <input type='text' class='range_field' name='alpharange_"+mrow_num+"[]' value='' />";
	$('#alpha_list_'+mrow_num).append(html_code);
}

function add_autocomplete_field(mrow_num)
{
	var html_code = "<input type='text' class='uniform_width' name='autocomplete_"+mrow_num+"[]' value='' /><br>";
	$('#autocomplete_list_'+mrow_num).append(html_code);
}

function update_ttype()
{
	if($('#name').attr("value").trim() == "")
	{
		alert("<?php echo LangUtil::$pageTerms['TIPS_MISSING_TESTNAME']; ?>");
		return;
	}
	if($('#cat_code').attr("value") == -1)
	{
		if($('#new_category_textbox').attr("value").trim() == "")
		{
			alert("<?php echo LangUtil::$pageTerms['TIPS_MISSING_CATNAME']; ?>");
			return;
		}
	}
	var is_panel = <?php if($test_type->isPanel == true) echo "true"; else echo "false"; ?>;
	if(is_panel == false)
	{
		var measure_elems = $("input[name='measure[]']");
		var range_type_elems = $("select[name='mtype[]']");
		var measure_entered = false;
		for(var j = 0; j < measure_elems.length; j++)
		{		
			if(measure_elems[j].value.trim() != "")
			{  
				measure_entered = true;
				if(range_type_elems[j].value == <?php echo Measure::$RANGE_NUMERIC; ?>)
				{
					// Check numeric ranges
					// Check all age ranges specified
					var range_l_elems = $("input[name='range_l_"+(j+1)+"[]']");
					
					var range_u_elems = $("input[name='range_u_"+(j+1)+"[]']");
					for(var k = 0; k < range_l_elems.length; k++)
					{
						var range_l = range_l_elems[k].value;
						var range_u = range_u_elems[k].value;
						if(range_l.trim() == "" )//|| isNaN(range_l))
						{
							
							//alert("<?php echo LangUtil::$generalTerms['INVALID']." ".LangUtil::$generalTerms['RANGE']; ?>: '"+range_l+"'!");
							//return;
						}
						if(isNaN(range_u))
						{
						//alert(range_u);
						//if(range_u.indexOf("/")!=-1)
						//alert("founr");
							//alert("<?php echo LangUtil::$generalTerms['INVALID']." ".LangUtil::$generalTerms['RANGE']; ?>: '"+range_u+"'!!");
							//return;
						}
						if($("#agerange_l_"+(j+1)+"_"+k).is(":disabled") == true)
						{
							continue;
						}
						var lower_value = $("#agerange_l_"+(j+1)+"_"+k).attr("value");
						var upper_value = $("#agerange_u_"+(j+1)+"_"+k).attr("value");
						if(lower_value == undefined || upper_value == undefined)
						{
							continue;
						}
						if(lower_value.trim() == "" && lower_value.trim() == "")
						{
							continue;
						}
						else if(lower_value.trim() == "" || upper_value.trim() == "")
						{
							alert("<?php echo LangUtil::$generalTerms['INVALID']." ".LangUtil::$generalTerms['AGE']; ?>: '"+lower_value+"':'"+upper_value+"'");
							return;
						}
						else if(isNaN(lower_value))
						{
							alert("<?php echo LangUtil::$generalTerms['INVALID']." ".LangUtil::$generalTerms['AGE']; ?>: '"+lower_value+"'");
							return;
						}
						else if(isNaN(upper_value))
						{
							alert("<?php echo LangUtil::$generalTerms['INVALID']." ".LangUtil::$generalTerms['AGE']; ?>: '"+upper_value+"'");
							return;
						}
					}
				}
				else if(range_type_elems[j].value == <?php echo Measure::$RANGE_OPTIONS; ?>)
				{
					//Check option values
					var option_elems = $("input[name='alpharange_"+(j+1)+"[]']");
					var option_exist = false;
					
					for(var k = 0; k < option_elems.length; k++)
					{
						var option_val = option_elems[k].value;
						
						
						if(option_val.trim() != "")
						{
							option_exist = true;
							break
						}
						
						
					}
					if(option_exist == false)
					{
						alert("<?php echo LangUtil::$generalTerms['INVALID']." ".LangUtil::$generalTerms['DROPDOWN']; ?>");
						return;
					}
				}
				else if(range_type_elems[j].value == <?php echo Measure::$RANGE_AUTOCOMPLETE; ?>)
				{
					//Check autocomplete values
					var option_elems = $("input[name='autocomplete_"+(j+1)+"[]']");
					var option_exist = false;
					for(var k = 0; k < option_elems.length; k++)
					{
						var option_val = option_elems[k].value;
						if(option_val.trim() != "")
						{
							option_exist = true;
							break
						}
					}
					if(option_exist == false)
					{
						alert("<?php echo LangUtil::$generalTerms['INVALID']." ".LangUtil::$generalTerms['RANGE_AUTOCOMPLETE']; ?>");
						return;
					}
				}
			}
		}
		if(measure_entered == false)
		{
			alert("<?php echo LangUtil::$pageTerms['TIPS_MISSING_SELECTEDMEASURES']; ?>");
			return;
		}
	}
	else
	{
		//TODO: Panel tests validation
		/*
		var mtype_entries = $('.m_entry');
		var mtype_selected = false;
		for(var i = 0; i < mtype_entries.length; i++)
		{
			if(mtype_entries[i].checked)
			{
				mtype_selected = true;
				break;
			}
		}
		if(mtype_selected == false)
		{
			alert("Error: No measures selected for panel test");
			return;
		}
		*/
	}
	var stype_entries = $('.stype_entry');
	var stype_selected = false;
	for(var i = 0; i < stype_entries.length; i++)
	{
		if(stype_entries[i].checked)
		{
			stype_selected = true;
			break;
		}
	}
	if(stype_selected == false)
	{
		alert("<?php echo LangUtil::$pageTerms['TIPS_MISSING_SELECTEDSPECIMEN']; ?>");
		return;
	}
	$('#update_ttype_progress').show();
	$('#edit_ttype_form').ajaxSubmit({
		success: function(msg) {
			$('#update_ttype_progress').hide();
			window.location="test_type_updated.php?tid=<?php echo $_REQUEST['tid']; ?>";
		}
	});
}

function check_if_new_category(select_obj)
{
	var value = $('#cat_code').val();
	if(value == -1)
	{
		$('#new_category').show();
	}
	else
	{
		$('#new_category_textbox').val("");
		$('#new_category').hide();
	}
}

function add_new_measure()
{
	num_measures++;
	$('#new_mrow_'+num_measures).show();
}

function add_new_option_field(mrow_num)
{
	var html_code = " / <input type='text' class='range_field' name='new_alpharange_"+mrow_num+"[]' value='' />";
	$('#new_alpha_list_'+mrow_num).append(html_code);
}

function add_new_autocomplete_field(mrow_num)
{
	var html_code = "<input type='text' class='uniform_width' name='new_autocomplete_"+mrow_num+"[]' value='' /><br>";
	$('#new_autocomplete_list_new_'+mrow_num).append(html_code);
}

function add_range_field(mrow_num, map_offset)
{
	if(num_ranges[mrow_num] == 0)
	{
		num_ranges[mrow_num] += map_offset;
	}
	else
	{
		num_ranges[mrow_num]++;
	}
	var num_row = num_ranges[mrow_num];
	var html_code = "<?php echo LangUtil::$generalTerms['RANGE']; ?><input type='text' class='range_field' name='range_l_"+mrow_num+"[]' value='' /> : <input type='text' class='range_field' name='range_u_"+mrow_num+"[]' value='' /><br><input type='hidden' name='bygender_"+mrow_num+"_"+num_row+"' value='B' ></input><br><br>";
	$('#numeric_'+mrow_num).append(html_code);
}

function toggle_agerange(measure_num, row_num)
{
	var field_id = "agerange_l_"+measure_num+"_"+row_num;
	if($('#'+field_id).is(":disabled") == false)
	{
		$('#'+field_id).attr("disabled", "true");
	}
	else
	{
		$('#'+field_id).removeAttr("disabled");
	}
	field_id = "agerange_u_"+measure_num+"_"+row_num;
	if($('#'+field_id).is(":disabled") == false)
	{
		$('#'+field_id).attr("disabled", "true");
	}
	else
	{
		$('#'+field_id).removeAttr("disabled");
	}	
}
</script>
<style type='text/css'>
.range_field {
	width:30px;
}
</style>
<br>
<br>

<div class='pretty_box'>
<form name='edit_ttype_form' id='edit_ttype_form' action='ajax/test_type_update.php' method='post'>
<input type='hidden' name='ispanel' 
value='<?php if($test_type->isPanel === true) echo "1"; else echo "0"; ?>'></input>
<input type='hidden' name='tid' id='tid' value='<?php echo $_REQUEST['tid']; ?>'></input>
	<table cellspacing='4px'>
		<tbody>
			
			<tr valign='top'>
				<td><?php echo LangUtil::$generalTerms['NAME']; ?><?php $page_elems->getAsterisk(); ?></td>
				<td><input type='text' name='name' id='name' value='<?php echo $test_type->name; ?>' class='uniform_width'></input></td>
			</tr>
			<tr valign='top'>
				<td><?php echo LangUtil::$generalTerms['LAB_SECTION']; ?><?php $page_elems->getAsterisk(); ?></td>
				<td>
				<SELECT name='cat_code' id='cat_code' onchange="javascript:check_if_new_category(this);" class='uniform_width'>
					<?php $page_elems->getTestCategorySelect(); ?>
					<option value='-1'>--<?php echo LangUtil::$pageTerms['NEW_LAB_SECTION']; ?>--</option>
				</select>
				&nbsp;&nbsp;&nbsp;
				<span id='new_category'>
					<small><?php echo LangUtil::$generalTerms['NAME']; ?></small>&nbsp;
					<input type='text' id='new_category_textbox' name='new_category' class='uniform_width' />
				</span>
				</td>
			</tr>
			<tr valign='top'>
				<td><?php echo LangUtil::$generalTerms['DESCRIPTION']; ?></td>
				<td><textarea type='text' name='description' id='description' class='uniform_width'><?php echo trim($test_type->description); ?></textarea></td>
			</tr>
			<?php
			# TODO: Add option to manage panel tests or add new measures
			if($test_type->isPanel == true)
			{
				# TODO: Show panel test options
			}
			else
			{
				?>
				<tr valign='top'>
					<td><?php echo LangUtil::$generalTerms['MEASURES']; ?> [<a href='#measures_help' rel='facebox'>?</a>]</td>
					<td>
						<table id='new_measure_list' class='smaller_font'>
							<tr>
								<td><u>Delete</u></td>
								<td><u><?php echo LangUtil::$generalTerms['NAME']; ?><?php $page_elems->getAsterisk(); ?></u></td>
								<td><u><?php echo LangUtil::$generalTerms['TYPE']; ?><?php $page_elems->getAsterisk(); ?></u></td>
								<td><u><?php echo LangUtil::$generalTerms['VALUES']; ?><?php $page_elems->getAsterisk(); ?></u></td>
								<td><u><?php echo LangUtil::$generalTerms['UNIT']; ?> /Default Value</u></td>
							</tr>
							<?php
							$max_num_measures = count($measure_list);
							for($i = 1; $i <= $max_num_measures; $i += 1)
							{
								$curr_measure = Measure::getById($measure_list[$i-1]);
								$ref_ranges = $curr_measure->getReferenceRanges($_SESSION['lab_config_id']);
								?>
								<input type='hidden' name='m_id[]' value='<?php echo $measure_list[$i-1]; ?>'></input>
								<?php
								echo "<tr valign='top' id='mrow_$i' ";
								echo ">";
								echo "<td align='center'>";
								echo "<input type=checkbox name='delete_".$curr_measure->measureId."'  />";
								echo "</td><td>";
								echo "<input type='text' name='measure[]' value='$curr_measure->name' />";
								echo "</td>";
								echo "<td>";
								$range_string = $curr_measure->range;
								$range_values = array();
								$range_type = $curr_measure->getRangeType();
								switch($range_type)
								{
									case Measure::$RANGE_NUMERIC:
										$range_values = explode(":", $range_string);
										break;
									case Measure::$RANGE_OPTIONS:
										$range_values = explode("/", $range_string);
										break;
									case Measure::$RANGE_AUTOCOMPLETE:
										$range_values = explode("_", $range_string);
										break;									
								}
								?>
								<select class='range_select' id='<?php echo $i; ?>' name='mtype[]'>
									<option value='<?php echo Measure::$RANGE_NUMERIC; ?>' <?php 
									if($range_type == Measure::$RANGE_NUMERIC)
										echo " selected='selected' ";
									?>><?php echo LangUtil::$generalTerms['RANGE_NUMERIC']; ?></option>
									<option value='<?php echo Measure::$RANGE_OPTIONS; ?>' <?php 
									if($range_type == Measure::$RANGE_OPTIONS)
										echo " selected='selected' ";
									?>><?php echo LangUtil::$generalTerms['RANGE_ALPHANUM']; ?></option>
									<option value='<?php echo Measure::$RANGE_AUTOCOMPLETE; ?>' <?php 
									if($range_type == Measure::$RANGE_AUTOCOMPLETE)
										echo " selected='selected' ";
									?>><?php echo LangUtil::$generalTerms['RANGE_AUTOCOMPLETE']; ?></option>
								</select>
								<?php
								echo "</td>";
								echo "<td>";
								?>
								<span id='val_<?php echo $i; ?>' class='values_section_<?php echo $i; ?>'
								<?php if($range_type != Measure::$RANGE_NUMERIC) echo " style='display:none' "; ?>
								>
									<?php
									
									$ref_count = 0;
									if(count($ref_ranges) == 0 || $ref_ranges == null)
									{
										# Reference ranges not configured. 
										# Fetch default values from 'measure' table
										$lower_range="";
										$upper_range="";
										if($range_type == Measure::$RANGE_NUMERIC)
										{
											$lower_range = $range_values[0];
											$upper_range = $range_values[1];
										}
										?>
										<span id='numeric_<?php echo $i; ?>'>
											<?php echo LangUtil::$generalTerms['RANGE']; ?>
											<input type='text' class='range_field' name='range_l_<?php echo $i; ?>[]' value='<?php echo $lower_range; ?>' /> :
											<input type='text' class='range_field' name='range_u_<?php echo $i; ?>[]' value='<?php echo $upper_range; ?>' />
											<br>
							
											<!--<?php echo LangUtil::$generalTerms['AGE']; ?>&nbsp;&nbsp;&nbsp;&nbsp;
											<input type='text' class='range_field agerange_l_<?php echo $i; ?>' name='agerange_l_<?php echo $i; ?>_0' id='agerange_l_<?php echo $i; ?>_0' value='' /> :
											<input type='text' class='range_field agerange_u_<?php echo $i; ?>' name='agerange_u_<?php echo $i; ?>_0' id='agerange_u_<?php echo $i; ?>_0' value='' />
											&nbsp; <input type='checkbox' checked onchange='javascript:toggle_agerange(<?php echo $i; ?>, 0);'></input>
											<br>
											<input type='radio' name='bygender_<?php echo $i; ?>_0' value='M'><?php echo LangUtil::$generalTerms['MALE']; ?></input>
											<input type='radio' name='bygender_<?php echo $i; ?>_0' value='F'><?php echo LangUtil::$generalTerms['FEMALE']; ?></input>-->
											<input type='hidden' name='bygender_<?php echo $i; ?>_0' value='B' ></input>
											<br><br>
										</span>
									<?php
									}
									else
									{
										?>
										<span id='numeric_<?php echo $i; ?>'>
										<?php
										# Use values from 'reference_range' table
										foreach($ref_ranges as $ref_range)
										{
											?>
											<?php echo LangUtil::$generalTerms['RANGE']; ?>
											<input type='text' class='range_field' name='range_l_<?php echo $i; ?>[]' value='<?php echo $ref_range->rangeLower; ?>' /> :
											<input type='text' class='range_field' name='range_u_<?php echo $i; ?>[]' value='<?php echo $ref_range->rangeUpper ?>' />
											<br>
											<!--<?php echo LangUtil::$generalTerms['AGE']; ?>&nbsp;&nbsp;&nbsp;&nbsp;
											<input type='text' class='range_field agerange_l_<?php echo $i; ?>' name='agerange_l_<?php echo $i; ?>_<?php echo $ref_count; ?>' id='agerange_l_<?php echo $i; ?>_<?php echo $ref_count; ?>' value='<?php echo $ref_range->ageMin; ?>' /> :
											<input type='text' class='range_field agerange_u_<?php echo $i; ?>' name='agerange_u_<?php echo $i; ?>_<?php echo $ref_count; ?>' id='agerange_u_<?php echo $i; ?>_<?php echo $ref_count; ?>' value='<?php echo $ref_range->ageMax; ?>' />
											&nbsp; <input type='checkbox' checked onchange='javascript:toggle_agerange(<?php echo $i; ?>, <?php echo $ref_count; ?>);'></input>
											<br>
											<input type='radio' name='bygender_<?php echo $i; ?>_<?php echo $ref_count; ?>' value='M' <?php
											if($ref_range->sex == 'M')
												echo " checked ";
											?>><?php echo LangUtil::$generalTerms['MALE']; ?></input>
											<input type='radio' name='bygender_<?php echo $i; ?>_<?php echo $ref_count; ?>' value='F' <?php
											if($ref_range->sex == 'F')
												echo " checked ";
											?>><?php echo LangUtil::$generalTerms['FEMALE']; ?></input>
											<input type='radio' name='bygender_<?php echo $i; ?>_<?php echo $ref_count; ?>' value='B' <?php
											if($ref_range->sex == 'B')
												echo " checked ";
											?>>Both</input>
											<br><br>-->
											<?php
											$ref_count++;
										}
										?>
										</span>
										<?php
									}
									?>							
									<!--<small><a href="javascript:add_range_field('<?php echo $i; ?>',<?php echo $ref_count+1; ?>);"><?php echo LangUtil::$generalTerms['ADDANOTHER']; ?> &raquo;</a></small>
									<br><br>-->
								</span>
								<span id='alpha_<?php echo $i; ?>' class='values_section_<?php echo $i; ?>'
								<?php if($range_type != Measure::$RANGE_OPTIONS) echo " style='display:none' "; ?>
								>
									<span id='alpha_list_<?php echo $i; ?>'>
									<?php
										$j = 0;
										foreach($range_values as $range_value)
										{ $range_value= str_replace("#", "/", $range_value);
											$j++;
										?>
											<input type='text' class='range_field' name='alpharange_<?php echo $i; ?>[]' value='<?php if($range_type == Measure::$RANGE_OPTIONS) echo str_replace("#", "/", $range_value); ?>' /> 
										<?php
											if($j < count($range_values))
												echo "/ ";
										}
										?>
									</span>
									<br>
									<small><a href="javascript:add_option_field('<?php echo $i; ?>');"><?php echo LangUtil::$generalTerms['ADDANOTHER']; ?> &raquo;</a></small>
								</span>
								<span id='autocomplete_<?php echo $i; ?>' class='values_section_<?php echo $i; ?>'
								<?php if($range_type != Measure::$RANGE_AUTOCOMPLETE) echo " style='display:none' "; ?>
								>
									<span id='autocomplete_list_<?php echo $i; ?>'>
									<?php
										$j = 0;
										foreach($range_values as $range_value)
										{
											$j++;
										?>
											<input type='text' class='uniform_width' name='autocomplete_<?php echo $i; ?>[]' value='<?php if($range_type == Measure::$RANGE_AUTOCOMPLETE) echo $range_value; ?>' /> <br>
										<?php
										}
										?>
									</span>
									<small><a href="javascript:add_autocomplete_field('<?php echo $i; ?>');"><?php echo LangUtil::$generalTerms['ADDANOTHER']; ?> &raquo;</a></small>
								</span>
								<?php
								echo "</td>";
								echo "<td id='unit_$i'>";
								echo "<input type='text' name='unit[]' value='$curr_measure->unit' />";
								echo "</td>";
								echo "</tr>";
								
							}
							# Space for adding new measures
							$max_num_measures = 10;
							for($i = 1; $i <= $max_num_measures; $i += 1)
							{
								echo "<tr valign='top' id='new_mrow_$i' ";
								//if($i != 1)
								if(true)
								{
									# Hide all rows except the first
									echo " style='display:none;' ";
								}
								echo ">";
								echo "<td align='center'>";
								//echo "<input type=checkbox name='$curr_measure->name'  />";
								echo "</td><td>";
								echo "<input type='text' name='new_measure[]' value='' />";
								echo "</td>";
								echo "<td>";
								?>
								<select class='new_range_select' id='new_<?php echo $i; ?>' name='new_mtype[]'>
									<option value='<?php echo Measure::$RANGE_NUMERIC; ?>'><?php echo LangUtil::$generalTerms['RANGE_NUMERIC']; ?></option>
									<option value='<?php echo Measure::$RANGE_OPTIONS; ?>'><?php echo LangUtil::$generalTerms['RANGE_ALPHANUM']; ?></option>
									<option value='<?php echo Measure::$RANGE_AUTOCOMPLETE; ?>'><?php echo LangUtil::$generalTerms['RANGE_AUTOCOMPLETE']; ?></option>
								</select>
								<?php
								echo "</td>";
								echo "<td>";
								?>
								<span id='new_val_new_<?php echo $i; ?>' class='new_values_section_new_<?php echo $i; ?>'>
									<span id='numeric_<?php echo $i; ?>'>
										<?php echo LangUtil::$generalTerms['RANGE']; ?>
										<input type='text' class='range_field' name='new_range_l_<?php echo $i; ?>[]' value='' /> :
										<input type='text' class='range_field' name='new_range_u_<?php echo $i; ?>[]' value='' />
										<!--<br>
										<?php echo LangUtil::$generalTerms['AGE']; ?>&nbsp;&nbsp;&nbsp;&nbsp;
										<input type='text' class='range_field agerange_l_<?php echo $i; ?>' name='new_agerange_l_<?php echo $i; ?>_0' id='agerange_l_<?php echo $i; ?>_0' value='' /> :
										<input type='text' class='range_field agerange_u_<?php echo $i; ?>' name='new_agerange_u_<?php echo $i; ?>_0' id='agerange_u_<?php echo $i; ?>_0' value='' />
										&nbsp; <input type='checkbox' checked onchange='javascript:toggle_agerange(<?php echo $i; ?>, 0);'></input>
										<br>
										<input type='radio' name='new_bygender_<?php echo $i; ?>_0' value='M'><?php echo LangUtil::$generalTerms['MALE']; ?></input>
										<input type='radio' name='new_bygender_<?php echo $i; ?>_0' value='F'><?php echo LangUtil::$generalTerms['FEMALE']; ?></input>-->
										<input type='hidden' name='new_bygender_<?php echo $i; ?>_0' value='B' ></input>
										<!--<br><br>-->
									</span>
									<!--<small><a href="javascript:add_range_field('<?php echo $i; ?>', 0);"><?php echo LangUtil::$generalTerms['ADDANOTHER']; ?> &raquo;</a></small>
									<br><br>-->
								</span>	
								<span id='new_alpha_new_<?php echo $i; ?>' style='display:none' class='new_values_section_new_<?php echo $i; ?>'>
									<span id='new_alpha_list_<?php echo $i; ?>'>
										<input type='text' class='range_field' name='new_alpharange_<?php echo $i; ?>[]' value='' /> /
										<input type='text' class='range_field' name='new_alpharange_<?php echo $i; ?>[]' value='' />
									</span>
									<br>
									<small><a href="javascript:add_new_option_field('<?php echo $i; ?>');"><?php echo LangUtil::$generalTerms['ADDANOTHER']; ?> &raquo;</a>
								</span>
								<span id='new_autocomplete_new_<?php echo $i; ?>' style='display:none' class='new_values_section_new_<?php echo $i; ?>'>
									<span id='new_autocomplete_list_new_<?php echo $i; ?>'>
										<input type='text' class='uniform_width' name='new_autocomplete_<?php echo $i; ?>[]' value='' /><br>
										<input type='text' class='uniform_width' name='new_autocomplete_<?php echo $i; ?>[]' value='' /><br>
									</span>
									<small><a href="javascript:add_new_autocomplete_field('<?php echo $i; ?>');"><?php echo LangUtil::$generalTerms['ADDANOTHER']; ?> &raquo;</a>
								</span>
								<?php
								echo "</td>";
								echo "<td id='unit_$i'>";
								echo "<input type='text' name='new_unit[]' value='' />";
								echo "</td>";
								echo "</tr>";
							}
						?>
						</table>
						<a id='new_measure_link' href='javascript:add_new_measure();'><?php echo LangUtil::$generalTerms['ADDANOTHER']; ?> &raquo;</a>
					</td>
				</tr>
				<?php
			}
			?>
			<tr valign='top'>
				<td><?php echo LangUtil::$generalTerms['COMPATIBLE_SPECIMENS']; ?><?php $page_elems->getAsterisk(); ?></td>
				<td>
					<?php $page_elems->getSpecimenTypeCheckboxes(); ?>
					<br>
				</td>
			</tr>
			
			<tr valign='top'>
				<td></td>
				<td>
					<br><br>
					<input type='button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' onclick='javascript:update_ttype();'></input>
					&nbsp;&nbsp;&nbsp;
					<a href='catalog.php?show_t=1'><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a>
					&nbsp;&nbsp;&nbsp;
					<span id='update_ttype_progress' style='display:none;'>
						<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
					</span>
				</td>
			</tr>
		</tbody>
	</table>
</form>
</div>
<div id='measures_help' style='display:none'>
<small>
<b><?php echo LangUtil::$generalTerms['MEASURES']; ?></b>
<br><br>
Valid result ranges can be entered for each measure in the 'range' field. 
<br><br>
<u>Numeric ranges</u> can be specified as 'lower:upper'. 
For e.g., if the valid range lies between 0 and 1000, please enter '0:1000'. 
<br><br>
<u>Alphanumeric values</u> can be specified as 'value1/value2/value3'. 
For e.g., if test results can be either one from 'P','N' or 'D', please enter 'P/N/D'.
</small>
</div>
<?php include("includes/footer.php"); ?>