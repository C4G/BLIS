<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Lists currently accessible lab configurations with options to modify/add
# Check whether to redirect to lab configuration page
# Called when the lab admin has only one lab under him/her
#

require_once(__DIR__."/../../users/accesslist.php");
require_once(__DIR__."/../../includes/user_lib.php");
require_once(__DIR__."/lib/backup.php");

$current_user_id = $_SESSION['user_id'];
$current_user = get_user_by_id($current_user_id);
$lab_config_id = $_REQUEST['id'];

DbUtil::switchToGlobal();

$lab_db_name_query = "SELECT lab_config_id, name, db_name FROM lab_config WHERE lab_config_id = '$lab_config_id';";
$lab = query_associative_one($lab_db_name_query);
db_change($lab['db_name']);

$lab_config_name = $lab["name"];

$unauthorized = true;

if (is_super_admin($current_user) || is_country_dir($current_user)) {
    $unauthorized = false;
}

if ($unauthorized) {
    // If the user is not a super admin or country director, they should only
    // be able to access data for their own lab, and only if they are an admin.
    if ($lab_config_id == $current_user->labConfigId && is_admin($current_user)) {
        $unauthorized = false;
    }
}

if ($unauthorized) {
    header('HTTP/1.1 401 Unauthorized', true, 401);
    header("Location: /home.php");
    exit;
}

require_once(__DIR__."/../../includes/header.php");
LangUtil::setPageId("lab_configs");

$backups = Backup::for_lab_config_id($lab_config_id);

require_once(__DIR__."/../../includes/keymgmt.php");

// TODO: switch this to its own table, maybe...
$settings_encryption_enabled = KeyMgmt::read_enc_setting() != "0";

?>

<?php
$selected_tab = "lab_backups";
require_once(__DIR__."/lab_config_backup_header.php");
?>

<div id="create-backup" class="section">
    <h3 class="section-head">Create New Backup</h3>

    <form id='databaseBackupType' name='databaseBackupType' action='/backupData.php' method='post' enctype="multipart/form-data">
        <input type='hidden' value='<?php echo $lab_config_id; ?>' id='labConfigId' name='labConfigId' />
        <table>
            <?php if ($settings_encryption_enabled) {
            ?>
            <tr id="keySelectRow">
                <td style="text-align: right">Backup encryption key: </td>
                <td>
                    <select id="keySelectDropdown" name="target" autocomplete="off" onChange="updateKeyForm()">
                        <option value="0" selected>Current Lab (default key)</option>
                        <?php
                        $target_set=KeyMgmt::getAllKeys();
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

            <?php
            }
            ?>

            <tr>
                <td style="text-align: right">Type of backup:</td>
                <td>
                    <input type='radio' id='backupTypeSelectGeneral' name='backupTypeSelect' value='normal' checked>
                    <label for="backupTypeSelectGeneral">General Backup</label>
                    <br/>
                    <input type='radio' id='backupTypeSelectAnon' name='backupTypeSelect' value='anonymized'>
                    <label for="backupTypeSelectAnon">Anonymized Backup</label>
                </td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <input type='submit' value="Backup" id='start_backup_btn' />
                </td>
            </tr>
        </table>
    </form>
</div>

<div id='backup_list' class="section">
    <h3 class="section-head">Backups</h3>

    <?php
    if (count($backups) == 0) {
        echo "<div class='sidetip_nopos'>".LangUtil::$generalTerms['MSG_NOTFOUND']."</div>";
    } else {
        ?>
    <table class='hor-minimalist-b'>
        <thead>
            <tr valign='top'>
                <th class="text-right">
                    Date
                </th>
                <th class="text-right">
                    Database Name
                </th>
                <th class="text-right">
                    BLIS Version
                </th>
                <th class="text-center">
                    Filename
                </th>
                <th></th>
            </tr>
        </thead>
        <tbody>
    <?php
        $count = 1;
        foreach ($backups as $backup) {
            $analyzed = $backup->analyze();

            ?>
            <tr valign='top'>
                <td class="text-right">
                    <?php echo date("F j Y g:i:s", $backup->timestamp); ?>
                </td>
                <td class="text-right">
                    <?php echo $analyzed->database_name; ?>
                </td>
                <td class="text-right">
                    <?php echo $analyzed->version; ?>
                </td>
                <td>
                    <a href="download_backup.php?lab_config_id=<?php echo($lab_config_id); ?>&id=<?php echo($backup->id); ?>"><?php echo $backup->filename; ?></a>
                </td>
                <td>
                    <div>Restore</div>
                </td>
            </tr>
    <?php
        } ?>
        </tbody>
    </table>
    <?php
    }
    ?>
</div>

<?php require_once(__DIR__."/../../includes/footer.php"); ?>
