<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Lists currently accessible lab configurations with options to modify/add
# Check whether to redirect to lab configuration page
# Called when the lab admin has only one lab under him/her
#

require_once(__DIR__."/../../users/accesslist.php");
require_once(__DIR__."/../../includes/migrations.php");
require_once(__DIR__."/../../includes/user_lib.php");
require_once(__DIR__."/lib/backup.php");
require_once(__DIR__."/lib/backup_restorer.php");

$current_user_id = $_SESSION['user_id'];
$current_user = get_user_by_id($current_user_id);

$lab_config_id = $_REQUEST['lab_config_id'];
$lab_db_name_query = "SELECT lab_config_id, name, db_name FROM lab_config WHERE lab_config_id = '$lab_config_id';";
$lab = query_associative_one($lab_db_name_query);
db_change($lab['db_name']);
$lab_config_name = $lab['name'];

$backup_id = $_REQUEST['id'];
$backup = Backup::find($backup_id);

$unauthorized = true;

if (is_super_admin($current_user) || is_country_dir($current_user)) {
    $unauthorized = false;
}

if ($unauthorized) {
    // If the user is not a super admin or country director, they should only
    // be able to access data for their own lab, and only if they are an admin.
    if ($backup->lab_config_id == $current_user->labConfigId && is_admin($current_user)) {
        $unauthorized = false;
    }
}

if ($unauthorized) {
    header('HTTP/1.1 401 Unauthorized', true, 401);
    header("Location: /home.php");
    exit;
}

$analyzed = $backup->analyze();

if ($_GET["action"] != "confirm") {

    require_once(__DIR__."/../../includes/header.php");
    LangUtil::setPageId("lab_config_home");

    $selected_tab = "lab_backups";
    require_once(__DIR__."/lab_config_backup_header.php");

?>

<style>
#restore-footer {
    margin: 0 auto;
    width: 50%;
}

#restore-backup table {
    margin: 1rem;
}

#restore-backup table tr td:first-of-type {
    text-align: right;
}

#restore-backup table td {
    padding: 0.5rem;
}

</style>

<div class="section">
    <h3 class="section-head">Restore Backup</h3>

    <div id="restore-backup">
        <table>
            <tr>
                <td class="text-bold">Lab name</td>
                <td><?php echo($analyzed->lab_name); ?></td>
            </tr>
            <tr>
                <td class="text-bold">Backup Filename</td>
                <td><?php echo($backup->filename); ?></td>
            </tr>
            <tr>
                <td class="text-bold">BLIS Version</td>
                <td><?php echo($analyzed->version); ?></td>
            </tr>
            <tr>
                <td class="text-bold">Encrypted?</td>
                <td class="text-monospace"><?php echo($analyzed->encrypted ? "Yes" : "No"); ?></td>
            </tr>
            <tr>
                <td class="text-bold">Source database</td>
                <td class="text-monospace"><?php echo($analyzed->database_name); ?></td>
            </tr>
            <tr>
                <td class="text-bold">Target database</td>
                <td class="text-monospace"><?php echo($lab["db_name"]); ?></td>
            </tr>
        </table>
    </div>

    <div id="restore-footer">
        <p class="text-center">
            <b>This operation cannot be undone.</b> Please ensure you have a current backup before proceeding.
        </p>

        <div>
            <a style="float: left" class="text-bold" href="lab_config_backups.php?id=<?php echo($lab_config_id); ?>"><< Cancel</a>
            <a style="float: right" class="text-bold" href="lab_config_backup_restore.php?lab_config_id=<?php echo($lab_config_id); ?>&id=<?php echo($backup_id); ?>&action=confirm">Next >></a>
        </div>
    </div>
</div>

<?php

    require_once(__DIR__."/../../includes/footer.php");

} else {

    $restorer = new BackupRestorer($backup, $lab_config_id);

    $restore_successful = $restorer->restore();

    $migrations_successful = false;
    if ($restore_successful) {
        $migrator = new LabDatabaseMigrator($restorer->target_lab_database);
        $migrations_successful = $migrator->apply_migrations();
    }

    if ($restore_successful) {
        if ($migrations_successful) {
            $_SESSION["BACKUP_FLASH"] = "Backup restored successfully.";
        } else {
            $_SESSION["BACKUP_FLASH"] = "Backup database was restored, "
                                        . "but could not be migrated to the new BLIS version. "
                                        . "Please check the logs for details.";
        }
    } else {
        $_SESSION["BACKUP_FLASH"] = "Failed to restore backup.";
    }

    header("Location: lab_config_backups.php?id=$lab_config_id");
    return;
}

