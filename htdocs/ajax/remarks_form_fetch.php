<?php
#
# Generates form for editing result interpretations
# Called via Ajax from remarks_edit.php
#

include("../includes/db_lib.php");
include("../includes/page_elems.php");
$page_elems = new PageElems();

$lab_config_id = $_REQUEST['lid'];
$test_type_id = $_REQUEST['ttype'];

//include($LOCAL_PATH."langdata_".$lab_config_id."/remarks.php");

$saved_id = $_SESSION['lab_config_id'];

$lab_config = LabConfig::getById($lab_config_id);
$test_type = TestType::getById($test_type_id);

# Fetch all measures for this test
$measure_list = $test_type->getMeasures();
# For each measure, fetch existing remarks data from remarks.XML
$measure_remarks = array();
# Generate form
?>
<div class='pretty_box' style='width:auto;'>
<form name='remarks_form' id='remarks_form' action='remarks_update.php' method='post'>
<input type='hidden' name='lid' value='<?php echo $lab_config_id; ?>'></input>
<input type='hidden' name='ttype' value='<?php echo $test_type_id; ?>'></input>
<?php 
foreach($measure_list as $measure)
{
	$range_type = $measure->getRangeType();
	//my function is called where the measure id is given.//decide where to call the numeric or option walla function
	//$remaeks_list is an array r_l[range]=>description.
	//$remarks_list = $measure_remarks[$measure->measureId];
	$remarks_list=$measure->getInterpretation();
        if($measure->checkIfSubmeasure() == 1)
        {
            $decName = $measure->truncateSubmeasureTag();
        }
        else
        {
            $decName = $measure->getName();
        }
                echo "<br>";

	echo "<b>".$decName."</b>";
	if($range_type == Measure::$RANGE_NUMERIC)
	{
	
	$range_list_array=$measure->getReferenceRanges($_SESSION['lab_config_id']);
	if(count($range_list_array)==0)
	{
		echo "&nbsp;&nbsp;&nbsp;";
		echo $measure->getRangeString();
		echo "<br>";
	
	}
	else if(count($range_list_array)==1)
	{
		echo "&nbsp;&nbsp;&nbsp;";
		echo "(".($range_list_array[0]->rangeLower)."-".($range_list_array[0]->rangeUpper) .$measure->unit.")".$range_list_array[0]->sex;
		echo "<br>";
		
	}
	else{
	echo "&nbsp;&nbsp;&nbsp;";
		echo "(".($range_list_array[0]->rangeLower)."-".($range_list_array[0]->rangeUpper) .$measure->unit.")".$range_list_array[0]->sex;
		
		echo "&nbsp;&nbsp;&nbsp;";
		echo "(".($range_list_array[1]->rangeLower)."-".($range_list_array[1]->rangeUpper) .$measure->unit.")".$range_list_array[1]->sex;
		echo "<br>";
	}
		
		}
	?>
	<table id='remarks_table_<?php echo $measure->measureId; ?>' class='hor-minimalist-c'>
		<thead>
			<tr>
			<?php if($range_type == Measure::$RANGE_NUMERIC) {?>
				<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo LangUtil::$generalTerms['RANGE'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Age Range&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Gender</th>
				<?php } else {?>
				<th><?php echo LangUtil::$generalTerms['RANGE'];?></th>
				<?php }?>
				<th>Interpretation</th>
			</tr>
		</thead>
		<tbody>
		<?php
		if($range_type == Measure::$RANGE_NUMERIC)
		{
		$remarks_list= array();
		$remarks_list=$measure->getNumericInterpretation();
		if( count($remarks_list)!=0 ){
		foreach($remarks_list as $remark)
		{
		echo "<tr>";
		 echo "<td>";
		 echo "<input type='hidden' name='id_".$measure->measureId."[]' value='".$remark[6]."' class='uniform_width_less numeric_range' ></input>";
		 echo "<input type='text' name='range_l_".$measure->measureId."[]' value='".$remark[0]."' class='uniform_width_less numeric_range'></input>-";
		 echo "<input type='text' name='range_u_".$measure->measureId."[]' value='".$remark[1]."' class='uniform_width_less numeric_range'></input>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		 echo "<input type='text' name='age_l_".$measure->measureId."[]' value='".$remark[2]."' class='uniform_width_less numeric_range'></input>-";
		 echo "<input type='text' name='age_u_".$measure->measureId."[]' value='".$remark[3]."' class='uniform_width_less numeric_range'></input>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		 echo "<input type='text' name='gender_".$measure->measureId."[]' value='".$remark[4]."' size='1px'></input>";
		 echo "</td>";
		 echo "<td>";
		 echo "<input type='text' name='remarks_".$measure->measureId."[]' value='".$remark[5]."' class='uniform_width'></input>";
		 echo "</td>";
		echo "</tr>";
		}
		}else
		{
		echo "<tr>";
		 echo "<td>";
		  echo "<input type='hidden' name='id_".$measure->measureId."[]' value=-1 class='uniform_width_less numeric_range' ></input>";
		  echo "<input type='text' name='range_l_".$measure->measureId."[]' value='' class='uniform_width_less numeric_range'></input>-";
		 echo "<input type='text' name='range_u_".$measure->measureId."[]' value='' class='uniform_width_less numeric_range'></input>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		 echo "<input type='text' name='age_l_".$measure->measureId."[]' value='' class='uniform_width_less numeric_range'></input>-";
		 echo "<input type='text' name='age_u_".$measure->measureId."[]' value='' class='uniform_width_less numeric_range'></input>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		 echo "<input type='text' name='gender_".$measure->measureId."[]' value='' size='1px'></input>";
		 echo "</td>";
		 echo "<td>";
		 echo "<input type='text' name='remarks_".$measure->measureId."[]' value='' class='uniform_width'></input>";
		 echo "</td>";
		echo "</tr>";
		}
		}
		else if($range_type == Measure::$RANGE_OPTIONS)
		{
		$range_list=$measure->getRangeValues();
			foreach($range_list as $key=>$value)
			{
				$inter_value=$remarks_list[$key];
				if($inter_value=="")
				$inter_value=$value;
				echo "<tr>";
				echo "<td>";
				echo $value;
				echo "</td>";
				echo "<td>";
				echo "<input type='text' value='$inter_value' name='remarks_".$measure->measureId."[]' class='uniform_width'></input>";
				echo "</td>";
				echo "</tr>";
			}
		}
		else if($range_type == Measure::$RANGE_AUTOCOMPLETE)
		{
		
			$range_list=$measure->getRangeValues();
			foreach($range_list as $key=>$value)
			{
				$inter_value=$remarks_list[$key];
				if($inter_value=="")
				$inter_value=$value;
				echo "<tr>";
				echo "<td>";
				echo $value;
				echo "</td>";
				echo "<td>";
				echo "<input type='text' value='$inter_value' name='remarks_".$measure->measureId."[]' class='uniform_width'></input>";
				echo "</td>";
				echo "</tr>";
			}
			
		}
                
                else if($range_type == Measure::$RANGE_FREETEXT)
		{
		
			echo $range_list=$measure->getRangeValues();
                    
			/*foreach($range_list as $key=>$value)
			{
				$inter_value=$remarks_list[$key];
				if($inter_value=="")
				$inter_value=$value;
				echo "<tr>";
				echo "<td>";
				echo $value;
				echo "</td>";
				echo "<td>";
				echo "<input type='text' value='$inter_value' name='remarks_".$measure->measureId."[]' class='uniform_width'></input>";
				echo "</td>";
				echo "</tr>";
			}*/
			
		}
                
		?>
		</tbody>
	</table>
	<?php
	if($range_type == Measure::$RANGE_NUMERIC)
	{
		?>
		<br>
		 <small><a href="javascript:add_remarks_row(<?php echo $measure->measureId; ?>, <?php echo $range_type; ?>);"><?php echo LangUtil::$generalTerms['ADDANOTHER']; ?>&raquo;</a></small>
		<br>
		<?php
	}
}
?>
<br><br>
<input type='button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' onclick='javascript:submit_remarks_form();'></input>
&nbsp;&nbsp;
<a href='javascript:hide_remarks_form();'><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a>
&nbsp;&nbsp;
<span id='remarks_submit_progress' style='display:none;'>
	<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
</span>
</form>
</div>
<?php
# Return
$_SESSION['lab_config_id'] = $saved_id;
?>