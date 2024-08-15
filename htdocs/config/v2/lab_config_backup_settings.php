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
    header('HTTP/1.1 401 Unauthorized', true, 401);
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
$selected_tab = "settings";
require_once(__DIR__."/lab_config_backup_header.php");
?>

<div id="key-management">
    <h3 class="section-head">Key Management</h3>

    <?php
        if ($super_admin_or_country_dir) {
    ?>
    <p>
        <b>BLIS Cloud Administrator Key</b>:
        <a href="../../ajax/download_key.php?role=dir">Download Public Key</a>
    </p>
    <?php
        }
    ?>
    <p>
        <b><?php echo($lab["name"]); ?></b>:
        <a href="../../ajax/download_key.php?id=<?php echo($lab_config_id) ?>"><?php echo LangUtil::$pageTerms['download_key']; ?></a>
    </p>
</div>

<div id="settings">
    <h3 class="section-head">Settings</h3>
    <form id="settings_form" action="update_backup_settings.php?id=<?php echo($lab_config_id); ?>" method="POST">
        <div class="form-element">
            <input type="checkbox" id="settings_encryption_enabled" name="settings_encryption_enabled" <?php echo($settings_encryption_enabled ? "checked" : ""); ?>>
            <label for="settings_encryption_enabled">Enable Encrypted Backups</label>
        </div>

        <div class="form-element">
            <input type="submit" value="Update">
        </div>
    </form>
</div>


<?php require_once(__DIR__."/../../includes/footer.php"); ?>
