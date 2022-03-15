<?php
    include("../includes/header.php");
    //$labConfigId = $_REQUEST['id'];
    $labConfigId =$_SESSION['lab_config_id'];
    putUILog('backup_data_ui', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');
    $target_set=KeyMgmt::getAllKeys();
?>

<script type="text/javascript">
function findFile()
{
    var inp=		document.getElementById("target_input").value;
    var x = document.getElementById("targets");
    var i;
    var found=0;
        for (i = 0; i < x.options.length; i++) {
            if(inp===x.options[i].value)
        {
    found=1;
    document.getElementById("pkey").disabled=true;
    break;
}

}
if(found==0)
    document.getElementById("pkey").disabled=false;
}
	function keyTextInput(val) {
		if(val==1)
			$('#keyInputTR').show();
		else
			$('#keyInputTR').hide();
	}
	
</script>
<?php
$page_elems = new PageElems();
$page_elems->getSideTip(LangUtil::getGeneralTerm("TIPS"), LangUtil::getGeneralTerm("backup_tip"));
?>
<form id='databaseBackupType' name='databaseBackupType' action='backupData.php' method='post' target='_blank' enctype="multipart/form-data">
	<!--input style='font-family:Tahoma' type='button' value='<?php echo LangUtil::$pageTerms['MENU_BACKUP']; ?>' onclick='javascript:submitForm();' /-->
	<input type='hidden' value='<?php echo $labConfigId; ?>' id='labConfigId' name='labConfigId' />
	<table>
<tr>
<td>Choose who is this Backup For</td>
<td>
<input value="Current Lab" onBlur="findFile()" onInput="findFile()" name='target'  class ='target_auto' id='target_input' placeholder='Enter Receiver&apos;s name' list='targets' size='30' required></input>
<datalist id='targets'>
<option value="Current Lab" selected>
<?php
		foreach ($target_set as $option)
		{
			echo "<option value='".$option->LabName."'>".$option->LabName."</option>>";
		}?></datalist>
</td>
</tr>
<tr id="key_upload">
<td>Choose Key File</td> 
<td><input type="file" name="pkey" id="pkey" disabled/></td>
</tr>
	<tr>
		<td>Choose type of Backup</td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td><input type='radio' id='backupTypeSelect' name='backupTypeSelect' value='normal' onclick='keyTextInput(0);' checked>General Backup</option></td>
	</tr>
<!--	<tr>
		<td></td>
		<td><input type='radio' id='backupTypeSelect'  name='backupTypeSelect' value='encrypted' onclick='keyTextInput(1);'>Encrypted Backup</option></td>
	</tr>-->
	<tr name="keyInputTR" id="keyInputTR">
		<td></td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='keyType' id='keyType' value='uploaded'><small>Upload Public Key for Encryption: </small>
			<input type="file" name="publicKey" id="publicKey"/><br>
			&nbsp;&nbsp;&nbsp;&nbsp;<small><input type='radio' name='keyType' id='keyType' value='default'> or use Default Public Key</small>
		</td>
	</tr>
	<tr>
		<td></td>
		<td><input type='radio' id='backupTypeSelect' name='backupTypeSelect' value='anonymized' onclick='keyTextInput(0);'>Anonymized Backup</option></td>
	</tr>
	<tr>
		<td></td>
        <td>
			<input type='submit' name='local_or_server' id='local_or_server' value='<?php echo LangUtil::$generalTerms['BACKUP_LOCAL']; ?>'>
			<input type='submit' name='local_or_server' id='local_or_server' value='<?php echo LangUtil::$generalTerms['BACKUP_ONLINE']; ?>'>
		</td>	
    </tr>
	<tr id='exporting' style='display:none;'>
		<td></td>
		<td>
		<?php if( $_SESSION['locale'] != "fr" ) { ?>
			<p><?php $page_elems->getProgressSpinner("Backing up Data.. Please wait"); ?></p>
		<?php } else { ?>
			<p><?php $page_elems->getProgressSpinner("Sauvegarde des donn�es.. Sil vous plait attendre"); ?></p>
		<?php } ?>
		</td>
	</tr>
	<tr id='exportSuccess' style='display:none;'>
		<td><p style="color:green;"></p></td>
		<td></td>
	</tr>

	<tr id='exportDatabaseFailure' style='display:none;'>
		<td><p style="color:red;">Database Export Failed.</p></td>
		<td></td>
	</tr>
	</table>
</form> 

<?php
include("../includes/footer.php");
?>

