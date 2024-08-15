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

$current_user_id = $_SESSION["user_id"];
$current_user = get_user_by_id($current_user_id);
$lab_config_id = $_REQUEST["id"];

DbUtil::switchToGlobal();

$lab_db_name_query = "SELECT lab_config_id, name, db_name FROM lab_config WHERE lab_config_id = '$lab_config_id';";
$lab = query_associative_one($lab_db_name_query);
db_change($lab["db_name"]);

$lab_config_name = $lab["name"];

$super_admin_or_country_dir = is_super_admin($current_user) || is_country_dir($current_user);

$unauthorized = true;

if ($super_admin_or_country_dir) {
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
    header("HTTP/1.1 401 Unauthorized", true, 401);
    header("Location: /home.php");
    exit;
}

require_once(__DIR__."/../../includes/header.php");
LangUtil::setPageId("lab_config_home");

require_once(__DIR__."/../../includes/keymgmt.php");

// TODO: switch this to its own table, maybe...
$settings_encryption_enabled = KeyMgmt::read_enc_setting() != "0";

?>

<?php
$selected_tab = "upload";
require_once(__DIR__."/lab_config_backup_header.php");
?>

<?php

if ($_GET["action"] != "confirm") {

?>

<div id="upload-form" class="section">
    <h3 class="section-head">Upload Backup</h3>

    <form id="upload_backup_form" name="upload_backup_form" action="lab_config_backup_upload.php?id=<?php echo($lab_config_id); ?>&action=confirm" method="post" enctype="multipart/form-data">
        <input type="file" id="backup_file" name="backup_file">
        <input type="submit" id="import" value="Upload">
    </form>
</div>

<?php

} else {

$filename = $_FILES["backup_file"]["name"];
$tmp_path = $_FILES["backup_file"]["tmp_name"];

$analyzed_backup = new AnalyzedBackup($filename, $tmp_path);

$backup_already_exists =

mkdir("/tmp/blis", 0700);
$perm_tmp_path = "/tmp/blis/" . basename($tmp_path);

if (!move_uploaded_file($tmp_path, $perm_tmp_path)) {
    $_SESSION["BACKUP_FLASH"] = "Failed to upload $filename.";
    header("Location: lab_config_backup_upload.php?id=$lab_config_id");
    return;
}

?>

<style>
#confirm-upload-lab-data table {
    margin: 1rem;
}

#confirm-upload-lab-data table tr td:first-of-type {
    text-align: right;
}

#confirm-upload-lab-data table td {
    padding: 0.5rem;
}

#confirm_upload_backup_form input[type="submit"] {
    margin-left: 10rem;
}
</style>

<div id="confirm-upload-form" class="section">
    <h3 class="section-head">Upload Backup</h3>

    <div id="confirm-upload-lab-data">
        <table>
            <tr>
                <td class="text-bold">Lab name</td>
                <td>TODO</td>
            </tr>
            <tr>
                <td class="text-bold">BLIS Version</td>
                <td><?php echo($analyzed_backup->version); ?></td>
            </tr>
            <tr>
                <td class="text-bold">Encrypted?</td>
                <td class="text-monospace"><?php echo($analyzed_backup->encrypted ? "Yes" : "No"); ?></td>
            </tr>
            <tr>
                <td class="text-bold">Source database</td>
                <td class="text-monospace"><?php echo($analyzed_backup->database_name); ?></td>
            </tr>
            <tr>
                <td class="text-bold">Target database</td>
                <td class="text-monospace"><?php echo($lab["db_name"]); ?></td>
            </tr>
        </table>
    </div>

    <form id="confirm_upload_backup_form" name="confirm_upload_backup_form" action="upload_backup.php?id=<?php echo($lab_config_id); ?>" method="post">
        <input type="hidden" id="confirmed_backup_filename" name="confirmed_backup_filename" value="<?php echo($filename);?>">
        <input type="hidden" id="confirmed_backup_tmp_path" name="confirmed_backup_tmp_path" value="<?php echo($perm_tmp_path);?>">
        <input type="submit" id="import" value="Confirm Upload">
    </form>

    <p>
        Your data will not be affected. You can restore the data in this backup in the "Lab Backups" screen.
    </p>

</div>

<?php

}

require_once(__DIR__."/../../includes/footer.php");
