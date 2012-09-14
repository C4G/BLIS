<?php
include("../includes/header.php");
$labConfigId = $_REQUEST['id'];
putUILog('backup_data_ui', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');
?>

<script type="text/javascript">
	function keyTextInput(val) {
		if(val==1)
			$('#keyInputTR').show();
		else
			$('#keyInputTR').hide();
	}
	
	function formSubmit() {
		var backupTypeSelectValue = $("input:radio[name=backupTypeSelect]:checked").val();
		if( backupTypeSelectValue == "encrypted" ) {
			var typeOfKey = $("input:radio[name=keyType]:checked").val();
			if( !typeOfKey ) {
				alert("Please choose a key type");
				return;
			}
			if ( typeOfKey == "uploaded") {
				var fileValue = $('#publicKey').val();
				if( !fileValue ) {
					alert("Please select a key or use default");
					return;
				}
			}
		}
		$('#databaseBackupType').submit();
		/*$('#databaseBackUpType').ajaxSubmit({
			success: function(param) {
				$('#exporting').hide();
				if ( param != false ) {
					$('#exportSuccess').html(param);
					$('#exportSuccess').show();
				} else {
					alert(param);
					$('#exportDatabaseFailure').show();
				}
			}
		});
		*/
	}
	
</script>

<form id='databaseBackupType' name='databaseBackupType' action='backupData.php' method='post' target='_blank'>
	<!--input style='font-family:Tahoma' type='button' value='<?php echo LangUtil::$pageTerms['MENU_BACKUP']; ?>' onclick='javascript:submitForm();' /-->
	<input type='hidden' value='<?php echo $labConfigId; ?>' id='labConfigId' name='labConfigId' />
	<table>
	<tr>
		<td>Choose type of Backup</td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td><input type='radio' id='backupTypeSelect' name='backupTypeSelect' value='normal' onclick='keyTextInput(0);' >General Backup</option></td>
	</tr>
	<tr>
		<td></td>
		<td><input type='radio' id='backupTypeSelect'  name='backupTypeSelect' value='encrypted' onclick='keyTextInput(1);'>Encrypted Backup</option></td>
	</tr>
	<tr style="display:none;" name="keyInputTR" id="keyInputTR">
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
		<td><input style='font-family:Tahoma' type='button' value='<?php echo LangUtil::$pageTerms['MENU_BACKUP']; ?>' onclick='javascript:formSubmit();' ></td>
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