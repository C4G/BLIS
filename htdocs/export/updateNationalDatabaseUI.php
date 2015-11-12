<?php
#
# Updates Lab data (Similar to revert)
# Called via POST from lab_config_home.php
# Redirects back after update is complete
#
include("../includes/header.php");
$siteList = get_site_list($_SESSION['user_id']);
?>
<script type="text/javascript">
	function updateCountryDatabase() {
		var date_from = $('#yf').attr("value")+"-"+$('#mf').attr("value")+"-"+$('#df').attr("value");
		var date_to = $('#yt').attr("value")+"-"+$('#mt').attr("value")+"-"+$('#dt').attr("value");
		if(checkDate($('#yf').attr("value"), $('#mf').attr("value"), $('#df').attr("value")) == false) {
			alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
			return;
		}
		if(checkDate($('#yt').attr("value"), $('#mt').attr("value"), $('#dt').attr("value")) == false) {
			alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
			return;
		}
		$('#updateCountryForm').submit();
	}
</script>

<br><br>
<form id='updateCountryForm' name='updateCountryForm' action='updateCountryDatabase.php' method='post'>
<table>
<tr>
<td>Select a Lab </td>
<td><select id="labConfigId" name='labConfigId' style="font-family:'Tahoma';">
	<?php
		foreach($siteList as $key=>$value)
			echo "<option value='$key'>".substr($value, 0, strpos($value, "-"))."</option>";
	?>
</select>
</td>
</tr>
<tr>
<td>
<?php echo LangUtil::$generalTerms['FROM_DATE']; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</td>
<td>
<?php 
	$name_list = array("yearFrom", "monthFrom", "dayFrom");
	$id_list = $name_list;
	$weekago_date = date("Y-m-d", strtotime('-1 week'));
	$weekago_array = explode("-", $weekago_date);
	$value_list = $weekago_array;
	$page_elems->getDatePicker($name_list, $id_list, $value_list, true);
?>
</td>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<td>
<?php echo LangUtil::$generalTerms['TO_DATE']; ?>
<span>
<?php 
	$today = date("Y-m-d");
	$value_list = explode("-", $today);
	$name_list = array("yearTo", "monthTo", "dayTo");
	$id_list = $name_list;
	$page_elems->getDatePicker($name_list, $id_list, $value_list, true);
?>
</td>
</tr>
<tr>
<td>Select update file</td>
<td><input type="File" id="sqlFile" name="sqlFile" /></td>
</tr>
<tr>
<td></td>
<td>
<input type="submit" id="submit" onclick="javascript:updateCountryDatabase();" value="Update">
</td>
</tr>
</table>
</form>
<?
include("../includes/footer.php");
?>