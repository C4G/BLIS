<?php
#
# Main page for adding new test type form
#
include("redirect.php");
include("includes/header.php");
LangUtil::setPageId("catalog");

putUILog('test_type_new', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');


$script_elems->enableLatencyRecord();
?>
<script type='text/javascript'>
var num_measures = 1;
var num_submeasures = new Array(100);
var len = 100;
 while (--len >= 0) {
        num_submeasures[len] = 0;
    }

var num_ranges = new Array();
for(var k = 0; k < 100; k++)
{
	num_ranges[k] = 0;
}

$(document).ready(function() {
	$('#new_category').hide();
	$('#new_entries').show();
	$('.panel_row').hide();
	$('#ispanel').change( function() {
		toggle_panel();
	});
	$('.range_select').change( function() {
		toggle_range_type(this);
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
        else if(select_elem.value == <?php echo Measure::$RANGE_FREETEXT; ?>)
		$('#freetext_'+elem_id).show();
                
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

function add_freetext_field(mrow_num)
{
	var html_code = "<input type='text' class='uniform_width' name='freetext_"+mrow_num+"[]' value='' /><br>";
	$('#freetext_list_'+mrow_num).append(html_code);
}


function add_range_field(mrow_num)
{

		num_ranges[mrow_num]++;

	var num_row = num_ranges[mrow_num];
	
//		var map=map_offset-1;									
	var html_code = "<input type='text' class='range_field' name='range_l_"+mrow_num+"[]' value='' /> : <input type='text' class='range_field' name='range_u_"+mrow_num+"[]' value='' /> <input type='text' class='range_field' name='gender_"+mrow_num+"[]' value='B'/> <input type='text' class='range_field agerange_l_"+mrow_num+"' name='agerange_l_"+mrow_num+"[]' id='agerange_l_"+mrow_num+"[]' value='0' /> : <input type='text' class='range_field agerange_u_"+mrow_num+"' name='agerange_u_"+mrow_num+"[]' id='agerange_u_"+mrow_num+"[]' value='100' /> <br>";
	$('#numeric_'+mrow_num).append(html_code);
}

function toggle_panel()
{
	var checkbox_val = $('#ispanel').attr("checked");
	if(checkbox_val == true)
	{
		$('.panel_row').show();
		$('.nonpanel_row').hide();
	}
	else
	{
		$('.panel_row').hide();
		$('.nonpanel_row').show();
	}
}

function show_new_measure_elems()
{
	$('#new_measure_list').show();
	$('#new_entries').show();
	$('#new_measure_link').show();
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
	$('#mrow_'+num_measures).show();
}

function add_new_submeasure(mrow_num)
{
	num_submeasures[mrow_num]++;
	$('#smrow_'+mrow_num+'_'+num_submeasures[mrow_num]).show();
}

function removeMeasure(measure_num)
{
	//alert("Submeasures:"+num_submeasures[measure_num]);
	$('#mrow_'+measure_num).hide();
	for(var i = 1; i <= num_submeasures[measure_num]; i++)
	{
		$('#smrow_'+measure_num+'_'+i).hide();		
		
	}
}

function removeSubMeasure(measure,submeasure)
{
	$('#smrow_'+measure+'_'+submeasure).hide();
}

 
function addRowToTable()
{
  var tbl = document.getElementById('tblSample');
  var lastRow = tbl.rows.length;
  // if there's no header row in the table, then iteration = lastRow + 1
  var iteration = lastRow;
  var row = tbl.insertRow(lastRow);
  // right cell
  var cellRight = row.insertCell(0);
  
  var el = document.createElement('input');
  el.type = 'text';
  el.name = 'txtRow' + iteration+'1';
  el.id = 'txtRow' + iteration+'1';
  el.size = 40;
  cellRight.appendChild(el);
  // select cell
  var cellRightSel = row.insertCell(1);
  var sel = document.createElement('input');
  sel.type = 'text';
  sel.name = 'txtRow' + iteration+'2';
  sel.id = 'txtRow' + iteration+'2';
  sel.size = 40;
  cellRightSel.appendChild(sel);
}

function removeRowFromTable()
{
  var tbl = document.getElementById('tblSample');
  var lastRow = tbl.rows.length;
  if (lastRow > 2) tbl.deleteRow(lastRow - 1);
}

function validateRow()
{
	var tbl = document.getElementById('tblSample');
    var lastRow = tbl.rows.length - 1;
	var i;
	var clinical_data;
	var aLeft= new Array();
	var aRight=new Array();
    for (i=1; i<=lastRow; i++) 
	{
       aLeft[i-1] = document.getElementById('txtRow' + i+1).value;
       aRight[i-1] = document.getElementById('txtRow' + i+2).value;
    }
	
		var total="";
		if(aLeft[0]!="")
	  total='%%%'+aLeft+'###'+aRight;
	  var data= $('#clinical_data').attr("value");
	  if(data!=""&& total!="")
	  {
	  clinical_data="!#!"+data+total;
	  }
	  else if(data!="-" && data!="")
	  {
	 clinical_data=data;
	  }
	  else if(total!="%%%")
	  clinical_data=total;
	  else 
	  clinical_data="";
	
	$('#clinical_data').attr("value",clinical_data);
	
  check_input();
  }
  
 function addData(list)
{
var dat=list.split('###');
var name=dat[0].split(',');
var valu =dat[1].split(',');
$('#extra').show();
$('#tblSample1').show();
for(var i=1; i<name.length+1;i++)
{
$('#txtRow'+i+'1').attr("value",name[i-1]);
$('#txtRow'+i+'2').attr("value",valu[i-1]);
addRowToTable();
}
removeRowFromTable();
}

 function addTable()
 {
if($('#extra').is(":visible")==true)
{
$('#extra').hide();
$('#tblSample1').hide();
$('#text').show();

}
	else
	{
	$('#tblSample1').show();
$('#extra').show();
$('#text').hide();
	}
}



function check_input()
{
	var test_name = $('#test_name').attr("value");
	if(test_name == "")
	{
		alert("<?php echo LangUtil::$pageTerms['TIPS_MISSING_TESTNAME']; ?>");
		return;
	}
	var cat_code = $('#cat_code').attr("value");
	var new_cat_name = $('#new_category_textbox').attr("value");
	if((cat_code == -1 && new_cat_name == "") || cat_code == -2)
	{
		alert("<?php echo LangUtil::$pageTerms['TIPS_MISSING_CATNAME']; ?>");
		return;
	}
	var checkbox_val = $('#ispanel').attr("checked");
	if(checkbox_val == true)
	{
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
			alert("<?php echo LangUtil::$pageTerms['TIPS_MISSING_SELECTEDMEASURES']; ?>");
			return;
		}
	}
	else
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
						if(range_l.trim()=="" && range_u.trim()=="")
						{
							alert("If you do not want to add new measure then please delete the name");
							return;
						}
						if(isNaN(range_l))
						{
							
							alert("Lower Range value should be numeric: Not '"+range_l+"'!");
							return;
						}
						if(isNaN(range_u))
						{
							
							alert("Upper Range value should be numeric: Not '"+range_u+"'!");
							return;
						}
						if((range_l.trim()== "")&&(isNaN(range_u)==false))
						{
						
							alert("Lower bound cannot be blank");
							return;
						}
						if((range_u.trim()== "")&&(isNaN(range_l)==false))
						{
						
							alert("Upper bound cannot be blank");
							return;
						}
						if((range_u.trim()-range_l.trim())<=0)
						{
							alert("Upper bound cannot be less than or equal to lower bound");
							return;
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
						if(lower_value.trim() == "" && upper_value.trim() == "")
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
						else if((upper_value.trim()-lower_value.trim())<=0)
						{
							alert("Age range cannot be negative.");
							return;
						}
						else if((upper_value.trim()== lower_value.trim()))
						{
							alert("Age range: Min age should not ne same as max age.");
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
	
	
	var check_url = "ajax/test_type_name_check.php?test_name="+test_name;
	$.ajax({ url: check_url, async : false, success: function(response){			
			if(response == "1")		
			{	
				alert("Test name: "+test_name + " already exist");				
			}
			else
			{
					// All OK
					$('#new_test_form').submit();
			}
	}
	});
	
	
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

function isInputNumber(evt) {
	var characterCode = (evt.which) ? evt.which : event.keyCode

	if (characterCode > 31 && (characterCode < 48 || characterCode > 57))
		return false;

	return true;
}

</script>

<style type='text/css'>
.range_field {
	width:30px;
}
</style>

<b><?php echo LangUtil::$pageTerms['NEW_TEST_TYPE']; ?></b>
| <a href='catalog.php?show_t=1'><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a>
<br><br>
<div class='pretty_box'>
<form name='new_test_form' id='new_test_form' action='test_type_add.php' method='post'>
<table class='smaller_font'>
	<tr>
		<td><?php echo LangUtil::$generalTerms['NAME']; ?> <?php $page_elems->getAsterisk(); ?></td>
		<td><input type='text' name='test_name' id='test_name' class='uniform_width' /> 
			</td>
	</tr>
	<tr>
		<td><?php echo LangUtil::$generalTerms['LAB_SECTION']; ?> <?php $page_elems->getAsterisk(); ?></td>
		<td>
			<SELECT name='cat_code' id='cat_code' onchange="javascript:check_if_new_category(this);" class='uniform_width'>
			<option value="-2">--<?php echo LangUtil::$generalTerms['CMD_SELECT']; ?>--</option>			
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
		<td><textarea name='test_descr' id='test_descr' class='uniform_width'></textarea></td>
	</tr>
	<tr valign='top'>
		<td>Clinical Data [<a href='#clinical_help' rel='facebox'>?</a>] </td><td>
			<div id="text">
			<textarea name='clinical_data' id='clinical_data' class='uniform_width'></textarea>
			</div>
		</td>
		</tr>
		<tr>
		<td>
		</td>
			<td>
			<div id="tblSample1" style="display:none" >
			<table border="1" id="tblSample">
			<tr>
			</tr>
			<tr>
				<td>
					<input type="text" name="txtRow11" id="txtRow11" size="40"  />
				</td>
				<td>
					<input type="text" name="txtRow12" id="txtRow12" size="40"  />
				</td>
			</tr>
			</table>
			<input type="button" value="Add" onclick="addRowToTable();" />
			<input type="button" value="Remove" onclick="removeRowFromTable();" />
			</div>
			</td>
			</div>
		
		</tr>
			
			<?php if((stripos($test_type->clinical_data ,"%%%"))===0)
			{
			$string=$test_type->clinical_data;
			$string=substr($string,3);
			echo "<script language=javascript>addData('$string')</script>";
			}
?>
	<tr valign='top'>
		<td><?php echo LangUtil::$generalTerms['PANEL_TEST']; ?>?</td>
		<td><input type='checkbox' name='ispanel' id='ispanel'></input></td>
	</tr>
	<tr valign='top' class='panel_row'>
		<td>
			<?php echo LangUtil::$generalTerms['MEASURES']; ?> <?php $page_elems->getAsterisk(); ?>
		</td>
		<td>
			<?php $page_elems->getMeasureCheckboxes(); ?>
		</td>
	</tr>
	
	<tr valign='top' class='nonpanel_row'>
		<td>
			<?php echo LangUtil::$generalTerms['MEASURES']; ?> <?php $page_elems->getAsterisk(); ?> [<a href='#measures_help' rel='facebox'>?</a>]
		</td>
		<td>
			<table id='new_measure_list' class='smaller_font'>
				<tr>
					<td><u><?php echo LangUtil::$generalTerms['NAME']; ?><?php $page_elems->getAsterisk(); ?></u></td>
					<td><u><?php echo LangUtil::$generalTerms['TYPE']; ?><?php $page_elems->getAsterisk(); ?></u></td>
					<td><u><?php echo LangUtil::$generalTerms['VALUES']; ?><?php $page_elems->getAsterisk(); ?></u></td>
					<td><u><?php echo LangUtil::$generalTerms['UNIT'] ; ?> /Default Value</u>[<a href='#unit_help' rel='facebox'>?</a>]</td>
				</tr>
				<?php
				$max_num_measures = 40;
                                $max_num_submeasures = 15;
				for($i = 1; $i <= $max_num_measures; $i += 1)
				{
					echo "<tr valign='top' id='mrow_$i' ";
					if($i != 1)
					{
						# Hide all rows except the first
						echo " style='display:none;' ";
					}
					echo ">";
					echo "<td>";
					echo "<input type='text' name='measure[]' value='' />";
                                        echo "<br>";
                                        ?>
                                        <small><a id='new_submeasure_link' href='javascript:add_new_submeasure(<?php echo $i; ?>);'><?php echo 'Add Sub Measure'; ?> &raquo;</a></small>
                                        <?php
					echo "</td>";
					echo "<td>";
					?>
					<select class='range_select' id='<?php echo $i; ?>' name='mtype[]'>
						<option value='<?php echo Measure::$RANGE_NUMERIC; ?>'><?php echo LangUtil::$generalTerms['RANGE_NUMERIC']; ?></option>
						<option value='<?php echo Measure::$RANGE_OPTIONS; ?>'><?php echo LangUtil::$generalTerms['RANGE_ALPHANUM']; ?></option>
						<option value='<?php echo Measure::$RANGE_AUTOCOMPLETE; ?>'><?php echo LangUtil::$generalTerms['RANGE_AUTOCOMPLETE']; ?></option>
                                                 <option value='<?php echo Measure::$RANGE_FREETEXT; ?>'><?php echo "Free Text" ?></option>

                                        </select>
					<?php
					echo "</td>";
					echo "<td>";
					?>
					<span id='val_<?php echo $i; ?>' class='values_section_<?php echo $i; ?>'>
						<span id='numeric_<?php echo $i; ?>'>
							
							<input type='text' class='range_field' name='range_l_<?php echo $i; ?>[]' value='' /> :
							<input type='text' class='range_field' name='range_u_<?php echo $i; ?>[]' value=''/>
							<input type='text' class='range_field' name='gender_<?php echo $i; ?>[]' value='B'/>
							<input type='text' class='range_field'  name='agerange_l_<?php echo $i; ?>[]' id='agerange_l_<?php echo $i; ?>[]' value='0' /> :
							<input type='text' class='range_field' name='agerange_u_<?php echo $i; ?>[]' id='agerange_u_<?php echo $i; ?>[]' value='100' /><br />
						</span>
						&nbsp;&nbsp;&nbsp;&nbsp;<?php echo LangUtil::$generalTerms['RANGE']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Gender &nbsp;&nbsp;Age_Range
							<br>
						<small><a href="javascript:add_range_field('<?php echo $i; ?>');"><?php echo LangUtil::$generalTerms['ADDANOTHER']; ?> &raquo;</a></small>
						<br><br>
					</span>
					<span id='alpha_<?php echo $i; ?>' style='display:none' class='values_section_<?php echo $i; ?>'>
						<span id='alpha_list_<?php echo $i; ?>'>
							<input type='text' class='range_field' name='alpharange_<?php echo $i; ?>[]' value='' /> /
							<input type='text' class='range_field' name='alpharange_<?php echo $i; ?>[]' value='' />
						</span>
						<br>
						<small><a href="javascript:add_option_field('<?php echo $i; ?>');"><?php echo LangUtil::$generalTerms['ADDANOTHER']; ?> &raquo;</a></small>
					</span>
					<span id='autocomplete_<?php echo $i; ?>' style='display:none' class='values_section_<?php echo $i; ?>'>
						<span id='autocomplete_list_<?php echo $i; ?>'>
							<input type='text' class='uniform_width' name='autocomplete_<?php echo $i; ?>[]' value='' /><br>
							<input type='text' class='uniform_width' name='autocomplete_<?php echo $i; ?>[]' value='' /><br>
						</span>
						<small><a href="javascript:add_autocomplete_field('<?php echo $i; ?>');"><?php echo LangUtil::$generalTerms['ADDANOTHER']; ?> &raquo;</a></small>
					</span>
                                        <span id='freetext_<?php echo $i; ?>' style='display:none' class='values_section_<?php echo $i; ?>'>
						<span id='freeetext_list_<?php echo $i; ?>'>
							<?php echo "<small>Will appear as a text box for result entry</small>"?>
						</span>
					</span>
					<?php
					echo "</td>";
					echo "<td id='unit_$i'>";
					echo "<input type='text' name='unit[]' value='' />";
					if($i!=1)
						echo "<small><a href='javascript:removeMeasure($i);'> Remove</a></small>";
					echo "</td>";
					echo "</tr>";
                                        
                                        # submeasures
                                        
                                       // $max_num_submeasures = 5;
                                        $us = '_';
                                    for($y = 1; $y <= $max_num_submeasures; $y += 1)
                                    {
                                            echo "<tr valign='top' id='smrow_$i$us$y' style='display:none;'";
                                            
                                            echo ">";
                                            echo "<td>";
                                            ?>
                                            Sub: <input type='text' name='submeasure[<?php echo $i; ?>][]' value='' />
                                            <?php
                                            echo "</td>";
                                            echo "<td>";
                                            ?>
                                            <select class='range_select' id='<?php echo $i.$us.$y; ?>' name='smtype[<?php echo $i; ?>][]'>
                                                    <option value='<?php echo Measure::$RANGE_NUMERIC; ?>'><?php echo LangUtil::$generalTerms['RANGE_NUMERIC']; ?></option>
                                                    <option value='<?php echo Measure::$RANGE_OPTIONS; ?>'><?php echo LangUtil::$generalTerms['RANGE_ALPHANUM']; ?></option>
                                                    <option value='<?php echo Measure::$RANGE_AUTOCOMPLETE; ?>'><?php echo LangUtil::$generalTerms['RANGE_AUTOCOMPLETE']; ?></option>
                                                    <option value='<?php echo Measure::$RANGE_FREETEXT; ?>'><?php echo "Free Text" ?></option>

                                            </select>
                                            <?php
                                            echo "</td>";
                                            echo "<td>";
                                            ?>
                                            <span id='val_<?php echo $i.$us.$y; ?>' class='values_section_<?php echo $i.$us.$y; ?>'>
                                                    <span id='numeric_<?php echo $i.$us.$y; ?>'>

                                                            <input type='text' class='range_field' name='range_l_<?php echo $i.$us.$y; ?>[]' value='' /> :
                                                            <input type='text' class='range_field' name='range_u_<?php echo $i.$us.$y; ?>[]' value=''/>
                                                            <input type='text' class='range_field' name='gender_<?php echo $i.$us.$y; ?>[]' value='B'/>
                                                            <input type='text' class='range_field'  name='agerange_l_<?php echo $i.$us.$y; ?>[]' id='agerange_l_<?php echo $i.$us.$y; ?>[]' value='0' /> :
                                                            <input type='text' class='range_field' name='agerange_u_<?php echo $i.$us.$y; ?>[]' id='agerange_u_<?php echo $i.$us.$y; ?>[]' value='100' />
                                                            <br>
                                                    </span>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;<?php echo LangUtil::$generalTerms['RANGE']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Gender &nbsp;&nbsp;Age_Range
                                                            <br>
                                                    <small><a href="javascript:add_range_field('<?php echo $i.$us.$y; ?>');"><?php echo LangUtil::$generalTerms['ADDANOTHER']; ?> &raquo;</a></small>
                                                    <br><br>
                                            </span>
                                            <span id='alpha_<?php echo $i.$us.$y; ?>' style='display:none' class='values_section_<?php echo $i.$us.$y; ?>'>
                                                    <span id='alpha_list_<?php echo $i.$us.$y; ?>'>
                                                            <input type='text' class='range_field' name='alpharange_<?php echo $i.$us.$y; ?>[]' value='' /> /
                                                            <input type='text' class='range_field' name='alpharange_<?php echo $i.$us.$y; ?>[]' value='' />
                                                    </span>
                                                    <br>
                                                    <small><a href="javascript:add_option_field('<?php echo $i.$us.$y; ?>');"><?php echo LangUtil::$generalTerms['ADDANOTHER']; ?> &raquo;</a></small>
                                            </span>
                                            <span id='autocomplete_<?php echo $i.$us.$y; ?>' style='display:none' class='values_section_<?php echo $i.$us.$y; ?>'>
                                                    <span id='autocomplete_list_<?php echo $i.$us.$y; ?>'>
                                                            <input type='text' class='uniform_width' name='autocomplete_<?php echo $i.$us.$y; ?>[]' value='' /><br>
                                                            <input type='text' class='uniform_width' name='autocomplete_<?php echo $i.$us.$y; ?>[]' value='' /><br>
                                                    </span>
                                                    <small><a href="javascript:add_autocomplete_field('<?php echo $i.$us.$y; ?>');"><?php echo LangUtil::$generalTerms['ADDANOTHER']; ?> &raquo;</a></small>
                                            </span>
                                            <span id='freetext_<?php echo $i.$us.$y; ?>' style='display:none' class='values_section_<?php echo $i.$us.$y; ?>'>
                                                    <span id='freeetext_list_<?php echo $i.$us.$y; ?>'>
                                                            <?php echo "<small>Will appear as a text box for result entry</small>"?>
                                                    </span>
                                            </span>
                                            <?php
                                            echo "</td>";
                                            echo "<td id='unit_$i$us$y'>";
                                            ?>
                                            <input type='text' name='sunit[<?php echo $i; ?>][]' value='' />
                                            <?php
											if($y!=1)
												echo "<small><a href='javascript:removeSubMeasure($i,$y);'> Remove</a></small>";
                                            echo "</td>";
                                            echo "</tr>";
                                            ?>
                                            <div id='new_subentries' style='display:none;'>
                                            
											</div>
                                            

                                            
                                        <?php
                                        }// end of submeasures for each measure
                                        ?>
                                        
                                      <?php  
				}//end of measures
				?>
                                        
			
			</table>
                        
			<div id='new_entries'>
			</div>
			<a id='new_measure_link' href='javascript:add_new_measure();'><?php echo LangUtil::$generalTerms['ADDANOTHER']; ?> &raquo;</a>
		</td>
	</tr>
	<tr valign='top'>
		<td>
			<?php echo LangUtil::$generalTerms['COMPATIBLE_SPECIMENS']; ?> <?php $page_elems->getAsterisk(); ?>  [<a href='#specimen_help' rel='facebox'>?</a>]  
		</td>
		<td>
			<?php $page_elems->getSpecimenTypeCheckboxes($lab_config_id); ?>
		</td>
	</tr>
	<td></td>
	<tr valign='top'>
		<td>
			Hide Patient Name in Report 
		</td>
		<td>
			<select name="hidePatientName">
				<option value="0">No</option>
				<option value="1">Yes</option>
			</select>
		</td>		
	</tr>
	<tr valign='top'>
		<td>Prevalence Threshold </td>
		<td><input id='prevalenceThreshold' name='prevalenceThreshold' type='text' size='3' maxLength='3' onkeypress="return isInputNumber(event);" />
			<span id='prevalenceThresholdError' class='error_string' style='display:none;'>
			<?php echo "Threshold Value cannot be more than 100"; ?>
		</span>
		</td>
	</tr>
			
	<tr valign='top'>
		<td>Target TAT</td>
		<td><input id='targetTat' name='targetTat' type='text' size='3' maxLength='3' onkeypress="return isInputNumber(event);" />
		</td>
	</tr>
        <tr valign='top' <?php if (!is_billing_enabled($_SESSION['lab_config_id'])) {echo "style='display:none;'";} ?>>
		<td>Cost To Patient</td>
                <td>
                    <input id='cost_to_patient_dollars' name='cost_to_patient_dollars' type='number' size='6' maxLength='6' onkeypress="return isInputNumber(event);" value='0' />
                    <?php echo get_currency_delimiter_from_lab_config_settings(); ?>
                    <input id='cost_to_patient_dollars' name='cost_to_patient_cents' type='number' size='2' maxLength='2' onkeypress="return isInputNumber(event);" value='00' />
                    <?php echo get_currency_type_from_lab_config_settings(); ?>
                </td>
	</tr>        
	<td>
	</td>
	<td>
		<br>
		<br>
		<input type='button' onclick='javascript:validateRow();' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' />
		&nbsp;&nbsp;&nbsp;&nbsp;
		<a href='catalog.php?show_t=1'> <?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a>
	</td>
	</tr>
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
For e.g., if the valid range lies between 0 and 1000, please enter '0:1000'.By default the gender is B for both and age_range is 0:100. You can modify any of the fields based on the measure. 
<br><br>
<u>Alphanumeric values</u> can be specified as 'value1/value2/value3'. 
For e.g., if test results can be either one from 'P','N' or 'D', please enter 'P/N/D'.
<br><br>
<u>Autocomplete</u> can be specified in the textboxes provided. They will be prompted while inputting the results.
<br><br>
<u>Removing</u> a measure can be done by using either selecting the delete box or else by simply leaving the measure name empty. For removing a range for particular measure leave the range box empty.
</small>
</div>
<div id='clinical_help' style='display:none'>
<small>
<u>Clinical Data </u> can be entered either in the table or text on both forms. If it is not requried please leave it blank.
</small>
</div>
<div id='specimen_help' style='display:none'>
<small>
More than one <u>Compatible Specimen </u> can be selected/deselected at a time. But atleast one speciemen has to be selected. In case a new added specimen is missing in the list then go to lab configuration to set it.
</small>
</div>
</div>
<div id='unit_help' style='display:none'>
<small>
<u>Unit</u>
Inorder to represent ranges like 2mins30secs please enter the range as 2.30 and in the unit add as min,secs.<br>
To represent data like 56^5-65^5 ml add the range as 56-65 and the unit as 5:ml.<br><br>
<u>Default Values</u>
It is used for test which are alphanumeric and autocomplete. The default value for that measure can be recorded in this section.
</small>
</div>
<?php include("includes/footer.php"); ?>