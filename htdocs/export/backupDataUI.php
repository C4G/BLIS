﻿<?php
    require_once("../includes/header.php");
    require_once("../includes/keymgmt.php");
    //$labConfigId = $_REQUEST['id'];
    $labConfigId =$_SESSION['lab_config_id'];
    putUILog('backup_data_ui', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');
    $target_set=KeyMgmt::getAllKeys();
    $encryption_enabled = (KeyMgmt::read_enc_setting() == 1);
?>

<style type="text/css">
td {
    padding: 5px 0;
    line-height: 1.5rem;
}
</style>

<script type="text/javascript">

const ENCRYPTION_ENABLED = <?php echo($encryption_enabled ? 'true' : 'false') ?>;

function updateKeyForm() {
    const keyDropdown = document.getElementById('keySelectDropdown');

    const keyFileRow = document.getElementById('keyUploadFileRow');
    const keyNameRow = document.getElementById('keyUploadNameRow');

    if (keyDropdown.value === "-1") {
        // "unlisted" is selected
        keyFileRow.style.display = '';
        keyNameRow.style.display = '';
    } else {
        keyFileRow.style.display = 'none';
        keyFileRow.querySelector("input[type='file']").value = '';
        keyNameRow.style.display = 'none';
        keyNameRow.value = '';
        keyNameRow.querySelector("input[type='text']").value = '';
    }
}
</script>

<?php
$page_elems = new PageElems();
$page_elems->getSideTip(LangUtil::getGeneralTerm("TIPS"), LangUtil::getGeneralTerm("backup_tip"));
?>

<form id='databaseBackupType' name='databaseBackupType' action='backupData.php' method='post' target='_blank' enctype="multipart/form-data">
    <input type='hidden' value='<?php echo $labConfigId; ?>' id='labConfigId' name='labConfigId' />
	<table>
<tr id="keySelectRow" style="<?php echo($encryption_enabled ? '' : 'display: none') ?>">
    <td style="text-align: right">Backup encryption key: </td>
    <td>
        <select id="keySelectDropdown" name="target" autocomplete="off" onChange="updateKeyForm()">
        <option value="0" selected>Current Lab (default key)</option>
        <?php
        foreach ($target_set as $option)
        {
            echo "<option value='".$option->ID."'>".$option->LabName."</option>";
        }
        ?>
        <option value="-1">New key...</option>
        </select>
    </td>
</tr>

<tr id="keyUploadNameRow" style="display: none">
    <td style="text-align: right">Key alias:</td>
    <td><input type="text" name="pkey_alias" id="pkey_alias" autocomplete="off"/></td>
</tr>

<tr id="keyUploadFileRow" style="display: none">
    <td style="text-align: right">Choose key file:</td>
    <td><input type="file" name="pkey" id="pkey" autocomplete="off"/></td>
</tr>

<tr>
    <td style="text-align: right">Type of backup:</td>
    <td>
        <input type='radio' id='backupTypeSelect' name='backupTypeSelect' value='normal' checked>General Backup</option><br/>
        <input type='radio' id='backupTypeSelect' name='backupTypeSelect' value='anonymized'>Anonymized Backup</option>
    </td>
</tr>

<tr>
    <td></td>
    <td>
        <input type='submit' value="Backup" id='start_backup_btn' />
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
require_once("../includes/footer.php");
?>

