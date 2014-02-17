<?php
include("redirect.php");
include("includes/db_lib.php");

echo "<strong>Merge same patient data</strong>";
if(isset($_POST['Confirm']))
{
	if($_POST['confirmed']=="Yes")
	{
		if(mergedata())
		{
			echo "<strong><br> <br> Action performed sucessfully</strong>";
		}
		else
		{
			echo "<strong><br> <br>Sorry error occured...</strong>";
		}
		exit;
	}
}

function mergedata()
{
	if(!isset($_SESSION['lab_config_id']))
		return false;
	$workedID="";
	$lab_config = $_SESSION['lab_config_id'];	
	$saved_db = DbUtil::switchToLabConfig($importLabConfigId); 
	$querySelect = "SELECT patient_id,name,surr_id,addl_id FROM patient order by surr_id asc";
	$resultset = query_associative_all($querySelect, $rowCount);
	$rowCount=0;
	foreach($resultset as $record)
	{		
		if(strstr($workedID,$record['surr_id']))
			continue;
		else		
			$workedID.=",".$record['surr_id'];
			
		$querySelect = "SELECT patient_id,name,surr_id,addl_id FROM patient where 
		surr_id='".$record['surr_id']."' and 
		patient_id <> ".$record['patient_id'];		
		$Dupresult = query_associative_all($querySelect, $rowCount);
		foreach($Dupresult as $Duprecord)
		{
			$rowCount+=1;
			echo '<br> Working... '.$record['surr_id'];
			//update spacimen
			$updateQuery = "update specimen set patient_id=".$record['patient_id']."where patient_id=".$Duprecord['patient_id']; 
			 query_blind($updateQuery);
			 
			 //update bills
			 $updateQuery = "update bills set patient_id=".$record['patient_id']."where patient_id=".$Duprecord['patient_id']; 
			 query_blind($updateQuery);
			 
			 //now delete from custom_data and patients table
			  $deleteQuery = "delete from patient_custom_data where patient_id=".$Duprecord['patient_id']; 
			   query_blind($deleteQuery);
			   
			   $deleteQuery = "delete from patient where patient_id=".$Duprecord['patient_id']; 
			   query_blind($deleteQuery);
			 			
		}
	}
	
	
	//var_dump ( $resultset);
if($rowCount >0)
	echo '<br>'.$rowCount." Duplicate Records corrected.";
else
	echo '<br>'."No Duplicate Records found.";
	
return true;
}
?>
<table>
<form method="post" id="confirmAction">
<tr>
<td>Are you sure? </td><td>Yes<input name="confirmed" type="radio" value="Yes" /> 
 No
 <input name="confirmed" type="radio" value="No" checked="checked" />

</tr>
<tr><td></td>
<td> <input type="submit" id="confirm" name="Confirm" value="Confirm" /></td></tr>

</form>
</table>
