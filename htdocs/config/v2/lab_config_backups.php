<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Lists currently accessible lab configurations with options to modify/add
# Check whether to redirect to lab configuration page
# Called when the lab admin has only one lab under him/her
#

require_once(__DIR__."/../../users/accesslist.php");
require_once(__DIR__."/../../encryption/keys.php");
require_once(__DIR__."/../../includes/lab_config.php");
require_once(__DIR__."/../../includes/migrations.php");
require_once(__DIR__."/../../includes/user_lib.php");
require_once(__DIR__."/lib/backup.php");

$current_user_id = $_SESSION['user_id'];
$current_user = get_user_by_id($current_user_id);
$lab_config_id = $_REQUEST['id'];

DbUtil::switchToGlobal();

$lab_db_name_query = "SELECT * FROM lab_config WHERE lab_config_id = '$lab_config_id';";
$lab = query_associative_one($lab_db_name_query);
$lab_config = LabConfig::getObject($lab);
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

$settings_encryption_enabled = $lab_config->backup_encryption_enabled;

$migrator = new LabDatabaseMigrator($lab['db_name']);
$has_pending_migrations = $migrator->pending_migrations();

?>

<?php
$selected_tab = "lab_backups";
require_once(__DIR__."/lab_config_backup_header.php");
?>

<script type="text/javascript">
    $(document).ready(function() {

        $('a.delete-backup').bind('click', function () {
            return confirm('Are you sure you want to delete this backup?');
        });

    });
</script>

<?php
if ($has_pending_migrations) {
?>
<div class="section" id="pending-migrations">
    There are database migrations pending. Please <a href="lab_config_backups_apply_migrations.php?id=<?php echo($lab_config_id);?>">click here</a> to apply them.
</div>
<?php
}
?>

<div id="create-backup" class="section">
    <h3 class="section-head">Create New Backup</h3>

    <form id='databaseBackupType' name='databaseBackupType' action='/backupData.php' method='post' enctype="multipart/form-data">
        <input type='hidden' value='<?php echo $lab_config_id; ?>' id='labConfigId' name='labConfigId' />
        <table>
            <?php if ($settings_encryption_enabled) {
                $encryption_keys = Key::where_type(Key::$PUBLIC);
            ?>
            <tr id="keySelectRow">
                <td style="text-align: right">Backup encryption key: </td>
                <td>
                    <select id="keySelectDropdown" name="keySelectDropdown" autocomplete="off">
                        <?php
                        foreach ($encryption_keys as $pubkey)
                        {
                            echo "<option value=\"" . $pubkey->id . "\">" . $pubkey->name . "</option>";
                        }
                        ?>
                    </select>
                </td>
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
                    BLIS Version
                </th>
                <th class="text-center">
                    Filename
                </th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
    <?php
        $count = 1;
        foreach ($backups as $backup) {
            ?>
            <tr valign='top'>
                <td class="text-right">
                    <?php echo date("F j Y g:i:s", $backup->timestamp); ?>
                </td>
                <td class="text-right">
                    <?php echo $backup->version; ?>
                </td>
                <td>
                    <a href="download_backup.php?lab_config_id=<?php echo($lab_config_id); ?>&id=<?php echo($backup->id); ?>"><?php echo $backup->filename; ?></a>
                </td>
                <td>
                    <a href="lab_config_backup_restore.php?lab_config_id=<?php echo($lab_config_id); ?>&id=<?php echo($backup->id); ?>"><?php echo LangUtil::$generalTerms['CMD_RESTORE']; ?></a>
                </td>
                <td>
                    <a class="delete-backup" href="delete_backup.php?lab_config_id=<?php echo($lab_config_id); ?>&id=<?php echo($backup->id); ?>"><?php echo LangUtil::$generalTerms['CMD_DELETE']; ?></a>
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
